<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Sri Lanka Tour Packages | Blaze Tours (Pvt) Ltd</title>
    <meta name="description" content="Discover Colombo city tours, tuk tuk safaris, cultural trips, and private Sri Lanka tour packages with Blaze Tours (Pvt) Ltd.">
    <meta name="keywords" content="Sri Lanka tour packages, Colombo tours, tuk tuk safari Sri Lanka, Blaze Tours">
    <meta name="robots" content="index,follow">

    <meta property="og:title" content="Sri Lanka Tour Packages | Blaze Tours (Pvt) Ltd">
    <meta property="og:description" content="Private and custom Sri Lanka tour packages including Colombo city tours and tuk tuk safaris.">
    <meta property="og:url" content="https://blaze-tours.com/user/tours.php">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Sri Lanka Tour Packages | Blaze Tours">
    <meta name="twitter:description" content="Explore private Sri Lanka tour packages with Blaze Tours (Pvt) Ltd.">
    <meta name="twitter:image" content="https://blaze-tours.com/user/assets/img/preview.png">


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

</head>

<body>

    <!--==============================
     Preloader
  ==============================-->
    <!-- <div id="preloader" class="preloader ">
        <button class="th-btn preloaderCls">Cancel Preloader </button>
        <div class="preloader-inner">
            <img src="assets/img/logo3.svg" alt="">
        </div>

        <div id="loader" class="th-preloader">
            <div class="animation-preloader">
                <div class="txt-loading">
                    <span preloader-text="T" class="characters">T </span>

                    <span preloader-text="O" class="characters">O </span>

                    <span preloader-text="U" class="characters">U </span>

                    <span preloader-text="R" class="characters">R </span>

                    <span preloader-text="M" class="characters">M </span>
                </div>
            </div>
        </div>

    </div>  -->

    <!--==============================
    Header Area
============================== -->

    <?php include 'header.php'; ?>

    <div class="breadcumb-wrapper " data-bg-src="assets/img/bg/tours-bg.jpg">
        <div class="container">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title">All Tours</h1>
                <ul class="breadcumb-menu">
                    <li><a href="home-travel.html">Home</a></li>
                    <li>All Tours</li>
                </ul>
            </div>
        </div>
    </div>

    <!--==============================
