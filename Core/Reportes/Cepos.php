<?php

    require_once("../Procesamiento/Conexion.php");
	$filename = "Cepos-RelacionTotal.xls"; 
	header("Content-Disposition: attachment; filename=\"$filename\"");
	header("Content-Type: application/vnd.ms-excel; charset=UTF-8");

		echo '<table border="1" width="100%" style="font-size: 12px !important;border-collapse: collapse;">
					<tr>
						<th style="background-color:#e1e1e1">Cons</th>
						<th style="background-color:#e1e1e1">Cepo</th>
						<th style="background-color:#e1e1e1">Estado</th>
						<th style="background-color:#e1e1e1">Ubicacion</th>
						<th style="background-color:#e1e1e1">Fecha</th>
					</tr>
				<tbody>';   

				
$consulta=" SELECT codigo,estado,ubica,fechaestado FROM cepos ORDER BY fechaestado DESC "; 
$datos=mysqli_query($mysqli,$consulta);	
$cont=1;        

while($row=mysqli_fetch_row($datos)){ 
             echo '<tr >
		            <td  >'.$cont.'</td>
		            <td  >'.$row[0].'</td>
		            <td  >'.$row[1].'</td>
		            <td  >'.$row[2].'</td>
		            <td  >'.$row[3].'</td>
		        	</tr>';
				$cont++;
			}
	    echo '</tbody></table>';

?>


