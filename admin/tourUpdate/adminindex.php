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
        <link href="../tourUpdate/assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-style" />

        <!-- Datatables css -->
        <link href="../tourUpdate/assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css" />
        <link href="../tourUpdate/assets/libs/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css" rel="stylesheet" type="text/css" />
        <link href="../tourUpdate/assets/libs/datatables.net-keytable-bs5/css/keyTable.bootstrap5.min.css" rel="stylesheet" type="text/css" />
        <link href="../tourUpdate/assets/libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css" rel="stylesheet" type="text/css" />
        <link href="../tourUpdate/assets/libs/datatables.net-select-bs5/css/select.bootstrap5.min.css" rel="stylesheet" type="text/css" />

        <!-- Icons -->
        <link href="../tourUpdate/assets/css/icons.min.css" rel="stylesheet" type="text/css" />

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

            .content-page {
                animation: fadeIn 1s ease-in-out;
            }

            @keyframes fadeIn {
                from {
                    opacity: 0;
                }

                to {
                    opacity: 1;
                }
            }

            .btn-animate {
                transition: background-color 0.3s, transform 0.3s;
            }

            .btn-animate:hover {
                background-color: #0056b3;
                transform: scale(1.05);
            }

            .card {
                background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            }

            .form-control {
                border-radius: 0.25rem;
            }

            .form-label {
                font-weight: bold;
            }

            #main-image-preview img,
            #second-image-preview img {
                border: 1px solid #ddd;
                margin-bottom: 4px;
            }

            /* Reduce space below Add Location title and input */
            #location-name,
            #searchInput {
                margin-bottom: 0.3rem !important;
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
                                                    <img src="../tourUpdate/assets/images/users/user-12.jpg" class="img-fluid rounded-circle" alt="" />
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
                                                    <img src="../tourUpdate/assets/images/users/user-2.jpg" class="img-fluid rounded-circle" alt="" />
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
                                        <img src="../tourUpdate/assets/images/users/user-12.jpg" alt="user-image" class="rounded-circle">
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
                                        <a href="../tourUpdate/pages-profile.html" class="dropdown-item notify-item">
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
                                <a href="../tourUpdate/adminindex.php" class="logo logo-dark">
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
                                    <a style="color: red;" class="fw-bold" href="../tour/adminindex.php">
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

                <div class="content-page mt-5 fade-in">
                    <div class="row justify-content-center">
                        <div class="col-md-12">
                            <div class="card shadow-lg border-0 rounded-lg">
                                <div class="card-body p-5">
                                    <h3 class="card-title text-center mb-4">Update Tour</h3>
                                    <div id="validation-errors1" class="alert alert-danger d-none" role="alert"></div>
                                    <div id="success-message1" class="alert alert-success d-none" role="alert"></div>

                                    <!-- Section 1: Basic Tour Details -->
                                    <h5 class="mb-3">Basic Tour Details</h5>
                                    <form id="email-form">
                                        <div class="form-group mb-3 d-flex gap-2 align-items-end">
                                            <div class="flex-fill" style="flex:2;">
                                                <label for="name" class="form-label">Tour Name</label>
                                                <input type="text" class="form-control" id="name" name="name" required>
                                            </div>
                                            <div class="flex-fill" style="flex:1; max-width:380px;">
                                                <label for="tourType" class="form-label">Tour Type</label>
                                                <select class="form-select" id="tourType" name="tourType" required>
                                                    <option value="" disabled selected>Select Tour Type</option>
                                                    <?php
                                                    include '../tourUpdate/fetchToursTypeForAdd.php';
                                                    foreach ($toursType as $type) {
                                                        echo "<option value='{$type['id']}'>{$type['name']}</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="message" class="form-label">Description</label>
                                            <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
                                        </div>
                                        <div class="form-group mb-3 d-flex gap-2 align-items-end">
                                            <div class="flex-fill">
                                                <label for="Duration" class="form-label">Duration</label>
                                                <input type="number" class="form-control" id="Duration" name="Duration">
                                            </div>
                                            <div class="flex-fill">
                                                <label for="subject" class="form-label">Kids Price:</label>
                                                <input type="number" class="form-control" id="subject" name="subject" required>
                                            </div>
                                            <div class="flex-fill">
                                                <label for="adult-price" class="form-label">Adult Price:</label>
                                                <input type="number" class="form-control" id="adult-price" name="adult-price" required>
                                            </div>
                                            <div class="flex-fill">
                                                <label for="body-title" class="form-label">Maximum People Count</label>
                                                <input type="number" class="form-control" id="body-title" name="body-title" required>
                                            </div>
                                        </div>

                                        <!-- Section 2: Time & Highlight -->
                                        <div class="row mb-4 mt-4">
                                            <div class="col-md-6">
                                                <h5>Time Select</h5>
                                                <div class="input-group mb-2">
                                                    <input type="time" class="form-control" id="tour-time-input">
                                                    <button type="button" class="btn btn-outline-primary" id="add-time-btn">Add</button>
                                                </div>
                                                <ul class="list-group" id="time-list"></ul>
                                            </div>
                                            <div class="col-md-6">
                                                <h5>Add Highlight</h5>
                                                <div class="input-group mb-2">
                                                    <input type="text" class="form-control" id="highlight-input" placeholder="Enter highlight">
                                                    <button type="button" class="btn btn-outline-success" id="add-highlight-btn">Add</button>
                                                </div>
                                                <ul class="list-group" id="highlight-list"></ul>
                                            </div>
                                        </div>

                                        <!-- Section 3: Image Add -->
                                        <div class="row mb-4">
                                            <h5>Images</h5>
                                            <div class="col-md-4 mb-2">
                                                <label for="card-image" class="form-label">Card Image</label>
                                                <input type="file" class="form-control" id="card-image" accept="image/*">
                                                <div id="card-image-preview" class="mt-2"></div>
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <label for="main-image" class="form-label">Main Image</label>
                                                <input type="file" class="form-control" id="main-image" accept="image/*">
                                                <div id="main-image-preview" class="mt-2"></div>
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <label for="second-image" class="form-label">Second Image</label>
                                                <input type="file" class="form-control" id="second-image" accept="image/*">
                                                <div id="second-image-preview" class="mt-2"></div>
                                            </div>
                                        </div>

                                        <!-- Section 4: Add Location -->
                                        <div class="mb-4">
                                            <h5 class="mb-2" style="margin-bottom: 0.5rem !important;">Add Location</h5> <!-- Reduced bottom margin -->
                                            <!-- Add this for update map -->
                                            <div id="update-map" style="width:100%;height:300px;" class="mb-4"></div>
                                            <div class="row justify-content-center">
                                                <div class="col-md-12">
                                                    <div class="card shadow-lg border-0 rounded-lg">
                                                        <div class="card-body p-4">
                                                            <div class="form-group mb-3" style="margin-bottom: 0.5rem !important;"> <!-- Reduced bottom margin -->
                                                                <input id="searchInput" class="form-control" type="text" placeholder="Search location" autocomplete="off">
                                                            </div>
                                                            <div id="map" style="width:100%;height:300px;" class="mb-4"></div>
                                                            <form id="locationForm" action="" method="POST" enctype="multipart/form-data">
                                                                <div class="form-group mb-3" style="margin-bottom: 0.5rem !important;"> <!-- Reduced bottom margin -->
                                                                    <label for="location-name" class="form-label">Name:</label>
                                                                    <input name="name" id="location-name" class="form-control" required>
                                                                </div>
                                                                <div class="form-group mb-3">
                                                                    <label for="location-address" class="form-label">Address:</label>
                                                                    <input name="address" id="location-address" class="form-control" required>
                                                                </div>
                                                                <div class="form-group mb-4 d-flex gap-2 align-items-end">
                                                                    <div class="flex-fill">
                                                                        <label for="location-lat" class="form-label">Latitude:</label>
                                                                        <input name="lat" id="location-lat" class="form-control" required readonly>
                                                                    </div>
                                                                    <div class="flex-fill">
                                                                        <label for="location-lng" class="form-label">Longitude:</label>
                                                                        <input name="lng" id="location-lng" class="form-control" required readonly>
                                                                    </div>
                                                                    <div class="flex-fill">
                                                                        <label for="stop_duration_time" class="form-label">Add Stop Time Duration(min):</label>
                                                                        <input type="number" name="stop_duration_time" id="location-stop_duration_time" class="form-control" min="0" required>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group mb-3">
                                                                    <label for="location-icon" class="form-label">Icon Image:</label>
                                                                    <input type="file" name="icon" id="location-icon" class="form-control" accept="image/*" required>
                                                                    <div id="icon-info" class="mt-2">
                                                                        <span id="icon-filename" class="text-muted small"></span>
                                                                        <div id="icon-preview" style="max-width:60px;max-height:60px;"></div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group mb-3">
                                                                    <label for="location-description" class="form-label">Description:</label>
                                                                    <textarea name="description" id="location-description" class="form-control" rows="4" required></textarea>
                                                                </div>
                                                                <button type="button" id="addLocationBtn" class="btn btn-primary col-3 mt-3 mx-auto d-block btn-animate">Add Location</button>
                                                            </form>
                                                            <!-- Location Table -->
                                                            <div class="mt-4">
                                                                <h6>Locations Added (Temporary)</h6>
                                                                <div class="table-responsive">
                                                                    <table class="table table-bordered table-striped" id="locationTable">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>ID</th>
                                                                                <th>Name</th>
                                                                                <th>Address</th>
                                                                                <th>Latitude</th>
                                                                                <th>Longitude</th>
                                                                                <th>Icon</th>
                                                                                <th>Stop Time Duration (min)</th>
                                                                                <th>Description</th>
                                                                                <th>Action</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody></tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Section 5: Update Button -->
                                        <div id="loading-spinner1" class="d-none">
                                            <div class="d-flex justify-content-center">
                                                <div class="spinner-border text-primary" role="status">
                                                    <span class="visually-hidden">Loading...</span>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" id="addTourBtn" class="btn btn-success col-12 mt-3 mx-auto d-block btn-animate" style="font-size:1.3rem; padding: 0.75rem 0;">Update Tour</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- JS for dynamic add/remove and image preview -->
                <script>
                    // Time add/remove
                    let times = [];
                    const timeInput = document.getElementById('tour-time-input');
                    const timeList = document.getElementById('time-list');
                    document.getElementById('add-time-btn').onclick = function() {
                        if (timeInput.value && !times.includes(timeInput.value)) {
                            times.push(timeInput.value);
                            renderTimeList();
                            timeInput.value = '';
                        }
                    };

                    function renderTimeList() {
                        timeList.innerHTML = '';
                        times.forEach((t, i) => {
                            const li = document.createElement('li');
                            li.className = 'list-group-item d-flex justify-content-between align-items-center';
                            li.textContent = t;
                            const btn = document.createElement('button');
                            btn.className = 'btn btn-sm btn-danger';
                            btn.textContent = 'Remove';
                            btn.onclick = () => {
                                times.splice(i, 1);
                                renderTimeList();
                            };
                            li.appendChild(btn);
                            timeList.appendChild(li);
                        });
                    }
                    // Highlight add/remove
                    let highlights = [];
                    const highlightInput = document.getElementById('highlight-input');
                    const highlightList = document.getElementById('highlight-list');
                    document.getElementById('add-highlight-btn').onclick = function() {
                        if (highlightInput.value.trim() && !highlights.includes(highlightInput.value.trim())) {
                            highlights.push(highlightInput.value.trim());
                            renderHighlightList();
                            highlightInput.value = '';
                        }
                    };

                    function renderHighlightList() {
                        highlightList.innerHTML = '';
                        highlights.forEach((h, i) => {
                            const li = document.createElement('li');
                            li.className = 'list-group-item d-flex justify-content-between align-items-center';
                            li.textContent = h;
                            const btn = document.createElement('button');
                            btn.className = 'btn btn-sm btn-danger';
                            btn.textContent = 'Remove';
                            btn.onclick = () => {
                                highlights.splice(i, 1);
                                renderHighlightList();
                            };
                            li.appendChild(btn);
                            highlightList.appendChild(li);
                        });
                    }
                    // Image preview and remove
                    function handleImagePreview(inputId, previewId) {
                        const input = document.getElementById(inputId);
                        const preview = document.getElementById(previewId);
                        input.onchange = function() {
                            preview.innerHTML = '';
                            if (input.files && input.files[0]) {
                                const reader = new FileReader();
                                reader.onload = function(e) {
                                    const img = document.createElement('img');
                                    img.src = e.target.result;
                                    img.style.maxWidth = '120px';
                                    img.style.maxHeight = '120px';
                                    img.className = 'me-2 mb-2 rounded shadow-sm';
                                    const rmBtn = document.createElement('button');
                                    rmBtn.className = 'btn btn-sm btn-danger ms-2';
                                    rmBtn.textContent = 'Remove';
                                    rmBtn.onclick = function() {
                                        input.value = '';
                                        preview.innerHTML = '';
                                    };
                                    preview.appendChild(img);
                                    preview.appendChild(rmBtn);
                                };
                                reader.readAsDataURL(input.files[0]);
                            }
                        };
                    }
                    handleImagePreview('main-image', 'main-image-preview');
                    handleImagePreview('card-image', 'card-image-preview');
                    handleImagePreview('second-image', 'second-image-preview');

                    // Location add/remove
                    let locations = [];

                    function resetLocationForm() {
                        document.getElementById('location-name').value = '';
                        document.getElementById('location-address').value = '';
                        document.getElementById('location-lat').value = '';
                        document.getElementById('location-lng').value = '';
                        document.getElementById('location-stop_duration_time').value = '';
                        document.getElementById('location-icon').value = '';
                        document.getElementById('icon-filename').textContent = '';
                        document.getElementById('icon-preview').innerHTML = '';
                        document.getElementById('location-description').value = '';
                    }

                    function renderLocationTable() {
                        const tbody = document.querySelector('#locationTable tbody');
                        tbody.innerHTML = '';
                        locations.forEach((loc, idx) => {
                            const tr = document.createElement('tr');
                            tr.innerHTML = `
                <td>${idx + 1}</td>
                <td>${loc.name}</td>
                <td>${loc.address}</td>
                <td>${loc.lat}</td>
                <td>${loc.lng}</td>
                <td><img src="${loc.iconPreview}" style="max-width:40px;max-height:40px;"/></td>
                <td>${loc.stop_duration_time}</td>
                <td>${loc.description}</td>
                <td><button class="btn btn-danger btn-sm" onclick="removeLocation(${idx})">Remove</button></td>
            `;
                            tbody.appendChild(tr);
                        });
                    }

                    window.removeLocation = function(idx) {
                        locations.splice(idx, 1);
                        renderLocationTable();
                    };

                    document.getElementById('addLocationBtn').onclick = function(e) {
                        e.preventDefault();
                        // Get values
                        const name = document.getElementById('location-name').value.trim();
                        const address = document.getElementById('location-address').value.trim();
                        const lat = document.getElementById('location-lat').value.trim();
                        const lng = document.getElementById('location-lng').value.trim();
                        const stop_duration_time = document.getElementById('location-stop_duration_time').value.trim();
                        const description = document.getElementById('location-description').value.trim();
                        const iconInput = document.getElementById('location-icon');

                        // Validation
                        if (!name || !address || !lat || !lng || !stop_duration_time || !description || !iconInput.files || !iconInput.files[0]) {
                            const errorDiv = document.getElementById('validation-errors1');
                            errorDiv.textContent = 'Please fill all fields and select an icon.';
                            errorDiv.classList.remove('d-none');
                            errorDiv.scrollIntoView({
                                behavior: 'smooth',
                                block: 'center'
                            });
                            return;
                        } else {
                            document.getElementById('validation-errors1').classList.add('d-none');
                        }

                        // Read icon as base64 for preview
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            locations.push({
                                name,
                                address,
                                lat,
                                lng,
                                stop_duration_time,
                                description,
                                iconPreview: e.target.result
                            });
                            renderLocationTable();
                            resetLocationForm();
                        };
                        reader.readAsDataURL(iconInput.files[0]);
                    };

                    let map;
                    let marker;
                    let autocomplete;

                    function initMapAndAutocomplete() {
                        // Initialize the map
                        map = new google.maps.Map(document.getElementById('map'), {
                            center: {
                                lat: 7.8731,
                                lng: 80.7718
                            }, // Default: Sri Lanka center
                            zoom: 7
                        });

                        // Initialize the marker (hidden by default)
                        marker = new google.maps.Marker({
                            map: map,
                            draggable: true,
                            visible: false
                        });

                        // When marker is dragged, update lat/lng fields
                        marker.addListener('dragend', function() {
                            const pos = marker.getPosition();
                            document.getElementById('location-lat').value = pos.lat();
                            document.getElementById('location-lng').value = pos.lng();
                        });

                        // Initialize autocomplete for all places (not just geocode)
                        autocomplete = new google.maps.places.Autocomplete(
                            document.getElementById('searchInput'), {
                                types: []
                            } // Allow all place types for better suggestions
                        );
                        autocomplete.addListener('place_changed', fillInAddress);
                    }

                    function fillInAddress() {
                        const place = autocomplete.getPlace();
                        if (!place.geometry) return;
                        // Set address, lat, lng, and name
                        document.getElementById('location-address').value = place.formatted_address || '';
                        document.getElementById('location-lat').value = place.geometry.location.lat();
                        document.getElementById('location-lng').value = place.geometry.location.lng();
                        document.getElementById('location-name').value = place.name || '';
                        // Move and show marker
                        marker.setPosition(place.geometry.location);
                        marker.setVisible(true);
                        map.setCenter(place.geometry.location);
                        map.setZoom(15);
                        // Do NOT reset locations array or table here!
                    }

                    // Call this after the page loads and Google Maps is available
                    window.onload = function() {
                        if (typeof google !== 'undefined' && google.maps && google.maps.places) {
                            initMapAndAutocomplete();
                        }
                    };

                    // Prevent Enter key from submitting the form when searching location
                    const searchInput = document.getElementById('searchInput');
                    if (searchInput) {
                        searchInput.addEventListener('keydown', function(e) {
                            if (e.key === 'Enter') {
                                e.preventDefault();
                            }
                        });
                    }

                    // --- Auto show and fill update form on tour select ---

                    document.getElementById('SelectTourName').addEventListener('change', function() {
                        const tourId = this.value;
                        const updateForm = document.getElementById('updateTourFormContainer');
                        if (tourId) {
                            // Fetch tour data by ID
                            fetch('../tour/fetchTourById.php?id=' + encodeURIComponent(tourId))
                                .then(response => response.json())
                                .then(data => {
                                    if (data && !data.error) {
                                        // Show the update form
                                        updateForm.style.display = '';
                                        // Fill form fields
                                        // Find the update form fields (inside the hidden form)
                                        const container = updateForm;
                                        container.querySelector('input[name="name"]').value = data.name || '';
                                        container.querySelector('select[name="tourType"]').value = data.tours_type_id || '';
                                        container.querySelector('textarea[name="message"]').value = data.description || '';
                                        container.querySelector('input[name="Duration"]').value = data.duration || '';
                                        container.querySelector('input[name="subject"]').value = data.kids_price || '';
                                        container.querySelector('input[name="adult-price"]').value = data.adult_price || '';
                                        container.querySelector('input[name="body-title"]').value = data.maximum_people_count || '';
                                    } else {
                                        updateForm.style.display = 'none';
                                        alert(data.error || 'Tour not found');
                                    }
                                })
                                .catch(() => {
                                    updateForm.style.display = 'none';
                                    alert('Error fetching tour data');
                                });
                        } else {
                            updateForm.style.display = 'none';
                        }
                    });
                </script>


            </div>

        </div>

        <!-- Vendor -->
        <script src="../tourUpdate/assets/libs/jquery/jquery.min.js"></script>
        <script src="../tourUpdate/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="../tourUpdate/assets/libs/simplebar/simplebar.min.js"></script>
        <script src="../tourUpdate/assets/libs/node-waves/waves.min.js"></script>
        <script src="../tourUpdate/assets/libs/waypoints/lib/jquery.waypoints.min.js"></script>
        <script src="../tourUpdate/assets/libs/jquery.counterup/jquery.counterup.min.js"></script>
        <script src="../tourUpdate/assets/libs/feather-icons/feather.min.js"></script>

        <!-- Apexcharts JS -->
        <script src="../tourUpdate/assets/libs/apexcharts/apexcharts.min.js"></script>

        <!-- Widgets Init Js -->
        <script src="../tourUpdate/assets/js/pages/analytics-dashboard.init.js"></script>
        <!-- Datatables js -->

        <!-- dataTables.bootstrap5 -->
        <script src="../tourUpdate/assets/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
        <script src="../tourUpdate/assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>

        <!-- buttons.colVis -->
        <script src="../tourUpdate/assets/libs/datatables.net-buttons/js/buttons.colVis.min.js"></script>
        <script src="../tourUpdate/assets/libs/datatables.net-buttons/js/buttons.flash.min.js"></script>
        <script src="../tourUpdate/assets/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
        <script src="../tourUpdate/assets/libs/datatables.net-buttons/js/buttons.print.min.js"></script>

        <!-- buttons.bootstrap5 -->
        <script src="../tourUpdate/assets/libs/datatables.net-buttons-bs5/js/buttons.bootstrap5.min.js"></script>

        <!-- dataTables.keyTable -->
        <script src="../tourUpdate/assets/libs/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
        <script src="../tourUpdate/assets/libs/datatables.net-keytable-bs5/js/keyTable.bootstrap5.min.js"></script>


        <!-- dataTables.select -->
        <script src="../tourUpdate/assets/libs/datatables.net-select/js/dataTables.select.min.js"></script>
        <script src="../tourUpdate/assets/libs/datatables.net-select-bs5/js/select.bootstrap5.min.js"></script>

        <!-- Datatable Demo App Js -->
        <script src="../tourUpdate/assets/js/pages/datatable.init.js"></script>


        <!-- App js-->
        <script src="../assets/js/loader.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="../tourUpdate/assets/js/mail.js"></script>


        </script>

        <!--Table UI-->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>

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
