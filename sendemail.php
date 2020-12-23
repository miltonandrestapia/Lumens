<?php
//deshabilitar cache
ini_set("soap.wsdl_cache_enabled", "0");
 
//iniciar cliente soap
//escribir la dirección donde se encuentra el servicio
$cliente = new SoapClient("https://www.lecta.com.co/wservices/Correos/WebService.php?wsdl"); 
//establecer parametros de envío
$cuenta =  array("DESTINATARIO" => "coordsistemas.baq@lecta.com.co","MENSAJE" =>"MI MENSAJE","ASUNTO" => "MI ASUNTO"
,"EHEADER" => "EHEADER");
$result = $cliente->__SoapCall('WebServiceCorreos', $cuenta);	
//llamar a la función raiz cuadrada y guardar el resultado 
//imprimir primer resultado

echo $result->RESPUESTA;
?>
