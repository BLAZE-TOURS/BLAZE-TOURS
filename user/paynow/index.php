<?php
require_once '../assets/process/connection.php';
require_once 'includes/config.php'; // Config ෆයිල් එක link කරන්න

// 1. PAYMENT PROCESSING LOGIC (Form එක Submit කළාම වැඩ කරන කොටස)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pay_submit'])) {

    $email = Database::escape_string($_POST['email']);
    $description = Database::escape_string($_POST['description']);
    $currency_id = intval($_POST['currency_id']);
    $amount = floatval($_POST['amount']); // Foreign Currency Amount

    // Currency Rate එක DB එකෙන් ගැනීම
    $curr_res = Database::search("SELECT * FROM currency WHERE id = '$currency_id'");

    if ($curr_res->num_rows > 0) {
        $curr_row = $curr_res->fetch_assoc();
        $rate = floatval($curr_row['LKR']);
        $currency_code = $curr_row['currency']; // USD, EUR etc.

        // LKR අගය ගණනය කිරීම (Database එකට සහ Payment එකට යවන්න)
        $lkr_amount = $amount * $rate;
        $order_id = uniqid('ORD-'); // Unique Order ID

        // Database එකට Insert කිරීම (Pending Status)
        $sql = "INSERT INTO paynow (order_id, email, description, currency_id, amount, lkr_amount, status, status_code, createdAt) 
                VALUES ('$order_id', '$email', '$description', '$currency_id', '$amount', '$lkr_amount', 'Pending', 0, NOW())";

        Database::iud($sql);

        // --- PAYHERE Redirect Form සැකසීම ---
        // PayHere එකට යවන්නේ LKR ගාන. ඒ නිසා currency = LKR ලෙස යවමු.

        $pay_currency = 'LKR';
        $pay_amount = number_format($lkr_amount, 2, '.', ''); // දශම ස්ථාන 2කට හදාගන්න

        // Hash Generation
        $hash_str = MERCHANT_ID . $order_id . $pay_amount . $pay_currency . strtoupper(md5(MERCHANT_SECRET));
        $hash = strtoupper(md5($hash_str));

        // Auto Submit Form එක Output කිරීම
        echo '<!DOCTYPE html>
        <html>
        <head><title>Redirecting...</title></head>
        <body>
            <p style="text-align:center; margin-top:20%;">Redirecting to PayHere Secure Gateway...</p>
            <form id="payhere_auto" method="post" action="' . PayHere_URL . '">
                <input type="hidden" name="merchant_id" value="' . MERCHANT_ID . '">
                <input type="hidden" name="return_url" value="' . RETURN_URL . '">
                <input type="hidden" name="cancel_url" value="' . CANCEL_URL . '">
                <input type="hidden" name="notify_url" value="' . NOTIFY_URL . '">
                
                <input type="hidden" name="order_id" value="' . $order_id . '">
                <input type="hidden" name="items" value="' . htmlspecialchars($description) . '">
                <input type="hidden" name="currency" value="' . $pay_currency . '">
                <input type="hidden" name="amount" value="' . $pay_amount . '">
                
                <input type="hidden" name="first_name" value="Customer">
                <input type="hidden" name="last_name" value="">
                <input type="hidden" name="email" value="' . $email . '">
                <input type="hidden" name="address" value="Sri Lanka">
                <input type="hidden" name="city" value="Colombo">
                <input type="hidden" name="country" value="Sri Lanka">
                
                <input type="hidden" name="hash" value="' . $hash . '">
            </form>
            <script>document.getElementById("payhere_auto").submit();</script>
        </body>
        </html>';
        exit(); // Code එක මෙතනින් නවත්වනවා (Redirect වෙන නිසා)
    } else {
        echo "<script>alert('Invalid Currency Selected');</script>";
    }
}

