
<?php

session_start();     

require_once("Procesamiento/Conexion.php");


     $consulta="SET  time_zone = 'America/Bogota'"; 
     $datos=mysqli_query($mysqli,$consulta);    
     
     $consulta="SELECT now() "; 
     $datos=mysqli_query($mysqli,$consulta);       

  while($row=mysqli_fetch_row($datos)){ 

echo ''.$row[0];
  }



?>

