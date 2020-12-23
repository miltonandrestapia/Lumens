<?php
session_start();     
if (empty($_SESSION['LMNS-USER_NOMBREC'])){      
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
$("#Inicio").val(f.getFullYear()+"-"+mes+"-"+dia );
$("#Final").val(f.getFullYear()+"-"+mes+"-"+dia );
$("#btna").hide();  
$("#btnc").hide();
$("#divcantidad").html(''+cantidadpistoleo);
});




  


function Generar(){

			$('#btnGenerar').button('loading');
  			var parametros = {
				 "EspecialEnelGenerarInicio" :  $("#Inicio").val(),
				 "EspecialEnelGenerarFinal" :  $("#Final").val(),  
				 "EspecialEnelGenerarUsr" :  ""
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

function Descargar(){
	window.open("Reportes/rptActividadesResumen.php?GenerarInicio="+$("#Inicio").val()+"&GenerarFinal="+$("#Final").val()+"&GenerarTipoB="+$("#TipoB").val()+"&GenerarSoporteB="+$("#SoporteB").val()+"&GenerarCode=");
}

function Detallado(){
	window.open("Reportes/rptDetalleActividadesEspecialEnelRangoDeFechas.php?GenerarInicio="+$("#Inicio").val()+"&GenerarFinal="+$("#Final").val()+"&GenerarTipoB="+$("#TipoB").val()+"&GenerarSoporteB="+$("#SoporteB").val()+"&GenerarCode=");
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
				 "ReasignarUsuario" :  ""
			};	 
			$.ajax({
			data:parametros,
			url:"Procesamiento/MdlActividades.php",
			type:"POST",
				success:function(resp){ 
						$("#divpistoleo").html('<center></center>');
					    $(resp).each(function(){ 
					        if(resp.validacion=='Error'){
					       		 swal("Atención", resp.Mensaje,"error");
					        }else if(resp.validacion=="OK"){
								cantidadpistoleo++;
								$("#divcantidad").html(''+cantidadpistoleo);
					        }
					    });		 
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


</script>
<!-- //pie-chart --><!-- index page sales reviews visitors pie chart -->

</head> 
<body class="cbp-spmenu-push">
	<div class="main-content" >





		<?php
		include("Partes/MenuCliente.php");
		?>
		<!-- main content start-->
		<div id="page-wrapper">
			<div class="main-page">




          <input type="hidden" id="Cantidad" value="0">
          <input type="hidden" id="Nombre_Hoja" value="">


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
                             <li role="presentation" class="active"><a href="#profile" role="tab" id="profile-tab" data-toggle="tab" aria-controls="profile" aria-expanded="true">Historico</a></li>
                        </ul>


                    <div id="myTabContent" class="tab-content scrollbar1"> 
 <div role="tabpanel" class="tab-pane fade" id="home" aria-labelledby="home-tab"> 
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
    
           

                      <div class="single-bottom row" style="" id="divformoculto">
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
                          <p><i class="fa fa-calendar-chechyk-o"></i>Numero De Guia <span id="divcantidad" style="font-weight: bold;"></span></p>
                          <input id="Guia" type="text" name="Guia" onkeypress="ValidaConcatena(event);" class="form-control" />
                        </div>		


						  <div class="col-md-4" id="divpistoleo" style="text-align: left;"> </div>

 





                            </div> 
                            </div> 
                      </div>
                        </p> 
                    </div> 

                    <div role="tabpanel" class="tab-pane fade   active in" id="profile" aria-labelledby="profile-tab"> 
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