<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Paynow | Blaze Tours (Pvt) Ltd - Colombo & Sri Lanka Tour Photos</title>
    <meta name="author" content="Blaze Tours (Pvt) Ltd">
    <meta name="description" content="Explore stunning photos of Colombo and Sri Lanka tours with Blaze Tours (Pvt) Ltd. See breathtaking landscapes, cultural sites, and memorable travel experiences captured from our adventures.">
    <meta name="keywords" content="Blaze Tours gallery, Colombo tours photos, Sri Lanka travel pictures, travel memories, scenic destinations Sri Lanka, cultural sites Colombo">
    <meta name="robots" content="INDEX,FOLLOW">


    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Favicons - Place favicon.ico in the root directory -->
    <link rel="icon" type="image/png" href="assets/img/logo.png">

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
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <!-- Fontawesome Icon -->
    <link rel="stylesheet" href="assets/css/fontawesome.min.css">
    <!-- Magnific Popup -->
    <link rel="stylesheet" href="assets/css/magnific-popup.min.css">

    <!-- Swiper css -->
    <link rel="stylesheet" href="assets/css/swiper-bundle.min.css">

    <!-- Theme Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">

    <!-- Elfsight WhatsApp Chat | Untitled WhatsApp Chat -->
    <script src="https://static.elfsight.com/platform/platform.js" async></script>
    <div class="elfsight-app-105fdd11-2a94-4811-b9aa-24f273aafc7e" data-elfsight-app-lazy></div>

</head>

<body>


    <!--==============================
     Preloader
  ==============================-->

    <!-- <div id="preloader" class="preloader">
        <div class="preloader-inner">
        
            <img src="assets/img/logo.svg" alt="Logo">
            
        
            <div class="txt-loading">
                <span preloader-text="W" class="characters">W</span>
                <span preloader-text="A" class="characters">A</span>
                <span preloader-text="I" class="characters">I</span>
                <span preloader-text="T" class="characters">T</span>
                <span preloader-text="." class="characters">.</span>
                <span preloader-text="." class="characters">.</span>
            </div>
        </div>
    </div>  -->

    <div class="popup-search-box">
        <button class="searchClose"><i class="fal fa-times"></i></button>
        <form action="#">
            <input type="text" placeholder="What are you looking for?">
            <button type="submit"><i class="fal fa-search"></i></button>
        </form>
    </div><!--==============================
   Header Area
  ============================== -->
    <?php include 'header.php'; ?>

    <!--==============================
    Breadcumb
============================== -->
    <!--==============================
Gallery Area  
==============================-->
    <div class="overflow-hidden space" id="payment-sec">
        <div class="container">
            <div class="title-area mb-30 text-center">
                <span class="sub-title">Secure Payment</span>
                <h2 class="sec-title">Complete Your Payment</h2>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8 col-sm-10">
                    <div class="card shadow-lg border-0 rounded-3 p-4">
                        <form id="paymentForm" method="POST" action="processPayment.php">
                            <div class="mb-3">
                                <label for="fullName" class="form-label">Full Name</label>
                                <input type="text" name="fullName" id="fullName" class="form-control" placeholder="Enter your full name" required>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea name="description" id="description" class="form-control" placeholder="Enter description" rows="3" required></textarea>
                            </div>

                            <div class="mb-4">
                                <label for="currency" class="form-label">Currency</label>
                                <select name="currency" id="currency" class="form-select" required>
                                    <option value="" disabled selected>Select your currency</option>
                                    <option value="LKR">🇱🇰 LKR - Sri Lankan Rupee</option>
                                    <option value="USD">💵 USD - US Dollar</option>
                                    <option value="EUR">💶 EUR - Euro</option>
                                    <option value="GBP">💷 GBP - British Pound</option>
                                    <option value="INR">🇮🇳 INR - Indian Rupee</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="amount" class="form-label">Amount</label>
                                <input type="number" name="amount" id="amount" class="form-control" placeholder="Enter amount" required min="1" step="any">
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary btn-lg w-100" style="border-radius: 10px;">
                                    <i class="fas fa-lock me-2"></i>Pay Now
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--==============================
	Footer Area
==============================-->
    <?php include 'footer-mini.php'; ?>


    <!-- Scroll To Top -->
    <div class="scroll-top">
        <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" style="transition: stroke-dashoffset 10ms linear 0s; stroke-dasharray: 307.919, 307.919; stroke-dashoffset: 307.919;">
            </path>
        </svg>
    </div>


    <!--==============================
    All Js File
============================== -->
    <!-- Jquery -->
    <!-- Jquery -->
    <script src="assets/js/vendor/jquery-3.6.0.min.js"></script>
    <!-- Swiper Js -->
    <script src="assets/js/swiper-bundle.min.js"></script>
    <!-- Bootstrap -->
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- Magnific Popup -->
    <script src="assets/js/jquery.magnific-popup.min.js"></script>
    <!-- Counter Up -->
    <script src="assets/js/jquery.counterup.min.js"></script>
    <!-- Range Slider -->
    <script src="assets/js/jquery-ui.min.js"></script>
    <!-- imagesloaded -->
    <script src="assets/js/imagesloaded.pkgd.min.js"></script>
    <!-- isotope -->
    <script src="assets/js/isotope.pkgd.min.js"></script>
    <!-- gsap -->
    <script src="assets/js/gsap.min.js"></script>

    <!-- circle-progress -->
    <script src="assets/js/circle-progress.js"></script>

    <script src="assets/js/matter.min.js"></script>
    <script src="assets/js/matterjs-custom.js"></script>


    <!-- nice select -->
    <script src="assets/js/nice-select.min.js"></script>

    <!-- Main Js File -->
    <script src="assets/js/main.js"></script>
</body>

</html>