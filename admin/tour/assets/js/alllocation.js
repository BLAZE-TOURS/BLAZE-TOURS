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

function loadLocationData(id) {
    $.ajax({
        url: '../process/getLocationById.php',
        type: 'POST',
        data: { id: id },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                $('#update_location_id').val(response.data.id);
                $('#update_location_name').val(response.data.name);
                $('#update_location_address').val(response.data.address);
                $('#update_location_lat').val(response.data.lat);
                $('#update_location_lng').val(response.data.lng);
                $('#update_location_description').val(response.data.description);
                $('#update_location_stop_time').val(response.data.stop_duration_time);
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

function submitUpdateLocation() {
    var formData = $('#updateLocationForm').serialize();
    $.ajax({
        url: '../process/updateLocationProcess.php',
        type: 'POST',
        data: formData,
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