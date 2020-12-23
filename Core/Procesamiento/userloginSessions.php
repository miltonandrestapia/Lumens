<?php


  if( isset($_POST["DeptoUpdate"])) {
      session_start();
        $_SESSION['LMNS_dpto'] = $_POST["DepaDrop"];	   
             
    } elseif (isset($_POST["LMNS_unidadUpdate"])) {
      session_start();
        $_SESSION['LMNS_unidad'] = $_POST["uniDrop"];   
    }
    
 
   

?>