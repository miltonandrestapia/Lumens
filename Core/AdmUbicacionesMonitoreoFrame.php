<!DOCTYPE html>
<html>
  <head>
    <META HTTP-EQUIV="RjEFRESH" CONTENT="j60">
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
<?php


      require_once("Procesamiento/Conexion.php");
      $consulta="SELECT lat,lon,nombre,fechageo,cons FROM agentes WHERE DATE(fechageo)='".mysqli_real_escape_string($mysqli,$_GET["cod"])."' and usuario in (".$_GET["mns"].") "; 
     $datos=mysqli_query($mysqli,$consulta);       

$cont=0;
if(mysqli_num_rows($datos)>0){     
  while($row=mysqli_fetch_row($datos)){ 

        echo '  var    myLatLng = {lat: '.$row[0].', lng: '.$row[1].'} ;';
        if($cont==0){
            echo "
            var map = new google.maps.Map(document.getElementById('map'), 
            {
              zoom: 14,
              center: myLatLng
            });";
            $cont++;
        }  

echo '  
var marker'.$row[4].' = new google.maps.Marker({
          position: myLatLng,
          map: map,
          icon: image,
          title: "'.$row[3].' - '.$row[2].'"
        });';
  }
}else{
  alert("Ningun Agente Registrando.");
}


?>



      }
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB6BgNEUueTy1f0zxDi6PZO6dKFHx7s3jw&callback=initMap">
    </script>
  </body>
</html>