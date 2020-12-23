<?php
	require_once("back/Conexion.php");

	if(@session_start()==false){
		session_destroy();
		session_start();
		}


		$usuario= base64_decode($_GET["usuario"]);
		$nombre=base64_decode($_GET["enombre"]);
		$dpto=base64_decode($_GET["departamento"]);

		$sw1=0;
		$sw2=0;


	$consulta="SELECT  nombre,usuario,tipo FROM usuarios 
	WHERE  usuario='".mysqli_real_escape_string($mysqli,$usuario)."' 
	AND nombre='".mysqli_real_escape_string($mysqli,$nombre)."' AND estado='Activo' ";
	$datos=mysqli_query($mysqli,$consulta);
	if($row=mysqli_fetch_row($datos)){ 

		$sw1=1;
		$sw2=1;

	}else{


$consultaF = " INSERT funcionarios(nombre,usuario,Departamento) 
VALUES('".mysqli_real_escape_string($mysqli,$nombre)."',
'".mysqli_real_escape_string($mysqli,$usuario)."',
'".mysqli_real_escape_string($mysqli,$dpto)."' ) ";
$datosF = mysqli_query($mysqli,$consultaF);
if($datosF){    
//echo 'F OK';
$sw1=1;
} 


//--------------------------------------------------------------------

$consultaU = " INSERT INTO usuarios(usuario,nombre,tipo,estado) 
VALUES('".mysqli_real_escape_string($mysqli,$usuario)."',
'".mysqli_real_escape_string($mysqli,$nombre)."', 
'Funcionario',  
'Activo' ) ";
$datosU=mysqli_query($mysqli,$consultaU);

if($datosU){    
	//echo 'U OK'; 
	$sw2=1;
	}
	
}

if ($sw1==1 && $sw2==1){
	$consulta="SELECT  nombre,usuario,tipo FROM usuarios 
	WHERE  usuario='".mysqli_real_escape_string($mysqli,$usuario)."' 
	AND nombre='".mysqli_real_escape_string($mysqli,$nombre)."' AND estado='Activo' ";
	$datos=mysqli_query($mysqli,$consulta);
	if($row=mysqli_fetch_row($datos)){ 
  
	  $_SESSION['LMNS-USER_NOMBRE']=$row[0];
	  $_SESSION['LMNS-USER_USUARIO']=$row[1];  
	  $_SESSION['LMNS-USER_TIPO']=$row[2];
	   header("Location: Core/Home.php");    
	}
  


}else { echo "Error en la transferencia de datos";} 



			

		
?>