<?php


if($_GET['action']=='Proceso_Carga'){

		$cantidad=$_GET['Cantidad'];
		$nombre=$_GET['archivo'];

	require_once("Procesamiento/Conexion.php");

	if ($_GET['Proyecto']=="Generico") {
		$consulta="SELECT COUNT(*) from principal where	archivocarga='".mysqli_real_escape_string($mysqli,$nombre)."' ";
	}else{
		$consulta="SELECT COUNT(*) from proyectoespecialenel where	archivocarga='".mysqli_real_escape_string($mysqli,$nombre)."' ";
	}


 $datos=mysqli_query($mysqli,$consulta);
  if(mysqli_num_rows($datos)>0){

  $row=mysqli_fetch_row($datos);


		if($row[0]==0){

			$classl='loaderleyendo';
			$classt='texto';
			$load='Cargando, Leyendo Archivo ...';
			$self = $_SERVER['PHP_SELF'];
			$self = $self."?action=".$_GET["action"]."&archivo=".$_GET["archivo"]."&Cantidad=".$_GET['Cantidad']."&Proyecto=".$_GET['Proyecto'];
			header("refresh:1; url=$self"); 

		}else{

			if($row[0]>=$cantidad){
					echo "<script type='text/javascript'>window.close();</script>";
			}else{
				$classl='loaderguardando';
				$classt='textoguardando';
				$load='Se validaron '.$row[0].' Registros de '.$cantidad.' ';
				$self = $_SERVER['PHP_SELF'];
				$self = $self."?action=".$_GET["action"]."&archivo=".$_GET["archivo"]."&Cantidad=".$_GET['Cantidad']."&Proyecto=".$_GET['Proyecto'];
				header("refresh:1; url=$self"); 
			}
		}
	}

}



?>
<!DOCTYPE html>
<html>
<head>
	<title>Cargando archivo ...</title>
	<style>
.loaderleyendo {
  border: 20px solid #f3f3f3;
  border-radius: 50%;
  border-left: 20px solid #33267F;
  border-top: 20px solid #A898FF;
  border-right: 20px solid #544C7F;
  border-bottom: 20px solid #674CFF;
  width: 60px;
  height: 60px;
  -webkit-animation: spin 2s linear infinite;
  animation: spin 2s linear infinite;
}

.loaderguardando {
  border: 20px solid #f3f3f3;
  border-radius: 50%;
  border-left: 20px solid #207F27;
  border-top: 20px solid #8CFF95;
  border-right: 20px solid #40FF4F;
  border-bottom: 20px solid #33CC3F;
  width: 60px;
  height: 60px;
  -webkit-animation: spin 2s linear infinite;
  animation: spin 2s linear infinite;
}

@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

.texto{
	font-size: 30px;
	font-weight: bold;
	color: #33267F;
}
.textoguardando{
	font-size: 30px;
	font-weight: bold;
	color: #467F4B;
}
</style>
</head>
<body style="width: 97% !important;background-color: #f2f2f2">



	<div  class="" >
		
<table style="margin: auto;">
	<tr>
		<td><div class="<?php echo $classl; ?>"></div> 
		</td>
		<td><div class="<?php echo $classt; ?>"><?php echo $load; ?></div>
		</td>
	</tr>
</table>

 

	</div>
</body>
</html>
