<?php

    require_once("../Procesamiento/Conexion.php");
	$filename = "ResumenActividadesDe".$_GET["GenerarInicio"]."A".$_GET["GenerarFinal"].".xls"; 
	header("Content-Disposition: attachment; filename=\"$filename\"");
	header("Content-Type: application/vnd.ms-excel; charset=UTF-8");

		echo '<table border="1" width="100%" style="font-size: 12px !important;border-collapse: collapse;">
					<tr>
						<th style="background-color:#e1e1e1">Cons</th>
						<th  style="background-color:#e1e1e1">Codigo</th>
						<th  style="background-color:#e1e1e1">Jornada</th>
						<th  style="background-color:#e1e1e1">Tipo</th>
						<th  style="background-color:#e1e1e1">Soporte</th>
						<th  style="background-color:#e1e1e1">Usuario</th>
						<th  style="background-color:#e1e1e1">Estado</th>
						<th  style="background-color:#e1e1e1">Cantidad</th>
						<th  style="background-color:#e1e1e1">Efectivos</th>
						<th  style="background-color:#e1e1e1">No Efectivos</th>          
						<th  style="background-color:#e1e1e1">Realizados</th>       
						<th  style="background-color:#e1e1e1">Pendientes</th>   
						<th  style="background-color:#e1e1e1">Fecha Creacion</th>
						<th  style="background-color:#e1e1e1">Fecha Anulado</th>         
						<th  style="background-color:#e1e1e1">Observaciones</th>   
					</tr>
				<tbody>';   
				
	$completa="";
if($_GET["GenerarTipoB"]!=""){
$completa="  AND tipo='".mysqli_real_escape_string($mysqli,$_GET["GenerarTipoB"])."' ";
}


if($_GET["GenerarSoporteB"]!=""){
$completa.="  AND soporte='".mysqli_real_escape_string($mysqli,$_GET["GenerarSoporteB"])."' ";
}

if($_GET["GenerarCodcl"]!=""){

  $consulta="SELECT codactividad,fecha,tipo,soporte,usuariocarga,estado,cantidad,efectivos,noefectivos,usuariocarga,fechacreacion,fechaanulado,observaciones 
     FROM actividadclientes WHERE 
     fecha>='".mysqli_real_escape_string($mysqli,$_GET["GenerarInicio"])."' AND 
     fecha<='".mysqli_real_escape_string($mysqli,$_GET["GenerarFinal"])."' AND 
     codempresa='".mysqli_real_escape_string($mysqli,$_GET["GenerarCode"])."' AND 
     codcliente='".mysqli_real_escape_string($mysqli,$_GET["GenerarCodcl"])."' ".$completa." ORDER BY fecha,codactividad  "; 
}else{

  $consulta="SELECT cons,fecha,tipo,soporte,usuariocarga,estado,cantidad,efectivos,noefectivos,usuariocarga,fechacreacion,fechaanulado,observaciones 
     FROM actividad WHERE 
     fecha>='".mysqli_real_escape_string($mysqli,$_GET["GenerarInicio"])."' AND 
     fecha<='".mysqli_real_escape_string($mysqli,$_GET["GenerarFinal"])."' AND 
     codempresa='".mysqli_real_escape_string($mysqli,$_GET["GenerarCode"])."' ".$completa." ORDER BY fecha,cons  "; 
}




$datos=mysqli_query($mysqli,$consulta);	

				$cont=1;         
while($row=mysqli_fetch_row($datos)){ 


              
             echo '<tr >
            <td  >'.$cont.'</td>
            <td  >'.$row[0].'</td>
            <td  >'.$row[1].'</td>
            <td  >'.$row[2].'</td>
            <td  >'.$row[3].'</td>
            <td  >'.$row[4].'</td>
            <td  >'.$row[5].'</td>
            <td  >'.$row[6].'</td>
            <td  >'.$row[7].'</td>
            <td  >'.$row[8].'</td>
            <td  >'.($row[8]+$row[7]).'</td>
            <td  >'.($row[6]-($row[8]+$row[7])).'</td>
            <td  >'.$row[10].'</td>
            <td  >'.$row[11].'</td>
            <td  >'.$row[12].'</td>
          </tr>';

$cont++;
			}
	    echo '</tbody></table>';



?>


