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

$('#tourSelected').on('change', function() {
    var tourId = $(this).val();
    $.ajax({
        url: 'process/filterLocationByTour.php',
        type: 'POST',
        data: { tour_id: tourId },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                var tbody = $('#datatable-tourType tbody');
                tbody.empty();
                if (response.data.length > 0) {
                    response.data.forEach(function(row) {
                        var address = row.address ? row.address.split(',', 2) : [];
                        var addressHtml = address[0] ? $('<div>').text(address[0]).html() : '';
                        if (address[1]) addressHtml += "<br>" + $('<div>').text(address[1]).html();
                        var iconHtml = row.icon_url ? '<img src="' + $('<div>').text(row.icon_url).html() + '" alt="Icon" style="width:32px;height:32px;">' : '';
                        tbody.append(
                            `<tr class="text-center">
                                <td>${row.id}</td>
                                <td>${$('<div>').text(row.name).html()}</td>
                                <td>${addressHtml}</td>
                                <td>${row.lat ?? ''}</td>
                                <td>${row.lng ?? ''}</td>
                                <td>${iconHtml}</td>
                                <td style="max-width:200px; word-break:break-word; white-space:pre-line;">${$('<div>').text(row.description ?? '').html()}</td>
                                <td>${row.stop_duration_time ?? ''}</td>
                                <td>
                                    <button class="btn btn-sm btn-success edit-btn" onclick="confirmUpdateLocation(${row.id});">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger delete-btn" onclick="deleteLocation(${row.id});">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </td>
                            </tr>`
                        );
                    });
                } else {
                    tbody.append('<tr><td colspan="9" class="text-center">No locations found.</td></tr>');
                }
            }
        }
    });
});