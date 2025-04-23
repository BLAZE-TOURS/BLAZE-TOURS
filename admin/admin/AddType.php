<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Blaze Tuk Tuk Map</title>
  <style>
    #map {
      height: 500px;
      width: 100%;
      margin-top: 10px;
    }
    #search-box {
      width: 300px;
      margin-bottom: 10px;
    }
  </style>
</head>
<body>
  <h1>Blaze Tuk Tuk - Mark Multiple Locations</h1>
  <input id="search-box" type="text" placeholder="Search for a location" />
  <div id="map"></div>

  <script>
    let map;
    let markers = [];

    function initMap() {
      map = new google.maps.Map(document.getElementById("map"), {
        center: { lat: 7.8731, lng: 80.7718 },
        zoom: 8,
      });

      const input = document.getElementById("search-box");
      const searchBox = new google.maps.places.SearchBox(input);

      map.addListener("bounds_changed", () => {
        searchBox.setBounds(map.getBounds());
      });

      searchBox.addListener("places_changed", () => {
        const places = searchBox.getPlaces();
        if (places.length === 0) return;

        markers.forEach(marker => marker.setMap(null));
        markers = [];

        const bounds = new google.maps.LatLngBounds();
        places.forEach(place => {
          if (!place.geometry || !place.geometry.location) return;

          const marker = new google.maps.Marker({
            map,
            title: place.name,
            position: place.geometry.location,
          });
          markers.push(marker);

          if (place.geometry.viewport) bounds.union(place.geometry.viewport);
          else bounds.extend(place.geometry.location);
        });
        map.fitBounds(bounds);
      });

      map.addListener("click", e => {
        const marker = new google.maps.Marker({
          position: e.latLng,
          map,
        });
        markers.push(marker);

        console.log(`Marker added at: Latitude: ${e.latLng.lat()}, Longitude: ${e.latLng.lng()}`);
      });
    }

    window.gm_authFailure = function() {
      alert("Google Maps API key is invalid or restricted.");
    };
  </script>
      <script src="../assets/js/loader.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAmWjSKC0Z4RYKXjyD6t1aW_aFn7O79awA&libraries=places&callback=initMap" async defer loading="lazy" onerror="gm_authFailure()"></script>
</body>
</html>
