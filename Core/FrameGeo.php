<!DOCTYPE html>
<html>
  <head>
    <META HTTP-EQUIV="REFRESH" CONTENT="200">
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <meta http-Equiv="Cache-Control" Content="no-cache">
    <meta http-Equiv="Pragma" Content="no-cache">
    <meta http-Equiv="Expires" Content="0">
    <link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
    <script src="js/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" language="javascript" src="Ext/jquery.dataTables.js"></script>
    <link rel="stylesheet" type="text/css" href="Ext/jquery.dataTables.css">
    <script src="js/bootstrap.js"> </script>
    <link href="css/font-awesome.css" rel="stylesheet"> 

    <title>Zonas</title>
    <style>
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
var dentrozona=0;
var fuerazona=0;
var inactivos=0;
var finalizados=0;
var sinjornada=0;
var dentrozonatext="0";
var fuerazonatext="0";
var inactivostext="0";
var finalizadostext="0";
var sinjornadatext="0";


      // This example creates a simple polygon representing the Bermuda Triangle.

      function initMap() {

          var image = 'images/beachflag.png';
          var imagebad = 'images/beachflagbad.png';
          var imageoff = 'images/beachflagOff.png';
          var imageblack = 'images/beachflagblack.png';
          var imagesinjornada = 'images/beachflagsinjornada.png';
<?php
session_start();     
require_once("Procesamiento/Conexion.php"); 



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
     WHERE DATE(fechageo)=CURDATE() and 
    ".$completaconsulta." order by fechageo desc limit 1 "; 
     $datos=mysqli_query($mysqli,$consulta);       

$cont=0;
if(mysqli_num_rows($datos)>0){     
  while($row=mysqli_fetch_row($datos)){ 

echo '  var    myLatLng = {lat: '.$row[0].', lng: '.$row[1].'} ;';
        if($cont==0){
            echo "
            var map = new google.maps.Map(document.getElementById('map'), 
            {
              zoom: 13,
              center: myLatLng
            });";
            $cont++;
        }  
/*
echo ' var marker'.$row[4].' = new google.maps.Marker({
          position: myLatLng,
          map: map,
          icon: image,
          title: "'.$row[3].' - '.$row[2].'"
        });';*/
  }
}else{
 echo 'alert("Ningun Agente Registrando.")';
}

  $zonarepo="";
  $consultaz="SELECT cons,nombre,poligono,codigo FROM zonas "; 
  $datosz=mysqli_query($mysqli,$consultaz);       
  while($rowz=mysqli_fetch_row($datosz)){ 
  $zonarepo=$rowz[3];

echo "

var ".$rowz[3]." = [".$rowz[2]."];

    // Construct the polygon.
        var ".$rowz[3]."pol = new google.maps.Polygon({
          paths: ".$rowz[3].",
          strokeColor: 'green',
          strokeOpacity: 0,
          strokeWeight: 0,
          fillColor: 'green',
          fillOpacity: 0,
          content: '".$rowz[1]."',
          contento: '".$rowz[3]."pol'
        });
        ".$rowz[3]."pol.setMap(map);
";  }

    $consulta="SELECT lat,lon,nombre,fechageo,cons,sector,TIMESTAMPDIFF(MINUTE ,fechageo,NOW()),sesionfin,DATE(fechageo),CURDATE() FROM agentes WHERE DATE(fechageo)>DATE_ADD(CURDATE(), INTERVAL - 60 DAY) and estadoagente='Activo' AND 
     ".$completaconsulta; 

     $datos=mysqli_query($mysqli,$consulta);       

$cont=0;
if(mysqli_num_rows($datos)>0){     
  while($row=mysqli_fetch_row($datos)){ 

        if($row[5]=="" || strlen($row[5])<3 ){  
         $row[5]=$zonarepo."pol ";
        }

    if($row[8]==$row[9]){   
    if($row[7]==""){   
      if($row[6]<20){    
        echo '
        var centerSfo'.$row[4].' = new google.maps.LatLng("'.$row[0].'","'.$row[1].'");
        evaluereal(centerSfo'.$row[4].',"'.$row[2].'",'.$row[5].'pol,"marker'.$row[4].'",1,"'.$row[3].'","'.$row[4].'");';
      }else{

        echo 'var centerSfo'.$row[4].' = new google.maps.LatLng("'.$row[0].'","'.$row[1].'");
        evaluereal(centerSfo'.$row[4].',"'.$row[2].'",'.$row[5].'pol,"marker'.$row[4].'",2,"'.$row[3].'","'.$row[4].'");';
      }
    }else{
        echo 'var centerSfo'.$row[4].' = new google.maps.LatLng("'.$row[0].'","'.$row[1].'");
        evaluereal(centerSfo'.$row[4].',"'.$row[2].'",'.$row[5].'pol,"marker'.$row[4].'",0,"'.$row[3].'","'.$row[4].'");';
    }
    }else{
      ECHO 'sinjornada=sinjornada+1;
            sinjornadatext=sinjornadatext+","+'.$row[4].';';
           
     }
  }
}


?>

function segunzona(cord,poligono){
          if(google.maps.geometry.poly.containsLocation(cord, poligono)){  
             infoWindow.setContent("Dentro De Zona<br> gps:"+cord);
          }else{
             infoWindow.setContent("Fuera De Zona<br> gps:"+cord);
          }
}

function evalue(valor,contentString,contento){ 
 
  if(google.maps.geometry.poly.containsLocation(valor, contento)){

    infoWindow.setContent("<b>"+contentString+"</b><br>Dentro De Zona<br> gps:"+valor);
  }else{
    infoWindow.setContent("<b>"+contentString+"</b><br>Fuera De Zona<br> gps:"+valor);
  }

}


function evaluereal(valor,contentString,contento,marcador,estado,efecha,codagente){  

  if(estado==1){
  if(google.maps.geometry.poly.containsLocation(valor, contento)){
    dentrozona=dentrozona+1;
    dentrozonatext=dentrozonatext+","+codagente;

     var marcador = new google.maps.Marker({
          position: valor,
          map: map,
          animation: google.maps.Animation.DROP,
          icon: image,
          title: contentString+" - "+efecha
        });

  }else{
    fuerazona=fuerazona+1;
    fuerazonatext=fuerazonatext+","+codagente;
     var marcador = new google.maps.Marker({
          position: valor,
          map: map,
          animation: google.maps.Animation.DROP,
          icon: imagebad,
          title: contentString+" - "+efecha
        });
  }
}else{

  if(estado==2){
        inactivos=inactivos+1;
        inactivostext=inactivostext+","+codagente;
       
       var marcador = new google.maps.Marker({
              position: valor,
              map: map,
              animation: google.maps.Animation.DROP,
              icon: imageoff,
              title: contentString+" - "+efecha
            });

    }else{
           finalizados=finalizados+1;
            finalizadostext=finalizadostext+","+codagente;
           
           var marcador = new google.maps.Marker({
                  position: valor,
                  map: map,
                  animation: google.maps.Animation.DROP,
                  icon: imageblack,
                  title: contentString+" - "+efecha
                });
        
    }

  }

        marcador.addListener('click', toggleBounce);
} 

function toggleBounce() {
        if (this.getAnimation() !== null) {
          this.setAnimation(null);
        } else {
          this.setAnimation(google.maps.Animation.BOUNCE);
        }
      }

document.getElementById("fuerazona").innerHTML=fuerazona;
document.getElementById("dentrozona").innerHTML=dentrozona;
document.getElementById("inactivos").innerHTML=inactivos;
document.getElementById("activos").innerHTML=(fuerazona+dentrozona);
document.getElementById("totalzona").innerHTML=(fuerazona+dentrozona+inactivos+finalizados);
document.getElementById("finalizados").innerHTML=finalizados;
document.getElementById("sinjornada").innerHTML=sinjornada;

      }
    </script>
  
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB6BgNEUueTy1f0zxDi6PZO6dKFHx7s3jw&libraries=geometry&callback=initMap&v=3.exp"
         async defer></script>




 <!-- Button trigger modal -->
<button type="button" id="btnResumen" class="btn btn-success" data-toggle="modal" data-target="#exampleModal" style="position: absolute; bottom: 20px; right: 5% ">
Ver Resumen
</button>
<style type="text/css">
  .circulo {
  float: right;
  width: 20px;
  height: 20px;
  border-radius: 50%;
  padding:3px;
  margin-right: 10px;
}
.claselabel{
   color: #000;
   background-color: white;
   border: 1px solid #000;
   font-family: "Lucida Grande", "Arial", sans-serif;
   font-size: 12px;
   text-align: center;
   white-space: nowrap;
   padding: 2px;
}
</style>
<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document" id="modaltamano">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="exampleModalLabel">Resumen Operativo - <span id="titulo"></span></h4>
      </div>
      <div class="modal-body" id="ContenidoDetalle" style="background-color: #f2f2f2">
      </div>
      <div class="modal-body" id="Contenido" style="background-color: #f2f2f2;width: 500px; margin: auto;">
        <center>
      <table id="example" class="display dataTable" >
        <thead>
          <tr>
           <th >Concepto</th>
           <th  width="30">Distintivo</th>
           <th width="30"  >Cantidad</th>
          <th >Detallar</th>
        </tr>
        </thead>
        <tbody>
          <tr>
            <td class="sobretd" style="text-align: right;">AGENTES ACTIVOS 
            </td>
            <td class="sobretd" >
              <div class="circulo" style="background-color: green"></div>
              <div class="circulo" style="background-color:#CC0000"></div>
            </td>
            <td width="30" class="sobretd" id="activos" style="text-align: center"></td>
            <td class="sobretd" >
              <button type="button" class="btn btn-info btn-circle" id="btnactivos"><i class="fa fa-search "></i></button>

            </td>
          </tr>
          <tr>
            <td class="sobretd"  style="text-align: right;">AGENTES INACTIVOS </td>
            <td class="sobretd" ><div class="circulo" style="background-color:#1B1BB1"></div></td>
            <td class="sobretd" id="inactivos" style="text-align: center"></td>
            <td class="sobretd" >
              <button type="button" class="btn btn-info btn-circle" id="btninactivos" ><i class="fa fa-search "></i></button></td>
          </tr>

          <tr>
            <td class="sobretd"  style="text-align: right;">JORNADA FINALIZADA</td>
            <td class="sobretd" >
              <div class="circulo" style="background-color:black"></div></td>
            <td class="sobretd" id="finalizados" style="text-align: center"></td>
            <td class="sobretd" >
              <button type="button" class="btn btn-info btn-circle" id="btnfinalizados" ><i class="fa fa-search "></i></button></td>
          </tr>

        </tbody>
        <tfoot>
          <tr>
           <th colspan="2" style="text-align: right;!important">TOTAL AGENTES ACTUALES</th>
           <th id="totalzona" style="text-align: center"></th>
          <th ></th>
          </tr>
        </tfoot></table>

</center></div>

      <div class="modal-header" style="border-top:solid 1px #ccc"> 
        <h4 class="modal-title" id="exampleModalLabel">Seguimiento Detallado</h4>
      </div>

      <div class="modal-body" id="Contenido2" style="background-color: #f2f2f2;width: 500px; margin: auto;">
        <center>

  <table id="example" class="display dataTable" >
        <thead>
          <tr>
           <th >Concepto</th>
           <th  width="30">Distintivo</th>
           <th width="30">Cantidad</th>
          <th >Detallar</th>
        </tr>
        </thead>
        <tbody>

          <tr>
            <td class="sobretd"  style="text-align: right;">DENTRO DE ZONA</td> 
              <td class="sobretd" >
              <div class="circulo" style="background-color:  green"></div></td>
            <td class="sobretd" id="dentrozona" style="text-align: center"></td>
            <td class="sobretd" >
              <button type="button" class="btn btn-info btn-circle" id="btndentrozona" ><i class="fa fa-search "></i></button></td>
          </tr>
          <tr>
            <td class="sobretd"  style="text-align: right;">FUERA DE ZONA
              </td>
            <td class="sobretd" >
              <div class="circulo" style="background-color:#CC0000"></div></td>
            <td class="sobretd" id="fuerazona" style="text-align: center"></td>
            <td class="sobretd" >
              <button type="button" class="btn btn-info btn-circle" id="btnfuerazona" ><i class="fa fa-search "></i></button></td>
          </tr>
          <tr>
            <td class="sobretd"  style="text-align: right;">SIN JORNADA ACTUAL</td>
            <td class="sobretd" ></td>
            <td class="sobretd" id="sinjornada" style="text-align: center"></td>
            <td class="sobretd" >
              <button type="button" class="btn btn-info btn-circle" id="btnsinjornada" ><i class="fa fa-search "></i></button></td>
          </tr>
      </tbody>
  </table>

</center>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary"  id="btnRegresar">Regresar</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>   <script type="text/javascript">

$(document).ready(function(){


    $("#modaltamano").removeClass("modal-lg");
    $("#titulo").html("Principal");
    $("#btnResumen").click();
    $("#ContenidoDetalle").hide();
    $("#btnRegresar").hide();
    $("#btnactivos").click(DetallarActividad);
    $("#btninactivos").click(DetallarActividad);
    $("#btndentrozona").click(DetallarActividad);
    $("#btnfuerazona").click(DetallarActividad);  
    $("#btnfinalizados").click(DetallarActividad);  
    $("#btnsinjornada").click(DetallarActividad);  
    $("#btnResumen").click(mostrarPrincipal);   
    $("#btnRegresar").click(mostrarPrincipal);   

});

function mostrarPrincipal(){

    $("#modaltamano").removeClass("modal-lg");
    $("#titulo").html("Principal");
    $("#btnRegresar").hide();
 $("#Contenido").show();
 $("#Contenido2").show();
 $("#ContenidoDetalle").hide();
}


function DetallarActividad(){
  
    $("#modaltamano").addClass("modal-lg");
    $("#btnRegresar").show();
 $("#Contenido").hide();
 $("#Contenido2").hide();
 $("#ContenidoDetalle").show();
 $("#ContenidoDetalle").html("<center>Cargando, Por Favor Espere...</center>");

var etipo="";

if($(this).attr("id")=="btninactivos"){
 $("#titulo").html("Inactivos");
etipo=inactivostext;
}else if($(this).attr("id")=="btndentrozona"){
 $("#titulo").html("Dentro De Zona");
etipo=dentrozonatext;
}else if($(this).attr("id")=="btnfuerazona"){
 $("#titulo").html("Fuera De Zona");
etipo=fuerazonatext;
}else if($(this).attr("id")=="btnactivos"){
 $("#titulo").html("Activos");
etipo=dentrozonatext+","+fuerazonatext;
}else if($(this).attr("id")=="btnfinalizados"){
 $("#titulo").html("Finalizados");
etipo=finalizadostext;
}else if($(this).attr("id")=="btnsinjornada"){
 $("#titulo").html("Sin Jornada Actual");
etipo=sinjornadatext;
}else{
  return false;
}

    var Datos = {
        "DetallarAgentes" : 'DetallarAgentes',
        "DetallarAgentes" : etipo
    };

    $.ajax({
          data:Datos,
          url:"Procesamiento/MdlMonitoreo.php",
          type:"POST",
        success:function(resp){
            $('#ContenidoDetalle').html(resp); 
            $('#exampleDetalle').DataTable();
        },
        error:function(resp){
            swal("Error!","Error Al Conectarse Al Servidor", "error");
        }
     });
}



 </script>
  </body>

</html>