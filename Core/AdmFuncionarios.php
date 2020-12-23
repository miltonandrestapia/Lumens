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
<title>Funcionarios | Lumens</title>
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

$("#txt_nombre").focus();
$("#btna").hide();
$("#btnc").hide();

});
   
function IngresarCliente(){
  //alert(1);
   var Nombre=$("#txt_nombre").val();
   var Usuario=$("#Usuario").val();
   var Pass=$("#Pass").val();
   var Telefono=$("#Telefono").val();
   var Correo=$("#Correo").val();
   var Estado=$("#txt_estado").val();
   var Observaciones=$("#Observaciones").val();
   //var Empresa=$("#Empresa").val();
   var Departamento=$("#Departamento").val();  

//alert(2);
    
    if(Nombre==''){
      swal("Atención!","Ingrese Nombre","warning");
      //$("#txt_nombre").focus();
      return false;
    }
    
    if(Departamento=='Seleccionar...'){
      swal("Atención!","Seleccione el departamento","warning");
      //$("#txt_nombre").focus();
      return false;
    }


    if(Usuario==''){
      swal("Atención!","Ingrese Ususario","warning");
      //$("#txt_nit").focus();
      return false;
    }
    if(Pass==''){
      swal("Atención!","Ingrese Clave","warning");
      //$("#Contacto").focus();
      return false;
    }
    if(Telefono==''){
      swal("Atención!","Ingrese Telefono","warning");
      //$("#Telefono").focus();
      return false;
    }
    if(Correo==''){
      swal("Atención!","Ingrese Correo","warning");
      //$("#Correo").focus();
      return false;
    }
$('#btng').button('loading');
    $.ajax({  

    data:{Nombre:Nombre,Usuario:Usuario,Pass:Pass,Telefono:Telefono,Correo:Correo,Estado:Estado,Observaciones:Observaciones,Departamento:Departamento,'Ingresar':'OK'},
     url:"Procesamiento/MdlFuncionarios.php",
     type:"POST",
     success:function(resp){  
        
     if(resp=="OK"){              
      swal("Registro Exitoso!","Se ha registrado el usuario correctamente", "success");
      Nuevo();
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

function actualizar(){
   
   var Nombre=$("#txt_nombre").val();
   var Usuario=$("#Usuario").val();
   var Pass=$("#Pass").val();
   var Telefono=$("#Telefono").val();
   var Correo=$("#Correo").val();
   var Estado=$("#txt_estado").val();
   var Observaciones=$("#Observaciones").val();
   //var Empresa=$("#Empresa").val();
   var Departamento=$("#Departamento").val();  
//alert(2);
        if(Nombre==''){
      swal("Atención!","Ingrese Nombre","warning");
      //$("#txt_nombre").focus();
      return false;
    }

    if(Departamento=='Seleccionar...'){
      swal("Atención!","Seleccione el departamento","warning");
      //$("#txt_nombre").focus();
      return false;
    }

    if(Usuario==''){
      swal("Atención!","Ingrese Ususario","warning");
      //$("#txt_nit").focus();
      return false;
    }
    if(Pass==''){
      swal("Atención!","Ingrese Clave","warning");
      //$("#Contacto").focus();
      return false;
    }
    if(Telefono==''){
      swal("Atención!","Ingrese Telefono","warning");
      //$("#Telefono").focus();
      return false;
    }
    if(Correo==''){
      swal("Atención!","Ingrese Correo","warning");
      //$("#Correo").focus();
      return false;
    }
$('#btna').button('loading');
    $.ajax({

    data:{Nombre:Nombre,Usuario:Usuario,Pass:Pass,Telefono:Telefono,Correo:Correo,Estado:Estado,Observaciones:Observaciones,Departamento:Departamento,codigoc:codigoc,'Actualizar':'OK'},
     url:"Procesamiento/MdlFuncionarios.php",   
     type:"POST", 
     success:function(resp){  
        
     if(resp=="OK"){              
      swal("Registro Exitoso!","Se ha registrado el usuario correctamente", "success");
    }else{  
      swal("Atención!",resp, "error");          
    }   
    $('#btna').button('reset');   
  },
  error:function(resp){
    $('#btna').button('reset');
      swal("Error!","Error Al Conectarse Al Servidor", "error");
  }

  });  
}

function listar(){ 

  var Listado_dpto = $("#DepaDrop").val();
  var Listado_UniNeg =  $("#uniDrop").val();

  var Datos = {
       // "Listar" : '<?php //if($_SESSION['LMNS-USER_TIPO']!="Administrador"){ echo $_SESSION['LMNS-USER_CODE'];}else{echo"OK";}?>',
        "Listar" : '<?php if($_SESSION['LMNS-USER_TIPO']!="Administrador"){ echo"OK";}?>', 
        "Listado_dpto":Listado_dpto,
        "Listado_UniNeg":Listado_UniNeg 
 
         };

    $.ajax({
          data:Datos,
          url:"Procesamiento/MdlFuncionarios.php",
          type:"POST",
        success:function(resp){
          $('#Listado').html(resp); 
            //$(".sobretd").click(Buscar_Datos);
            $('#example').DataTable();
        },
        error:function(resp){
          swal("Error!","Error Al Conectarse Al Servidor", "error");
        }
     });  
}
  
function Nuevo(){
$("#txt_nombre").val('');
$("#Usuario").val('');
$("#Pass").val('');
$("#Telefono").val('');
$("#Correo").val('');
$("#Observaciones").val('');
$("#Departamento").val(''); 
$("#btna").hide();
$("#btnc").hide();
$("#btng").show();
$('#Usuario').attr("disabled", false);
}

function Buscar_Datos(codigo){ 
  Codigo_Registro= codigo;
  var Datos = {
        "Buscar_Datos" : Codigo_Registro,
         };

  $.ajax({
          data:Datos,
          url:"Procesamiento/MdlFuncionarios.php",
          type:"POST",
        success:function(resp){  
          
            resp=resp.split('§');
            if (resp[0]=='s'){
                $("#txt_nombre").val(resp[1]);
                $("#Usuario").val(resp[2]);
                $("#Pass").val(resp[3]);
                $("#Telefono").val(resp[4]); 
                $("#Correo").val(resp[5]);
                $("#txt_estado").val(resp[6]);
                $("#Departamento").val(resp[7]);
                $("#Observaciones").val(resp[8]);
                codigoc=resp[9];
                $("#home-tab").click();
                $("#btng").hide();
                $("#btna").show();
                $("#btnc").show();    
                $('#Usuario').attr("disabled", true);
            }else{
                swal("Atención!",resp, "error");
            }
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
		include("Partes/Menu.php");
		?>
		<!-- main content start-->
		<div id="page-wrapper">
			<div class="main-page">







                  <div class="col-md-12  widget-shadow">


                                          <ul id="myTabs" class="nav nav-tabs" role="tablist"> 
                                              <li role="presentation" class="active"><a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="false">Formulario  De Registro </a></li>
                                              <li role="presentation" class=""><a href="#profile" role="tab" id="profile-tab" data-toggle="tab" aria-controls="profile" aria-expanded="true">Reporte - Informe</a></li>
                                          </ul>


                                      <div id="myTabContent" class="tab-content scrollbar1"> 

                                      <div role="tabpanel" class="tab-pane fade  active in" id="home" aria-labelledby="home-tab"> 
                                          <p>
                                          <div class="panel panel-primary"> 
                                              <div class="panel-heading"  style="background-color: #222D32 !important"> 
                                                  <h3 class="panel-title">Lumens | Funcionarios Formulario</h3> 
                                              </div> 
                                              <div class="panel-body" style="background-color: #fafafa"> 
                      
                                        <div class="single-bottom row" style="">
                                      <!-- ROW -->

                                      <!-- <div class="col-md-4">
                                            <p><i class="fa fa-user-o"></i>Empresa</p>-->
                                              <?php
                  /*
                  if($_SESSION['LMNS-USER_TIPO']!="Administrador"){

                    $consulta="SELECT cons,nombre FROM empresas WHERE cons='".mysqli_real_escape_string($mysqli,$_SESSION['LMNS-USER_CODE'])."' ORDER BY nombre "; 
                                          $datos=mysqli_query($mysqli,$consulta);
                                        echo ' <select id="Empresa" name="Empresa" class="form-control">';           
                                          while($row=mysqli_fetch_row($datos)){                            
                                              echo '<option  selected="selected" value="'.$row[0].'">'.$row[1].'</option>';  
                                          }
                                          echo ' </select>';
                  }else{
                      $consulta="SELECT cons,nombre FROM empresas  ORDER BY nombre "; 
                                          $datos=mysqli_query($mysqli,$consulta);
                                        echo ' <select id="Empresa" name="Empresa" class="form-control">
                                            <option  selected="selected" value="">Seleccionar...</option>';           
                                          while($row=mysqli_fetch_row($datos)){                            
                                              echo '<option   value="'.$row[0].'">'.$row[1].'</option>';  
                                          }
                                          echo ' </select>';
                  }

                  */
                                      
                                              ?>
                                    <!--      </div> -->

                                          <div class="col-md-4">
                                            <p><i class="fa fa-user-o"></i> Nombre Funcionario</p>
                                            <input id="txt_nombre" type="text" name="txt_nombre" class="form-control" />
                                          </div>

                                          <div class="col-md-4 ">
                                            <p><i class="fa fa-calendar-check-o"></i>Usuario</p>
                                            <input id="Usuario" type="text" name="Usuario" class="form-control" />
                                          </div>
                                          <div class="col-md-4 ">
                                            <p><i class="fa fa-calendar-check-o"></i>Contraseña</p>
                                            <input id="Pass" type="text" name="Pass" class="form-control" />
                                          </div>

                                          <div class="col-md-4 espacio4">
                                            <p><i class="fa fa-id-card"></i>Telefono </p>
                                            <input id="Telefono" type="text" name="Telefono" class="form-control" />
                                          </div>
                                          <div class="col-md-4 espacio4">
                                            <p><i class="fa fa-calendar-check-o"></i>Correo </p>
                                            <input id="Correo" type="text" name="Correo" class="form-control" />
                                          </div>  


                                          <div class="col-md-4 espacio4">  
                                        <p><i class="fa fa-user-o"></i>Departamento</p>   
                                              <?php
                  /*
                  if($_SESSION['LMNS-USER_TIPO']!="Administrador"){  
                  */
                  $consulta="SELECT cons, nombre FROM departamentos  ORDER BY nombre "; 
                  $datos=mysqli_query($mysqli,$consulta);
                  echo ' <select id="Departamento" name="Departamento" class="form-control">
                    <option  selected="selected" value="">Seleccionar...</option>';           
                  while($row=mysqli_fetch_row($datos)){                             
                      echo '<option   value="'.$row[1].'">'.$row[1].'</option>';       
                  }
                  echo ' </select>';
                  /*}else{
                      $consulta="SELECT cons,nombre FROM empresas  ORDER BY nombre "; 
                                          $datos=mysqli_query($mysqli,$consulta);
                                        echo ' <select id="Empresa" name="Empresa" class="form-control">
                                            <option  selected="selected" value="">Seleccionar...</option>';           
                                          while($row=mysqli_fetch_row($datos)){                            
                                              echo '<option   value="'.$row[0].'">'.$row[1].'</option>';  
                                          }
                                          echo ' </select>';
                                        //}
                  */

                                      
                                              ?>
                                        </div>







                                          <div class="col-md-4 espacio4">
                                            <p><i class="fa fa-user-o"></i>Estado</p>
                                              <select id="txt_estado" name="txt_estado" class="form-control">
                                                <option selected="" value="Activo">Activo</option>
                                                <option value="Inactivo">Inactivo</option>
                                              </select>
                                          </div>

                                      


                                          <div class="col-md-8 espacio4">  
                                            <p><i class="fa fa-user-o"></i>Observaciones</p>
                                            <input id="Observaciones" type="text" name="Observaciones" class="form-control" />
                                          </div>

                                          <div class="col-md-12 espacio4" align="center">                         
                                          <button id="btng" type="button" class="btn btn-success" onclick="IngresarCliente();" data-loading-text="<div class='loader'></div> Cargando, Espere...">Guardar</button>
                                          <button id="btna" type="button" class="btn btn-success" onclick="actualizar();" data-loading-text="<div class='loader'></div> Cargando, Espere...">Actualizar</button>
                                          <button id="btnc" type="button" class="btn btn-danger" onclick="Nuevo();" data-loading-text="<div class='loader'></div> Cargando, Espere...">Cancelar</button>
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
                                                              <h3 class="panel-title">Lumens |  Funcionarios Listado</h3> 
                                                          </div> 
                                                          <div class="panel-body" style="background-color: #fafafa"> 
                                                                  <div class="single-bottom row" >
                                                                          <div id="Listado" class="single-bottom row" style=""></div>  
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