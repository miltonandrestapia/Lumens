<?php  

    require_once("../Procesamiento/Conexion.php");
	$filename = "DetalladoAsistencia".$_GET["GenerarInicio"]."_".$_GET["GenerarFinal"].".xls"; 
	header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
	header("Content-type:   application/x-msexcel; charset=utf-8");
	header("Content-Disposition: attachment; filename=\"$filename\"");
    header('Pragma: no-cache');
    header('Expires: 0');
   
		echo utf8_decode('


		<table border="1" width="100%" style="font-size: 12px !important;border-collapse: collapse;">
					<tr>
						<th style="background-color:#e1e1e1">Cons</th>						
						<th  style="background-color:#e1e1e1">Agente</th>			
						<th  style="background-color:#e1e1e1">Fecha</th>			
						<th  style="background-color:#e1e1e1">Cedula</th>			
                        <th  style="background-color:#e1e1e1">camecodensa</th>
                        <th  style="background-color:#e1e1e1">Camearp </th>
                        <th  style="background-color:#e1e1e1">Preoperacional</th>
                        <th  style="background-color:#e1e1e1">Procedimiento</th>
                        <th  style="background-color:#e1e1e1">Ropa</th>
                        <th  style="background-color:#e1e1e1">Canguro</th>
                        <th  style="background-color:#e1e1e1">Casco</th>
                        <th  style="background-color:#e1e1e1">Bloqueador</th>
                        <th  style="background-color:#e1e1e1">Guantes</th>
                        <th  style="background-color:#e1e1e1">Impremeables</th>
                        <th  style="background-color:#e1e1e1">Gorra</th>
                        <th  style="background-color:#e1e1e1">Botas</th>
                        <th  style="background-color:#e1e1e1">Cartuchera</th>
                        <th  style="background-color:#e1e1e1">Binoculares</th>
                        <th  style="background-color:#e1e1e1">Interna</th>
                        <th  style="background-color:#e1e1e1">Planillero</th>
                        <th  style="background-color:#e1e1e1">Detector</th>
                        <th  style="background-color:#e1e1e1">Polainas</th>
                        <th  style="background-color:#e1e1e1">Atomizador</th>
                        <th  style="background-color:#e1e1e1">Celular</th>
                        <th  style="background-color:#e1e1e1">Presentacion</th>
                        <th  style="background-color:#e1e1e1">Mapa</th>
                        <th  style="background-color:#e1e1e1">Salud</th>
                        <th  style="background-color:#e1e1e1">Batena</th>
                        <th  style="background-color:#e1e1e1">Teclado</th>
                        <th  style="background-color:#e1e1e1">Encendido</th>
                        <th  style="background-color:#e1e1e1">Impresion</th>
                        <th  style="background-color:#e1e1e1">Certificaciones</th>
                        <th  style="background-color:#e1e1e1">Constancias</th>
                        <th  style="background-color:#e1e1e1">Hojas</th>
                        <th  style="background-color:#e1e1e1">Observaciones</th>

                        			
					</tr>
				<tbody>');   
				


      $consulta="SELECT a.nombre,
                        e.fecha,
                        e.cedula,   
                        e.carnecodensa,
                        e.carnearp,  	
                        e.preoperacional,
                        e.procedimiento, 
                        e.ropa, 
                        e.canguro, 
                        e.casco, 
                        e.bloqueador, 
                        e.guantes, 
                        e.imprermeables, 
                        e.gorra, 
                        e.botas, 
                        e.cartuchera, 
                        e.binoculares, 
                        e.linterna,  
                        e.planillero, 
                        e.detector, 
                        e.polainas, 
                        e.atomizador, 
                        e.celular, 
                        e.presentacion, 
                        e.mapa, 
                        e.salud, 
                        e.bateria, 
                        e.teclado, 
                        e.encendido, 
                        e.impresion, 
                        e.certificaciones, 
                        e.constancias, 
                        e.hojas,
                        e.observaciones    
                        from enelasistencia e inner join agentes a on a.usuario=codagente
                        where  e.fecha>='".mysqli_real_escape_string($mysqli,$_GET["GenerarInicio"])."' 
                        and fecha<='".mysqli_real_escape_string($mysqli,$_GET["GenerarFinal"])."'  "; 


  
//echo $consulta;
$datos=mysqli_query($mysqli,$consulta);	 

				$cont=1;         
while($row=mysqli_fetch_row($datos)){ 

					/*  $imagen='';
					  if ($row[78]!="") {
					  	$imagen='<a href="https://storage.googleapis.com/lumensarchivostemporales/Soportes/'.$row[78].'">Ver Imagen</a>';
					  }*/
            echo utf8_decode('<tr >
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
					<td  >'.$row[27].'</td>   
					<td  >'.$row[28].'</td>  
					<td  >'.$row[29].'</td>  
					<td  >'.$row[30].'</td> 		           
		            <td  >'.$row[31].'</td>
		            <td  >'.$row[32].'</td>  
					<td  >'.$row[33].'</td> ');  



				$cont++;
			} 
	    echo '</tbody></table>';  




?>


