<?php

class pointLocation {
    var $pointOnVertex = true; // Check if the point sits exactly on one of the vertices?

    function pointLocation() {
    }

    function pointInPolygon($point, $polygon, $pointOnVertex = true) {
        $this->pointOnVertex = $pointOnVertex;

        // Transform string coordinates into arrays with x and y values
        $point = $this->pointStringToCoordinates($point);
        $vertices = array(); 
        foreach ($polygon as $vertex) {
            $vertices[] = $this->pointStringToCoordinates($vertex); 
        }

        // Check if the point sits exactly on a vertex
        if ($this->pointOnVertex == true and $this->pointOnVertex($point, $vertices) == true) {
            return "vertex";
        }

        // Check if the point is inside the polygon or on the boundary
        $intersections = 0; 
        $vertices_count = count($vertices);

        for ($i=1; $i < $vertices_count; $i++) {
            $vertex1 = $vertices[$i-1]; 
            $vertex2 = $vertices[$i];
            if ($vertex1['y'] == $vertex2['y'] and $vertex1['y'] == $point['y'] and $point['x'] > min($vertex1['x'], $vertex2['x']) and $point['x'] < max($vertex1['x'], $vertex2['x'])) { // Check if point is on an horizontal polygon boundary
                return "boundary";
            }
            if ($point['y'] > min($vertex1['y'], $vertex2['y']) and $point['y'] <= max($vertex1['y'], $vertex2['y']) and $point['x'] <= max($vertex1['x'], $vertex2['x']) and $vertex1['y'] != $vertex2['y']) { 
                $xinters = ($point['y'] - $vertex1['y']) * ($vertex2['x'] - $vertex1['x']) / ($vertex2['y'] - $vertex1['y']) + $vertex1['x']; 
                if ($xinters == $point['x']) { // Check if point is on the polygon boundary (other than horizontal)
                    return "boundary";
                }
                if ($vertex1['x'] == $vertex2['x'] || $point['x'] <= $xinters) {
                    $intersections++; 
                }
            } 
        } 
        // If the number of edges we passed through is odd, then it's in the polygon. 
        if ($intersections % 2 != 0) {
            return "adentro";
        } else {
            return "afuera";
        }
    }

    function pointOnVertex($point, $vertices) {
        foreach($vertices as $vertex) {
            if ($point == $vertex) {
                return true;
            }
        }

    }

    function pointStringToCoordinates($pointString) {
        $coordinates = explode(" ", $pointString);
        return array("x" => $coordinates[0], "y" => $coordinates[1]);
    }

}





