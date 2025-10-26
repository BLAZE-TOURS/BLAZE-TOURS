<?php
require_once 'assets/process/connection.php';

// Load currencies for the selector
$currency_rs = Database::search("SELECT id, currency, country, LKR FROM currency ORDER BY id ASC");
$currencies = [];
while ($c = $currency_rs->fetch_assoc()) {
    $currencies[] = $c;
}
?>
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

    <!-- PayHere SDK -->
    <script type="text/javascript" src="https://www.payhere.lk/lib/payhere.js"></script>

    <!-- Elfsight WhatsApp Chat | Untitled WhatsApp Chat -->
    <script src="https://static.elfsight.com/platform/platform.js" async></script>
    <div class="elfsight-app-105fdd11-2a94-4811-b9aa-24f273aafc7e" data-elfsight-app-lazy></div>

</head>

<body>
    <?php
    if (isset($_GET['status'])) {
        echo "<script>
            alert('" . htmlspecialchars($_GET['message'], ENT_QUOTES) . "');
        </script>";
    }
    ?>
    <?php include 'header.php'; ?>

    <div class="overflow-hidden space" id="payment-sec">
        <div class="container">
            <div class="title-area mb-30 text-center">
                <span class="sub-title">Secure Payment</span>
                <h2 class="sec-title">Complete Your Payment</h2>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8 col-sm-10">
                    <div class="card shadow-lg border-0 rounded-3 p-4">
                        <!-- updated form -->
                        <form id="paymentForm" method="POST">

                            <div class="mb-3">
                                <label for="email" class="form-label">Email *</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="Enter email" required>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description *</label>
                                <textarea name="description" id="description" class="form-control" placeholder="Enter description" required rows="3"></textarea>
                            </div>

                            <div class="mb-4">
                                <label for="currency" class="form-label">Currency</label>
                                <select name="currency_id" id="currency" class="form-select" required>
                                    <?php foreach ($currencies as $c) : ?>
                                        <option value="<?php echo htmlspecialchars($c['id']); ?>"
                                            data-code="<?php echo htmlspecialchars($c['currency']); ?>"
                                            data-rate="<?php echo htmlspecialchars($c['LKR']); ?>"
                                            <?php echo ($c['currency'] === 'LKR') ? 'selected' : ''; ?>> <!-- Set LKR as selected -->
                                            <?php echo htmlspecialchars($c['currency'] . ' - ' . $c['country']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="amount" class="form-label">Amount (in selected currency)</label>
                                <input type="number" name="amount" id="amount" class="form-control" placeholder="Enter amount" required min="0.01" step="any">
                            </div>

                            <div class="mb-3">
                                <label for="finalAmount" class="form-label">Final Amount (LKR)</label>
                                <input type="text" id="finalAmount" class="form-control" readonly value="0.00" aria-readonly="true">
                            </div>

                            <div class="mb-3">
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="fas fa-credit-card me-2"></i>Pay Now
                                    </button>
                                </div>
                            </div>
                        </form>
                        <!-- end updated form -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const currencySelect = document.getElementById('currency');
            const amountInput = document.getElementById('amount');
            const finalInput = document.getElementById('finalAmount');

            function parseRate(option) {
                if (!option) return 0;
                const r = parseFloat(option.getAttribute('data-rate'));
                return isFinite(r) ? r : 0;
            }

            function updateFinalAmount() {
                const opt = currencySelect.options[currencySelect.selectedIndex];
                const rate = parseRate(opt); // LKR per 1 unit of selected currency
                const amt = parseFloat(amountInput.value) || 0;
                const final = amt * rate;
                // show with currency label
                finalInput.value = 'LKR ' + (final ? final.toFixed(2) : '0.00');
            }

            if (currencySelect) currencySelect.addEventListener('change', updateFinalAmount);
            if (amountInput) amountInput.addEventListener('input', updateFinalAmount);

            // initialize
            updateFinalAmount();
        });
    </script>

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

    <!-- PayNow Payment Integration -->
    <script src="paynow/paynow.js"></script>
</body>

</html>