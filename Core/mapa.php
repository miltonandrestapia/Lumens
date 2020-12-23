<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Ubicaciones En Vivo</title>
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
    </style>
  </head>
  <body>
    <div id="map"></div>
    <script>

      function initMap() {


        var image = 'images/beachflag.png';


        var myLatLng = {lat: 11.000953333333333, lng: -74.82318666666667} ;

        var map = new google.maps.Map(document.getElementById('map'), 
        {
          zoom: 13,
          center: myLatLng
        });

      var marker = new google.maps.Marker({
        position: myLatLng,
        map: map,
        icon: image,
        title: 'rtyrtyrtyt'
      });

      var    myLatLng = {lat: 11.000953333333333, lng: -74.81218666666667} ;
        var marker = new google.maps.Marker({
          position: myLatLng,
          map: map,
          icon: image,
          title: 'rtyrtyr'
        });

      var myLatLng = {lat: 11.000153333333333, lng: -74.82918666666667} ;
        var marker = new google.maps.Marker({
          position: myLatLng,
          icon: image,
          map: map,
          title: '1111'
        });


      }
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB6BgNEUueTy1f0zxDi6PZO6dKFHx7s3jw&callback=initMap">
    </script>
  </body>
</html>