if(date("H")<18){

$pointLocation = new pointLocation();




session_start();     
require_once("../Procesamiento/Conexion.php"); 


 
$correos="";
$correosEspEnel="";
$consulta="SELECT lat,lon,nombre,sector,token_notif,Departamento,usuario,unidad_negocio FROM agentes 
WHERE sesionfin IS NULL AND fechageo >=DATE_ADD(NOW(), INTERVAL -2 MINUTE)  ORDER BY unidad_negocio"; 

     $datos=mysqli_query($mysqli,$consulta);       


while($row=mysqli_fetch_row($datos)){  
	$points = array($row[1]." ".$row[0] );

$polygon = array( );
$emailzona="";
  $consultaz="SELECT cons,nombre,poligono,codigo,email FROM zonas where codigo='".$row[3]."' "; 
  $datosz=mysqli_query($mysqli,$consultaz);       
  if($rowz=mysqli_fetch_row($datosz)){
    $emailzona=$rowz[4];
  	$poligonobruto=$rowz[2];
  	$poligonobruto=explode("}", $poligonobruto);

  	$i=0;
  	while ($i < (count($poligonobruto)-1)) { 
  		$cadapunto=$poligonobruto[$i];
  		$cadapunto = preg_replace('/[^A-Za-z0-9.-]/', '', $cadapunto);
  		$cadapunto=str_replace("lng", "", $cadapunto);
  		$cadapunto=str_replace("lat", ",", $cadapunto); 
  		$cadapunto=str_replace(" ", "", $cadapunto);
  		$cadapunto=str_replace(",", " ", $cadapunto); 
  		array_push($polygon,  $cadapunto);
		$i++;
  	} 

 
	foreach($points as $key => $point) {
			if($pointLocation->pointInPolygon($point, $polygon)=="afuera"){ 
				echo "<br>".$row[2]." - ".$row[5]." Zona: ".$row[3]."(".$row[1]." ".$row[0].")";

		$consultx=" INSERT registrofueradezona(codagente,valor,zona1,fecha,fechahora )
        VALUES('".$row[6]."','".$row[1]." ".$row[0]."','".$row[3]."',curdate(),now()) "; 
 
  			if( $datosx=mysqli_query($mysqli,$consultx)){   
	            sendGCM("Detectamos que se encuentra fuera de zona de labor asignada." , "ALERTA POR UBICACIÓN NO PERMITIDA", $row[4]);
	            //sendGCM($row[2]."Por favor regrese a su zona asignada." , "ALERTA POSICIÓN NO PERMITIDA DETECTADA","cC4D2AUQ-ZM:APA91bEVQNWlSAYSGWRJTwM4T6TP8u1QkxgayRUAUqWBuT_eIiNYdNfvk0m_KBgV8BfxW2FLH3VFQzFwAgEAN8BZjtY2zlJ250V5-Fce32HMw6fZUHa_PiqLDgPeTQiUAuKd-BBOKTbi");
              				

							if($row[7]=="ENEL CODENSA"){
									$correos.= "  ".$row[7]."-". $row[2]."  \n";
							}
							if($row[7]=="ENEL REPARTO ESPECIAL"){
									$correosEspEnel.= "  ".$row[7]."-". $row[2]."  \n";
							}


                            if($emailzona!=""){
                            ini_set("soap.wsdl_cache_enabled", "0");
                            $cliente = new SoapClient("https://www.lecta.com.co/wservices/Correos/WebService.php?wsdl");
                            $cuenta =  array("DESTINATARIO" =>$emailzona,"MENSAJE" => $row[7]."-". $row[2] ,
                            "ASUNTO" => "REPORTE DE FUERA DE ZONA","EHEADER" => "EHEADER");
                            $result = $cliente->__SoapCall('WebServiceCorreos', $cuenta);    
                            }


 
	          } 
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
	$cuenta =  array("DESTINATARIO" => "tecnicocopilotoenel.bog@lecta.com.co;COORDINADORENEL.BOG@LECTA.COM.CO;prevencionistasslenel.bog@lecta.com.co","MENSAJE" =>$correos,"ASUNTO" => "REPORTE DE FUERA DE ZONA"
	,"EHEADER" => "EHEADER");
	$result = $cliente->__SoapCall('WebServiceCorreos', $cuenta);	
	//llamar a la función raiz cuadrada y guardar el resultado |
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
	$cuenta =  array("DESTINATARIO" => "auxadmin2enel.bog@lecta.com.co;tecnicocopilotoenel.bog@lecta.com.co;COORDINADORENEL.BOG@LECTA.COM.CO;prevencionistasslenel.bog@lecta.com.co","MENSAJE" =>$correosEspEnel,"ASUNTO" => "REPORTE DE FUERA DE ZONA REPARTO ESPECIAL"
	,"EHEADER" => "EHEADER");
	$result = $cliente->__SoapCall('WebServiceCorreos', $cuenta);	
	//llamar a la función raiz cuadrada y guardar el resultado |
	//imprimir primer resultado

	echo $result->RESPUESTA;
}






}else{
echo date("H");
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



//$points = array("50 70","70 40","-20 30","100 10","-10 -10","40 -20","110 -20");
/*

$polygon = array("-50 30","50 70","100 50","80 10","110 -10","110 -30","-20 -50","-30 -40","10 -10","-10 10","-30 -20","-50 30");
// The last point's coordinates must be the same as the first one's, to "close the loop"
foreach($points as $key => $point) {
    echo "point " . ($key+1) . " ($point): " . $pointLocation->pointInPolygon($point, $polygon) . "<br>";
}*/


?>