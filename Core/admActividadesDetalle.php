<?php
session_start();     
if (empty($_SESSION['LMNS-USER_TIPO'])){      
  echo"<script>document.location=('../');</script>";  
}else{

  require_once("Procesamiento/Conexion.php"); 
}

$ecodempresa="";
$codcliente="";

if( $_SESSION['LMNS-USER_TIPO']=="Cliente"){
  $ecodempresa=$_SESSION['LMNS-USER_CODEC'];
  $codcliente=$_SESSION['LMNS-USER_CLIENTE'];
}else{
  $ecodempresa=$_SESSION['LMNS-USER_CODE'];
  $codcliente="";
}
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Detalle Actividad | Lumens</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- Bootstrap Core CSS -->
<link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
<!-- Custom CSS -->
<link href="css/style.css" rel='stylesheet' type='text/css' />
<!-- font-awesome icons CSS -->
<link href="css/font-awesome.css" rel="stylesheet"> 
<!-- //font-awesome icons CSS-->
<!-- side nav css file -->
<link href='css/SidebarNav.min.css' media='all' rel='stylesheet' type='text/css'/>
<!-- //side nav css file --> 
 <!-- js-->
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/modernizr.custom.js"></script>

<!--webfonts-->
<link href="//fonts.googleapis.com/css?family=PT+Sans:400,400i,700,700i&amp;subset=cyrillic,cyrillic-ext,latin-ext" rel="stylesheet">
<script src="js/Chart.js"></script>
<!-- //chart -->

<!-- Metis Menu -->
<script src="js/metisMenu.min.js"></script>
<script src="js/custom.js"></script>
<link href="css/custom.css" rel="stylesheet">

<!--pie-chart --><!-- index page sales reviews visitors pie chart -->
<script src="js/pie-chart.js" type="text/javascript"></script>
<script type="text/javascript" language="javascript" src="Ext/jquery.dataTables.js"></script>
<link rel="stylesheet" type="text/css" href="Ext/jquery.dataTables.css">
 <script type="text/javascript">

var codigoc='';
 $(document).ready(function(){

            $('#example').DataTable();

 
});

function TrazaAgente(codigo){	
	$('#myModal').modal('show');
$("#divmapa").html('<iframe src="AdmActividadesTrackingFrame.php?agente='+codigo+
			'&cod=<?php echo $_GET["cod"]?>" style="margin: 0px; padding: 0px; border:none;width: 100%;height: 100%"></iframe>');
}


function UbicacionesAgentes(){	
	$('#myModal').modal('show');
$("#divmapa").html('<iframe src="AdmActividadesUbicaciones.php?cod=<?php echo $_GET["cod"]?>" style="margin: 0px; padding: 0px; border:none;width: 100%;height: 100%"></iframe>');
}


function detalleRegistro(Codigo_Registro){	
	$('#myModalDetalle').modal('show');
  var Datos = {
        "BuscaDetalle" : Codigo_Registro
         };

  $.ajax({
          data:Datos,
          url:"Procesamiento/MdlActividades.php",
          type:"POST",
        success:function(resp){
			var valores = eval(resp); 
            $("#TipoActividad").val(valores[0][0]);
            $("#TipoSoporte").val(valores[0][1]);
            $("#Observaciones").val(valores[0][2]);
            $("#Destinatario").val(valores[0][3]);
            $("#Direccion").val(valores[0][4]);
            $("#Ciudad").val(valores[0][5]);
            $("#Departamento").val(valores[0][6]);
            $("#Cliente").val(valores[0][7]);
            $("#Referencia1").val(valores[0][8]);
            $("#Referencia2").val(valores[0][9]);
            $("#Referencia3").val(valores[0][10]);
            $("#Referencia4").val(valores[0][11]);
            $("#Referencia5").val(valores[0][12]);
            $("#Ruta").val(valores[0][13]);
            $("#Ordenamiento").val(valores[0][14]);
            $("#Agente").val(valores[0][15]);
            $("#Estado").val(valores[0][16]);
            $("#FechaEstado").val(valores[0][17]);
            $("#Respuesta").val(valores[0][18]);
            $("#Detalle").val(valores[0][19]);
            $("#Respuesta1").val(valores[0][20]);
            $("#Respuesta2").val(valores[0][21]);
            $("#ObservacionesR").val(valores[0][25]);

    if(valores[0][22]!="" && valores[0][22]!=null && valores[0][22]!="0"){
            $("#divubicacion").html( "<a id='aubicacion' onclick='abreframeu()' name='ActividadMapa.php?lat="+valores[0][22]+"&lon="+valores[0][23]+"&dir="+valores[0][4]+"'  data-toggle='modal' href='#myModal2'>Ver Posicion</a>");
          }else{
             $("#divubicacion").html("Sin GPS");
          }
		
    	if(valores[0][24]!="" && valores[0][24]!=null){
        		$("#divSoporte").html( "<a id='asoporte'  onclick='abreframes()'  name='https://storage.googleapis.com/lumensarchivostemporales/Soportes/"+valores[0][24]+"' data-toggle='modal' href='#myModal2'>Ver Soporte</a>");
			}else{
       			 $("#divSoporte").html("Sin Soporte");
			}


        },
        error:function(resp){
        	swal("Error!","Error Al Conectarse Al Servidor", "error");
        }
        });
}

