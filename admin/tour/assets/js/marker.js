let map, marker, autocomplete;

function initMap() {
    const defaultLoc = { lat: 7.2906, lng: 80.6337 };
    map = new google.maps.Map(document.getElementById("map"), {
        center: defaultLoc,
        zoom: 8,
    });

    marker = new google.maps.Marker({
        map: map,
        draggable: true,
        position: defaultLoc,
    });

    autocomplete = new google.maps.places.Autocomplete(
        document.getElementById("searchInput")
    );
    autocomplete.bindTo("bounds", map);

    autocomplete.addListener("place_changed", function () {
        const place = autocomplete.getPlace();
        if (!place.geometry) return;

        map.setCenter(place.geometry.location);
        map.setZoom(15);

        marker.setPosition(place.geometry.location);

        document.getElementById("address").value = place.formatted_address || "";
        document.getElementById("lat").value = place.geometry.location.lat();
        document.getElementById("lng").value = place.geometry.location.lng();
        if (place.name) document.getElementById("name").value = place.name;
    });

    marker.addListener("dragend", function () {
        const pos = marker.getPosition();
        document.getElementById("lat").value = pos.lat();
        document.getElementById("lng").value = pos.lng();

        // Reverse geocode to get address
        const geocoder = new google.maps.Geocoder();
        geocoder.geocode({ location: pos }, function (results, status) {
            if (status === "OK" && results[0]) {
                document.getElementById("address").value = results[0].formatted_address;
            }
        });
    });
}

window.onload = initMap;

// AJAX form submission
document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("locationForm");
    form.addEventListener("submit", function (e) {
        e.preventDefault();

        const formData = new FormData(form);

        document.getElementById("loading-spinner1").classList.remove("d-none");

        fetch("../process/addMarkerProcess.php", {
            method: "POST",
            body: formData,
        })
            .then((res) => res.json())
            .then((data) => {
                document.getElementById("loading-spinner1").classList.add("d-none");
                if (data.success) {
                    Swal.fire({
                        icon: "success",
                        title: "Location added!",
                        text: "Your location was successfully added.",
                        timer: 1500,
                        showConfirmButton: false,
                    }).then(() => {
                        window.location.reload();
                    });
                    form.reset();
                    document.getElementById("icon-filename").textContent = "";
                    document.getElementById("icon-preview").innerHTML = "";
                } else {
                    document
                        .getElementById("validation-errors1")
                        .classList.remove("d-none");
                    document.getElementById("validation-errors1").textContent =
                        "Error: " + data.message;
                }
            })
            .catch((err) => {
                document.getElementById("loading-spinner1").classList.add("d-none");
                document
                    .getElementById("validation-errors1")
                    .classList.remove("d-none");
                document.getElementById("validation-errors1").textContent =
                    "AJAX error: " + err;
            });
    });
});

// Handle file input for icon image
document.getElementById("icon").addEventListener("change", function (e) {
    const file = e.target.files[0];
    const filenameSpan = document.getElementById("icon-filename");
    const previewDiv = document.getElementById("icon-preview");
    filenameSpan.textContent = file ? file.name : "";
    previewDiv.innerHTML = "";
    if (file && file.type.startsWith("image/")) {
        const reader = new FileReader();
        reader.onload = function (ev) {
            previewDiv.innerHTML = `<img src="${ev.target.result}" style="max-width:60px;max-height:60px;border-radius:4px;">`;
        };
        reader.readAsDataURL(file);
    }
});
