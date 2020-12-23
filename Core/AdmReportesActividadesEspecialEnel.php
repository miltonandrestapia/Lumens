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
  $codcliente=$_SESSION['LMNS-USER_CLIENTE'];
}else{ 
  $codcliente="";
}
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Reportes | Lumens</title>
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
  <script src="js/SimpleChart.js"></script>
 <script type="text/javascript">

var codigoc='';
 $(document).ready(function(){

	var f = new Date();
	dia="";
	if(f.getDate()<10){
		dia="0"+f.getDate();
	}else{
		dia=f.getDate();  
	}
	mes="";
	if((f.getMonth() +1)<10){
		mes="0"+(f.getMonth() +1);
	}else{
		mes=(f.getMonth() +1);  
	}   
	$("#divBusqueda1").hide();
	$("#divBusqueda2").hide();
	$("#Desde").val(f.getFullYear()+"-"+mes+"-"+dia);
	$("#Hasta").val(f.getFullYear()+"-"+mes+"-"+dia);

	$("#Reporte").change(cambiotipo);
});

function cambiotipo(){ 
	if ( $("#Reporte").val()=="Busqueda"  )  {

    	$("#divResumen1").hide();
    	$("#divResumen2").hide();
    	$("#divBusqueda1").show();
    	$("#divBusqueda2").show();
	}else{

      if ( $("#Reporte").val()=="PreoperacionalPendientes"  )  {

      
          $("#divResumen1").show();
          $("#divResumen2").hide();
          $("#divBusqueda1").hide();
          $("#divBusqueda2").hide();
      }else{

          $("#divResumen1").show();
          $("#divResumen2").show();
          $("#divBusqueda1").hide();
          $("#divBusqueda2").hide();
      }
	}
}

function detalleRegistro(Codigo_Registro){	
	$('#myModalDetalle').modal('show');
  var Datos = {
        "BuscaDetalleEspecialEnel" : Codigo_Registro
         };

  $.ajax({
          data:Datos,
          url:"Procesamiento/MdlActividades.php",
          type:"POST",
        success:function(resp){
			var valores = eval(resp); 
            $("#nombre").val(valores[0][0]);
            $("#producto").val(valores[0][1]);
            $("#orden").val(valores[0][2]);
            $("#guia").val(valores[0][3]);
            $("#cuenta").val(valores[0][4]);
            $("#idventa").val(valores[0][5]);
            $("#direccion").val(valores[0][6]);
            $("#cuadratula").val(valores[0][7]);
            $("#ciclo").val(valores[0][8]);
            $("#suscriptor").val(valores[0][9]);
            $("#grupo").val(valores[0][10]);
            $("#sucursal").val(valores[0][11]);
            $("#supervisor").val(valores[0][12]);
            $("#telefono").val(valores[0][13]);
            $("#medidor").val(valores[0][14]);
            $("#lectura").val(valores[0][15]);
            $("#quienrecibe").val(valores[0][16]);
            $("#direccioncorrecta").val(valores[0][17]);
            $("#observaciones").val(valores[0][18]);
            $("#anomalia").val(valores[0][19]);
            $("#estado").val(valores[0][20]);
            $("#fecharealizado").val(valores[0][21]);

           
            $("#fecha_fisico").val(valores[0][27]); 
            $("#fecha_maxima").val(valores[0][28]);
            $("#cedula").val(valores[0][29]);
            $("#specialone").val(valores[0][30]);
            $("#lote").val(valores[0][31]);         
            $("#Posicionmedidor").val(valores[0][32]);         


    if(valores[0][22]!="" && valores[0][22]!=null && valores[0][22]!="0"){
            $("#divubicacion").html( "<a id='aubicacion' onclick='abreframeu()' name='ActividadMapa.php?lat="+valores[0][22]+"&lon="+valores[0][23]+"&dir="+valores[0][6]+"'  data-toggle='modal' href='#myModal2'>Ver Posicion</a>");
          }else{
             $("#divubicacion").html("Sin GPS");
          }
		
    	if(valores[0][24]!="" && valores[0][24]!=null){
        		$("#divfotomedidor").html( "<a id='asoportemedidor'  onclick='abreframesmedidor()'  name='https://storage.googleapis.com/lumensarchivostemporales/Soportes/"+valores[0][24]+"' data-toggle='modal' href='#myModal2'>Ver Soporte</a>");
			}else{
       			 $("#divfotomedidor").html("Sin Soporte");
			}

 
    	if(valores[0][25]!="" && valores[0][25]!=null){
        		$("#divfotoguia").html( "<a id='asoporteguia'  onclick='abreframesguia()'  name='https://storage.googleapis.com/lumensarchivostemporales/Soportes/"+valores[0][25]+"' data-toggle='modal' href='#myModal2'>Ver Soporte</a>");
			}else{
       			 $("#divfotoguia").html("Sin Soporte");
			}
    	if(valores[0][26]!="" && valores[0][26]!=null){
        		$("#divfotopredio").html( "<a id='asoportepredio'  onclick='abreframespredio()'  name='https://storage.googleapis.com/lumensarchivostemporales/Soportes/"+valores[0][26]+"' data-toggle='modal' href='#myModal2'>Ver Soporte</a>");
			}else{
       			 $("#divfotopredio").html("Sin Soporte");
			}
	 
          


        },
        error:function(resp){
        	swal("Error!","Error Al Conectarse Al Servidor", "error");
        }
        });
}

