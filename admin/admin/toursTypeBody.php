<div class="content-page mt-5 fade-in">

    <div class="row justify-content-center mt-2">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h3 class="card-title text-center">Meditation Schedule List</h3>

                    <!-- Add New Company Section -->
                    <div class="mb-4">
                        <h4>Add New Meditation Schedule</h4>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addMeditationTypeModal">
                            <i class="fas fa-plus"></i> Create
                        </button>
                    </div>

                    <!-- Add Meditation Type Modal -->
                    <div class="modal fade" id="addMeditationTypeModal" tabindex="-1" aria-labelledby="addMeditationTypeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addMeditationTypeModalLabel">Add New Meditation Schedule</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div id="validation-errors-meditation" class="alert alert-danger d-none" role="alert"></div>
                                    <div id="success-message-meditation" class="alert alert-success d-none" role="alert"></div>
                                    <form id="addMeditationTypeForm" enctype="multipart/form-data">
                                        <div class="row g-3">
                                            <div class="col-12">
                                                <label for="meditation_name" class="form-label">Meditation Schedule Name</label>
                                                <input type="text" class="form-control" name="meditation_name" id="meditation_name" required>
                                            </div>
            
                                            <div class="col-12">
                                                <label for="meditation_start_time" class="form-label">Start Time</label>
                                                <input type="time" class="form-control" name="meditation_start_time" id="meditation_start_time" required>
                                            </div>
                                            <div class="col-12">
                                                <label for="meditation_end_time" class="form-label">End Time</label>
                                                <input type="time" class="form-control" name="meditation_end_time" id="meditation_end_time" required>
                                            </div>
                                            <div class="col-12">
                                                <label for="meditation_description" class="form-label">Description</label>
                                                <textarea class="form-control" name="meditation_description" id="meditation_description" rows="3" required></textarea>
                                            </div>
                                            <div class="col-12">
                                                <label for="meditation_image" class="form-label">Image</label>
                                                <input type="file" class="form-control" name="meditation_image" id="meditation_image" accept="image/*" onchange="previewImage(event, 'meditation_image_preview')" required>
                                                <img id="meditation_image_preview" src="#" alt="Image Preview" style="display:none;max-width:100px;margin-top:10px;" />
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div id="loading-spinner-meditation" class="d-none">
                                    <div class="d-flex justify-content-center">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" onclick="addMeditationType();" form="addMeditationTypeForm">Add Schedule</button>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Update Meditation Type Modal -->
                    <div class="modal fade" id="updateMediTypeModal" tabindex="-1" aria-labelledby="updateMediTypeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg"> 
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="updateMediTypeModalLabel">Update Meditation Schedule</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div id="validation-errors-meditation-update" class="alert alert-danger d-none" role="alert"></div>
                                    <div id="success-message-meditation-update" class="alert alert-success d-none" role="alert"></div>
                                    <form id="updateMeditationTypeForm" enctype="multipart/form-data">
                                        <input type="hidden" name="id" id="update_meditation_id">
                                        <div class="row g-3">
                                            <div class="col-12">
                                                <label for="update_meditation_name" class="form-label">Meditation Schedule Name</label>
                                                <input type="text" class="form-control" name="meditation_name" id="update_meditation_name" required>
                                            </div>
                                            
                                            <div class="col-12">
                                                <label for="update_meditation_start_time" class="form-label">Start Time</label>
                                                <input type="time" class="form-control" name="meditation_start_time" id="update_meditation_start_time" required>
                                            </div>
                                            <div class="col-12">
                                                <label for="update_meditation_end_time" class="form-label">End Time</label>
                                                <input type="time" class="form-control" name="meditation_end_time" id="update_meditation_end_time" required>
                                            </div>
                                            <div class="col-12">
                                                <label for="update_meditation_description" class="form-label">Description</label>
                                                <textarea class="form-control" name="meditation_description" id="update_meditation_description" rows="3" required></textarea>
                                            </div>
                                            <div class="col-12">
                                                <label for="update_meditation_image" class="form-label">Image</label>
                                                <input type="file" class="form-control" name="meditation_image" id="update_meditation_image" accept="image/*" onchange="previewImage(event, 'update_meditation_image_preview')">
                                                <img id="update_meditation_image_preview" src="#" alt="Image Preview" style="display:none;max-width:100px;margin-top:10px;" />
                                                <div id="current-image-container" class="mt-2"></div>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div id="loading-spinner-meditation-update" class="d-none">
                                    <div class="d-flex justify-content-center">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" onclick="submitUpdateMeditationType();">Update Meditation Schedule</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Existing Company List Table -->
                    <div class="table-responsive col-12 mx-auto">
                        <table id="datatable-tourType" class="table table-striped table-bordered dt-responsive nowrap">
                            <thead>
                                <tr class="Table-header">
                                    <th>#ID</th>
                                    <th>Tours Type Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($toursType_n > 0) {
                                    while ($row = $toursType_rs->fetch_assoc()) {
                                ?>
                                        <tr class="text-center">
                                            <td><?php echo $row["id"]; ?></td>
                                            <td><?php echo $row["name"]; ?></td>
                                            <td>
                                                <button class="btn btn-sm btn-success edit-btn" onclick="updateMediType(<?php echo $row['id']; ?>);">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-sm btn-danger delete-btn" onclick="deleteMediType(<?php echo $row['id']; ?>);">
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