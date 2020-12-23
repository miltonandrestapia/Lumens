<?php 

require_once("Conexion.php");
  if($_POST["Action"]=='OK' AND isset($_POST["usuario"])){
					logearse($mysqli);							
	}
											
function logearse($mysqli){

   $consulta="SELECT  nombre,usuario,tipo FROM usuarios 
  WHERE  usuario='".mysqli_real_escape_string($mysqli,$_POST["usuario"])."' 
  AND pass='".mysqli_real_escape_string($mysqli,$_POST["pass"])."' AND estado='Activo' AND NOT tipo='Agente' "; 

$datos=mysqli_query($mysqli,$consulta);

if($row=mysqli_fetch_row($datos)){ 

                 session_start();
                 if( $row[2]=="Cliente"){
                   $_SESSION['LMNS-USER_NOMBREC']=$row[0];
                   $_SESSION['LMNS-USER_USUARIOC']=$row[1];
                   $_SESSION['LMNS-USER_TIPO']=$row[2];

                      $consulta="SELECT  unidad_negocio FROM clientes  WHERE  usuario='".$row[1]."' "; 
                      $datos=mysqli_query($mysqli,$consulta);
                      if($row=mysqli_fetch_row($datos)){ 
                         $_SESSION['LMNS_unidad']=$row[0];
                      }
                }else{
                   $_SESSION['LMNS-USER_NOMBRE']=$row[0];
                   $_SESSION['LMNS-USER_USUARIO']=$row[1];
                   $_SESSION['LMNS-USER_TIPO']=$row[2];
                }

            echo 'OK';
          }else{
            echo 'Usuario o Contraseña invalido';
          }
}

?>