function Cerrar(){	
	$('#myModalDetalle').modal('hide');
}


function abreframeu(){
  $("#titulosegundo").html("Ubicacion GPS");
  $("#iframesegundo").html('<iframe src="'+$("#aubicacion").attr("name")+'" style="margin: 0px; padding: 0px; border:none;width: 100%;height: 100%"></iframe>');
  $("#iframesegundo").addClass('claseframe');
  $("#mdcontent").removeClass('clasemodal');
}


function abreframes(){
  $("#titulosegundo").html("Soporte De Visita");
  $("#iframesegundo").html('<div><center><img src="'+$("#asoporte").attr("name")+'" style="width: 700px;margin:auto"></center><div class="clearfix"> </div></div>');
  $("#iframesegundo").removeClass('claseframe');
  $("#mdcontent").addClass('clasemodal');
}


</script>
<style type="text/css">
.modal-dialog {
  width: 100%;
  height: 100%;
  padding: 0;
}

.modal-content {
  height: 100%;
  border-radius: 0;
}
</style>
<!-- //pie-chart --><!-- index page sales reviews visitors pie chart -->

</head> 
<body class="cbp-spmenu-push">
	<div class="main-content" >





		<?php if( $_SESSION['LMNS-USER_TIPO']=="Cliente"){
        include("Partes/MenuCliente.php");
      }else{
        include("Partes/Menu.php");
      }
		?>
		<!-- main content start-->
		<div id="page-wrapper">
			<div class="main-page">




          <input type="hidden" id="Cantidad" value="0">
          <input type="hidden" id="Nombre_Hoja" value="">



<div class="col-md-12  widget-shadow">


                       
                    <div id="myTabContent" class="tab-content scrollbar1"> 


                    <div role="tabpanel" class="tab-pane fade  active in" id="profile" aria-labelledby="profile-tab"> 
                            <p>

                                    <div class="panel panel-primary"> 
                                        <div class="panel-heading"  style="background-color: #222D32 !important"> 
                                            <h3 class="panel-title">Lumens | Detalle Actividad (<?php echo $_GET["cod"]?>)</h3> 
                                        </div> 
                                        

					</div>
                                            	
<?php

$tabla="";
$rpendientes=0;
$refectivas=0;
$rnoefectivas=0;

$completa="";
if($codcliente!=""){
$completa=" and p.codcliente='".mysqli_real_escape_string($mysqli,$codcliente)."' ";

}

         $consulta="SELECT ag.nombre,destinatario,direccion,c.nombre AS ciudad,p.cliente AS cliente,referencia1,p.estado,p.respuesta,p.cons FROM (((principal p INNER JOIN ciudades c ON c.cons=p.codciudad) 
      INNER JOIN actividad a ON a.cons=p.codactividad)INNER JOIN agentes ag ON ag.usuario=p.codagente) WHERE p.codactividad='".mysqli_real_escape_string($mysqli,$_GET["cod"])."' ".$completa."  order by ordenamiento,p.cons  ";
