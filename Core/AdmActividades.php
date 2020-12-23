<?php
session_start();     
if (empty($_SESSION['LMNS-USER_USUARIO'])){      
	echo"<script>document.location=('../');</script>";	
}else{

  require_once("Procesamiento/Conexion.php"); 
}
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Actividades | Lumens</title>
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

 //$('#example').DataTable();

 $('ul.nav-tabs li a').click(function(){
    var activeTab = $(this).attr('href');
    if(activeTab=='#profile'){
      listar();
      Nuevo();
    }
    if(activeTab=='#help'){
      Nuevo();
    }
 });

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

$("#Fecha").val(f.getFullYear()+"-"+mes+"-"+dia );
$("#Inicio").val(f.getFullYear()+"-"+mes+"-"+dia );
$("#Final").val(f.getFullYear()+"-"+mes+"-"+dia );
$("#btna").hide();
$("#divformoculto").hide();
$("#btnc").hide();
});





	function validarCargaAdd(nombre){

  			var parametros = {
				 "validarCargaAddCodigo" :  $("#CodigoAct").val(),
				 "validarCargaAddFechaa" :  $("#Fechaa").val(),
				 "validarCargaAddnombre" :  nombre
			};	

			$.ajax({
			data:parametros,
			url:"Procesamiento/Excel/CargaBase.php",
			type:"POST",
				success:function(resp){

					    $(resp).each(function(){
					        if(resp.validacion=='Error'){
					       		 swal("Atención", resp.Mensaje,"error");
					        }else if(resp.validacion=="OK"){
					       		 swal("Atención", resp.Mensaje,resp.icono);									
					       		 if(resp.icono=="error"){
										$("#divrespuestasAdd").html('<br><div class="alert alert-danger" role="alert"><strong>Detalle De La Revision:</strong><br> '
											+resp.detalleerror+'</div>');
					       		 }else{
										$("#divrespuestasAdd").html("");
					       		 }			                
					        }
					    });		
						$('#btnad').button('reset');		
				},
				error:function(XMLHttpRequest, textStatus, errorThrown){
		       		 swal("Atención", "Status: " + textStatus+" | Error: " + errorThrown+" | Error: " + XMLHttpRequest.responseText,"error");
				}
			});
	}



function AdicionarDatos(){
$("#divrespuestasAdd").html("");

   

    if($("#Baseadicionar").val()==''){
      swal("Atención!","Seleccione Base","warning");
      return false;
    }


	var archivos = document.getElementById("Baseadicionar");//Damos el valor del input tipo file
	var archivo = archivos.files; //Obtenemos el valor del input (los arcchivos) en modo de arreglo	
	var data = new FormData();	

	data.append('archivo',archivo[0]);	
	data.append('CargaBaseAdd',"CargaBase");
	$("#Baseadicionar").val("");

			$('#btnad').button('loading');

	$.ajax({	
		url:'Procesamiento/Excel/CargaBase.php', //Url a donde la enviaremos
		type:'POST', //Metodo que usaremos
		contentType:false, //Debe estar en false para que pase el objeto sin procesar
		data:data, //Le pasamos el objeto que creamos con los archivos
		processData:false, //Debe estar en false para que JQuery no procese los datos a enviar
		cache:false //Para que el formulario no guarde cache		
	}).done(function(resp){	  
			    $(resp).each(function(){
			        if(resp.validacion=='Error'){
			        swal("Atención", resp.Mensaje,"error");
					$('#btnad').button('reset');
			        }else if(resp.validacion=="OK"){
			         	$("#Nombre_Hoja").val(resp.nombre);
			            $("#Cantidad").val(resp.cantidad);
           				validarCargaAdd(resp.nombre)  ;   
			            Progreso(0);	           
			        }
			    });
	  }).fail(  function(XMLHttpRequest, textStatus, errorThrown){
					$('#btnad').button('reset');
     swal("Atención", "Status: " + textStatus+" | Error: " + errorThrown+" | Error: " + XMLHttpRequest.responseText,"error");
  });  
}






