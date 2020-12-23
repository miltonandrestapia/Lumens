<?php
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

$consulta2=" SELECT  cons FROM empresas WHERE nit='".mysqli_real_escape_string($mysqli,$_POST["nit"])."' "; 

 $datos2=mysqli_query($mysqli,$consulta2);

  if(mysqli_num_rows($datos2)>0){

    echo 'Este Numero de Nit ya fue ingresado';
          
  }else{

$consulta2=" SELECT nombre FROM usuarios WHERE usuario='".mysqli_real_escape_string($mysqli,$_POST["Usuario"])."' "; 

 $datos2=mysqli_query($mysqli,$consulta2);

  if(mysqli_num_rows($datos2)>0){

    echo 'Este Usuario ya fue ingresado';
          
  }else{

    $consulta=" INSERT empresas (nombre,nit,fechalicencia,contacto,telefono,correo,estado,observaciones,fecha) VALUE 
    ('".mysqli_real_escape_string($mysqli,strtoupper($_POST["nombre"]))."',
    '".mysqli_real_escape_string($mysqli,strtoupper($_POST["nit"]))."',
    '".mysqli_real_escape_string($mysqli,$_POST["fechai"])."',
    '".mysqli_real_escape_string($mysqli,strtoupper($_POST["Contacto"]))."',
    '".mysqli_real_escape_string($mysqli,strtoupper($_POST["Telefono"]))."',
    '".mysqli_real_escape_string($mysqli,strtoupper($_POST["correo"]))."',
    '".mysqli_real_escape_string($mysqli,$_POST["estado"])."',
    '".mysqli_real_escape_string($mysqli,strtoupper($_POST["observaciones"]))."',curdate())";          
          if( $datos=mysqli_query($mysqli,$consulta) ){

 $consultax=" SELECT  cons FROM empresas WHERE nit='".mysqli_real_escape_string($mysqli,$_POST["nit"])."' "; 
  $datosx=mysqli_query($mysqli,$consultax);
  $rowx=mysqli_fetch_row($datosx);

    $consulta=" INSERT usuarios (usuario,nombre,pass,estado,tipo,codempresa) VALUE 
    ('".mysqli_real_escape_string($mysqli,$_POST["Usuario"])."',
    '".mysqli_real_escape_string($mysqli,strtoupper($_POST["nombre"]))."',
    '".mysqli_real_escape_string($mysqli,$_POST["Pass"])."',
    '".mysqli_real_escape_string($mysqli,$_POST["estado"])."','Empresa',
    '".mysqli_real_escape_string($mysqli,$rowx[0])."')";          
          $datos=mysqli_query($mysqli,$consulta);


            echo 'OK';
          }else{
            echo 'No se ha podido ingresar la empresa';
          }

        }
  }

}

function Actualizar($mysqli){
  $consulta=" UPDATE empresas SET 
  nombre='".mysqli_real_escape_string($mysqli,strtoupper($_POST["nombre"]))."', 
  nit='".mysqli_real_escape_string($mysqli,strtoupper($_POST["nit"]))."',
  fecha='".mysqli_real_escape_string($mysqli,$_POST["fechai"])."',
  contacto='".mysqli_real_escape_string($mysqli,strtoupper($_POST["Contacto"]))."',
  telefono='".mysqli_real_escape_string($mysqli,strtoupper($_POST["Telefono"]))."',
  correo='".mysqli_real_escape_string($mysqli,strtoupper($_POST["correo"]))."',
  estado='".mysqli_real_escape_string($mysqli,$_POST["estado"])."',
  observaciones='".mysqli_real_escape_string($mysqli,strtoupper($_POST["observaciones"]))."' 
  WHERE cons='".mysqli_real_escape_string($mysqli,$_POST["codigoc"])."' ";   
  if( $datos=mysqli_query($mysqli,$consulta)){

       $consultax=" UPDATE usuarios SET 
  pass='".mysqli_real_escape_string($mysqli,$_POST["Pass"])."' ,
  estado='".mysqli_real_escape_string($mysqli,$_POST["estado"])."' ,
  nombre='".mysqli_real_escape_string($mysqli,strtoupper($_POST["nombre"]))."' 
  WHERE usuario='".mysqli_real_escape_string($mysqli,$_POST["Usuario"])."' ";  
  $datosx=mysqli_query($mysqli,$consultax);

    echo 'OK';
  }else{
    echo 'No se ha podido actualizar la empresa';
  }
}

