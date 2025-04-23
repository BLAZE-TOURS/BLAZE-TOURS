function adminSignIn(event) {
    event.preventDefault();  // Prevent the default form submission

    var email = document.getElementById("email");
    var password = document.getElementById("password");
    var rememberme = document.getElementById("rememberme");

    // Clear previous error styles and messages
    email.classList.remove("input-error");
    password.classList.remove("input-error");
    document.getElementById("email-error").innerText = "";
    document.getElementById("password-error").innerText = "";

    var f = new FormData();
    f.append("e", email.value);
    f.append("p", password.value);
    f.append("r", rememberme.checked); // Correct the rememberme value to .checked instead of .value

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState === 4) {
            var t = r.responseText;
            var response = JSON.parse(t);  // Parse JSON response from the PHP backend
            if (response.status === "success") {
                Swal.fire({
                    icon: 'success',
                    title: 'Signed in successfully',
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    window.location = "../admin/adminindex.php";  // Redirect on success
                });
            } else {
                // Display small alerts near the input fields
                if (response.message.includes("Email")) {
                    email.classList.add("input-error");
                    document.getElementById("email-error").innerText = response.message;
                }
                if (response.message.includes("Password")) {
                    password.classList.add("input-error");
                    document.getElementById("password-error").innerText = response.message;
                }
            }
        }
    };

    r.open("POST", "../process/adminSignInProcess.php", true);
    r.send(f);
}