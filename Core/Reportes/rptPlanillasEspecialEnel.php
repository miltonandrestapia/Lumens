
<body onLoad="window.print()">

<?php

    require_once("../Procesamiento/Conexion.php"); 



    $consulta="SELECT a.nombre,ac.fecha,now()
    FROM (( proyectoespecialenel p INNER JOIN actividad ac ON ac.cons=p.codactividad)  LEFT JOIN agentes a ON a.usuario=p.codagente)
	WHERE ac.cons='".mysqli_real_escape_string($mysqli,$_GET["CodActividad"])."' AND p.codagente='".mysqli_real_escape_string($mysqli,$_GET["codagente"])."'	  ORDER BY ac.cons  "; 

$nombre="";
$fecha="";
$impreso="";
$datos=mysqli_query($mysqli,$consulta);	 
if($row=mysqli_fetch_row($datos)){ 
	$nombre=$row[0];
	$fecha=$row[1];
	$impreso=$row[2];
}




		$texto= '<table border="1" width="100%" style="font-size: 12px !important;border-collapse: collapse;">
					<tr>
						<th style="background-color:#e1e1e1">Cons</th> 
						<th style="background-color:#e1e1e1">Producto</th>
						<th style="background-color:#e1e1e1">Orden de servicio</th>
						<th style="background-color:#e1e1e1">No Guia</th>
						<th style="background-color:#e1e1e1">No Cuenta</th>
						<th style="background-color:#e1e1e1">ID Venta</th>
						<th style="background-color:#e1e1e1">Direccion</th>
						<th style="background-color:#e1e1e1">Cuadratula</th> 
					</tr>
				<tbody>';   
				


    $consulta="SELECT  p.producto,p.orden,p.guia,p.cuenta,p.idventa,p.direccion,p.cuadratula 
    FROM (( proyectoespecialenel p INNER JOIN actividad ac ON ac.cons=p.codactividad)  LEFT JOIN agentes a ON a.usuario=p.codagente)
	WHERE ac.cons='".mysqli_real_escape_string($mysqli,$_GET["CodActividad"])."'  AND p.codagente='".mysqli_real_escape_string($mysqli,$_GET["codagente"])."'	   ORDER BY ac.cons  "; 


$datos=mysqli_query($mysqli,$consulta);	

				$cont=1;        
while($row=mysqli_fetch_row($datos)){ 
              
       
            $texto.= '<tr >
		            <td  >'.$cont.'</td>  
		            <td  >'.$row[0].'</td>
		            <td  >'.$row[1].'</td>
		            <td  >'.$row[2].'</td>
		            <td  >'.$row[3].'</td>
		            <td  >'.$row[4].'</td>
		            <td  >'.$row[5].'</td>
		            <td  >'.$row[6].'</td> 
		        	</tr>';
		    

				$cont++;
			}
	    $texto.= '</tbody></table>';

		echo '<table border="1" width="100%" style="font-size: 14px !important;border-collapse: collapse;">
					<tr>
						<th rowspan="2" width="20%"  ><img src="../images/Lecta.jpg" width="70%" ></th> 
						<th >Agente</th> 
						<th >'.$nombre.'</th> 
						<th >Fecha Actividades</th> 
						<th >'.$fecha.'</th> 
							</tr>	<tr>
						<th >Fecha Impresion</th> 
						<th >'.$impreso.'</th> 
						<th >Cantidad</th> 
						<th >'.($cont-1).'</th> </tr></table>
<br><br>
						';
echo $texto;

?>


