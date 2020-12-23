<?php

require_once("../back/Conexion.php");
  if($_POST["Action"]=='Login' AND isset($_POST["usuario"])){
					logearse($mysqli);							
	}elseif ($_POST["Action"]=='Tracking') {
    Tracking($mysqli);  
  }elseif ($_POST["Action"]=='Notificacion') {
    Notificacion($mysqli);  
  }elseif ($_POST["Action"]=='Publicidad') {
    Publicidad($mysqli);  
  }elseif ($_POST["Action"]=='listaNotificacion') {
    listaNotificacion($mysqli);  
  }elseif ($_POST["Action"]=='listaAsignaciones') {
    listaAsignaciones($mysqli);  
  }else{
   http_response_code(400);
    $array=array();
    $array['estado']="400";
    header('Content-type: application/json');
    echo json_encode($array);
  }
   
 //*** Buscar Planilla especifica
  function listaAsignaciones($mysqli){

      $Busqueda="SELECT codactividad,destinatario,direccion,c.nombre as ciudad,d.nombre as depto,p.cliente as cliente,referencia1,referencia2,referencia3,referencia4,referencia5,ruta,ordenamiento,a.tipo as tipoactividad,a.soporte as tiposoporte,a.observaciones as observaciones FROM (((principal p INNER JOIN ciudades c ON c.cons=p.codciudad) INNER JOIN departamentos d ON d.cons=p.coddepartamento) inner join actividad a on a.cons=p.codactividad) WHERE codagente='".mysqli_real_escape_string($mysqli,$_POST["listanUsuario"])."' AND a.estado='Activo' AND fechaactividad=CURDATE() order by ordenamiento,cons  ";

        $responseArray = array();
        $sql=mysqli_query($mysqli,$Busqueda);

          while( $row=mysqli_fetch_row($sql) ){         
            $Datos=array('codactividad'=>$row[0], 
              'destinatario'=>$row[1], 
              'direccion'=>$row[2], 
              'ciudad'=>$row[3], 
              'depto'=>$row[4], 
              'cliente'=>$row[5], 
              'referencia1'=>$row[6], 
              'referencia2'=>$row[7], 
              'referencia3'=>$row[8], 
              'referencia4'=>$row[9], 
              'referencia5'=>$row[10], 
              'ruta'=>$row[11], 
              'ordenamiento'=>$row[12], 
              'tipoactividad'=>$row[13], 
              'tiposoporte'=>$row[14], 
              'observaciones'=>$row[15]
            );
            array_push($responseArray,$Datos);        
          }

          header('Content-type: application/json');
            header(':', true, 200);         
          $array=array();
            $array['mensaje']=($responseArray);
            echo json_encode($array);
  }



	function listaNotificacion($mysqli){


				$Busqueda="SELECT encabezado,descripcion,fechacarga FROM notificaciones WHERE 
				codempresa='".mysqli_real_escape_string($mysqli,$_POST["listanEmpresa"])."' AND 
				(rango='".mysqli_real_escape_string($mysqli,$_POST["listanUsuario"])."' or rango='') order by fechacarga desc ";
				$responseArray = array();
				$sql=mysqli_query($mysqli,$Busqueda);

					while( $row=mysqli_fetch_row($sql) ){					
						$Datos=array('Titulo'=>$row[0], 'Descripcion'=>$row[1], 'Fecha'=>$row[2]);
						array_push($responseArray,$Datos);				
					}

					header('Content-type: application/json');
				   	header(':', true, 200);					
					$array=array();
			     	$array['mensaje']=($responseArray);
			    	echo json_encode($array);
	}



function Notificacion($mysqli){
     $consulta="UPDATE  agentes SET
    token_notif='".mysqli_real_escape_string($mysqli,$_POST["not_token"])."'
    where usuario='".mysqli_real_escape_string($mysqli,$_POST["not_usuario"])."'"; 
    if($datos=mysqli_query($mysqli,$consulta)){
    header(':', true, 200);
    $array=array();
    $array['mensaje']="Guardado";
    header('Content-type: application/json');
    echo json_encode($array);
     }else{
        header(':', true, 401);
      $array=array();
      $array['mensaje']="No Guardado";
      header('Content-type: application/json');
      echo json_encode($array);
     }
  

}
        