function ActualizaDatos(){

    if($("#BaseActualizar").val()==''){
      swal("Atención!","Seleccione Archivo","warning");
      return false;
    }

	var archivos = document.getElementById("BaseActualizar");//Damos el valor del input tipo file
	var archivo = archivos.files; //Obtenemos el valor del input (los arcchivos) en modo de arreglo	
	var data = new FormData();	

	data.append('archivo',archivo[0]);		
	data.append('BaseActualizarCodigoAct',$("#CodigoAct").val());
	data.append('BaseActualizar',"BaseActualizar");
	data.append('BaseActualizarCode',"");

	$("#BaseActualizar").val("");
	$('#ActualizaDatos').button('loading');

	$.ajax({	
		url:'Procesamiento/Excel/CargaBase.php', //Url a donde la enviaremos
		type:'POST', //Metodo que usaremos
		contentType:false, //Debe estar en false para que pase el objeto sin procesar
		data:data, //Le pasamos el objeto que creamos con los archivos
		processData:false, //Debe estar en false para que JQuery no procese los datos a enviar
		cache:false //Para que el formulario no guarde cache		
	}).done(function(resp){
			    $(resp).each(function(){
			        if(resp.validacion=='Error'){
				        swal("Atención", resp.Mensaje,"error");
						$('#ActualizaDatos').button('reset');
			        }else if(resp.validacion=="OK"){			        	
      					swal(resp.cantidad+" Visitas Actualizadas" ,resp.Mensaje, resp.icono);
						$('#ActualizaDatos').button('reset');
			        }else{
			        	alert(resp.validacion);
			        }
			    });

	  }).fail(  function(XMLHttpRequest, textStatus, errorThrown){
	$('#ActualizaDatos').button('reset');
     swal("Atención", "Status: " + textStatus+" | Error: " + errorThrown+" | Error: " + XMLHttpRequest.responseText,"error");
  });  
}





function CancelarB(){	
		$("#divformoculto").hide();
		$("#divformbusqueda").show();
}

function BuscaActividad(){

if($("#CodigoAct").val()==""){
	swal("Atención", "Escriba Codigo De Actividad","error");
	return false;
}
			$('#btngBuscaActividad').button('loading');
  			var parametros = {
				 "BuscaActividadCodigoAct" :  $("#CodigoAct").val(),
				 "BuscaActividadCode" :  ""
			};	

			$.ajax({
			data:parametros,
			url:"Procesamiento/MdlActividades.php",
			type:"POST",
				success:function(resp){
					$('#btngBuscaActividad').button('reset');
					if(resp!="n"){
						var valores = eval(resp); 
						$("#Fechaa").val(valores[0][0]);
						$("#Tipoa").val(valores[0][1]);
						$("#Soportea").val(valores[0][2]);
						$("#Observacionesa").val(valores[0][3]);
						$("#divformoculto").show();
						$("#divformbusqueda").hide();
					}else{
						swal("Atención", "No Existe La Actividad","error");
						$("#divformoculto").hide();
					}	
				},
				error:function(XMLHttpRequest, textStatus, errorThrown){
					$('#btnGenerar').button('reset');
		       		 swal("Atención", "Status: " + textStatus+" | Error: " + errorThrown+" | Error: " + XMLHttpRequest.responseText,"error");
				}
			});
}

function Generar(){

			$('#btnGenerar').button('loading');
  			var parametros = {
				 "GenerarInicio" :  $("#Inicio").val(),
				 "GenerarFinal" :  $("#Final").val(),
				 "GenerarTipoB" :  $("#TipoB").val(),
				 "GenerarSoporteB" :  $("#SoporteB").val(), 
				 "GenerarUsr" :  "<?php echo $_SESSION['LMNS-USER_USUARIO'];?>"
			};	

			$.ajax({
			data:parametros,
			url:"Procesamiento/MdlActividades.php",
			type:"POST",
				success:function(resp){
					$('#Listado').html(resp); 
					$('#example').DataTable();
					$('#btnGenerar').button('reset');	
				},
				error:function(XMLHttpRequest, textStatus, errorThrown){
					$('#btnGenerar').button('reset');
		       		 swal("Atención", "Status: " + textStatus+" | Error: " + errorThrown+" | Error: " + XMLHttpRequest.responseText,"error");
				}
			});
}


