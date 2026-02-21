document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector(".contact-form");
    const notyf = new Notyf({
        position: { x: 'center', y: 'top' }
    });

    // intl-tel-input instance
    const input = document.querySelector("#number3");
    const iti = window.intlTelInput(input, {
        initialCountry: "lk",
        separateDialCode: true,
        utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@18.5.1/build/js/utils.js"
    });

    form.addEventListener("submit", function (e) {
        e.preventDefault();

        const submitBtn = document.getElementById("submitBtn");
        const spinner = document.getElementById("spinner");
        const btnIcon = document.getElementById("btnIcon");

        // Get values
        const name = document.getElementById("name3").value.trim();
        const email = document.getElementById("email3").value.trim();
        const mobile = iti.getNumber(); // Get full international number
        const message = document.getElementById("message").value.trim();

        // Validation
        if (!name || !email || !mobile || !message) {
            notyf.error("All fields are required!");
            return;
        }
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailPattern.test(email)) {
            notyf.error("Invalid email address!");
            return;
        }
        // Mobile validation (intl-tel-input)
        if (!iti.isValidNumber()) {
            notyf.error("Invalid mobile number!");
            return;
        }

        // Show spinner, hide icon, disable button
        submitBtn.disabled = true;
        spinner.style.display = "inline-block";
        btnIcon.style.display = "none";

        // AJAX
        fetch("assets/process/sendMessageProcess.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({
                name: name,
                email: email,
                mobile: mobile,
                message: message
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                notyf.success("Message sent successfully!");
                form.reset();
                iti.setNumber(""); // clear phone field
            } else {
                notyf.error(data.error || "Failed to send message!");
            }
        })
        .catch(() => {
            notyf.error("Server error!");
        })
        .finally(() => {
            // Hide spinner, show icon, enable button
            submitBtn.disabled = false;
            spinner.style.display = "none";
            btnIcon.style.display = "inline-block";
        });
    });
});