<?php
require_once '../assets/process/connection.php';

// Get tour ID from URL
$tour_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Validate tour exists and is active (status_id = 1)
$valid_tour = false;
if ($tour_id > 0) {
    $tour_id_safe = Database::escape_string($tour_id);
    $check_query = "SELECT status_id FROM tour WHERE id = '$tour_id_safe' LIMIT 1";
    $result = Database::search($check_query);

    if ($result && $result->num_rows > 0) {
        $tour = $result->fetch_assoc();
        if ($tour['status_id'] == 1) {
            $valid_tour = true;
        }
    }
}

// Redirect to tours page if tour is invalid or inactive
if (!$valid_tour) {
    header('Location: ../tours.php?error=' . urlencode('Tour not available'));
    exit;
}

// Continue with rest of the file only if tour is valid
include '../assets/process/fetchTour.php';
?>
<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Blaze Tours (Pvt) Ltd | Colombo City & Sri Lanka Tours</title>
    <meta name="author" content="Blaze Tours (Pvt) Ltd">
    <meta name="description" content="Blaze Tours (Pvt) Ltd is a Colombo-based travel company offering unforgettable city tours, cultural trips, and scenic getaways across Sri Lanka. Explore paradise with us!">
    <meta name="keywords" content="Colombo tours, Sri Lanka travel, Blaze Tours, day trips Colombo, Sri Lanka sightseeing, private tours, cultural tours, beach tours">
    <meta name="robots" content="INDEX,FOLLOW">

    <!-- meta -->
    <meta property="og:title" content="Blaze Tours (Pvt) Ltd | Colombo & Sri Lanka Tours">
    <meta property="og:description" content="Explore stunning Colombo city and Sri Lanka tours with Blaze Tours (Pvt) Ltd. Book your adventure today!">
    <meta property="og:image" content="https://blaze-tours.com/assets/img/preview.png">
    <meta property="og:url" content="https://blaze-tours.com/">
    <meta property="og:type" content="website">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Blaze Tours (Pvt) Ltd | Colombo & Sri Lanka Tours">
    <meta name="twitter:description" content="Explore stunning Colombo city and Sri Lanka tours with Blaze Tours (Pvt) Ltd. Book your adventure today!">
    <meta name="twitter:image" content="https://blaze-tours.com/assets/img/preview.png">

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

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/css/intlTelInput.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/intlTelInput.min.js"></script>


    <!-- Custom Booking Modal CSS -->
    <style>
        .card {
            background: #f9fafc;
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
        }

        input.form-control {
            border-radius: 10px;
            padding: 10px 14px;
        }

        .modal-content {
            border-radius: 15px;
            border: none;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            z-index: 1056;
        }

        .modal {
            z-index: 1055;
        }

        .modal-backdrop {
            z-index: 1050;
        }


        .modal-title {
            font-weight: 600;
            font-size: 1.5rem;
        }

        .btn-close {
            filter: invert(1);
        }

        .form-label {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
        }

        .form-control,
        .form-select {
            border-radius: 8px;
            border: 2px solid #e9ecef;
            padding: 12px 15px;
            transition: all 0.3s ease;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #bd3838;
            box-shadow: 0 0 0 0.2rem rgba(234, 113, 102, 0.25);
        }

        .input-group .btn {
            border-radius: 8px;
            border: 2px solid #e9ecef;
            font-weight: bold;
            width: 45px;
        }

        .input-group .btn:hover {
            background-color: #bd3838;
            border-color: #bd3838;
            color: white;
        }

        .form-check-input:checked {
            background-color: #bd3838;
            border-color: #bd3838;
        }

        .form-check-label {
            font-weight: 500;
            padding-left: 8px;
        }

        .card {
            border-radius: 10px;
            border: none;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .btn-primary {
            background: linear-gradient(135deg, #bd3838 0%, rgb(195, 37, 37) 100%);
            border: none;
            border-radius: 8px;
            padding: 12px 30px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(234, 109, 102, 0.4);
        }

        .btn-secondary {
            border-radius: 8px;
            padding: 12px 30px;
            font-weight: 600;
        }


        .country-code-select {
            background-image: none;
        }

        .country-code-select option {
            padding: 10px;
        }

        .modal-body {
            padding: 2rem;
        }

        .modal-footer {
            border-top: none;
            background-color: #f8f9fa;
            border-radius: 0 0 15px 15px;
        }

        .modal-body.border-top {
            background-color: #fff;
            border-top: 1px solid #dee2e6;
            margin-top: 1rem;
        }

        /* Mobile Responsive Styles */
        @media (max-width: 768px) {
            .modal-dialog {
                margin: 0.5rem;
                max-width: calc(100% - 1rem);
                z-index: 1055;
            }

            .modal-content {
                border-radius: 10px;
                margin: 0;
                z-index: 1056;
            }

            .modal-backdrop {
                z-index: 1050;
            }

            .modal-body {
                padding: 1rem;
                max-height: 80vh;
                overflow-y: auto;
            }

            .modal-footer {
                padding: 1rem;
                flex-direction: column;
                gap: 0.5rem;
            }

            .modal-footer .btn {
                width: 100%;
                margin: 0;
            }

            .form-label {
                font-size: 14px;
                margin-bottom: 6px;
            }

            .form-control,
            .form-select {
                padding: 10px 12px;
                font-size: 14px;
            }

            .input-group .btn {
                width: 40px;
                padding: 8px;
            }

            .form-check-label {
                font-size: 14px;
            }

            .card-body {
                padding: 1rem;
            }

            .card-title {
                font-size: 1rem;
            }

            .phone-input {
                max-width: 100%;
            }

            .modal-title {
                font-size: 1.25rem;
            }

            .btn-primary,
            .btn-secondary {
                padding: 10px 20px;
                font-size: 14px;
            }
        }

        @media (max-width: 576px) {
            .modal-dialog {
                margin: 0.25rem;
                max-width: calc(100% - 0.5rem);
            }

            .modal-body {
                padding: 0.75rem;
                max-height: 85vh;
            }

            .modal-footer {
                padding: 0.75rem;
            }

            .row {
                margin: 0;
            }

            .col-md-6,
            .col-md-4,
            .col-6 {
                padding: 0 0 1rem 0;
            }

            /* Time slot specific mobile styling */
            .col-6 .form-check {
                margin-bottom: 0.5rem;
                padding: 8px;
                border: 1px solid #e9ecef;
                border-radius: 6px;
                background: #f8f9fa;
            }

            .col-6 .form-check:hover {
                background: #e9ecef;
                border-color: #bd3838;
            }

            .col-6 .form-check-input:checked+.form-check-label {
                color: #bd3838;
                font-weight: 600;
            }

            .form-control,
            .form-select {
                padding: 8px 10px;
                font-size: 13px;
            }

            .input-group .btn {
                width: 35px;
                padding: 6px;
                font-size: 12px;
            }

            .form-check {
                margin-bottom: 0.5rem;
            }

            .card {
                margin-bottom: 1rem;
            }

            .card-body {
                padding: 0.75rem;
            }

            .d-flex {
                flex-direction: column;
                gap: 0.25rem;
            }

            .d-flex.justify-content-between {
                flex-direction: row;
                justify-content: space-between;
            }
        }

        @media (max-width: 400px) {
            .modal-dialog {
                margin: 0.1rem;
                max-width: calc(100% - 0.2rem);
            }

            .modal-body {
                padding: 0.5rem;
            }

            .modal-footer {
                padding: 0.5rem;
            }

            .form-control,
            .form-select {
                padding: 6px 8px;
                font-size: 12px;
            }

            .btn-primary,
            .btn-secondary {
                padding: 8px 16px;
                font-size: 13px;
            }

            .modal-title {
                font-size: 1.1rem;
            }

            .form-label {
                font-size: 13px;
            }
        }

        .phone-input {
            max-width: 350px;
            margin: 10px 0;
        }

        .iti {
            width: 100%;
        }

        /* Mobile Touch Improvements */
        @media (max-width: 768px) {
            .form-check-input {
                transform: scale(1.2);
                margin-right: 8px;
            }

            .btn {
                min-height: 44px;
                touch-action: manipulation;
            }

            .input-group .btn {
                min-height: 44px;
            }

            .form-control,
            .form-select {
                min-height: 44px;
                touch-action: manipulation;
            }

            .modal-dialog {
                min-height: 100vh;
                display: flex;
                align-items: center;
                margin-top: 20px;
            }

            .modal-content {
                min-height: auto;
                max-height: 90vh;
                margin-top: 20px;
            }

            .modal-body {
                -webkit-overflow-scrolling: touch;
            }

            /* Ensure modal appears above fixed headers */
            .modal.show {
                z-index: 9999 !important;
            }

            .modal-dialog {
                z-index: 10000 !important;
            }

            .modal-content {
                z-index: 10001 !important;
            }
        }

        /* Prevent zoom on input focus on iOS */
        @media screen and (-webkit-min-device-pixel-ratio: 0) {

            select,
            textarea,
            input[type="text"],
            input[type="password"],
            input[type="datetime"],
            input[type="datetime-local"],
            input[type="date"],
            input[type="month"],
            input[type="time"],
            input[type="week"],
            input[type="number"],
            input[type="email"],
            input[type="url"],
            input[type="search"],
            input[type="tel"],
            input[type="color"] {
                font-size: 16px;
            }
        }

        /* Add this to your existing style section */
        .form-check {
            margin-bottom: 1rem;
        }

        .form-check-input:checked {
            background-color: #bd3838;
            border-color: #bd3838;
        }

        .form-check-label {
            font-size: 0.9rem;
            color: #6c757d;
        }

        .form-check-label a:hover {
            color: #bd3838;
        }

        #goToCheckout:disabled {
            opacity: 0.65;
            cursor: not-allowed;
        }
    </style>
</head>

<body>

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
                    <li><a href="../paynow/">Paynow</a></li>
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
                                    <li><a href="../paynow/">Paynow</a></li>
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


    <div class="breadcumb-wrapper " data-bg-src="../assets/img/bg/category_bg_1.png">
        <div class="container">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title">Tour Page</h1>
                <ul class="breadcumb-menu">
                    <li><a href="index.php">Home</a></li>
                    <li>Tour Details</li>
                </ul>
            </div>
        </div>
    </div><!--==============================
tour Area
==============================-->
    <section class="space">
        <div class="container">
            <div class="row">
                <div class="col-xxl-8 col-lg-7">
                    <div class="page-single">
                        <!-- Main Image -->
                        <div class="service-img">
                            <?php
                            $main_image_name = '';
                            if (!empty($tour['main_image'])) {
                                $main_image_name = basename($tour['main_image']);
                            }
                            ?>
                            <img src="../../admin/assets/uploads/tour_images/<?php echo $main_image_name ? $main_image_name : 'default.png'; ?>" alt="image">
                        </div>
                        <div class="page-content d-block">
                            <div class="page-meta mt-50 mb-45">
                                <a class="page-tag" href="tour.php">POPULAR</a>
                                <span class="ratting"><i class="fa-sharp fa-solid fa-star"></i><span>4.8</span></span>
                            </div>
                            <h2 class="box-title"><?php echo htmlspecialchars($tour['name'] ?? ''); ?></h2>
                            <p class="box-text mb-30"><?php echo htmlspecialchars($tour['description'] ?? ''); ?></p>
                            -->
                            <div class="service-inner-img mb-40">
                                <?php
                                $second_image_name = '';
                                if (!empty($tour['second_image'])) {
                                    $second_image_name = basename($tour['second_image']);
                                }
                                ?>

                                <img src="../../admin/assets/uploads/tour_images/<?php echo $second_image_name ? $second_image_name : 'default.png'; ?>" alt="image">
                            </div>
                        </div>
                        <div class="destination-gallery-wrapper col-12 order-1">
                            <h3 class="page-title mt-30 mb-30">Destination Map</h3>
                            <div class="row gy-4">
                                <iframe src="../assets/process/livemapBody.php?id=<?php echo $tour_id; ?>" width="100%" height="480" style="border:0;"></iframe>
                            </div>
                        </div>
                        <div class="destination-gallery-wrapper">
                            <h3 class="page-title mt-30 mb-30">From our gallery</h3>
                            <div class="row gy-4 gallery-row filter-active">
                                <?php
                                // Fetch gallery images for this tour
                                $gallery_items = [];
                                $ch = curl_init('http://localhost/BLAZE-TOURS/user/assets/process/fetchTourGallery.php?tour_id=' . $tour_id);
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                $response = curl_exec($ch);
                                curl_close($ch);
                                if ($response) {
                                    $gallery_items = json_decode($response, true);
                                    if (!is_array($gallery_items)) $gallery_items = [];
                                }
                                $sizes = [
                                    ['w' => 312, 'h' => 215],
                                    ['w' => 526, 'h' => 215],
                                    ['w' => 526, 'h' => 215],
                                    ['w' => 312, 'h' => 215],
                                ];
                                for ($i = 0; $i < 4; $i++):
                                    $img = $gallery_items[$i] ?? ['url' => '../assets/img/gallery/gallery_6_' . ($i + 1) . '.jpg', 'title' => 'Default'];
                                    $w = $sizes[$i]['w'];
                                    $h = $sizes[$i]['h'];
                                ?>
                                    <div class="col-xxl-auto filter-item">
                                        <div class="gallery-box style3">
                                            <div class="gallery-img global-img">
                                                <img src="<?php echo htmlspecialchars($img['url']); ?>"
                                                    alt="<?php echo htmlspecialchars($img['title']); ?>"
                                                    width="<?php echo $w; ?>" height="<?php echo $h; ?>"
                                                    style="object-fit:cover; width:<?php echo $w; ?>px; height:<?php echo $h; ?>px;">
                                                <a href="<?php echo htmlspecialchars($img['url']); ?>" class="icon-btn popup-image">
                                                    <i class="fal fa-magnifying-glass-plus"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                <?php endfor; ?>
                            </div>
                        </div>
                        <div class="th-comments-wrap style2 ">
                            <h2 class="blog-inner-title h4">Reviews (0)</h2>
                            <ul class="comment-list"></ul>
                        </div>
                        <div class="th-comment-form ">
                            <div class="row">
                                <h3 class="blog-inner-title h4 mb-2">Share Your Experience</h3>
                                <p class="mb-25">Your email address will not be published. Required fields are marked</p>
                                <div class="col-md-6 form-group">
                                    <input type="text" placeholder="Full Name*" class="form-control" name="name" required>
                                    <i class="far fa-user"></i>
                                </div>
                                <div class="col-md-6 form-group">
                                    <input type="text" placeholder="Your Email*" class="form-control" name="email" required>
                                    <i class="far fa-envelope"></i>
                                </div>
                                <div class="col-12 form-group">
                                    <label class="mb-2">Your Rating*</label>
                                    <div id="star-rating" style="font-size: 1.7em; color: #FFD700; cursor: pointer;">
                                        <span class="star" data-value="1">&#9733;</span>
                                        <span class="star" data-value="2">&#9733;</span>
                                        <span class="star" data-value="3">&#9733;</span>
                                        <span class="star" data-value="4">&#9733;</span>
                                        <span class="star" data-value="5">&#9733;</span>
                                    </div>
                                    <input type="hidden" name="rating" id="rating" value="5" required>
                                </div>
                                <div class="col-12 form-group">
                                    <textarea placeholder="Comment*" class="form-control" name="comment" required></textarea>
                                    <i class="far fa-pencil"></i>
                                </div>
                                <div class="col-12 form-group mb-0">
                                    <button class="th-btn" type="button">Submit Review<img src="../assets/img/icon/plane2.svg" alt=""></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-4 col-lg-5">
                    <aside class="sidebar-area style3">
                        <div class="widget tour-booking">
                            <p class="widget_subtitle">From <span class="widget_price">$<?php echo number_format($tour['adult_price'] ?? 0, 2); ?></span>/Person</p>
                            <div class="info-list">
                                <ul>
                                    <li>
                                        <strong>Duration : <?php echo htmlspecialchars($tour['duration'] ?? ''); ?> hours</strong>
                                    </li>
                                    <?php foreach ($highlights as $hl): ?>
                                        <li><strong><?php echo htmlspecialchars($hl); ?></strong></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                            <button class="th-btn th-icon" data-bs-toggle="modal" data-bs-target="#bookingModal">Book Now</button>
                            <span class="review"><i class="fa-light fa-heart"></i> 88% of travelers recommend this experience</span>
                        </div>
                        <div class="widget tour-booking col-12 order-2 order-lg-3 ">
                            <p class="widget_subtitle">Highlight <span class="widget_price">Itinerary</span></p>
                            <div class="info-list">
                                <ul>
                                    <?php foreach ($locations as $loc): ?>
                                        <li>
                                            <strong><?php echo htmlspecialchars($loc['name']); ?></strong>
                                            <span>Stop: <?php echo intval($loc['stop_duration_time']); ?> minutes</span>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                        <div class="widget widget_tag_cloud">
                            <h3 class="widget_title">Available time</h3>
                            <div class="tagcloud">
                                <?php foreach ($times as $time): ?>
                                    <a href=""><?php echo date('g:i A', strtotime($time)); ?></a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </aside>
                </div>

            </div>
        </div>
        <div class="shape-mockup shape1 d-none d-xxl-block" data-bottom="35%" data-right="12%">
            <img src="../assets/img/shape/shape_1.png" alt="shape">
        </div>
        <div class="shape-mockup shape2 d-none d-xl-block" data-bottom="31%" data-right="8%">
            <img src="../assets/img/shape/shape_2.png" alt="shape">
        </div>
        <div class="shape-mockup shape3 d-none d-xxl-block" data-bottom="33%" data-right="5%">
            <img src="../assets/img/shape/shape_3.png" alt="shape">
        </div>
    </section><!--==============================
	Footer Area
==============================-->


<!-- Footer -->
 <footer class="footer-wrapper footer-layout1">
    <div class="widget-area">
        <div class="container">
            <div class="newsletter-area">
                <div class="newsletter-top">
                    <div class="row gy-4 align-items-center">
                        <div class="col-lg-5">
                            <h2 class="newsletter-title text-capitalize mb-0">get updated the latest newsletter</h2>
                        </div>
                        <div class="col-lg-7">
                            <form class="newsletter-form">
                                <input class="form-control" type="email" name="email" placeholder="Email address." required id="Footer-Subscriber-email">
                                <button type="button" id="subscribe-button" class="th-btn style3">
                                    Subscribe Now
                                    <img src="../assets/img/icon/plane.svg" alt="">
                                    <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-between">
                <div class="col-md-6 col-xl-3">
                    <div class="widget footer-widget">
                        <div class="th-widget-about">
                            <div class="about-logo">
                                <a href="home-travel.php"><img src="../assets/img/footer-logo.png" alt="Tour"></a>
                            </div>
                            <p class="about-text">Discover Sri Lanka with trusted tours, safe rides, lasting memories.</p>
                            <div class="th-social">
                                <a href="https://www.facebook.com/"><i class="fab fa-facebook-f"></i></a>
                                <a href="https://www.twitter.com/"><i class="fab fa-twitter"></i></a>
                                <a href="https://www.linkedin.com/"><i class="fab fa-linkedin-in"></i></a>
                                <a href="https://www.whatsapp.com/"><i class="fab fa-whatsapp"></i></a>
                                <a href="https://instagram.com/"><i class="fab fa-instagram"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-auto">
                    <div class="widget widget_nav_menu footer-widget">
                        <h3 class="widget_title">Quick Links</h3>
                        <div class="menu-all-pages-container">
                            <ul class="menu">

                                <li><a href="../index.php">Home</a></li>
                                <li><a href="../tours.php">Tours</a></li>
                                <li><a href="../about.php">About us</a></li>
                                <li><a href="../gallery.php">Gallery</a></li>
                                <li><a href="../contact.php">Contact Us</a></li>
                                <li><a href="../privacy-policy.php">Privacy Policy</a></li>
                                <li><a href="../refund-policy.php">Return & Refund Policy</a></li>
                                <li><a href="../terms-conditions.php">Terms & Conditions</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-auto">
                    <div class="widget footer-widget">
                        <h3 class="widget_title">Address</h3>
                        <div class="th-widget-contact">
                            <div class="info-box_text">
                                <div class="icon">
                                    <img src="../assets/img/icon/phone.svg" alt="img">
                                </div>
                                <div class="details">
                                    <p><a href="tel:+94713344399" class="info-box_link">+94713344399</a></p>
                                </div>
                            </div>
                            <div class="info-box_text">
                                <div class="icon">
                                    <img src="../assets/img/icon/envelope.svg" alt="img">
                                </div>
                                <div class="details">
                                    <p><a href="mailto:info@blaze-tours.com" class="info-box_link">info@blaze-tours.com</a></p>
                                    <p><a href="mailto:booking@blaze-tours.com" class="info-box_link">booking@blaze-tours.com</a></p>
                                </div>
                            </div>
                            <div class="info-box_text">
                                <div class="icon"><img src="../assets/img/icon/location-dot.svg" alt="img"></div>
                                <div class="details">
                                    <p>68/29, Sri Sidhartha road, Kirulapane, Colombo-6</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-auto">
                    <div class="widget footer-widget">
                        <h3 class="widget_title">Instagram Post</h3>
                        <div class="sidebar-gallery" id="insta-gallery">
                            <blockquote class="instagram-media" data-instgrm-permalink="https://www.instagram.com/travel_with_blaze/" data-instgrm-version="12" style="background:#FFF; border:0; border-radius:3px; box-shadow:0 0 1px 0 rgba(0,0,0,0.5),0 1px 10px 0 rgba(0,0,0,0.15); margin: 1px; max-width:540px; min-width:326px; padding:0; width:99.375%;">
                                <div style="padding:16px;">
                                    <a href="https://www.instagram.com/travel_with_blaze/" style="background:#FFFFFF; line-height:0; padding:0 0; text-align:center; text-decoration:none; width:100%;" target="_blank">
                                        <div style="display: flex; flex-direction: row; align-items: center;">
                                            <div style="background-color: #F4F4F4; border-radius: 50%; flex-grow: 0; height: 40px; margin-right: 14px; width: 40px;"></div>
                                            <div style="display: flex; flex-direction: column; flex-grow: 1; justify-content: center;">
                                                <div style="background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; margin-bottom: 6px; width: 100px;"></div>
                                                <div style="background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; width: 60px;"></div>
                                            </div>
                                        </div>
                                        <div style="padding: 19% 0;"></div>
                                        <div style="display:block; height:50px; margin:0 auto 12px; width:50px;">
                                            <svg width="50px" height="50px" viewBox="0 0 60 60" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <g transform="translate(-511.000000, -20.000000)" fill="#000000">
                                                        <path d="M556.869,30.41 C554.814,30.41 553.148,32.076 553.148,34.131 C553.148,36.186 554.814,37.852 556.869,37.852 C558.924,37.852 560.59,36.186 560.59,34.131 C560.59,32.076 558.924,30.41 556.869,30.41 M541,60.657 C535.114,60.657 530.342,55.887 530.342,50 C530.342,44.114 535.114,39.342 541,39.342 C546.887,39.342 551.658,44.114 551.658,50 C551.658,55.887 546.887,60.657 541,60.657 M541,33.886 C532.1,33.886 524.886,41.1 524.886,50 C524.886,58.899 532.1,66.113 541,66.113 C549.9,66.113 557.115,58.899 557.115,50 C557.115,41.1 549.9,33.886 541,33.886 M565.378,62.101 C565.244,65.022 564.756,66.606 564.346,67.663 C563.803,69.06 563.154,70.057 562.106,71.106 C561.058,72.155 560.06,72.803 558.662,73.347 C557.607,73.757 556.021,74.244 553.102,74.378 C549.944,74.521 548.997,74.552 541,74.552 C533.003,74.552 532.056,74.521 528.898,74.378 C525.979,74.244 524.393,73.757 523.338,73.347 C521.94,72.803 520.942,72.155 519.894,71.106 C518.846,70.057 518.197,69.06 517.654,67.663 C517.244,66.606 516.755,65.022 516.623,62.101 C516.479,58.943 516.448,57.996 516.448,50 C516.448,42.003 516.479,41.056 516.623,37.899 C516.755,34.978 517.244,33.391 517.654,32.338 C518.197,30.938 518.846,29.942 519.894,28.894 C520.942,27.846 521.94,27.196 523.338,26.654 C524.393,26.244 525.979,25.756 528.898,25.623 C532.057,25.479 533.004,25.448 541,25.448 C548.997,25.448 549.943,25.479 553.102,25.623 C556.021,25.756 557.607,26.244 558.662,26.654 C560.06,27.196 561.058,27.846 562.106,28.894 C563.154,29.942 563.803,30.938 564.346,32.338 C564.756,33.391 565.244,34.978 565.378,37.899 C565.522,41.056 565.552,42.003 565.552,50 C565.552,57.996 565.522,58.943 565.378,62.101 M570.82,37.631 C570.674,34.438 570.167,32.258 569.425,30.349 C568.659,28.377 567.633,26.702 565.965,25.035 C564.297,23.368 562.623,22.342 560.652,21.575 C558.743,20.834 556.562,20.326 553.369,20.18 C550.169,20.033 549.148,20 541,20 C532.853,20 531.831,20.033 528.631,20.18 C525.438,20.326 523.257,20.834 521.349,21.575 C519.376,22.342 517.703,23.368 516.035,25.035 C514.368,26.702 513.342,28.377 512.574,30.349 C511.834,32.258 511.326,34.438 511.181,37.631 C511.035,40.831 511,41.851 511,50 C511,58.147 511.035,59.17 511.181,62.369 C511.326,65.562 511.834,67.743 512.574,69.651 C513.342,71.625 514.368,73.296 516.035,74.965 C517.703,76.634 519.376,77.658 521.349,78.425 C523.257,79.167 525.438,79.673 528.631,79.82 C531.831,79.965 532.853,80.001 541,80.001 C549.148,80.001 550.169,79.965 553.369,79.82 C556.562,79.673 558.743,79.167 560.652,78.425 C562.623,77.658 564.297,76.634 565.965,74.965 C567.633,73.296 568.659,71.625 569.425,69.651 C570.167,67.743 570.674,65.562 570.82,62.369 C570.966,59.17 571,58.147 571,50 C571,41.851 570.966,40.831 570.82,37.631"></path>
                                                    </g>
                                                </g>
                                            </svg>
                                        </div>
                                        <div style="padding-top: 8px;">
                                            <div style="color:#3897f0; font-family:Arial,sans-serif; font-size:14px; font-style:normal; font-weight:550; line-height:18px;">View this post on Instagram</div>
                                        </div>
                                    </a>
                                    <p style="color:#c9c8cd; font-family:Arial,sans-serif; font-size:14px; line-height:17px; margin-bottom:0; margin-top:8px; overflow:hidden; padding:8px 0 7px; text-align:center; text-overflow:ellipsis; white-space:nowrap;">
                                        A post shared by <a href="https://www.instagram.com/travel_with_blaze/" style="color:#c9c8cd; font-family:Arial,sans-serif; font-size:14px; font-style:normal; font-weight:normal; line-height:17px; text-decoration:none;" target="_blank">travel_with_blaze</a>
                                    </p>
                                </div>
                            </blockquote>
                            <!-- Instagram's official embed script -->
                            <script async src="https://www.instagram.com/embed.js"></script>
                        </div>
                        <style>
                            .boxes3 {
                                height: 175px;
                                width: 153px;
                            }
                        </style>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    <div class="copyright-wrap">
        <div class="container">
            <div class="row justify-content-between align-items-center">
                <div class="col-md-6">
                    <p class="copyright-text">Copyright 2025 <a href="home-travel.php">BLAZE TOURS (PVT) LTD</a> | All Rights Reserved.</p>
                </div>
                <div class="col-md-6 text-end d-none d-md-block">
                    <div class="footer-card">
                        <span class="title">We Accept</span>
                        <a href="https://www.payhere.lk" target="_blank"><img src="../assets/img/payhere.png" alt="PayHere" width="400" /></a>
                    </div>
                </div>
            </div>

        </div>
    </div>

</footer>

<script src="assets/js/Footersubscriber.js"></script>
<script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
<!-- Footer -->


    <!-- Booking Modal -->
    <div class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="bookingModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">

                <div class="modal-body">
                    <form id="bookingForm">
                        <!-- Tour Name -->
                        <div class="mb-4">
                            <h4 class="fw-bold"><?php echo htmlspecialchars($tour['name'] ?? ''); ?></h4>
                        </div>

                        <!-- Date Selection -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="tourDate" class="form-label">Select Date *</label>
                                <input type="date" class="form-control" id="tourDate" name="tourDate" required>
                            </div>
                        </div>

                        <!-- People Count -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Adults *</label>
                                <div class="input-group">
                                    <button type="button" class="btn btn-outline-secondary" id="adultMinus">-</button>
                                    <input type="number" class="form-control text-center" id="adultCount" name="adultCount" value="1" min="1" readonly>
                                    <button type="button" class="btn btn-outline-secondary" id="adultPlus">+</button>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Children</label>
                                <div class="input-group">
                                    <button type="button" class="btn btn-outline-secondary" id="childMinus">-</button>
                                    <input type="number" class="form-control text-center" id="childCount" name="childCount" value="0" min="0" readonly>
                                    <button type="button" class="btn btn-outline-secondary" id="childPlus">+</button>
                                </div>
                            </div>
                        </div>

                        <!-- Time Slot Selection -->
                        <div class="mb-3">
                            <label class="form-label">Select Time Slot *</label>
                            <div class="row">
                                <?php foreach ($times as $index => $time): ?>
                                    <div class="col-md-4 col-sm-6 col-6 mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="timeSlot" id="timeSlot<?php echo $index; ?>" value="<?php echo $time; ?>" required>
                                            <label class="form-check-label" for="timeSlot<?php echo $index; ?>">
                                                <?php echo date('g:i A', strtotime($time)); ?>
                                            </label>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <!-- Contact Information -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="fullName" class="form-label">Full Name *</label>
                                <input type="text" class="form-control" id="fullName" name="fullName" required>
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email Address *</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                        </div>

                        <!-- Phone Number with Country Code -->
                        <div class="mb-3">
                            <label for="phoneNumber" class="form-label">Phone Number *</label>
                            <div class="phone-input">
                                <input name="number3" id="number3" type="tel" placeholder="Enter phone number" class="form-control" />
                            </div>

                        </div>

                        <!-- Pickup Location -->
                        <div class="mb-3">
                            <label for="pickup" class="form-label">Pickup Location *</label>
                            <input type="text" class="form-control" id="pickup" name="pickup" placeholder="Enter your pickup location" required>
                        </div>

                        <!-- Price Summary -->
                        <div class="mb-4">
                            <div class="card shadow-sm border-0 rounded-3">
                                <div class="card-body">
                                    <h5 class="card-title text-center fw-bold text-primary mb-3">
                                        Price Summary
                                    </h5>

                                    <!-- Adults -->
                                    <div class="d-flex justify-content-between align-items-center py-2">
                                        <span class="fw-medium">Adults (1 × $<?php echo number_format($tour['adult_price'] ?? 0, 2); ?>)</span>
                                        <span id="adultPrice" class="fw-semibold text-dark">
                                            $<?php echo number_format($tour['adult_price'] ?? 0, 2); ?>
                                        </span>
                                    </div>

                                    <!-- Children -->
                                    <div class="d-flex justify-content-between align-items-center py-2 border-top" id="childPriceRow" style="display: none;">
                                        <span class="fw-medium">Children (0 × $<?php echo number_format($tour['kids_price'] ?? 0, 2); ?>)</span>
                                        <span id="childPrice" class="fw-semibold text-dark">$0.00</span>
                                    </div>

                                    <hr class="my-3">

                                    <!-- Total -->
                                    <div class="d-flex justify-content-between align-items-center">
                                        <strong class="text-success">Total Price</strong>
                                        <strong id="totalPrice" class="text-success fs-5">
                                            $<?php echo number_format($tour['adult_price'] ?? 0, 2); ?>
                                        </strong>
                                    </div>

                                    <!-- LKR Equivalent -->
                                    <div class="d-flex justify-content-between text-muted small mt-1">
                                        <span>LKR Equivalent</span>
                                        <span id="totalPriceLKR">Loading...</span>
                                    </div>

                                    <hr class="my-3">

                                    <!-- Paid Amount Section -->
                                    <div class="form-group">
                                        <label for="paidAmount" class="form-label fw-semibold">Paid Amount (USD)</label>
                                        <input type="number" class="form-control border-0 shadow-sm" id="paidAmount"
                                            step="any" min="0" placeholder="Min $00" required>

                                        <small class="fw-medium d-block mt-2">
                                            Min. Advance <span class="text-danger">$00 (00% of total)</span>
                                        </small>

                                        <div class="mt-3 border-top pt-2">
                                            <div class="d-flex justify-content-between">
                                                <span>Paid Amount (LKR)</span>
                                                <span id="paidLKR" class="fw-semibold">Rs. 0</span>
                                            </div>
                                            <div class="d-flex justify-content-between mt-2">
                                                <span>Balance Due (LKR)</span>
                                                <span id="balanceLKR" class="fw-semibold text-danger">Rs. 0</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>
                    <!-- Add this just before the modal-footer div -->
                    <div class="modal-body border-top pt-3">
                        <div class="small text-muted mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="privacyPolicyCheck" required>
                                <label class="form-check-label" for="privacyPolicyCheck">
                                    I agree to the <a href="privacy-policy.php" target="_blank" class="text-decoration-underline">Privacy Policy</a>
                                    & <a href="refund-policy.php" target="_blank" class="text-decoration-underline">Refund Policy</a>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="goToCheckout" disabled>Go to Checkout</button>
                </div>
            </div>
        </div>
    </div>

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

    <!-- Intl-Tel-Input JS -->
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18.5.1/build/js/intlTelInput.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18.5.1/build/js/utils.js"></script>

    <!-- CryptoJS for MD5 hash generation -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.1.1/crypto-js.min.js"></script>

    <!-- nice select -->
    <script src="../assets/js/nice-select.min.js"></script>

    <!-- Main Js File -->
    <script src="../assets/js/main.js"></script>
    <script src="../assets/js/review.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>

<script type="text/javascript" src="https://www.payhere.lk/lib/payhere.js"></script>

    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places&callback=initAutocomplete" async defer></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            
            // Initialize Notyf for notifications
            const notyf = new Notyf({
                duration: 4000,
                position: { x: 'center', y: 'top' },
                dismissible: true
            });

            // Function to check if date is closed
            async function checkClosedDay(date) {
                if (!date) {
                    return { success: false, message: 'Please select a date' };
                }

                try {
                    const response = await fetch(`../assets/process/checkClosedDay.php?date=${date}`);
                    const data = await response.json();
                    return data;
                } catch (error) {
                    console.error('Error checking closed day:', error);
                    return { success: false, message: 'Error checking date availability' };
                }
            }

            // Function to check if the selected date/time slot already has a successful booking
            async function checkSlotAvailability(date, timeSlot) {
                if (!date || !timeSlot) {
                    return { success: false, message: 'Select both date and time slot' };
                }

                try {
                    const response = await fetch(`../assets/process/checkSlotAvailability.php?tour_id=${tourId}&date=${date}&timeSlot=${encodeURIComponent(timeSlot)}`);
                    const data = await response.json();
                    return data;
                } catch (error) {
                    console.error('Error checking slot availability:', error);
                    return { success: false, message: 'Error checking slot availability' };
                }
            }
            
            // 1. Star Rating Logic
            const stars = document.querySelectorAll("#star-rating .star");
            const ratingInput = document.getElementById("rating");

            stars.forEach(star => {
                star.addEventListener("click", function() {
                    const rating = this.getAttribute("data-value");
                    ratingInput.value = rating;
                    stars.forEach(s => {
                        s.style.color = (s.getAttribute("data-value") <= rating) ? "#FFD700" : "#ccc";
                    });
                });
            });

            // 2. Booking Variables
            const adultCount = document.getElementById('adultCount');
            const childCount = document.getElementById('childCount');
            const adultPlus = document.getElementById('adultPlus');
            const adultMinus = document.getElementById('adultMinus');
            const childPlus = document.getElementById('childPlus');
            const childMinus = document.getElementById('childMinus');
            const adultPrice = document.getElementById('adultPrice');
            const childPrice = document.getElementById('childPrice');
            const childPriceRow = document.getElementById('childPriceRow');
            const totalPrice = document.getElementById('totalPrice');
            const paidAmountInput = document.getElementById('paidAmount');
            
            // Checkbox and Button
            const privacyCheckbox = document.getElementById('privacyPolicyCheck');
            const checkoutButton = document.getElementById('goToCheckout');

            // PHP values to JS
            const tourId = <?php echo (int)$tour_id; ?>;
            const adultPricePerPerson = <?php echo $tour['adult_price'] ?? 0; ?>;
            const childPricePerPerson = <?php echo $tour['kids_price'] ?? 0; ?>;
            const maximumAdultCount = <?php echo (int)($tour['maximum_adult_count'] ?? 0); ?>;
            const maximumKidsCount = <?php echo (int)($tour['maximum_kids_count'] ?? 0); ?>;

            // 3. Price Update Function
            function updatePrices() {
                const adults = parseInt(adultCount.value);
                const children = parseInt(childCount.value);

                const adultTotal = adults * adultPricePerPerson;
                const childTotal = children * childPricePerPerson;
                const total = adultTotal + childTotal;

                adultPrice.textContent = '$' + adultTotal.toFixed(2);
                childPrice.textContent = '$' + childTotal.toFixed(2);
                totalPrice.textContent = '$' + total.toFixed(2);

                // Update LKR equivalent
                updateLKRPrice(total);

                // Show/hide child price row
                if (children > 0) {
                    childPriceRow.style.display = 'flex';
                    childPriceRow.querySelector('span:first-child').textContent = `Children (${children} x $${childPricePerPerson.toFixed(2)})`;
                } else {
                    childPriceRow.style.display = 'none';
                }

                // Update adult price text
                adultPrice.parentElement.querySelector('span:first-child').textContent = `Adults (${adults} x $${adultPricePerPerson.toFixed(2)})`;

                updatePaidAmountPlaceholder();
                updatePaidDisplays();
            }

            // 4. Currency & Advance Logic
            let usdToLkrRate = 320; // Default
            let advancePercentage = 100; // Default
            window.usdToLkrRate = usdToLkrRate;
            window.advancePercentage = advancePercentage;

            function formatUSD(amount) { return '$' + Number(amount).toFixed(2); }
            function formatLKR(amount) { return 'Rs. ' + Number(amount).toFixed(2); }

            async function fetchExchangeRate() {
                try {
                    const response = await fetch('../assets/process/getCurrencyRate.php');
                    const data = await response.json();
                    if (data.success) usdToLkrRate = data.rate;
                    updateLKRPrice(parseFloat(totalPrice.textContent.replace('$', '')));
                } catch (error) {
                    console.error('Error fetching exchange rate:', error);
                }
            }

            function updateLKRPrice(usdAmount) {
                if (usdToLkrRate > 0) {
                    const lkrAmount = usdAmount * usdToLkrRate;
                    document.getElementById('totalPriceLKR').textContent = 'Rs. ' + lkrAmount.toFixed(2);
                } else {
                    document.getElementById('totalPriceLKR').textContent = 'Loading...';
                }
            }

            async function fetchAdvancePercentage() {
                try {
                    const response = await fetch('../assets/process/getAdvancePercentage.php');
                    const data = await response.json();
                    if (data.success) {
                        advancePercentage = parseInt(data.value) || 30;
                        updatePaidAmountPlaceholder();
                    }
                } catch (error) {
                    console.error('Error fetching advance percentage:', error);
                }
            }

            function updatePaidAmountPlaceholder() {
                const totalUSD = parseFloat(totalPrice.textContent.replace('$', ''));
                const minAdvance = (totalUSD * (advancePercentage / 100));
                
                paidAmountInput.placeholder = `Min ${formatUSD(minAdvance)} (${advancePercentage}% of total)`;
                paidAmountInput.min = minAdvance;

                const advanceText = document.querySelector('small.fw-medium span.text-danger');
                if (advanceText) {
                    advanceText.textContent = `${formatUSD(minAdvance)} (${advancePercentage}% of total)`;
                }

                if (!paidAmountInput.dataset.userEdited) {
                    paidAmountInput.value = minAdvance.toFixed(2);
                    updatePaidDisplays();
                }
            }

            function updatePaidDisplays() {
                const paidUSD = parseFloat(paidAmountInput.value || 0);
                const totalUSD = parseFloat(totalPrice.textContent.replace('$', ''));
                const minAdvance = totalUSD * (advancePercentage / 100);

                if (paidUSD < minAdvance) {
                    paidAmountInput.setCustomValidity(`Minimum payment is ${formatUSD(minAdvance)}`);
                } else if (paidUSD > totalUSD) {
                    paidAmountInput.setCustomValidity(`Maximum payment is ${formatUSD(totalUSD)}`);
                    paidAmountInput.value = totalUSD.toFixed(2);
                } else {
                    paidAmountInput.setCustomValidity('');
                }

                const paidLKR = paidUSD * usdToLkrRate;
                const totalLKR = totalUSD * usdToLkrRate;
                const balanceLKR = Math.max(0, totalLKR - paidLKR);

                document.getElementById('paidLKR').textContent = formatLKR(paidLKR);
                document.getElementById('balanceLKR').textContent = formatLKR(balanceLKR);
                document.getElementById('totalPriceLKR').textContent = formatLKR(totalLKR);
            }

            function getSelectedTimeSlot() {
                const selected = document.querySelector('input[name="timeSlot"]:checked');
                return selected ? selected.value : '';
            }

            // 5. Button Click Handlers (Plus/Minus)
            function updateButtonsState() {
                const currentAdults = parseInt(adultCount.value);
                const currentKids = parseInt(childCount.value);

                adultMinus.disabled = currentAdults <= 1;
                if (maximumAdultCount > 0) adultPlus.disabled = currentAdults >= maximumAdultCount;
                
                childMinus.disabled = currentKids <= 0;
                if (maximumKidsCount > 0) childPlus.disabled = currentKids >= maximumKidsCount;
            }

            adultPlus.addEventListener('click', function() {
                const current = parseInt(adultCount.value);
                if (maximumAdultCount === 0 || current < maximumAdultCount) {
                    adultCount.value = current + 1;
                    updatePrices();
                    updateButtonsState();
                }
            });

            adultMinus.addEventListener('click', function() {
                const current = parseInt(adultCount.value);
                if (current > 1) {
                    adultCount.value = current - 1;
                    updatePrices();
                    updateButtonsState();
                }
            });

            childPlus.addEventListener('click', function() {
                const current = parseInt(childCount.value);
                if (maximumKidsCount === 0 || current < maximumKidsCount) {
                    childCount.value = current + 1;
                    updatePrices();
                    updateButtonsState();
                }
            });

            childMinus.addEventListener('click', function() {
                const current = parseInt(childCount.value);
                if (current > 0) {
                    childCount.value = current - 1;
                    updatePrices();
                    updateButtonsState();
                }
            });

            paidAmountInput.addEventListener('input', function() {
                this.dataset.userEdited = '1';
                updatePaidDisplays();
            });

            // 6. Privacy Policy Checkbox
            privacyCheckbox.addEventListener('change', function() {
                checkoutButton.disabled = !this.checked;
                if (this.checked) {
                    checkoutButton.classList.remove('btn-secondary');
                    checkoutButton.classList.add('btn-primary');
                } else {
                    checkoutButton.classList.remove('btn-primary');
                    checkoutButton.classList.add('btn-secondary');
                }
            });

            // 7. Initialize
            updatePrices();
            updateButtonsState();
            fetchExchangeRate();
            fetchAdvancePercentage();

            const today = new Date().toISOString().split('T')[0];
            document.getElementById('tourDate').setAttribute('min', today);

            // Add validation when date is selected
            document.getElementById('tourDate').addEventListener('change', async function() {
                const selectedDate = this.value;
                if (!selectedDate) return;

                const result = await checkClosedDay(selectedDate);
                
                if (result.success && result.isClosed) {
                    notyf.error(result.message || 'This date is not available for bookings');
                    this.value = ''; // Clear the invalid date
                    checkoutButton.disabled = true;
                } else if (result.success && !result.isClosed) {
                    notyf.success('Date is available for booking');
                    // Re-check if checkbox is checked to enable button
                    if (privacyCheckbox.checked) {
                        checkoutButton.disabled = false;
                    }

                    // If a time slot is already selected, validate it for this date
                    const currentTimeSlot = getSelectedTimeSlot();
                    if (currentTimeSlot) {
                        const slotResult = await checkSlotAvailability(selectedDate, currentTimeSlot);
                        if (slotResult.success && slotResult.isAvailable) {
                            if (privacyCheckbox.checked) {
                                checkoutButton.disabled = false;
                            }
                        } else if (slotResult.success && !slotResult.isAvailable) {
                            notyf.error(slotResult.message || 'This time slot is already booked for the selected date');
                            const checkedSlot = document.querySelector('input[name="timeSlot"]:checked');
                            if (checkedSlot) checkedSlot.checked = false;
                            checkoutButton.disabled = true;
                        } else {
                            notyf.error(slotResult.message || 'Unable to verify time slot availability');
                            checkoutButton.disabled = true;
                        }
                    }
                } else {
                    notyf.error(result.message || 'Unable to verify date availability');
                    this.value = '';
                }
            });

            // Validate time slot whenever user selects one
            document.querySelectorAll('input[name="timeSlot"]').forEach(function(radio) {
                radio.addEventListener('change', async function() {
                    const selectedDate = document.getElementById('tourDate').value;
                    if (!selectedDate) {
                        notyf.error('Please select a date first');
                        this.checked = false;
                        return;
                    }

                    const result = await checkSlotAvailability(selectedDate, this.value);
                    if (result.success && result.isAvailable) {
                        notyf.success('Time slot available');
                        if (privacyCheckbox.checked) {
                            checkoutButton.disabled = false;
                        }
                    } else if (result.success && !result.isAvailable) {
                        notyf.error(result.message || 'This time slot is already booked for the selected date');
                        this.checked = false;
                        checkoutButton.disabled = true;
                    } else {
                        notyf.error(result.message || 'Unable to verify time slot availability');
                        this.checked = false;
                        checkoutButton.disabled = true;
                    }
                });
            });

            // =========================================================
            // 8. PAYHERE CHECKOUT LOGIC (MERGED INSIDE DOMCONTENTLOADED)
            // =========================================================
            checkoutButton.addEventListener('click', async function() {
                
                // 1. First check if date is closed (PRIORITY VALIDATION)
                const selectedDate = document.getElementById('tourDate').value;
                if (!selectedDate) {
                    notyf.error('Please select a tour date');
                    return;
                }

                const closedDayCheck = await checkClosedDay(selectedDate);
                if (closedDayCheck.success && closedDayCheck.isClosed) {
                    notyf.error(closedDayCheck.message || 'This date is not available for bookings. Please select another date.');
                    document.getElementById('tourDate').value = '';
                    return;
                } else if (!closedDayCheck.success) {
                    notyf.error(closedDayCheck.message || 'Unable to verify date availability. Please try again.');
                    return;
                }

                // 2. Check time slot selection and availability
                const selectedTimeSlot = getSelectedTimeSlot();
                if (!selectedTimeSlot) {
                    notyf.error('Please select a time slot');
                    return;
                }

                const slotCheck = await checkSlotAvailability(selectedDate, selectedTimeSlot);
                if (slotCheck.success && !slotCheck.isAvailable) {
                    notyf.error(slotCheck.message || 'This time slot is already booked. Please choose another.');
                    return;
                } else if (!slotCheck.success) {
                    notyf.error(slotCheck.message || 'Unable to verify time slot availability. Please try again.');
                    return;
                }
                
                // 3. Form Validation Check
                const form = document.getElementById('bookingForm');
                if (!form.checkValidity()) {
                    form.reportValidity(); // Show default HTML5 validation errors
                    return;
                }

                checkoutButton.disabled = true;
                checkoutButton.innerHTML = 'Processing...';

                const formData = new FormData(form);
                formData.append('paidAmount', paidAmountInput.value);
                formData.append('tour_id', '<?php echo $tour_id; ?>');

                // Call submit_booking.php (Same folder)
                fetch('submit_booking.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const payment = data.payhere_data;

                        payhere.onCompleted = function onCompleted(orderId) {
                            window.location.href = payment.return_url;
                        };

                        payhere.onDismissed = function onDismissed() {
                            checkoutButton.disabled = false;
                            checkoutButton.innerHTML = 'Go to Checkout';
                        };

                        payhere.onError = function onError(error) {
                            console.log("Error:" + error);
                            alert("Payment Error: " + error);
                            checkoutButton.disabled = false;
                            checkoutButton.innerHTML = 'Go to Checkout';
                        };

                        // Start PayHere Payment
                        payhere.startPayment(payment);

                    } else {
                        alert('Error processing booking: ' + (data.message || 'Unknown error'));
                        checkoutButton.disabled = false;
                        checkoutButton.innerHTML = 'Go to Checkout';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Network Error');
                    checkoutButton.disabled = false;
                    checkoutButton.innerHTML = 'Go to Checkout';
                });
            });

        });
    </script>

    <script>
        (function() {
            const input = document.querySelector("#number3");
            if (!input) return;
            window.iti = window.intlTelInput(input, {
                initialCountry: "lk", 
                separateDialCode: true, 
                utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@18.5.1/build/js/utils.js"
            });
        })();
    </script>

</body>

</html>