function AnularAct(codigobtn){




	     	 swal({
			  title: "Atención",
			  text: "¿Confirma Anulacion de Actividad?",
			  icon: "error",
			  buttons: true,
			  dangerMode: false,
			})
			.then((willDelete) => {
			  if (willDelete) {

  			var parametros = {
				 "AnularAct" : codigobtn
			};	

			$.ajax({
			data:parametros,
			url:"Procesamiento/MdlActividades.php",
			type:"POST",
				success:function(resp){
					if(resp=="OK"){
					Generar();						
					}else{
					 swal("Atención", "No se pudo anular","error");
					}
				},
				error:function(XMLHttpRequest, textStatus, errorThrown){
		       		 swal("Atención", "Status: " + textStatus+" | Error: " + errorThrown+" | Error: " + XMLHttpRequest.responseText,"error");
				}
			});



			  } else {
	        		   return false;
			  }
			});


}




function DescargarDetallado(codigo){
	window.open("Reportes/rptDetalleActividades.php?CodActividad="+codigo+"&codclient=");
}

function Descargar(){
	window.open("Reportes/rptActividadesResumen.php?GenerarInicio="+$("#Inicio").val()+"&GenerarFinal="+$("#Final").val()+"&GenerarTipoB="+$("#TipoB").val()+"&GenerarSoporteB="+$("#SoporteB").val()+"&GenerarCode=");
}


function IngresarCliente(){
$("#divrespuestas").html("");
    if($("#Fecha").val()==''){
      swal("Atención!","Ingrese Fecha","warning");
      return false;
    }
    if($("#Tipo").val()==''){
      swal("Atención!","Seleccione Tipo Actvidad","warning");
      return false;
    }
    if($("#Soporte").val()==''){
      swal("Atención!","Seleccione Tipo Soporte","warning");
      return false;
    }
    if($("#Base").val()==''){
      swal("Atención!","Seleccione Base","warning");
      return false;
    }
  var dt = new Date();
  var month =dt.getMonth()+1;
  month=((month < 10) ? "0" : "") + month       
  var day =dt.getDate(); 
  day=((day < 10) ? "0" : "") + day
  var year = dt.getFullYear();
  var actual = year+'-'+month+'-'+day;  

	  if($("#Fecha").val()<actual){
		swal("Atención", "Seleccione fecha actividad igual o mayor fecha de hoy.","error");
	    return false;
	  }

	var archivos = document.getElementById("Base");//Damos el valor del input tipo file
	var archivo = archivos.files; //Obtenemos el valor del input (los arcchivos) en modo de arreglo	
	var data = new FormData();	

	data.append('archivo',archivo[0]);	
	data.append('CargaBase',"CargaBase");
	$("#Base").val("");

			$('#btng').button('loading');

	$.ajax({	
		url:'Procesamiento/Excel/CargaBase.php', //Url a donde la enviaremos
		type:'POST', //Metodo que usaremos
		contentType:false, //Debe estar en false para que pase el objeto sin procesar
		data:data, //Le pasamos el objeto que creamos con los archivos
		processData:false, //Debe estar en false para que JQuery no procese los datos a enviar
		cache:false //Para que el formulario no guarde cache		
	}).done(function(resp){	  
			    $(resp).each(function(){
			        if(resp.validacion=='Error'){
			        swal("Atención", resp.Mensaje,"error");
					$('#btng').button('reset');
			        }else if(resp.validacion=="OK"){
			         	$("#Nombre_Hoja").val(resp.nombre);
			            $("#Cantidad").val(resp.cantidad);
           				validarCarga(resp.nombre)  ;   
			            Progreso(0);	           
			        }
			    });
	  }).fail(  function(XMLHttpRequest, textStatus, errorThrown){
					$('#btng').button('reset');
     swal("Atención", "Status: " + textStatus+" | Error: " + errorThrown+" | Error: " + XMLHttpRequest.responseText,"error");
  });  
}



	function validarCarga(nombre){

  			var parametros = {
				 "validarCargaFecha" :  $("#Fecha").val(),
				 "validarCargaTipo" :  $("#Tipo").val(),
				 "validarCargaSoporte" :  $("#Soporte").val(),
				 "validarCargaObservaciones" :  $("#Observaciones").val(),
				 "validarCarganombre" :  nombre
			};	

			$.ajax({
			data:parametros,
			url:"Procesamiento/Excel/CargaBase.php",
			type:"POST",
				success:function(resp){
					
					    $(resp).each(function(){
					        if(resp.validacion=='Error'){
					       		 swal("Atención", resp.Mensaje,"error");
					        }else if(resp.validacion=="OK"){
					       		 swal("Atención", resp.Mensaje,resp.icono);									
					       		 if(resp.icono=="error"){
										$("#divrespuestas").html('<br><div class="alert alert-danger" role="alert"><strong>Detalle De La Revision:</strong><br> '
											+resp.detalleerror+'</div>');
					       		 }else{
										$("#divrespuestas").html("");
										$("#Observaciones").val("");
										$("#Tipo").val("");
					       		 }			                
					        }
					    });		
							$('#btng').button('reset');		
				},
				error:function(XMLHttpRequest, textStatus, errorThrown){
		       		 swal("Atención", "Status: " + textStatus+" | Error: " + errorThrown+" | Error: " + XMLHttpRequest.responseText,"error");
				}
			});
	}

