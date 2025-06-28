function deleteLocation(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "This location will be deleted!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            // AJAX call to delete
            $.ajax({
                url: '../process/deleteLocationProcess.php',
                type: 'POST',
                data: { id: id },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        Swal.fire('Deleted!', response.message, 'success').then(() => {
                            location.reload(); // Reload the page after successful delete
                        });
                    } else {
                        Swal.fire('Error!', response.message, 'error');
                    }
                },
                error: function(xhr, status, error) {
                    console.log('AJAX Error:', xhr.responseText, status, error); // Log to browser console
                    Swal.fire('Error!', 'Something went wrong.<br><pre>' + xhr.responseText + '</pre>', 'error');
                }
            });
        }
    });
}

function confirmUpdateLocation(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "Do you want to update this location?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#aaa',
        confirmButtonText: 'Yes, update!',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            loadLocationData(id);
        }
    });
}

// --- UPDATE LOCATION MODAL MAP & FORM LOGIC ---
let updateMap, updateMarker, updateAutocomplete;

function destroyUpdateMap() {
    updateMap = null;
    updateMarker = null;
    updateAutocomplete = null;
}

function initUpdateMap(lat = 7.2906, lng = 80.6337, address = "") {
    const defaultLoc = { lat: parseFloat(lat), lng: parseFloat(lng) };
    updateMap = new google.maps.Map(document.getElementById("update_map"), {
        center: defaultLoc,
        zoom: 8,
    });
    updateMarker = new google.maps.Marker({
        map: updateMap,
        draggable: true,
        position: defaultLoc,
    });
    updateAutocomplete = new google.maps.places.Autocomplete(
        document.getElementById("update_searchInput")
    );
    updateAutocomplete.bindTo("bounds", updateMap);
    updateAutocomplete.addListener("place_changed", function () {
        const place = updateAutocomplete.getPlace();
        if (!place.geometry) return;
        updateMap.setCenter(place.geometry.location);
        updateMap.setZoom(15);
        updateMarker.setPosition(place.geometry.location);
        document.getElementById("update_location_address").value = place.formatted_address || "";
        document.getElementById("update_location_lat").value = place.geometry.location.lat();
        document.getElementById("update_location_lng").value = place.geometry.location.lng();
        if (place.name) document.getElementById("update_location_name").value = place.name;
    });
    updateMarker.addListener("dragend", function () {
        const pos = updateMarker.getPosition();
        document.getElementById("update_location_lat").value = pos.lat();
        document.getElementById("update_location_lng").value = pos.lng();
        // Reverse geocode to get address
        const geocoder = new google.maps.Geocoder();
        geocoder.geocode({ location: pos }, function (results, status) {
            if (status === "OK" && results[0]) {
                document.getElementById("update_location_address").value = results[0].formatted_address;
            }
        });
    });
}

// Show update modal and re-init map/autocomplete every time
$(document).on('shown.bs.modal', '#updateLocationModal', function () {
    // Destroy previous map/autocomplete if any
    destroyUpdateMap();
    // Get current values
    const lat = $('#update_location_lat').val() || 7.2906;
    const lng = $('#update_location_lng').val() || 80.6337;
    setTimeout(function() {
        initUpdateMap(lat, lng);
        document.getElementById('update_searchInput').focus();
    }, 200);
});

function loadLocationData(id) {
    $.ajax({
        url: '../process/getLocationById.php',
        type: 'POST',
        data: { id: id },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                $('#update_location_id').val(response.data.id);
                $('#update_location_tour_id').val(response.data.tour_id);
                $('#update_location_name').val(response.data.name);
                $('#update_location_address').val(response.data.address);
                $('#update_location_lat').val(response.data.lat);
                $('#update_location_lng').val(response.data.lng);
                $('#update_location_description').val(response.data.description);
                $('#update_location_stop_time').val(response.data.stop_duration_time);
                // Show current icon
                if (response.data.icon_url) {
                    $('#update-icon-preview').html('<img src="'+response.data.icon_url+'" style="max-width:60px;max-height:60px;border-radius:4px;">');
                } else {
                    $('#update-icon-preview').html('');
                }
                $('#update-icon-filename').text('');
                // Initialize map with current data
                setTimeout(function() {
                    initUpdateMap(response.data.lat, response.data.lng, response.data.address);
                }, 300);
                $('#updateLocationModal').modal('show');
            } else {
                Swal.fire('Error!', response.message, 'error');
            }
        },
        error: function(xhr) {
            Swal.fire('Error!', 'Could not load location data.', 'error');
        }
    });
}

// Handle file input for icon image in update modal
$(document).on('change', '#update_icon', function (e) {
    const file = e.target.files[0];
    const filenameSpan = document.getElementById("update-icon-filename");
    const previewDiv = document.getElementById("update-icon-preview");
    filenameSpan.textContent = file ? file.name : "";
    previewDiv.innerHTML = "";
    if (file && file.type.startsWith("image/")) {
        const reader = new FileReader();
        reader.onload = function (ev) {
            previewDiv.innerHTML = `<img src="${ev.target.result}" style="max-width:60px;max-height:60px;border-radius:4px;">`;
        };
        reader.readAsDataURL(file);
    }
});

function submitUpdateLocation() {
    var form = document.getElementById('updateLocationForm');
    var formData = new FormData(form);
    document.getElementById("validation-errors-location-update").classList.add("d-none");
    $.ajax({
        url: '../process/updateLocationProcess.php',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                $('#updateLocationModal').modal('hide');
                Swal.fire('Updated!', response.message, 'success').then(() => {
                    location.reload();
                });
            } else {
                $('#validation-errors-location-update').removeClass('d-none').text(response.message);
            }
        },
        error: function(xhr) {
            $('#validation-errors-location-update').removeClass('d-none').text('Update failed.');
        }
    });
}