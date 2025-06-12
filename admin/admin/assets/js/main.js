function changeDashboardView() {
    history.pushState(null, '', 'adminindex.php?view=dashboard');
    sessionStorage.setItem('currentView', 'dashboard');
    hideAllContainers();
    document.querySelector('.content-page').style.display = 'block';
}

function changeDashboardViewEmail() {
    history.pushState(null, '', 'adminindex.php?view=email');
    sessionStorage.setItem('currentView', 'email');
    hideAllContainers();
    var emailFormContainer = document.getElementById('emailFormContainer');
    emailFormContainer.classList.remove('d-none');
    emailFormContainer.style.display = 'block';
}

function changeDashboardViewCompany() {
    history.pushState(null, '', 'adminindex.php?view=companies');
    sessionStorage.setItem('currentView', 'companies');
    hideAllContainers();
    var companyFormContainer = document.getElementById('CompanyFormContainer');
    companyFormContainer.classList.remove('d-none');
    companyFormContainer.style.display = 'block';
}

function changeDashboardViewSubscribers() {
    history.pushState(null, '', 'adminindex.php?view=Subscribers');
    sessionStorage.setItem('currentView', 'Subscribers');
    hideAllContainers();
    var subscriberContainer = document.getElementById('SubscriberContainer');
    subscriberContainer.classList.remove('d-none');
    subscriberContainer.style.display = 'block';
}

function changeDashboardViewMedi() {
    history.pushState(null, '', 'adminindex.php?view=Medi');
    sessionStorage.setItem('currentView', 'Medi');
    hideAllContainers();
    var mediContainer = document.getElementById('mediContainer');
    mediContainer.classList.remove('d-none');
    mediContainer.style.display = 'block';
}

function changeDashboardViewMedArrivedi() {
    history.pushState(null, '', 'adminindex.php?view=MediArrived');
    sessionStorage.setItem('currentView', 'MediArrived');
    hideAllContainers();
    var mediMediArrivedContainer = document.getElementById('mediMediArrivedContainer');
    mediMediArrivedContainer.classList.remove('d-none');
    mediMediArrivedContainer.style.display = 'block';
}


function changeDashboardViewToursType() {
    history.pushState(null, '', 'adminindex.php?view=ToursType');
    sessionStorage.setItem('currentView', 'ToursType');
    hideAllContainers();
    var toursTypeContainer = document.getElementById('toursTypeContainer');
    toursTypeContainer.classList.remove('d-none');
    toursTypeContainer.style.display = 'block';
}

function changeDashboardViewGallary() {
    history.pushState(null, '', 'adminindex.php?view=Gallary');
    sessionStorage.setItem('currentView', 'Gallary'); // Ensure key matches retrieval
    hideAllContainers();
    var gallaryContainer = document.getElementById('gallaryContainer');
    gallaryContainer.classList.remove('d-none');
    gallaryContainer.style.display = 'block';
}

//msg
function changeDashboardViewMessages() {
    history.pushState(null, '', 'adminindex.php?view=Messages');
    sessionStorage.setItem('currentView', 'Messages'); // Ensure key matches retrieval
    hideAllContainers();
    var MessagesContainer = document.getElementById('MessagesContainer');
    MessagesContainer.classList.remove('d-none');
    MessagesContainer.style.display = 'block';
}

//replied
function changeDashboardViewReplied() {
    history.pushState(null, '', 'adminindex.php?view=Replied');
    sessionStorage.setItem('currentView', 'Replied'); // Ensure key matches retrieval
    hideAllContainers();
    var RepliedContainer = document.getElementById('RepliedContainer');
    RepliedContainer.classList.remove('d-none');
    RepliedContainer.style.display = 'block';
}


function changeDashboardViewShorts() {
    history.pushState(null, '', 'adminindex.php?view=Shorts');
    sessionStorage.setItem('currentView', 'Shorts'); // Ensure key matches retrieval
    hideAllContainers();
    var gallaryContainer = document.getElementById('shortsContainer');
    gallaryContainer.classList.remove('d-none');
    gallaryContainer.style.display = 'block';
}

function changeDashboardViewStory() {
    history.pushState(null, '', 'adminindex.php?view=Story');
    sessionStorage.setItem('currentView', 'Story'); // Ensure key matches retrieval
    hideAllContainers();
    var gallaryContainer = document.getElementById('StoryContainer');
    gallaryContainer.classList.remove('d-none');
    gallaryContainer.style.display = 'block';
}



function hideAllContainers() {
    document.querySelector('.content-page').style.display = 'none';
    var containers = ['emailFormContainer', 'CompanyFormContainer', 'SubscriberContainer', 'gallaryContainer', 'shortsContainer', '', 'mediContainer', 'toursTypeContainer', 'mediMediArrivedContainer', 'MessagesContainer', 'RepliedContainer', 'StoryContainer'];
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
            case 'email':
                changeDashboardViewEmail();
                break;
            case 'companies':
                changeDashboardViewCompany();
                break;
            case 'Subscribers':
                changeDashboardViewSubscribers();
                break;
            case 'Gallary': // Ensured correct key match
                changeDashboardViewGallary();
                break;
            case 'Shorts': // Ensured correct key match
                changeDashboardViewShorts();
                break;
            case 'Medi': // Ensured correct key match
                changeDashboardViewMedi();
                break;
            case 'ToursType': // Ensured correct key match
                changeDashboardViewToursType();
                break;
            case 'MediArrived': // Ensured correct key match
                changeDashboardViewMedArrivedi();
                break;
            case 'Messages': // Ensured correct key match
                changeDashboardViewMessages();
                break;
            case 'Replied': // Ensured correct key match
                changeDashboardViewReplied();
                break;
            case 'Story': // Ensured correct key match
                changeDashboardViewStory();
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
