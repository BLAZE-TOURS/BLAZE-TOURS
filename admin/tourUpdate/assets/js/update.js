$(document).ready(function () {
    var id = getParameterByName('id');
    if (!id) {
        alert('No tour id provided in URL.');
        return;
    }
    $.get('fetchTourById.php?id=' + id, function(data) {
        try {
            window.tourData = typeof data === 'string' ? JSON.parse(data) : data;
        } catch (e) {
            window.tourData = null;
        }
        fillTourForm();
    });
});

// Helper to get query parameter from URL
function getParameterByName(name) {
    const url = window.location.href;
    name = name.replace(/[\[\]]/g, '\\$&');
    const regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)');
    const results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, ' '));
}

function fillTourForm() {
    if (!window.tourData) return;
    $('#name').val(tourData.name || '');
    $('#tourType').val(tourData.tours_type_id || '');
    $('#message').val(tourData.description || '');
    $('#Duration').val(tourData.duration || '');
    $('#subject').val(tourData.kids_price || '');
    $('#adult-price').val(tourData.adult_price || '');
    $('#body-title').val(tourData.maximum_people_count || '');

    // Times
    if (Array.isArray(tourData.times)) {
        window.times = tourData.times;
        if (typeof renderTimeList === 'function') renderTimeList();
    }

    // Highlights
    if (Array.isArray(tourData.highlights)) {
        window.highlights = tourData.highlights;
        if (typeof renderHighlightList === 'function') renderHighlightList();
    }

    // Images
    if (tourData.images) {
        if (tourData.images.main_image) {
            $('#main-image-preview').html('<img src="../' + tourData.images.main_image.replace(/^(\.\.\/)+/, '') + '" style="max-width:120px;max-height:120px;" class="me-2 mb-2 rounded shadow-sm">');
        }
        if (tourData.images.second_image) {
            $('#second-image-preview').html('<img src="../' + tourData.images.second_image.replace(/^(\.\.\/)+/, '') + '" style="max-width:120px;max-height:120px;" class="me-2 mb-2 rounded shadow-sm">');
        }
    }

    // Locations
    if (Array.isArray(tourData.locations)) {
        window.locations = tourData.locations.map(function (loc) {
            return {
                name: loc.name,
                address: loc.address,
                lat: loc.lat,
                lng: loc.lng,
                stop_duration_time: loc.stop_duration_time,
                description: loc.description,
                iconPreview: loc.icon_url ? '../tour/' + loc.icon_url : ''
            };
        });
        if (typeof renderLocationTable === 'function') renderLocationTable();
    }
}
window.fillTourForm = fillTourForm;