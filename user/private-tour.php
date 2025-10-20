<?php
$tour_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
include 'assets/process/fetchTour.php';
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
    <meta property="og:image" content="https://yourdomain.com/assets/img/preview.png">
    <meta property="og:url" content="https://blaze-tours.com/">
    <meta property="og:type" content="website">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Blaze Tours (Pvt) Ltd | Colombo & Sri Lanka Tours">
    <meta name="twitter:description" content="Explore stunning Colombo city and Sri Lanka tours with Blaze Tours (Pvt) Ltd. Book your adventure today!">
    <meta name="twitter:image" content="https://blaze-tours.com/assets/img/preview.png">

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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/css/intlTelInput.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/intlTelInput.min.js"></script>


    <!-- Custom Booking Modal CSS -->
    <style>
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
            border-top: 1px solid #e9ecef;
            padding: 1.5rem 2rem;
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
    </style>
</head>

<body>
    <!--==============================
     Preloader
  ==============================-->
    <!-- 
    <div id="preloader" class="preloader">
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
    </div> -->
    <!--==============================
   Header Area
  ============================== -->
    <?php include 'header.php'; ?>

    <!--==============================
    Breadcumb
============================== -->
    <div class="breadcumb-wrapper " data-bg-src="assets/img/bg/category_bg_1.png">
        <div class="container">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title">Single Tour Page</h1>
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
                            <img src="../admin/assets/uploads/tour_images/<?php echo $main_image_name ? $main_image_name : 'default.png'; ?>" alt="image">
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

                                <img src="../admin/assets/uploads/tour_images/<?php echo $second_image_name ? $second_image_name : 'default.png'; ?>" alt="image">
                            </div>
                        </div>
                        <div class="destination-gallery-wrapper col-12 order-1">
                            <h3 class="page-title mt-30 mb-30">Destination Map</h3>
                            <div class="row gy-4">
                                <iframe src="assets/process/livemapBody.php?id=<?php echo $tour_id; ?>" width="100%" height="480" style="border:0;"></iframe>
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
                                    $img = $gallery_items[$i] ?? ['url' => 'assets/img/gallery/gallery_6_' . ($i + 1) . '.jpg', 'title' => 'Default'];
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
                                    <button class="th-btn" type="button">Submit Review<img src="assets/img/icon/plane2.svg" alt=""></button>
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
            <img src="assets/img/shape/shape_1.png" alt="shape">
        </div>
        <div class="shape-mockup shape2 d-none d-xl-block" data-bottom="31%" data-right="8%">
            <img src="assets/img/shape/shape_2.png" alt="shape">
        </div>
        <div class="shape-mockup shape3 d-none d-xxl-block" data-bottom="33%" data-right="5%">
            <img src="assets/img/shape/shape_3.png" alt="shape">
        </div>
    </section><!--==============================
	Footer Area
