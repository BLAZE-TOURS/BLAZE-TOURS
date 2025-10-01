$('#updateTourBtn').on('click', function () {
    const formData = new FormData();

    // 1. Basic Fields from update form
    formData.append('name', $('#updateTourFormContainer input[name="name"]').val());
    formData.append('tourType', $('#updateTourFormContainer select[name="tourType"]').val());
    formData.append('message', $('#updateTourFormContainer textarea[name="message"]').val());
    formData.append('Duration', $('#updateTourFormContainer input[name="Duration"]').val());
    formData.append('subject', $('#updateTourFormContainer input[name="subject"]').val());
    formData.append('adult-price', $('#updateTourFormContainer input[name="adult-price"]').val());
    formData.append('update-adult-count', $('#updateTourFormContainer input[name="update-adult-count"]').val());
    formData.append('update-kids-count', $('#updateTourFormContainer input[name="update-kids-count"]').val());

    // 2. tour_id for update
    const selectedTourId = $('#SelectTourName').val();
    if (selectedTourId) {
        formData.append('tour_id', selectedTourId);
    }

    // 3. Times from time-list
    let updateTimes = [];
    $('#updateTourFormContainer #time-list li').each(function () {
        const timeText = $(this).clone().children().remove().end().text().replace('Remove', '').trim();
        if (timeText) updateTimes.push(timeText);
    });
    formData.append('times', JSON.stringify(updateTimes));

    // 4. Highlights from highlight-list
    let updateHighlights = [];
    $('#updateTourFormContainer #highlight-list li').each(function () {
        const highlightText = $(this).clone().children().remove().end().text().replace('Remove', '').trim();
        if (highlightText) updateHighlights.push(highlightText);
    });
    formData.append('highlights', JSON.stringify(updateHighlights));

    // 5. Locations: use the locations array (should be updated by your add location logic)
    if (typeof locations !== "undefined") {
        formData.append('locations', JSON.stringify(locations));
    }

    // 6. Images from update form
    const mainImage = $('#updateTourFormContainer #main-image')[0]?.files[0];
    const secondImage = $('#updateTourFormContainer #second-image')[0]?.files[0];
    if (mainImage) formData.append('main_image', mainImage);
    if (secondImage) formData.append('second_image', secondImage);

    // Show loader
    $('#loading-spinner2').removeClass('d-none');

    // Send AJAX
    $.ajax({
        url: '../tour/process/addCompleteTourProcess.php', // <-- Use the correct path
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function (res) {
            $('#loading-spinner2').addClass('d-none');
            if (res.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: res.message,
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location.reload();
                });
                $('#success-message1').addClass('d-none');
                $('#validation-errors1').addClass('d-none');
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: res.message
                });
                $('#validation-errors1').removeClass('d-none').text(res.message);
                $('#success-message1').addClass('d-none');
            }
        },
        error: function (xhr, status, error) {
            $('#loading-spinner2').addClass('d-none');
            $('#validation-errors1').removeClass('d-none').text("AJAX error: " + error);
            $('#success-message1').addClass('d-none');
        }
    });
});
// End of file: admin/tour/addToursBody.php
// --- a/file:///c%3A/xampp/htdocs/BLAZE-TOURS/admin/tour/addCompleteTourProcess.php
// +++ b/file:///c%3A/xampp/htdocs/BLAZE-TOURS/admin/tour/addCompleteTourProcess.php
// @@ -1,6 +1,7 @@