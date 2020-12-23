<?php
error_reporting(E_ERROR | E_PARSE);
require_once("Conexion.php");

  if( isset($_POST["Ingresar"]) ){
		Ingresar($mysqli);							
	}else if(isset($_POST["Listar"])){
    Listar($mysqli);
  }else if(isset($_POST["Buscar_Datos"])){
    buscar($mysqli);
  }else if(isset($_POST["Actualizar"])){
    Actualizar($mysqli);
  }
			

function Ingresar($mysqli){

$consulta2=" SELECT  nombre FROM zonas WHERE 
codigo='".mysqli_real_escape_string($mysqli,$_POST["Codigo"])."' "; 
 $datos2=mysqli_query($mysqli,$consulta2);
  if(mysqli_num_rows($datos2)>0){
    echo 'Zona ya fue ingresada';          
  }else{
    //codempresa
 $consulta=" INSERT zonas(nombre,codigo,poligono,Departamento,unidad_negocio,Velocidad,email) VALUE ('".
mysqli_real_escape_string($mysqli,strtoupper($_POST["Zona"]))."','".
mysqli_real_escape_string($mysqli,$_POST["Codigo"])."','".
//mysqli_real_escape_string($mysqli,strtoupper($_POST["Empresa"]))."','".
mysqli_real_escape_string($mysqli,($_POST["Observaciones"]))."' ,'".
mysqli_real_escape_string($mysqli,($_POST["Departamento"]))."'  , '".
mysqli_real_escape_string($mysqli,($_POST["unidadNeg"]))."', '".
mysqli_real_escape_string($mysqli,($_POST["Velocidad"]))."' , '".
mysqli_real_escape_string($mysqli,($_POST["email"]))."'
) ";  

          if( $datos=mysqli_query($mysqli,$consulta) ){
            echo 'OK';
          }else{
            echo 'No se ha podido ingresar la zona';
          }
 }

}

function Actualizar($mysqli){


$consulta=" UPDATE zonas SET 
nombre='".mysqli_real_escape_string($mysqli,strtoupper($_POST["Zona"]))."',
codigo='".mysqli_real_escape_string($mysqli,$_POST["Codigo"])."',
poligono='".mysqli_real_escape_string($mysqli,$_POST["Observaciones"])."' ,
Departamento='".mysqli_real_escape_string($mysqli,$_POST["Departamento"])."' ,  
unidad_negocio='".mysqli_real_escape_string($mysqli,$_POST["unidadNeg"])."'  ,  
Velocidad='".mysqli_real_escape_string($mysqli,$_POST["Velocidad"])."' , 
email='".mysqli_real_escape_string($mysqli,$_POST["email"])."'
WHERE cons='".mysqli_real_escape_string($mysqli,$_POST["codigoc"])."' "; 
if( $datos=mysqli_query($mysqli,$consulta)){
  echo 'OK';
}else{
  echo 'No se ha podido Actualizar la zona';
}
 
}
//codempresa='".mysqli_real_escape_string($mysqli,$_POST["Empresa"])."' 

function buscar($mysqli){
  $consulta=" SELECT cons,nombre,codigo,Departamento,poligono,unidad_negocio,Velocidad,email FROM zonas WHERE 
  cons='".mysqli_real_escape_string($mysqli,$_POST["Buscar_Datos"])."' "; 

  $datos=mysqli_query($mysqli,$consulta);
  if(mysqli_num_rows($datos)>0){
  $row=mysqli_fetch_row($datos); 
  echo 's§'.$row[0].'§'.$row[1].'§'.$row[2].'§'.$row[3].'§'.$row[4].'§'.$row[5].'§'.$row[6].'§'.$row[7];     
            
  }else{
    echo 'No se encontro resultado'; 
  }

}

function Listar($mysqli){  
//if($_POST["Listar"]=="OK")

if($_POST["Listado_dpto"] =="" && $_POST["Listado_UniNeg"] == "")
{
        /*  $consulta=" SELECT z.cons,z.codigo,e.nombre,z.nombre, z.Departamento FROM zonas z inner join empresas e on e.cons=z.codempresa
          ORDER BY e.nombre  ";     */
          $consulta = " SELECT cons, codigo, nombre, Departamento, unidad_negocio FROM zonas   ";  
 /*}else{
  
     $consulta=" SELECT z.cons,z.codigo,e.nombre,z.nombre, z.Departamento FROM zonas z inner join empresas e on e.cons=z.codempresa
     where  z.codempresa='".mysqli_real_escape_string($mysqli,$_POST["Listar"])."' ORDER BY e.nombre ";     
  */
  
}

else if ( !empty($_POST["Listado_dpto"]) && $_POST["Listado_UniNeg"] == "") 
{
  $consulta = " SELECT cons, codigo, nombre, Departamento, unidad_negocio,Velocidad FROM zonas 
   WHERE Departamento ='".mysqli_real_escape_string($mysqli, $_POST["Listado_dpto"])."'   ";  
}

else if ( $_POST["Listado_dpto"] == ""  &&  !empty($_POST["Listado_UniNeg"]) ) 
{
  $consulta = " SELECT cons, codigo, nombre, Departamento, unidad_negocio,Velocidad FROM zonas 
   WHERE unidad_negocio ='".mysqli_real_escape_string($mysqli, $_POST["Listado_UniNeg"])."'   ";  
}
  
else if ( !empty($_POST["Listado_dpto"]) && !empty($_POST["Listado_UniNeg"])  ) 
{
  $consulta = " SELECT cons, codigo, nombre, Departamento, unidad_negocio,Velocidad FROM zonas 
  WHERE  Departamento ='".mysqli_real_escape_string($mysqli, $_POST["Listado_dpto"])."' 
  AND   unidad_negocio ='".mysqli_real_escape_string($mysqli, $_POST["Listado_UniNeg"])."'   ";   
}


$datos=mysqli_query($mysqli,$consulta);
// <th >Empresa</th>
          $tabla='<table id="example" class="display dataTable" cellspacing="0" width="100%" style="font-size: 12px; width: 100%;" role="grid" aria-describedby="example_info">
        <thead>
          <tr>
          
          <th >Código</th>
          <th >Nombre</th>
          <th >Departamento</th>
          <th >Unidad</th>
          <th >Velocidad Max.</th>
          <th ></th></tr></tr>
        </thead><tfoot>
          <tr>
         
          <th>Código</th>
          <th>Nombre</th> 
          <th >Departamento</th>
          <th >Unidad</th>
          <th >Velocidad Max.</th>
          <th></th></tr>
        </tfoot>  <tbody> ';


          if(mysqli_num_rows($datos)>0){            
while($row=mysqli_fetch_row($datos)){ 
  
              $tabla.='<tr >
            
            <td class="sobretd" id="'.$row[0].'" >'.$row[1].'</td>
            <td class="sobretd" id="'.$row[0].'" >'.$row[2].'</td>
            <td class="sobretd" id="'.$row[0].'" >'.$row[3].'</td>  
            <td class="sobretd" id="'.$row[0].'" >'.$row[4].'</td>
            <td class="sobretd" id="'.$row[0].'" >'.$row[5].' Km/h</td>
            <td class="sobretd" id="'.$row[0].'" ><button type="button" class="btn btn-success btn-circle" onclick="Buscar_Datos('.$row[0].');"><i class="fa fa-edit"></i></button></td>
          </tr>';
            }
              
          }  

          $tabla.='</tbody></table>';

          echo $tabla;
}//<td class="sobretd" id="'.$row[0].'" >'.$row[2].'</td>

mysqli_close($mysqli);
?>