// Load currencies for the selector (Existing Logic)
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

    <!-- Header -->
    <!-- Mobile View -->
    <div class="th-menu-wrapper onepage-nav">
        <div class="th-menu-area text-center">
            <button class="th-menu-toggle"><i class="fal fa-times"></i></button>
            <div class="mobile-logo">
                <a href="../index.php"><img src="../assets/img/logo-main.png" alt="Tour"></a>
            </div>
            <div class="th-mobile-menu">
                <ul>
                    <li class="mega-menu-wrap">
                        <a class="active" href="../index.php">Home</a>
                    </li>
                    <li><a href="../tours.php">Tours</a></a></li>
                    <li><a href="../about.php">About Us</a></li>
                    <li><a href="../gallery.php">Gallery</a></li>
                    <li><a href="">Paynow</a></li>
                    <li><a href="../contact.php">Contact us</a></li>
                </ul>
            </div>
        </div>
    </div>



    <header class="th-header header-layout1">
        <div class="header-top">
            <div class="container th-container">
                <div class="row justify-content-center justify-content-xl-between align-items-center">
                    <div class="col-auto d-none d-md-block">
                        <div class="header-links">
                            <ul>
                                <li class="d-none d-xl-inline-block"><i class="fa-sharp fa-regular  fa-location-dot"></i>
                                    <span>68/29, Sri Sidhartha road, Kirulapane, Colombo-6</span>
                                </li>
                                <li class="d-none d-xl-inline-block"><i class="fa-regular fa-clock text-success"></i>
                                    <span class="text-success">Always Open</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="header-right">
                            <div class="header-links">
                                <ul>
                                    <li class="d-none d-md-inline-block"><a href="../privacy-policy.php">Privacy Policy</a></li>
                                    <li class="d-none d-md-inline-block"><a href="../terms-conditions.php">Terms & Conditions</a></li>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="sticky-wrapper">
            <!-- Main Menu Area -->
            <div class="menu-area">
                <div class="container th-container">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto">
                            <div class="header-logo">
                                <a href="../index.php"><img src="../assets/img/logo-main.png" alt="Tour"></a>
                            </div>
                        </div>
                        <div class="col-auto me-xl-auto">
                            <nav class="main-menu d-none d-xl-inline-block">
                                <ul>
                                    <li><a href="../index.php">Home</a></li>
                                    <li><a href="../tours.php">Tours</a></a></li>
                                    <li><a href="../about.php">About Us</a></li>
                                    <li><a href="../gallery.php">Gallery</a></li>
                                    <li><a href="">Paynow</a></li>
                                    <li><a href="../contact.php">Contact us</a></li>
                                </ul>
                            </nav>
                            <button type="button" class="th-menu-toggle d-block d-xl-none"><i class="far fa-bars"></i></button>
                        </div>
                        <div class="col-auto d-none d-xl-block">
                            <div class="header-button">
                                <a href="#" onclick="window.location.href='../tours.php'" class="th-btn style3 th-icon">Book Now</a>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="logo-bg" data-mask-src="../assets/img/logo_bg_mask.png"></div>
            </div>
        </div>
    </header>
    <!-- Header -->

    <div class="overflow-hidden space" id="payment-sec">
        <div class="container">
            <div class="title-area mb-30 text-center">
                <span class="sub-title">Secure Payment</span>
                <h2 class="sec-title">Complete Your Payment</h2>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8 col-sm-10">
                    <div class="card shadow-lg border-0 rounded-3 p-4">

                        <form id="paymentForm" method="POST">

                            <input type="hidden" name="pay_submit" value="1">

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
                                            <?php echo ($c['currency'] === 'LKR') ? 'selected' : ''; ?>>
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
                                <label for="finalAmount" class="form-label">Final Amount to Pay (LKR)</label>
                                <input type="text" id="finalAmount" class="form-control" readonly value="0.00" style="font-weight:bold; color:#007bff;">
                            </div>

                            <div class="mb-3">
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="fas fa-credit-card me-2"></i>Pay Now
                                    </button>
                                </div>
                            </div>
                        </form>
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
                const rate = parseRate(opt);
                const amt = parseFloat(amountInput.value) || 0;
                const final = amt * rate;
                // Display LKR value
                finalInput.value = 'LKR ' + (final ? final.toFixed(2) : '0.00');
            }

            if (currencySelect) currencySelect.addEventListener('change', updateFinalAmount);
            if (amountInput) amountInput.addEventListener('input', updateFinalAmount);
            updateFinalAmount();
        });
    </script>

    <!--==============================
	Footer Area
==============================-->
    <?php include '../footer-mini.php'; ?>


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