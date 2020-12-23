<?php

    require_once("../Procesamiento/Conexion.php");
	$filename = "Detalleactividades_".$_GET["Desde"]."_".$_GET["Hasta"].".xls"; 
	header("Content-Disposition: attachment; filename=\"$filename\"");
	header("Content-Type: application/vnd.ms-excel; charset=UTF-8");

		echo '<table border="1" width="100%" style="font-size: 12px !important;border-collapse: collapse;">
					<tr>
						<th style="background-color:#e1e1e1">Cons</th>
						<th  style="background-color:#e1e1e1">Codigo Visita</th>
						<th  style="background-color:#e1e1e1">Codigo Actividad</th>
						<th  style="background-color:#e1e1e1">Fecha Actividad</th>
						<th  style="background-color:#e1e1e1">Tipo Actividad</th>
						<th  style="background-color:#e1e1e1">Tipo Soporte</th>
						<th  style="background-color:#e1e1e1">Usuario Creacion  Actividad </th>
						<th  style="background-color:#e1e1e1">Estado Actividad</th> 
						<th  style="background-color:#e1e1e1">Fecha Creacion  Actividad</th>
						<th  style="background-color:#e1e1e1">Fecha Anulado  Actividad</th>         
						<th  style="background-color:#e1e1e1">Observaciones  Actividad</th> 
						<th style="background-color:#e1e1e1">Destinatario</th>
						<th style="background-color:#e1e1e1">Direccion</th>
						<th style="background-color:#e1e1e1">Ciudad</th>
						<th style="background-color:#e1e1e1">Departamento</th>
						<th style="background-color:#e1e1e1">Cliente</th>
						<th style="background-color:#e1e1e1">Referencia 1</th>
						<th style="background-color:#e1e1e1">Referencia 2</th>
						<th style="background-color:#e1e1e1">Referencia 3</th>
						<th style="background-color:#e1e1e1">Referencia 4</th>
						<th style="background-color:#e1e1e1">Referencia 5</th>
						<th style="background-color:#e1e1e1">Ruta </th>
						<th style="background-color:#e1e1e1">Ordenamiento</th>
						<th style="background-color:#e1e1e1">Agente</th>
						<th style="background-color:#e1e1e1">Estado Visita</th>
						<th style="background-color:#e1e1e1">Fecha Realizado</th>
						<th style="background-color:#e1e1e1">Respuesta</th>
						<th style="background-color:#e1e1e1">Detalle Respuesta</th>
						<th style="background-color:#e1e1e1">Resultado 1</th>
						<th style="background-color:#e1e1e1">Resultado 2</th>
						<th style="background-color:#e1e1e1">Ubicacion</th>
						<th style="background-color:#e1e1e1">Soporte</th>
						<th style="background-color:#e1e1e1">Observaciones</th>
					</tr>
				<tbody>';   
				


$completa="";
if($_GET["tipo"]!=""){
	$completa=" AND ac.tipo='".mysqli_real_escape_string($mysqli,$_GET["tipo"])."' ";
}


