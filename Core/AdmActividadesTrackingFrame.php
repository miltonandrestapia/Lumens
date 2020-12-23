<!DOCTYPE html>
<html>
  <head>
    <META HTTP-EQUIV="REFRESH" CONTENT="60">
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    
    <meta http-Equiv="Cache-Control" Content="no-cache">
    <meta http-Equiv="Pragma" Content="no-cache">
    <meta http-Equiv="Expires" Content="0">
    <title>Tracking</title>
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

      var image = 'images/beachflagcircle.png';

<?php


require_once("Procesamiento/Conexion.php");

$coordenadas="";



        $consulta="SELECT  platitud,plongitud,fecharealizado,direccion FROM principal WHERE 
     codagente='".mysqli_real_escape_string($mysqli,$_GET["agente"])."' 
     AND codactividad='".mysqli_real_escape_string($mysqli,$_GET["cod"])."' and estado='Realizado' ORDER BY fecharealizado ASC"; 


     $datos=mysqli_query($mysqli,$consulta);       

$cont=1;
$escdatos="";
if(mysqli_num_rows($datos)>0){     
  while($row=mysqli_fetch_row($datos)){
  if($row[0]!="0" && $row[0]!=""){ 
$coordenadas.='{lat:'.$row[0].', lng:'.$row[1].'},';

$escdatos.='  var    myLatLng = {lat: '.$row[0].', lng: '.$row[1].'} ;';
        if($cont==mysqli_num_rows($datos)){

echo '  var    myLatLng = {lat: '.$row[0].', lng: '.$row[1].'} ;';
            echo "
            var map = new google.maps.Map(document.getElementById('map'), 
            {
              zoom: 16,
              center: myLatLng
            });";           
        }  
 $cont++;
$escdatos.= '  
var marker'.$cont.' = new google.maps.Marker({
          position: myLatLng,
          map: map,
          icon: image,
          title: "'.$row[3].' | '.$row[2].'"
        });';
}else{
   $cont++;
}

  }
echo $escdatos;
  echo 'var lineSymbol = { path: google.maps.SymbolPath.FORWARD_CLOSED_ARROW    };


  var flightPlanCoordinates = [ '.$coordenadas.' ];
  var flightPath = new google.maps.Polyline({
          path: flightPlanCoordinates,
          icons: [{ icon: lineSymbol,offset: "100%" }],
          geodesic: false,
          travelMode: "walking",
          strokeColor: "#0066CC",
          strokeOpacity: 0.7,
          strokeWeight: 2
        });
';
}else{
  echo 'alert("Ningun Agente Registrando.");';
}


?>


        flightPath.setMap(map);

      }
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB6BgNEUueTy1f0zxDi6PZO6dKFHx7s3jw&callback=initMap">
    </script>
  </body>
</html>