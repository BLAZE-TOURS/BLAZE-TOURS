<div class="content-page mt-5 fade-in">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-body p-5">
                    <h3 class="card-title text-center mb-4">Add Tour</h3>
                    <div id="validation-errors1" class="alert alert-danger d-none" role="alert"></div>
                    <div id="success-message1" class="alert alert-success d-none" role="alert"></div>

                    <form id="email-form">
                        <div class="form-group mb-3 d-flex gap-2 align-items-end">
                            <div class="flex-fill" style="flex:2;">
                                <label for="email" class="form-label">Tour Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="flex-fill" style="flex:1; max-width:380px;">
                                <label for="tourType" class="form-label">Tour Type</label>
                                <select class="form-select" id="tourType" name="tourType" required>
                                    <option value="" disabled selected>Select Tour Type</option>
                                    <?php
                                    include '../tour/fetchToursTypeForAdd.php';
                                    foreach ($toursType as $type) {
                                        echo "<option value='{$type['id']}'>{$type['name']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="cc-email" class="form-label">Description</label>
                            <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
                        </div>
                        <div class="form-group mb-3 d-flex gap-2 align-items-end">
                            <div class="flex-fill">
                                <label for="bcc-email" class="form-label">Duration</label>
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


                        <div id="loading-spinner1" class="d-none">
                            <div class="d-flex justify-content-center">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                        </div>
                        <button type="button" id="addTourBtn" class="btn btn-primary col-12 mt-3 mx-auto d-block btn-animate">Add Tour</button>
                    </form>
                </div>
            </div>

        </div>
        <!-- Processing Tours Dropdown with label and margin -->
        <div class="mt-4">
            <label for="SelectTourName" class="form-label fw-bold mb-2">Select Processing Tour</label>
            <?php
            $query = Database::search("SELECT * FROM `tour` WHERE `status_id` = '3'");
            if ($query && $query->num_rows > 0) {
                echo '<select id="SelectTourName" class="form-select">';
                echo '<option value="">Select</option>';
                while ($row = $query->fetch_assoc()) {
                    echo '<option value="' . htmlspecialchars($row['id']) . '">' . htmlspecialchars($row['name']) . '</option>';
                }
                echo '</select>';
            } else {
                echo '<select id="SelectTourName" class="form-select">';
                echo '<option value="">No processing tours found</option>';
                echo '</select>';
            }
            ?>
        </div>
        <!--  -->
        <!-- Hiden Update Form -->
        <div class="col-md-12" id="updateTourFormContainer" style="display:none;">
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
                                    include '../tour/fetchToursTypeForAdd.php';
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
                            <h5>Add Location</h5>
                            <div class="row justify-content-center">
                                <div class="col-md-12">
                                    <div class="card shadow-lg border-0 rounded-lg">
                                        <div class="card-body p-4">
                                            <div class="form-group mb-3">
                                                <input id="searchInput" class="form-control" type="text" placeholder="Search location" autocomplete="off">
                                            </div>
                                            <div id="map" style="width:100%;height:300px;" class="mb-4"></div>
                                            <form id="locationForm" action="" method="POST" enctype="multipart/form-data">
                                                <div class="form-group mb-3">
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
                        <div id="loading-spinner2" class="d-none">
                            <div class="d-flex justify-content-center">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                        </div>
                        <button type="button" id="updateTourBtn" class="btn btn-success col-12 mt-3 mx-auto d-block btn-animate" style="font-size:1.3rem; padding: 0.75rem 0;">Update Tour</button>
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




<!-- JS for Hiden Update Form -->
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
            center: { lat: 7.8731, lng: 80.7718 }, // Default: Sri Lanka center
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
            document.getElementById('searchInput'),
            { types: [] } // Allow all place types for better suggestions
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

    #main-image-preview img,
    #second-image-preview img {
        border: 1px solid #ddd;
        margin-bottom: 4px;
    }
</style>


<script>
    $(document).ready(function() {
        $.ajax({
            url: 'fechprocessingTour.php',
            method: 'GET',
            success: function(data) {
                $('#SelectTourName').html(data);
            },
            error: function() {
                $('#SelectTourName').html('<option value="">Error loading tours</option>');
            }
        });
    });
</script>

<script>
    // Hide update form by default
    $(document).ready(function() {
        $('#updateTourFormContainer').hide();
        $('#SelectTourName').on('change', function() {
            const selectedId = $(this).val();
            if (!selectedId) {
                $('#updateTourFormContainer').hide();
                // Optionally clear form fields here
                return;
            }
            // Show the form
            $('#updateTourFormContainer').show();
            // Fetch tour data by ID
            $.ajax({
                url: 'fetchTourById.php',
                method: 'GET',
                data: { id: selectedId },
                dataType: 'json',
                success: function(data) {
                    if (data) {
                        // Populate simple tour details section
                        $('#updateTourFormContainer input[name="name"]').val(data.name);
                        $('#updateTourFormContainer select[name="tourType"]').val(data.tours_type_id);
                        $('#updateTourFormContainer textarea[name="message"]').val(data.description);
                        $('#updateTourFormContainer input[name="Duration"]').val(data.duration);
                        $('#updateTourFormContainer input[name="subject"]').val(data.kids_price);
                        $('#updateTourFormContainer input[name="adult-price"]').val(data.adult_price);
                        $('#updateTourFormContainer input[name="body-title"]').val(data.maximum_people_count);
                    }
                },
                error: function() {
                    alert('Failed to fetch tour data.');
                }
            });
        });
    });
</script>