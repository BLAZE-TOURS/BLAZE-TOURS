function changeDashboardView() {
    // Update the URL without reloading the page
    history.pushState(null, '', 'adminindex.php?view=dashboard');

    // Store the current view in sessionStorage
    sessionStorage.setItem('currentView', 'dashboard');

    // Hide all content containers
    hideAllContainers();

    // Show the main content of the admin index page
    document.querySelector('.content-page').style.display = 'block';
}

function changeDashboardViewEmail() {
    // Update the URL without reloading the page
    history.pushState(null, '', 'adminindex.php?view=email');

    // Store the current view in sessionStorage
    sessionStorage.setItem('currentView', 'email');

    // Hide all content containers
    hideAllContainers();

    // Show the email sending form
    var emailFormContainer = document.getElementById('emailFormContainer');
    emailFormContainer.classList.remove('d-none');
    emailFormContainer.style.display = 'block';
}

function changeDashboardViewCompany() {
    // Update the URL without reloading the page
    history.pushState(null, '', 'adminindex.php?view=companies');

    // Store the current view in sessionStorage
    sessionStorage.setItem('currentView', 'companies');

    // Hide all content containers
    hideAllContainers();

    // Show the company form
    var companyFormContainer = document.getElementById('CompanyFormContainer');
    companyFormContainer.classList.remove('d-none');
    companyFormContainer.style.display = 'block';
}

function changeDashboardViewSubscribers() {
    // Update the URL without reloading the page
    history.pushState(null, '', 'adminindex.php?view=Subscribers');

    // Store the current view in sessionStorage
    sessionStorage.setItem('currentView', 'Subscribers');

    // Hide all content containers
    hideAllContainers();

    // Show the subscribers container
    var subscriberContainer = document.getElementById('SubscriberContainer');
    subscriberContainer.classList.remove('d-none');
    subscriberContainer.style.display = 'block';
}

function hideAllContainers() {
    // Hide all content containers
    document.querySelector('.content-page').style.display = 'none';
    document.getElementById('emailFormContainer').classList.add('d-none');
    document.getElementById('CompanyFormContainer').classList.add('d-none');
    document.getElementById('SubscriberContainer').classList.add('d-none');
}

// On page load, check the stored view and display the corresponding container
document.addEventListener('DOMContentLoaded', function() {
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
            var t = r.responseText;

            if (t == "success") {

                window.location.reload();

            } else {
                alert(t);
            }
        }
    }

    r.open("GET", "../process/signoutProcess.php", true);
    r.send();

}