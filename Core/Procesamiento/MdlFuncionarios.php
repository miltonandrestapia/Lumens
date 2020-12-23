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

$consulta2=" SELECT  nombre FROM funcionarios WHERE 
usuario='".mysqli_real_escape_string($mysqli,$_POST["Usuario"])."' "; 
 $datos2=mysqli_query($mysqli,$consulta2);
  if(mysqli_num_rows($datos2)>0){
    echo 'Este Usuario ya fue ingresado';          
  }else{

 $consulta=" INSERT funcionarios (nombre,usuario,telefono,correo,observaciones,Departamento) VALUE ('".
mysqli_real_escape_string($mysqli,strtoupper($_POST["Nombre"]))."','".
mysqli_real_escape_string($mysqli,$_POST["Usuario"])."','".
mysqli_real_escape_string($mysqli,strtoupper($_POST["Telefono"]))."','".
mysqli_real_escape_string($mysqli,strtoupper($_POST["Correo"]))."','".
//mysqli_real_escape_string($mysqli,$_POST["Empresa"])."','".
mysqli_real_escape_string($mysqli,$_POST["Observaciones"])."' , '" . 
mysqli_real_escape_string($mysqli,$_POST["Departamento"])."' ) ";    

          if( $datos=mysqli_query($mysqli,$consulta) ){

     $consulta=" INSERT usuarios (usuario,nombre,pass,estado,tipo) VALUE 
    ('".mysqli_real_escape_string($mysqli,$_POST["Usuario"])."',
    '".mysqli_real_escape_string($mysqli,strtoupper($_POST["Nombre"]))."',
    '".mysqli_real_escape_string($mysqli,$_POST["Pass"])."',
    '".mysqli_real_escape_string($mysqli,$_POST["Estado"])."','Funcionario') ";
       
       //  '".mysqli_real_escape_string($mysqli,$_POST["Empresa"])."')"; 
    $datos=mysqli_query($mysqli,$consulta);
            echo 'OK';
          }else{
            echo 'No se ha podido Ingresar el Funcionario';
          }
 }

}

function Actualizar($mysqli){


          $consulta=" UPDATE funcionarios SET 
          nombre='".mysqli_real_escape_string($mysqli,strtoupper($_POST["Nombre"]))."',
          usuario='".mysqli_real_escape_string($mysqli,$_POST["Usuario"])."',
          telefono='".mysqli_real_escape_string($mysqli,strtoupper($_POST["Telefono"]))."',
          correo='".mysqli_real_escape_string($mysqli,strtoupper($_POST["Correo"]))."',
          observaciones='".mysqli_real_escape_string($mysqli,$_POST["Observaciones"])."' ,
          Departamento='".mysqli_real_escape_string($mysqli,$_POST["Departamento"])."' 
          
          WHERE cons='".mysqli_real_escape_string($mysqli,$_POST["codigoc"])."' "; 

//codempresa='".mysqli_real_escape_string($mysqli,$_POST["Empresa"])."' 
if( $datos=mysqli_query($mysqli,$consulta)){

  $consultax=" UPDATE usuarios SET 
  pass='".mysqli_real_escape_string($mysqli,$_POST["Pass"])."' ,
  estado='".mysqli_real_escape_string($mysqli,$_POST["Estado"])."' ,
  nombre='".mysqli_real_escape_string($mysqli,strtoupper($_POST["Nombre"]))."' 
  WHERE usuario='".mysqli_real_escape_string($mysqli,$_POST["Usuario"])."' ";  
  $datosx=mysqli_query($mysqli,$consultax);

            echo 'OK';
          }else{
            echo 'No se ha podido Actualizar el Funcionario';
          }
 
}
  //f.codempresa
function buscar($mysqli){
  $consulta=" SELECT   f.nombre,f.usuario,pass,telefono,correo,u.estado,Departamento,observaciones,f.cons FROM funcionarios f 
 INNER JOIN usuarios u ON f.usuario=u.usuario WHERE 
  f.cons='".mysqli_real_escape_string($mysqli,$_POST["Buscar_Datos"])."' "; 

  $datos=mysqli_query($mysqli,$consulta);
  if(mysqli_num_rows($datos)>0){
  $row=mysqli_fetch_row($datos);

          echo 's§'.$row[0].'§'.$row[1].'§'.$row[2].'§'.$row[3].'§'.$row[4].'§'.$row[5].'§'.$row[6].'§'.$row[7].'§'.$row[8].'§'.$row[9]; 
            
  }else{
          echo 'No se encontro resultado';
  }

}

