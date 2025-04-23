document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('contact-form');
    const submitButton = form.querySelector('button[type="submit"]');
    const spinner = submitButton.querySelector('.spinner-border');

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Disable button and show spinner
        submitButton.disabled = true;
        spinner.classList.remove('d-none');

        // Get form data
        const formData = new FormData(form);

        // Send AJAX request
        fetch('contact-process.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                showNotification('success', data.message);
                form.reset();
            } else {
                showNotification('error', data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('error', 'An error occurred. Please try again.');
        })
        .finally(() => {
            submitButton.disabled = false;
            spinner.classList.add('d-none');
        });
    });

    function showNotification(type, message) {
        const notyf = new Notyf({
            position: { x: 'center', y: 'top' },
            duration: 3000
        });
        
        if (type === 'success') {
            notyf.success(message);
        } else {
            notyf.error(message);
        }
    }
});