function Progreso(idc){
		var nombre=$("#Nombre_Hoja").val();
		var cantidad=$("#Cantidad").val();

testwindow1 = window.open("Progreso.php?action=Proceso_Carga&archivo="+nombre+"&Cantidad="+cantidad+"&Proyecto=Generico", "Progreso", "location=0,status=0,scrollbars=0,width=800,height=200");
testwindow1.moveTo(50, 0);
	
}

function DetallarActividad(idc){
window.open("admActividadesDetalle.php?cod="+idc);

}

</script>
<!-- //pie-chart --><!-- index page sales reviews visitors pie chart -->

</head> 
<body class="cbp-spmenu-push">
	<div class="main-content" >





		<?php
		include("Partes/Menu.php");
		?>
		<!-- main content start-->
		<div id="page-wrapper">
			<div class="main-page">




          <input type="hidden" id="Cantidad" value="0">
          <input type="hidden" id="Nombre_Hoja" value="">



<div class="col-md-12  widget-shadow">


                        <ul id="myTabs" class="nav nav-tabs" role="tablist"> 
                            <li role="presentation" class="active"><a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="false">Formulario  De Registro </a></li>
                             <li role="presentation" class=""><a href="#Editp" role="tab" id="Editp-tab" data-toggle="tab" aria-controls="Editp" aria-expanded="true">Actualizaciones</a></li>
                             <li role="presentation" class=""><a href="#profile" role="tab" id="profile-tab" data-toggle="tab" aria-controls="profile" aria-expanded="true">Historico</a></li>
                        </ul>


                    <div id="myTabContent" class="tab-content scrollbar1"> 
 <div role="tabpanel" class="tab-pane fade  active in" id="home" aria-labelledby="home-tab"> 
                        <p>
                        <div class="panel panel-primary"> 
                            <div class="panel-heading"  style="background-color: #222D32 !important"> 
                                <h3 class="panel-title">Lumens | Actividades Formulario</h3> 
                            </div> 
                            <div class="panel-body" style="background-color: #fafafa"> 
    
                      <div class="single-bottom row" style="">
                    <!-- ROW -->


                        <div class="col-md-4">
                          <p><i class="fa fa-user-o"></i>Fecha Actividad</p>
                          <input id="Fecha" type="date" name="Fecha" class="form-control" />
                        </div>

                        <div class="col-md-4">
                          <p><i class="fa fa-user-o"></i>Tipo De Actividad</p>
                            <select id="Tipo" name="Tipo" class="form-control">
                                <option selected="" value="">Seleccionar...</option>
                                <option value="Mensajeria">Mensajeria</option>
                                <option  value="Gestion De Cobro">Gestion De Cobro</option>
                                <option value="Lectura De Contadores">Lectura De Contadores</option>
                                <option value="Corte y Reconexion">Corte y Reconexion</option>
                                <option value="Recogida">Recogida</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                          <p><i class="fa fa-user-o"></i>Tipo Soporte</p>
                            <select id="Soporte" name="Soporte"  class=" form-control">
                                <option value="Sin Soporte" selected="selected">Sin Soporte Requerido</option>
                                <option value="En Linea">Soporte transmision en linea</option>
                                <option value="Solo Wifi">Soporte transmision Wifi</option>
                            </select> 
                        </div>


                  
									      <div class="col-md-4 espacio4">
									        <p>Base De Datos</p>
									        <input id="Base" type="file" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" name="Base" class="form-control" />
									      </div>
                     


                        <div class="col-md-8 espacio4">
                          <p><i class="fa fa-user-o"></i>Observaciones</p>
                          <input id="Observaciones" type="text" name="Observaciones" class="form-control" />
                        </div>

                        <div class="col-md-12 espacio4" align="center">                         
                        <button id="btng" type="button" class="btn btn-success" onclick="IngresarCliente();" data-loading-text="<div class='loader'></div> Cargando, Espere...">Cargar Actividad</button>                     
                      <a href="Archivos/Instructivos/SubirBase.xlsx" target="_blank">  <button id="btng" type="button" class="btn btn-info" data-loading-text="<div class='loader'></div> Cargando, Espere...">Descargar Instructivo</button></a>
                        </div>
						<div class="row">
						  <div class="col-md-7 col-md-offset-2" id="divrespuestas"></div>
						</div>
						     

                      </div>



                            </div> 
                      </div>
                        </p> 
                    </div> 

                    <div role="tabpanel" class="tab-pane fade" id="Editp" aria-labelledby="Editp-tab"> 
                        <p>
                        <div class="panel panel-primary"> 
                            <div class="panel-heading"  style="background-color: #222D32 !important"> 
                                <h3 class="panel-title">Lumens |  Actualizaciones</h3> 
                            </div> 
                            <div class="panel-body" style="background-color: #fafafa"> 
    
                      <div class="single-bottom row" style="" id="divformbusqueda" >


                        <div class="col-md-4 espacio4" align="right">
                          <p><i class="fa fa-user-o"></i>Codigo Actividad</p>
                        </div>
                        <div class="col-md-3 espacio4">
                                             <input id="CodigoAct" type="text" name="CodigoAct" class="form-control" />
                        </div>

                        <div class="col-md-4 espacio4" align="left">                       
                        <button id="btngBuscaActividad" type="button" class="btn btn-primary" onclick="BuscaActividad();" data-loading-text="<div class='loader'></div> Cargando, Espere...">Buscar</button>

                        </div>

                      </div>

                      <div class="single-bottom row" style="" id="divformoculto">
                    <!-- ROW -->

