$('#updateTourBtn').on('click', function () {
    const formData = new FormData();

    // Basic Fields
    formData.append('name', $('input[name="name"]').val());
    formData.append('tourType', $('select[name="tourType"]').val());
    formData.append('message', $('textarea[name="message"]').val());
    formData.append('Duration', $('input[name="Duration"]').val());
    formData.append('subject', $('input[name="subject"]').val());
    formData.append('adult-price', $('input[name="adult-price"]').val());
    formData.append('body-title', $('input[name="body-title"]').val());

    // Optional: add tour_id if updating
    const selectedTourId = $('#SelectTourName').val();
    if (selectedTourId) {
        formData.append('tour_id', selectedTourId);
    }

    // Append times, highlights, locations as JSON
    formData.append('times', JSON.stringify(times)); // times array from JS
    formData.append('highlights', JSON.stringify(highlights)); // highlights array from JS
    formData.append('locations', JSON.stringify(locations)); // locations array from JS

    // Files (images)
    const mainImage = $('#main-image')[0].files[0];
    const secondImage = $('#second-image')[0].files[0];
    if (mainImage) formData.append('main_image', mainImage);
    if (secondImage) formData.append('second_image', secondImage);

    // Show loader
    $('#loading-spinner1').removeClass('d-none');

    // Send AJAX
    $.ajax({
        url: '../tour/addCompleteTourProcess.php',
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (res) {
            $('#loading-spinner1').addClass('d-none');
            if (res.success) {
                $('#success-message1').removeClass('d-none').text(res.message);
                $('#validation-errors1').addClass('d-none');
                $('html, body').animate({ scrollTop: 0 }, 'slow');
            } else {
                $('#validation-errors1').removeClass('d-none').text(res.message);
                $('#success-message1').addClass('d-none');
            }
        },
        error: function (xhr, status, error) {
            $('#loading-spinner1').addClass('d-none');
            $('#validation-errors1').removeClass('d-none').text("AJAX error: " + error);
            $('#success-message1').addClass('d-none');
        }
    });
});
// End of file: admin/tour/addToursBody.php
// --- a/file:///c%3A/xampp/htdocs/BLAZE-TOURS/admin/tour/addCompleteTourProcess.php
// +++ b/file:///c%3A/xampp/htdocs/BLAZE-TOURS/admin/tour/addCompleteTourProcess.php
// @@ -1,6 +1,7 @@  