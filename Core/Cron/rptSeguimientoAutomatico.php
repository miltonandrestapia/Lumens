<?php

    require_once("../Procesamiento/Conexion.php");
 
 

             $consulta="SELECT DISTINCT(a.usuario),a.nombre,a.token_notif,a.unidad_negocio,z.email  FROM ((tracking t INNER JOIN agentes a ON a.usuario=t.usuario ) INNER JOIN zonas z ON z.codigo=a.sector)
            WHERE t.fecha=CURDATE() AND hora >=DATE_ADD(NOW(), INTERVAL -2 MINUTE)  ORDER BY a.unidad_negocio ,a.nombre"; 
           




	$cont=1;
	$imei="";
	$correos="";
$correosEspEnel="";

	$d1=mysqli_query($mysqli,$consulta);
	while($r1=mysqli_fetch_row($d1)){ 
              
 



              $consulta="SELECT usuario,hora,lat,lon,equipo FROM tracking WHERE 
              fecha=CURDATE() AND usuario='".$r1[0]."'  AND hora >=DATE_ADD(NOW(), INTERVAL -2 MINUTE)   ORDER BY hora DESC "; 


            $datos=mysqli_query($mysqli,$consulta); 
            $latanterior="";
            $lonanterior="";
            $horaold="";
            $horakm="";
            $strincidencias="";
            $cantincidencias=0;

            $kmh=0;
            $kmultimo=0;
            while($row=mysqli_fetch_row($datos)){ 
            $imei=$row[4]; 

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
                            
                        if($kmh>60){
                            if($horaold==$horakm){ 

                                $cantincidencias++; 
            						$kmultimo=$kmh;
                            }
                                $horakm=$row[1];

                        }
            
                        
                        $horaold=$row[1];
                        $latanterior=$row[2];
                        $lonanterior=$row[3];
      }
                            if($cantincidencias>0){  
                            	if ($kmultimo<100) {

	 								sendGCM("Maneje con moderación, alta velocidad detectada." , "ALERTA POR EXCESO DE VELOCIDAD ".$kmultimo." Km/h", $r1[2]);

									if($r1[3]=="ENEL CODENSA"){
										$correos.= "  ".$r1[3]."-".$r1[1]." ".$kmultimo."  \n";
									}
									if($r1[3]=="ENEL REPARTO ESPECIAL"){
										$correosEspEnel.= "  ".$r1[3]."-".$r1[1]." ".$kmultimo."  \n";
									}
                                    if ($r1[4]!="") {

                            ini_set("soap.wsdl_cache_enabled", "0");
                            $cliente = new SoapClient("https://www.lecta.com.co/wservices/Correos/WebService.php?wsdl");
                            $cuenta =  array("DESTINATARIO" =>$r1[4],"MENSAJE" => $r1[3]."-".$r1[1]." ".$kmultimo,
                            "ASUNTO" => "REPORTE DE VELOCIDAD","EHEADER" => "EHEADER");
                            $result = $cliente->__SoapCall('WebServiceCorreos', $cuenta);  
                                    }
              						 
                            	}
                            }

 
 }






if($correos!=""){

//deshabilitar cache
ini_set("soap.wsdl_cache_enabled", "0");
//iniciar cliente soap
//escribir la dirección donde se encuentra el servicio
$cliente = new SoapClient("https://www.lecta.com.co/wservices/Correos/WebService.php?wsdl"); 
//establecer parametros de envío
$cuenta =  array("DESTINATARIO" => "auxadmin2enel.bog@lecta.com.co;tecnicocopilotoenel.bog@lecta.com.co; COORDINADORENEL.BOG@LECTA.COM.CO;prevencionistasslenel.bog@lecta.com.co","MENSAJE" =>$correos,"ASUNTO" => "REPORTE DE VELOCIDAD LUMENS"
,"EHEADER" => "EHEADER");
$result = $cliente->__SoapCall('WebServiceCorreos', $cuenta);	
//llamar a la función raiz cuadrada y guardar el resultado 
//imprimir primer resultado

echo $result->RESPUESTA;
}
 
if($correosEspEnel!=""){

//deshabilitar cache
ini_set("soap.wsdl_cache_enabled", "0");
//iniciar cliente soap
//escribir la dirección donde se encuentra el servicio
$cliente = new SoapClient("https://www.lecta.com.co/wservices/Correos/WebService.php?wsdl"); 
//establecer parametros de envío
$cuenta =  array("DESTINATARIO" => "auxadmin2enel.bog@lecta.com.co;tecnicocopilotoenel.bog@lecta.com.co; COORDINADORENEL.BOG@LECTA.COM.CO;prevencionistasslenel.bog@lecta.com.co","MENSAJE" =>$correosEspEnel,"ASUNTO" => "REPORTE DE VELOCIDAD LUMENS REPARTO ESPECIAL"
,"EHEADER" => "EHEADER");
$result = $cliente->__SoapCall('WebServiceCorreos', $cuenta);	
//llamar a la función raiz cuadrada y guardar el resultado 
//imprimir primer resultado

echo $result->RESPUESTA;
}
 


//	sendGCM("Maneje con moderación, alta velocidad detectada." , "ALERTA POR EXCESO DE VELOCIDAD 62 Km/h", "cC4D2AUQ-ZM:APA91bEVQNWlSAYSGWRJTwM4T6TP8u1QkxgayRUAUqWBuT_eIiNYdNfvk0m_KBgV8BfxW2FLH3VFQzFwAgEAN8BZjtY2zlJ250V5-Fce32HMw6fZUHa_PiqLDgPeTQiUAuKd-BBOKTbi");
              					

            
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


function sendGCM ( $m, $t, $r){
    // API access key from Google API's Console
        if (!defined('API_ACCESS_KEY')) define( 'API_ACCESS_KEY', 'AAAAaSpvWag:APA91bE2KRx8TXR-zhtWscfqoHxnvGxwYfPZhxbSY4K4jTPqHbXVrk_loogVVLBlmi4IqcAtbqPubToC3Jnq6t6_5Nx8jeW8KEzgHys8iE4DLeK-jcLKEfYAF77LXR1_LQKVZF0lICD4' );
        $tokenarray = array($r);
        // prep the bundle
        $msg = array
        (
            'title'     => $t,
            'body'     => $m 

        );
        $fields = array
        (
            'registration_ids'     => $tokenarray,
            'notification'            => $msg
        );

        $headers = array
        (
            'Authorization: key=' . API_ACCESS_KEY,
            'Content-Type: application/json'
        );

        $ch = curl_init();
        curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
        $result = curl_exec($ch );
        curl_close( $ch );
        return $result;
    }  
 
?>