function buscar($mysqli){

  $consulta=" SELECT  nombre,nit,fechalicencia,contacto,telefono,correo,estado,observaciones,cons FROM empresas WHERE cons='".mysqli_real_escape_string($mysqli,$_POST["Buscar_Datos"])."' "; 
  $datos=mysqli_query($mysqli,$consulta);
  if(mysqli_num_rows($datos)>0){
  $row=mysqli_fetch_row($datos);

    echo 's§'.$row[0].'§'.$row[1].'§'.$row[2].'§'.$row[3].'§'.$row[4].'§'.$row[5].'§'.$row[6].'§'.$row[7].'§'.$row[8];
    $consultax=" SELECT  usuario,pass FROM usuarios WHERE 
    codempresa='".mysqli_real_escape_string($mysqli,$_POST["Buscar_Datos"])."' and tipo='Empresa' and estado='Activo' "; 
    $datosx=mysqli_query($mysqli,$consultax);
    $rowx=mysqli_fetch_row($datosx);
    echo '§'.$rowx[0].'§'.$rowx[1];  

  }else{
    echo 'No se encontro resultado';
  }

}

function Listar($mysqli){
          $consulta=" SELECT  cons,nombre,nit,fechalicencia,contacto,telefono,correo,estado FROM empresas ORDER BY nombre  "; 
         
$datos=mysqli_query($mysqli,$consulta);

          $tabla='<table id="example" class="display dataTable" cellspacing="0" width="100%" style="font-size: 12px; width: 100%;" role="grid" aria-describedby="example_info">
        <thead>
          <tr>
           <th >cons</th>
           <th >Codigo</th>
          <th >Nombre</th>
          <th >Nit</th>
          <th >Contacto</th>
          <th >Telefono</th>
          <th >Direccion</th>
          <th >Estado</th>
          <th >Fecha Fin.</th></th>
          <th ></th></tr>
        </thead>
        <tfoot>
          <tr>
           <th >cons</th>
          <th >Codigo</th>
          <th >Nombre</th>
          <th >Nit</th>
          <th >Contacto</th>
          <th >Telefono</th>
          <th >Direccion</th>
          <th >Estado</th>
          <th >Fecha Fin.</th></th>
          <th ></th>
          </tr>
        </tfoot>  <tbody> ';

          if(mysqli_num_rows($datos)>0){
$cont=1;
           
while($row=mysqli_fetch_row($datos)){ 

              if($row[7]=='Inactivo'){
                $st='style="background-color:#FFBABA; color:#D8000C;"';
              }else{
                $st='style="background-color:#B3FFBA; color:#33D100;"';
              }

              $tabla.='<tr>
            <td class="sobretd"  >'.$cont.'</td>
            <td class="sobretd"  >'.$row[0].'</td>
            <td class="sobretd"  >'.$row[1].'</td>
            <td class="sobretd"  >'.$row[2].'</td>
            <td class="sobretd"  >'.$row[4].'</td>
            <td class="sobretd"  >'.$row[5].'</td>
            <td class="sobretd"  >'.$row[6].'</td>
            <td class="sobretd"   '.$st.' >'.$row[7].'</td>
            <td class="sobretd"  >'.$row[3].'</td>
            <td class="sobretd"  ><button type="button" class="btn btn-success btn-circle" onclick="Buscar_Datos('.$row[0].');"><i class="fa fa-edit"></i></button></td>
          </tr>';
$cont++;
            }
            
          }

          $tabla.='</tbody></table>';

          echo $tabla;
}

mysqli_close($mysqli);
?>