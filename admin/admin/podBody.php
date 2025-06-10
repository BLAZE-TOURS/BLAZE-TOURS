<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Admin Panel for Rakkitha Kanda Rock Temple">
    <meta name="author" content="Malindu Prabod wm">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Podcast Management | Admin Dashboard</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="../SignIn/images/Untit1.png" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- App CSS -->
    <link href="../admin/assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-style" />

    <!-- DataTables CSS -->
    <link href="../admin/assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <link href="../admin/assets/libs/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <link href="../admin/assets/libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css" rel="stylesheet" type="text/css" />

    <!-- Icons -->
    <link href="../admin/assets/css/icons.min.css" rel="stylesheet" type="text/css" />

    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <style>
        .content-page {
            margin-top: 50px;
        }

        .table-responsive {
            margin-top: 20px;
        }

        .modal-footer {
            justify-content: space-between;
        }

        .desc-cell {
            max-width: 300px;
            /* Adjust as needed */
            white-space: normal !important;
            word-break: break-word;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>
</head>

<body data-menu-color="light" data-sidebar="default">
    <div class="content-page fade-in">
        <div class="row justify-content-center mt-2">
            <div class="col-md-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h3 class="card-title text-center">Podcast List</h3>

                        <!-- Add New Podcast Section -->
                        <div class="mb-4">
                            <h4>Add New Podcast</h4>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPodModal">
                                <i class="fas fa-plus"></i> Add Podcast
                            </button>
                        </div>

                        <!-- Add Podcast Modal -->
                        <div class="modal fade" id="addPodModal" tabindex="-1" aria-labelledby="addPodModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="addPodModalLabel">Add New Podcast</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div id="validation-errors-pod" class="alert alert-danger d-none" role="alert"></div>
                                        <div id="success-message-pod" class="alert alert-success d-none" role="alert"></div>
                                        <form id="addPodForm" enctype="multipart/form-data">
                                            <div class="row g-3">
                                                <div class="col-12">
                                                    <label for="pod_name" class="form-label">Podcast Name</label>
                                                    <input type="text" class="form-control" placeholder="Podcast Name" name="pod_name" id="pod_name" required>
                                                </div>
                                                <div class="col-12 mt-2">
                                                    <label for="description" class="form-label">Description</label>
                                                    <textarea class="form-control" placeholder="Description" name="description" id="description" required></textarea>
                                                </div>
                                                <div class="col-12 mt-2">
                                                    <label for="img" class="form-label">Image</label>
                                                    <input type="file" class="form-control" name="img" id="img" accept="image/*" onchange="previewImage(event, 'img-preview')" required>
                                                    <img id="img-preview" src="#" alt="Image Preview" style="width: 100px; height: auto; margin-top: 10px; display: none;">
                                                </div>
                                                <div class="col-12 mt-2">
                                                    <label for="podcast" class="form-label">Podcast</label>
                                                    <input type="file" class="form-control" name="podcast" id="podcast" accept="audio/*" onchange="previewAudio(event, 'audio-preview')" required>
                                                    <audio id="audio-preview" controls style="margin-top: 10px; display: none;">
                                                        <source src="#" type="audio/mpeg">
                                                        Your browser does not support the audio element.
                                                    </audio>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div id="loading-spinner-pod" class="d-none">
                                        <div class="d-flex justify-content-center">
                                            <div class="spinner-border text-primary" role="status">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Add this inside the modal-body, after the spinner -->
                                    <div id="upload-progress-pod" class="progress d-none" style="height: 20px; margin-top: 10px;">
                                        <div id="upload-progress-bar-pod" class="progress-bar progress-bar-striped progress-bar-animated"
                                            role="progressbar" style="width: 0%">0%</div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary" onclick="addPod();" form="addPodForm">Add Podcast</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Update Podcast Modal -->
                        <div class="modal fade" id="updatePodModal" tabindex="-1" aria-labelledby="updatePodModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="updatePodModalLabel">Update Podcast</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div id="validation-errors-pod-update" class="alert alert-danger d-none" role="alert"></div>
                                        <div id="success-message-pod-update" class="alert alert-success d-none" role="alert"></div>
                                        <form id="updatePodForm" enctype="multipart/form-data">
                                            <input type="hidden" id="update_pod_id" name="id">
                                            <div class="row g-3">
                                                <div class="col-12">
                                                    <label for="update_pod_name" class="form-label">Podcast Name</label>
                                                    <input type="text" class="form-control" name="pod_name" id="update_pod_name" required>
                                                </div>
                                                <div class="col-12 mt-2">
                                                    <label for="update_description" class="form-label">Description</label>
                                                    <textarea class="form-control" name="description" id="update_description" required></textarea>
                                                </div>
                                                <div class="col-12 mt-2">
                                                    <label for="update_img" class="form-label">Image</label>
                                                    <input type="file" class="form-control" name="img" id="update_img" accept="image/*" onchange="previewImage(event, 'update-img-preview')">
                                                    <img id="update-img-preview" src="#" alt="Image Preview" style="width: 100px; height: auto; margin-top: 10px; display: none;">
                                                </div>
                                                <div class="col-12 mt-2">
                                                    <label for="update_podcast" class="form-label">Podcast</label>
                                                    <input type="file" class="form-control" name="podcast" id="update_podcast" accept="audio/*" onchange="previewAudio(event, 'update-audio-preview')">
                                                    <audio id="update-audio-preview" controls style="margin-top: 10px; display: none;">
                                                        <source src="#" type="audio/mpeg">
                                                        Your browser does not support the audio element.
                                                    </audio>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div id="loading-spinner-pod-update" class="d-none">
                                        <div class="d-flex justify-content-center">
                                            <div class="spinner-border text-primary" role="status">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="upload-progress-pod-update" class="progress d-none" style="height: 20px; margin-top: 10px;">
                                        <div id="upload-progress-bar-pod-update" class="progress-bar progress-bar-striped progress-bar-animated"
                                            role="progressbar" style="width: 0%">0%</div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary" id="updatePodButton">Update Podcast</button>
                                    </div>
                                </div>
                            </div>
                        </div>




                        <!-- Podcast Table -->
                        <div class="table-responsive">
                            <table id="datatable-pod" class="table table-striped table-bordered dt-responsive nowrap">
                                <thead>
                                    <tr>
                                        <th>#ID</th>
                                        <th>Podcast Name</th>
                                        <th>Description</th>
                                        <th>Image</th>
                                        <th>Podcast</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($pod_n > 0) {
                                        while ($row = $pod_rs->fetch_assoc()) {
                                            // Correctly concatenate the base directory with the database paths
                                            $imagePath = "../" . $row["pod_img_url"];
                                            $audioPath = "../" . $row["pod_url"];
                                    ?>
                                            <tr class="text-center">
                                                <td><?php echo $row["id"]; ?></td>
                                                <td><?php echo htmlspecialchars($row["pod_name"]); ?></td>
                                                <td class="desc-cell" title="<?php echo htmlspecialchars($row["pod_description"]); ?>">
                                                    <?php echo htmlspecialchars($row["pod_description"]); ?>
                                                </td>
                                                <td>
                                                    <img src="<?php echo $imagePath; ?>" alt="Podcast Image" style="width: 50px; height: auto;">
                                                </td>
                                                <td>
                                                    <audio controls>
                                                        <source src="<?php echo $audioPath; ?>" type="audio/mpeg">
                                                        Your browser does not support the audio element.
                                                    </audio>
                                                </td>
                                                <td>
                                                    <button class="btn btn-sm btn-primary" onclick="updatePod(<?php echo $row['id']; ?>);">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <!-- <button class="btn btn-sm btn-success" onclick="downloadPod(<?php echo $row['id']; ?>);">
                                                        <i class="fas fa-download"></i>
                                                    </button> -->
                                                    <button class="btn btn-sm btn-danger" onclick="deletePod(<?php echo $row['id']; ?>);">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                    <?php
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="../admin/assets/libs/jquery/jquery.min.js"></script>
    <script src="../admin/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../admin/assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../admin/assets/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
    <script src="../admin/assets/js/app.js"></script>
    <script src="../admin/assets/js/pod.js"></script>

    <script>
        $(document).ready(function() {
            // Wait for the table to be fully loaded
            setTimeout(function() {
                if ($.fn.DataTable.isDataTable('#fixed-header-datatable')) {
                    $('#fixed-header-datatable').DataTable().clear().destroy();
                }

                $('#fixed-header-datatable').DataTable({
                    responsive: true,
                    autoWidth: false,
                    paging: true,
                    searching: true,
                    ordering: true
                });

                console.log("DataTable initialized successfully after delay");
            }, 500); // Adjust delay as needed
        });
    </script>
</body>

</html>