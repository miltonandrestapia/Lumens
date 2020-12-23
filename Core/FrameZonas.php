<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Zonas</title>
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

      // This example creates a simple polygon representing the Bermuda Triangle.

      function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 12,
          center: {<?php
session_start();     
require_once("Procesamiento/Conexion.php"); 

$ecodempresa="";

 


$completaconsulta=" 1=1";

if(isset($_SESSION['LMNS_dpto'])) {
    if ($_SESSION['LMNS_dpto']!="") {
      $completaconsulta.=" AND Departamento='".mysqli_real_escape_string($mysqli,$_SESSION['LMNS_dpto'])."'";
    }
}

if(isset($_SESSION['LMNS_unidad'])){
  if ($_SESSION['LMNS_unidad']!="") {
    $completaconsulta.=" AND unidad_negocio='".mysqli_real_escape_string($mysqli,$_SESSION["LMNS_unidad"])."' ";
  }
}


   $consulta="SELECT lat,lon,nombre,fechageo,cons FROM agentes 
     WHERE  ".$completaconsulta."
     order by fechageo desc limit 1 "; 



     $datos=mysqli_query($mysqli,$consulta);       

$cont=0; $nombrezona="";
  while($row=mysqli_fetch_row($datos)){
     echo 'lat: '.$row[0].',  lng: '.$row[1].'';
     
  } 
?>
}
        });

<?php
$zonarepo="";
  $zonaguia="";
  $consultaz="SELECT cons,nombre,poligono,codigo FROM zonas WHERE 
  ".$completaconsulta." "; 
  $datosz=mysqli_query($mysqli,$consultaz);   
     while($rowz=mysqli_fetch_row($datosz)){ 
          $zonaguia=$rowz[3];$zonarepo=$rowz[3];
          echo "
          var ".$rowz[3]." = [".$rowz[2]."];";
     }

?>

      google.maps.event.addListener(map, 'click', function(e) {
           segunzona(e.latLng,<?php echo $zonarepo.'pol';?>);
        });


<?php

  $zonarepo="";
  $consultaz="SELECT cons,nombre,poligono,codigo FROM zonas WHERE 
  ".$completaconsulta." "; 
  $datosz=mysqli_query($mysqli,$consultaz);   
     while($rowz=mysqli_fetch_row($datosz)){ 
          $zonarepo=$rowz[3];
          $color="purple";
          if($zonaguia==$zonarepo){
            $color="blue";
          }

        echo "

       // Construct the polygon.
        var ".$rowz[3]."pol = new google.maps.Polygon({
          paths: ".$rowz[3].",
         strokeColor: '".$color."',
          strokeOpacity: 0.8,
          strokeWeight: 2,
          fillColor: '".$color."',
          fillOpacity: 0.1,
          content: '".$rowz[1]."',
          contento: '".$rowz[3]."pol'
        });
        ".$rowz[3]."pol.setMap(map);
        ".$rowz[3]."pol.addListener('click', showArrays);"; 
     }
?>


        infoWindow = new google.maps.InfoWindow;
 




function showArrays(event) {
  evalue(event.latLng,this.content,<?php echo $zonarepo."pol";?>);
}

function segunzona(cord,poligono){

          if(google.maps.geometry.poly.containsLocation(cord, poligono)){  
             infoWindow.setContent("Dentro De Zona<br> gps:"+cord);
          }else{
             infoWindow.setContent("Fuera De Zona<br> gps:"+cord);
          }
      infoWindow.setPosition(cord);
      infoWindow.open(map);
}

function evalue(valor,contentString,contento){ 
 
  if(google.maps.geometry.poly.containsLocation(valor, contento)){

    infoWindow.setContent("<b>"+contentString+"</b><br>Dentro De Zona<br> gps:"+valor);
  }else{
    infoWindow.setContent("<b>"+contentString+"</b><br>Fuera De Zona<br> gps:"+valor);
  }

    infoWindow.setPosition(valor);
    infoWindow.open(map);
}



      }
    </script>
  
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB6BgNEUueTy1f0zxDi6PZO6dKFHx7s3jw&libraries=geometry&callback=initMap"
         async defer></script>
  </body>
</html>