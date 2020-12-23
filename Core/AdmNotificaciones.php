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
<title>Notificaciones | Lumens</title>
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
 $('ul.nav-tabs li a').click(function(){
    var activeTab = $(this).attr('href');
    if(activeTab=='#profile'){
        listar();
        Nuevo();
    }
    if(activeTab=='#help'){
        Nuevo();
    }   

    if(activeTab=='#profileE'){
        listarEntrantes();
        Nuevo();
    }
 });



$("#encabezado").focus();
$("#btna").hide();
$("#btnc").hide();


});


function listarEntrantes(){
    var Datos = {
        "ListaRecibidas" : 'Ok',
        "Listaruser" : "<?php echo $_SESSION['LMNS-USER_USUARIO'];?>",
        "Listarcode" : "",
         };

    $.ajax({
          data:Datos,
          url:"Procesamiento/MdlNotificaciones.php",
          type:"POST",
        success:function(resp){
            $('#ListadoEntrantes').html(resp); 
            $('#exampleEntrantes').DataTable();
        },
        error:function(resp){
            swal("Error!","Error Al Conectarse Al Servidor", "error");
        }
     });
}

function IngresarCliente(){


     if($("#encabezado").val()==''){
      swal("Atención!","Ingrese Titulo","warning");
      return false;
    }
     if($("#descripcion").val()==''){
      swal("Atención!","Ingrese Descripcion","warning");
      return false;
    }
    
    $('#btng').button('loading');

    var data = new FormData();
    data.append("titulo",$("#encabezado").val());
    data.append("descripcion",$("#descripcion").val());
    data.append("rango",$("#Rango").val());
    data.append("Guardar","OK");
    data.append("codusuario","<?php echo $_SESSION['LMNS-USER_USUARIO'];?>");
    data.append("codcode"," ");


$("#archivo").val('');

var ajax = $.ajax({
  url:'Procesamiento/MdlNotificaciones.php', //Url a donde la enviaremos
  type:'POST', //Metodo que usaremos
  contentType:false, //Debe estar en false para que pase el objeto sin procesar
  data:data, //Le pasamos el objeto que creamos con los archivos
  processData:false, //Debe estar en false para que JQuery no procese los datos a enviar
  cache:false //Para que el formulario no guarde cache
});

ajax.done(function(resp){
  if(resp=="OK"){
  swal("Registro Exitoso!","Guardado Con Exito", "success");
  Nuevo();
}else{
  swal("Error!","No se pudo guardar, verifique los datos."+resp, "error");
}
$('#btng').button('reset');
});

ajax.fail(function(resp){
swal("Error!","Error Al Conectarse Al Servidor", "error");
  $('#btna').button('reset');
});

}

function listar(){
    var Datos = {
        "Listar" : 'Ok',
        "Listaruser" : "<?php echo $_SESSION['LMNS-USER_USUARIO'];?>",
        "Listarcode" : " ",
         };

    $.ajax({
          data:Datos,
          url:"Procesamiento/MdlNotificaciones.php",
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







  function Nuevo(){
    $("#encabezado").val('');
    $("#descripcion").val('');
    $("#Rango").val('');
    $("#btna").hide();
    $("#btnc").hide();
    $("#btng").show();
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



<div class="col-md-12  widget-shadow">


                        <ul id="myTabs" class="nav nav-tabs" role="tablist"> 
                            <li role="presentation" class="active"><a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="false">Formulario  De Registro </a></li>
                             <li role="presentation" class=""><a href="#profile" role="tab" id="profile-tab" data-toggle="tab" aria-controls="profile" aria-expanded="true">Reporte Salientes</a></li>
                             <li role="presentation" class=""><a href="#profileE" role="tab" id="profileE-tab" data-toggle="tab" aria-controls="profileE" aria-expanded="true">Reporte Entrantes</a></li>
                        </ul>


                    <div id="myTabContent" class="tab-content scrollbar1"> 

                    <div role="tabpanel" class="tab-pane fade  active in" id="home" aria-labelledby="home-tab"> 
                        <p>
                        <div class="panel panel-primary"> 
                            <div class="panel-heading"  style="background-color: #222D32 !important"> 
                                <h3 class="panel-title">Lumens | Notificaciones Formulario</h3> 
                            </div> 
                            <div class="panel-body" style="background-color: #fafafa"> 


                                        <div class="single-bottom row" >
                                        <!-- ROW -->
                                              <div class="col-md-4">
                                                      <p>Remitentes</p>
                                  <?php
                                        $consulta="SELECT usuario,nombre FROM agentes     ORDER BY nombre "; 
                                                  $datos=mysqli_query($mysqli,$consulta);
                                                  echo ' <select id="Rango" name="Rango" class="form-control">
                                                  <option  selected="selected" value="">Todos</option>';          
                                                  while($row=mysqli_fetch_row($datos)){                            
                                                   echo '<option value="'.$row[0].'">'.$row[1].'</option>';  
                                                  }
                                                  echo ' </select>';
                                  ?>
                                              </div>   


                                               <div class="col-md-8">
                                                <p>Titulo</p>
                                                <input type="text" name="encabezado" id="encabezado" class="form-control">
                                              </div>                                             

                                              <div class="col-md-12 col-form">
                                                <p>Descripcion</p>
                                                <textarea rows="3" class="form-control" id="descripcion" name="descripcion"></textarea>
                                              </div>
                                                                             

                                          
                                          <div class="col-md-12 espacio4" align="center">                                   
                                            <button id="btng" type="button" class="btn btn-success" onclick="IngresarCliente();" data-loading-text="<div class='loader'></div> Cargando, Espere...">Guardar</button>
                                            <button id="btna" type="button" class="btn btn-success"  onclick="actualizar();" data-loading-text="<div class='loader'></div> Cargando, Espere...">Actualizar</button>
                                            <button id="btnc" type="button" class="btn btn-danger" onclick="Nuevo();">Cancelar</button>
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
                                            <h3 class="panel-title">Lumens |  Notificaciones Salientes</h3> 
                                        </div> 
                                        <div class="panel-body" style="background-color: #fafafa"> 
                                                <div class="single-bottom row" >
                                                        <div id="Listado" class="single-bottom row" style=""></div>  
                                                </div>
                                        </div>
                                    </div>

                             </p> 
                    </div> 
                    <div role="tabpanel" class="tab-pane fade" id="profileE" aria-labelledby="profileE-tab"> 
                            <p>

                                    <div class="panel panel-primary"> 
                                        <div class="panel-heading"  style="background-color: #222D32 !important"> 
                                            <h3 class="panel-title">Lumens |  Notificaciones Entrantes</h3> 
                                        </div> 
                                        <div class="panel-body" style="background-color: #fafafa"> 
                                                <div class="single-bottom row" >
                                                        <div id="ListadoEntrantes" class="single-bottom row" style=""></div>  
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