Product Area
==============================-->
    <section class="space">
        <div class="container">
            <div class="th-sort-bar">
                <div class="row justify-content-between align-items-center">
                    <div class="col-md-4">
                        <div class="search-form-area">
                            <form class="search-form" method="get" action="tours.php">
                                <?php
                                // Preserve params except search and page
                                foreach ($_GET as $key => $value) {
                                    if ($key === 'search' || $key === 'page') {
                                        continue;
                                    }
                                    echo '<input type="hidden" name="' . htmlspecialchars($key) . '" value="' . htmlspecialchars($value) . '">';
                                }
                                echo '<input type="hidden" name="page" value="1">';
                                $currentSearch = isset($_GET['search']) ? $_GET['search'] : '';
                                ?>
                                <input type="text" name="search" value="<?php echo htmlspecialchars($currentSearch); ?>" placeholder="Search by tour name">
                                <button type="submit"><i class="fa-light fa-magnifying-glass"></i></button>
                            </form>
                        </div>
                    </div>

                    <div class="col-md-auto">
                        <div class="sorting-filter-wrap">
                            <div class="nav" role="tablist">
                                <a class="active" href="#" id="tab-destination-grid" data-bs-toggle="tab" data-bs-target="#tab-grid" role="tab" aria-controls="tab-grid" aria-selected="true"><i class="fa-light fa-grid-2"></i></a>

                                <a href="#" id="tab-destination-list" data-bs-toggle="tab" data-bs-target="#tab-list" role="tab" aria-controls="tab-list" aria-selected="false" class=""><i class="fa-solid fa-list"></i></a>
                            </div>
                            <form class="woocommerce-ordering" method="get">
                                <?php
                                // Preserve existing query params except orderby and page (we reset page on sort)
                                foreach ($_GET as $key => $value) {
                                    if ($key === 'orderby' || $key === 'page') {
                                        continue;
                                    }
                                    echo '<input type="hidden" name="' . htmlspecialchars($key) . '" value="' . htmlspecialchars($value) . '">';
                                }
                                echo '<input type="hidden" name="page" value="1">';
                                $currentOrder = isset($_GET['orderby']) ? $_GET['orderby'] : 'menu_order';
                                ?>
                                <select name="orderby" class="orderby" aria-label="destination order" onchange="this.form.submit()">
                                    <option value="menu_order" <?php echo ($currentOrder === 'menu_order') ? 'selected' : ''; ?>>Default Sorting</option>
                                    <option value="popularity" <?php echo ($currentOrder === 'popularity') ? 'selected' : ''; ?>>Sort by popularity</option>
                                    <option value="rating" <?php echo ($currentOrder === 'rating') ? 'selected' : ''; ?>>Sort by average rating</option>
                                    <option value="date" <?php echo ($currentOrder === 'date') ? 'selected' : ''; ?>>Sort by latest</option>
                                    <option value="price" <?php echo ($currentOrder === 'price') ? 'selected' : ''; ?>>Sort by price: low to high</option>
                                    <option value="price-desc" <?php echo ($currentOrder === 'price-desc') ? 'selected' : ''; ?>>Sort by price: high to low</option>
                                </select>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-xxl-8 col-lg-7">
                    <div class="tab-content" id="nav-tabContent">


                        <?php
                        require_once 'assets/process/connection.php';

                        // Pagination setup
                        $limit = 10;
                        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                        if ($page < 1) {
                            $page = 1;
                        }
                        $offset = ($page - 1) * $limit;

                        // Base WHERE clause (extend later if filters are added)
                        $whereClause = "WHERE t.status_id = 1";

                        // Filter by category (tours_type)
                        $typeFilter = null;
                        if (isset($_GET['type']) && is_numeric($_GET['type'])) {
                            $typeFilter = (int)$_GET['type'];
                            if ($typeFilter > 0) {
                                $whereClause .= " AND t.tours_type_id = $typeFilter";
                            }
                        }

                        // Filter by duration
                        if (isset($_GET['duration']) && is_numeric($_GET['duration'])) {
                            $duration = (int)$_GET['duration'];
                            if ($duration > 0) {
                                $whereClause .= " AND t.duration = $duration";
                            }
                        }

                        // Search by tour name
                        $searchTerm = '';
                        if (isset($_GET['search']) && $_GET['search'] !== '') {
                            $searchTerm = Database::escape_string($_GET['search']);
                            $whereClause .= " AND t.name LIKE '%$searchTerm%'";
                        }

                        // Sorting setup
                        $orderby = isset($_GET['orderby']) ? $_GET['orderby'] : 'menu_order';
                        switch ($orderby) {
                            case 'price':
                                $orderBySql = "ORDER BY t.adult_price ASC";
                                break;
                            case 'price-desc':
                                $orderBySql = "ORDER BY t.adult_price DESC";
                                break;
                            case 'date':
                                // Assuming higher id == newer; adjust to created_at if available
                                $orderBySql = "ORDER BY t.id DESC";
                                break;
                            case 'rating':
                            case 'popularity':
                                // No explicit columns; fallback to name
                                $orderBySql = "ORDER BY t.name ASC";
                                break;
                            case 'menu_order':
                            default:
                                $orderBySql = "ORDER BY t.id ASC";
                        }

                        // Count total tours
                        $totalTours = 0;
                        try {
                            $countQuery = "SELECT COUNT(*) AS total FROM tour t $whereClause";
                            $countResult = Database::search($countQuery);
                            if ($countRow = $countResult->fetch_assoc()) {
                                $totalTours = (int)$countRow['total'];
                            }
                        } catch (Exception $e) {
                            $totalTours = 0;
                        }

                        $totalPages = ($totalTours > 0) ? (int)ceil($totalTours / $limit) : 1;
                        if ($page > $totalPages) {
                            $page = $totalPages;
                            $offset = ($page - 1) * $limit;
                        }

                        // Fetch paginated tours
                        $tours = [];
                        try {
                            $query = "SELECT t.id, t.name, t.description, t.duration, t.adult_price, t.tours_type_id, ti.main_image
              FROM tour t
              LEFT JOIN tour_image ti ON t.id = ti.tour_id
              $whereClause
              $orderBySql
              LIMIT $limit OFFSET $offset";
                            $result = Database::search($query);
                            while ($row = $result->fetch_assoc()) {
                                $tours[] = $row;
                            }
                        } catch (Exception $e) {
                            // Error handling
                        }

                        // Helper to build pagination URLs preserving existing query params
                        function buildPageUrl($pageNumber)
                        {
                            $params = $_GET;
                            $params['page'] = $pageNumber;
                            $qs = http_build_query($params);
                            return 'tours.php' . ($qs ? ('?' . $qs) : '');
                        }
                        ?>


                        <div class="tab-pane fade active show" id="tab-grid" role="tabpanel" aria-labelledby="tab-tour-grid">
                            <div class="row gy-24 gx-24">

                                <!-- Tour Card -->
                                <?php if (empty($tours)): ?>
                                    <div class="col-12"></div>
                                        <div class="text-center py-5">
                                            <div class="mb-4">
                                                <i class="fa-light fa-search" style="font-size: 4rem; color: #ccc;"></i>
                                            </div>
                                            <h3 class="mb-3">No Tours Found</h3>
                                            <p class="text-muted mb-4">Sorry, we couldn't find any tours matching your search criteria.</p>
                                            <a href="tours.php" class="th-btn">View All Tours</a>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <?php foreach ($tours as $tour): ?>
                                    <div class="col-md-6">
                                        <div class="tour-box th-ani">
                                            <div class="tour-box_img global-img">

                                                <?php
                                                $main_image_name = '';
                                                if (!empty($tour['main_image'])) {
                                                    $main_image_name = basename($tour['main_image']);
                                                }
                                                ?>
                                                <img src="../admin/assets/uploads/tour_images/<?php echo $main_image_name ? $main_image_name : 'default.png'; ?>" alt="image">
                                            </div>
                                            <div class="tour-content">
                                                <h3 class="box-title">
                                                    <a href="tour-page/index.php?id=<?php echo $tour['id']; ?>">
                                                        <?php echo htmlspecialchars($tour['name']); ?>
                                                    </a>
                                                </h3>

                                                <div class="tour-rating">
                                                    <div class="star-rating" role="img" aria-label="Rated 5.00 out of 5"><span style="width:100%">Rated
                                                            <strong class="rating">5.00</strong> out of 5 based on <span class="rating">4.8</span>(4.8
                                                            Rating)</span></div>
                                                    <a href="tour-page/index.php?id=<?php echo $tour['id']; ?>" class="woocommerce-review-link">(<span class="count">4.8</span>
                                                        Rating)</a>
                                                </div>
                                                <h4 class="tour-box_price"><span class="currency">$<?php echo number_format($tour['adult_price'], 2); ?></span>/Per Person</h4>
                                                <div class="tour-action">
                                                    <span><i class="fa-light fa-clock"></i><?php echo (int)$tour['duration']; ?> <?php echo ($tour['tours_type_id'] == 8) ? 'Days' : 'Hours'; ?></span>
                                                    <a href="tour-page/index.php?id=<?php echo $tour['id']; ?>" class="th-btn style4">Detail View</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>

                            </div>
                        </div>

                        <div class="tab-pane fade " id="tab-list" role="tabpanel" aria-labelledby="tab-tour-list">
                            <div class="row gy-30">

                                <!-- Tour List Card -->
                                <?php if (empty($tours)): ?>
                                    <div class="col-12">
                                        <div class="text-center py-5">
                                            <div class="mb-4">
                                                <i class="fa-light fa-search" style="font-size: 4rem; color: #ccc;"></i>
                                            </div>
                                            <h3 class="mb-3">No Tours Found</h3>
                                            <p class="text-muted mb-4">Sorry, we couldn't find any tours matching your search criteria.</p>
                                            <a href="tours.php" class="th-btn">View All Tours</a>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <?php foreach ($tours as $tour): ?>

                                    <div class="col-12">
                                        <div class="tour-box style-flex th-ani">
                                            <div class="tour-box_img global-img">
                                                <?php
                                                $main_image_name = '';
                                                if (!empty($tour['main_image'])) {
                                                    $main_image_name = basename($tour['main_image']);
                                                }
                                                ?>
                                                <img src="../admin/assets/uploads/tour_images/<?php echo $main_image_name ? $main_image_name : 'default.png'; ?>" alt="image">
                                            </div>
                                            <div class="tour-content">
                                                <h3 class="box-title"><a href="tour-page/index.php?id=<?php echo $tour['id']; ?>"><?php echo htmlspecialchars($tour['name']); ?></a></h3>
                                                <div class="tour-rating">
                                                    <div class="star-rating" role="img" aria-label="Rated 5.00 out of 5"><span style="width:100%">Rated
                                                            <strong class="rating">5.00</strong> out of 5 based on <span class="rating">5.0</span>(5.0
                                                            Rating)</span></div>
                                                    <a href="tour-page/index.php?id=<?php echo $tour['id']; ?>" class="woocommerce-review-link">(<span class="count">5.0</span>
                                                        Rating)</a>
                                                </div>
                                                <h4 class="tour-box_price"><span class="currency">$<?php echo number_format($tour['adult_price'], 2); ?></span>/Per Person</h4>
                                                <div class="tour-action">
                                                    <span><i class="fa-light fa-clock"></i><?php echo (int)$tour['duration']; ?> <?php echo ($tour['tours_type_id'] == 8) ? 'Days' : 'Hours'; ?></span>
                                                    <a href="tour-page/index.php?id=<?php echo $tour['id']; ?>" class="th-btn style4">Detail View</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>

                            </div>
                        </div>
                        <?php if (!empty($tours)): ?>
                        <div class="th-pagination text-center mt-60">
                            <ul>
                                <?php if ($page > 1): ?>
                                    <li><a href="<?php echo htmlspecialchars(buildPageUrl($page - 1)); ?>">Prev</a></li>
                                <?php endif; ?>

                                <?php
                                // Simple numbered pagination
                                for ($i = 1; $i <= $totalPages; $i++):
                                    $isActive = ($i === $page) ? 'active' : '';
                                ?>
                                    <li><a class="<?php echo $isActive; ?>" href="<?php echo htmlspecialchars(buildPageUrl($i)); ?>"><?php echo $i; ?></a></li>
                                <?php endfor; ?>

                                <?php if ($page < $totalPages): ?>
                                    <li><a class="next-page" href="<?php echo htmlspecialchars(buildPageUrl($page + 1)); ?>">Next <img src="assets/img/icon/arrow-right4.svg" alt=""></a></li>
                                <?php endif; ?>
                            </ul>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-xxl-4 col-lg-5">
                    <aside class="sidebar-area">
                        <div class="widget widget_categories  ">
                            <h3 class="widget_title">Categories</h3>
                            <ul>
                                <!-- All -->
                                <?php
                                $allCurrentParams = $_GET;
                                $currentTypeIdAll = isset($_GET['type']) ? (int)$_GET['type'] : 0;
                                if (isset($allCurrentParams['type'])) { unset($allCurrentParams['type']); }
                                $allCurrentParams['page'] = 1;
                                $allQs = http_build_query($allCurrentParams);
                                $allUrl = 'tours.php' . ($allQs ? ('?' . $allQs) : '');
                                $isAllActive = ($currentTypeIdAll === 0);
                                ?>
                                <li>
                                    <a href="<?php echo htmlspecialchars($allUrl); ?>" <?php echo $isAllActive ? ' style="color:#bd3838"' : ''; ?>>
                                        <img src="assets/img/theme-img/map.svg" alt="">
                                        All
                                    </a>
                                </li>

                                <?php
                                require_once 'assets/process/connection.php';

                                $tours = [];
                                try {
                                    $query = "SELECT id, name FROM tours_type";
                                    $result = Database::search($query);
                                    while ($row = $result->fetch_assoc()) {
                                        $tours[] = $row;
                                    }
                                } catch (Exception $e) {
                                    // Error handling
                                }
                                ?>
                                <?php
                                $currentParams = $_GET;
                                $currentTypeId = isset($_GET['type']) ? (int)$_GET['type'] : 0;
                                foreach ($tours as $tour):
                                    $params = $currentParams;
                                    $params['type'] = $tour['id'];
                                    $params['page'] = 1; // reset pagination when changing category
                                    $qs = http_build_query($params);
                                    $url = 'tours.php' . ($qs ? ('?' . $qs) : '');
                                    $isActiveType = ($currentTypeId === (int)$tour['id']);
                                ?>
                                    <li>
                                        <a href="<?php echo htmlspecialchars($url); ?>" <?php echo $isActiveType ? ' style="color:#bd3838"' : ''; ?>>
                                            <img src="assets/img/theme-img/map.svg" alt="">
                                            <?php echo htmlspecialchars($tour['name']); ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>

                            </ul>
                        </div>


                        <div class="widget widget_offer  " data-bg-src="assets/img/normal/tour-contact.png">
                            <div class="offer-banner">
                                <div class="offer">
                                    <h6 class="box-title">Need Help? We Are Here To Help You</h6>
                                    <div class="banner-logo">
                                        <img src="assets/img/footer-logo.png" alt="blaze">
                                    </div>
                                    <div class="offer">
                                        <h6 class="offer-title">You Get Online support</h6>
                                        <a class="offter-num" href="+256214203215">+94 71 334 4399</a>
                                    </div>
                                    <a href="contact.php" class="th-btn style2 th-icon">Read More</a>
                                </div>
                            </div>
                        </div>
                    </aside>
                </div>

            </div>

        </div>
        <div class="shape-mockup shape1 d-none d-xxl-block" data-bottom="7%" data-right="8%">
            <img src="assets/img/shape/shape_1.png" alt="shape">
        </div>
        <div class="shape-mockup shape2 d-none d-xl-block" data-bottom="1%" data-right="7%">
            <img src="assets/img/shape/shape_2.png" alt="shape">
        </div>
        <div class="shape-mockup shape3 d-none d-xxl-block" data-bottom="2%" data-right="4%">
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
</body>

</html>