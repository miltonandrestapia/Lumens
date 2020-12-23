<?php
session_start();     
  require_once("Procesamiento/Conexion.php");  
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Lumens | Bienvenido!</title>
<!-- Bootstrap Core CSS -->
<link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
<!-- Custom CSS -->
<link href="css/style.css" rel='stylesheet' type='text/css' />
 <!-- js-->
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/modernizr.custom.js"></script>

<script src="js/Chart.js"></script>
<!-- //chart -->
</head> 

<?php


$cantidad=0;
$efectivos=0;
$noefectivos=0;
$textcantidad="";
$textefectivos="";
$textnoefectivos="";

$completa="";

if($_GET['tipo']!=""){
   $completa=" and tipo='".mysqli_real_escape_string($mysqli,$_GET['tipo'])."' "; 
}

if( $_SESSION['LMNS-USER_TIPO']=="Cliente"){
$consulta="SELECT fecha,SUM(cantidad),SUM(efectivos),SUM(noefectivos) FROM actividadclientes WHERE
fecha>='".mysqli_real_escape_string($mysqli,$_GET['Desde'])."' and
fecha<='".mysqli_real_escape_string($mysqli,$_GET['Hasta'])."'
".$completa."
and codempresa='".mysqli_real_escape_string($mysqli,$_SESSION['LMNS-USER_CODEC'])."'  AND codcliente='".$_SESSION['LMNS-USER_CLIENTE']."' GROUP BY fecha";
}else{
    $consulta="SELECT fecha,SUM(cantidad),SUM(efectivos),SUM(noefectivos) FROM actividad WHERE
    fecha>='".mysqli_real_escape_string($mysqli,$_GET['Desde'])."' and
    fecha<='".mysqli_real_escape_string($mysqli,$_GET['Hasta'])."'
    ".$completa."
    and codempresa='".mysqli_real_escape_string($mysqli,$_SESSION['LMNS-USER_CODE'])."' GROUP BY fecha";
}






 $datos=mysqli_query($mysqli,$consulta);      
while($row=mysqli_fetch_row($datos)){ 
    $cantidad=$cantidad+$row[1];
    $efectivos=$efectivos+$row[2];
    $noefectivos=$noefectivos+$row[3];

    $textefectivos.='{ X: "'.$row[0].'", Y: '.$row[2].' },';
    $textnoefectivos.='{ X: "'.$row[0].'", Y: '.$row[3].' },';
    $textcantidad.='{ X: "'.$row[0].'", Y: '.($row[1]-($row[2]+$row[3])).' },';
}
        ?>





        <div class="row-one widgettable">
            <div class="col-md-8 content-top-2 card">
                <div class="agileinfo-cdr">
                    <div class="card-header">
                        <h3>
                            <div class="col-md-9" align="left">Grafico Trazabilidad</div>
                            <div class="col-md-3" style="color: #164194; font-weight: bold; ">
                                <?php echo $cantidad?> Visitas</div>
                        </h3>
                    </div>                  
                        <div id="Linegraph" style="width: 100%; height: 375px">
                        </div>                      
                </div>
            </div>

            <div class="clearfix"> </div>
        </div>
        

    <!-- for index page weekly sales java script -->
    <script src="js/SimpleChart.js"></script>
    <script>
        var graphdata1 = {
            linecolor: "#FFC168",
            title: "No Realizadas",
            values: [
            <?php echo ($textcantidad);?>
            ]
        };
        var graphdata2 = {
            linecolor: "#00CC66",
            title: "No Efectivas",
            values: [              
            <?php echo $textnoefectivos;?>
            ]
        };
        var graphdata3 = {
            linecolor: "#8E43E7",
            title: "Efectivas",
            values: [
           
            <?php echo $textefectivos;?>
            ]
        };



        $(function () {
            $("#Linegraph").SimpleChart({
                ChartType: "Line",
                toolwidth: "40",
                toolheight: "20",
                axiscolor: "#E6E6E6",
                textcolor: "#6E6E6E",
                showlegends: true,
                data: [ graphdata3, graphdata2, graphdata1],
                legendsize: "50",
                legendposition: 'bottom',
                xaxislabel: 'Dias',
                title: '',
                yaxislabel: 'Cantidad De Registros'
            });
        });

    </script>

</body>
</html>