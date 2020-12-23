<?php

    session_start();
    if( $_SESSION['LMNS-USER_TIPO']=="Cliente"){

	require_once("back/Conexion.php");
	  $consulta="SELECT  cons FROM clientes  WHERE  
	  usuario='".mysqli_real_escape_string($mysqli,$_SESSION['LMNS-USER_USUARIOC'])."' ";
		$datos=mysqli_query($mysqli,$consulta);
		if($row=mysqli_fetch_row($datos)){ 
			$_SESSION['LMNS-USER_CLIENTE']=$row[0];
		        header("Location: Core/HomeClient.php"); 
		}

    }else{
        header("Location: Core/Home.php"); 
    }
    
?>
