<!DOCTYPE html>
<html lang="en">

<head>
    <title>Admin Login | BLAZE TOURS (PVT) LTD</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="../SignIn/images/Untit1.png" />
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../SignIn/vendor/bootstrap/css/bootstrap.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../SignIn/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../SignIn/vendor/animate/animate.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../SignIn/vendor/css-hamburgers/hamburgers.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../SignIn/vendor/select2/select2.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../SignIn/css/util.css">
    <link rel="stylesheet" type="text/css" href="../SignIn/css/main.css">
    <link rel="stylesheet" type="text/css" href="../loader/loader.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!--===============================================================================================-->
    <style>
        .input-error {
            border: 2px solid red;
        }

        .msg-error {
            color: red;
            font-size: 12px;
            margin-top: 5px;
            display: block;
        }
    </style>
</head>

<body>

    <!-- Loader -->
    <div class="loader">
        <div class="animation"></div>
    </div>

    <!-- End of Loader -->

    
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <div class="login100-pic js-tilt" data-tilt>
                    <img src="../SignIn/images/Untit1.png" alt="IMG">
                </div>

                <form class="login100-form validate-form" onsubmit="adminSignIn(event)">
                    <span class="login100-form-title">
                        Admin Login
                    </span>

                    <div class="wrap-input100 validate-input" data-validate="Valid email is required: ex@abc.xyz">
                        <input class="input100" type="text" name="email" id="email" placeholder="Email">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-envelope" aria-hidden="true"></i>
                        </span>
                        <span id="email-error" class="msg-error"></span>
                    </div>

                    <div class="wrap-input100 validate-input" data-validate="Password is required">
                        <input class="input100" type="password" id="password" name="pass" placeholder="Password">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-lock" aria-hidden="true"></i>
                        </span>
                        <span id="password-error" class="msg-error"></span>
                    </div>

                    <div class="form-group">
                        <label>
                            <input type="checkbox" id="rememberme" name="remember"> Remember Me
                        </label>
                    </div>

                    <div class="container-login100-form-btn">
                        <button class="login100-form-btn" type="submit">
                            Login
                        </button>
                    </div>

                    </br></br>
                </form>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="text-center mt-4 fixed-bottom">
        <p class="text-light">&copy; 2025 BLAZE TOURS (PVT) LTD | All Rights Reserved</p>
        <p class="text-light">Developed by Tecxone</p>
    </footer>

    <!--===============================================================================================-->
    <script src="../SignIn/vendor/jquery/jquery-3.2.1.min.js"></script>
    <!--===============================================================================================-->
    <script src="../SignIn/vendor/bootstrap/js/popper.js"></script>
    <script src="../SignIn/vendor/bootstrap/js/bootstrap.min.js"></script>
    <!--===============================================================================================-->
    <script src="../SignIn/vendor/select2/select2.min.js"></script>
    <!--===============================================================================================-->
    <script src="../SignIn/vendor/tilt/tilt.jquery.min.js"></script>

    <!--===============================================================================================-->
    <script src="../SignIn/js/main.js"></script>

    <script src="../assets/js/adminSignIn.js"></script>

    <script src="../assets/js/loader.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>