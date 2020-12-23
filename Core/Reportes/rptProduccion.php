<?php

    require_once("../Procesamiento/Conexion.php");
	$filename = "Produccion_".$_GET["Desde"]."_".$_GET["Hasta"].".xls"; 
	header("Content-Disposition: attachment; filename=\"$filename\"");
	header("Content-Type: application/vnd.ms-excel; charset=UTF-8");

		echo '<table border="1" width="100%" style="font-size: 12px !important;border-collapse: collapse;">
					<tr>
						<th style="background-color:#e1e1e1">Cons</th>
						<th style="background-color:#e1e1e1">Cliente</th>
						<th style="background-color:#e1e1e1">Fecha</th>
						<th style="background-color:#e1e1e1">Cantidad</th>
						<th style="background-color:#e1e1e1">Efectivos</th>
						<th style="background-color:#e1e1e1">No Efectivos</th>
						<th style="background-color:#e1e1e1">Realizados</th>
						<th style="background-color:#e1e1e1">Pendientes</th>
						<th style="background-color:#e1e1e1">% Efectividad</th>
					</tr>
				<tbody>'; 
$completa="";
if($_GET["tipo"]!=""){
	$completa=" AND ac.tipo='".mysqli_real_escape_string($mysqli,$_GET["tipo"])."' ";
}

if($_GET["Reporte"]=="Produccion"){

	$consulta="SELECT p.cliente,ac.fecha,
			SUM(CASE WHEN p.estado ='Pendiente' THEN 1 ELSE 0 END),
			SUM(CASE WHEN p.respuesta ='Efectiva' THEN 1 ELSE 0 END),
			SUM(CASE WHEN p.estado ='No Efectiva' THEN 1 ELSE 0 END) 
			FROM principal p INNER JOIN actividad ac ON ac.cons=p.codactividad  WHERE 
			ac.fecha>='".mysqli_real_escape_string($mysqli,$_GET["Desde"])."' AND
			ac.fecha<='".mysqli_real_escape_string($mysqli,$_GET["Hasta"])."'
			AND ac.codempresa='".mysqli_real_escape_string($mysqli,$_GET["Code"])."'
			".$completa." group by p.cliente,ac.fecha ";
}else{
	$consulta="SELECT a.nombre,ac.fecha,
			SUM(CASE WHEN p.estado ='Pendiente' THEN 1 ELSE 0 END),
			SUM(CASE WHEN p.respuesta ='Efectiva' THEN 1 ELSE 0 END),
			SUM(CASE WHEN p.estado ='No Efectiva' THEN 1 ELSE 0 END) 
			FROM ((principal p INNER JOIN actividad ac ON ac.cons=p.codactividad)
			INNER JOIN agentes a ON a.usuario=p.codagente)  WHERE 
			ac.fecha>='".mysqli_real_escape_string($mysqli,$_GET["Desde"])."' AND
			ac.fecha<='".mysqli_real_escape_string($mysqli,$_GET["Hasta"])."'
			AND ac.codempresa='".mysqli_real_escape_string($mysqli,$_GET["Code"])."'
			".$completa." group by a.nombre,ac.fecha ";
}

$cont=1;    
$datos=mysqli_query($mysqli,$consulta);	
     
while($row=mysqli_fetch_row($datos)){ 
	$cantidad=0;
	$cantidad=$row[2]+$row[3]+$row[4];
	$pendientes=$row[2];
	$efectivos=$row[3];
	$noefectivos=$row[4];
	$finalizados=$row[3]+$row[4];

                      echo '<tr >
		            <td  >'.$cont.'</td>
		            <td  >'.$row[0].'</td>
		            <td  >'.$row[1].'</td>
		            <td  >'.$cantidad.'</td>
		            <td  >'.$efectivos.'</td>
		            <td  >'.$noefectivos.'</td>
		            <td  >'.$finalizados.'</td>
		            <td  >'.$pendientes.'</td>	
		            <td  >'.round(($finalizados/$cantidad*100),1).'%</td>
		            </tr>
		             ';
				$cont++;
			}
	    echo '</tbody></table>';



?>


