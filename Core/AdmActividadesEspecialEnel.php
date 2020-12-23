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
var cantidadpistoleo=0;
var cantidadpistoleodigita=0;
var codigoimpresion;
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
$("#fecharealizado").val(f.getFullYear()+"-"+mes+"-"+dia );
$("#Inicio").val(f.getFullYear()+"-"+mes+"-"+dia );
$("#Final").val(f.getFullYear()+"-"+mes+"-"+dia );

$("#Fecha_llegada_fisico").val(f.getFullYear()+"-"+mes+"-"+dia );
$("#Fecha_max_entrega").val(f.getFullYear()+"-"+mes+"-"+dia );

$("#btna").hide();  
$("#btnc").hide();
$("#divcantidaddigita").html(''+cantidadpistoleodigita);
$("#divcantidad").html(''+cantidadpistoleo);
 
});




  

function Cerrar(){	
	$('#myModalDetalle').modal('hide');

}





function Generar(){

			$('#btnGenerar').button('loading');
  			var parametros = {
				 "EspecialEnelGenerarInicio" :  $("#Inicio").val(),
				 "EspecialEnelGenerarFinal" :  $("#Final").val(),  
				 "EspecialEnelGenerarUsr" :  "<?php echo $_SESSION['LMNS-USER_USUARIO'];?>"
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
					}).then((willDelete) => {
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
	window.open("Reportes/rptDetalleActividadesEspecialEnel.php?CodActividad="+codigo);
}

function Impresion(idc){

	function VentanaCentrada(theURL,winName,features, myWidth, myHeight, isCenter) { //v3.0
        if(window.screen)if(isCenter)if(isCenter=="true"){
          var myLeft = (screen.width-myWidth)/2;
          var myTop = (screen.height-myHeight)/2;
          features+=(features!='')?',':'';
          features+=',left='+myLeft+',top='+myTop;
        }
      window.open(theURL,winName,features+((features!='')?',':'')+'width='+myWidth+',height='+myHeight);
    }

	
	VentanaCentrada("Reportes/rptImpresionGuiaEnel.php?CodActividad="+idc);  
}

function Descargar(){
	window.open("Reportes/rptActividadesResumen.php?GenerarInicio="+$("#Inicio").val()+"&GenerarFinal="+$("#Final").val()+"&GenerarTipoB="+$("#TipoB").val()+"&GenerarSoporteB="+$("#SoporteB").val()+"&GenerarCode=");
}

function Detallado(){
	window.open("Reportes/rptDetalleActividadesEspecialEnelRangoDeFechas.php?GenerarInicio="+$("#Inicio").val()+"&GenerarFinal="+$("#Final").val()+"&Tipo=Detallado");
}


function IngresarCliente(){

			$("#divrespuestas").html("");
			if($("#Fecha").val()==''){
			swal("Atención!","Ingrese Fecha","warning");
			return false;
			} 
			if($("#Base").val()==''){
			swal("Atención!","Seleccione Archivo","warning");
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

			if($("#Fecha_llegada_fisico").val()<actual){
			swal("Atención", "Seleccione  la fecha de llegada físico igual o mayor fecha de hoy.","error");
			return false;
			}

			if($("#Fecha_max_entrega").val()<actual){
			swal("Atención", "Seleccione la fecha máxima de entrega igual o mayor fecha de hoy.","error");
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
			url:'Procesamiento/Excel/CargaBaseEspecialEnel.php', //Url a donde la enviaremos
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
			   				validarCarga(resp.nombre);   
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
				 "validarCargaFechallegadafisico" :  $("#Fecha_llegada_fisico").val(), 
				 "validarCargaFechamaximaentrega" :  $("#Fecha_max_entrega").val(),  
				 "validarCargaObservaciones" :  $("#Observaciones").val(),
				 "validarCarganombre" :  nombre
			};	

			$.ajax({
			data:parametros,
			url:"Procesamiento/Excel/CargaBaseEspecialEnel.php",
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
	testwindow1 = window.open("Progreso.php?action=Proceso_Carga&archivo="+nombre+"&Cantidad="+cantidad+"&Proyecto=EspecialEnel", "Progreso", "location=0,status=0,scrollbars=0,width=800,height=200");
	testwindow1.moveTo(50, 0);
}

function DetallarActividad(idc){
window.open("admActividadesDetalleEspecialEnel.php?cod="+idc);

}


function ValidaConcatena(event) {
    if (event.keyCode == 13) {  Reasignar(); }
}

function ValidaConcatenadigita(event) {
    if (event.keyCode == 13) {  DigitarVisita(); }
}


var busquedadigitada="";
function DigitarVisita(){

if ($("#Guiadigita").val()!="") {

		  var parametrobusqueda1=$("#Guiadigita").val();
		  $("#Guiadigita").val('');

		  var c1=0;
		  while(c1==0){ 
		    if(parametrobusqueda1.indexOf(0)=='0'){
		      parametrobusqueda1=parametrobusqueda1.slice(1);
		    }else{
		      c1=1;
		    }
		  } 
			$("#divpistoleodigita").html('<center><br>Cargando, Espere...</center>');
 



  var Datos = {
        "BuscaDetalleEspecialEnelxGuia" : parametrobusqueda1
         };

  $.ajax({
          data:Datos,
          url:"Procesamiento/MdlActividades.php",
          type:"POST",
        success:function(resp){ 
			$("#divpistoleodigita").html(''); 
			if(resp=="n"){
					swal("Atención", "Numero de guia "+parametrobusqueda1+" no encontrado","error");
			}else{

			$('#myModalDetalle').modal('show');
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
			busquedadigitada=valores[0][27];
			$("#fecha_fisico").val(valores[0][28]); 
            $("#fecha_maxima").val(valores[0][29]);
            $("#cedula").val(valores[0][30]);
            $("#specialone").val(valores[0][31]);  
            $("#Posicionmedidor").val(valores[0][32]);
 
  


	 }
          


        },
        error:function(resp){
        	swal("Error!","Error Al Conectarse Al Servidor", "error");
        }
        });

	
}



}

function Reasignar(){


if ($("#Guia").val()!="") {
if ($("#Agente").val()!="") {

		  var parametrobusqueda=$("#Guia").val();
		  $("#Guia").val('');
		  var c=0;
		  while(c==0){ 
		    if(parametrobusqueda.indexOf(0)=='0'){
		      parametrobusqueda=parametrobusqueda.slice(1);
		    }else{
		      c=1;
		    }
		  } 


			$("#divpistoleo").html('<center><br>Cargando, Espere...</center>');

  			var parametros = {
				 "Reasignarparametrobusqueda" : parametrobusqueda,  
				 "ReasignarAgente" :  $("#Agente").val() ,  
				 "ReasignarUsuario" :  "<?php echo $_SESSION['LMNS-USER_USUARIO'];?>"
			};	 
			$.ajax({
			data:parametros,
			url:"Procesamiento/MdlActividades.php",
			type:"POST",
				success:function(resp){ 

						$("#divpistoleo").html('<center></center>'); 
					        if(resp!='OK'){
					       		 swal("Atención", resp,"error");
					        }else{
								cantidadpistoleo++;
								$("#divcantidad").html(''+cantidadpistoleo);
					        }
					  
				},
				error:function(XMLHttpRequest, textStatus, errorThrown){
		       		 swal("Atención", "Status: " + textStatus+" | Error: " + errorThrown+" | Error: " + XMLHttpRequest.responseText,"error");
				}
			});

	}else{
 			swal("Atención!","Seleccione Agente","warning");
	}
}

}

function AbrirPlanillas(idap){ 
	$('#myModal').modal('show');
  codigoimpresion=idap;
            $('#divlistaagentes').html("Cargando, espere por favor...");  
   

		var Datos = {
        "CargaAgentesActividad" : idap
         };

  		$.ajax({
          data:Datos,
          url:"Procesamiento/MdlActividades.php",
          type:"POST",
        success:function(resp){ 
          $('#divlistaagentes').html("Agentes Programados<br>"+resp
          	+'<button type="button" class="btn btn-success" onclick="GenerarPlanilla();"  style="margin-top:10px;width:100%" id="btnGenerarPlanilla">Generar Planilla</button> ');  
        },
        error:function(resp){
        	swal("Error!","Error Al Conectarse Al Servidor", "error");
        }
        });
 


} 


function GenerarPlanilla(){ 
	if ($('#AgenteListado').val()!="") {
		window.open("Reportes/rptPlanillasEspecialEnel.php?CodActividad="+codigoimpresion+"&codagente="+ $('#AgenteListado').val());
	}else{

 			swal("Atención!","Seleccione Agente","warning");
	}
}






function GuardarDatosDigita(){ 
			$("#divrespuestas").html("");


			if($("#fecharealizado").val()==''){
			swal("Atención!","Ingrese fecha realizado","warning");
			return false;
			} 
			if($("#medidor").val()==''){
			swal("Atención!","Ingrese medidor","warning");
			return false;
			} 

			if($("#anomalia").val()==''){
			swal("Atención!","Seleccione anomalia","warning");
			return false;
			} 



			if($("#estado").val()=='Pendiente'){
			swal("Atención!","Seleccione Estado","warning");
			return false;
			} 
 
			var dt = new Date();
			var month =dt.getMonth()+1;
			month=((month < 10) ? "0" : "") + month       
			var day =dt.getDate(); 
			day=((day < 10) ? "0" : "") + day
			var year = dt.getFullYear();
			var actual = year+'-'+month+'-'+day;  

			if($("#fecharealizado").val()>actual){
			swal("Atención", "Seleccione fecha realizado igual o menor a la fecha de hoy.","error");
			return false;
			}

			var archivos = document.getElementById("fileFotoguia");//Damos el valor del input tipo file
			var archivo = archivos.files; //Obtenemos el valor del input (los arcchivos) en modo de arreglo	
			var data = new FormData();	

			data.append('Digita',archivo[0]);	
			data.append('Digitafecharealizado',$("#fecharealizado").val());
			data.append('Digitatelefono',$("#telefono").val());
			data.append('Digitamedidor',$("#medidor").val());
			data.append('DigitaPosicionmedidor',$("#Posicionmedidor").val());
			data.append('Digitalectura',$("#lectura").val());
			data.append('Digitaquienrecibe',$("#quienrecibe").val());
			data.append('Digitadireccioncorrecta',$("#direccioncorrecta").val());
			data.append('Digitaobservaciones',$("#observaciones").val());
			data.append('Digitaanomalia',$("#anomalia").val());
			data.append('Digitaestado',$("#estado").val());
			data.append('Digitafecharealizado',$("#fecharealizado").val());  
			data.append('DigitaVisitas',busquedadigitada); 
 
			$("#Base").val("");
			$('#btng').button('loading');

			$.ajax({	
			url:'Procesamiento/MdlActividades.php', //Url a donde la enviaremos
			type:'POST', //Metodo que usaremos
			contentType:false, //Debe estar en false para que pase el objeto sin procesar
			data:data, //Le pasamos el objeto que creamos con los archivos
			processData:false, //Debe estar en false para que JQuery no procese los datos a enviar
			cache:false //Para que el formulario no guarde cache		
			}).done(function(resp){	 

				if (resp=="Registro Actualizado") {
     						 swal("Registro Exitoso!","Se ha actualizado correctamente", "success");
     						 Cerrar();
				}else{
        				swal("Error!",resp, "error");

				}




			}).fail(  function(XMLHttpRequest, textStatus, errorThrown){
						$('#btng').button('reset');
			swal("Atención", "Status: " + textStatus+" | Error: " + errorThrown+" | Error: " + XMLHttpRequest.responseText,"error");
			});  
}

//----------------------------------------------------------------------------------------------------------------------------------

function GuardarDatosMasivos(){ 
			$("#divrespuestas2").html("");

			if($("#updateMasivo").val()==''){ 
			swal("Atención!","Seleccione el archivo","warning");
			return false;
			} 
 
		
			var archivos = document.getElementById("updateMasivo");//Damos el valor del input tipo file
			var filename = archivos .files[0].name;
			var archivo = archivos.files; //Obtenemos el valor del input (los arcchivos) en modo de arreglo	
			var data = new FormData();	

			

			data.append('masivo',archivo[0]);	
			//data.append('DigitaMasivos',busquedadigitada); 
			data.append('DigitaMasivo','OK'); 
		

			$("#Base").val("");
			$("#updateMasivo").val("");
			//$('#btng').button('loading');
 
			$('#btngMasivoAceptar').html('Cargando...');

			$.ajax({	
			url:'Procesamiento/MdlActividades.php', //Url a donde la enviaremos
			type:'POST', //Metodo que usaremos
			contentType:false, //Debe estar en false para que pase el objeto sin procesar
			data:data, //Le pasamos el objeto que creamos con los archivos
        	dataType: 'JSON',
			processData:false, //Debe estar en false para que JQuery no procese los datos a enviar
			cache:false //Para que el formulario no guarde cache		
			}).done(function(resp){	  

				    $(resp).each(function(){
				        if(resp.validacion=='Error'){
					       		 swal("Atención", resp.Mensaje,"error");
					        }else if(resp.validacion=="OK"){
					       		 swal("Atención", resp.Mensaje,resp.icono);
									Cerrar();
									
									
									$('#btngMasivoAceptar').html('Actualizar');	
																
					       		 if(resp.icono=="error"){
										$("#divrespuestas2").html('<br><div class="alert alert-danger" role="alert"><strong>Detalle De La Revision:</strong><br> '
											+resp.detalleerror+'</div>');
     						                
					       		 }else{
										$("#divrespuestas2").html("");
										//$("#Observaciones").val(""); 
					       		 }			                
					        }
				    });
			}).fail(  function(XMLHttpRequest, textStatus, errorThrown){
				        $('#btngMasivoAceptar').html('Actualizar');
						//$('#btng').button('reset');
			swal("Atención", "Status: " + textStatus+" | Error: " + errorThrown+" | Error: " + XMLHttpRequest.responseText,"error");
			});
			

			
}

//----------------------------------------------------------------------------------------------------------------------------------



function Impresion(idc){

	function VentanaCentrada(theURL,winName,features, myWidth, myHeight, isCenter) { //v3.0
        if(window.screen)if(isCenter)if(isCenter=="true"){
          var myLeft = (screen.width-myWidth)/2;
          var myTop = (screen.height-myHeight)/2;
          features+=(features!='')?',':'';
          features+=',left='+myLeft+',top='+myTop;
        }
      window.open(theURL,winName,features+((features!='')?',':'')+'width='+myWidth+',height='+myHeight);
    }

	
	VentanaCentrada("Reportes/rptImpresionGuiaEnel.php?CodActividad="+idc);  
}
</script>
<!-- //pie-chart --><!-- index page sales reviews visitors pie chart -->

</head> 

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

                    <div class="clearfix espacio4"> </div>
<br>
            
   <div class="panel-heading espacio4"  style="background-color: #7696a5 !important;color:#fff !important;"> 
 <h3 class="panel-title">Recoleccion En Terreno</h3></div> 



 <div class="col-md-3 espacio4">
  <p><i class="fa fa-user-o"></i>Telefono</p>
  <input id="telefono" type="text"   name="telefono" class="form-control" />
</div>
 <div class="col-md-3 espacio4">
  <p><i class="fa fa-user-o"></i>Medidor</p>
  <input id="medidor" type="text"    name="medidor" class="form-control" />
</div>
 <div class="col-md-3 espacio4">
  <p><i class="fa fa-user-o"></i>Posicion Medidor</p>


<select name="Posicionmedidor"  id="Posicionmedidor" class="form-control"  >
<option value="REFERENCIA" selected="selected">REFERENCIA</option>
<option value="ANTERIOR" >ANTERIOR</option>
<option value="POSTERIOR" >POSTERIOR</option>
</select>   

</div>
 <div class="col-md-3 espacio4">
  <p><i class="fa fa-user-o"></i>Lectura</p>
  <input id="lectura" type="text"    name="lectura" class="form-control" />
</div>
 <div class="col-md-3 espacio4">
  <p><i class="fa fa-user-o"></i>Quien recibe</p>
  <input id="quienrecibe" type="text"    name="quienrecibe" class="form-control" />
</div>
 <div class="col-md-3 espacio4">
  <p><i class="fa fa-user-o"></i>Direccion correcta</p>
  <input id="direccioncorrecta" type="text"    name="direccioncorrecta" class="form-control" />
</div>
 <div class="col-md-3 espacio4">
  <p><i class="fa fa-user-o"></i>Observaciones</p>
  <input id="observaciones" type="text"  name="observaciones" class="form-control" />
</div>
 <div class="col-md-3 espacio4">
  <p><i class="fa fa-user-o"></i>Estado</p> 

<select name="estado"  id="estado" class="form-control"  >
<option value="EFECTIVO" selected="selected">EFECTIVO</option>
<option value="NO EFECTIVO" >NO EFECTIVO</option>  
<option value="Pendiente" >PENDIENTE</option>  
</select>   

</div>
 <div class="col-md-3 espacio4">
  <p><i class="fa fa-user-o"></i>Anomalia</p>
<select name="anomalia"  id="anomalia" class="form-control"   >
	<option value="" selected="selected">Seleccionar...</option>  
	<option value="EFECTIVA" >EFECTIVA</option>  
	<option value="SIN NOMENCLATURA" >SIN NOMENCLATURA</option>  
	<option value="DIFICIL LOCALIZACION" >DIFICIL LOCALIZACION</option>  
	<option value="DOBLE FACTURACION" >DOBLE FACTURACION</option>  
	<option value="ERROR EN DIRECCION" >ERROR EN DIRECCION</option>  
	<option value="PREDIO DEMOLIDO" >PREDIO DEMOLIDO</option>  
	<option value="PREDIO ABANDONADO" >PREDIO ABANDONADO</option>  
	<option value="ACCESO DENEGADO" >ACCESO DENEGADO</option>  
	<option value="LOTE VACIO" >LOTE VACIO</option>  
	<option value="APARTADO AEREO" >APARTADO AEREO</option>  
	<option value="FUERA DE CICLO O ZONA" >FUERA DE CICLO O ZONA</option>  
	<option value="PERRO BRAVO" >PERRO BRAVO</option>  
	<option value="ZONA PELIGROSA" >ZONA PELIGROSA</option>  
	<option value="AISLAMIENTO PREVENTIVO" >AISLAMIENTO PREVENTIVO</option>   
</select>   


</div>
 <div class="col-md-3 espacio4">
  <p><i class="fa fa-user-o"></i>Fecha realizado</p>
  <input id="fecharealizado" type="date"  name="fecharealizado" class="form-control" />
</div> 

 <div class="col-md-2 espacio4">
  <p><i class="fa fa-user-o"></i>Foto guia</p>
   <input id="fileFotoguia" type="file"  name="fileFotoguia" class="form-control" /> 
</div>


 
 
 <div class="col-md-12 espacio4" align="center"><br>
<button type="button" class="btn btn-primary" onclick="GuardarDatosDigita();" >Guardar Datos</button>
<button type="button" class="btn btn-dark" onclick="Cerrar();"  id="Cerrar">Cerrar Detalle</button>
</div>
              
                    <div class="clearfix espacio4"> </div>

      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      </div>
      <div class="modal-body" id="divlistaagentes" style="height: 100% !important">
      </div>
    </div>
  </div>
</div>


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


                        <div class="col-md-3">
                          <p><i class="fa fa-user-o"></i>Fecha Actividad</p>
                          <input id="Fecha" type="date" name="Fecha" class="form-control" />
                        </div> 

						<!--

						<div class="col-md-3">
                          <p><i class="fa fa-user-o"></i>Fecha llegada físico</p>
                          <input id="Fecha_llegada_fisico" type="date" name="Fecha_llegada_fisico" class="form-control" />
                        </div> 
 
						<div class="col-md-3">
                          <p><i class="fa fa-user-o"></i>Fecha máxima entrega</p>
                          <input id="Fecha_max_entrega" type="date" name="Fecha_max_entrega" class="form-control" />
                        </div> 

						  -->


                  
									      <div class="col-md-4  ">
									        <p>Base De Datos</p>
									        <input id="Base" type="file" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" name="Base" class="form-control" />
									      </div>
                     


                        <div class="col-md-5  ">
                          <p><i class="fa fa-user-o"></i>Comentarios</p>
                          <input id="Observaciones" type="text" name="Observaciones" class="form-control" />
                        </div>

					
                        <div class="col-md-12 espacio4" align="center">                         
                        <button id="btng" type="button" class="btn btn-success" onclick="IngresarCliente();" data-loading-text="<div class='loader'></div> Cargando, Espere...">Cargar Actividad</button>                     
                      <a href="Archivos/Instructivos/SubirBaseEspecialesEnel.xlsx" target="_blank">  <button id="btng" type="button" class="btn btn-info" data-loading-text="<div class='loader'></div> Cargando, Espere...">Descargar Instructivo</button></a>
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
    
           

                      <div class="single-bottom row" style="" id="">
                    <!-- ROW --> 
			<h3 style="color: orange">Reasignar Visitas</h3>
    		   <div class="col-md-4">
                          <p><i class="fa fa-user-o"></i> Agente Asignado</p>
                           <select id="Agente" name="Agente" class="form-control">   
                             <!--  <option  selected="selected" value="No">No Asignado</option> -->
                               <?php 
                                  $consulta="SELECT usuario,nombre FROM agentes   
                                  ORDER BY nombre ";   
                                  $datos=mysqli_query($mysqli,$consulta);  
                                   echo '<option  selected="selected" value=""> Seleccionar... </option> ';              
                                     while($row=mysqli_fetch_row($datos)){                           
                                         echo '<option   value="'.$row[0].'">'.$row[1].'</option>';   
                                     }

                               ?>
                              </select>    
                             

                        </div>
				
                        <div class="col-md-4 ">
                          <p><i class="fa fa-calendar-chechyk-o"></i>Cantidad<span id="divcantidad" style="font-weight: bold;margin-left: 100px"></span></p>
                          <input id="Guia" type="text" name="Guia" onkeypress="ValidaConcatena(event);" class="form-control" /> 
                        </div>		


						  <div class="col-md-4" id="divpistoleo" style="text-align: left;"> </div>
   </div>


                      <div class="single-bottom row" style="" id="">
                    <!-- ROW --> 
			<h3 style="color: orange">Digitación de visitas Individual</h3>
    		    
                        <div class="col-md-4 ">
                          <p><i class="fa fa-calendar-chechyk-o"></i>Cantidad <span id="divcantidaddigita" style="font-weight: bold;margin-left: 100px"></span></p>
                          <input id="Guiadigita" type="text" name="Guiadigita" onkeypress="ValidaConcatenadigita(event);" class="form-control" />
                        </div>		


						  <div class="col-md-4" id="divpistoleodigita" style="text-align: left;"> </div>

						  
   </div>



          <div class="single-bottom row" style="" id="">
						<!-- ROW --> 
				<h3 style="color: orange">Actualización masiva</h3>
					
							<div class="col-md-4 ">
							 <p><i class="fa fa-calendar-chechyk-o"></i>Seleccione archivo<span id="divupdatemasivo" style="font-weight: bold;"></span></p> 

							<input id="updateMasivo" type="file" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" name="updateMasivo" class="form-control">
							</div>

							 

					


							 <div class="col-md-8" id="divupdatemasivo" style="textdivupdatemasivo" style="font-weight: bold;"></span></p>
							 <p><i class="fa fa-calendar-chechyk-o"></i> <span id="divupdatemasivo" style="font-weight: bold;"></span></p>
									<button id="btngMasivoAceptar" type="button" class="btn btn-success" 
									onclick="GuardarDatosMasivos();" >
									Actualizar
									</button>

									<a href="Archivos/Instructivos/PlantillaActualizacion.xlsx" target="_blank">  
										<button id="btngMasivo" type="button" class="btn btn-info" 
										data-loading-text="<div class='loader'></div> Cargando, Espere...">Descargar Instructivo
										</button>
									</a>		

							 </div>

						  
            </div>



					<div class="row">
						  <div class="col-md-7 col-md-offset-2" id="divrespuestas2"></div>
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

                     					 <div class="col-md-6   ">	<br>
												<button type="button" class="btn btn-primary" onclick="Generar();"  id="btnGenerar">Ver Reporte</button>    	
												<button type="button" class="btn btn-success"  onclick="Descargar();" id="btndescargar">Descargar Reporte</button>
												<button type="button" class="btn btn-success"  onclick="Detallado();" id="btndescargar">Descargar Detalle</button>
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