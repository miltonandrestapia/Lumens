<!DOCTYPE html>
<html>
  <head> 
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

if($_GET["tipo"]=="Publicidad"){
       $consulta="SELECT  lat,lon,hora FROM publicidad WHERE 
     usuario='".mysqli_real_escape_string($mysqli,$_GET["agente"])."' 
     AND fecha='".mysqli_real_escape_string($mysqli,$_GET["fecha"])."' ORDER BY hora ASC"; 
}else{
       if($_GET["tipo"]=="Asignaciones"){

            $completa="";
            if($_GET["codcl"]!=""){
              $completa=" and codcliente='".mysqli_real_escape_string($mysqli,$_GET["codcl"])."'";
            }
            $consulta="SELECT platitud,plongitud,fecharealizado FROM principal WHERE 
            codagente='".mysqli_real_escape_string($mysqli,$_GET["agente"])."' 
            AND fechaestado='".mysqli_real_escape_string($mysqli,$_GET["fecha"])."' 
            ".$completa." ORDER BY fecharealizado ASC"; 
            

        }else{
                $consulta="SELECT  lat,lon,hora FROM tracking WHERE 
             usuario='".mysqli_real_escape_string($mysqli,$_GET["agente"])."' 
             AND fecha='".mysqli_real_escape_string($mysqli,$_GET["fecha"])."' ORDER BY hora ASC"; 
        }

}


     $datos=mysqli_query($mysqli,$consulta);       

$cont=1;
$escdatos="";
if(mysqli_num_rows($datos)>0){     
  while($row=mysqli_fetch_row($datos)){ 
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

$escdatos.= '  
var marker'.$cont.' = new google.maps.Marker({
          position: myLatLng,
          map: map,
          icon: {
            path: google.maps.SymbolPath.CIRCLE,
          strokeColor: "red",
            scale: 4
        },
          title: "'.$row[2].'"
        });';         
        }else{ 
      $escdatos.= '  
var marker'.$cont.' = new google.maps.Marker({
          position: myLatLng,
          map: map,
          icon: {
            path: google.maps.SymbolPath.CIRCLE,
          strokeColor: "purple",
            scale:	1
        },
          title: "'.$row[2].'"
        });';
    }
 $cont++;
  }
echo $escdatos;
  echo 'var lineSymbol = { path: google.maps.SymbolPath.FORWARD_CLOSED_ARROW, 
          strokeColor: "blue",
            fillColor: "blue", 
          strokeOpacity: 0.8,
          fillOpacity: 0.8,
          strokeWeight: 1  };


  var flightPlanCoordinates = [ '.$coordenadas.' ];
  var flightPath = new google.maps.Polyline({
          path: flightPlanCoordinates,
          icons: [{ icon: lineSymbol,offset: "100%",repeat:"150px" }],
          geodesic: true,
          travelMode: "walking",
          strokeColor: "purple",
          strokeOpacity: 0.8,
          strokeWeight: 3
        });
';
}else{
  alert("Ningun Agente Registrando.");
}


?>

        flightPath.setMap(map);
animateCircle(flightPath);/*
function animateCircle(line) {
  let count = 0;
  window.setInterval(() => {
    count = (count + 1) % 200;
    const icons = line.get("icons");
    icons[0].offset = count / 2 + "%";
    line.set("icons", icons);
  }, 80);
}*/
      }
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB6BgNEUueTy1f0zxDi6PZO6dKFHx7s3jw&callback=initMap">
    </script>
  </body>
</html>