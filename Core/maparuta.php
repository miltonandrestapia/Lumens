<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Travel Modes in Directions</title>
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      #floating-panel {
        position: absolute;
        top: 10px;
        left: 25%;
        z-index: 5;
        background-color: #fff;
        padding: 5px;
        border: 1px solid #999;
        text-align: center;
        font-family: 'Roboto','sans-serif';
        line-height: 30px;
        padding-left: 10px;
      }
    </style>
  </head>
  <body>


    <div id="map"></div>
    <div id="divpanel"></div>
    <script>
      function initMap() {
        var directionsDisplay = new google.maps.DirectionsRenderer;
        var directionsService = new google.maps.DirectionsService;
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 14,
          center: {lat: 37.77, lng: -122.447}
        });
        directionsDisplay.setMap(map);

        calculateAndDisplayRoute(directionsService, directionsDisplay);


      }
     var waypts = [];
      waypts.push({location: {lat: 10.947424999999999, lng: -74.78322333333334},stopover: true});
      waypts.push({location: {lat: 10.969434999999999, lng: -74.78997166666666},stopover: true});
      waypts.push({location: {lat: 10.984758333333332, lng: -74.81180666666667},stopover: true});
      waypts.push({location: {lat: 10.988628333333335, lng: -74.81189166666667},stopover: true});
      waypts.push({location: {lat: 10.968678333333333, lng: -74.80575666666667},stopover: true});
      waypts.push({location: {lat: 10.95382, lng: -74.80789166666666},stopover: true});
      waypts.push({location: {lat: 10.961404999999997, lng: -74.797675},stopover: true});
      waypts.push({location: {lat: 10.946403333333334, lng: -74.799105},stopover: true});
      waypts.push({location: {lat: 10.924116666666665, lng: -74.79765166666667},stopover: true});
      waypts.push({location: {lat: 10.922194999999999, lng: -74.81221833333333},stopover: true});
      waypts.push({location: {lat: 10.928159999999998, lng: -74.77861833333333},stopover: true});
      waypts.push({location: {lat: 10.926610000000002, lng: -74.78052333333333},stopover: true});
      waypts.push({location: {lat: 10.945048333333334, lng: -74.78477},stopover: true});

      function calculateAndDisplayRoute(directionsService, directionsDisplay) {
        var ediv =document.getElementById("divpanel");

        directionsService.route({
            origin: {lat: 11.001038333333334, lng: -74.823155},  
            destination: {lat: 11.001338333333334, lng: -74.823555},  
            waypoints: waypts,
            optimizeWaypoints: true,
            avoidTolls: true,
            travelMode: google.maps.TravelMode.DRIVING
        }, function(response, status) {
          if (status == 'OK') {
            directionsDisplay.setDirections(response);
            directionsDisplay.setPanel(ediv);
            console.log(response.routes[0]);

            console.log(response.routes[0].waypoint_order);
var j=0;
var sumakm=0;
var sumatiempo=0;
while(j<response.routes[0].legs.length){
sumakm=sumakm+ response.routes[0].legs[j].distance.value;
sumatiempo=sumatiempo+ response.routes[0].legs[j].duration.value;
  j++;
}
  alert("Distancia De Ruta: "+Math.round((sumakm/1000),2)+" Kms.<br> Tiempo Estimado: "+Math.round((sumatiempo/60),2)+" Min  ");

          } else {
            window.alert('Directions request failed due to ' + status);
          }
        });

        
      }
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB6BgNEUueTy1f0zxDi6PZO6dKFHx7s3jw&callback=initMap">
    </script>
  </body>
</html>