<?php  

    require_once("../Procesamiento/Conexion.php");
	$filename = "Detalleactividades_".$_GET["Tipo"]."_".$_GET["GenerarInicio"]."_".$_GET["GenerarFinal"].".xls"; 
	header("Content-Disposition: attachment; filename=\"$filename\"");
	header("Content-Type: application/vnd.ms-excel; charset=UTF-8");

		echo '<table border="1" width="100%" style="font-size: 12px !important;border-collapse: collapse;">
					<tr>
						<th style="background-color:#e1e1e1">Cons</th>
						
						<th  style="background-color:#e1e1e1">Agente</th>
						<th  style="background-color:#e1e1e1">Codigo Visita</th>
						<th  style="background-color:#e1e1e1">Codigo Actividad</th>
						<th  style="background-color:#e1e1e1">Fecha Actividad</th> 
						<th  style="background-color:#e1e1e1">Usuario Creacion  Actividad </th>
						<th  style="background-color:#e1e1e1">Estado Actividad</th> 
						<th  style="background-color:#e1e1e1">Fecha Creacion  Actividad</th>
						<th  style="background-color:#e1e1e1">Fecha Anulado  Actividad</th>         
						<th  style="background-color:#e1e1e1">Observaciones  Actividad</th> 
						<th style="background-color:#e1e1e1">Producto</th>
						<th style="background-color:#e1e1e1">Orden de servicio</th>
						<th style="background-color:#e1e1e1">Consecutivo</th>
						<th style="background-color:#e1e1e1">No Cuenta</th>
						<th style="background-color:#e1e1e1">ID Venta</th>
						<th style="background-color:#e1e1e1">Direccion</th>
						<th style="background-color:#e1e1e1">Cuadratula</th>
						<th style="background-color:#e1e1e1">Ciclo</th>
						<th style="background-color:#e1e1e1">Suscriptor</th>
						<th style="background-color:#e1e1e1">Grupo</th>
						<th style="background-color:#e1e1e1">Sucursal</th>
						<th style="background-color:#e1e1e1">Supervisor</th>

						<th style="background-color:#e1e1e1">Fecha maxima entrega</th>
						<th style="background-color:#e1e1e1">Fecha llegada fisico</th>
						<th style="background-color:#e1e1e1">Cedula</th>
						<th style="background-color:#e1e1e1">Especial1</th>   
						<th style="background-color:#e1e1e1">Lote</th> 

						<th style="background-color:#e1e1e1">Telefono</th>
						<th style="background-color:#e1e1e1">Medidor</th>
						<th style="background-color:#e1e1e1">Posicion Medidor</th>
						<th style="background-color:#e1e1e1">Lectura Actual</th>
						<th style="background-color:#e1e1e1">Nombre Quien Recibe</th>
						<th style="background-color:#e1e1e1">Direccion Correcta</th>
						<th style="background-color:#e1e1e1">Observaciones De Visita</th>
						<th style="background-color:#e1e1e1">Anomalia</th>
						<th style="background-color:#e1e1e1">Estado</th>
						<th style="background-color:#e1e1e1">Fecha Registro</th>
						<th style="background-color:#e1e1e1">Latitud</th>
						<th style="background-color:#e1e1e1">Longitud</th> 
						<th style="background-color:#e1e1e1">Ubicacion</th>
						<th style="background-color:#e1e1e1">Soporte Medidor</th>
						<th style="background-color:#e1e1e1">Soporte Medidor Fecha</th>
						<th style="background-color:#e1e1e1">Soporte consecutivo</th>
						<th style="background-color:#e1e1e1">Soporte consecutivo Fecha</th>
						<th style="background-color:#e1e1e1">Soporte Predio</th>
						<th style="background-color:#e1e1e1">Soporte Predio Fecha</th>

						
                        
						
					</tr>
				<tbody>';   
				