session_start();     
if( $_SESSION['LMNS-USER_TIPO']=="Cliente"){
$consulta="SELECT  ac.cons, ac.fecha, ac.tipo, ac.soporte, ac.usuariocarga, ac.estado, ac.fechacreacion,ac.fechaanulado, ac.observaciones,p.destinatario,p.direccion,c.nombre,d.nombre,p.cliente,p.referencia1,p.referencia2,p.referencia3,p.referencia4,p.referencia5,p.ruta,p.ordenamiento,a.nombre,p.estado,p.fecharealizado,p.respuesta,p.detallerespuesta,p.resultado1,p.resultado2,p.platitud,p.plongitud,p.soporte,p.observaciones,p.cons as pcons FROM ((((principal p INNER JOIN actividad ac ON ac.cons=p.codactividad) INNER JOIN ciudades c ON c.cons=p.codciudad)INNER JOIN departamentos d ON d.cons=p.coddepartamento)INNER JOIN agentes a ON a.usuario=p.codagente) WHERE 
	ac.fecha>='".mysqli_real_escape_string($mysqli,$_GET["Desde"])."' AND
	ac.fecha<='".mysqli_real_escape_string($mysqli,$_GET["Hasta"])."'
	AND ac.codempresa='".mysqli_real_escape_string($mysqli,$_GET["Code"])."'
	AND p.codcliente='".mysqli_real_escape_string($mysqli,$_GET["Codcl"])."'
	".$completa."  ORDER BY ac.cons  "; 
}else{
$consulta="SELECT  ac.cons, ac.fecha, ac.tipo, ac.soporte, ac.usuariocarga, ac.estado, ac.fechacreacion,ac.fechaanulado, ac.observaciones,p.destinatario,p.direccion,c.nombre,d.nombre,p.cliente,p.referencia1,p.referencia2,p.referencia3,p.referencia4,p.referencia5,p.ruta,p.ordenamiento,a.nombre,p.estado,p.fecharealizado,p.respuesta,p.detallerespuesta,p.resultado1,p.resultado2,p.platitud,p.plongitud,p.soporte,p.observaciones,p.cons as pcons FROM ((((principal p INNER JOIN actividad ac ON ac.cons=p.codactividad) INNER JOIN ciudades c ON c.cons=p.codciudad)INNER JOIN departamentos d ON d.cons=p.coddepartamento)INNER JOIN agentes a ON a.usuario=p.codagente) WHERE 
	ac.fecha>='".mysqli_real_escape_string($mysqli,$_GET["Desde"])."' AND
	ac.fecha<='".mysqli_real_escape_string($mysqli,$_GET["Hasta"])."'
	AND ac.codempresa='".mysqli_real_escape_string($mysqli,$_GET["Code"])."'
	".$completa."  ORDER BY ac.cons  "; 	
}

$datos=mysqli_query($mysqli,$consulta);	

				$cont=1;         
while($row=mysqli_fetch_row($datos)){ 
              
            echo '<tr >
		            <td  >'.$cont.'</td>
		            <td  >'.$row[32].'</td>
		            <td  >'.$row[0].'</td>
		            <td  >'.$row[1].'</td>
		            <td  >'.$row[2].'</td>
		            <td  >'.$row[3].'</td>
		            <td  >'.$row[4].'</td>
		            <td  >'.$row[5].'</td>
		            <td  >'.$row[6].'</td>
		            <td  >'.$row[7].'</td>
		            <td  >'.$row[8].'</td>
		            <td  >'.$row[9].'</td>
		            <td  >'.$row[10].'</td>
		            <td  >'.$row[11].'</td>
		            <td  >'.$row[12].'</td>
		            <td  >'.$row[13].'</td>
		            <td  >'.$row[14].'</td>
		            <td  >'.$row[15].'</td>
		            <td  >'.$row[16].'</td>
		            <td  >'.$row[17].'</td>
		            <td  >'.$row[18].'</td>
		            <td  >'.$row[19].'</td>
		            <td  >'.$row[20].'</td>
		            <td  >'.$row[21].'</td>
		            <td  >'.$row[22].'</td>
		            <td  >'.$row[23].'</td>
		            <td  >'.$row[24].'</td>
		            <td  >'.$row[25].'</td>
		            <td  >'.$row[26].'</td>
		            <td  >'.$row[27]."</td>
		            <td  ><a href='http://lumens.lecta.com.co/Core/ActividadMapa.php?lat=".$row[28]."&lon=".$row[29]."&dir=".$row[10]."' target='_blank'>Ver Posicion</a></td>		            
		            <td  ><a href='http://lumens.lecta.com.co/Core/".$row[30]."' target='_blank'>Ver Soporte</a></td>
		            <td  >".$row[31]."</td>
		        	</tr>";

				$cont++;
			}
	    echo '</tbody></table>';



?>