$datos=mysqli_query($mysqli,$consulta);

         $tabla.='
         <table id="example" class="display dataTable" cellspacing="0" width="100%" style="font-size: 12px; width: 100%;text-align:center;margin-top: 20px !important" role="grid" aria-describedby="example_info">
        <thead>
          <tr>
          <th  width="10">Codigo Visita</th>
          <th >Agente</th>
          <th >Destinatario</th>
          <th >Direccion</th>
          <th >Ciudad</th>
          <th >Cliente</th>
          <th >Referencia 1</th>
          <th >Estado</th>
          <th width="20">Opciones</th>
          </tr>

          </tr>
        </thead><tfoot>
          <tr>
          <th  width="10">Codigo Visita</th>
          <th >Agente</th>
          <th >Destinatario</th>
          <th >Direccion</th>
          <th >Ciudad</th>
          <th >Cliente</th>
          <th >Referencia 1</th>
          <th >Estado</th>
          <th width="20">Opciones</th>
          </tr>
        </tfoot>  <tbody> ';
$cont=1;
                 
			while($row=mysqli_fetch_row($datos)){ 



	            if($row[6]=='Pendiente'){
	                $st='style="background-color:#FF2C21; color:#fff;"';
	                $estado="Pendiente";
	                $rpendientes= $rpendientes+1;
				}else{
	                $estado=$row[7];
					 if($row[7]=='Efectiva'){
	                		$refectivas= $refectivas+1;
		                $st='style="background-color:#00FF2C; color:#fff;"';
		             }else{
	               		 $rnoefectivas= $rnoefectivas+1;
		                $st='style="background-color:#FF9500; color:#fff;"';
		             }
		        }
$CODD="'".$row[8]."'";
	              
		            $tabla.= '<tr >
		            <td  >'.$row[8].'</td>
		             <td  >'.$row[0].'</td>
		            <td  >'.$row[1].'</td>
		            <td  >'.$row[2].'</td>
		            <td  >'.$row[3].'</td>
		            <td  >'.$row[4].'</td>
		            <td  >'.$row[5].'</td>
		            <td  '.$st.'>'.$estado.'</td>
		            <td  >
 <button type="button" onclick="detalleRegistro('.$CODD.');" class="btn btn-info" style="background-color:blue;padding:7px !important">
 <i class="fa fa-search "></i></button>

		            </td>
		            </tr>';
					$cont++;
            }

            $rtotal=$rpendientes+$refectivas+$rnoefectivas;
            $rrealizadas=$refectivas+$rnoefectivas;
          $tabla.= '</tbody></table>';




				$listaclientes="";
				$consulta="SELECT cliente,SUM(CASE WHEN estado !='Pendiente' THEN 1 ELSE 0 END),
				SUM(CASE WHEN estado !='Pendiente' THEN 0 ELSE 1 END) FROM principal p  WHERE 
				p.codactividad='".mysqli_real_escape_string($mysqli,$_GET["cod"])."' ".$completa."   group by cliente ";

				$datos=mysqli_query($mysqli,$consulta);                 
				while($row=mysqli_fetch_row($datos)){ 
					$ctotal=$row[1]+$row[2];
					$porcentajecliente= round((($row[1]/$ctotal)*100),0);
					$color="green";
					if($porcentajecliente>=30 && $porcentajecliente<=60 ){
							$color="yellow";
					}else{

						if($porcentajecliente<=30 ){
								$color="red";
						}
					}

					$listaclientes.= '<li>'.$row[0].' <span class="pull-right">'.$porcentajecliente.'%</span>  
						<div class="progress progress-striped active progress-right">
						<div class="bar '.$color.'" style="width:'.$porcentajecliente.'%;"></div></div></li>';
				}

				$listaagentes="";
				$consulta="SELECT a.nombre,SUM(CASE WHEN estado !='Pendiente' THEN 1 ELSE 0 END),
				SUM(CASE WHEN estado !='Pendiente' THEN 0 ELSE 1 END),a.usuario FROM principal p inner join agentes a on a.usuario=p.codagente WHERE 
				p.codactividad='".mysqli_real_escape_string($mysqli,$_GET["cod"])."' ".$completa."  group by a.nombre,a.usuario ";

				$datos=mysqli_query($mysqli,$consulta);                 
				while($row=mysqli_fetch_row($datos)){ 
					$ctotal=$row[1]+$row[2];
					$porcentajeagentes= round((($row[1]/$ctotal)*100),0);
					$color="green";
					if($porcentajeagentes>=30 && $porcentajeagentes<=60 ){
							$color="yellow";
					}else{

						if($porcentajeagentes<=30 ){
								$color="red";
						}
					}
					$row[3]="'".$row[3]."'";
					$listaagentes.= '<li><button onclick="TrazaAgente('.$row[3].');" type="button" class="btn btn-info" style="background-color:#428bca;padding:3px !important;margin-top:-5px"><i class="fa fa-map-marker"></i></button>  '.$row[0].' <span class="pull-right">'.$porcentajeagentes.'%</span>  
						<div class="progress progress-striped active progress-right">
						<div class="bar '.$color.'" style="width:'.$porcentajeagentes.'%;"></div></div></li>';
				}
