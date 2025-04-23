function SendEmailForAll() {
    var subject = document.getElementById('subjectAll');
    var message = document.getElementById('messageAll');
    var validationErrors = document.getElementById('validation-errors');
    var successMessage = document.getElementById('success-message');
    var loadingSpinner = document.getElementById('loading-spinner');

    var f = new FormData();
    f.append("subject", subject.value);
    f.append("message", message.value);

    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            loadingSpinner.classList.add('d-none'); // Hide the spinner
            if (r.status == 200) {
                if (t.includes("Emails sent successfully")) {
                    successMessage.innerHTML = t;
                    successMessage.classList.remove('d-none');
                    validationErrors.classList.add('d-none');
                    document.getElementById('subjectAll').value = '';
                    document.getElementById('messageAll').value = '';
                } else {
                    validationErrors.innerHTML = t;
                    validationErrors.classList.remove('d-none');
                    successMessage.classList.add('d-none');
                }
            } else {
                validationErrors.innerHTML = t;
                validationErrors.classList.remove('d-none');
                successMessage.classList.add('d-none');
            }
        }
    };

    loadingSpinner.classList.remove('d-none'); // Show the spinner
    r.open("POST", "../process/sendMailAllProcess.php", true);
    r.send(f);
}


function SendEmail() {
    var email = document.getElementById('email1');
    var ccEmail = document.getElementById('cc-email');
    var bccEmail = document.getElementById('bcc-email');
    var subject = document.getElementById('subject');
    var bodyTitle = document.getElementById('body-title');
    var message = document.getElementById('message');

    var validationErrors = document.getElementById('validation-errors1');
    var successMessage = document.getElementById('success-message1');
    var loadingSpinner = document.getElementById('loading-spinner1');

    var f = new FormData();
    f.append("email", email.value);
    f.append("cc-email", ccEmail.value);
    f.append("bcc-email", bccEmail.value);
    f.append("subject", subject.value);
    f.append("body-title", bodyTitle.value);
    f.append("message", message.value);

    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            loadingSpinner.classList.add('d-none'); // Hide the spinner
            if (r.status == 200) {
                if (t.includes("Email sent successfully")) {
                    successMessage.innerHTML = t;
                    successMessage.classList.remove('d-none');
                    validationErrors.classList.add('d-none');
                    document.getElementById('email1').value = '';
                    document.getElementById('cc-email').value = '';
                    document.getElementById('bcc-email').value = '';
                    document.getElementById('subject').value = '';
                    document.getElementById('body-title').value = '';
                    document.getElementById('message').value = '';
                } else {
                    validationErrors.innerHTML = t;
                    validationErrors.classList.remove('d-none');
                    successMessage.classList.add('d-none');
                }
            } else {
                validationErrors.innerHTML = t;
                validationErrors.classList.remove('d-none');
                successMessage.classList.add('d-none');
            }
        }
    };

    loadingSpinner.classList.remove('d-none'); // Show the spinner
    r.open("POST", "../process/sendEmailProcess.php", true);
    r.send(f);
}