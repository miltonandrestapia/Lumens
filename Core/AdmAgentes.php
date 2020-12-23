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
<title>Agentes | Lumens</title>
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
     if(activeTab=='#OperativosEnel'){
      listarEnel(); 
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

function ActualizarZonas(){
$("#divrespuestas").html("");

    if($("#Base").val()==''){
      swal("Atención!","Seleccione Base","warning");
      return false;
    }


  var archivos = document.getElementById("Base");//Damos el valor del input tipo file
  var archivo = archivos.files; //Obtenemos el valor del input (los arcchivos) en modo de arreglo 
  var data = new FormData();  

  data.append('archivo',archivo[0]);  
  data.append('ActualizaZonas',"ActualizaZonas");
  data.append('ActualizaZonasCode',"<?php //echo $_SESSION['LMNS-USER_CODE'];?>");
  $("#Base").val("");

      $('#btnzonas').button('loading');

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
                $('#btnzonas').button('reset');
              }else if(resp.validacion=="OK"){                
                swal(resp.cantidad+" Registros Actualizados" ,resp.Mensaje, resp.icono);
                $('#btnzonas').button('reset');
              }else{
                alert(resp.validacion);
              }
          });

    }).fail(  function(XMLHttpRequest, textStatus, errorThrown){
  $('#btnzonas').button('reset');
     swal("Atención", "Status: " + textStatus+" | Error: " + errorThrown+" | Error: " + XMLHttpRequest.responseText,"error");
  });


}




