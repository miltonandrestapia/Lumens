<?php


    header('Access-Control-Allow-Origin: *');
require_once("../back/Conexion.php");


echo date("H");


if(date("H")<17){
echo 'date_default_timezone_set: ' . date_default_timezone_get() . '<br />';
}


?>