<div class="content-page mt-5 fade-in">

    <div class="row justify-content-center mt-2">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h3 class="card-title text-center">Gallary Images</h3>

                    <!-- Add New Company Section -->
                    <div class="mb-4">
                        <h4>Add New Image</h4>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addImageModal">
                            <i class="fas fa-plus"></i> Add New Image
                        </button>
                    </div>


                    <!-- Add Image Modal -->
                    <div class="modal fade" id="addImageModal" tabindex="-1" aria-labelledby="addImageModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addImageModalLabel">Add New Image</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div id="validation-errors-image" class="alert alert-danger d-none" role="alert"></div>
                                    <div id="success-message-image" class="alert alert-success d-none" role="alert"></div>
                                    <form id="addaImageForm">
                                        <div class="row g-3">
                                            <div class="col-12">
                                                <label for="image-title" class="form-label">Title</label>
                                                <input type="text" class="form-control" placeholder="Image Title" name="image_title" id="image_title" required>
                                            </div>
                                            <div class="col-12 mt-2">
                                                <label for="image" class="form-label">Image</label>
                                                <input type="file" class="form-control" name="logo" id="image_update" onchange="previewImage(event, 'image-preview-update')">
                                                <img id="image-preview-update" src="" alt="Image Preview" style="width: 100px; height: auto; margin-top: 10px; display: none;">
                                            </div>
                                            <div class="col-12 mt-2">
                                                <label for="tour_id" class="form-label">Tour (Optional)</label>
                                                <select class="form-control" name="tour_id" id="tour_id">
                                                    <option value="">-- No Tour --</option>
                                                    <!-- Options loaded by JS -->
                                                </select>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div id="loading-spinner-add-image" class="d-none">
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
                                    <!-- <button type="button" class="btn btn-primary" id="addImageButton" disabled>Add Image</button> -->
                                    <button type="button" class="btn btn-primary" onclick=" addImage();" form="addCompanyForm">Add Image</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Update  Image modal -->
                    <div class="modal fade" id="updateImageModal" tabindex="-1" aria-labelledby="updateImageModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="updateImageModalLabel">Update Image</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div id="validation-errors-image-update" class="alert alert-danger d-none" role="alert"></div>
                                    <div id="success-message-image-update" class="alert alert-success d-none" role="alert"></div>
                                    <form id="updateImageForm">
                                        <div class="row g-3">
                                            <div class="col-12">
                                                <label for="update_image_title" class="form-label">Title</label>
                                                <input type="text" class="form-control" placeholder="Image Title" name="image_title" id="update_image_title" required>
                                            </div>

                                            <div class="col-12 mt-2">
                                                <label for="update_image" class="form-label">Image</label>
                                                <input type="file" class="form-control" name="logo" id="update_image" onchange="previewImage(event, 'update_logo_preview')">
                                                <img id="update_logo_preview" src="#" alt="Image Preview" style="width: 100px; height: auto; margin-top: 10px; display: none;">
                                            </div>
                                            <div class="col-12 mt-2">
                                                <label for="update_tour_id" class="form-label">Tour (Optional)</label>
                                                <select class="form-control" name="tour_id" id="update_tour_id">
                                                    <option value="">-- No Tour --</option>
                                                    <!-- Options loaded by JS -->
                                                </select>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div id="loading-spinner-image-update" class="d-none">
                                    <div class="d-flex justify-content-center">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Add this inside the modal-body, before modal-footer -->
                                <div id="upload-progress-pod" class="progress d-none" style="height: 20px; margin-top: 10px;">
                                    <div id="upload-progress-bar-pod" class="progress-bar progress-bar-striped progress-bar-animated" 
                                        role="progressbar" style="width: 0%">0%</div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" id="updateImageButton" disabled>Update Image</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Existing Company List Table -->
                    <div class="table-responsive col-12 mx-auto">
                        <table id="dataTableGallery" class="table table-striped table-bordered dt-responsive nowrap">
                            <thead>
                                <tr class="Table-header">
                                    <th>#ID</th>
                                    <th>Title</th>
                                    <th>Tour Name</th>
                                    <th>Image</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($gallary_n > 0) {
                                    // Fetch all tours for mapping id => name
                                    $tour_map = [];
                                    $tour_rs = Database::search("SELECT id, name FROM tour");
                                    while ($tour_row = $tour_rs->fetch_assoc()) {
                                        $tour_map[$tour_row['id']] = $tour_row['name'];
                                    }

                                    while ($row = $gallary_rs->fetch_assoc()) {
                                        // Get tour name or show '-' if not set
                                        $tour_name = isset($row["tour_id"]) && !empty($row["tour_id"]) && isset($tour_map[$row["tour_id"]]) ? $tour_map[$row["tour_id"]] : "-";
                                ?>
                                        <tr class="text-center">
                                            <td><?php echo $row["id"]; ?></td>
                                            <td><?php echo $row["title"]; ?></td>
                                            <td><?php echo $tour_name; ?></td>
                                            <td><img src="<?php echo $row["url"]; ?>" alt="Image" style="width: 70px; height: auto;"></td>
                                            <td>
                                                <button class="btn btn-sm btn-primary  edit-btn" onclick="updateImage(<?php echo $row['id']; ?>);">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-sm btn-success edit-btn" onclick="downloadPod(<?php echo $row['id']; ?>);">
                                                    <i class="fas fa-download"></i>
                                                </button>
                                                <button class="btn btn-sm btn-danger delete-btn" onclick="deleteImage(<?php echo $row['id']; ?>);">
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


<script>
    function previewImage(event, previewId) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById(previewId);
            output.src = reader.result;
            output.style.display = 'block';
        }
        reader.readAsDataURL(event.target.files[0]);
    }

    function loadTours(selectId, selectedValue = "") {
        fetch("../process/getTours.php")
            .then(res => res.json())
            .then(tours => {
                const select = document.getElementById(selectId);
                select.innerHTML = '<option value="">-- No Tour --</option>';
                tours.forEach(t => {
                    const opt = document.createElement('option');
                    opt.value = t.id;
                    opt.textContent = t.name;
                    if (selectedValue && selectedValue == t.id) opt.selected = true;
                    select.appendChild(opt);
                });
            });
    }

    // Load for Add modal
    document.getElementById('addImageModal').addEventListener('show.bs.modal', function () {
        loadTours('tour_id');
    });

    // Load for Update modal (with selected)
    document.getElementById('updateImageModal').addEventListener('show.bs.modal', function () {
        // selected value will be set after loading image data
        loadTours('update_tour_id');
    });
</script>