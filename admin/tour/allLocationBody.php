<div class="content-page mt-5 fade-in">

    <div class="row justify-content-center mt-2">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h3 class="card-title text-center">All Location List</h3>

                    <div class="mb-3" style="max-width: 300px; margin-left: 0; margin-right: auto;">
                        <label for="SelectTourName" class="form-label">Select Tour Name</label>
                        <select id="SelectTourName" class="form-select">
                            <option value="">All</option>
                            <?php
                            require_once __DIR__ . '/../connection.php';
                            $tour_query = "SELECT id, name FROM tour";
                            $tour_result = Database::search($tour_query);
                            if ($tour_result && $tour_result->num_rows > 0) {
                                while ($tour = $tour_result->fetch_assoc()) {

                                    echo '<option value="' . htmlspecialchars($tour['id']) . '">' . htmlspecialchars($tour['name']) . '</option>';
                                }
                            }
                            ?>
                        </select>
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
                                    <form id="updateLocationForm" enctype="multipart/form-data">
                                        <input type="hidden" name="id" id="update_location_id">
                                        <input type="hidden" name="tour_id" id="update_location_tour_id">

                                        <div class="form-group mb-3">
                                            <input id="update_searchInput" class="form-control" type="text" placeholder="Search location">
                                        </div>
                                        <div id="update_map" style="width:100%;height:300px;" class="mb-4"></div>

                                        <div class="form-group mb-3">
                                            <label for="update_location_name" class="form-label">Name:</label>
                                            <input name="name" id="update_location_name" class="form-control" required>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="update_location_address" class="form-label">Address:</label>
                                            <input name="address" id="update_location_address" class="form-control" required>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="update_location_lat" class="form-label">Latitude:</label>
                                            <input name="lat" id="update_location_lat" class="form-control" required readonly>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="update_location_lng" class="form-label">Longitude:</label>
                                            <input name="lng" id="update_location_lng" class="form-control" required readonly>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="update_icon" class="form-label">Icon Image:</label>
                                            <input type="file" name="icon" id="update_icon" class="form-control" accept="image/*">
                                            <div id="update-icon-info" class="mt-2">
                                                <span id="update-icon-filename" class="text-muted small"></span>
                                                <div id="update-icon-preview" style="max-width:60px;max-height:60px;"></div>
                                            </div>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="update_location_description" class="form-label">Description:</label>
                                            <textarea name="description" id="update_location_description" class="form-control" rows="4" required></textarea>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="update_location_stop_time" class="form-label">Add Stop Time Duration(min):</label>
                                            <input type="number" name="stop_duration_time" id="update_location_stop_time" class="form-control" min="0" required>
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
                            <tbody id="location-table-body">
                                <!-- Table rows will be loaded dynamically via JS. -->
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('SelectTourName').addEventListener('change', function() {
    const tourId = this.value;
    fetch('fetchLocationsByTour.php?tour_id=' + encodeURIComponent(tourId))
        .then(response => response.text())
        .then(html => {
            document.getElementById('location-table-body').innerHTML = html;
        });
});
</script>