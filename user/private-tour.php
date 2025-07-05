<?php
$tour_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
include 'assets/process/fetchTour.php';
?>
<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>BLAZE TOURS - Service Details</title>
    <meta name="author" content="Tourm">
    <meta name="description" content="Tourm - Travel & Tour Booking Agency HTML Template ">
    <meta name="keywords" content="Tourm - Travel & Tour Booking Agency HTML Template ">
    <meta name="robots" content="INDEX,FOLLOW">

    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Favicons - Place favicon.ico in the root directory -->
    <link rel="apple-touch-icon" sizes="57x57" href="assets/img/favicons/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="assets/img/favicons/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="assets/img/favicons/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="assets/img/favicons/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="assets/img/favicons/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="assets/img/favicons/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="assets/img/favicons/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="assets/img/favicons/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="assets/img/favicons/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="assets/img/favicons/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/img/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="assets/img/favicons/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/img/favicons/favicon-16x16.png">
    <link rel="manifest" href="assets/img/favicons/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="assets/img/favicons/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

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
    Sidemenu
============================== -->
    <div class="sidemenu-wrapper sidemenu-info ">
        <div class="sidemenu-content">
            <button class="closeButton sideMenuCls"><i class="far fa-times"></i></button>
            <div class="widget  ">
                <div class="th-widget-about">
                    <div class="about-logo">
                        <a href="home-travel.php"><img src="assets/img/logo2.svg" alt="Tourm"></a>
                    </div>
                    <p class="about-text">Rapidiously myocardinate cross-platform intellectual capital model. Appropriately create interactive infrastructures</p>
                    <div class="th-social">
                        <a href="https://www.facebook.com/"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://www.twitter.com/"><i class="fab fa-twitter"></i></a>
                        <a href="https://www.linkedin.com/"><i class="fab fa-linkedin-in"></i></a>
                        <a href="https://www.whatsapp.com/"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>
            </div>
            <div class="widget  ">
                <h3 class="widget_title">Recent Posts</h3>
                <div class="recent-post-wrap">
                    <div class="recent-post">
                        <div class="media-img">
                            <a href="blog-details.php"><img src="assets/img/blog/recent-post-1-1.jpg" alt="Blog Image"></a>
                        </div>
                        <div class="media-body">
                            <div class="recent-post-meta">
                                <a href="blog.php"><i class="far fa-calendar"></i>24 Jun , 2024</a>
                            </div>
                            <h4 class="post-title"><a class="text-inherit" href="blog-details.php">Where Vision Meets Concrete
                                    Reality</a></h4>
                        </div>
                    </div>
                    <div class="recent-post">
                        <div class="media-img">
                            <a href="blog-details.php"><img src="assets/img/blog/recent-post-1-2.jpg" alt="Blog Image"></a>
                        </div>
                        <div class="media-body">
                            <div class="recent-post-meta">
                                <a href="blog.php"><i class="far fa-calendar"></i>22 Jun , 2024</a>
                            </div>
                            <h4 class="post-title"><a class="text-inherit" href="blog-details.php">Raising the Bar in Construction.</a></h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="widget  ">
                <h3 class="widget_title">Get In Touch</h3>
                <div class="th-widget-contact">
                    <div class="info-box_text">
                        <div class="icon">
                            <img src="assets/img/icon/phone.svg" alt="img">
                        </div>
                        <div class="details">
                            <p><a href="tel:+01234567890" class="info-box_link">+01 234 567 890</a></p>
                            <p><a href="tel:+09876543210" class="info-box_link">+09 876 543 210</a></p>
                        </div>
                    </div>
                    <div class="info-box_text">
                        <div class="icon">
                            <img src="assets/img/icon/envelope.svg" alt="img">
                        </div>
                        <div class="details">
                            <p><a href="mailto:mailinfo00@tourm.com" class="info-box_link">mailinfo00@tourm.com</a></p>
                            <p><a href="mailto:support24@tourm.com" class="info-box_link">support24@tourm.com</a></p>
                        </div>
                    </div>
                    <div class="info-box_text">
                        <div class="icon"><img src="assets/img/icon/location-dot.svg" alt="img"></div>
                        <div class="details">
                            <p>789 Inner Lane, Holy park, California, USA</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="popup-search-box">
        <button class="searchClose"><i class="fal fa-times"></i></button>
        <form action="#">
            <input type="text" placeholder="What are you looking for?">
            <button type="submit"><i class="fal fa-search"></i></button>
        </form>
    </div><!--==============================
    Mobile Menu
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
                                <iframe src="https://www.google.com/maps/d/embed?mid=1Q_k3EFU6t3kuax-TL6eEfp4O0MUmw_I&hl=si&ehbc=2E312F" width="640" height="480"></iframe>
                            </div>
                        </div>
                        <div class="destination-gallery-wrapper">
                            <h3 class="page-title mt-30 mb-30">From our gallery</h3>
                            <div class="row gy-4 gallery-row filter-active">
                                <div class="col-xxl-auto filter-item">
                                    <div class="gallery-box style3">
                                        <div class="gallery-img global-img">
                                            <img src="assets/img/gallery/gallery_6_1.jpg" alt="gallery image">
                                            <a href="assets/img/gallery/gallery_6_1.jpg" class="icon-btn popup-image"><i class="fal fa-magnifying-glass-plus"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-auto filter-item">
                                    <div class="gallery-box style3">
                                        <div class="gallery-img global-img">
                                            <img src="assets/img/gallery/gallery_6_2.jpg" alt="gallery image">
                                            <a href="assets/img/gallery/gallery_6_2.jpg" class="icon-btn popup-image"><i class="fal fa-magnifying-glass-plus"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-auto filter-item">
                                    <div class="gallery-box style3">
                                        <div class="gallery-img global-img">
                                            <img src="assets/img/gallery/gallery_6_3.jpg" alt="gallery image">
                                            <a href="assets/img/gallery/gallery_6_3.jpg" class="icon-btn popup-image"><i class="fal fa-magnifying-glass-plus"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-auto filter-item">
                                    <div class="gallery-box style3">
                                        <div class="gallery-img global-img">
                                            <img src="assets/img/gallery/gallery_6_4.jpg" alt="gallery image">
                                            <a href="assets/img/gallery/gallery_6_4.jpg" class="icon-btn popup-image"><i class="fal fa-magnifying-glass-plus"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="th-comments-wrap style2 ">
                            <h2 class="blog-inner-title h4">Reviews (3)</h2>
                            <ul class="comment-list">
                                <li class="th-comment-item">
                                    <div class="th-post-comment">
                                        <div class="comment-avater">
                                            <img src="assets/img/blog/comment-author-1.jpg" alt="Comment Author">
                                        </div>
                                        <div class="comment-content">
                                            <h3 class="name">Adam Jhon</h3>
                                            <div class="commented-wrapp">
                                                <span class="commented-on">20 Jun, 2024</span>
                                                <span class="commented-time">08:56pm </span>
                                                <span class="comment-review">
                                                    <i class="fa-solid fa-star"></i>
                                                    <i class="fa-solid fa-star"></i>
                                                    <i class="fa-solid fa-star"></i>
                                                    <i class="fa-solid fa-star"></i>
                                                    <i class="fa-solid fa-star"></i>
                                                </span>
                                            </div>
                                            <p class="text">Credibly pontificate transparent quality vectors with quality mindshare. Efficiently
                                                architect worldwide strategic theme areas after user.</p>
                                            <div class="reply_and_edit">
                                                <i class="fa-solid fa-thumbs-up"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <ul class="children">
                                        <li class="th-comment-item">
                                            <div class="th-post-comment">
                                                <div class="comment-avater">
                                                    <img src="assets/img/blog/comment-author-4.jpg" alt="Comment Author">
                                                </div>
                                                <div class="comment-content">
                                                    <div class="">
                                                        <h3 class="name">Maria Willson</h3>
                                                        <div class="commented-wrapp">
                                                            <span class="commented-on">23 Jun, 2024</span>
                                                            <span class="commented-time">08:56pm </span>
                                                            <span class="comment-review">
                                                                <i class="fa-solid fa-star"></i>
                                                                <i class="fa-solid fa-star"></i>
                                                                <i class="fa-solid fa-star"></i>
                                                                <i class="fa-solid fa-star"></i>
                                                                <i class="fa-solid fa-star"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <p class="text">It is different from airport transfer or port transfer, which are services
                                                        that pick you up</p>
                                                    <div class="reply_and_edit">
                                                        <i class="fa-solid fa-thumbs-up"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </li>
                                <li class="th-comment-item">
                                    <div class="th-post-comment">
                                        <div class="comment-avater">
                                            <img src="assets/img/blog/comment-author-5.jpg" alt="Comment Author">
                                        </div>
                                        <div class="comment-content">
                                            <div class="">
                                                <h3 class="name">Michel Edwards</h3>
                                                <div class="commented-wrapp">
                                                    <span class="commented-on">27 Jun, 2024</span>
                                                    <span class="commented-time">08:56pm </span>
                                                    <span class="comment-review">
                                                        <i class="fa-solid fa-star"></i>
                                                        <i class="fa-solid fa-star"></i>
                                                        <i class="fa-solid fa-star"></i>
                                                        <i class="fa-solid fa-star"></i>
                                                        <i class="fa-solid fa-star"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            <p class="text">Credibly pontificate transparent quality vectors with quality mindshare. Efficiently
                                                architect worldwide strategic theme areas after user.</p>
                                            <div class="reply_and_edit">
                                                <i class="fa-solid fa-thumbs-up"></i>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div> <!-- Comment end --> <!-- Comment Form -->
                        <div class="th-comment-form ">
                            <div class="row">
                                <h3 class="blog-inner-title h4 mb-2">Leave a Reply</h3>
                                <p class="mb-25">Your email address will not be published. Required fields are marked</p>
                                <div class="col-md-6 form-group">
                                    <input type="text" placeholder="Full Name*" class="form-control" required>
                                    <i class="far fa-user"></i>
                                </div>
                                <div class="col-md-6 form-group">
                                    <input type="text" placeholder="Your Email*" class="form-control" required>
                                    <i class="far fa-envelope"></i>
                                </div>
                                <div class="col-12 form-group">
                                    <input type="text" placeholder="Website" class="form-control" required>
                                    <i class="far fa-globe"></i>
                                </div>
                                <div class="col-12 form-group">
                                    <textarea placeholder="Comment*" class="form-control"></textarea>
                                    <i class="far fa-pencil"></i>
                                </div>
                                <div class="col-12 form-group">
                                    <input type="checkbox" id="html">
                                    <label for="html">Save my name, email, and website in this browser for the next time I
                                        comment.</label>
                                </div>
                                <div class="col-12 form-group mb-0">
                                    <button class="th-btn">Send Message<img src="assets/img/icon/plane2.svg" alt=""></button>
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
                            <a href="contact.php" class="th-btn th-icon">Book Now</a>
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
    <!--********************************
			Code End  Here 
	******************************** -->

    <!-- Scroll To Top -->
    <div class="scroll-top">
        <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" style="transition: stroke-dashoffset 10ms linear 0s; stroke-dasharray: 307.919, 307.919; stroke-dashoffset: 307.919;">
            </path>
        </svg>
    </div>
    <!--==============================
