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
    <script src="assets/js/review.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>

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
        });
    </script>
</body>

</html>