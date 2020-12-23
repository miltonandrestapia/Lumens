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
<title>Cepos Control | Lumens</title>
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


 $(document).ready(function(){




});

function validarTXT(){
     if (event.keyCode == 13) {IngresarCliente();}
}
function SeguimientoTXT(){
     if (event.keyCode == 13) {Seguimiento();}
}

function Descargar(){
  window.open("Reportes/Cepos.php");
}

function Seguimiento(){

   var CepoSeguimiento=$("#CepoSeguimiento").val();
    
    if(CepoSeguimiento==''){
      swal("Atención!","Ingrese Cepo","warning");
      return false;
    }

    $('#btng2').button('loading');
 $("#Listado").html('<iframe src="AdmCepoFrame.php?Cepo='+$("#CepoSeguimiento").val()+'" style="margin: 0px; padding: 0px; border:none;width: 100%;height: 100%"></iframe>');


    $('#Listadot').html('<center>Cargando...</center>'); 



    $.ajax({

    data:{CepoSeguimiento:CepoSeguimiento,'Seguimiento':'OK'},
     url:"Procesamiento/MdlCepos.php",
     type:"POST",
     success:function(resp){      
        $('#btng2').button('reset');      
        $("#CepoSeguimiento").val(''); 
        $('#Listadot').html(resp); 
        $('#example').DataTable();   
  },
  error:function(resp){
    $('#btng').button('reset');
      swal("Error!","Error Al Conectarse Al Servidor", "error");
  }

  }); 

}



function IngresarCliente(){
  //alert(1);
   var CepoDescarga=$("#CepoDescarga").val();
    
    if(CepoDescarga==''){
      swal("Atención!","Ingrese Cepo","warning");
      return false;
    }



$('#btng').button('loading');
    $.ajax({

    data:{CepoDescarga:CepoDescarga,'USR':'<?php echo $_SESSION['LMNS-USER_USUARIO'];?>','Descargar':'OK'},
     url:"Procesamiento/MdlCepos.php",
     type:"POST",
     success:function(resp){  
        

            $("#CepoDescarga").val('');
     if(resp=="OK"){              

         var cant=$("#cantidad").val();
          if(cant==0){
            $("#cantidad").val('1');
          }else{
            var sum=parseInt(cant)+1
            $("#cantidad").val(sum);
          }
    }else{  
      swal("Atención!",resp, "error");          
    }   
    $('#btng').button('reset');     
  },
  error:function(resp){
    $('#btng').button('reset');
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
		include("Partes/Menu.php");
		?>
		<!-- main content start-->
		<div id="page-wrapper">
			<div class="main-page">







<div class="col-md-12  widget-shadow">


                        <ul id="myTabs" class="nav nav-tabs" role="tablist"> 
                            <li role="presentation" class="active"><a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="false">Formulario  De Registro </a></li>
                             <li role="presentation" class=""><a href="#profile" role="tab" id="profile-tab" data-toggle="tab" aria-controls="profile" aria-expanded="true">Reporte - Seguimiento</a></li>
                        </ul>


                    <div id="myTabContent" class="tab-content scrollbar1"> 

                    <div role="tabpanel" class="tab-pane fade  active in" id="home" aria-labelledby="home-tab"> 
                        <p>
                        <div class="panel panel-primary"> 
                            <div class="panel-heading"  style="background-color: #222D32 !important"> 
                                <h3 class="panel-title">Lumens | Cepos Descarga</h3> 
                            </div> 
                            <div class="panel-body" style="background-color: #fafafa"> 
    
                      <div class="single-bottom row" style="">
                    <!-- ROW -->


                        <div class="col-md-4 col-md-offset-3 espacio4 ">
                          <p><i class="fa fa-calendar-chechyk-o"></i>Escriba Numero De Cepo</p>
                          <input id="CepoDescarga" type="text" name="CepoDescarga" class="form-control" onkeypress="validarTXT(event)"/>
                        </div>

                        <div class="col-md-1 espacio4 ">
                          <p><i class="fa fa-calendar-chechyk-o"></i>Cantidad</p>
                          <input id="cantidad" type="text" name="cantidad" class="form-control" readonly="" />
                        </div>


                        <div class="col-md-1 espacio4" align="center">      <br>                   
                        <button id="btng" type="button" class="btn btn-success" onclick="IngresarCliente();" data-loading-text="<div class='loader'></div> Cargando, Espere...">Recepcionar</button>
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
                                            <h3 class="panel-title">Lumens |  Cepos Reporte</h3> 
                                        </div> 

                                        <div class="panel-body" style="background-color: #fafafa"> 
                                                <div class="single-bottom row" >

        <div class="col-md-4 col-md-offset-2 espacio4 ">
                          <p><i class="fa fa-calendar-chechyk-o"></i>Cepo A Seguimiento</p>
                          <input id="CepoSeguimiento" type="text" name="CepoSeguimiento" class="form-control" onkeypress="SeguimientoTXT(event)"/>
                        </div>


                        <div class="col-md-5 espacio4" align="left">      <br>                   
                        <button id="btng2" type="button" class="btn btn-primary" onclick="Seguimiento();" data-loading-text="<div class='loader'></div> Cargando, Espere...">Seguimiento</button>   

                        <button id="btng2" type="button" class="btn btn-success" onclick="Descargar();" data-loading-text="<div class='loader'></div> Cargando, Espere...">Descargar Relacion General</button>
                        </div>

                        </div>
                                                <div class="single-bottom row" style="background-color: #f2f2f2;padding: 10px" >

                                                        <div id="Listadot" class="single-bottom row " style=";margin: 0px !important; padding: 0px !important;"></div>  
    <div id="Listado" class="single-bottom row " style="height: 500px !important;margin: 0px !important; padding: 0px !important;"></div>  

                                         
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