<h3 style="color: orange">Datos De Actividad</h3>
                        <div class="col-md-4">
                          <p><i class="fa fa-user-o"></i>Fecha Actividad</p>
                          <input id="Fechaa" type="date" readonly="" name="Fechaa" class="form-control" />
                        </div>

                        <div class="col-md-4">
                          <p><i class="fa fa-user-o"></i>Tipo De Actividad</p>
                            <select id="Tipoa" name="Tipoa" readonly="" class="form-control">
                                <option selected="" value="">Seleccionar...</option>
                                <option value="Mensajeria">Mensajeria</option>
                                <option  value="Gestion De Cobro">Gestion De Cobro</option>
                                <option value="Lectura De Contadores">Lectura De Contadores</option>
                                <option value="Corte y Reconexion">Corte y Reconexion</option>
                                <option value="Recogida">Recogida</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                          <p><i class="fa fa-user-o"></i>Tipo Soporte</p>
                            <select id="Soportea" name="Soportea" readonly="" class=" form-control">
                                <option value="Sin Soporte" selected="selected">Sin Soporte Requerido</option>
                                <option value="En Linea">Soporte transmision en linea</option>
                                <option value="Solo Wifi">Soporte transmision Wifi</option>
                            </select> 
                        </div>


                  


                        <div class="col-md-8 espacio4">
                          <p><i class="fa fa-user-o"></i>Observaciones</p>
                          <input id="Observacionesa"  readonly=""type="text" name="Observacionesa" class="form-control" />
                        </div>

   <div class="col-md-4 espacio4" align="center"> <br> 
                        <button id="btnga" type="button" class="btn btn-danger" onclick="CancelarB();" data-loading-text="<div class='loader'></div> Cargando, Espere...">Cancelar</button>
                        </div>

