<?php  

    require_once("../Procesamiento/Conexion.php");
	$filename = "DetalladoPreoperacional".$_GET["GenerarInicio"]."_".$_GET["GenerarFinal"].".xls"; 
	header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
	header("Content-type:   application/x-msexcel; charset=utf-8");
	header("Content-Disposition: attachment; filename=\"$filename\"");
header('Pragma: no-cache');
header('Expires: 0');

		echo utf8_decode( '


		<table border="1" width="100%" style="font-size: 12px !important;border-collapse: collapse;">
					<tr>
						<th style="background-color:#e1e1e1">Cons</th>						
						<th  style="background-color:#e1e1e1">Observaciones</th>			
						<th  style="background-color:#e1e1e1">Fecha</th>			
						<th  style="background-color:#e1e1e1">Estado de las llantas.</th>			
						<th  style="background-color:#e1e1e1">Observaciones</th>			
						<th  style="background-color:#e1e1e1">Estado de los rines</th>			
						<th  style="background-color:#e1e1e1">Observaciones</th>			
						<th  style="background-color:#e1e1e1">Luz delantera</th>			
						<th  style="background-color:#e1e1e1">Observaciones</th>			
						<th  style="background-color:#e1e1e1">Luz del stop</th>			
						<th  style="background-color:#e1e1e1">Observaciones</th>			
						<th  style="background-color:#e1e1e1">Luces direccionales delantera y trasera</th>			
						<th  style="background-color:#e1e1e1">Observaciones</th>			
						<th  style="background-color:#e1e1e1">Pito opera normalmente.</th>			
						<th  style="background-color:#e1e1e1">Observaciones</th>			
						<th  style="background-color:#e1e1e1">Manubrios en buen estado.</th>			
						<th  style="background-color:#e1e1e1">Observaciones</th>			
						<th  style="background-color:#e1e1e1">Verificar el estado del kit de arrastre</th>			
						<th  style="background-color:#e1e1e1">Observaciones</th>			
						<th  style="background-color:#e1e1e1">Verificar aceite</th>			
						<th  style="background-color:#e1e1e1">Observaciones</th>			
						<th  style="background-color:#e1e1e1">Funcionamiento de frenos. (Delantero y trasero)</th>			
						<th  style="background-color:#e1e1e1">Observaciones</th>			
						<th  style="background-color:#e1e1e1">La carrera o movimiento de los pedales (palanca) de accionamiento del sistema de freno son adecuados.</th>			
						<th  style="background-color:#e1e1e1">Observaciones</th>			
						<th  style="background-color:#e1e1e1">Estado de los espejos retrovisores</th>			
						<th  style="background-color:#e1e1e1">Observaciones</th>			
						<th  style="background-color:#e1e1e1">Cuenta con el mínimo nivel requerido de líquido para frenos</th>			
						<th  style="background-color:#e1e1e1">Observaciones</th>			
						<th  style="background-color:#e1e1e1">Hay retorno adecuado de pedal/palanca de freno trasero y/o delantero</th>			
						<th  style="background-color:#e1e1e1">Observaciones</th>			
						<th  style="background-color:#e1e1e1">Se encuentra la tapa del depósito de líquido de frenos</th>			
						<th  style="background-color:#e1e1e1">Observaciones</th>			
						<th  style="background-color:#e1e1e1">Estado de los escala pies (posapiés)</th>			
						<th  style="background-color:#e1e1e1">Observaciones</th>			
						<th  style="background-color:#e1e1e1">Testigos del tablero</th>			
						<th  style="background-color:#e1e1e1">Observaciones</th>			
						<th  style="background-color:#e1e1e1">Velocímetro funcionando correctamente</th>			
						<th  style="background-color:#e1e1e1">Observaciones</th>			
						<th  style="background-color:#e1e1e1">Prueba en marcha (ruido, otros)</th>			
						<th  style="background-color:#e1e1e1">Observaciones</th>			
						<th  style="background-color:#e1e1e1">Estado de amortiguador delantero</th>			
						<th  style="background-color:#e1e1e1">Observaciones</th>			
						<th  style="background-color:#e1e1e1">Estado de amortiguador trasero</th>			
						<th  style="background-color:#e1e1e1">Observaciones</th>			
						<th  style="background-color:#e1e1e1">Carnet ARL</th>			
						<th  style="background-color:#e1e1e1">Observaciones</th>			
						<th  style="background-color:#e1e1e1">Carnet Lecta</th>			
						<th  style="background-color:#e1e1e1">Observaciones</th>			
						<th  style="background-color:#e1e1e1">Carnet Enel</th>			
						<th  style="background-color:#e1e1e1">Observaciones</th>			
						<th  style="background-color:#e1e1e1">Cédula cuidadanía</th>			
						<th  style="background-color:#e1e1e1">Observaciones</th>			
						<th  style="background-color:#e1e1e1">Licencia tránsito</th>			
						<th  style="background-color:#e1e1e1">Observaciones</th>			
						<th  style="background-color:#e1e1e1">Licencia conducción</th>			
						<th  style="background-color:#e1e1e1">Observaciones</th>			
						<th  style="background-color:#e1e1e1">SOAT</th>			
						<th  style="background-color:#e1e1e1">Observaciones</th>			
						<th  style="background-color:#e1e1e1">Casco incluir visor</th>			
						<th  style="background-color:#e1e1e1">Observaciones</th>			
						<th  style="background-color:#e1e1e1">Guantes</th>			
						<th  style="background-color:#e1e1e1">Observaciones</th>			
						<th  style="background-color:#e1e1e1">Chaleco airbag (incluir botella de activación, correa de activación, correa de sujeción al chasis, protector de espalda).</th>			
						<th  style="background-color:#e1e1e1">Observaciones</th>			
						<th  style="background-color:#e1e1e1">Coderas y rodilleras</th>			
						<th  style="background-color:#e1e1e1">Observaciones</th>			
						<th  style="background-color:#e1e1e1">Botas</th>			
						<th  style="background-color:#e1e1e1">Observaciones</th>			
						<th  style="background-color:#e1e1e1">Kilometraje inicial</th>	

						<th  style="background-color:#e1e1e1">Fecha</th>			
						<th  style="background-color:#e1e1e1">Hallazgo</th>			
						<th  style="background-color:#e1e1e1">Accion correctiva</th>			
						<th  style="background-color:#e1e1e1">Seguimiento</th>			
						<th  style="background-color:#e1e1e1">Conforme</th>			
						<th  style="background-color:#e1e1e1">No conforme</th>			
						<th  style="background-color:#e1e1e1">Apto</th>			
						<th  style="background-color:#e1e1e1">No Apto</th>			
						<th  style="background-color:#e1e1e1">Observaciones</th>			
						<th  style="background-color:#e1e1e1">Imagen</th>			

						
                        
						
					</tr>
				<tbody>');   
				


      $consulta="SELECT a.nombre,fecha,e1,obs1, e2,obs2, e3,obs3, e4,obs4, e5,obs5, e6,obs6, e7,obs7, e8,obs8, e9,obs9, e10,obs10, e11,obs11, e12,obs12, e13,obs13, e14,obs14, e15,obs15, e16,obs16, e17,obs17, e18,obs18, e19,obs19, e20,obs20,e21,obs21, d1,obs22,d2,obs23,d3,obs24,d4,obs25,d5,obs26,d6,obs27,d7,obs28,s1,obs29,s2,obs30,s3,obs31,s4,obs32,s5,obs33,s6,n1,n2,n3,n4,n5,n6,apto,noapto,obs36,imagen   from enelpreopperacionalmotos inner join agentes a on a.usuario=codagente
         where  fecha>='".mysqli_real_escape_string($mysqli,$_GET["GenerarInicio"])."' and fecha<='".mysqli_real_escape_string($mysqli,$_GET["GenerarFinal"])."'  "; 



//echo $consulta;
$datos=mysqli_query($mysqli,$consulta);	 

				$cont=1;         
while($row=mysqli_fetch_row($datos)){ 

					  $imagen='';
					  if ($row[78]!="") {
					  	$imagen='<a href="https://storage.googleapis.com/lumensarchivostemporales/Soportes/'.$row[78].'">Ver Imagen</a>';
					  }
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
					<td  >'.$row[33].'</td> 
					<td  >'.$row[34].'</td> 
					<td  >'.$row[35].'</td> 
					<td  >'.$row[36].'</td> 
					<td  >'.$row[37].'</td> 
					<td  >'.$row[38].'</td> 
					<td  >'.$row[39].'</td> 
					<td  >'.$row[40].'</td> 
					<td  >'.$row[41].'</td>


					<td  >'.$row[42].'</td> 
					<td  >'.$row[43].'</td> 
					<td  >'.$row[44].'</td> 
					<td  >'.$row[45].'</td> 
					<td  >'.$row[46].'</td> 
					<td  >'.$row[47].'</td> 
					<td  >'.$row[48].'</td> 
					<td  >'.$row[49].'</td> 
					<td  >'.$row[50].'</td> 
					<td  >'.$row[51].'</td> 
					<td  >'.$row[52].'</td> 
					<td  >'.$row[53].'</td> 
					<td  >'.$row[54].'</td> 
					<td  >'.$row[55].'</td> 
					<td  >'.$row[56].'</td> 
					<td  >'.$row[57].'</td> 


					<td  >'.$row[58].'</td> 
					<td  >'.$row[59].'</td> 
					<td  >'.$row[60].'</td> 
					<td  >'.$row[61].'</td> 
					<td  >'.$row[62].'</td> 
					<td  >'.$row[63].'</td> 
					<td  >'.$row[64].'</td> 
					<td  >'.$row[65].'</td> 
					<td  >'.$row[66].'</td> 
					<td  >'.$row[67].'</td> 
					<td  >'.$row[68].'</td> 





					<td  >'.$row[69].'</td> 
					<td  >'.$row[70].'</td> 
					<td  >'.$row[71].'</td> 
					<td  >'.$row[72].'</td> 
					<td  >'.$row[73].'</td> 
					<td  >'.$row[74].'</td> 




					<td  >'.$row[75].'</td> 
					<td  >'.$row[76].'</td> 
					<td  >'.$row[77].'</td> 
					<td  >'.$imagen.'</td> 

					');  



				$cont++;
			} 
	    echo '</tbody></table>';  




?>


