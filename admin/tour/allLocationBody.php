<div class="content-page mt-5 fade-in">

    <div class="row justify-content-center mt-2">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h3 class="card-title text-center">All Location List</h3>

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

                    <!-- Update Location Modal -->
                    <div class="modal fade" id="updateLocationModal" tabindex="-1" aria-labelledby="updateLocationModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="updateLocationModalLabel">Update Location</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div id="validation-errors-location-update" class="alert alert-danger d-none" role="alert"></div>
                                    <div id="success-message-location-update" class="alert alert-success d-none" role="alert"></div>
                                    <form id="updateLocationForm">
                                        <input type="hidden" name="id" id="update_location_id">
                                        <div class="row g-3">
                                            <div class="col-12">
                                                <label for="update_location_name" class="form-label">Location Name</label>
                                                <input type="text" class="form-control" name="name" id="update_location_name" required>
                                            </div>
                                            <div class="col-12">
                                                <label for="update_location_address" class="form-label">Address</label>
                                                <input type="text" class="form-control" name="address" id="update_location_address" disabled>
                                            </div>
                                            <div class="col-6">
                                                <label for="update_location_lat" class="form-label">Latitude</label>
                                                <input type="text" class="form-control" name="lat" id="update_location_lat" disabled>
                                            </div>
                                            <div class="col-6">
                                                <label for="update_location_lng" class="form-label">Longitude</label>
                                                <input type="text" class="form-control" name="lng" id="update_location_lng" disabled>
                                            </div>
                                            <div class="col-12">
                                                <label for="update_location_description" class="form-label">Description</label>
                                                <textarea class="form-control" name="description" id="update_location_description"></textarea>
                                            </div>
                                            <div class="col-12">
                                                <label for="update_location_stop_time" class="form-label">Stop Time</label>
                                                <input type="number" class="form-control" name="stop_duration_time" id="update_location_stop_time">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" onclick="submitUpdateLocation();">Update Location</button>
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
                                    <th>Location Name</th>
                                    <th>Address</th>
                                    <th>Lat</th>
                                    <th>Lng</th>
                                    <th>Icon</th>
                                    <th>Description</th>
                                    <th>Stop Time</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($allLocation_n > 0) {
                                    while ($row = $allLocation_rs->fetch_assoc()) {
                                ?>
                                        <tr class="text-center">
                                            <td><?php echo $row["id"]; ?></td>
                                            <td><?php echo $row["name"]; ?></td>
                                            <td>
                                                <?php
                                                    $address = explode(',', $row["address"], 2);
                                                    echo htmlspecialchars($address[0]);
                                                    if (isset($address[1])) {
                                                        echo "<br>" . htmlspecialchars($address[1]);
                                                    }
                                                ?>
                                            </td>
                                            <td><?php echo $row["lat"]; ?></td>
                                            <td><?php echo $row["lng"]; ?></td>
                                            <td>
                                                <?php if (!empty($row["icon_url"])): ?>
                                                    <img src="<?php echo htmlspecialchars($row["icon_url"]); ?>" alt="Icon" style="width:32px;height:32px;">
                                                <?php endif; ?>
                                            </td>
                                            <td style="max-width:200px; word-break:break-word; white-space:pre-line;">
                                                <?php echo htmlspecialchars($row["description"]); ?>
                                            </td> <!-- Hide column -->
                                            <td><?php echo $row["stop_duration_time"]; ?></td>
                                            <td>
                                                <button class="btn btn-sm btn-success edit-btn" onclick="confirmUpdateLocation(<?php echo $row['id']; ?>);">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-sm btn-danger delete-btn" onclick="deleteLocation(<?php echo $row['id']; ?>);">
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