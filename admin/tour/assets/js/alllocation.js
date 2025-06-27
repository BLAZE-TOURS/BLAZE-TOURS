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