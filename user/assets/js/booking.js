(function() {
	const notyf = new Notyf({ duration: 3000, position: { x: 'center', y: 'top' } });

	function attachPayHereCallbacks(currentOrderId) {
		if (typeof window.payhere === 'undefined') {
			console.warn('[payhere] SDK not found, cannot attach callbacks');
			return;
		}

		// Resolve markPaid URL relative to the current page to avoid context/path issues
		const markPaidUrl = new URL('assets/process/markPaid.php', window.location.href).href;

		console.log('[payhere] attaching callbacks for order:', currentOrderId, 'markPaidUrl:', markPaidUrl);
		payhere.onCompleted = async function onCompleted(orderId) {
			console.log('[payhere] onCompleted:', orderId);
			try {
				const effectiveOrderId = orderId || currentOrderId;
				const form = new FormData();
				form.append('order_id', effectiveOrderId);

				// Try to include optional payment fields if PayHere passes them (safe no-op if not present)
				// (Some SDKs may provide payment_id / method in other callbacks; add if you have them)
				const res = await fetch(markPaidUrl, { method: 'POST', body: form, credentials: 'same-origin' });
				let json = {};
				try { json = await res.json(); } catch (e) { console.warn('[payhere] markPaid parse warn:', e); }
				console.log('[payhere] markPaid response:', res.status, json);

				if (!res.ok || !json.success) {
					console.error('[payhere] markPaid failed', res.status, json);
					// Continue to redirect to invoice anyway, but leave a console message for debugging.
				}
			} catch (e) {
				console.error('[payhere] markPaid error:', e);
			}
			// Always redirect to invoice after completion (use the effective id)
			const dest = 'invoice.php?order_id=' + encodeURIComponent(orderId || currentOrderId);
			console.log('[payhere] redirecting to:', dest);
			window.location.href = dest;
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

	document.getElementById('goToCheckout').addEventListener('click', function() {
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
		const phoneRaw = document.querySelector('#number3');
		const phoneValue = phoneRaw.value.trim();
		if (!/^\d+$/.test(phoneValue)) {
			notyf.error('Phone number must contain only numbers.');
			return;
		}
		const phoneNumber = phoneValue;

		// 7. Pickup Location validation
		const pickup = document.getElementById('pickup').value.trim();
		if (!pickup) {
			notyf.error('Please enter your pickup location.');
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


