document.addEventListener('DOMContentLoaded', function () {
    var submitButton = document.querySelector('.request-quote button');

    if (submitButton && !submitButton.dataset.listenerAdded) {
        submitButton.addEventListener('click', subscribe);
        submitButton.dataset.listenerAdded = true;
    }

    // Declare iti in the global scope
    window.iti = null;

    // Initialize intl-tel-input
    var input = document.querySelector("#Mobile");
    window.iti = window.intlTelInput(input, {
        initialCountry: "lk", // Set default country to Sri Lanka
        geoIpLookup: function (callback) {
            fetch('https://ipinfo.io/json')
                .then(response => response.json())
                .then(data => callback(data.country))
                .catch(() => callback('us'));
        },
        utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"
    });

    // Set initial value to the default country's dial code
    input.value = `+${window.iti.getSelectedCountryData().dialCode}`;

    // Add event listener for country change
    input.addEventListener('countrychange', function() {
        var countryCode = window.iti.getSelectedCountryData().dialCode;
        input.value = `+${countryCode}`;
    });
});

function subscribe(event) {
    event.preventDefault();

    var submitButton = event.target;
    var spinner = submitButton.querySelector('.spinner-border');
    submitButton.disabled = true; // Disable button to prevent multiple clicks
    spinner.classList.remove('d-none'); // Show spinner

    // Get form values
    var firstName = document.getElementById('First-Name').value.trim();
    var lastName = document.getElementById('Last-Name').value.trim();
    var email = document.getElementById('Email').value.trim();
    var mobileInput = document.getElementById('Mobile');
    var mobile = window.iti.getNumber(); // Get the full international number
    var review = document.querySelector('textarea[name="Reviews"]').value.trim();
    var ratingStar = document.querySelector('input[name="rating"]:checked') 
        ? document.querySelector('input[name="rating"]:checked').id.replace('rate', '') 
        : '';

    // Validate fields before sending request
    if (!firstName || !lastName || !email || !mobile || !review || !ratingStar) {
        showNotification('error', 'Please fill in all fields before submitting.');
        submitButton.disabled = false;
        spinner.classList.add('d-none'); // Hide spinner
        return;
    }

    if (!validateEmail(email)) {
        showNotification('error', 'Please enter a valid email address.');
        submitButton.disabled = false;
        spinner.classList.add('d-none'); // Hide spinner
        return;
    }

    if (!window.iti.isValidNumber()) {
        showNotification('error', 'Please enter a valid mobile number.');
        submitButton.disabled = false;
        spinner.classList.add('d-none'); // Hide spinner
        return;
    }

    // Prepare form data
    var formData = new FormData();
    formData.append('first_name', firstName);
    formData.append('last_name', lastName);
    formData.append('email', email);
    formData.append('mobile', mobile);
    formData.append('review', review);
    formData.append('rating_star', ratingStar);

    // Create XMLHttpRequest
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "assets/process/subscriberProcess.php", true);

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            try {
                var response = JSON.parse(xhr.responseText); // Parse JSON response
                console.log("Response:", response); // Debugging

                if (xhr.status === 200 && response.status === "success") {
                    showNotification('success', response.message);
                    clearForm(); // Clear the form on success
                } else {
                    showNotification('error', response.message || 'Something went wrong!');
                }
            } catch (error) {
                console.error("Invalid JSON response:", xhr.responseText);
                showNotification('error', 'Server returned an invalid response.');
            }
            submitButton.disabled = false; // Re-enable the submit button
            spinner.classList.add('d-none'); // Hide spinner
        } else if (xhr.status === 500) {
            console.error("Server error:", xhr.responseText);
            showNotification('error', 'A server error occurred. Please try again later.');
            submitButton.disabled = false;
            spinner.classList.add('d-none'); // Hide spinner
        }
    };

    xhr.send(formData);
}

// Function to show notifications
function showNotification(type, message) {
    var notyf = new Notyf({
        position: { x: 'center', y: 'top' }
    });

    if (type === 'success') {
        notyf.success(message);
    } else {
        notyf.error(message);
    }
}

// Function to clear form fields
function clearForm() {
    document.getElementById('First-Name').value = '';
    document.getElementById('Last-Name').value = '';
    document.getElementById('Email').value = '';
    document.getElementById('Mobile').value = '';
    document.querySelector('textarea[name="Reviews"]').value = '';
    document.querySelectorAll('input[name="rating"]').forEach(input => input.checked = false);
}

// Function to validate email format
function validateEmail(email) {
    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}