function Generar(){


$('#btnMonitoreo').button('loading');

if($("#Reporte").val()!="Busqueda") {
 

  var Datos = {
        "GenerarDesde" : $("#Desde").val(),
        "GenerarHasta" : $("#Hasta").val() ,
        "GenerarTipoReporte" : $("#Reporte").val() 
         }; 

    $.ajax({
          data:Datos,
          url:"Procesamiento/MdlMonitoreo.php",
          type:"POST",
        success:function(resp){
         	$('#Listado').html(resp);  
            $('#example').DataTable(); 
           
        },
        error:function(resp){
          swal("Error!","Error Al Conectarse Al Servidor", "error");
        }
     });

}else{

 if ( $("#Parametro").val()=="") {
          swal("Error!","Escriba Parametro de busqueda", "error");
          return false;
 }
 if ( $("#Filtro").val()=="") {
          swal("Error!","Seleccione Filtro", "error");
          return false;
 }

  var Datos = {
        "GenerarParametro" : $("#Parametro").val(),
        "GenerarFiltro" : $("#Filtro").val() 
         };

    $.ajax({
          data:Datos,
          url:"Procesamiento/MdlMonitoreo.php",
          type:"POST",
        success:function(resp){
         	$('#Listado').html(resp);  
            $('#example').DataTable(); 
           
        },
        error:function(resp){
          swal("Error!","Error Al Conectarse Al Servidor", "error");
        }
     });
}

 
$('#btnMonitoreo').button('reset');
 

      

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


	function abreframespredio(){
	  $("#titulosegundo").html("Soporte De Visita");
	  $("#iframesegundo").html('<div><center><img src="'+$("#asoportepredio").attr("name")+'" style="width: 700px;margin:auto"></center><div class="clearfix"> </div></div>');
	  $("#iframesegundo").removeClass('claseframe');
	  $("#mdcontent").addClass('clasemodal');
	}


	function abreframesguia(){
	  $("#titulosegundo").html("Soporte De Visita");
	  $("#iframesegundo").html('<div><center><img src="'+$("#asoporteguia").attr("name")+'" style="width: 700px;margin:auto"></center><div class="clearfix"> </div></div>');
	  $("#iframesegundo").removeClass('claseframe');
	  $("#mdcontent").addClass('clasemodal');
	}


	function abreframesmedidor(){
	  $("#titulosegundo").html("Soporte De Visita");
  $("#iframesegundo").html('<div><center><img src="'+$("#asoportemedidor").attr("name")+'" style="width: 700px;margin:auto"></center><div class="clearfix"> </div></div>');
  $("#iframesegundo").removeClass('claseframe');
  $("#mdcontent").addClass('clasemodal');
}

function Descargar(){

    if($("#Reporte").val()!="Busqueda") {

      if($("#Reporte").val()=="Preoperacional") {
        window.open("Reportes/rptPreoperacionalEnel.php?GenerarInicio="+$("#Desde").val()+"&GenerarFinal="+$("#Hasta").val() );
      }else{

        if($("#Reporte").val()=="PreoperacionalPendientes") {
          window.open("Reportes/rptPreoperacionalEnelPendientes.php?GenerarInicio="+$("#Desde").val() );
        }else{
        window.open("Reportes/rptDetalleActividadesEspecialEnelRangoDeFechas.php?GenerarInicio="+$("#Desde").val()+"&GenerarFinal="+$("#Hasta").val() +"&Tipo="+$("#Reporte").val() );

        }

      }

    }else{


         if ( $("#Parametro").val()=="") {
                  swal("Error!","Escriba Parametro de busqueda", "error");
                  return false;
         }
         if ( $("#Filtro").val()=="") {
                  swal("Error!","Seleccione Filtro", "error");
                  return false;
         }
         window.open("Reportes/rptDetalleActividadesEspecialEnelParametro.php?Filtro="+$("#Filtro").val()+"&Parametro="+$("#Parametro").val() );
    
    }
}




function ExportaFromatoEnel(Codigo_Registroennel){ 
      window.open("Reportes/EnelPreoperacionalFormato.php?Codigo_Registroennel="+Codigo_Registroennel);
 
}



</script>
<!-- //pie-chart --><!-- index page sales reviews visitors pie chart -->

</head> 
<body class="cbp-spmenu-push">
	<div class="main-content" >





		<?php
    if( $_SESSION['LMNS-USER_TIPO']=="Cliente"){
        include("Partes/MenuCliente.php");
      }else{
        include("Partes/Menu.php");
      }
		?>
		<!-- main content start-->
		<div id="page-wrapper">
			<div class="main-page">


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

<style type="text/css">
  .claseframe{
    height: 100%
  }
  .clasemodal{
    height: max-content;min-height: 100%
  }

</style>

          <input type="hidden" id="Cantidad" value="0">
          <input type="hidden" id="Nombre_Hoja" value="">



<div class="col-md-12  widget-shadow">

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
      <div class="modal-body" style="background-color: white ">

   <div class="panel-heading"  style="background-color: #7696a5 !important;color:#fff !important"> 
                                            <h3 class="panel-title">Datos Iniciales De Visita</h3> 
                                        </div>  
                                        
      	    <div class="col-md-3 espacio4">
              <p><i class="fa fa-user-o"></i>Agente</p>
              <input id="nombre" type="text"  readonly="" name="nombre" class="form-control" />
            </div>

      	    <div class="col-md-3 espacio4">
              <p><i class="fa fa-user-o"></i>Producto</p>
              <input id="producto" type="text"  readonly="" name="producto" class="form-control" />
            </div>
      	    <div class="col-md-3 espacio4">
              <p><i class="fa fa-user-o"></i>Orden</p>
              <input id="orden" type="text"  readonly="" name="producto" class="form-control" />
            </div>
      	    <div class="col-md-3 espacio4">
              <p><i class="fa fa-user-o"></i>Consecutivo</p>
              <input id="guia" type="text"  readonly="" name="guia" class="form-control" />
            </div>
      	    <div class="col-md-3 espacio4">
              <p><i class="fa fa-user-o"></i>Cuenta</p>
              <input id="cuenta" type="text"  readonly="" name="cuenta" class="form-control" />
            </div>
      	    <div class="col-md-3 espacio4">
              <p><i class="fa fa-user-o"></i>ID venta</p>
              <input id="idventa" type="text"  readonly="" name="idventa" class="form-control" />
            </div>
      	    <div class="col-md-3 espacio4">
              <p><i class="fa fa-user-o"></i>Direccion</p>
              <input id="direccion" type="text"  readonly="" name="direccion" class="form-control" />
            </div>
      	    <div class="col-md-3 espacio4">
              <p><i class="fa fa-user-o"></i>Cuadratula</p>
              <input id="cuadratula" type="text"  readonly="" name="cuadratula" class="form-control" />
            </div>
      	    <div class="col-md-3 espacio4">
              <p><i class="fa fa-user-o"></i>Ciclo</p>
              <input id="ciclo" type="text"  readonly="" name="ciclo" class="form-control" />
            </div>
      	    <div class="col-md-3 espacio4">
              <p><i class="fa fa-user-o"></i>Suscriptor</p>
              <input id="suscriptor" type="text"  readonly="" name="suscriptor" class="form-control" />
            </div>

      	    <div class="col-md-3 espacio4">
              <p><i class="fa fa-user-o"></i>Grupo</p>
              <input id="grupo" type="text"  readonly="" name="grupo" class="form-control" />
            </div>
      	    <div class="col-md-3 espacio4">
              <p><i class="fa fa-user-o"></i>Sucursal</p>
              <input id="sucursal" type="text"  readonly="" name="sucursal" class="form-control" />
            </div>
      	    <div class="col-md-3 espacio4">
              <p><i class="fa fa-user-o"></i>Supervisor</p>
              <input id="supervisor" type="text"  readonly="" name="supervisor" class="form-control" />
            </div>
            

            <div class="col-md-3 espacio4">
              <p><i class="fa fa-user-o"></i>Fecha llegada físico</p>
              <input id="fecha_fisico" type="text"  readonly="" name="fecha_fisico" class="form-control" />
            </div>

            <div class="col-md-3 espacio4">
              <p><i class="fa fa-user-o"></i>Fecha máxima de entrega</p>
              <input id="fecha_maxima" type="text"  readonly="" name="fecha_maxima" class="form-control" />
            </div>



            <div class="col-md-3 espacio4">
              <p><i class="fa fa-user-o"></i>Cédula</p>
              <input id="cedula" type="text"  readonly="" name="cedula" class="form-control" />
            </div>

            <div class="col-md-3 espacio4"> 
              <p><i class="fa fa-user-o"></i>Especial 1</p>
              <input id="specialone" type="text"  readonly="" name="specialone" class="form-control" />
            </div>  

            <div class="col-md-3 espacio4"> 
              <p><i class="fa fa-user-o"></i>Lote</p>
              <input id="lote" type="text"  readonly="" name="lote" class="form-control" />      
            </div>  
                    <div class="clearfix espacio4"> </div>
<br>
            
   <div class="panel-heading espacio4"  style="background-color: #7696a5 !important;color:#fff !important;"> 
 <h3 class="panel-title">Recoleccion En Terreno</h3></div> 



 <div class="col-md-3 espacio4">
  <p><i class="fa fa-user-o"></i>Telefono</p>
  <input id="telefono" type="text"  readonly="" name="telefono" class="form-control" />
</div>
 <div class="col-md-3 espacio4">
  <p><i class="fa fa-user-o"></i>Medidor</p>
  <input id="medidor" type="text"  readonly="" name="medidor" class="form-control" />
</div>

 <div class="col-md-3 espacio4">
  <p><i class="fa fa-user-o"></i>Posicion Medidor</p>
  <input id="Posicionmedidor" type="text"  readonly="" name="Posicionmedidor" class="form-control" />
</div>
 <div class="col-md-3 espacio4">
  <p><i class="fa fa-user-o"></i>Lectura</p>
  <input id="lectura" type="text"  readonly="" name="lectura" class="form-control" />
</div>
 <div class="col-md-3 espacio4">
  <p><i class="fa fa-user-o"></i>Quien recibe</p>
  <input id="quienrecibe" type="text"  readonly="" name="quienrecibe" class="form-control" />
</div>
 <div class="col-md-3 espacio4">
  <p><i class="fa fa-user-o"></i>Direccion correcta</p>
  <input id="direccioncorrecta" type="text"  readonly="" name="direccioncorrecta" class="form-control" />
</div>
 <div class="col-md-3 espacio4">
  <p><i class="fa fa-user-o"></i>Observaciones</p>
  <input id="observaciones" type="text"  readonly="" name="observaciones" class="form-control" />
</div>
 <div class="col-md-3 espacio4">
  <p><i class="fa fa-user-o"></i>Anomalia</p>
  <input id="anomalia" type="text"  readonly="" name="anomalia" class="form-control" />
</div>
 <div class="col-md-2 espacio4">
  <p><i class="fa fa-user-o"></i>Estado</p>
  <input id="estado" type="text"  readonly="" name="estado" class="form-control" />
</div>
 <div class="col-md-2 espacio4">
  <p><i class="fa fa-user-o"></i>Fecha realizado</p>
  <input id="fecharealizado" type="text"  readonly="" name="fecharealizado" class="form-control" />
</div> 
 <div class="col-md-2 espacio4">
  <p><i class="fa fa-user-o"></i>Punto Geolicalizado</p>
  <div id="divubicacion"></div>
</div>

 <div class="col-md-2 espacio4">
  <p><i class="fa fa-user-o"></i>Foto medidor</p>
  <div id="divfotomedidor"></div>
</div>

 <div class="col-md-2 espacio4">
  <p><i class="fa fa-user-o"></i>Foto Consecutivo</p>
  <div id="divfotoguia"></div>
</div>

 <div class="col-md-2 espacio4">
  <p><i class="fa fa-user-o"></i>Foto predio</p>
  <div id="divfotopredio"></div>
</div>


 
 
 <div class="col-md-12 espacio4" align="center"><br>
<button type="button" class="btn btn-dark" onclick="Cerrar();"  id="Cerrar">Cerrar Detalle</button>
</div>
              
                    <div class="clearfix espacio4"> </div>

      </div>
    </div>
  </div>
</div>

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
                    <ul id="myTabs" class="nav nav-tabs" role="tablist"> 
                         <li role="presentation" class="active"><a href="#profile" role="tab" id="profile-tab" data-toggle="tab" aria-controls="profile" aria-expanded="false">Reportes</a></li>
                    </ul>

                    <div id="myTabContent" class="tab-content scrollbar1"> 


                    <div role="tabpanel" class="tab-pane fade  active in" id="profile" aria-labelledby="profile-tab"> 
                            <p>

                                    <div class="panel panel-primary"> 
                                        <div class="panel-heading"  style="background-color: #222D32 !important"> 
                                            <h3 class="panel-title">Lumens | Reportes</h3> 
                                        </div> 
                                        <div class="panel-body " style="background-color: #fafafa"> 

  						           
  						<div class="col-md-3">
                         	<p><i class="fa fa-user-o"></i>Tipo Reporte</p>
                            <select id="Reporte" name="Reporte" class="form-control"> 
                                <option value="Detallado">Detallado General</option> 
                                <option value="Busqueda">Busqueda Por Parametro</option> 
                                <option value="Busquedadirecciones">Actualización de direcciones</option> 
                                <option value="Preoperacional">Preoperacional Detallado</option> 
                                <option value="PreoperacionalPendientes">Preoperacional Pendientes</option> 
                            </select>
                        </div> 
  						<div class="col-md-3"  id="divBusqueda1">
                         	<p><i class="fa fa-user-o"></i>Filtro</p>
                            <select id="Filtro" name="Filtro" class="form-control"> 
                                <option value="">Seleccionar....</option>  
                                <option value="cuenta">Cuenta</option>  
                                <option value="direccion">Direccion</option>  
                                <option value="guia">Consecutivo</option>  
                                <option value="idventa">ID Venta</option>  
                                <option value="medidor">Medidor</option>  
                                <option value="orden">Orden</option>  
                            </select>
                        </div>

                        <div class="col-md-3"  id="divBusqueda2">
                          <p><i class="fa fa-user-o"></i>Parametro </p>
                          <input id="Parametro" type="text" name="Parametro" class="form-control" />
                        </div>

                        <div class="col-md-3" id="divResumen1">
                          <p><i class="fa fa-user-o"></i>Desde </p>
                          <input id="Desde" type="date" name="Desde" class="form-control" />
                        </div>
                        <div class="col-md-3" id="divResumen2">
                          <p><i class="fa fa-user-o"></i>Hasta</p>
                          <input id="Hasta" type="date" name="Hasta" class="form-control" />
                        </div>

                        	<div class="col-md-3  "><br>
                        					<center>
											<button type="button" class="btn btn-primary" onclick="Generar();"  id="btnBuscar">Buscar</button>
											<button type="button" class="btn btn-success" onclick="Descargar();"  id="btnDescargar">Descargar</button>
											</center>
								    </div>
							</div>

                                                <div class="single-bottom row" style="background-color: #f2f2f2;padding: 10px" >
                                                        <div id="Listado" class="single-bottom row "  ></div> 
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