?>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      </div>
      <div class="modal-body" id="divmapa" style="height: 100% !important">
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="myModalDetalle" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      </div>
      <div class="modal-body" >

   <div class="panel-heading"  style="background-color: #7696a5 !important;color:#fff !important"> 
                                            <h3 class="panel-title">Datos Iniciales De Visita</h3> 
                                        </div> 

      	    <div class="col-md-3">
              <p><i class="fa fa-user-o"></i>Tipo Actividad</p>
              <input id="TipoActividad" type="text" readonly="" name="TipoActividad" class="form-control" />
            </div>


      	    <div class="col-md-3">
              <p><i class="fa fa-user-o"></i>Tipo Soporte</p>
              <input id="TipoSoporte" type="text"  readonly="" name="TipoSoporte" class="form-control" />
            </div>

      	    <div class="col-md-3">
              <p><i class="fa fa-user-o"></i>Observaciones Actividad</p>
              <input id="Observaciones" type="text"  readonly="" name="Observaciones" class="form-control" />
            </div>

      	    <div class="col-md-3">
              <p><i class="fa fa-user-o"></i>Destinatario</p>
              <input id="Destinatario" type="text"  readonly="" name="Destinatario" class="form-control" />
            </div>
      	    <div class="col-md-3 espacio4">
              <p><i class="fa fa-user-o"></i>Direccion</p>
              <input id="Direccion" type="text"  readonly="" name="Direccion" class="form-control" />
            </div>

      	    <div class="col-md-3 espacio4">
              <p><i class="fa fa-user-o"></i>Ciudad</p>
              <input id="Ciudad" type="text"  readonly="" name="Ciudad" class="form-control" />
            </div>


      	    <div class="col-md-3 espacio4">
              <p><i class="fa fa-user-o"></i>Departamento</p>
              <input id="Departamento" type="text"  readonly="" name="Departamento" class="form-control" />
            </div>

      	    <div class="col-md-3 espacio4">
              <p><i class="fa fa-user-o"></i>Cliente</p>
              <input id="Cliente" type="text"  readonly="" name="Cliente" class="form-control" />
            </div>

      	    <div class="col-md-3 espacio4">
              <p><i class="fa fa-user-o"></i>Referencia 1</p>
              <input id="Referencia1" type="text"  readonly="" name="Referencia1" class="form-control" />
            </div>

      	    <div class="col-md-3 espacio4">
              <p><i class="fa fa-user-o"></i>Referencia 2</p>
              <input id="Referencia2" type="text"  readonly="" name="Referencia2" class="form-control" />
            </div>

            
      	    <div class="col-md-3 espacio4">
              <p><i class="fa fa-user-o"></i>Referencia 3</p>
              <input id="Referencia3" type="text"  readonly="" name="Referencia3" class="form-control" />
            </div>

      	    <div class="col-md-3 espacio4">
              <p><i class="fa fa-user-o"></i>Referencia 4</p>
              <input id="Referencia4" type="text"  readonly="" name="Referencia4" class="form-control" />
            </div>

      	    <div class="col-md-3 espacio4">
              <p><i class="fa fa-user-o"></i>Referencia 5</p>
              <input id="Referencia5" type="text"  readonly="" name="Referencia5" class="form-control" />
            </div>

      	    <div class="col-md-3 espacio4">
              <p><i class="fa fa-user-o"></i>Ruta</p>
              <input id="Ruta" type="text"  readonly="" name="Ruta" class="form-control" />
            </div>

            
      	    <div class="col-md-3 espacio4">
              <p><i class="fa fa-user-o"></i>Ordenamiento</p>
              <input id="Ordenamiento" type="text"  readonly="" name="Ordenamiento" class="form-control" />
            </div>

            
      	    <div class="col-md-3 espacio4">
              <p><i class="fa fa-user-o"></i>Agente</p>
              <input id="Agente" type="text"  readonly="" name="Agente" class="form-control" />
            </div>
                    <div class="clearfix espacio4"> </div>
