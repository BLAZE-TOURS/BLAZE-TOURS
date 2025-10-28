(function () {
    const notyf = new Notyf({ duration: 3000, position: { x: 'center', y: 'top' } });

    // Listen for cross-window messages (popup -> parent) and redirect parent when needed
    window.addEventListener('message', function (evt) {
        try {
            if (!evt || !evt.data) return;
            const d = evt.data;
            if (d && d.type === 'payherePaymentCompleted' && d.dest) {
                console.log('[payhere] message received, redirecting parent to:', d.dest);
                window.location.href = d.dest;
            }
        } catch (e) {
            console.warn('[payhere] message handler error', e);
        }
    }, false);

    function attachPayHereCallbacks(currentOrderId) {
        if (typeof window.payhere === 'undefined') {
            console.warn('[payhere] SDK not found, cannot attach callbacks');
            return;
        }

        console.log('[payhere] attaching callbacks for order:', currentOrderId);
        payhere.onCompleted = async function onCompleted(orderId) {
            console.log('[payhere] onCompleted:', orderId);
            try {
                const effectiveOrderId = orderId || currentOrderId;

                // --- NON-BLOCKING server notify: use sendBeacon when possible, fallback to fetch keepalive ---
                try {
                    const markPaidUrl = new URL('assets/process/markPaid.php', window.location.href).href;
                    const params = new URLSearchParams();
                    params.append('order_id', effectiveOrderId);

                    if (navigator.sendBeacon) {
                        // sendBeacon is best for quick background POSTs (especially when window might close)
                        navigator.sendBeacon(markPaidUrl, params);
                        console.log('[payhere] markPaid sent via sendBeacon');
                    } else {
                        // fallback: non-blocking fetch with keepalive
                        fetch(markPaidUrl, {
                            method: 'POST',
                            body: params,
                            keepalive: true,
                            credentials: 'same-origin'
                        }).catch(e => console.warn('[payhere] markPaid fetch (keepalive) failed', e));
                        console.log('[payhere] markPaid sent via fetch keepalive');
                    }
                } catch (e) {
                    console.warn('[payhere] markPaid fire-and-forget failed', e);
                }

                const effectiveId = orderId || currentOrderId;
                const dest = 'invoice.php?order_id=' + encodeURIComponent(effectiveId);
                console.log('[payhere] immediate redirect to:', dest);

                // 1) If running inside a popup opened by parent, change opener.location and close popup
                try {
                    if (window.opener && !window.opener.closed) {
                        window.opener.location.href = dest;
                        setTimeout(() => { try { window.close(); } catch (e) { } }, 300);
                        return;
                    }
                } catch (e) { console.warn('[payhere] opener redirect failed', e); }

                // 2) If inside an iframe, try parent/top redirect
                try {
                    if (window.parent && window.parent !== window) {
                        window.parent.location.href = dest;
                        return;
                    }
                } catch (e) { console.warn('[payhere] parent redirect failed', e); }

                // 3) Post message to top (useful if callback executes in another window context)
                try {
                    window.top.postMessage({ type: 'payherePaymentCompleted', orderId: effectiveId, dest }, '*');
                } catch (e) { console.warn('[payhere] postMessage failed', e); }

                // 4) Final fallback: navigate current window
                try {
                    window.location.href = dest;
                } catch (e) {
                    console.error('[payhere] final redirect failed', e);
                }
            } catch (e) {
                console.error('[payhere] onCompleted top-level error:', e);
            }
        };

        payhere.onDismissed = function onDismissed() {
            console.warn('[payhere] onDismissed');
            // Optional: redirect to cancel page
            window.location.href = 'payment_cancel.php?order_id=' + encodeURIComponent(currentOrderId);
        };

        payhere.onError = function onError(error) {
            console.error('[payhere] onError:', error);
            // Optional: redirect to cancel page
            window.location.href = 'payment_cancel.php?order_id=' + encodeURIComponent(currentOrderId);
        };
    }

    async function createBooking(bookingData) {
        const btn = document.getElementById('goToCheckout');
        if (btn) {
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Loading...';
        }

        try {
            console.log('[booking] creating with data:', bookingData);
            const formData = new FormData();
            Object.keys(bookingData).forEach(k => formData.append(k, bookingData[k] ?? ''));

            const res = await fetch('assets/process/createBooking.php', {
                method: 'POST',
                body: formData
            });
            console.log('[booking] response status:', res.status);
            let json;
            try {
                json = await res.json();
                console.log('[booking] response json:', json);
            } catch (e) {
                console.error('[booking] json parse error:', e);
                notyf.error('Unexpected server response: ' + e);
                json = { success: false, message: 'Unexpected server response' };
            }
            if (!json.success) {
                console.warn('[booking] backend failed', json);
                if (res.status === 409) {
                    notyf.error(json.message || 'Selected date and time slot are already booked.');
                    return;
                }
                if (res.status === 423) {
                    notyf.error(json.message || 'This date is closed for bookings.');
                    return;
                }
                notyf.error(json.message || 'Failed to create booking');
                return;
            }

            const bookingId = json.booking_id;
            const payment = json.payment;
            console.log('[booking] payment payload:', payment);
            if (!payment) {
                notyf.error('Payment payload missing');
                return;
            }

            // Use configured globals if available
            if (typeof window.payhere !== 'undefined') {
                // Ensure sandbox flag matches site config
                payment.sandbox = !!window.payhereSandbox;
                payment.merchant_id = window.payhereMerchantId || payment.merchant_id;
                payment.return_url = window.payhereReturnUrl || payment.return_url;
                payment.cancel_url = window.payhereCancelUrl || payment.cancel_url;
                payment.notify_url = window.payhereNotifyUrl || payment.notify_url;
                console.log('[booking] starting payhere with:', payment);

                attachPayHereCallbacks(payment.order_id);
                notyf.success('Redirecting to payment...');
                setTimeout(() => {
                    window.payhere.startPayment(payment);
                }, 500);
            } else {
                console.warn('[booking] payhere not available, redirecting to invoice');
                // Fallback: go to invoice (should not happen in production)
                window.location.href = 'invoice.php?order_id=' + encodeURIComponent(bookingId);
            }
        } catch (e) {
            console.error('[booking] createBooking error:', e);
            notyf.error('Failed to create booking');
        } finally {
            if (btn) {
                btn.disabled = false;
                btn.textContent = 'Go to Checkout';
            }
        }
    }

    // Add this to your goToCheckout click handler validation section
    document.getElementById('goToCheckout').addEventListener('click', function () {
        const notyf = new Notyf({ duration: 3000, position: { x: 'center', y: 'top' } });
        const form = document.getElementById('bookingForm');
        console.log('[booking] goToCheckout clicked');

        // 1. Date validation
        const tourDate = document.getElementById('tourDate').value;
        if (!tourDate) {
            notyf.error('Please select a date.');
            return;
        }

        // 2. Adults validation
        const adultCount = document.getElementById('adultCount');
        if (!adultCount.value || parseInt(adultCount.value) < 1) {
            notyf.error('At least one adult is required.');
            return;
        }

        // 3. Time Slot validation
        const timeSlotInput = document.querySelector('input[name="timeSlot"]:checked');
        if (!timeSlotInput) {
            notyf.error('Please select a time slot.');
            return;
        }

        // 4. Full Name validation
        const fullName = document.getElementById('fullName').value.trim();
        if (!fullName) {
            notyf.error('Please enter your full name.');
            return;
        }

        // 5. Email validation
        const email = document.getElementById('email').value.trim();
        if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
            notyf.error('Please enter a valid email address.');
            return;
        }

        // 6. Phone number validation
        // Use intl-tel-input when available to get full E.164 number (includes country code)
        let phoneNumber = '';
        const itiInstance = window.iti;
        if (itiInstance) {
            if (!itiInstance.isValidNumber()) {
                notyf.error('Please enter a valid phone number.');
                return;
            }
            phoneNumber = itiInstance.getNumber(); // e.g. +9471xxxxxxx
        } else {
            const phoneRaw = document.querySelector('#number3');
            phoneNumber = phoneRaw ? phoneRaw.value.trim() : '';
            if (!/^\d+$/.test(phoneNumber)) {
                notyf.error('Phone number must contain only numbers.');
                return;
            }
        }

        // 7. Pickup Location validation
        const pickup = document.getElementById('pickup').value.trim();
        if (!pickup) {
            notyf.error('Please enter your pickup location.');
            return;
        }

        // 8. empty paidAmount 
        const paidInput = document.getElementById('paidAmount').value.trim();
        if (!paidInput) {
            notyf.error('Please enter your paid amount.');
            return;
        }

        // 9.  paidAmount Validation 
        updatePaidDisplays();

        function updatePaidDisplays() {
            const paidInput = document.getElementById('paidAmount');
            const paidUSD = parseFloat(paidInput.value || 0);
            const totalPriceEl = document.getElementById('totalPrice');
            const totalUSD = parseFloat((totalPriceEl ? totalPriceEl.textContent : '0').replace('$', '')) || 0;
            const minAdvance = totalUSD * (advancePercentage / 100);
            // expose balance to outer scope so bookingData can use it
            window.balanceUSD = totalUSD - paidUSD;
            balanceUSD = window.balanceUSD;


            // Validate paid amount: must be at least the minimum advance and not exceed the total
            if (paidUSD < minAdvance || paidUSD > totalUSD) {
                notyf.error('Please enter a valid paid amount.');
                return;
            }
            return;
        }



        const bookingData = {
            tourId: window.tour_id || 0,
            tourName: window.tour_name || '',
            adults: parseInt(adultCount.value),
            children: parseInt(document.getElementById('childCount').value),
            adultPrice: window.adultPricePerPerson || 0,
            childPrice: window.childPricePerPerson || 0,
            totalPriceUSD: parseFloat(document.getElementById('totalPrice').textContent.replace('$', '')),
            totalPriceLKR: window.usdToLkrRate > 0 ? parseFloat(document.getElementById('totalPrice').textContent.replace('$', '')) * window.usdToLkrRate : 0,
            paidAmountUSD: parseFloat(document.getElementById('paidAmount').value),
            balanceAmountUSD: balanceUSD.toFixed(2),
            date: tourDate,
            timeSlot: timeSlotInput.value,
            fullName: fullName,
            email: email,
            pickup: pickup,
            phone: phoneNumber
        };

        console.log('[booking] prepared bookingData:', bookingData);
        window.createBooking && window.createBooking(bookingData);
    });

    window.createBooking = createBooking;
})();


