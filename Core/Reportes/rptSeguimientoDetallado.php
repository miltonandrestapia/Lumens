<?php

    require_once("../Procesamiento/Conexion.php");
	$filename = "SeguimientoDetallado_".$_GET["fecha"]."_".$_GET["cod"].".xls";


	header("Content-Disposition: attachment; filename=\"$filename\"");
	header("Content-Type: application/vnd.ms-excel; charset=UTF-8");

		echo '<table border="1" width="100%" style="font-size: 12px !important;border-collapse: collapse;">
					<tr>
						<th style="background-color:#e1e1e1">CONS</th>
						<th style="background-color:#e1e1e1">FECHA HORA</th>
						<th style="background-color:#e1e1e1">TIPO DE RED</th>
						<th style="background-color:#e1e1e1">LATITUD</th>
						<th style="background-color:#e1e1e1">LONGITUD</th>
						<th style="background-color:#e1e1e1">BATERIA</th>
						<th style="background-color:#e1e1e1">TIPO CARGA</th>
						<th style="background-color:#e1e1e1">BLUETOOTH</th>
						<th style="background-color:#e1e1e1">VELOCIDAD</th>
						<th style="background-color:#e1e1e1">VER UBICACION</th>
					</tr>
				<tbody>';   

    $consulta="SELECT hora,red,lat,lon,bateria,carga,bluet FROM tracking WHERE 
    fecha='".mysqli_real_escape_string($mysqli,$_GET["fecha"])."' AND usuario='".mysqli_real_escape_string($mysqli,$_GET["cod"])."'
	 ORDER BY hora desc  "; 

$latanterior="";
$lonanterior="";
$horaold="";
$datos=mysqli_query($mysqli,$consulta);	

				$cont=1;         
			while($row=mysqli_fetch_row($datos)){ 
$velocidad="";
$diferencia="";
$segundos="";
$minutos="";
$horas="";
$tiempocalculo="";
$kmh=0;


				     if($horaold==""){
				        $horaold=$row[0];
				        $latanterior=$row[2];
				        $lonanterior=$row[3];
				    }else{
				        $datetime1 = new DateTime($row[0]);
				        $datetime2 = new DateTime($horaold);
				        $interval = $datetime1->diff($datetime2);
				        $segundos = $interval->format('%s');
				        $minutos = $interval->format('%i');
				        $horas = $interval->format('%H');

				        $elapsed = ($minutos)+($horas*60);
				        $tiempocalculo = ($segundos)+($minutos*60)+($horas*360);
				        if($elapsed>20){
				          $clase=' style="background-color:red " ';
				        }

						$diferencia = distanceCalculation($latanterior, $lonanterior, $row[2], $row[3], "km", "");
							 if (($diferencia."")!="NAN") {
				       	 	$kmh=round(((($diferencia/$tiempocalculo)*18)/5),0);
				        }
				    } 

           			 echo '<tr >
		            <td  >'.$cont.'</td>
		            <td  >'.$row[0].'</td>
		            <td  >'.$row[1].'</td>
		            <td  >'.$row[2].'</td>
		            <td  >'.$row[3].'</td>
		            <td  >'.$row[4].'</td>
		            <td  >'.$row[5].'</td>
		            <td  >'.$row[6].'</td>
		            <td  >'.$kmh.' km/h</td>
		            <td  ><a href="https://lumens-1554145071773.appspot.com/Core/VerEnMapa.php?lat='.$row[2].'&lon='.$row[3].'">Ver en mapa</a></td>
		        	</tr>';

                        ;$horaold=$row[0];
                    	$latanterior=$row[2];
						$lonanterior=$row[3];
				$cont++;
			}
	    echo '</tbody></table>';



   function distanceCalculation($point1_lat, $point1_long, $point2_lat, $point2_long, $unit, $decimals) {
      $degrees = rad2degs(acos( (sin(deg2rads($point1_lat)) * sin(deg2rads($point2_lat))) + (cos(deg2rads($point1_lat))*cos(deg2rads($point2_lat)) * cos(deg2rads($point1_long-$point2_long)) ) ));
      switch($unit) {
        case 'km':
          $distance = $degrees * 111.13384; // 1 grado = 111.13384 km, basándose en el diametro promedio de la Tierra (12.735 km)
          $distance = $distance * 1000; // 1 grado = 111.13384 km, basándose en el diametro promedio de la Tierra (12.735 km)
          break;
        case 'mi':
          $distance = $degrees * 69.05482; // 1 grado = 69.05482 millas, basándose en el diametro promedio de la Tierra (7.913,1 millas)
          break;
        case 'nmi':
          $distance =  $degrees * 59.97662; // 1 grado = 59.97662 millas naúticas, basándose en el diametro promedio de la Tierra (6,876.3 millas naúticas)
      }
      return round($distance,0);
    }


    function rad2degs($angle) {
      return $angle * 57.29577951308232 ;// angle / Math.PI * 180
    }

    function deg2rads($angle) {
      return $angle * 0.017453292519943295 ;// (angle / 180) * Math.PI;
    }    
?>