==============================-->
    <?php include 'footer.php'; ?>


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
                            <small class="form-text text-muted">Start typing to see location suggestions</small>
                        </div>

                        <!-- Price Summary -->
                        <div class="mb-3">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title">Price Summary</h6>
                                    <div class="d-flex justify-content-between">
                                        <span>Adults (1 x $<?php echo number_format($tour['adult_price'] ?? 0, 2); ?>)</span>
                                        <span id="adultPrice">$<?php echo number_format($tour['adult_price'] ?? 0, 2); ?></span>
                                    </div>
                                    <div class="d-flex justify-content-between" id="childPriceRow" style="display: none;">
                                        <span>Children (0 x $<?php echo number_format($tour['kids_price'] ?? 0, 2); ?>)</span>
                                        <span id="childPrice">$0.00</span>
                                    </div>
                                    <hr>
                                    <div class="d-flex justify-content-between">
                                        <strong>Total Price</strong>
                                        <strong id="totalPrice">$<?php echo number_format($tour['adult_price'] ?? 0, 2); ?></strong>
                                    </div>
                                    <div class="d-flex justify-content-between text-muted small">
                                        <span>LKR Equivalent</span>
                                        <span id="totalPriceLKR">Loading...</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="goToCheckout">Go to Checkout</button>
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

    <!-- Intl-Tel-Input JS -->
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18.5.1/build/js/intlTelInput.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18.5.1/build/js/utils.js"></script>

    <!-- CryptoJS for MD5 hash generation -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.1.1/crypto-js.min.js"></script>

    <!-- nice select -->
    <script src="assets/js/nice-select.min.js"></script>

    <!-- Main Js File -->
    <script src="assets/js/main.js"></script>
    <script src="assets/js/review.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>

    <!-- PayHere SDK -->
    <script type="text/javascript" src="https://www.payhere.lk/lib/payhere.js"></script>

    <!-- Google Maps API - Replace YOUR_API_KEY with your actual Google Maps API key -->
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places&callback=initAutocomplete" async defer></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
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

            // Booking modal functionality
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

            const adultPricePerPerson = <?php echo $tour['adult_price'] ?? 0; ?>;
            const childPricePerPerson = <?php echo $tour['kids_price'] ?? 0; ?>;
            const maximumAdultCount = <?php echo (int)($tour['maximum_adult_count'] ?? 0); ?>;
            const maximumKidsCount = <?php echo (int)($tour['maximum_kids_count'] ?? 0); ?>;

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
            }

            // Currency conversion function
            let usdToLkrRate = 0;

            async function fetchExchangeRate() {
                try {
                    const response = await fetch('https://api.exchangerate-api.com/v4/latest/USD');
                    const data = await response.json();
                    usdToLkrRate = data.rates.LKR;
                    updateLKRPrice(parseFloat(totalPrice.textContent.replace('$', '')));
                } catch (error) {
                    console.error('Error fetching exchange rate:', error);
                    // Fallback rate if API fails
                    usdToLkrRate = 320;
                    updateLKRPrice(parseFloat(totalPrice.textContent.replace('$', '')));
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

            function updateButtonsState() {
                const currentAdults = parseInt(adultCount.value);
                const currentKids = parseInt(childCount.value);

                // Adults: min 1, max maximumAdultCount (if > 0)
                adultMinus.disabled = currentAdults <= 1;
                if (maximumAdultCount > 0) {
                    adultPlus.disabled = currentAdults >= maximumAdultCount;
                } else {
                    adultPlus.disabled = false;
                }

                // Kids: min 0, max maximumKidsCount (if > 0)
                childMinus.disabled = currentKids <= 0;
                if (maximumKidsCount > 0) {
                    childPlus.disabled = currentKids >= maximumKidsCount;
                } else {
                    childPlus.disabled = false;
                }
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

            // Initialize states
            updatePrices();
            updateButtonsState();
            fetchExchangeRate(); // Fetch exchange rate on page load

            // Set minimum date to today
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('tourDate').setAttribute('min', today);

            // click handler is implemented in assets/js/booking.js

        });
    </script>


    <script>
        // Make the intl-tel-input instance available globally as window.iti
        (function() {
          const input = document.querySelector("#number3");
          if (!input) return;
          window.iti = window.intlTelInput(input, {
              initialCountry: "lk", // default Sri Lanka
              separateDialCode: true, // show +94 separately
              utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@18.5.1/build/js/utils.js"
          });
        })();
    </script>

    <script>
        // Expose key tour variables globally for booking.js
        window.tour_id = <?php echo (int)$tour_id; ?>;
        window.tour_name = '<?php echo addslashes($tour['name'] ?? ''); ?>';
        window.adultPricePerPerson = <?php echo (float)($tour['adult_price'] ?? 0); ?>;
        window.childPricePerPerson = <?php echo (float)($tour['kids_price'] ?? 0); ?>;
        // PayHere configuration (sandbox true for testing)
        window.payhereSandbox = true; // set false on live
        window.payhereMerchantId = '1232435'; // TODO: replace with your live merchant id
        window.payhereReturnUrl = 'http://localhost/BLAZE-TOURS/user/payment_success.php';
        window.payhereCancelUrl = 'http://localhost/BLAZE-TOURS/user/payment_cancel.php';
        window.payhereNotifyUrl = 'http://localhost/BLAZE-TOURS/user/payment_notify.php';
    </script>
    <script src="assets/js/booking.js"></script>

    <!-- PayHere Callback Functions -->
    <script>
        // Do not override PayHere callbacks here — booking.js installs callbacks that
        // post to markPaid.php and perform the correct redirect. Keep a small log.
        if (typeof window.payhere !== 'undefined') {
            console.log('[payhere] callbacks handled by booking.js; no override from page.');
        }
    </script>
</body>

</html>