function IngresarCliente(){

  //alert(1);
   var Nombre=$("#txt_nombre").val();
   var Usuario=$("#Usuario").val();
   var Pass=$("#Pass").val();
   var Telefono=$("#Telefono").val();
   var Correo=$("#Correo").val();
   var Estado=$("#txt_estado").val();
   var Observaciones=$("#Observaciones").val();
  // var Empresa=$("#Empresa").val();
   var Desplazamiento=$("#Desplazamiento").val();
   var Unidad=$("#Unidad").val();
   var Sector=$("#Sector").val();
   var Departamento=$("#Departamento").val();
   var Imei=$("#Imei").val();
   var TipoAgente=$("#TipoAgente").val();
   var  unidadNeg = $("#unidadNeg").val();

  
//alert(2);
     if(Sector==''){
      swal("Atención!","Ingrese Sector","warning");
      //$("#txt_nombre").focus();
      return false;
    }
    if(Nombre==''){
      swal("Atención!","Ingrese Nombre","warning");
      //$("#txt_nombre").focus();
      return false;
    }

    /*
    if(Empresa==''){
      swal("Atención!","Seleccione Empresa","warning");
      //$("#txt_nombre").focus();
      return false;
    }
*/

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

    if(Departamento == ''){
      swal("Atención!","Seleccione departamento","warning");
      return false;
    }


    if(unidadNeg == ''){
      swal("Atención!","Seleccione unidad de negocio","warning");
     return false;
    }


$('#btng').button('loading');
    $.ajax({

    data:{Nombre:Nombre,Usuario:Usuario,Pass:Pass,Telefono:Telefono,Correo:Correo,Estado:Estado,Observaciones:Observaciones,Sector:Sector,Unidad:Unidad,Desplazamiento:Desplazamiento,Departamento:Departamento,Imei:Imei,TipoAgente:TipoAgente,unidadNeg:unidadNeg,'Ingresar':'OK'},
     url:"Procesamiento/MdlAgentes.php",
     type:"POST",
     success:function(resp){  
        
     if(resp=="OK"){              
      swal("Registro Exitoso!","Se ha registrado el usuario correctamente", "success");
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
   var Desplazamiento=$("#Desplazamiento").val();
   var Unidad=$("#Unidad").val();
   var Sector=$("#Sector").val();
   var Departamento=$("#Departamento").val();
   var Imei=$("#Imei").val();
   var TipoAgente=$("#TipoAgente").val();
   var unidadNeg = $("#unidadNeg").val();   

  if(Sector==''){
      swal("Atención!","Ingrese Sector","warning");
      //$("#txt_nombre").focus();
      return false;
    }
        if(Nombre==''){
      swal("Atención!","Ingrese Nombre","warning");
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

    if(Departamento == ''){
      swal("Atención!","Seleccione departamento","warning");
      return false;
    }


    if(unidadNeg == ''){
      swal("Atención!","Seleccione unidad de negocio","warning");
     return false;
    }

$('#btna').button('loading');
    $.ajax({

    data:{Nombre:Nombre,Usuario:Usuario,Pass:Pass,Telefono:Telefono,Correo:Correo,Estado:Estado,Observaciones:Observaciones,Sector:Sector,Unidad:Unidad,Desplazamiento:Desplazamiento,codigoc:codigoc,Departamento:Departamento,Imei:Imei,TipoAgente:TipoAgente,unidadNeg:unidadNeg,'Actualizar':'OK'},
     url:"Procesamiento/MdlAgentes.php",
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
        "Listar" : "OK",<?php //echo $_SESSION['LMNS-USER_CODE'];?>
        "Listado_dpto":Listado_dpto,
        "Listado_UniNeg":Listado_UniNeg
         };

    $.ajax({
          data:Datos,
          url:"Procesamiento/MdlAgentes.php",
          type:"POST",
        success:function(resp){
          $('#Listado').html(resp); 
            //$(".sobretd").click(Buscar_Datos);
            $('#example').DataTable();
           // alert(Listado_dpto+ " " + Listado_UniNeg);
           
        },
        error:function(resp){
          swal("Error!","Error Al Conectarse Al Servidor", "error");
        }
     });
}


function listarEnel(){

  var Listado_dpto = $("#DepaDrop").val();
  var Listado_UniNeg =  $("#uniDrop").val();

  var Datos = {
        "ListarEnel" : "OK", 
        "Listado_dpto":Listado_dpto,
        "Listado_UniNeg":Listado_UniNeg
         };

    $.ajax({
          data:Datos,
          url:"Procesamiento/MdlAgentes.php",
          type:"POST",
        success:function(resp){
            $('#ListadoEnel').html(resp);  
            $('#exampleEnel').DataTable(); 
           
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
$("#unidadNeg").val('');   
$("#Imei").val('');

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
          url:"Procesamiento/MdlAgentes.php",
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
                $("#Empresa").val(resp[7]);
                $("#Observaciones").val(resp[8]);
                codigoc=resp[9];
                $("#Desplazamiento").val(resp[10]);
                $("#Unidad").val(resp[11]);
                $("#Sector").val(resp[12]);
                $("#Departamento").val(resp[13]);
                $("#Imei").val(resp[14]);
                $("#TipoAgente").val(resp[15]);
                $("#unidadNeg").val(resp[16]);
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


function DescargarEnel(){
  
  window.open("Reportes/EnelDatosVehiculos.php?Listado_dpto="+$("#DepaDrop").val()+"&Listado_UniNeg="+$("#uniDrop").val());
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
                             <li role="presentation" class=""><a href="#Zonas" role="tab" id="Zonas-tab" data-toggle="tab" aria-controls="Zonas" aria-expanded="true">Zonas Masivas</a></li>
                             <li role="presentation" class=""><a href="#OperativosEnel" role="tab" id="OperativosEnel-tab" data-toggle="tab" aria-controls="OperativosEnel" aria-expanded="true">Datos Operativos Enel</a></li>
                        </ul>


                    <div id="myTabContent" class="tab-content scrollbar1"> 

                    <div role="tabpanel" class="tab-pane fade" id="OperativosEnel" aria-labelledby="OperativosEnel-tab"> 
                            <p>

                                    <div class="panel panel-primary"> 
                                        <div class="panel-heading"  style="background-color: #222D32 !important"> 
                                          <div class=" col-md-10 ">   
                                            <h3 class="panel-title"  >Lumens |  Datos Operativos Enel </h3> 
                                          </div>

                                        <div class=" col-md-2 ">   
                                          <button  type="button" class="btn btn-success" onclick="DescargarEnel();" >Exportar datos</button>    
                                        </div>
                                        </div> 
                                        <div class="panel-body" style="background-color: #fafafa"> 
                                                <div class="single-bottom row" >
                                                        <div id="ListadoEnel" class="single-bottom row" style=""></div>  
                                                </div>
                                        </div>
                                    </div>

                             </p> 
                    </div> 

                    <div role="tabpanel" class="tab-pane fade  active in" id="home" aria-labelledby="home-tab"> 
                        <p>
                        <div class="panel panel-primary"> 
                            <div class="panel-heading"  style="background-color: #222D32 !important"> 
                                <h3 class="panel-title">Lumens | Agentes Formulario</h3> 
                            </div> 
                            <div class="panel-body" style="background-color: #fafafa"> 
    
                      <div class="single-bottom row" style="">
                    <!-- ROW -->

                 <!--     <div class="col-md-4"> -->
                      
                         <!-- <p><i class="fa fa-user-o"></i>Empresa</p>-->
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
              <!--      </div>       --->     
                 
                        <div class="col-md-4">
                          <p> Nombre Agente</p>
                          <input id="txt_nombre" type="text" name="txt_nombre" class="form-control" />
                        </div>

                        <div class="col-md-4 ">
                          <p></i>Usuario</p>
                          <input id="Usuario" type="text" name="Usuario" class="form-control" />
                        </div>
                        <!-- se le quitó la clase espacio4 en contraseña-->
                        <div class=" col-md-4 ">   
                          <p>Contraseña</p>
                          <input id="Pass" type="text" name="Pass" class="form-control" />
                        </div>

                        <div class="col-md-4 espacio4">
                          <p><i class="fa fa-id-card"></i>Telefono </p>
                          <input id="Telefono" type="text" name="Telefono" class="form-control" />
                        </div>

                        <div class="col-md-4 espacio4">
                          <p>Correo </p>
                          <input id="Correo" type="text" name="Correo" class="form-control" />
                        </div>
                        <div class="col-md-4 espacio4">
                          <p><i class="fa fa-user-o"></i>Tipo Desplazamiento</p>
                            <select id="Desplazamiento" name="Desplazamiento" class="form-control">
                                <option selected="" value="Moto">Moto</option>
                                <option  value="Carro">Carro</option>
                              <option value="Bicicleta">Bicicleta</option>
                              <option value="A pie">A pie</option>
                            </select>
                        </div>
                        <div class="col-md-4 espacio4">
                          <p><i class="fa fa-user-o"></i>Unidad Servicio</p>
                            <select id="Unidad" name="Unidad" class="form-control">
                                <option selected="" value="Mensajeria">Mensajeria</option>
                                <option  value="Gestion De Cobro">Gestion De Cobro</option>
                                <option value="Lectura De Contadores">Lectura De Contadores</option>
                                <option value="Corte y Reconexion">Corte y Reconexion</option>
                                <option value="Publicidad">Publicidad</option>
                                <option value="Reparto Especial">Reparto Especial</option>
                                <option value="Seguimiento">Seguimiento</option>
                            </select>
                        </div>

                        <div class="col-md-4 espacio4">
   <p><i class="fa fa-user-o"></i>Departamento</p>
   <?php
                       /*  <select id="Departamento" name="Departamento" class="form-control">
                                <option  selected="" value="">Seleccionar...</option>
                               </option><option  value="AMAZONAS">AMAZONAS</option>   <option  value="ANTIOQUIA">ANTIOQUIA</option>   <option  value="ARAUCA">ARAUCA</option>   <option  value="ATLANTICO">ATLANTICO</option>   <option  value="BOLIVAR">BOLIVAR</option>   <option  value="BOYACA">BOYACA</option>   <option  value="CALDAS">CALDAS</option>   <option  value="CAQUETA">CAQUETA</option>   <option  value="CASANARE">CASANARE</option>   <option  value="CAUCA">CAUCA</option>   <option  value="CESAR">CESAR</option>   <option  value="CHOCO">CHOCO</option>   <option  value="CORDOBA">CORDOBA</option>   <option  value="CUNDINAMARCA">CUNDINAMARCA</option>   <option  value="D.C.">D.C.</option>   <option  value="GUAINIA">GUAINIA</option>   <option  value="GUAJIRA">GUAJIRA</option>   <option  value="GUAVIARE">GUAVIARE</option>   <option  value="HUILA">HUILA</option>   <option  value="ISLAS">ISLAS</option>   <option  value="LA GUAJIRA">LA GUAJIRA</option>   <option  value="MAGDALENA">MAGDALENA</option>   <option  value="META">META</option>  <option  value="NARIÑO">NARIÑO</option>   <option  value="NORTE DE SANTANDER">NORTE DE SANTANDER</option>   <option  value="PUTUMAYO">PUTUMAYO</option>   <option  value="QUINDIO">QUINDIO</option>   <option  value="RISARALDA">RISARALDA</option>   <option  value="SANTANDER">SANTANDER</option>   <option  value="SUCRE">SUCRE</option>   <option  value="TOLIMA">TOLIMA</option>   <option  value="VALLE DEL CAUCA">VALLE DEL CAUCA</option>   <option  value="VAUPES">VAUPES</option>   <option  value="VICHADA">VICHADA</option>

                             </select> -->*/
                             $consulta="SELECT cons, nombre FROM departamentos  ORDER BY nombre ";   
$datos=mysqli_query($mysqli,$consulta);
echo ' <select id="Departamento" name="Departamento" class="form-control">
   <option  selected="selected" value="">Seleccionar...</option>';           
while($row=mysqli_fetch_row($datos)){                               
    echo '<option   value="'.$row[1].'">'.$row[1].'</option>';    
}
echo ' </select>';
   
 
?>
                           </div>

                        <div class="col-md-4 espacio4">
                          <p><i class="fa fa-user-o"></i>Sector Operativo</p>
                            <select id="Sector" name="Sector" class="form-control">
                              <option  value="">Seleccionar...</option>


 <?php


   //$consulta="SELECT codigo,nombre FROM zonas WHERE codempresa='".mysqli_real_escape_string($mysqli,$_SESSION['LMNS-USER_CODE'])."' ORDER BY nombre "; 
   $consulta="SELECT codigo,nombre FROM zonas  ORDER BY nombre "; 
                        $datos=mysqli_query($mysqli,$consulta);          
                        while($row=mysqli_fetch_row($datos)){                            
                            echo '<option  value="'.$row[0].'">'.$row[1].'</option>';  
                        }                    
                        
?>





                            </select>
                        </div>




                        <div class="col-md-4 espacio4">
                          <p><i class="fa fa-user-o"></i>Estado</p>
                            <select id="txt_estado" name="txt_estado" class="form-control">
                              <option selected="" value="Activo">Activo</option>
                              <option value="Inactivo">Inactivo</option>
                            </select>
                        </div>

                     

                        <div class="col-md-4 espacio4">
                          <p>Imei </p>
                          <input id="Imei" type="text" name="Imei" class="form-control" />
                        </div>
                   <div class="col-md-4 espacio4">
                          <p><i class="fa fa-user-o"></i>Tipo Agente</p>
                            <select id="TipoAgente" name="TipoAgente" class="form-control">
                              <option selected="" value="Operativo">Operativo</option>
                              <option value="Supervisor">Supervisor</option>
                            </select>
                        </div>

                <div class="col-md-4 espacio4">
                    <p><i class="fa fa-user-o"></i>Unidad de negocio</p>
                    <?php
              
                  
                      $consulta="SELECT cons, unidad FROM unidades  ORDER BY unidad ";   
                      $datos=mysqli_query($mysqli,$consulta);
                      echo ' <select id="unidadNeg" name="unidadNeg" class="form-control " > 
                               <option  selected="selected" value=""> Seleccionar...</option>';                
                      while($row=mysqli_fetch_row($datos))
                      {                               
                          echo '<option   value="'.$row[1].'">'.$row[1].'</option>';       
                      } 
                      echo ' </select> '; 
                      
                    
                  
                  ?>

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
                                            <h3 class="panel-title">Lumens |  Agentes Listado</h3> 
                                        </div> 
                                        <div class="panel-body" style="background-color: #fafafa"> 
                                                <div class="single-bottom row" >
                                                        <div id="Listado" class="single-bottom row" style=""></div>  
                                                </div>
                                        </div>
                                    </div>

                             </p> 
                    </div> 

                    <div role="tabpanel" class="tab-pane fade" id="Zonas" aria-labelledby="Zonas-tab"> 
                            <p>

                                    <div class="panel panel-primary"> 
                                        <div class="panel-heading"  style="background-color: #222D32 !important"> 
                                            <h3 class="panel-title">Lumens | Zonas Masivas</h3> 
                                        </div> 
                                        <div class="panel-body" style="background-color: #fafafa"> 
                                                <div class="single-bottom row" >
                                                           <div class="col-md-3 col-md-offset-3" >
                          <p><i class="fa fa-user-o"></i> Base De Datos</p>
                          <input id="Base" type="file" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" name="Base" class="form-control" />
                           </div>
   <div class="col-md-6 ">  <br>                     
                        <button id="btnzonas" type="button" class="btn btn-success" onclick="ActualizarZonas();" data-loading-text="<div class='loader'></div> Cargando, Espere...">Cargar Datos</button>                     
                      <a href="Archivos/Instructivos/ActualizarZonas.xlsx" target="_blank">  <button id="btng" type="button" class="btn btn-info" data-loading-text="<div class='loader'></div> Cargando, Espere...">Descargar Instructivo</button></a>

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