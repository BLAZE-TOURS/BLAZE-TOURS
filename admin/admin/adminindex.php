<?php
session_start();
require "../connection.php";

if (isset($_SESSION["adminuser"])) {

?>
    <!DOCTYPE html>
    <html lang="en">

    <head>

        <meta charset="utf-8" />
        <title>Admin Dashboard | Blaze Tours</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="A fully featured admin Panel" />
        <meta name="author" content="Malindu Prabod wm" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <!-- App favicon -->
        <link rel="icon" type="image/png" href="../SignIn/images/Untit1.png" />

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <!-- App css -->
        <link href="../admin/assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-style" />

        <!-- Datatables css -->
        <link href="../admin/assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css" />
        <link href="../admin/assets/libs/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css" rel="stylesheet" type="text/css" />
        <link href="../admin/assets/libs/datatables.net-keytable-bs5/css/keyTable.bootstrap5.min.css" rel="stylesheet" type="text/css" />
        <link href="../admin/assets/libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css" rel="stylesheet" type="text/css" />
        <link href="../admin/assets/libs/datatables.net-select-bs5/css/select.bootstrap5.min.css" rel="stylesheet" type="text/css" />


        <!-- Icons -->
        <link href="../admin/assets/css/icons.min.css" rel="stylesheet" type="text/css" />

        <link rel="stylesheet" type="text/css" href="../loader/loader.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

        <style>
            /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
            .sidebar {
                max-height: 100vh;
                /* Set the maximum height to the viewport height */
                overflow-y: auto;
                /* Enable vertical scrolling */
            }

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
                                        <a href="#" class="dropdown-item notify-item">
                                            <i class="mdi mdi-location-exit fs-16 align-middle"></i>
                                            <span onclick="signout();" >Logout</span>
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
                                <a href="../adminindex.php" class="logo logo-dark">
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
                                    <a href="#" onclick="changeDashboardView();">
                                        <i data-feather="home"></i>
                                        <span> Dashboard </span>
                                        <!-- <span class="menu-arrow"></span> -->
                                    </a>
                                </li>



                                <li class="menu-title">Pages</li>


                                <li>
                                    <a href="#sidebarExpages" data-bs-toggle="collapse">
                                        <i data-feather="file-text"></i>
                                        <span>Reservation</span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <div class="collapse" id="sidebarExpages">
                                        <ul class="nav-second-level">
                                            <li>
                                                <a href="#" class="tp-link">Reserved</a>
                                            </li>
                                            <li>
                                                <a href="#" class="tp-link">Arrived</a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>

                                <li>
                                    <a href="#" onclick="changeDashboardViewCompany();">
                                        <i data-feather="file-text"></i>
                                        <span>Company</span>
                                        <!-- <span class="menu-arrow"></span> -->
                                    </a>
                                </li>

                                <li>
                                    <a href="#" onclick="changeDashboardViewEmail();">
                                        <i data-feather="file-text"></i>
                                        <span>Send-Emails</span>
                                        <!-- <span class="menu-arrow"></span> -->
                                    </a>
                                </li>

                                <li>
                                    <a href="#" onclick="changeDashboardViewSubscribers();">
                                        <i data-feather="file-text"></i>
                                        <span>Subscribers</span>
                                        <!-- <span class="menu-arrow"></span> -->
                                    </a>
                                </li>
                                <li>
                                    <a href="#" onclick="changeDashboardViewSubscribers();">
                                        <i data-feather="file-text"></i>
                                        <span>Tours Shedule</span>
                                        <!-- <span class="menu-arrow"></span> -->
                                    </a>
                                </li>
                                <li>
                                    <a href="#" onclick="changeDashboardViewSubscribers();">
                                        <i data-feather="file-text"></i>
                                        <span>Donation</span>
                                        <!-- <span class="menu-arrow"></span> -->
                                    </a>
                                </li>
                                <li>
                                    <a href="#" onclick="changeDashboardViewSubscribers();">
                                        <i data-feather="file-text"></i>
                                        <span>Settngs</span>
                                        <!-- <span class="menu-arrow"></span> -->
                                    </a>
                                </li>
                            </ul>

                        </div>
                        <!-- End Sidebar -->

                        <div class="clearfix"></div>

                    </div>
                </div>
                <!-- Left Sidebar End -->

                <!-- ============================================================== -->
                <!-- Start Home Page Content here -->
                <!-- ============================================================== -->
                <div id="HomeBodyContainer"> <?php include "../admin/HomeBody.php"; ?> </div>
                <!-- ============================================================== -->
                <!-- End Home Page content -->
                <!-- ============================================================== -->

                <!-- ============================================================== -->
                <!-- Start Page Company  -->
                <!-- ============================================================== -->
                <div id="CompanyFormContainer" class="d-none"> <?php include 'fetchCompany.php'; ?> <?php include "../admin/CompanyBody.php"; ?> </div>
                <!-- ============================================================== -->
                <!-- End of Company  -->
                <!-- ============================================================== -->

                <!-- ============================================================== -->
                <!-- Start Page Send EMail -->
                <!-- ============================================================== -->
                <div id="emailFormContainer" class="d-none"> <?php include "../admin/SendEmailBody.php"; ?> </div>

                <!-- ============================================================== -->
                <!-- End of Send EMail -->
                <!-- ============================================================== -->


                <!-- ============================================================== -->
                <!-- Start Page sybscriber test-->
                <!-- ============================================================== -->
                <div id="SubscriberContainer" class="d-none"> <?php include 'fetchSubscribers.php'; ?> <?php include "../admin/SubscribersBody.php"; ?> </div>

                <!-- ============================================================== -->
                <!-- End of sybscriber test -->
                <!-- ============================================================== -->


            </div>

        </div>

        <?php include "../admin/footer.php"; ?>
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
        <script src="../admin/assets/libs/apexcharts/apexcharts.min.js"></script>

        <!-- Widgets Init Js -->
        <script src="../admin/assets/js/pages/analytics-dashboard.init.js"></script>
        <!-- Datatables js -->
        <script src="../admin/assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>

        <!-- dataTables.bootstrap5 -->
        <script src="../admin/assets/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
        <script src="../admin/assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>

        <!-- buttons.colVis -->
        <script src="../admin/assets/libs/datatables.net-buttons/js/buttons.colVis.min.js"></script>
        <script src="../admin/assets/libs/datatables.net-buttons/js/buttons.flash.min.js"></script>
        <script src="../admin/assets/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
        <script src="../admin/assets/libs/datatables.net-buttons/js/buttons.print.min.js"></script>

        <!-- buttons.bootstrap5 -->
        <script src="../admin/assets/libs/datatables.net-buttons-bs5/js/buttons.bootstrap5.min.js"></script>

        <!-- dataTables.keyTable -->
        <script src="../admin/assets/libs/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
        <script src="../admin/assets/libs/datatables.net-keytable-bs5/js/keyTable.bootstrap5.min.js"></script>

      
        <!-- dataTables.select -->
        <script src="../admin/assets/libs/datatables.net-select/js/dataTables.select.min.js"></script>
        <script src="../admin/assets/libs/datatables.net-select-bs5/js/select.bootstrap5.min.js"></script>

        <!-- Datatable Demo App Js -->
        <script src="../admin/assets/js/pages/datatable.init.js"></script>


        <!-- App js-->
        <script src="../admin/assets/js/app.js"></script>
        <script src="../admin/assets/js/main.js"></script>
        <script src="../assets/js/loader.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="../admin/assets/js/mail.js"></script>
        <script src="../admin/assets/js/Company.js"></script>


    </body>


    </html>

<?php

} else {
    echo ("You are not a valid user");
    header("Refresh: 2; URL=adminSignIn.php"); // Refresh the page after 2 seconds
    exit();
}

?>