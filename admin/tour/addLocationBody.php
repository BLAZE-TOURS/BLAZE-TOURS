<?php

$tours = [];
$result = Database::search("SELECT id, name FROM tour ");
while ($row = $result->fetch_assoc()) {
    $tours[] = $row;
}
?>
<div class="content-page mt-5 fade-in">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-body p-5">
                    <h3 class="card-title text-center mb-4">Add a Location</h3>
                    <div id="validation-errors1" class="alert alert-danger d-none" role="alert"></div>
                    <div id="success-message1" class="alert alert-success d-none" role="alert"></div>

                    <div class="form-group mb-3">
                        <input id="searchInput" class="form-control" type="text" placeholder="Search location">
                    </div>
                    <div id="map" style="width:100%;height:300px;" class="mb-4"></div>

                    <form id="locationForm" action="../process/addMarkerProcess.php" method="POST" enctype="multipart/form-data">
                        <div class="form-group mb-3">
                            <label for="tour_id" class="form-label">Select Tour:</label>
                            <select name="tour_id" id="tour_id" class="form-control" required>
                                <option value="">-- Select Tour --</option>
                                <?php foreach ($tours as $tour): ?>
                                    <option value="<?= htmlspecialchars($tour['id']) ?>">
                                        <?= htmlspecialchars($tour['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="name" class="form-label">Name:</label>
                            <input name="name" id="name" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="address" class="form-label">Address:</label>
                            <input name="address" id="address" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="lat" class="form-label">Latitude:</label>
                            <input name="lat" id="lat" class="form-control" required readonly>
                        </div>
                        <div class="form-group mb-3">
                            <label for="lng" class="form-label">Longitude:</label>
                            <input name="lng" id="lng" class="form-control" required readonly>
                        </div>
                        <div class="form-group mb-3">
                            <label for="icon" class="form-label">Icon Image:</label>
                            <input type="file" name="icon" id="icon" class="form-control" accept="image/*" required>
                            <div id="icon-info" class="mt-2">
                                <span id="icon-filename" class="text-muted small"></span>
                                <div id="icon-preview" style="max-width:60px;max-height:60px;"></div>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="description" class="form-label">Description:</label>
                            <textarea name="description" id="description" class="form-control" rows="4" required></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label for="stop_duration_time" class="form-label">Add Stop Time Duration(min):</label>
                            <input type="number" name="stop_duration_time" id="stop_duration_time" class="form-control" min="0" required>
                        </div>
                        <div id="loading-spinner1" class="d-none">
                            <div class="d-flex justify-content-center">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary col-12 mt-3 mx-auto d-block btn-animate">Add Location</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
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
</style>