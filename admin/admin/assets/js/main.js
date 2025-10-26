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

function changeDashboardViewCloseDays() {
    history.pushState(null, '', 'adminindex.php?view=CloseDays');
    sessionStorage.setItem('currentView', 'CloseDays');
    hideAllContainers();
    var companyFormContainer = document.getElementById('CloseDaysContainer');
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
    history.pushState(null, '', 'adminindex.php?view=Booking');
    sessionStorage.setItem('currentView', 'Booking');
    hideAllContainers();
    var mediContainer = document.getElementById('mediContainer');
    mediContainer.classList.remove('d-none');
    mediContainer.style.display = 'block';
}

function changeDashboardViewMedArrivedi() {
    history.pushState(null, '', 'adminindex.php?view=BookingArrived');
    sessionStorage.setItem('currentView', 'BookingArrived');
    hideAllContainers();
    var mediMediArrivedContainer = document.getElementById('mediMediArrivedContainer');
    mediMediArrivedContainer.classList.remove('d-none');
    mediMediArrivedContainer.style.display = 'block';
}

function changeDashboardViewBookingClosed() {
    history.pushState(null, '', 'adminindex.php?view=BookingClosed');
    sessionStorage.setItem('currentView', 'BookingClosed');
    hideAllContainers();
    var mediMediArrivedContainer = document.getElementById('BookingClosedContainer');
    mediMediArrivedContainer.classList.remove('d-none');
    mediMediArrivedContainer.style.display = 'block';
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


function changeDashboardViewCurrency() {
    history.pushState(null, '', 'adminindex.php?view=Currency');
    sessionStorage.setItem('currentView', 'Currency'); // Ensure key matches retrieval
    hideAllContainers();
    var gallaryContainer = document.getElementById('CurrencyContainer');
    gallaryContainer.classList.remove('d-none');
    gallaryContainer.style.display = 'block';
}

function changeDashboardViewPayout() {
    history.pushState(null, '', 'adminindex.php?view=Payout');
    sessionStorage.setItem('currentView', 'Payout'); // Ensure key matches retrieval
    hideAllContainers();
    var gallaryContainer = document.getElementById('PayoutContainer');
    gallaryContainer.classList.remove('d-none');
    gallaryContainer.style.display = 'block';
}

function changeDashboardViewCreateInvoice() {
    history.pushState(null, '', 'adminindex.php?view=CreateInvoice');
    sessionStorage.setItem('currentView', 'CreateInvoice'); // Ensure key matches retrieval
    hideAllContainers();
    var gallaryContainer = document.getElementById('CreateInvoiceContainer');
    gallaryContainer.classList.remove('d-none');
    gallaryContainer.style.display = 'block';
}

function hideAllContainers() {
    document.querySelector('.content-page').style.display = 'none';
    var containers = ['emailFormContainer', 'CompanyFormContainer', 'SubscriberContainer', 'gallaryContainer', 'shortsContainer', '', 'mediContainer', 'mediMediArrivedContainer', 'MessagesContainer', 'RepliedContainer', 'StoryContainer', 'CloseDaysContainer', 'BookingClosedContainer', 'CurrencyContainer', 'PayoutContainer', 'CreateInvoiceContainer'];
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

            case 'CloseDays': // Ensured correct key match
                changeDashboardViewCloseDays();
                break;
            case 'Shorts': // Ensured correct key match
                changeDashboardViewShorts();
                break;
            case 'Booking': // Ensured correct key match
                changeDashboardViewMedi();
                break;
            case 'BookingArrived': // Ensured correct key match
                changeDashboardViewMedArrivedi();
                break;
            case 'BookingClosed': // Ensured correct key match
                changeDashboardViewBookingClosed();
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
            case 'Currency': // Ensured correct key match
                changeDashboardViewCurrency();
                break;
            case 'Payout': // Ensured correct key match
                changeDashboardViewPayout();
                break;
            case 'CreateInvoice': // Ensured correct key match
                changeDashboardViewCreateInvoice();
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
