document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('paymentForm');
    const currencySelect = document.getElementById('currency');
    const amountInput = document.getElementById('amount');
    const finalInput = document.getElementById('finalAmount');

    const notyfAvailable = typeof Notyf !== 'undefined';
    const notyf = notyfAvailable ? new Notyf({ duration: 3000, position: { x: 'center', y: 'top' } }) : null;

    function notifySuccess(msg) {
        if (notyf) notyf.success(msg); else alert(msg);
    }
    function notifyError(msg) {
        if (notyf) notyf.error(msg); else alert(msg);
    }

    // ---- Calculate LKR amount dynamically ----
    function parseRate(option) {
        if (!option) return 0;
        const r = parseFloat(option.getAttribute('data-rate'));
        return isFinite(r) ? r : 0;
    }

    function updateFinalAmount() {
        const opt = currencySelect.options[currencySelect.selectedIndex];
        const rate = parseRate(opt);
        const amt = parseFloat(amountInput.value) || 0;
        const final = amt * rate;
        finalInput.value = 'LKR ' + (final ? final.toFixed(2) : '0.00');
    }

    if (currencySelect) currencySelect.addEventListener('change', updateFinalAmount);
    if (amountInput) amountInput.addEventListener('input', updateFinalAmount);
    updateFinalAmount();

    // ---- Form submission ----
    form.addEventListener('submit', function (e) {
        e.preventDefault();

        const email = (document.getElementById('email').value || '').trim();
        const description = (document.getElementById('description').value || '').trim();
        const amount = parseFloat(amountInput.value || 0);
        const currency_id = parseInt(currencySelect.value || 0, 10);

        // validation
        if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
            notifyError('Please enter a valid email.');
            return;
        }
        if (!description) {
            notifyError('Please enter a description.');
            return;
        }
        if (!currency_id || amount <= 0) {
            notifyError('Please select a currency and enter an amount greater than zero.');
            return;
        }

        const fd = new FormData(form);
        const submitBtn = form.querySelector('button[type="submit"]');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Processing...';

        fetch('paynow/addPaynowProcess.php', {
            method: 'POST',
            body: fd
        })
        .then(async res => {
            const text = await res.text();
            try {
                return JSON.parse(text);
            } catch {
                console.error('Server returned non-JSON:', text);
                throw new Error('Invalid JSON response');
            }
        })
        .then(data => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fas fa-credit-card me-2"></i>Pay Now';

            if (data && data.success) {
                notifySuccess(data.message || 'Payment saved successfully!');

                // Initiate PayHere Payment (Replace placeholders with your actual config)
                if (typeof payhere !== 'undefined') {
                    payhere.startPayment({
                        sandbox: true,  // Set to false for production
                        merchant_id: "1232435",  // Replace with your PayHere Merchant ID
                        return_url: "http://localhost/BLAZE-TOURS/user/paynow.php?status=success",  // Success redirect
                        cancel_url: "http://localhost/BLAZE-TOURS/user/paynow.php?status=cancel",  // Cancel redirect
                        notify_url: "http://localhost/BLAZE-TOURS/user/paynow/notify.php",  // Server notification (create this file for IPN)
                        order_id: data.id,
                        items: description,
                        currency: "LKR",
                        amount: data.lkr.toFixed(2),
                        first_name: email.split('@')[0],  // Extract first name from email or add input field
                        last_name: "",
                        email: email,
                        phone: "",  // Add phone input if needed
                        address: "",
                        city: "Colombo",
                        country: "Sri Lanka"
                    });
                } else {
                    notifyError('PayHere SDK not loaded. Payment cannot be initiated.');
                }

                form.reset();
                updateFinalAmount();
                console.log('✅ Payment created:', data);
            } else {
                notifyError(data?.message || 'Failed to save payment.');
                console.warn('⚠️ Payment failed:', data);
            }
        })
        .catch(err => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fas fa-credit-card me-2"></i>Pay Now';
            notifyError('Server error. Please try again later.');
            console.error('❌ Fetch error:', err);
        });
    });
});