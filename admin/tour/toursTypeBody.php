<div class="content-page mt-5 fade-in">

    <div class="row justify-content-center mt-2">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h3 class="card-title text-center">Tour Type List</h3>

                    <!-- Add New Company Section -->
                    <div class="mb-4">
                        <h4>Add New Tour Type</h4>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addToursTypeModal">
                            <i class="fas fa-plus"></i> Create
                        </button>
                    </div>

                    <!-- Add New Tours Type Modal -->
                    <div class="modal fade" id="addToursTypeModal" tabindex="-1" aria-labelledby="addToursTypeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addToursTypeModalLabel">Add New Tour Type</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div id="validation-errors-tours" class="alert alert-danger d-none" role="alert"></div>
                                    <div id="success-message-tours" class="alert alert-success d-none" role="alert"></div>
                                    <form id="addToursTypeForm">
                                        <div class="row g-3">
                                            <div class="col-12">
                                                <label for="tours_name" class="form-label">Tour Type Name</label>
                                                <input type="text" class="form-control" name="tours_name" id="tours_name" required>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div id="loading-spinner-tours" class="d-none">
                                    <div class="d-flex justify-content-center">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" onclick="addToursType();" form="addToursTypeForm">Add Tour Type</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Update Tours Type Modal -->
                    <div class="modal fade" id="updateToursTypeModal" tabindex="-1" aria-labelledby="updateToursTypeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="updateToursTypeModalLabel">Update Tour Type</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div id="validation-errors-tours-update" class="alert alert-danger d-none" role="alert"></div>
                                    <div id="success-message-tours-update" class="alert alert-success d-none" role="alert"></div>
                                    <form id="updateToursTypeForm">
                                        <input type="hidden" name="id" id="update_tours_id">
                                        <div class="row g-3">
                                            <div class="col-12">
                                                <label for="update_tours_name" class="form-label">Tour Type Name</label>
                                                <input type="text" class="form-control" name="tours_name" id="update_tours_name" required>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div id="loading-spinner-tours-update" class="d-none">
                                    <div class="d-flex justify-content-center">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" onclick="submitUpdateToursType();">Update Tour Type</button>
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
                                                <button class="btn btn-sm btn-success edit-btn" onclick="updateToursType(<?php echo $row['id']; ?>);">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-sm btn-danger delete-btn" onclick="deleteToursType(<?php echo $row['id']; ?>);">
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