function Listar($mysqli){


  if ($_POST["Listado_UniNeg"] == "" && !empty($_POST["Listado_dpto"]) ) 
  {
  /*
              $consulta=" SELECT  f.cons,f.nombre,u.usuario,f.telefono,f.correo,u.estado,e.nombre,f.Departamento 
              FROM ((funcionarios f inner join empresas e on f.codempresa=e.cons)inner join usuarios u on u.usuario=f.usuario)  
              ORDER BY e.nombre,f.nombre  "; */
      $consulta = " SELECT  f.cons,f.nombre,u.usuario,f.telefono,f.correo,u.estado,f.Departamento 
                    FROM funcionarios f INNER JOIN usuarios u ON  f.usuario=u.usuario 
                    WHERE Departamento ='".mysqli_real_escape_string($mysqli, $_POST["Listado_dpto"])."'
                    ORDER BY f.nombre ";
 }

else if ( !empty($_POST["Listado_dpto"]) && !empty($_POST["Listado_UniNeg"])  ) 
{
/*  
              $consulta=" SELECT  f.cons,f.nombre,u.usuario,f.telefono,f.correo,u.estado,e.nombre 
              FROM ((funcionarios f inner join empresas e on f.codempresa=e.cons)inner join usuarios u on u.usuario=f.usuario) 
              where  e.cons='".mysqli_real_escape_string($mysqli,$_POST["Listar"])."'  ORDER BY e.nombre,f.nombre  "; 
              */
              $consulta = " SELECT  f.cons,f.nombre,u.usuario,f.telefono,f.correo,u.estado,f.Departamento  
              FROM funcionarios f INNER JOIN usuarios u ON f.usuario=u.usuario 
              WHERE Departamento ='".mysqli_real_escape_string($mysqli, $_POST["Listado_dpto"])."'
              ORDER BY f.nombre ";   
}

else 
{
  $consulta = " SELECT  f.cons,f.nombre,u.usuario,f.telefono,f.correo,u.estado,f.Departamento 
  FROM funcionarios f INNER JOIN usuarios u ON  f.usuario=u.usuario
  ORDER BY f.nombre  ";  

}


$datos=mysqli_query($mysqli,$consulta);

          $tabla='<table id="example" class="display dataTable" cellspacing="0" width="100%" style="font-size: 12px; width: 100%;" role="grid" aria-describedby="example_info">
        <thead>
          <tr>
          
          <th >Funcionario</th>
          <th >Usuario</th>
          <th >Telefono</th>
          <th >Correo</th>
          <th >Estado</th>
          <th >Departamento</th>
          <th ></th></tr></tr>
        </thead><tfoot>
          <tr> 
       
          <th >Funcionario</th>
          <th >Usuario</th>
          <th >Telefono</th>
          <th >Correo</th>
          <th >Estado</th>
          <th >Departamento</th>
          <th ></th></tr>
        </tfoot>  <tbody> ';

       
          if(mysqli_num_rows($datos)>0){            
while($row=mysqli_fetch_row($datos)){ 

              if($row[5]=='Inactivo'){
                $st='style="background-color:#FFBABA; color:#D8000C;"';
              }else{
                $st='style="background-color:#B3FFBA; color:#33D100;"';
              }

              $tabla.='<tr role="row" class="odd">
          
            <td class="sobretd" id="'.$row[0].'" >'.$row[1].'</td>
            <td class="sobretd" id="'.$row[0].'" >'.$row[2].'</td>
            <td class="sobretd" id="'.$row[0].'" >'.$row[3].'</td>
            <td class="sobretd" id="'.$row[0].'" >'.$row[4].'</td>
            <td class="sobretd" id="'.$row[0].'"  '.$st.' >'.$row[5].'</td>
            <td class="sobretd" id="'.$row[0].'" >'.$row[6].'</td> 
            <td class="sobretd" id="'.$row[0].'" ><button type="button" class="btn btn-success btn-circle" onclick="Buscar_Datos('.$row[0].');"><i class="fa fa-edit"></i></button></td>
          </tr>';
            }
            
          }
//  <td class="sobretd sorting_1" id="'.$row[0].'" >'.$row[6].'</td>
          $tabla.='</tbody></table>';

          echo $tabla;
}

mysqli_close($mysqli);
?>