<br>
            
   <div class="panel-heading espacio4"  style="background-color: #7696a5 !important;color:#fff !important;"> 
                                            <h3 class="panel-title">Recoleccion En Terreno</h3> 
                                        </div> 



 <div class="col-md-3 espacio4">
  <p><i class="fa fa-user-o"></i>Estado</p>
  <input id="Estado" type="text"  readonly="" name="Estado" class="form-control" />
</div>

 <div class="col-md-3 espacio4">
  <p><i class="fa fa-user-o"></i>Fecha Estado</p>
  <input id="FechaEstado" type="text"  readonly="" name="FechaEstado" class="form-control" />
</div>

 <div class="col-md-3 espacio4">
  <p><i class="fa fa-user-o"></i>Respuesta</p>
  <input id="Respuesta" type="text"  readonly="" name="Respuesta" class="form-control" />
</div>


 <div class="col-md-3 espacio4">
  <p><i class="fa fa-user-o"></i>Detalle Respuesta</p>
  <input id="Detalle" type="text"  readonly="" name="Detalle" class="form-control" />
</div>

 <div class="col-md-3 espacio4">
  <p><i class="fa fa-user-o"></i>Respuesta 1</p>
  <input id="Respuesta1" type="text"  readonly="" name="Respuesta1" class="form-control" />
</div>

 <div class="col-md-3 espacio4">
  <p><i class="fa fa-user-o"></i>Respuesta 2</p>
  <input id="Respuesta2" type="text"  readonly="" name="Respuesta2" class="form-control" />
</div>
 <div class="col-md-3 espacio4">
  <p><i class="fa fa-user-o"></i>Punto Geolicalizado</p>
  <div id="divubicacion"></div>
</div>

 <div class="col-md-3 espacio4">
  <p><i class="fa fa-user-o"></i>Soporte</p>
  <div id="divSoporte"></div>
</div>

 <div class="clearfix"> </div>


 <div class="col-md-6 espacio4">
  <p><i class="fa fa-user-o"></i>Observaciones Respuesta</p>
  <input id="ObservacionesR" type="text"  readonly="" name="ObservacionesR" class="form-control" />
</div>


 <div class="col-md-6 espacio4" align="center"><br>
<button type="button" class="btn btn-dark" onclick="Cerrar();"  id="Cerrar">Cerrar Detalle</button>
</div>
            

      </div>
    </div>
  </div>
</div>

<style type="text/css">
  .claseframe{
    height: 100%
  }
  .clasemodal{
    height: max-content;min-height: 100%
  }

</style>

<div class="modal fade rotate" id="myModal2">
    <div class="modal-dialog">
        <div class="modal-content" id="mdcontent" >
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                  <h4 class="modal-title" id="titulosegundo" style="font-weight: bold;"></h4>
            </div>
               <div class="modal-body" id="iframesegundo" >
                 
               </div>

        </div>
    </div>
</div>

					<div class="col-md-4  stats-info" style="border:solid 1px #ccc;box-shadow: 0px 0px 5px -2px rgba(0,0,0,0.75); background-color:#fff">
						<div class="stats-info-agileits" >
                                        <header class="widget-header" >
                                            <h4 class="widget-title" ><b>Resumen Agentes
											</b>  

                            	<button type="button" onclick="UbicacionesAgentes();" class="btn btn-info" style="background-color:green;padding:0px 7px !important"><i class="fa fa-location-arrow "></i></button>
