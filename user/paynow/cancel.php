<?php
// cancel.php
require_once '../assets/process/connection.php';

// Order ID එක ලබා ගැනීම (PayHere එවන්නේ order_id එක විතරයි cancel වුනාම)
$order_id = isset($_GET['order_id']) ? $_GET['order_id'] : '';

?>

<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Pyament Cancel | Blaze Tours (Pvt) Ltd - Colombo & Sri Lanka Tour Photos</title>

    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Favicons - Place favicon.ico in the root directory -->
    <link rel="icon" type="image/png" href="../assets/img/logo.png">

    <!--==============================
	  Google Fonts
	============================== -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Manrope:wght@200..800&family=Montez&display=swap" rel="stylesheet">

    <!--==============================
	    All CSS File
	============================== -->
    <!-- Bootstrap -->
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <!-- Fontawesome Icon -->
    <link rel="stylesheet" href="../assets/css/fontawesome.min.css">
    <!-- Magnific Popup -->
    <link rel="stylesheet" href="../assets/css/magnific-popup.min.css">

    <!-- Swiper css -->
    <link rel="stylesheet" href="../assets/css/swiper-bundle.min.css">

    <!-- Theme Custom CSS -->
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>

</head>

<body>
    <div class="overflow-hidden space" id="payment-cancel">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8 col-sm-10">
                    <div class="card shadow-lg border-0 rounded-3 p-5 text-center">

                        <!-- Cancel Icon -->
                        <div class="mb-4">
                            <i class="fas fa-times-circle text-danger" style="font-size: 80px;"></i>
                        </div>

                        <!-- Title -->
                        <h2 class="sec-title mb-2">Payment Cancelled</h2>
                        <span class="sub-title mb-3 d-block">No payment was processed</span>

                        <!-- Message -->
                        <p class="mb-3">
                            Your payment was cancelled before completion.
                            No charges have been made to your account.
                        </p>

                        <small class="text-muted d-block mb-4">
                            If this was a mistake, you can safely retry the payment.
                        </small>

                        <a href="index.php" class="th-btn style3">
                            <i class="fas fa-arrow-left me-2"></i>
                            Back to Paynow
                        </a>

                    </div>
                </div>
            </div>
        </div>
    </div>


    <!--==============================
    All Js File
============================== -->
    <!-- Jquery -->
    <!-- Jquery -->
    <script src="../assets/js/vendor/jquery-3.6.0.min.js"></script>
    <!-- Swiper Js -->
    <script src="../assets/js/swiper-bundle.min.js"></script>
    <!-- Bootstrap -->
    <script src="../assets/js/bootstrap.min.js"></script>
    <!-- Magnific Popup -->
    <script src="../assets/js/jquery.magnific-popup.min.js"></script>
    <!-- Counter Up -->
    <script src="../assets/js/jquery.counterup.min.js"></script>
    <!-- Range Slider -->
    <script src="../assets/js/jquery-ui.min.js"></script>
    <!-- imagesloaded -->
    <script src="../assets/js/imagesloaded.pkgd.min.js"></script>
    <!-- isotope -->
    <script src="../assets/js/isotope.pkgd.min.js"></script>
    <!-- gsap -->
    <script src="../assets/js/gsap.min.js"></script>

    <!-- circle-progress -->
    <script src="../assets/js/circle-progress.js"></script>

    <script src="../assets/js/matter.min.js"></script>
    <script src="../assets/js/matterjs-custom.js"></script>


    <!-- nice select -->
    <script src="../assets/js/nice-select.min.js"></script>

    <!-- Main Js File -->
    <script src="../assets/js/main.js"></script>
</body>

</html>