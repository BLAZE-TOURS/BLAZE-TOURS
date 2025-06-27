 <?php require '../connection.php'; ?>

 <!DOCTYPE html>
 <html>

 <head>
     <title>Live Map | BLAZE TOURS (PVT) LTD </title>
     <link rel="icon" type="image/png" href="../SignIn/images/Untit1.png" />
     <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCzj96kj0RB6UZ7iNAvuLm6fLBWO4mfa5A"></script>
     <script>
         function LoadMap() {
             const center = {
                 lat: 7.2906,
                 lng: 80.6337
             }; // Center on Sri Lanka
             const map = new google.maps.Map(document.getElementById("map"), {
                 zoom: 10,
                 center: center
             });

             fetch("fetchLivemap.php")
                 .then(response => response.json())
                 .then(data => {
                     data.forEach(marker => {
                         const position = {
                             lat: parseFloat(marker.lat),
                             lng: parseFloat(marker.lng)
                         };

                         const mapMarker = new google.maps.Marker({
                             position: position,
                             map: map,
                             title: marker.name,
                             icon: {
                                 url: marker.icon_url, // Use the path as stored in DBmg/maker/icon_684925cc6dc9c.png
                                 scaledSize: new google.maps.Size(40, 40), // Resize icon
                                 anchor: new google.maps.Point(20, 40) // Anchor bottom-center
                             }
                         });

                         const infoWindow = new google.maps.InfoWindow({
                             content: `
    <div style="
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: #ffffff;
      border-radius: 10px;
      padding: 12px 16px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      color: #333;
      max-width: 250px;
      line-height: 1.5;
    ">
      <h3 style="margin: 0 0 6px; font-size: 16px; color: #2c3e50;">${marker.name}</h3>
      <p style="margin: 0 0 6px; font-size: 14px;">📍 ${marker.address}</p>
      ${marker.description ? `<p style="margin: 0 0 6px; font-style: italic; color: #555;">📝 ${marker.description}</p>` : ''}
      <p style="margin: 0; font-size: 14px; color: #666;">⏱️ Stop: ${marker.stop_duration_time || 0} min</p>
    </div>
  `
                         });


                         mapMarker.addListener("click", () => {
                             infoWindow.open(map, mapMarker);
                         });
                     });
                 })
                 .catch(err => {
                     console.error("Failed to load marker data:", err);
                 });
         }
     </script>
     <style>
         #map {
             height: 100vh;
             width: 100%;
         }
     </style>
 </head>

 <body onload="LoadMap()">
     <div id="map"></div>
 </body>

 </html>