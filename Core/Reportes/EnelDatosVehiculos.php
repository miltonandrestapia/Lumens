<?php

    require_once("../Procesamiento/Conexion.php");
	$filename = "Cepos-RelacionTotal.xls"; 
	header("Content-Disposition: attachment; filename=\"$filename\"");
	header("Content-Type: application/vnd.ms-excel; charset=UTF-8");

		echo '<table border="1" width="100%" style="font-size: 12px !important;border-collapse: collapse;">
					<tr>
						<th style="background-color:#e1e1e1">Nombre</th> 
						<th style="background-color:#e1e1e1">Usuario</th> 
						<th style="background-color:#e1e1e1">Fecha Guardado</th> 
						<th style="background-color:#e1e1e1">Placa</th> 
						<th style="background-color:#e1e1e1">Marca</th> 
						<th style="background-color:#e1e1e1">Modelo</th> 
						<th style="background-color:#e1e1e1">Vencimienot Soat</th> 
						<th style="background-color:#e1e1e1">Licencia Conduccion</th> 
						<th style="background-color:#e1e1e1">Vencimiento Licencia</th> 
						<th style="background-color:#e1e1e1">Licencia Trancito</th> 
						<th style="background-color:#e1e1e1">Vencimiento Tecnomecanica</th> 
					</tr>
				<tbody>';   
 
				 


if($_GET["Listado_dpto"] =="" && $_GET["Listado_UniNeg"] == "")
{ 
         $consulta= " SELECT a.nombre,a.usuario,e.fechaguardado,e.placa, e.marca, e.modelo, e.fechavencimientosoat, e.licencia, e.fechavencimientolicencia, e.licenciatrancito, e.fechavencimientotecnomecanica FROM eneldatosvehiculo e INNER JOIN agentes a ON a.usuario= e.codagente  ORDER BY a.nombre  ";
   
}

else if ( !empty($_GET["Listado_dpto"]) && $_GET["Listado_UniNeg"] == "") 
{ 
         $consulta="SELECT a.nombre,a.usuario,e.fechaguardado,e.placa, e.marca, e.modelo, e.fechavencimientosoat, e.licencia, e.fechavencimientolicencia, e.licenciatrancito, e.fechavencimientotecnomecanica FROM eneldatosvehiculo e INNER JOIN agentes a ON a.usuario= e.codagente
         where  a.Departamento='".mysqli_real_escape_string($mysqli,$_GET["Listado_dpto"])."'
         ORDER BY a.nombre  ";  
}

else if ( $_GET["Listado_dpto"] == "" &&  !empty($_GET["Listado_UniNeg"]) ) 
{ 
         $consulta="SELECT a.nombre,a.usuario,e.fechaguardado,e.placa, e.marca, e.modelo, e.fechavencimientosoat, e.licencia, e.fechavencimientolicencia, e.licenciatrancito, e.fechavencimientotecnomecanica FROM eneldatosvehiculo e INNER JOIN agentes a ON a.usuario= e.codagente
         where  a.unidad_negocio='".mysqli_real_escape_string($mysqli,$_GET["Listado_UniNeg"])."'
         ORDER BY a.nombre  ";  
}




else if ( !empty($_GET["Listado_dpto"]) && !empty($_GET["Listado_UniNeg"])  ) 
{ 
         $consulta=" SELECT a.nombre,a.usuario,e.fechaguardado,e.placa, e.marca, e.modelo, e.fechavencimientosoat, e.licencia, e.fechavencimientolicencia, e.licenciatrancito, e.fechavencimientotecnomecanica FROM eneldatosvehiculo e INNER JOIN agentes a ON a.usuario= e.codagente
         where  a.Departamento='".mysqli_real_escape_string($mysqli,$_GET["Listado_dpto"])."'
        AND a.unidad_negocio='".mysqli_real_escape_string($mysqli,$_GET["Listado_UniNeg"])."'  ORDER BY a.nombre  ";  
} 
 



$datos=mysqli_query($mysqli,$consulta);	
 
while($row=mysqli_fetch_row($datos)){ 
             echo '<tr > 
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
		        	</tr>'; 
			}
	    echo '</tbody></table>';







?>


