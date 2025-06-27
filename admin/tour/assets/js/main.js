function changeDashboardView() {
    history.pushState(null, '', 'adminindex.php?view=Tours');
    sessionStorage.setItem('currentView', 'Tours');
    hideAllContainers();
    document.querySelector('.content-page').style.display = 'block';
}

function changeDashboardViewToursType() {
    history.pushState(null, '', 'adminindex.php?view=ToursType');
    sessionStorage.setItem('currentView', 'ToursType');
    hideAllContainers();
    var toursTypeContainer = document.getElementById('toursTypeContainer');
    toursTypeContainer.classList.remove('d-none');
    toursTypeContainer.style.display = 'block';
}

function changeDashboardViewAddTour() {
    history.pushState(null, '', 'adminindex.php?view=AddTours');
    sessionStorage.setItem('currentView', 'AddTours');
    hideAllContainers();
    var addToursContainer = document.getElementById('addToursContainer');
    addToursContainer.classList.remove('d-none');
    addToursContainer.style.display = 'block';
}

function changeDashboardViewAddLocation() {
    history.pushState(null, '', 'adminindex.php?view=AddLocation');
    sessionStorage.setItem('currentView', 'AddLocation');
    hideAllContainers();
    var addLocationContainer = document.getElementById('addLocationContainer');
    addLocationContainer.classList.remove('d-none');
    addLocationContainer.style.display = 'block';
}

function changeDashboardViewLivemap() {
    history.pushState(null, '', 'adminindex.php?view=Livemap');
    sessionStorage.setItem('currentView', 'Livemap');
    hideAllContainers();
    var liveMapContainer = document.getElementById('liveMapContainer');
    liveMapContainer.classList.remove('d-none');
    liveMapContainer.style.display = 'block';
}

function hideAllContainers() {
    document.querySelector('.content-page').style.display = 'none';
    var containers = ['toursTypeContainer', 'toursContainer', 'addToursContainer', 'addLocationContainer','liveMapContainer'];
    // Add any other container IDs you want to hide here
    containers.forEach(function (id) {
        var element = document.getElementById(id);
        if (element) {
            element.classList.add('d-none');
        }
    });
}

// On page load, check the stored view and display the corresponding container
document.addEventListener('DOMContentLoaded', function () {
    var currentView = sessionStorage.getItem('currentView');
    if (currentView) {
        switch (currentView) {
            case 'Tours':
                changeDashboardView();
                break;
            case 'ToursType': // Ensured correct key match
                changeDashboardViewToursType();
                break;
            case 'AddTours': // Ensured correct key match
                changeDashboardViewAddTour();
                break;
            case 'AddLocation': // Ensured correct key match
                changeDashboardViewAddLocation();
                break;
            case 'Livemap': // Ensured correct key match
                changeDashboardViewLivemap();
                break;
            default:
                changeDashboardView();
        }
    } else {
        changeDashboardView();
    }
});

function signout() {
    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            if (r.responseText == "success") {
                sessionStorage.removeItem('currentView'); // Clear session storage on signout
                window.location.reload();
            } else {
                alert(r.responseText);
            }
        }
    };
    r.open("GET", "../process/signoutProcess.php", true);
    r.send();
}