if ($_GET["Tipo"]=="Busquedadirecciones") { 
     $consulta="SELECT  p.cons,
	ac.cons,
	ac.fecha,
	ac.usuariocarga,
	ac.estado, 
	ac.fechacreacion,
	ac.fechaanulado, 
	ac.observaciones,

	p.producto,
	p.orden,
	p.guia,
	p.cuenta,
	p.idventa,
	p.direccion,
	p.cuadratula,
	p.ciclo,
	p.suscriptor,
	p.grupo,
	p.sucursal,
	p.supervisor,

	p.fecha_max_entrega,
	p.fecha_llegada_fisico,
	p.documento,
	p.especial1,
	p.lote,


	p.telefono,
	p.medidor,
	p.lectura,
	p.quienrecibe,
	p.direccioncorrecta,
	p.observaciones,
	p.anomalia,
	p.estado,
	p.fechahorarealizado,
	p.latitud,
	p.longitud,
	p.fotomedidor,
	p.fotomedidorfecha,
	p.fotoguia,
	p.fotoguiafecha,
	p.fotopredio,
	p.fotoprediofecha,
	a.nombre,
	p.posicionmedidor

    FROM (( proyectoespecialenel p INNER JOIN actividad ac ON ac.cons=p.codactividad)  LEFT JOIN agentes a ON a.usuario=p.codagente)
	WHERE ac.fecha>='".mysqli_real_escape_string($mysqli,$_GET["GenerarInicio"])."' and ac.fecha<='".mysqli_real_escape_string($mysqli,$_GET["GenerarFinal"])."'  AND  (p.direccion!=p.direccioncorrecta AND p.direccioncorrecta  IS NOT NULL AND NOT p.direccioncorrecta='')  order by p.cons   "; 
}else{
    $consulta="SELECT  p.cons,
	ac.cons,
	ac.fecha,
	ac.usuariocarga,
	ac.estado, 
	ac.fechacreacion,
	ac.fechaanulado, 
	ac.observaciones,

	p.producto,
	p.orden,
	p.guia,
	p.cuenta,
	p.idventa,
	p.direccion,
	p.cuadratula,
	p.ciclo,
	p.suscriptor,
	p.grupo,
	p.sucursal,
	p.supervisor,

	p.fecha_max_entrega,
	p.fecha_llegada_fisico,
	p.documento,
	p.especial1,
	p.lote,


	p.telefono,
	p.medidor,
	p.lectura,
	p.quienrecibe,
	p.direccioncorrecta,
	p.observaciones,
	p.anomalia,
	p.estado,
	p.fechahorarealizado,
	p.latitud,
	p.longitud,
	p.fotomedidor,
	p.fotomedidorfecha,
	p.fotoguia,
	p.fotoguiafecha,
	p.fotopredio,
	p.fotoprediofecha,
	a.nombre,
	p.posicionmedidor

    FROM (( proyectoespecialenel p INNER JOIN actividad ac ON ac.cons=p.codactividad)  LEFT JOIN agentes a ON a.usuario=p.codagente)
	WHERE ac.fecha>='".mysqli_real_escape_string($mysqli,$_GET["GenerarInicio"])."' and ac.fecha<='".mysqli_real_escape_string($mysqli,$_GET["GenerarFinal"])."'   ORDER BY p.cons   "; 

}



//echo $consulta;
$datos=mysqli_query($mysqli,$consulta);	 

				$cont=1;         
while($row=mysqli_fetch_row($datos)){ 
                         if ($row[42]==""){    
              	$row[42]="NO ASIGNADO";
              }
            echo '<tr >
					<td  >'.$cont.'</td> 
					<td  >'.$row[42].'</td>  
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
					<td  >'.$row[43].'</td>  
					<td  >'.$row[27].'</td>   
					<td  >'.$row[28].'</td>  
					<td  >'.$row[29].'</td>  
					<td  >'.$row[30].'</td>  

		           
		            <td  >'.$row[31].'</td>
		            <td  >'.$row[32].'</td>  
					<td  >'.$row[33].'</td>';  
					  
			  	//latitud
				if ($row[34]=="") {
		          echo '<td  > </td>
		            <td> </td>  
		            <td> </td>
		            <td> </td> 
		            <td> </td>
		            <td> </td> 
		            <td> </td> 
		            <td> </td> 
					<td> </td> 

					
					
					
		        	</tr>';

				}else{ 
		          echo '<td  >'.$row[34].'</td>
		            <td  >'.$row[35].'</td>
		             <td  ><a href="http://lumens.lecta.com.co/Core/ActividadMapa.php?lat='.$row[34].'&lon='.$row[35].'&dir='.$row[13].'" target="_blank">Ver Posicion</a></td>	
		           <td  ><a href="https://storage.googleapis.com/lumensarchivostemporales/Soportes/'.$row[36].'" target="_blank">Ver Imagen</a></td>	
		            <td  >'.$row[37].'</td>
		            <td  ><a href="https://storage.googleapis.com/lumensarchivostemporales/Soportes/'.$row[38].'" target="_blank">Ver Imagen</a></td>	
		            <td  >'.$row[39].'</td>
		            <td  ><a href="https://storage.googleapis.com/lumensarchivostemporales/Soportes/'.$row[40].'" target="_blank">Ver Imagen</a></td>	
					<td  >'.$row[41].'</td>   

				 
		        	</tr>';  
		        }

				$cont++;
			} 
	    echo '</tbody></table>';  




?>