</h4>
                                        </header>
                                        <hr class="widget-separator" style="border-top: 1px solid red;" >
							<div class="stats-body">
								<ul class="list-unstyled">
									
									<?php echo $listaagentes;?>
								</ul>
							</div>
						</div>
					</div>
					
					<div class="col-md-5  stats-info" style="border:solid 1px #ccc;box-shadow: 0px 0px 5px -2px rgba(0,0,0,0.75); background-color:#fff">
						<div class="stats-info-agileits">
                                        <header class="widget-header">
                                            <h4 class="widget-title"><b>Resumen Clientes</b></h4>
                                        </header>
                                        <hr class="widget-separator" style="border-top: 1px solid yellow;">
							<div class="stats-body">
								<ul class="list-unstyled">
									<?php echo $listaclientes;?>
								</ul>
							</div>
						</div>
					</div>

					<div class="col-md-3  stats-info" style="border:solid 1px #ccc;box-shadow: 0px 0px 5px -2px rgba(0,0,0,0.75); background-color:#fff">
						<div class="stats-info-agileits">
                                        <header class="widget-header">
                                            <h4 class="widget-title"><b><?php echo ($_GET["cod"])?> - Resumen Actividad (<?php echo ($cont-1)?>)</b></h4>
                                        </header>
                                        <hr class="widget-separator" style="border-top: 1px solid orange;">
							<div class="stats-body">
<ul class="list-unstyled">
	<li>Pendientes (<?php echo $rpendientes;?>) <span class="pull-right">
		<?php echo round((($rpendientes/$rtotal)*100),0);?>%</span>  
		<div class="progress progress-striped active progress-right">
			<div class="bar yellow" style="width:<?php echo round((($rpendientes/$rtotal)*100),0);?>%;"></div>
		</div>
	</li>
	<li>Realizadas (<?php echo $rrealizadas;?>)<span class="pull-right">
		<?php echo round((($rrealizadas/$rtotal)*100),0);?>%</span>  
		<div class="progress progress-striped active progress-right">
			<div class="bar green" style="width:<?php echo round((($rrealizadas/$rtotal)*100),0);?>%;"></div> 
		</div>
	</li>

	<li>Efectivas (<?php echo $refectivas;?>)<span class="pull-right"><?php echo round((($refectivas/$rtotal)*100),0);?>%</span>  
		<div class="progress progress-striped active progress-right">
			<div class="bar blue" style="width:<?php echo round((($refectivas/$rtotal)*100),0);?>%;"></div>
		</div>
	</li>

	<li>No Efectivas (<?php echo $rnoefectivas;?>)<span class="pull-right"><?php echo round((($rnoefectivas/$rtotal)*100),0);?>%</span>  
		<div class="progress progress-striped active progress-right">
			<div class="bar light-blue" style="width:<?php echo round((($rnoefectivas/$rtotal)*100),0);?>%;"></div>
		</div>
	</li>
</ul>
							</div>
						</div>
					</div>




                    <div class="clearfix"> </div>
<br>


        				<div class="single-bottom row" style="background-color: #f2f2f2;padding: 10px" >
                		<div id="Listado" class="single-bottom row " style="height: 500px !important;margin: 0px !important; padding: 0px !important;"><?php echo $tabla;?>
                                </div>  
                        </div>
                </div>
            </div>

                             </p> 
                    </div> 
                    </div>
                    <div class="clearfix"> </div>
                </div>















		</div>
	</div>
		
	<!-- new added graphs chart js-->
	
    <script src="js/Chart.bundle.js"></script>
    <script src="js/utils.js"></script>
	
	<!-- new added graphs chart js-->
	
	<!-- Classie --><!-- for toggle left push menu script -->
		<script src="js/classie.js"></script>
		<script>
			var menuLeft = document.getElementById( 'cbp-spmenu-s1' ),
				showLeftPush = document.getElementById( 'showLeftPush' ),
				body = document.body;
				
			showLeftPush.onclick = function() {
				classie.toggle( this, 'active' );
				classie.toggle( body, 'cbp-spmenu-push-toright' );
				classie.toggle( menuLeft, 'cbp-spmenu-open' );
				disableOther( 'showLeftPush' );
			};
			

			function disableOther( button ) {
				if( button !== 'showLeftPush' ) {
					classie.toggle( showLeftPush, 'disabled' );
				}
			}
		</script>
	<!-- //Classie --><!-- //for toggle left push menu script -->

	<!-- side nav js -->
	<script src='js/SidebarNav.min.js' type='text/javascript'></script>
	<script>
      $('.sidebar-menu').SidebarNav()
    </script>
<script src="js/sweetalert.min.js"></script>
   <script src="js/bootstrap.js"> </script>	

</body>
</html>