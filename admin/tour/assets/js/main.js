function changeDashboardView() {
    history.pushState(null, '', 'adminindex.php?view=dashboard');
    sessionStorage.setItem('currentView', 'dashboard');
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


function hideAllContainers() {
    document.querySelector('.content-page').style.display = 'none';
    var containers = ['toursTypeContainer', ];
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
            case 'dashboard':
                changeDashboardView();
                break;
            case 'ToursType': // Ensured correct key match
                changeDashboardViewToursType();
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
