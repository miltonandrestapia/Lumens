<?php

session_start();    
    require_once("../Procesamiento/Conexion.php");


$filename = "ResumenActividadesDe".$_GET["Fecha"].".xls"; 
	header("Content-Disposition: attachment; filename=\"$filename\"");
	header("Content-Type: application/vnd.ms-excel; charset=UTF-8");


		echo '<table border="1" width="100%" style="font-size: 12px !important;border-collapse: collapse;">
					<tr>
						<th style="background-color:#e1e1e1">Cons</th>
						<th  style="background-color:#e1e1e1">AGENTE</th>
						<th  style="background-color:#e1e1e1">CANTIDAD INCIDENCIAS</th>
					</tr>
				<tbody>';   
				
            $cont=1;    


$completaconsulta=" 1=1";

if(isset($_SESSION['LMNS_dpto'])) {
    if ($_SESSION['LMNS_dpto']!="") {
      $completaconsulta.=" AND a.Departamento='".mysqli_real_escape_string($mysqli,$_SESSION['LMNS_dpto'])."'";
    }
}

if(isset($_SESSION['LMNS_unidad'])){
  if ($_SESSION['LMNS_unidad']!="") {
    $completaconsulta.=" AND a.unidad_negocio='".mysqli_real_escape_string($mysqli,$_SESSION["LMNS_unidad"])."' ";
  }
}


            $c1="SELECT DISTINCT(a.usuario),a.nombre FROM tracking t INNER JOIN agentes a ON a.usuario=t.usuario WHERE t.fecha='".$_GET['Fecha']."' AND ".$completaconsulta." order by a.nombre "; 
            $d1=mysqli_query($mysqli,$c1); 
            while($r1=mysqli_fetch_row($d1)){ 

              echo '<tr >
            <td  >'.$cont.'</td>
            <td  >'. $r1[1].'</td>';


              $consulta="SELECT usuario,hora,lat,lon FROM tracking WHERE 
              fecha='".$_GET['Fecha']."' AND usuario='".$r1[0]."' ORDER BY hora DESC "; 


            $datos=mysqli_query($mysqli,$consulta);	
            $latanterior="";
            $lonanterior="";
            $horaold="";
            $horakm="";
            $strincidencias="";
            $cantincidencias=0;

            while($row=mysqli_fetch_row($datos)){ 

            $velocidad="";
            $diferencia="";
            $segundos="";
            $minutos="";
            $horas="";
            $tiempocalculo="";
            $kmh=0;
              
      

                            if($horaold==""){
                                $horaold=$row[1];
                                $latanterior=$row[2];
                                $lonanterior=$row[3];
                            }else{
                                $datetime1 = new DateTime($row[1]);
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
                            
                        if($kmh>50){
                            if($horaold==$horakm){
                                $cantincidencias++; 
                                $strincidencias= $strincidencias." | ".$row[1];
                            }
                                $horakm=$row[1];

                        }
            
                        
                        $horaold=$row[1];
                        $latanterior=$row[2];
                        $lonanterior=$row[3];
			}


                        $cont++;
             ECHO'<td>'.$cantincidencias.'</td></tr>';

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


