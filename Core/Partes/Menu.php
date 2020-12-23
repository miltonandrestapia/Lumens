
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
            <a class="navbar-brand" href="Home.php">
<img src="images/logo.png" class="img-responsive">
            </a>
          </div>
          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="sidebar-menu">
              <li class="header"></li>
              <li class="treeview">
                <a href="Home.php">
                <i class="fa fa-home"></i> <span>Pagina Principal</span>
                </a>
              </li>              
        <li class="treeview">
                <a href="#">
                <i class="fa fa-cogs"></i>
                <span>Parametrizacion</span>
                <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                  <li><a href="AdmAgentes.php"><i class="fa fa-sitemap"></i>Agentes</a></li>
                  <li><a href="AdmDispositivos.php"><i class="fa fa-mobile"></i>Dispositivos</a></li>
                  <li><a href="AdmFuncionarios.php"><i class="fa fa-user"></i>Funcionarios</a></li>
                  <li><a href="AdmZonasForm.php"><i class="fa fa-sitemap"></i>Zonas</a></li> 
                  <li><a href="AdmUnidadNegocio.php"><i class="fa fa-users"></i>Unidad de negocio</a></li>
                  <li><a href="AdmClientes.php"><i class="fa fa-flag"></i>Clientes</a></li>
                  <?php
                  if($_SESSION['LMNS-USER_TIPO']=="Administrador"){
        //  echo '<li><a href="AdmEmpresas.php"><i class="fa fa-building-o"></i>Empresas</a></li>';
                }
                  ?>
                  
                </ul>
              </li> 

   <li class="treeview">
                <a href="#">
                <i class="fa fa-laptop "></i>
                <span>Actividades</span>
                <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="AdmActividades.php"><i class="fa fa-dot-circle-o"></i>Actividades</a></li> 
                    <li><a href="AdmActividadesEspecialEnel.php"><i class="fa fa-dot-circle-o"></i>Enel-Reparto Especial </a></li>
                </ul>
              </li>

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
                <a href="AdmBusqueda.php">
                <i class="fa fa-search"></i>
                <span>Busqueda</span>
                </a>
              </li>


              <li class="treeview">
                <a href="#">
                <i class="fa fa-table "></i>
                <span>Reportes</span>
                <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="AdmReportesActividades.php"><i class="fa fa-laptop"></i>Actividades</a></li> 
                    <li><a href="AdmReportesActividadesEspecialEnel.php"><i class="fa fa-dot-circle-o"></i>Enel-Reparto Especial </a></li>
                    <li><a href="AdmReportesSeguimiento.php"><i class="fa fa-map-marker"></i>Seguimiento</a></li>
                </ul>
              </li>




              <li class="treeview">
                <a href="#">
                <i class="fa fa-bullhorn "></i>
                <span>Comunicación</span>
                <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
              <li><a href="AdmNoticias.php"><i class="fa fa-location-arrow"></i>Noticias</a></li> 
            <li><a href="AdmNotificaciones.php"><i class="fa fa-comment"></i>Notificaciones</a></li>
                 </ul>
              </li>
        <li class="treeview">
                <a href="#">
                <i class="fa fa-file-text-o"></i>
                <span>Extras</span>
                <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                  <li><a href="Admzonas.php"><i class="fa fa-sitemap"></i>Zonas</a></li>
                  <li><a href="AdmCepos.php"><i class="fa fa-tty "></i>Control CEPOS</a></li>
               
                  
                </ul>
              </li>



            </ul>
          </div>
          <!-- /.navbar-collapse -->
      </nav>
    </aside>
  </div>
    <!--left-fixed -navigation-->
    
    <!-- header-starts -->
    <div class="sticky-header header-section ">
      <div class="header-left">
        <!--toggle button start-->
        <button id="showLeftPush"><i class="fa fa-bars"></i></button>
        <!--toggle button end-->
        <div class="profile_details_left"><!--notifications of menu start -->
          <ul class="nofitications-dropdown">
            <li class="dropdown head-dpdn">


            <script>



              

  $(document).ready(function(){ 

   
    $("#DepaDrop").change(DropDpto);     
    $("#uniDrop").change(MuniDrop);     
    

  /*


    $("#liAux").click(function() {   
      $("#aAux").attr('aria-expanded','true'); 
      $('#liAux').trigger('click.bs.dropdown');  
      //$('#liAux').addClass('open'); // Opens the dropdown

     // $("#liAux").attr('class', 'dropdown profile_details_drop ');
  }); 

$( ".dropdown" ).mouseover(function() {  

  //$("#ulx").css("visibility", "hidden");   
  
});

$( ".dropdown" ).mouseleave(function() {  
   
//$("#ulx").css("visibility", "hidden");   

});

  
 
$( ".dropdown" ).click(function() { 
  //$(".dropdown").css("display", "block");
  //alert("Damneee1wd!");
  //$(".dropdown:hover .dropdown-menu").css("display", "block");
 //$("#aAux").attr('aria-expanded','true');  
 //$(".dropdown profile_details_drop").attr('class', 'dropdown profile_details_drop open ');
 //$("#ulx").css("visibility", "visible"); 
 
 //$(".dropdown:hover .dropdown-menu").css("display", "block");
 
}); 
   */ 

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
//*********************************************************************************************** */
function MuniDrop () 
{

  var uniDrop = $("#uniDrop").val();  
   
   
    $.ajax({
    data:{uniDrop:uniDrop,'LMNS_unidadUpdate':'OK',  },
     url:"Procesamiento/userloginSessions.php",
     type:"POST",
     success:function(resp){   location.reload();

  },   
  error:function(resp){
   // $('#btna').button('reset');
      console.log("Error2!","Error Al Conectarse Al Servidor", "error");
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
<?php

/*
      $consulta="SELECT n.cons,n.encabezado,u.nombre 
     FROM noticias n inner join usuarios u on u.usuario= n.usuariocarga where fechacarga=curdate()
     and n.codempresa='".mysqli_real_escape_string($mysqli,$_SESSION['LMNS-USER_CODE'])."'  ORDER BY n.cons ASC"; 
*/
    $consulta="SELECT n.cons,n.encabezado,u.nombre 
    FROM noticias n inner join usuarios u on u.usuario= n.usuariocarga where fechacarga=curdate()
     ORDER BY n.cons ASC"; 
 

$datos=mysqli_query($mysqli,$consulta);       
if(mysqli_num_rows($datos)>0){   
echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-bell"></i><span class="badge red">'.mysqli_num_rows($datos).'</span></a>
  <ul class="dropdown-menu">
  <li>
    <div class="notification_header">
      <h3>Ultimas Noticias</h3>
    </div>
  </li>';        
  while($row=mysqli_fetch_row($datos)){ 
      echo '<li><a href="AdmNoticiasDetalle.php?cod='.$row[0].' ">
          <div class="user_img"><img src="images/4.jpg" alt=""></div>
           <div class="notification_desc">
          <p>'.$row[1].'</p>
          <p><span>'.$row[2].'</span></p>
          </div>
          <div class="clearfix"></div>  
         </a></li>';
  }
  echo '</ul>';
}else{
  echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-bell"></i><span class="badge blue">0</span></a>';
}
?>
         
            
            </li>          


            <li class="dropdown head-dpdn" style="font-weight: bold;padding-right: 10px"> 
            </li>
            <li class="dropdown head-dpdn" style="font-weight: bold;padding-right: 10px;font-size: 70%;margin-top: 10px">DEPARTAMENTO: <?php if(!isset($_SESSION['LMNS_dpto'])) {echo "TODOS";} elseif($_SESSION['LMNS_dpto']==""){echo "TODOS";}else{echo $_SESSION['LMNS_dpto'];}  ?> 
            </li>
            <li class="dropdown head-dpdn" style="color: orange;font-weight: bold;font-size: 70%;margin-top: 10px" > |
            </li>
            <li class="dropdown head-dpdn" style="font-weight: bold;padding-left: 10px;font-size: 70%;margin-top: 10px">  UNIDAD DE NEGOCIO: <?php if(!isset($_SESSION['LMNS_unidad'])) {echo "TODAS";} elseif($_SESSION['LMNS_unidad']==""){echo "TODAS";}else{echo $_SESSION['LMNS_unidad'];} ?>
            </li>
          </ul>

          <div class="clearfix"> </div>
        </div> 
        <!--notification menu end -->


        
        <div class="clearfix"> </div>
      </div>



      <div class="header-right">
                
        <div class="profile_details" id="hack">   
          <ul id ="liAux" class="dropdown profile_details_drop ">
            <li >

           
              <a href="#" id=""  class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">  
                <div class="profile_img"> 
                  <span class="prfil-img"><img src="images/2.jpg" alt=""> </span> 
                  <div class="user-name">  
                    <p style="color: #00dd99">En Linea •</p>
                    <span style="color: #000;font-weight: bold;"><?php echo  $_SESSION['LMNS-USER_NOMBRE'];?></span>
                  </div>
                <!--  <i class="fa fa-angle-down lnr"></i> 
                  <i class="fa fa-angle-up lnr"></i>-->  
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
     
            <li><a href="#" >Unidades de negocio:</a></li>

            <li> 

             
              <?php 
                       require_once("Procesamiento/Conexion.php"); 
                      // session_start();
                       $consulta="SELECT cons, unidad FROM unidades  ORDER BY unidad ";   
                       $datos=mysqli_query($mysqli,$consulta);
                       echo ' <select id="uniDrop" name="uniDrop" class="form-control " > 
                         <option  selected="selected" value="">TODAS</option> ';            
                       while($row=mysqli_fetch_row($datos))
                       {                               
                           echo '<option   value="'.$row[1].'">'.$row[1].'</option>';     
                       } 
                       echo ' </select> '; 
                            
                    ?>
  
                          <script>  
                                  $("#uniDrop").val('<?php if(isset($_SESSION['LMNS_unidad'])) {echo $_SESSION['LMNS_unidad'];} ?>'); 
                      
                          </script>
            
            </li>

            <li><a href="../" style="font-weight: bold; padding-top: 10px"><i class="fa fa-sign-out"></i>Cerrar Sesión</a></li>  
          </ul>
        </li>
      </ul>
                  <div class="clearfix"></div>  
                </div>  
              </a>     
              <!--
              <ul class="dropdown-menu drp-mnu" id="ulx">  
              <li id="lix" > 
                
                
                  
                    <i class="fa fa-sign-out"></i>Departamento
                    
                    <?php /*
                        require_once("Procesamiento/Conexion.php"); 
                        
                        $consulta="SELECT cons, nombre FROM departamentos  ORDER BY nombre ";   
                        $datos=mysqli_query($mysqli,$consulta);
                        echo '  <select id="Departamentos" name="Departamentos" class="form-control " >
                          <option  selected="selected" value="TODOS">TODOS</option> ';           
                        while($row=mysqli_fetch_row($datos))
                        {                               
                            echo '<option   value="'.$row[0].'">'.$row[1].'</option>';     
                        } 
                        echo ' </select> ';*/
                        
                    ?>
                  
               
            
            
            </li> 
              <li> 
                <a href="#">
                <span class="spanaux">   
                <i class="fa fa-sign-out"></i>Clientes
                <?php 
                       /* require_once("Procesamiento/Conexion.php"); 
                        
                        $consulta="SELECT cons, unidad FROM unidades  ORDER BY unidad ";   
                        $datos=mysqli_query($mysqli,$consulta);
                        echo ' <select id="unidades" name="unidades" class="form-control " >
                          <option  selected="selected" value="TODOS">TODOS</option> ';            
                        while($row=mysqli_fetch_row($datos))
                        {                               
                            echo '<option   value="'.$row[0].'">'.$row[1].'</option>';     
                        } 
                        echo ' </select> '; */
                        
                    ?>
                   </span> 
                </a> 
          </li>
              <li> <a href="../"><i class="fa fa-sign-out"></i> Cerrar Sesion</a> </li>    
              
              </ul> -->
              

            </li>
          </ul>
        </div>
        <div class="clearfix"> </div>       
      </div>
      <div class="clearfix"> </div> 
    </div>
    <!-- //header-ends -->