modal Area  
==============================-->
    <div id="login-form" class="popup-login-register mfp-hide">
        <ul class="nav" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-menu" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="false">Login</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-menu active" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="true">Register</button>
            </li>
        </ul>
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                <h3 class="box-title mb-30">Sign in to your account</h3>
                <div class="th-login-form">
                    <form action="mail.php" method="POST" class="login-form ajax-contact">
                        <div class="row">
                            <div class="form-group col-12">
                                <label>Username or email</label>
                                <input type="text" class="form-control" name="email" id="email" required="required">
                            </div>
                            <div class="form-group col-12">
                                <label>Password</label>
                                <input type="password" class="form-control" name="pasword" id="pasword" required="required">
                            </div>

                            <div class="form-btn mb-20 col-12">
                                <button class="th-btn btn-fw th-radius2 ">Send Message</button>
                            </div>
                        </div>
                        <div id="forgot_url">
                            <a href="my-account.php">Forgot password?</a>
                        </div>
                        <p class="form-messages mb-0 mt-3"></p>
                    </form>
                </div>
            </div>
            <div class="tab-pane fade active show" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                <h3 class="th-form-title mb-30">Sign in to your account</h3>
                <form action="mail.php" method="POST" class="login-form ajax-contact">
                    <div class="row">
                        <div class="form-group col-12">
                            <label>Username*</label>
                            <input type="text" class="form-control" name="usename" id="usename" required="required">
                        </div>
                        <div class="form-group col-12">
                            <label>First name*</label>
                            <input type="text" class="form-control" name="firstname" id="firstname" required="required">
                        </div>
                        <div class="form-group col-12">
                            <label>Last name*</label>
                            <input type="text" class="form-control" name="lastname" id="lastname" required="required">
                        </div>
                        <div class="form-group col-12">
                            <label for="new_email">Your email*</label>
                            <input type="text" class="form-control" name="new_email" id="new_email" required="required">
                        </div>
                        <div class="form-group col-12">
                            <label for="new_email_confirm">Confirm email*</label>
                            <input type="text" class="form-control" name="new_email_confirm" id="new_email_confirm" required="required">
                        </div>
                        <div class="statement">
                            <span class="register-notes">A password will be emailed to you.</span>
                        </div>

                        <div class="form-btn mt-20 col-12">
                            <button class="th-btn btn-fw th-radius2 ">Sign up</button>
                        </div>
                    </div>
                    <p class="form-messages mb-0 mt-3"></p>
                </form>
            </div>
        </div>
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