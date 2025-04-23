document.addEventListener('DOMContentLoaded', function () {
    var subscribeButton = document.getElementById('subscribe-button');
    var emailInput = document.getElementById('Footer-Subscriber-email');

    if (subscribeButton && emailInput) {
        subscribeButton.addEventListener('click', function (event) {
            event.preventDefault(); // Prevent default button behavior

            var spinner = subscribeButton.querySelector('.spinner-border');
            subscribeButton.disabled = true; // Disable button to prevent multiple clicks
            spinner.classList.remove('d-none'); // Show spinner

            var email = emailInput.value.trim();

            // Validate email
            if (!validateEmail(email)) {
                showNotification('error', 'Please enter a valid email address.');
                subscribeButton.disabled = false;
                spinner.classList.add('d-none'); // Hide spinner
                return;
            }

            // Prepare form data
            var formData = new FormData();
            formData.append('email', email);

            // Create XMLHttpRequest
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "assets/process/FooterSubscriberProcess.php", true);

            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4) {
                    try {
                        var response = JSON.parse(xhr.responseText); // Parse JSON response
                        console.log("Response:", response); // Debugging

                        if (xhr.status === 200 && response.status === "success") {
                            showNotification('success', response.message);
                            emailInput.value = ''; // Clear the email input on success
                        } else {
                            showNotification('error', response.message || 'Something went wrong!');
                        }
                    } catch (error) {
                        console.error("Invalid JSON response:", xhr.responseText);
                        showNotification('error', 'Server returned an invalid response.');
                    }
                    subscribeButton.disabled = false; // Re-enable the button
                    spinner.classList.add('d-none'); // Hide spinner
                } else if (xhr.status === 500) {
                    console.error("Server error:", xhr.responseText);
                    showNotification('error', 'A server error occurred. Please try again later.');
                    subscribeButton.disabled = false;
                    spinner.classList.add('d-none'); // Hide spinner
                }
            };

            xhr.send(formData);
        });
    }
});

// Function to validate email format
function validateEmail(email) {
    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
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