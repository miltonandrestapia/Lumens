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
	$("#Fecha").val(f.getFullYear()+"-"+mes+"-"+dia);

});



function Exportar(){
  window.open("Reportes/rptSeguimiento.php?Fecha="+$("#Fecha").val()+"&Tipo="+$("#Tipo").val());
}



function Generar(){



    $('#Listado').html('<center>Cargando...</center>'); 
  var Datos = {
        "GenerarSeguimientoFecha":$("#Fecha").val(),
        "GenerarSeguimientoTipo":$("#Tipo").val(), 
 
         };

    $.ajax({
          data:Datos,
          url:"Procesamiento/MdlMonitoreo.php",
          type:"POST",
        success:function(resp){
          $('#Listado').html(resp); 
            $('#exampleDetalle').DataTable();
        },
        error:function(resp){
          swal("Error!","Error Al Conectarse Al Servidor", "error");
        }
     });  
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
                          <p><i class="fa fa-user-o"></i>Fecha </p>
                          <input id="Fecha" type="date" name="Fecha" class="form-control" />
                        </div>

  						          <div class="col-md-3">
                         	<p><i class="fa fa-user-o"></i>Tipo De Informe</p>
                            <select id="Tipo" name="Tipo" class="form-control" >
                                <option value="velocidad" selected="selected">Exceso de velocidad</option>
                                <option value="zona">Fuera de zona</option>
                            </select>
                        </div>

  						
                        	<div class="col-md-5  "><br>
                             <button type="button" class="btn btn-success" onclick="Generar();"  id="btnMonitoreo">Generar Reporte</button>
                             <button type="button" class="btn btn-success" onclick="Exportar();"  id="btnMonitoreo">Exportar A Excel</button>
  										    </div>
							</div>

                                                          <div class="panel-body" style="background-color: #fafafa"> 
                                                     <div class="single-bottom row" >
                                                                          <div id="Listado" class="single-bottom row" style=""></div>  
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