function Publicidad($mysqli){
 
$consulta="INSERT publicidad(usuario,hora,red,lat,lon,bateria,carga,bluet,equipo,fecha) values(
'".mysqli_real_escape_string($mysqli,$_POST["trk_usuario"])."',
'".mysqli_real_escape_string($mysqli,$_POST["trk_hora"])."',
'".mysqli_real_escape_string($mysqli,$_POST["trk_red"])."',
'".mysqli_real_escape_string($mysqli,$_POST["trk_lat"])."',
'".mysqli_real_escape_string($mysqli,$_POST["trk_lon"])."',
'".mysqli_real_escape_string($mysqli,$_POST["trk_bateria"])."',
'".mysqli_real_escape_string($mysqli,$_POST["trk_carga"])."',
'".mysqli_real_escape_string($mysqli,$_POST["trk_bluet"])."',
'".mysqli_real_escape_string($mysqli,$_POST["trk_equipo"])."',curdate())"; 

  if( $datos=mysqli_query($mysqli,$consulta) ){   

 
$consulta2="UPDATE agentes SET fechapublicidad=CURDATE() 
WHERE usuario='".mysqli_real_escape_string($mysqli,$_POST["trk_usuario"])."'"; 
 $datos2=mysqli_query($mysqli,$consulta2);  

    header(':', true, 200);
    $array=array();
    $array['mensaje']="Guardado";
    header('Content-type: application/json');
    echo json_encode($array);

  }else{

    header(':', true, 401);
    $array=array();
    $array['mensaje']="No Guardado";
    header('Content-type: application/json');
    echo json_encode($array);
  }

}

function Tracking($mysqli){
 
$consulta="INSERT tracking(usuario,hora,red,lat,lon,bateria,carga,bluet,equipo,fecha) values(
'".mysqli_real_escape_string($mysqli,$_POST["trk_usuario"])."',
'".mysqli_real_escape_string($mysqli,$_POST["trk_hora"])."',
'".mysqli_real_escape_string($mysqli,$_POST["trk_red"])."',
'".mysqli_real_escape_string($mysqli,$_POST["trk_lat"])."',
'".mysqli_real_escape_string($mysqli,$_POST["trk_lon"])."',
'".mysqli_real_escape_string($mysqli,$_POST["trk_bateria"])."',
'".mysqli_real_escape_string($mysqli,$_POST["trk_carga"])."',
'".mysqli_real_escape_string($mysqli,$_POST["trk_bluet"])."',
'".mysqli_real_escape_string($mysqli,$_POST["trk_equipo"])."',curdate())"; 

  if( $datos=mysqli_query($mysqli,$consulta) ){   
    $consulta="UPDATE  agentes SET
    lat='".mysqli_real_escape_string($mysqli,$_POST["trk_lat"])."',
    lon='".mysqli_real_escape_string($mysqli,$_POST["trk_lon"])."',
    fechageo=now() where usuario='".mysqli_real_escape_string($mysqli,$_POST["trk_usuario"])."'"; 
    $datos=mysqli_query($mysqli,$consulta);      
    header(':', true, 200);
    $array=array();
    $array['mensaje']="Guardado";
    header('Content-type: application/json');
    echo json_encode($array);
     

  }else{
    $consulta="INSERT tracking(usuario,fecha) 
    values('".mysqli_real_escape_string($mysqli,$_POST["trk_usuario"])."',curdate())"; 
  $datos=mysqli_query($mysqli,$consulta);

    header(':', true, 401);
    $array=array();
    $array['mensaje']="No Guardado";
    header('Content-type: application/json');
    echo json_encode($array);
  }

}
											
function logearse($mysqli){


   $consulta="SELECT  nombre,usuario,tipo,codempresa FROM usuarios 
  WHERE  usuario='".mysqli_real_escape_string($mysqli,$_POST["usuario"])."' 
  AND pass='".mysqli_real_escape_string($mysqli,$_POST["pass"])."' AND estado='Activo' AND tipo='Agente'  "; 

$datos=mysqli_query($mysqli,$consulta);

            if($row=mysqli_fetch_row($datos)){ 

				   http_response_code(200);

				    $array=array();
				    $array['estado']="200";
				    $array['nombreUsuario']=$row[0];
				    $array['codigoEmpresa']=$row[3];
				    header('Content-type: application/json');
				    echo json_encode($array);
               
          }else{
      $array=array();
      $array['estado']="401";
     header('Content-type: application/json');
    header("HTTP/1.0 404 Not Found");
     echo json_encode($array);
          }
}

?>