<div class="clearfix" style="border-bottom: solid 1px #999; padding-bottom: 20px"></div>
<h3 style="color: orange">Reasignar Visitas</h3>

									      <div class="col-md-4 espacio4">
									        <p>Base De Datos</p>
									        <input id="BaseActualizar" type="file" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" name="BaseActualizar" class="form-control" />
									      </div>
               <div class="col-md-8 espacio4" align="left">     <br>                    
                        <button id="ActualizaDatos" type="button" class="btn btn-success" onclick="ActualizaDatos();" data-loading-text="<div class='loader'></div> Cargando, Espere...">cargar Archivo</button>      
                      <a href="Archivos/Instructivos/ReasignarVisitas.xlsx" target="_blank">  <button id="" type="button" class="btn btn-info" data-loading-text="<div class='loader'></div> Cargando, Espere...">Descargar Instructivo</button></a>

                </div>


<div class="clearfix" style="border-bottom: solid 1px #999; padding-bottom: 20px"></div>
<h3 style="color: orange">Adicionar Registros</h3>

									      <div class="col-md-4 espacio4">
									        <p>Base De Datos</p>
									        <input id="Baseadicionar" type="file" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" name="Baseadicionar" class="form-control" />
									      </div>
                         <div class="col-md-8 espacio4" align="left">     <br>                    
                        <button id="btnad" type="button" class="btn btn-success" onclick="AdicionarDatos();" data-loading-text="<div class='loader'></div> Cargando, Espere...">cargar Archivo</button>              

                      <a href="Archivos/Instructivos/SubirBase.xlsx" target="_blank">  <button id="btng" type="button" class="btn btn-info" data-loading-text="<div class='loader'></div> Cargando, Espere...">Descargar Instructivo</button></a>

                        </div>

						<div class="row">
						  <div class="col-md-7 col-md-offset-2" id="divrespuestasAdd"></div>
						</div>
                      </div>





                            </div> 
                      </div>
                        </p> 
                    </div> 

                    <div role="tabpanel" class="tab-pane fade" id="profile" aria-labelledby="profile-tab"> 
                            <p>

                                    <div class="panel panel-primary"> 
                                        <div class="panel-heading"  style="background-color: #222D32 !important"> 
                                            <h3 class="panel-title">Lumens | Actividades Listado</h3> 
                                        </div> 
                                        <div class="panel-body " style="background-color: #fafafa"> 


                          <div class="col-md-3">
                          <p><i class="fa fa-user-o"></i>Fecha Inicio</p>
                          <input id="Inicio" type="date" name="Inicio" class="form-control" />
                        </div>

                          <div class="col-md-3">
                          <p><i class="fa fa-user-o"></i>Fecha Final</p>
                          <input id="Final" type="date" name="Final" class="form-control" />
                        </div>

                        <div class="col-md-3">
                          <p><i class="fa fa-user-o"></i>Tipo De Actividad</p>
                            <select id="TipoB" name="TipoB" class="form-control">
                                <option selected="" value="">Todos</option>
                                <option value="Mensajeria">Mensajeria</option>
                                <option  value="Gestion De Cobro">Gestion De Cobro</option>
                                <option value="Lectura De Contadores">Lectura De Contadores</option>
                                <option value="Corte y Reconexion">Corte y Reconexion</option>
                                <option value="Recogida">Recogida</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                          <p><i class="fa fa-user-o"></i>Tipo Soporte</p>
                            <select id="SoporteB" name="SoporteB"  class=" form-control">
                                <option selected="" value="">Todos</option>
                                <option value="Sin Soporte" >Sin Soporte Requerido</option>
                                <option value="En Linea">Soporte transmision en linea</option>
                                <option value="Solo Wifi">Soporte transmision Wifi</option>
                            </select> 
                        </div>

                     					 <div class="col-md-12  espacio4">	<br>								      	<CENTER>
												<button type="button" class="btn btn-primary" onclick="Generar();"  id="btnGenerar">Generar Reporte</button>    	
												<button type="button" class="btn btn-success"  onclick="Descargar();" id="btndescargar">Descargar Reporte</button></CENTER>
												<br><br>
									      </div>

									      </div>

                                                <div class="single-bottom row" style="background-color: #f2f2f2;padding: 10px" >
                                                        <div id="Listado" class="single-bottom row " style=""></div>  
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