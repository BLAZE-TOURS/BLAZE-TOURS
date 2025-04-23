<?php

session_start();

require "../connection.php";

if (isset($_SESSION["adminuser"])) {

?>


    <!DOCTYPE html>
    <html lang="en">

    <head>

        <meta charset="utf-8" />
        <title>Admin Dashboard | Blaze tuk tuk </title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc." />
        <meta name="author" content="Malindu Prabod wm" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <script type="module" src="https://ajax.googleapis.com/ajax/libs/@googlemaps/extended-component-library/0.6.11/index.min.js">
        </script>

        <!-- App favicon -->
        <link rel="icon" type="image/png" href="../SignIn/images/Untit1.png" />
        <!-- App css -->
        <link href="../admin/assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-style" />

        <!-- Icons -->
        <link href="../admin/assets/css/icons.min.css" rel="stylesheet" type="text/css" />

        <link rel="stylesheet" type="text/css" href="../loader/loader.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

        <style>
            /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
            html,
            body {
                height: 100%;
                margin: 0;
                padding: 0;
            }

            .place-picker-container {
                padding: 20px;
            }
        </style>

        <style>
            #map {
                height: 500px;
                width: 100%;
                margin-top: 10px;
            }

            #search-box {
                width: 300px;
                margin-bottom: 10px;
            }
        </style>

        <style>
            #imagePreview {
                display: flex;
                flex-wrap: wrap;
                gap: 10px;
            }

            .image-preview-item {
                position: relative;
                width: 100px;
                height: 100px;
                overflow: hidden;
                border: 1px solid #ddd;
                border-radius: 5px;
            }

            .image-preview-item img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            .image-preview-item .remove-image {
                position: absolute;
                top: 5px;
                right: 5px;
                background: rgba(255, 255, 255, 0.7);
                border: none;
                border-radius: 50%;
                cursor: pointer;
            }
        </style>

        <style>
            .scrollable-container {
                max-height: 80vh;
                overflow-y: auto;
            }
        </style>

    </head>

    <!-- body start -->

    <body data-menu-color="light" data-sidebar="default">

        <!-- Begin page -->
        <div id="app-layout">


            <!-- Topbar Start -->
            <div class="topbar-custom">
                <div class="container-xxl">
                    <div class="d-flex justify-content-between">
                        <ul class="list-unstyled topnav-menu mb-0 d-flex align-items-center">
                            <li>
                                <button class="button-toggle-menu nav-link ps-0">
                                    <i data-feather="menu" class="noti-icon"></i>
                                </button>
                            </li>
                            <li class="d-none d-lg-block">
                                <div class="position-relative topbar-search">
                                    <input type="text" class="form-control bg-light bg-opacity-75 border-light ps-4" placeholder="Search...">
                                    <i class="mdi mdi-magnify fs-16 position-absolute text-muted top-50 translate-middle-y ms-2"></i>
                                </div>
                            </li>
                        </ul>

                        <ul class="list-unstyled topnav-menu mb-0 d-flex align-items-center">

                            <li class="d-none d-sm-flex">
                                <button type="button" class="btn nav-link" data-toggle="fullscreen">
                                    <i data-feather="maximize" class="align-middle fullscreen noti-icon"></i>
                                </button>
                            </li>

                            <li class="dropdown notification-list topbar-dropdown">
                                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                    <i data-feather="bell" class="noti-icon"></i>
                                    <span class="badge bg-danger rounded-circle noti-icon-badge">2</span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end dropdown-lg">

                                    <!-- item-->
                                    <div class="dropdown-item noti-title">
                                        <h5 class="m-0">
                                            <span class="float-end">
                                                <a href="" class="text-dark">
                                                    <small>Clear All</small>
                                                </a>
                                            </span>Notification
                                        </h5>
                                    </div>

                                    <div class="noti-scroll" data-simplebar>

                                        <!-- item-->
                                        <a href="javascript:void(0);" class="dropdown-item notify-item text-muted link-primary active">
                                            <div class="notify-icon">
                                                <img src="../admin/assets/images/users/user-12.jpg" class="img-fluid rounded-circle" alt="" />
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <p class="notify-details">Carl Steadham</p>
                                                <small class="text-muted">5 min ago</small>
                                            </div>
                                            <p class="mb-0 user-msg">
                                                <small class="fs-14">Completed <span class="text-reset">Improve workflow in Figma </span></small>
                                            </p>
                                        </a>

                                        <!-- item-->
                                        <a href="javascript:void(0);" class="dropdown-item notify-item text-muted link-primary">
                                            <div class="notify-icon">
                                                <img src="../admin/assets/images/users/user-2.jpg" class="img-fluid rounded-circle" alt="" />
                                            </div>
                                            <div class="notify-content">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <p class="notify-details">Olivia McGuire</p>
                                                    <small class="text-muted">1 min ago</small>
                                                </div>

                                                <div class="d-flex mt-2 align-items-center">
                                                    <div class="notify-sub-icon">
                                                        <i class="mdi mdi-download-box text-dark"></i>
                                                    </div>

                                                    <div>
                                                        <p class="notify-details mb-0">dark-themes.zip</p>
                                                        <small class="text-muted">2.4 MB</small>
                                                    </div>
                                                </div>

                                            </div>
                                        </a>

                                    </div>
                                    <!-- All-->
                                    <a href="javascript:void(0);" class="dropdown-item text-center text-primary notify-item notify-all">
                                        View all
                                        <i class="fe-arrow-right"></i>
                                    </a>

                                </div>
                            </li>

                            <li class="dropdown notification-list topbar-dropdown">
                                <a class="nav-link dropdown-toggle nav-user me-0" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                    <img src="../admin/assets/images/users/user-12.jpg" alt="user-image" class="rounded-circle">
                                    <span class="pro-user-name ms-1">
                                        <?php echo $_SESSION["adminuser"]["email"]; ?><i class="mdi mdi-chevron-down"></i>
                                    </span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end profile-dropdown ">
                                    <!-- item-->
                                    <div class="dropdown-header noti-title">
                                        <h6 class="text-overflow m-0">Welcome !</h6>
                                    </div>

                                    <!-- item-->
                                    <a href="../admin/pages-profile.html" class="dropdown-item notify-item">
                                        <i class="mdi mdi-account-circle-outline fs-16 align-middle"></i>
                                        <span>My Account</span>
                                    </a>

                                    <div class="dropdown-divider"></div>

                                    <!-- item-->
                                    <a href="../admin/auth-logout.html" class="dropdown-item notify-item">
                                        <i class="mdi mdi-location-exit fs-16 align-middle"></i>
                                        <span>Logout</span>
                                    </a>

                                </div>
                            </li>

                        </ul>
                    </div>

                </div>

            </div>

            <!-- end Topbar -->

            <!-- Left Sidebar Start -->
            <div class="app-sidebar-menu">
                <div class="h-100" data-simplebar>

                    <!--- Sidemenu -->
                    <div id="sidebar-menu">

                        <div class="logo-box" style="text-align: center;">
                            <a href="../index.php" class="logo logo-dark">
                                <span class="logo-sm">
                                    <img src="../SignIn/images/Untit1.png" alt="" height="100">
                                </span>
                                <span class="logo-lg">
                                    <img src="../SignIn/images/Untit1.png" alt="" height="100">
                                </span>
                            </a>
                        </div>

                        <ul id="side-menu" style="margin-top: 30px;">

                            <li class="menu-title">Menu</li>
                            <li>
                                <a href="../admin/adminindex.php">
                                    <i data-feather="home"></i>
                                    <span> Dashboard </span>
                                    <span class="menu-arrow"></span>
                                </a>
                            </li>



                            <li class="menu-title">Pages</li>


                            <li>
                                <a href="#sidebarExpages" data-bs-toggle="collapse">
                                    <i data-feather="file-text"></i>
                                    <span>Tour Plan</span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse" id="sidebarExpages">
                                    <ul class="nav-second-level">
                                        <li>
                                            <a href="#" onclick="window.location.reload();" id="addTourPlanLink">Add Tour Plan</a>
                                        </li>
                                        <li>
                                            <a href="pages-profile.html" class="tp-link">Update Tour Plan</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>

                        </ul>

                    </div>
                    <!-- End Sidebar -->

                    <div class="clearfix"></div>

                </div>
            </div>
            <!-- Left Sidebar End -->

            <!-- ============================================================== -->
            <!-- Start Page Content here -->
            <!-- ============================================================== -->


            <div class="content-page">
                <div class="content">
                    <!-- Start Content-->


                    <div class="container-xxl">
                        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                            <div class="flex-grow-1">
                                <h4 class="fs-18 fw-semibold m-0">Add Tour Plan</h4>
                            </div>
                            <div class="text-end">
                                <a href="#sidebarExpages" data-bs-toggle="collapse">
                                    <i data-feather="file-text"></i>
                                    <span>Tour Plan</span>
                                    <span class="menu-arrow"></span>
                                </a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Add Tour Plan</h5>
                                    </div>
                                    <div class="card-body col-12 scrollable-container">
                                        <form>
                                            <div class="form-group ">
                                                <label for="tourType">Tour Type</label>
                                                <select class="form-control" id="tourType" name="tourType">
                                                    <option value="" disabled selected>Select Tour Type</option>
                                                    <?php
                                                    $rs = Database::search("SELECT * FROM `toure_type`");
                                                    $n = $rs->num_rows;
                                                    for ($x = 0; $x < $n; $x++) {
                                                        $d = $rs->fetch_assoc();
                                                        echo "<option value='{$d["id"]}'>{$d["name"]}</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-group ">
                                                <label for="tourTitle">Tour Title</label>
                                                <input type="text" class="form-control" id="tourTitle" name="tourTitle" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="tourSubtitle">Tour Subtitle</label>
                                                <input type="text" class="form-control" id="tourSubtitle" name="tourSubtitle">
                                            </div>
                                            <div class="form-group">
                                                <label for="adultPrice">Adult Price (USD)</label>
                                                <input type="number" class="form-control" id="adultPrice" name="adultPrice" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="childrenPrice">Children's Price (USD)</label>
                                                <input type="number" class="form-control" id="childrenPrice" name="childrenPrice">
                                            </div>
                                            <div class="form-group">
                                                <label for="description">Description</label>
                                                <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="maxCount">Maximum Count</label>
                                                <input type="number" class="form-control" id="maxCount" name="maxCount" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="map">Tour Markers</label>
                                                <div class="col-06" style="margin-bottom: 10px;">
                                                    <button type="button" class="btn btn-primary" onclick="openNewTab();">Create Markes</button>
                                                </div>
                                                <label for="map">Past Your Embed code </label>
                                                <textarea class="form-control" id="code" name="code" rows="4" placeholder="Past your Embeded on my website code" required></textarea>
                                                <div id="pastedCode" style="margin-top: 10px;"></div>        
                                                <!-- <input id="search-box" type="text" placeholder="Search for a location" class="form-control mb-2" />
    <div id="map"></div> -->

                                                <label for="map">Map</label>
                                                <div id="displayMap" class="col-12 " style="width: 100% ; height: 480px ;">
                                                   
                                                </div>

                                              
                                            </div>
                                            <div class="form-group">
                                                <label for="timeSlot">Time Slots</label>
                                                <div id="timeSlotsContainer">
                                                    <div class="input-group mb-2">
                                                        <input type="time" class="form-control" name="timeSlots[]" required>
                                                        <div class="input-group-append">
                                                            <button class="btn btn-outline-danger" type="button" onclick="addTimeSlot();">+</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group mb-2">
                                                <label for="images">Add Images</label>
                                                <input type="file" class="form-control-file " id="images" name="images[]" multiple onchange="previewImages()">
                                                <div id="imagePreview" class="mt-3"></div>


                                            </div>
                                            <div class="form-group  mt-3"><button type="button" class="btn btn-danger col-12">Create Tour</button></div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->

            <!-- Container to load CreateToure.php content -->
            <div id="createTourPlanContainer" style="display: none; ">
            </div>

        </div>
        <!-- END wrapper -->
        <!-- Vendor -->
        <script src="../admin/assets/libs/jquery/jquery.min.js"></script>
        <script src="../admin/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="../admin/assets/libs/simplebar/simplebar.min.js"></script>
        <script src="../admin/assets/libs/node-waves/waves.min.js"></script>
        <script src="../admin/assets/libs/waypoints/lib/jquery.waypoints.min.js"></script>
        <script src="../admin/assets/libs/jquery.counterup/jquery.counterup.min.js"></script>
        <script src="../admin/assets/libs/feather-icons/feather.min.js"></script>

        <!-- Apexcharts JS -->


        <!-- for basic area chart -->

        <!-- Widgets Init Js -->


        <!-- App js-->
        <script src="../admin/assets/js/app.js"></script>
        <script src="../admin/assets/js/addToure.js"></script>
        <script src="../assets/js/loader.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


        <!-- map -->
        <script>
            let map;
            let markers = [];

            function initMap() {
                map = new google.maps.Map(document.getElementById("map"), {
                    center: {
                        lat: 7.8731,
                        lng: 80.7718
                    },
                    zoom: 8,
                });

                const input = document.getElementById("search-box");
                const searchBox = new google.maps.places.SearchBox(input);

                map.addListener("bounds_changed", () => {
                    searchBox.setBounds(map.getBounds());
                });

                searchBox.addListener("places_changed", () => {
                    const places = searchBox.getPlaces();
                    if (places.length === 0) return;

                    markers.forEach(marker => marker.setMap(null));
                    markers = [];

                    const bounds = new google.maps.LatLngBounds();
                    places.forEach(place => {
                        if (!place.geometry || !place.geometry.location) return;

                        const marker = new google.maps.Marker({
                            map,
                            title: place.name,
                            position: place.geometry.location,
                        });
                        markers.push(marker);

                        if (place.geometry.viewport) bounds.union(place.geometry.viewport);
                        else bounds.extend(place.geometry.location);
                    });
                    map.fitBounds(bounds);
                });

                map.addListener("click", e => {
                    const marker = new google.maps.Marker({
                        position: e.latLng,
                        map,
                    });
                    markers.push(marker);

                    console.log(`Marker added at: Latitude: ${e.latLng.lat()}, Longitude: ${e.latLng.lng()}`);
                });
            }

            window.gm_authFailure = function() {
                alert("Google Maps API key is invalid or restricted.");
            };
        </script>
        <!-- Google Maps API script -->
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAmWjSKC0Z4RYKXjyD6t1aW_aFn7O79awA&libraries=places&callback=initMap" async defer loading="lazy" onerror="gm_authFailure()"></script>

    </html>

<?php

} else {
    echo ("You are not a valid user");
    header("Refresh: 2; URL=adminSignIn.php"); // Refresh the page after 2 seconds
    exit();
}

?>