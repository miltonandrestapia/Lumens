<?php

    require_once("../Procesamiento/Conexion.php");
	$filename = "AsistenciaPreoperacional_".$_GET["GenerarInicio"].".xls"; 
	header("Content-Disposition: attachment; filename=\"$filename\"");
	header("Content-Type: application/vnd.ms-excel; charset=UTF-8");

		echo '<table border="1" width="100%" style="font-size: 12px !important;border-collapse: collapse;">
					<tr>
						<th style="background-color:#e1e1e1">Cons</th>
						<th  style="background-color:#e1e1e1">Agente</th> 
						<th  style="background-color:#e1e1e1">usuario</th> 
						<th  style="background-color:#e1e1e1">Ultimo Login</th> 
					</tr>
				<tbody>';    
				 


    $consulta="SELECT nombre,usuario,sesioninicio FROM agentes WHERE (unidad_negocio='ENEL CODENSA' OR unidad_negocio='ENEL REPARTO ESPECIAL' ) AND usuario NOT IN (SELECT codagente FROM `enelasistencia` WHERE fecha='".mysqli_real_escape_string($mysqli,$_GET["GenerarInicio"])."') order by nombre    "; 


$datos=mysqli_query($mysqli,$consulta);	

				$cont=1;         
while($row=mysqli_fetch_row($datos)){  
            echo '<tr >
		            <td  >'.$cont.'</td>  
		            <td  >'.$row[0].'</td>
		            <td  >'.$row[1].'</td>
		            <td  >'.$row[2].'</td>  
		        	</tr>';
		        

				$cont++;
			}
	    echo '</tbody></table>';



?>


