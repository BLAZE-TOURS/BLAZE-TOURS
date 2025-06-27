<?php
session_start();
require "../connection.php";

if (isset($_SESSION["adminuser"])) {

?>
    <!DOCTYPE html>
    <html lang="en">

    <head>

        <meta charset="utf-8" />
        <title>Admin Dashboard | BLAZE TOURS (PVT) LTD </title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="A fully featured admin Panel" />
        <meta name="author" content="Malindu Prabod wm" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <!-- App favicon -->
        <link rel="icon" type="image/png" href="../SignIn/images/Untit1.png" />

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <!-- App css -->
        <link href="../tour/assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-style" />

        <!-- Datatables css -->
        <link href="../tour/assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css" />
        <link href="../tour/assets/libs/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css" rel="stylesheet" type="text/css" />
        <link href="../tour/assets/libs/datatables.net-keytable-bs5/css/keyTable.bootstrap5.min.css" rel="stylesheet" type="text/css" />
        <link href="../tour/assets/libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css" rel="stylesheet" type="text/css" />
        <link href="../tour/assets/libs/datatables.net-select-bs5/css/select.bootstrap5.min.css" rel="stylesheet" type="text/css" />

        <!-- Icons -->
        <link href="../tour/assets/css/icons.min.css" rel="stylesheet" type="text/css" />

        <link rel="stylesheet" type="text/css" href="../loader/loader.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

        <!--Table UI-->
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css">

        <!-- Google Maps API -->
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCzj96kj0RB6UZ7iNAvuLm6fLBWO4mfa5A&libraries=places"></script>


        <style>
            .sidebar {
                max-height: 100vh;
                /* Set the maximum height to the viewport height */
                overflow-y: auto;
                /* Enable vertical scrolling */
            }

            html,
            body {

                margin: 0;

            }

            .place-picker-container {
                padding: 20px;
            }

            .sidebar-collapse {
                display: none;
                transition: all 0.3s;
            }

            .sidebar-collapse.show {
                display: block;
            }

            .menu-arrow {
                display: inline-block;
                transition: transform 0.3s;
                border: solid #888;
                border-width: 0 2px 2px 0;
                padding: 3px;
                margin-left: 8px;
                transform: rotate(45deg);
                /* right arrow */
                width: 8px;
                height: 8px;
            }

            a.active .menu-arrow {
                transform: rotate(135deg);
                /* down arrow */
            }
        </style>

    </head>

    <!-- body start -->

    <body data-menu-color="light" data-sidebar="default">
        <!-- Loader -->
        <div class="loader">
            <div class="animation"></div>
        </div>
        <!-- end of Loader -->

        <!-- Begin page -->
        <div id="app-layout">

            <div class="sidebar">

                <!-- Sidebar content -->

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
                                                    <img src="../tour/assets/images/users/user-12.jpg" class="img-fluid rounded-circle" alt="" />
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
                                                    <img src="../tour/assets/images/users/user-2.jpg" class="img-fluid rounded-circle" alt="" />
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
                                        <img src="../tour/assets/images/users/user-12.jpg" alt="user-image" class="rounded-circle">
                                        <span class="pro-user-name ms-1">
                                            <?php echo $_SESSION["adminuser"]["email"]; ?></i>
                                        </span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end profile-dropdown ">
                                        <!-- item-->
                                        <div class="dropdown-header noti-title">
                                            <h6 class="text-overflow m-0">Welcome !</h6>
                                        </div>

                                        <!-- item-->
                                        <a href="../tour/pages-profile.html" class="dropdown-item notify-item">
                                            <i class="mdi mdi-account-circle-outline fs-16 align-middle"></i>
                                            <span>My Account</span>
                                        </a>

                                        <div class="dropdown-divider"></div>

                                        <!-- item-->
                                        <a href="../tour/adminSignIn.php" class="dropdown-item notify-item">
                                            <i class="mdi mdi-location-exit fs-16 align-middle"></i>
                                            <span onclick="signout();">Logout</span>
                                        </a>

                                    </div>
                                </li>

                            </ul>
                        </div>

                    </div>

                </div>
                <!-- end Topbar -->

                <!-- Left Sidebar Start -->
                <div class=" app-sidebar-menu">
                    <div class="h-100" data-simplebar>

                        <!--- Sidemenu -->
                        <div id="sidebar-menu">

                            <div class="logo-box" style="text-align: center;">
                                <a href="../tour/adminindex.php" class="logo logo-dark">
                                    <span class="logo-sm">
                                        <img src="../SignIn/images/Untit1.png" alt="" height="100">
                                    </span>
                                    <span class="logo-lg">
                                        <img src="../SignIn/images/Untit1.png" alt="" height="100">
                                    </span>
                                </a>
                            </div>

                            <ul id="side-menu" style="margin-top: 30px;">



                                <li class="menu-title">Pages</li>


                                <li>
                                    <a href="#" onclick="changeDashboardView();">
                                        <i data-feather="map-pin"></i>
                                        <span>All Tours</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" onclick="changeDashboardViewAddTour();">
                                        <i data-feather="plus-square"></i>
                                        <span>Add Tour</span>
                                    </a>
                                </li>
                                <li>
                                <li>
                                    <a href="#" onclick="changeDashboardViewToursType();">
                                        <i data-feather="layers"></i>
                                        <span>Tour Type</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" onclick="changeDashboardViewAddLocation();">
                                        <i data-feather="map"></i>
                                        <span>Add Location</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" onclick="changeDashboardViewAllLocation();">
                                        <i data-feather="map-pin"></i>
                                        <span>All Location</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="../liveMap/livemapBody.php" target="_blank">
                                        <i data-feather="globe"></i>
                                        <span>Live Map</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="#" onclick="changeDashboardViewTourImage();">
                                        <i data-feather="image"></i>
                                        <span>Tour Images</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="#" onclick="changeDashboardViewTime();">
                                        <i data-feather="clock"></i>
                                        <span>Time</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="#" onclick="changeDashboardViewHighlight();">
                                        <i data-feather="star"></i>
                                        <span>Highlight</span>
                                    </a>
                                </li>

                                <li>
                                    <a style="color: red;" class="fw-bold" href="../admin/adminindex.php">
                                        <i data-feather="log-out"></i>
                                        <span>Back</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <!-- End Sidebar -->

                        <div class="clearfix"></div>

                    </div>
                </div>
                <div id="HomeBodyContainer"> <?php include 'fetchTours.php'; ?> <?php include "../tour/toursBody.php"; ?> </div>

                <div id="toursTypeContainer" class="d-none"> <?php include 'fetchToursType.php'; ?> <?php include "../tour/toursTypeBody.php"; ?> </div>

                <div id="addToursContainer" class="d-none"> <?php include "../tour/addToursBody.php"; ?> </div>

                <div id="addLocationContainer" class="d-none"> <?php include "../tour/addLocationBody.php"; ?> </div>

                <div id="allLocationContainer" class="d-none"> <?php include 'fetchAllLocation.php'; ?> <?php include "../tour/allLocationBody.php"; ?> </div>        

            </div>

        </div>

        <?php include "../tour/footer.php"; ?>
        <!-- END wrapper -->

        <!-- Vendor -->
        <script src="../tour/assets/libs/jquery/jquery.min.js"></script>
        <script src="../tour/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="../tour/assets/libs/simplebar/simplebar.min.js"></script>
        <script src="../tour/assets/libs/node-waves/waves.min.js"></script>
        <script src="../tour/assets/libs/waypoints/lib/jquery.waypoints.min.js"></script>
        <script src="../tour/assets/libs/jquery.counterup/jquery.counterup.min.js"></script>
        <script src="../tour/assets/libs/feather-icons/feather.min.js"></script>

        <!-- Apexcharts JS -->
        <script src="../tour/assets/libs/apexcharts/apexcharts.min.js"></script>

        <!-- Widgets Init Js -->
        <script src="../tour/assets/js/pages/analytics-dashboard.init.js"></script>
        <!-- Datatables js -->

        <!-- dataTables.bootstrap5 -->
        <script src="../tour/assets/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
        <script src="../tour/assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>

        <!-- buttons.colVis -->
        <script src="../tour/assets/libs/datatables.net-buttons/js/buttons.colVis.min.js"></script>
        <script src="../tour/assets/libs/datatables.net-buttons/js/buttons.flash.min.js"></script>
        <script src="../tour/assets/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
        <script src="../tour/assets/libs/datatables.net-buttons/js/buttons.print.min.js"></script>

        <!-- buttons.bootstrap5 -->
        <script src="../tour/assets/libs/datatables.net-buttons-bs5/js/buttons.bootstrap5.min.js"></script>

        <!-- dataTables.keyTable -->
        <script src="../tour/assets/libs/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
        <script src="../tour/assets/libs/datatables.net-keytable-bs5/js/keyTable.bootstrap5.min.js"></script>


        <!-- dataTables.select -->
        <script src="../tour/assets/libs/datatables.net-select/js/dataTables.select.min.js"></script>
        <script src="../tour/assets/libs/datatables.net-select-bs5/js/select.bootstrap5.min.js"></script>

        <!-- Datatable Demo App Js -->
        <script src="../tour/assets/js/pages/datatable.init.js"></script>


        <!-- App js-->
        <script src="../tour/assets/js/app.js"></script>
        <script src="../tour/assets/js/main.js"></script>
        <script src="../assets/js/loader.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="../tour/assets/js/mail.js"></script>
        <script src="../tour/assets/js/tourstype.js"></script>
        <script src="../tour/assets/js/tour.js"></script>
        <script src="../tour/assets/js/marker.js"></script>


        </script>

        <!--Table UI-->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>


        <script>
            $(document).ready(function() {
                $('#datatable-tourType').DataTable();
            });
        </script>

        <script>
            function toggleSidebarMenu(contentId, btnId) {
                var el = document.getElementById(contentId);
                var btn = document.getElementById(btnId);
                if (el) {
                    el.classList.toggle('show');
                }
                if (btn) {
                    btn.classList.toggle('active');
                }
            }
        </script>

    </body>


    </html>

<?php

}
if (!isset($_SESSION["adminuser"])) {
    header("Location: ../admin/adminSignIn.php");
    exit();
}
