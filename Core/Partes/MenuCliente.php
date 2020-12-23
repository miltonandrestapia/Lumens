
	<div class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left" id="cbp-spmenu-s1">
		<!--left-fixed -navigation-->
		<aside class="sidebar-left">
      <nav class="navbar navbar-inverse">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".collapse" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="HomeClient.php">
<img src="images/logo.png" class="img-responsive">
            </a>
          </div>
          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="sidebar-menu">
              <li class="header"></li>
              <li class="treeview">
                <a href="HomeClient.php">
                <i class="fa fa-home"></i> <span>Pagina Principal</span>
                </a>
              </li>             
			  
			  <?php 

			  if ($_SESSION['LMNS-USER_NOMBREC']=="ENEL - CODENSA") {
			  	echo '  <li class="treeview">
	                <a href="AdmActividadesClientEspecialCodensa.php">
	                <i class="fa fa-laptop"></i>
	                <span>Actividades</span>
	                </a>
	              </li>';
			  }else{
				echo '  <li class="treeview">
	                <a href="AdmActividadesClient.php">
	                <i class="fa fa-laptop"></i>
	                <span>Actividades</span>
	                </a>
	              </li>';
			  }
			    
			  ?>

            


              <li class="treeview">
                <a href="AdmMonitoreo.php">
                <i class="fa fa-dashboard"></i>
                <span>Monitoreo</span>
                </a>
              </li>
              <li class="treeview">
                <a href="AdmUbicaciones.php">
                <i class="fa fa-map-marker"></i>
                <span>Ubicaciones</span>
                </a>
              </li>
              <li class="treeview">
                <a href="AdmTracking.php">
                <i class="fa fa-map-o"></i>
                <span>Tracking</span>
                </a>
              </li>

          
              <li class="treeview">
                <a href="#">
                <i class="fa fa-table "></i>
                <span>Reportes</span>
                <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu"> 
                    <li><a href="AdmReportesSeguimiento.php"><i class="fa fa-map-marker"></i>Seguimiento</a></li>
                     <?php 

			  if ($_SESSION['LMNS-USER_NOMBREC']=="ENEL - CODENSA") {
			  	echo '
                    <li><a href="AdmReportesActividadesEspecialEnel.php"><i class="fa fa-dot-circle-o"></i>Enel-Reparto Especial </a></li>';
			  } 
			    
			  ?>

                </ul>
              </li>

              <li class="treeview">
                <a href="AdmBusqueda.php">
                <i class="fa fa-search"></i>
                <span>Busqueda</span>
                </a>
              </li>

              <li class="treeview">
                <a href="Admzonas.php">
                <i class="fa fa-sitemap"></i>
                <span>Zonas</span>
                </a>
              </li>





            </ul>
          </div>
          <!-- /.navbar-collapse -->
      </nav>
    </aside>
	</div>
		<!--left-fixed -navigation-->
    
		
            <script>



              

  $(document).ready(function(){ 

   
    $("#DepaDrop").change(DropDpto);     
    


  $('.dropdown-toggle').click(function(e) {
  if ($(document).width() > 768) {
    e.preventDefault();

    var url = $(this).attr('href');

       
    if (url !== '#') {  
    
      window.location.href = url;
    }

  }
});



    
  

$(document).tooltip({
      position: {
        my: "justify bottom-5",
        at: "justify top",
        using: function( position, feedback ) {
          $( this ).css( position );
          $( "<div>" )  
            .addClass( "arrow" )
            .addClass( feedback.vertical )
            .addClass( feedback.horizontal )
            .appendTo( this );
        }
      } 
});  


function DropDpto () 
{

  var DepaDrop = $("#DepaDrop").val();  
   //alert(DepaDrop);  
  //$('#btna').button('loading');
    $.ajax({
    data:{DepaDrop:DepaDrop,'DeptoUpdate':'OK'},     
     url:"Procesamiento/userloginSessions.php", 
     type:"POST",    
     success:function(resp){      
location.reload();

  },
  error:function(resp){
   // $('#btna').button('reset');  
 
      alert("Error!","Error Al Conectarse Al Servidor", "error");
  }

  }); 
}



});



</script>

<style>

  .dropdown:hover .dropdown-menu {   
    display: block;
   

  }

 

  .dropdown-menu > li > a  {
    padding: 3px 1px;  

}
  
</style>
		<!-- header-starts -->
		<div class="sticky-header header-section ">
			<div class="header-left">
				<!--toggle button start-->
				<button id="showLeftPush"><i class="fa fa-bars"></i></button>
				<!--toggle button end-->
			
            <li class="dropdown head-dpdn" style="font-weight: bold;padding-right: 10px"> 
            </li>
            <li class="dropdown head-dpdn" style="font-weight: bold;padding-right: 10px;font-size: 70%;margin-top: 10px">DEPARTAMENTO: <?php if(!isset($_SESSION['LMNS_dpto'])) {echo "TODOS";} elseif($_SESSION['LMNS_dpto']==""){echo "TODOS";}else{echo $_SESSION['LMNS_dpto'];}  ?> 
            </li>
				<!--notification menu end -->
				<div class="clearfix"> </div>
			</div>
			<div class="header-right">
								
				<div class="profile_details">		
					<ul>
						<li class="dropdown profile_details_drop">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
								<div class="profile_img">	
									<span class="prfil-img"><img src="images/2.jpg" alt=""> </span> 
									<div class="user-name">
										<p style="color: #00dd99">En Linea •</p>
										<span style="color: #000;font-weight: bold;"><?php echo  $_SESSION['LMNS-USER_NOMBREC'];?></span>
									</div>
								  <span style="visibility:hidden">  Dropdown </span> <span class="caret"  style="border-top-width: 10px;"></span></a>  
          <ul class="dropdown-menu"> 
            
            <li><a href="#">Departamento:</a></li> 
            <li>

             
              <?php 
                        require_once("Procesamiento/Conexion.php"); 
                        $consulta="SELECT cons, nombre FROM departamentos  ORDER BY nombre ";   
                        $datos=mysqli_query($mysqli,$consulta);
                        echo '  <select id="DepaDrop" name="DepaDrop" class="form-control select-css" " >
                          <option  selected="selected" value="">TODOS</option>  ';           
                        while($row=mysqli_fetch_row($datos))
                        {                               
                            echo '<option   value="'.$row[1].'">'.$row[1].'</option>';     
                        } 
                        echo ' </select> 
                        ';

                    ?>

                          <script>
                                  
                                $("#DepaDrop").val('<?php if(isset($_SESSION['LMNS_dpto'])) {echo $_SESSION['LMNS_dpto'];} ?>'); 
                          </script>
            
            </li>
     
<input type="hidden" id="uniDrop" value="<?php if(isset($_SESSION['LMNS_unidad'])) {echo $_SESSION['LMNS_unidad'];} ?>">
            <li><a href="../" style="font-weight: bold; padding-top: 10px"><i class="fa fa-sign-out"></i>Cerrar Sesión</a></li>  
          </ul>
						</li>
					</ul>
				</div>
				<div class="clearfix"> </div>				
			</div>
			<div class="clearfix"> </div>	
		</div>
		<!-- //header-ends -->