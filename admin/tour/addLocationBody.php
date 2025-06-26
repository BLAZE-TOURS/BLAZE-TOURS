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
                        </div>
                        <div class="form-group mb-3">
                            <label for="description" class="form-label">Description:</label>
                            <textarea name="description" id="description" class="form-control" rows="4" required></textarea>
                        </div>
                        <div class="form-group mb-4 d-flex align-items-center">
                            <label for="stop_duration_time" class="form-label mb-0 me-2">Add Stop Time Duration:</label>
                            <input type="number" name="stop_duration_time" id="stop_duration_time" class="form-control" min="0" required style="width:100px;">
                            <span class="ms-2">min</span>
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
        from { opacity: 0; }
        to { opacity: 1; }
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

<script>
let map, marker, autocomplete;

function initMap() {
    const defaultLoc = { lat: 7.2906, lng: 80.6337 };
    map = new google.maps.Map(document.getElementById("map"), {
        center: defaultLoc,
        zoom: 8
    });

    marker = new google.maps.Marker({
        map: map,
        draggable: true,
        position: defaultLoc
    });

    autocomplete = new google.maps.places.Autocomplete(document.getElementById('searchInput'));
    autocomplete.bindTo('bounds', map);

    autocomplete.addListener('place_changed', function () {
        const place = autocomplete.getPlace();
        if (!place.geometry) return;

        map.setCenter(place.geometry.location);
        map.setZoom(15);

        marker.setPosition(place.geometry.location);

        document.getElementById('address').value = place.formatted_address || '';
        document.getElementById('lat').value = place.geometry.location.lat();
        document.getElementById('lng').value = place.geometry.location.lng();
        if (place.name) document.getElementById('name').value = place.name;
    });

    marker.addListener('dragend', function () {
        const pos = marker.getPosition();
        document.getElementById('lat').value = pos.lat();
        document.getElementById('lng').value = pos.lng();

        // Reverse geocode to get address
        const geocoder = new google.maps.Geocoder();
        geocoder.geocode({ location: pos }, function(results, status) {
            if (status === 'OK' && results[0]) {
                document.getElementById('address').value = results[0].formatted_address;
            }
        });
    });
}

window.onload = initMap;

// AJAX form submission
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('locationForm');
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(form);

        document.getElementById('loading-spinner1').classList.remove('d-none');

        fetch('../process/addMarkerProcess.php', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            document.getElementById('loading-spinner1').classList.add('d-none');
            if (data.success) {
                document.getElementById('success-message1').classList.remove('d-none');
                document.getElementById('success-message1').textContent = 'Location added!';
                form.reset();
            } else {
                document.getElementById('validation-errors1').classList.remove('d-none');
                document.getElementById('validation-errors1').textContent = 'Error: ' + data.message;
            }
        })
        .catch(err => {
            document.getElementById('loading-spinner1').classList.add('d-none');
            document.getElementById('validation-errors1').classList.remove('d-none');
            document.getElementById('validation-errors1').textContent = 'AJAX error: ' + err;
        });
    });
});
</script>

