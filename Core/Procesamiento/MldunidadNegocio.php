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

$consulta2=" SELECT  unidad FROM unidades WHERE 
unidad='".mysqli_real_escape_string($mysqli,$_POST["unidadN"])."' ";           
 $datos2=mysqli_query($mysqli,$consulta2);
  if(mysqli_num_rows($datos2)>0){
    echo 'Esta unidad ya fue ingresada';   
         
  }else{
    //codempresa
 $consulta=" INSERT unidades(unidad) VALUE ('".
mysqli_real_escape_string($mysqli,strtoupper($_POST["unidadN"]))."'
) ";  

          if( $datos=mysqli_query($mysqli,$consulta) ){
            echo 'OK';
          }else{
            echo 'No se ha podido ingresar la unidad de negocio';
          }
 }

}

function Actualizar($mysqli){


$consulta=" UPDATE unidades SET 
unidad='".mysqli_real_escape_string($mysqli,strtoupper($_POST["unidadN"]))."'
WHERE cons='".mysqli_real_escape_string($mysqli,$_POST["codigoc"])."' "; 
if( $datos=mysqli_query($mysqli,$consulta)){
  echo 'OK';
}else{
  echo 'No se ha podido Actualizar la unidad de negocio';
}
 
}
  

function buscar($mysqli){
  $consulta=" SELECT cons,unidad FROM unidades WHERE 
  cons='".mysqli_real_escape_string($mysqli,$_POST["Buscar_Datos"])."' "; 

  $datos=mysqli_query($mysqli,$consulta);
  if(mysqli_num_rows($datos)>0){
  $row=mysqli_fetch_row($datos); 
  echo 's§'.$row[0].'§'.$row[1].'§'.$row[2];       
            
  }else{  
    echo 'No se encontro resultado'; 
  }

}

function Listar($mysqli){  
//if($_POST["Listar"]=="OK")

if ($_POST["Listado_dpto"] == "" && !empty($_POST["Listado_UniNeg"]) ) 
{
  $consulta = " SELECT cons, unidad FROM unidades 
  WHERE unidad ='".mysqli_real_escape_string($mysqli, $_POST["Listado_UniNeg"])."'
  ORDER BY unidad   ";  
}

else if ( !empty($_POST["Listado_dpto"]) && !empty($_POST["Listado_UniNeg"])  ) 
{
  
  $consulta = " SELECT cons, unidad FROM unidades 
  WHERE unidad ='".mysqli_real_escape_string($mysqli, $_POST["Listado_UniNeg"])."'
  ORDER BY unidad   ";  

}
else 
{
        /*  $consulta=" SELECT z.cons,z.codigo,e.nombre,z.nombre, z.Departamento FROM zonas z inner join empresas e on e.cons=z.codempresa
          ORDER BY e.nombre  ";     */
          $consulta = " SELECT cons, unidad FROM unidades   ORDER BY unidad ";   
 /*}else{
  
     $consulta=" SELECT z.cons,z.codigo,e.nombre,z.nombre, z.Departamento FROM zonas z inner join empresas e on e.cons=z.codempresa
     where  z.codempresa='".mysqli_real_escape_string($mysqli,$_POST["Listar"])."' ORDER BY e.nombre ";     
  */
  
}
  
$datos=mysqli_query($mysqli,$consulta);
// <th >Empresa</th>
          $tabla='<table id="example" class="display dataTable" cellspacing="0" width="100%" style="font-size: 12px; width: 100%;" role="grid" aria-describedby="example_info">
        <thead>
          <tr>
          
          <th>ID</th>
          <th>Unidad</th>
          <th ></th></tr></tr>
        </thead><tfoot>
          <tr>
         
          <th>ID</th>
          <th>Unidad</th> 
          <th></th></tr>
        </tfoot>  <tbody> ';


          if(mysqli_num_rows($datos)>0){            
while($row=mysqli_fetch_row($datos)){ 
  
              $tabla.='<tr >
            
            <td class="sobretd" id="'.$row[0].'" >'.$row[0].'</td>
            <td class="sobretd" id="'.$row[0].'" >'.$row[1].'</td>
            <td class="sobretd" id="'.$row[0].'" ><button type="button" class="btn btn-success btn-circle" onclick="Buscar_Datos('.$row[0].');"><i class="fa fa-edit"></i></button></td>
          </tr>';
            }
              
          }  

          $tabla.='</tbody></table>';

          echo $tabla;
}//<td class="sobretd" id="'.$row[0].'" >'.$row[2].'</td>

mysqli_close($mysqli);
?>