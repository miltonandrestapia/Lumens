<?php


		header('Access-Control-Allow-Origin: *');
		require_once("../back/Conexion.php");


		if(isset($_POST["Action"])){

			  if($_POST["Action"]=='Login'){
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
			  }elseif ($_POST["Action"]=='recibeGestion') {
			    recibeGestion($mysqli);  
			  }elseif ($_POST["Action"]=='recibeSoporte') {
			    recibeSoporte($mysqli);  
			  }elseif ($_POST["Action"]=='Loginlite') {
			    logearselite($mysqli);  
			  }elseif ($_POST["Action"]=='CEPO') {
			    cepo($mysqli);  
			  }elseif ($_POST["Action"]=='listaFuncionarios') {
			    listaFuncionarios($mysqli);  
			  }elseif ($_POST["Action"]=='listaNotificaciones') {
			    listaNotificaciones($mysqli);  
			  }elseif ($_POST["Action"]=='recibeNotificacion') {
			    recibeNotificacion($mysqli); 
			  }elseif ($_POST["Action"]=='cierraSesion') {
			    CierraSesion($mysqli); 
			  }elseif ($_POST["Action"]=='recibeVersion') {
			    recibeVersion($mysqli); 
			  }elseif ($_POST["Action"]=='Tracking2') {
			    Tracking2($mysqli);  
			  }elseif ($_POST["Action"]=='RespProyectoEspEnel') {
			    recibeGestionEspEnel($mysqli);  
			  }elseif ($_POST["Action"]=='consultaVehiculosEnel') {
			    consultaVehiculosEnel($mysqli);  
			  }elseif ($_POST["Action"]=='guardaVehiculosEnel') {
			    guardaVehiculosEnel($mysqli);  
			  }elseif ($_POST["Action"]=='guardaEnelPreoperacional') {
			    guardaEnelPreoperacional($mysqli);  
			  }else{
			    $array=array();
			    $array['estado']="400";
			    header('Content-type: application/json');
			    echo json_encode($array);
			  }  

	  }else{
	    $array=array();
	    $array['estado']="400";
	    header('Content-type: application/json');
	    echo json_encode($array);
	  }  
		


function guardaEnelPreoperacional($mysqli){
  



   $consulta="SELECT fecha FROM enelpreopperacionalmotos WHERE 
   codagente='".mysqli_real_escape_string($mysqli,$_POST["codagente"])."' AND fecha=CURDATE() "; 
	$datos=mysqli_query($mysqli,$consulta);

            if(!$row=mysqli_fetch_row($datos)){ 


$consulta="INSERT INTO enelpreopperacionalmotos
            (fecha,codagente,e1,e2,e3,e4,e5,e6,e7,e8,e9,e10,e11,e12,e13,e14,e15,e16,e17,e18,e19,e20,e21,d1,d2,d3,d4,d5,d6,d7,s1,s2,s3,s4,s5,s6,n1,n2,n3,n4,n5,n6,apto,noapto,obs1,obs2,obs3,obs4,obs5,obs6,obs7,obs8,obs9,obs10,obs11,obs12,obs13,obs14,obs15,obs16,obs17,obs18,obs19,obs20,obs21,obs22,obs23,obs24,obs25,obs26,obs27,obs28,obs29,obs30,obs31,obs32,obs33,obs36)
VALUES ( curdate(),
       '".mysqli_real_escape_string($mysqli,$_POST["codagente"])."',
       '".mysqli_real_escape_string($mysqli,$_POST["e1"])."',
       '".mysqli_real_escape_string($mysqli,$_POST["e2"])."',
       '".mysqli_real_escape_string($mysqli,$_POST["e3"])."',
       '".mysqli_real_escape_string($mysqli,$_POST["e4"])."',
       '".mysqli_real_escape_string($mysqli,$_POST["e5"])."',
       '".mysqli_real_escape_string($mysqli,$_POST["e6"])."',
       '".mysqli_real_escape_string($mysqli,$_POST["e7"])."',
       '".mysqli_real_escape_string($mysqli,$_POST["e8"])."',
       '".mysqli_real_escape_string($mysqli,$_POST["e9"])."',
       '".mysqli_real_escape_string($mysqli,$_POST["e10"])."',
       '".mysqli_real_escape_string($mysqli,$_POST["e11"])."',
       '".mysqli_real_escape_string($mysqli,$_POST["e12"])."',
       '".mysqli_real_escape_string($mysqli,$_POST["e13"])."',
       '".mysqli_real_escape_string($mysqli,$_POST["e14"])."',
       '".mysqli_real_escape_string($mysqli,$_POST["e15"])."',
       '".mysqli_real_escape_string($mysqli,$_POST["e16"])."',
       '".mysqli_real_escape_string($mysqli,$_POST["e17"])."',
       '".mysqli_real_escape_string($mysqli,$_POST["e18"])."',
       '".mysqli_real_escape_string($mysqli,$_POST["e19"])."',
       '".mysqli_real_escape_string($mysqli,$_POST["e20"])."',
       '".mysqli_real_escape_string($mysqli,$_POST["e21"])."',
       '".mysqli_real_escape_string($mysqli,$_POST["d1"])."',
       '".mysqli_real_escape_string($mysqli,$_POST["d2"])."',
       '".mysqli_real_escape_string($mysqli,$_POST["d3"])."',
       '".mysqli_real_escape_string($mysqli,$_POST["d4"])."',
       '".mysqli_real_escape_string($mysqli,$_POST["d5"])."',
       '".mysqli_real_escape_string($mysqli,$_POST["d6"])."',
       '".mysqli_real_escape_string($mysqli,$_POST["d7"])."',
       '".mysqli_real_escape_string($mysqli,$_POST["s1"])."',
       '".mysqli_real_escape_string($mysqli,$_POST["s2"])."',
       '".mysqli_real_escape_string($mysqli,$_POST["s3"])."',
       '".mysqli_real_escape_string($mysqli,$_POST["s4"])."',
       '".mysqli_real_escape_string($mysqli,$_POST["s5"])."',
       '".mysqli_real_escape_string($mysqli,$_POST["s6"])."', 
       '".mysqli_real_escape_string($mysqli,$_POST["n1"])."',
       '".mysqli_real_escape_string($mysqli,$_POST["n2"])."',
       '".mysqli_real_escape_string($mysqli,$_POST["n3"])."',
       '".mysqli_real_escape_string($mysqli,$_POST["n4"])."',
       '".mysqli_real_escape_string($mysqli,$_POST["n5"])."',
       '".mysqli_real_escape_string($mysqli,$_POST["n6"])."',
       '".mysqli_real_escape_string($mysqli,$_POST["apto"])."',
       '".mysqli_real_escape_string($mysqli,$_POST["noapto"])."',
       '".mysqli_real_escape_string($mysqli,$_POST["obs1"])."',
       '".mysqli_real_escape_string($mysqli,$_POST["obs2"])."',
       '".mysqli_real_escape_string($mysqli,$_POST["obs3"])."',
       '".mysqli_real_escape_string($mysqli,$_POST["obs4"])."',
       '".mysqli_real_escape_string($mysqli,$_POST["obs5"])."',
       '".mysqli_real_escape_string($mysqli,$_POST["obs6"])."',
       '".mysqli_real_escape_string($mysqli,$_POST["obs7"])."',
       '".mysqli_real_escape_string($mysqli,$_POST["obs8"])."',
       '".mysqli_real_escape_string($mysqli,$_POST["obs9"])."',
       '".mysqli_real_escape_string($mysqli,$_POST["obs10"])."',
       '".mysqli_real_escape_string($mysqli,$_POST["obs11"])."',
       '".mysqli_real_escape_string($mysqli,$_POST["obs12"])."',
       '".mysqli_real_escape_string($mysqli,$_POST["obs13"])."',
       '".mysqli_real_escape_string($mysqli,$_POST["obs14"])."',
       '".mysqli_real_escape_string($mysqli,$_POST["obs15"])."',
       '".mysqli_real_escape_string($mysqli,$_POST["obs16"])."',
       '".mysqli_real_escape_string($mysqli,$_POST["obs17"])."',
       '".mysqli_real_escape_string($mysqli,$_POST["obs18"])."',
       '".mysqli_real_escape_string($mysqli,$_POST["obs19"])."',
       '".mysqli_real_escape_string($mysqli,$_POST["obs20"])."',
       '".mysqli_real_escape_string($mysqli,$_POST["obs21"])."',
       '".mysqli_real_escape_string($mysqli,$_POST["obs22"])."',
       '".mysqli_real_escape_string($mysqli,$_POST["obs23"])."',
       '".mysqli_real_escape_string($mysqli,$_POST["obs24"])."',
       '".mysqli_real_escape_string($mysqli,$_POST["obs25"])."',
       '".mysqli_real_escape_string($mysqli,$_POST["obs26"])."',
       '".mysqli_real_escape_string($mysqli,$_POST["obs27"])."',
       '".mysqli_real_escape_string($mysqli,$_POST["obs28"])."',
       '".mysqli_real_escape_string($mysqli,$_POST["obs29"])."',
       '".mysqli_real_escape_string($mysqli,$_POST["obs30"])."',
       '".mysqli_real_escape_string($mysqli,$_POST["obs31"])."',
       '".mysqli_real_escape_string($mysqli,$_POST["obs32"])."', 
       '".mysqli_real_escape_string($mysqli,$_POST["obs33"])."',
       '".mysqli_real_escape_string($mysqli,$_POST["obs36"])."');"; 
		  if( $datos=mysqli_query($mysqli,$consulta) ){   
		 

		    $array=array();
		    $array['mensaje']="Guardado";
		    header('Content-type: application/json');
		    echo json_encode($array);
		     
		  }else{ 
		    $array=array();
		    $array['mensaje']="No Guardado";
		    header('Content-type: application/json');
		    echo json_encode($array);
		  }
       
  }else{ 
    $array=array();
    $array['mensaje']="Ya Guardado Hoy";
    header('Content-type: application/json');
    echo json_encode($array);
  }


}	



function guardaVehiculosEnel($mysqli){
  
$consulta="REPLACE INTO eneldatosvehiculo (codagente,placa,marca,modelo,fechavencimientosoat,licencia,fechavencimientolicencia,licenciatrancito,fechavencimientotecnomecanica,fechaguardado)
values (
'".mysqli_real_escape_string($mysqli,$_POST["vehiculosEnelCodagente"])."', 
'".mysqli_real_escape_string($mysqli,strtoupper($_POST["vehiculosEnelPlaca"]))."', 
'".mysqli_real_escape_string($mysqli,strtoupper($_POST["vehiculosEnelMarca"]))."', 
'".mysqli_real_escape_string($mysqli,strtoupper($_POST["vehiculosEnelModelo"]))."', 
'".mysqli_real_escape_string($mysqli,$_POST["vehiculosEnelFechavencimientosoat"])."', 
'".mysqli_real_escape_string($mysqli,$_POST["vehiculosEnelLicencia"])."', 
'".mysqli_real_escape_string($mysqli,$_POST["vehiculosEnelFechavencimientolicencia"])."', 
'".mysqli_real_escape_string($mysqli,$_POST["vehiculosEnelLicenciatrancito"])."', 
'".mysqli_real_escape_string($mysqli,$_POST["vehiculosEnelFechavencimientotecnomecanica"])."',curdate()) "; 
  if( $datos=mysqli_query($mysqli,$consulta) ){   
 

    $array=array();
    $array['mensaje']="Guardado";
    header('Content-type: application/json');
    echo json_encode($array);
     
  }else{ 
    $array=array();
    $array['mensaje']="No Guardado";
    header('Content-type: application/json');
    echo json_encode($array);
  }


}




function consultaVehiculosEnel($mysqli){


   $consulta="SELECT placa,marca,modelo,fechavencimientosoat,licencia,fechavencimientolicencia,licenciatrancito,fechavencimientotecnomecanica FROM eneldatosvehiculo WHERE codagente='".mysqli_real_escape_string($mysqli,$_POST["codAgente"])."' "; 
	$datos=mysqli_query($mysqli,$consulta);

            if($row=mysqli_fetch_row($datos)){ 
					$array=array(); 
					$array['placa']=$row[0];
					$array['marca']=$row[1];
					$array['modelo']=$row[2];
					$array['fechavencimientosoat']=$row[3];
					$array['licencia']=$row[4];
					$array['fechavencimientolicencia']=$row[5];
					$array['licenciatrancito']=$row[6];
					$array['fechavencimientotecnomecanica']=$row[7];
					$array['versionmovil']=$row[8]; 

						$realizadahoy="NO";
						$consulta="SELECT fecha FROM enelpreopperacionalmotos WHERE 
						codagente='".mysqli_real_escape_string($mysqli,$_POST["codAgente"])."' AND fecha=CURDATE() "; 
						$datos=mysqli_query($mysqli,$consulta);
						if($row=mysqli_fetch_row($datos)){  
								$realizadahoy="SI";
						}


					$array['realizoHoy']=$realizadahoy; 
					header('Content-type: application/json');
					echo json_encode($array);
               
          }else{
			$array=array();
			$array['estado']="400";
			header('Content-type: application/json');
			echo json_encode($array);
          }
}




function recibeGestionEspEnel($mysqli){
 
   $Busqueda="SELECT estado,codactividad,codagente FROM proyectoespecialenel  WHERE cons='".mysqli_real_escape_string($mysqli,$_POST["Consespecialenel"])."'  ";
    $responseArray = array();
    $sql=mysqli_query($mysqli,$Busqueda);
	if($row=mysqli_fetch_row($sql)){

		if($row[0]=="Pendiente"){


			$consulta="UPDATE proyectoespecialenel SET 
			fechaestado=curdate(),
			fecharealizado=curdate(),
			fechahorarealizado=now(),
			telefono='".mysqli_real_escape_string($mysqli,$_POST["telefono"])."',
			medidor='".mysqli_real_escape_string($mysqli,$_POST["nomedidor"])."',
			lectura='".mysqli_real_escape_string($mysqli,$_POST["lecturaactual"])."',
			quienrecibe='".mysqli_real_escape_string($mysqli,$_POST["nombrequienrecibe"])."',
			direccioncorrecta='".mysqli_real_escape_string($mysqli,$_POST["direccioncorrecta"])."',
			observaciones='".mysqli_real_escape_string($mysqli,$_POST["observaciones"])."',
			anomalia='".mysqli_real_escape_string($mysqli,$_POST["anomalias"])."',
			latitud='".mysqli_real_escape_string($mysqli,$_POST["latitud"])."',
			longitud='".mysqli_real_escape_string($mysqli,$_POST["longitud"])."',
			fechahoraregistro='".mysqli_real_escape_string($mysqli,$_POST["fechahoraregistro"])."',
			estado='".mysqli_real_escape_string($mysqli,$_POST["estado"])."',
			posicionmedidor='".mysqli_real_escape_string($mysqli,$_POST["posicionmedidor"])."'
			WHERE cons='".mysqli_real_escape_string($mysqli,$_POST["Consespecialenel"])."' "; 

			if( $datos=mysqli_query($mysqli,$consulta) ){ 



						if($_POST["estado"]!="EFECTIVO"){
							$consulta="UPDATE actividad SET noefectivos=noefectivos+1 WHERE 
							cons='".mysqli_real_escape_string($mysqli,$row[1])."' "; 
						}else{
							$consulta="UPDATE actividad SET efectivos=efectivos+1 WHERE 
							cons='".mysqli_real_escape_string($mysqli,$row[1])."' "; 
						}

						if( $datos=mysqli_query($mysqli,$consulta) ){ 

						$consulta1="UPDATE  agentes SET fechavisitas=CURDATE() 
					    where usuario='".mysqli_real_escape_string($mysqli,$row[2])."'"; 
					    $datosx=mysqli_query($mysqli,$consulta1);

						header('Content-type: application/json');
						$array=array();
						$array['mensaje']="Registro Actualizado";
						echo json_encode($array);





						}else{
						    $array=array();
						    $array['mensaje']="No Incrementado";
						    header('Content-type: application/json');
						    echo json_encode($array);
					  	}




			}else{
			    $array=array();
			    $array['mensaje']="No Guardado";
			    header('Content-type: application/json');
			    echo json_encode($array);
		  	}

		}else{
		    $array=array();
		    $array['mensaje']="Ya Gestionado";
		    header('Content-type: application/json');
		    echo json_encode($array);
	  	}
	}else{
	    $array=array();
	    $array['mensaje']="No Existe";
	    header('Content-type: application/json');
	    echo json_encode($array);
  	}

}



function Tracking2($mysqli){

if(date("H")<18){

$valores=explode("|", $_POST["insert"]);

$consulta="INSERT tracking(usuario,hora,red,lat,lon,bateria,carga,bluet,equipo,fecha) 
values ". $valores[0]." "; 
  if( $datos=mysqli_query($mysqli,$consulta) ){   

    $consulta1="UPDATE  agentes SET
    lat='".mysqli_real_escape_string($mysqli,$valores[1])."',
    lon='".mysqli_real_escape_string($mysqli,$valores[2])."',
    ultimageo='".mysqli_real_escape_string($mysqli,$valores[4])."',
    penlat='".mysqli_real_escape_string($mysqli,$valores[5])."',
    penlog='".mysqli_real_escape_string($mysqli,$valores[6])."',
    pengeo='".mysqli_real_escape_string($mysqli,$valores[7])."',
    fechageo=now() where usuario='".mysqli_real_escape_string($mysqli,$valores[3])."'"; 
    $datosx=mysqli_query($mysqli,$consulta1);

    $array=array();
    $array['mensaje']="Guardado";
    header('Content-type: application/json');
    echo json_encode($array);
     
  }else{
    $consulta="INSERT tracking(usuario,fecha) 
    values('".mysqli_real_escape_string($mysqli,$_POST["trk_usuario"])."',curdate())"; 
  $datos=mysqli_query($mysqli,$consulta);

    $array=array();
    $array['mensaje']="No Guardado";
    header('Content-type: application/json');
    echo json_encode($array);
  }
}

}
			
function recibeVersion($mysqli){


   $consulta="SELECT  versionmovil FROM configuraciones  "; 
	$datos=mysqli_query($mysqli,$consulta);

            if($row=mysqli_fetch_row($datos)){ 
					$array=array();
					$array['estado']="200";
					$array['versionmovil']=$row[0];
					header('Content-type: application/json');
					echo json_encode($array);
               
          }else{
			$array=array();
			$array['estado']="400";
			header('Content-type: application/json');
			echo json_encode($array);
          }
}


function CierraSesion($mysqli){

		$consulta="update agentes set sesionfin=NOW()
		WHERE  usuario='".mysqli_real_escape_string($mysqli,$_POST["usuario"])."'  "; 
		$datos=mysqli_query($mysqli,$consulta);

		$array=array();
		$array['estado']="200";
		$array['nombreUsuario']=$row[0];
		$array['codigoEmpresa']=$row[3];
		header('Content-type: application/json');
		echo json_encode($array);
}


function recibeNotificacion($mysqli){
 


			$consulta="INSERT notificaciones(encabezado,rango,descripcion,fechacarga,usuariocarga,tipo)
VALUE(
'".mysqli_real_escape_string($mysqli,$_POST["Titulo"])."',
'".mysqli_real_escape_string($mysqli,$_POST["Funcionario"])."',
'".mysqli_real_escape_string($mysqli,$_POST["Descripcion"])."',
now(),
'".mysqli_real_escape_string($mysqli,$_POST["codAgente"])."','Salida')"; 

			if( $datos=mysqli_query($mysqli,$consulta) ){ 
						header('Content-type: application/json');   
						$array=array();
						$array['mensaje']="Enviado";
						echo json_encode($array);

$consulta="SELECT correo FROM funcionarios WHERE
 usuario='".mysqli_real_escape_string($mysqli,$_POST["Funcionario"])."' "; 
$sql=mysqli_query($mysqli,$consulta);
if( $row=mysqli_fetch_row($sql) ){	

$headers = "From: NUEVO MENSAJE LUMENS <No-Responder@lecta.com.co>\n".
           "Reply-To: No-Responder"."\r\n".
           'X-Mailer: PHP/' . phpversion();
$headers .= "Content-Type: text/plain; charset=UTF-8";
// email de destino
$email = $row[0];
// asunto del email
$subject = "NUEVO MENSAJE LUMENS";
// Cuerpo del mensaje
$mensaje = "NUEVO MENSAJE LUMENS\n";
$mensaje.= " \n \n \n";
$mensaje.= "ENCABEZADO: ".$_POST["Titulo"]." \n";
$mensaje.= "MENSAJE: ".$_POST["Descripcion"]." \n";
$mensaje.= "USUARIO: ".$_POST["codAgente"]." \n\n";
    // Enviamos el mensaje
 mail($email, $subject, utf8_decode($mensaje), $headers);
}




			}else{
			    $array=array();
			    $array['mensaje']="No Enviado";
			    header('Content-type: application/json');
			    echo json_encode($array);
		  	}

}


function listaNotificaciones($mysqli){


				$Busqueda="SELECT encabezado,descripcion,fechacarga FROM notificaciones WHERE  
				usuariocarga='".mysqli_real_escape_string($mysqli,$_POST["listanUsuario"])."' AND tipo='Salida' order by fechacarga desc ";
				$responseArray = array();
				$sql=mysqli_query($mysqli,$Busqueda);

					while( $row=mysqli_fetch_row($sql) ){					
						$Datos=array('Titulo'=>$row[0], 'Descripcion'=>$row[1], 'Fecha'=>$row[2]);
						array_push($responseArray,$Datos);				
					}

					header('Content-type: application/json');			
					$array=array();
			     	$array['mensaje']=($responseArray);
			    	echo json_encode($array);
	}


function listaFuncionarios($mysqli){

$responseArray = array();

$consulta="SELECT usuario,nombre FROM funcionarios WHERE codempresa = (SELECT  codempresa FROM usuarios 
WHERE  usuario='".mysqli_real_escape_string($mysqli,$_POST["usuario"])."'  AND estado='Activo' AND tipo='Agente')  "; 
$sql=mysqli_query($mysqli,$consulta);
while( $row=mysqli_fetch_row($sql) ){					
	$Datos=array('usuario'=>$row[0], 'nombre'=>$row[1]);
	array_push($responseArray,$Datos);			
}


header('Content-type: application/json');

$array=array();
$array['mensaje']=($responseArray);
echo json_encode($array);
}
   
function cepo($mysqli){
 
 $valores=explode("|", $_POST["insert"]);
$consulta="INSERT cepodetalle(usuario,hora,lat,lon,fecha,cepo,especial,tipo) 
values (
'".mysqli_real_escape_string($mysqli,$_POST["usuario"])."', 
'".mysqli_real_escape_string($mysqli,$_POST["hora"])."', 
'".mysqli_real_escape_string($mysqli,$_POST["lat"])."', 
'".mysqli_real_escape_string($mysqli,$_POST["lon"])."', 
'".mysqli_real_escape_string($mysqli,$_POST["fecha"])."',
'".mysqli_real_escape_string($mysqli,$_POST["cepo"])."',
'".mysqli_real_escape_string($mysqli,$_POST["especial"])."' ,
'".mysqli_real_escape_string($mysqli,$_POST["tipo"])."' )"; 
  if( $datos=mysqli_query($mysqli,$consulta) ){   


 $consulta="REPLACE cepos(codigo,estado,ubica,fechaestado,tipo) 
values (
'".mysqli_real_escape_string($mysqli,$_POST["cepo"])."', 
'ASIGNADO', 
'".mysqli_real_escape_string($mysqli,$_POST["especial"])."',NOW(), 
'".mysqli_real_escape_string($mysqli,$_POST["tipo"])."')"; 
  $datos=mysqli_query($mysqli,$consulta);  

    $array=array();
    $array['mensaje']="Guardado";
    header('Content-type: application/json');
    echo json_encode($array);

  }else{

    $array=array();
    $array['mensaje']="No Guardado";
    header('Content-type: application/json');
    echo json_encode($array);
  }

}
											
function logearselite($mysqli){

//imei
   $consulta="SELECT  nombre,usuario,tipo,codempresa FROM usuarios 
  WHERE  usuario='".mysqli_real_escape_string($mysqli,$_POST["usuario"])."' 
  AND pass='".mysqli_real_escape_string($mysqli,$_POST["pass"])."'AND imei='".mysqli_real_escape_string($mysqli,$_POST["imei"])."' AND estado='Activo' AND tipo='Agente'  "; 
	$datos=mysqli_query($mysqli,$consulta);

            if($row=mysqli_fetch_row($datos)){ 
					$array=array();
					$array['estado']="200";
					$array['nombreUsuario']=$row[0];
					$array['codigoEmpresa']=$row[3];
					header('Content-type: application/json');
					echo json_encode($array);

			$consulta="update usuarios set ultimologin=curdate()
			WHERE  usuario='".mysqli_real_escape_string($mysqli,$_POST["usuario"])."' 
			AND pass='".mysqli_real_escape_string($mysqli,$_POST["pass"])."' "; 
			$datos=mysqli_query($mysqli,$consulta);
               
          }else{
			$array=array();
			$array['estado']="400";
			header('Content-type: application/json');
			echo json_encode($array);
          }
}

function recibeSoporte($mysqli){
 
if ($_POST["Proyecto"]=="EspecialEnel") { 



						$Busqueda="";
						if ($_POST["descSoporte"]=="Fachada") {
								$Busqueda="SELECT fotopredio FROM proyectoespecialenel  WHERE cons='".mysqli_real_escape_string($mysqli,$_POST["gestionCons"])."'  ";
						}elseif ($_POST["descSoporte"]=="Guia") {
							$Busqueda="SELECT fotoguia FROM proyectoespecialenel  WHERE cons='".mysqli_real_escape_string($mysqli,$_POST["gestionCons"])."'  ";
						 }elseif ($_POST["descSoporte"]=="Medidor") {
								$Busqueda="SELECT fotomedidor FROM proyectoespecialenel  WHERE cons='".mysqli_real_escape_string($mysqli,$_POST["gestionCons"])."'  ";
						} 




    $responseArray = array();
    $sql=mysqli_query($mysqli,$Busqueda);
	if($row=mysqli_fetch_row($sql)){

		if($row[0]==""){
  
			$nombre='';
			$swx=0;
			$ruta="gs://lumensarchivostemporales/Soportes/";
			foreach ($_FILES as $key) {
				if($key['error'] == UPLOAD_ERR_OK ){//Verificamos si se subio correctamente
				  $nombre = $_POST["gestionCons"]."-EspecialEnel-".$_POST["descSoporte"].".png";
				  $temporal = $key['tmp_name']; //Obtenemos el nombre del archivo temporal
				  move_uploaded_file($temporal, $ruta.$nombre); //Movemos el archivo temporal a la ruta especificada	
					if(file_exists($ruta.$nombre)){
							$swx=1;
					}
				}
			}

				if($swx==1){

						$consulta="";
						if ($_POST["descSoporte"]=="Fachada") {
							$consulta="UPDATE proyectoespecialenel SET	fotoprediofecha=now(),
						    fotopredio='".mysqli_real_escape_string($mysqli,$nombre)."' WHERE cons='".mysqli_real_escape_string($mysqli,$_POST["gestionCons"])."' "; 
						}elseif ($_POST["descSoporte"]=="Guia") {
							$consulta="UPDATE proyectoespecialenel SET	fotoguiafecha=now(),
						    fotoguia='".mysqli_real_escape_string($mysqli,$nombre)."' WHERE cons='".mysqli_real_escape_string($mysqli,$_POST["gestionCons"])."' ";
						}elseif ($_POST["descSoporte"]=="Medidor") {
							$consulta="UPDATE proyectoespecialenel SET	fotomedidorfecha=now(),
						    fotomedidor='".mysqli_real_escape_string($mysqli,$nombre)."' WHERE cons='".mysqli_real_escape_string($mysqli,$_POST["gestionCons"])."' ";
						} 

						if( $datos=mysqli_query($mysqli,$consulta) ){ 

							header('Content-type: application/json');      
							$array=array();
							$array['mensaje']="Registro Actualizado ";
							echo json_encode($array);

						}else{
						    $array=array();
						    $array['mensaje']="No Actualizado";
						    header('Content-type: application/json');
						    echo json_encode($array);
					  	}

				}else{
				    $array=array();
				    $array['mensaje']="Soporte No Cargado";
				    header('Content-type: application/json');
				    echo json_encode($array);
				  }

		}else{
		    $array=array();
		    $array['mensaje']="Ya Tiene Soporte";
		    header('Content-type: application/json');
		    echo json_encode($array);
	  	}
	}else{
	    $array=array();
	    $array['mensaje']="No Existe";
	    header('Content-type: application/json');
	    echo json_encode($array);
  	}
}else{

if ($_POST["Proyecto"]=="Preoperacional") { 



			$Busqueda="SELECT imagen,fecha,cons FROM enelpreopperacionalmotos  WHERE codagente='".mysqli_real_escape_string($mysqli,$_POST["gestionCons"])."' and fecha=curdate() ";
				




    $responseArray = array();
    $sql=mysqli_query($mysqli,$Busqueda);
	if($row=mysqli_fetch_row($sql)){

		if($row[0]==""){
  
			$nombre='';
			$swx=0;
			$ruta="gs://lumensarchivostemporales/Soportes/";
			foreach ($_FILES as $key) {
				if($key['error'] == UPLOAD_ERR_OK ){//Verificamos si se subio correctamente
				  $nombre = "Preoperacional".$_POST["gestionCons"]."-".$row[1].".png";
				  $temporal = $key['tmp_name']; //Obtenemos el nombre del archivo temporal
				  move_uploaded_file($temporal, $ruta.$nombre); //Movemos el archivo temporal a la ruta especificada	
					if(file_exists($ruta.$nombre)){
							$swx=1;
					}
				}
			}

				if($swx==1){

							$consulta="UPDATE enelpreopperacionalmotos SET
						    imagen='".mysqli_real_escape_string($mysqli,$nombre)."' WHERE cons='".mysqli_real_escape_string($mysqli,$row[2])."' "; 
				

						if( $datos=mysqli_query($mysqli,$consulta) ){ 

							header('Content-type: application/json');      
							$array=array();
							$array['mensaje']="Registro Actualizado ";
							echo json_encode($array);

						}else{
						    $array=array();
						    $array['mensaje']="No Actualizado";
						    header('Content-type: application/json');
						    echo json_encode($array);
					  	}

				}else{
				    $array=array();
				    $array['mensaje']="Soporte No Cargado";
				    header('Content-type: application/json');
				    echo json_encode($array);
				  }

		}else{
		    $array=array();
		    $array['mensaje']="Ya Tiene Soporte";
		    header('Content-type: application/json');
		    echo json_encode($array);
	  	}
	}else{
	    $array=array();
	    $array['mensaje']="No Existe";
	    header('Content-type: application/json');
	    echo json_encode($array);
  	}



}else{
	$Busqueda="SELECT soporte FROM principal  WHERE cons='".mysqli_real_escape_string($mysqli,$_POST["gestionCons"])."'  ";
    $responseArray = array();
    $sql=mysqli_query($mysqli,$Busqueda);
	if($row=mysqli_fetch_row($sql)){

		if($row[0]==""){
  
			$nombre='';
			$swx=0;
			$ruta="gs://lumensarchivostemporales/Soportes/";
			foreach ($_FILES as $key) {
				if($key['error'] == UPLOAD_ERR_OK ){//Verificamos si se subio correctamente
				  $nombre = $_POST["gestionCons"]."-Generico.png";
				  $temporal = $key['tmp_name']; //Obtenemos el nombre del archivo temporal
				  move_uploaded_file($temporal, $ruta.$nombre); //Movemos el archivo temporal a la ruta especificada	
					if(file_exists($ruta.$nombre)){
							$swx=1;
					}
				}
			}

				if($swx==1){

						$consulta="UPDATE principal SET
						fechasoporte=now(),
						soporte='".mysqli_real_escape_string($mysqli,$nombre)."'
						WHERE cons='".mysqli_real_escape_string($mysqli,$_POST["gestionCons"])."' "; 
						if( $datos=mysqli_query($mysqli,$consulta) ){ 

							header('Content-type: application/json');      
							$array=array();
							$array['mensaje']="Registro Actualizado";
							echo json_encode($array);

						}else{
						    $array=array();
						    $array['mensaje']="No Actualizado";
						    header('Content-type: application/json');
						    echo json_encode($array);
					  	}

				}else{
				    $array=array();
				    $array['mensaje']="Soporte No Cargado";
				    header('Content-type: application/json');
				    echo json_encode($array);
				  }

		}else{
		    $array=array();
		    $array['mensaje']="Ya Tiene Soporte";
		    header('Content-type: application/json');
		    echo json_encode($array);
	  	}
	}else{
	    $array=array();
	    $array['mensaje']="No Existe";
	    header('Content-type: application/json');
	    echo json_encode($array);
  	}
}

}

   

}




function recibeGestion($mysqli){
 
   $Busqueda="SELECT estado,codactividad,codagente FROM principal  WHERE cons='".mysqli_real_escape_string($mysqli,$_POST["gestionCons"])."'  ";
    $responseArray = array();
    $sql=mysqli_query($mysqli,$Busqueda);
	if($row=mysqli_fetch_row($sql)){

		if($row[0]=="Pendiente"){

						$respuesta="";
						if($_POST["gestionCampo1"]=="ENTREGA"){
							$respuesta="REALIZADA";
						}else{
							if($_POST["gestionCampo1"]=="DEVOLUCION"){
								$respuesta="NO REALIZADA";
							}else{
								$respuesta=$_POST["gestionCampo1"];
							}
						}

						if($respuesta=="NO REALIZADA"){
								$respuesta="No Efectiva";
						}else{
								$respuesta="Efectiva";
						}

						$detallerespuesta=$_POST["gestionCampo2"];

						if($detallerespuesta=="NO EFECTIVA"){							
								$respuesta="No Efectiva";
						}

						$resultado1=$_POST["gestionCampo3"];
						$resultado2=$_POST["gestionCampo4"];
						$observaciones=$_POST["gestionObservaciones"];
						$fecharealizado=$_POST["gestionHora"];

						$consulta="UPDATE principal SET
						estado='Realizado',
						fechaestado=CURDATE(),
						respuesta='".mysqli_real_escape_string($mysqli,$respuesta)."',
						detallerespuesta='".mysqli_real_escape_string($mysqli,$detallerespuesta)."',
						fecharealizado='".mysqli_real_escape_string($mysqli,$fecharealizado)."',
						resultado1='".mysqli_real_escape_string($mysqli,$resultado1)."',
						resultado2='".mysqli_real_escape_string($mysqli,$resultado2)."',
						platitud='".mysqli_real_escape_string($mysqli,$_POST["gestionLatitud"])."',
						plongitud='".mysqli_real_escape_string($mysqli,$_POST["gestionLongitud"])."',
						observaciones='".mysqli_real_escape_string($mysqli,$observaciones)."' WHERE
						cons='".mysqli_real_escape_string($mysqli,$_POST["gestionCons"])."' "; 

			if( $datos=mysqli_query($mysqli,$consulta) ){ 



						if($respuesta=="No Efectiva"){
							$consulta="UPDATE actividad SET noefectivos=noefectivos+1 WHERE 
							cons='".mysqli_real_escape_string($mysqli,$row[1])."' "; 
						}else{
							$consulta="UPDATE actividad SET efectivos=efectivos+1 WHERE 
							cons='".mysqli_real_escape_string($mysqli,$row[1])."' "; 
						}

						if( $datos=mysqli_query($mysqli,$consulta) ){ 

						$consulta1="UPDATE  agentes SET fechavisitas=CURDATE() 
					    where usuario='".mysqli_real_escape_string($mysqli,$row[2])."'"; 
					    $datosx=mysqli_query($mysqli,$consulta1);

						header('Content-type: application/json');
						$array=array();
						$array['mensaje']="Registro Actualizado";
						echo json_encode($array);





						}else{
						    $array=array();
						    $array['mensaje']="No Incrementado";
						    header('Content-type: application/json');
						    echo json_encode($array);
					  	}




			}else{
			    $array=array();
			    $array['mensaje']="No Guardado";
			    header('Content-type: application/json');
			    echo json_encode($array);
		  	}

		}else{
		    $array=array();
		    $array['mensaje']="Ya Gestionado";
		    header('Content-type: application/json');
		    echo json_encode($array);
	  	}
	}else{
	    $array=array();
	    $array['mensaje']="No Existe";
	    header('Content-type: application/json');
	    echo json_encode($array);
  	}

}



 //*** Buscar Planilla especifica
  function listaAsignaciones($mysqli){

      $Busqueda="SELECT codactividad,destinatario,direccion,c.nombre as ciudad,d.nombre as depto,p.cliente as cliente,referencia1,referencia2,referencia3,referencia4,referencia5,ruta,ordenamiento,a.tipo as tipoactividad,a.soporte as tiposoporte,a.observaciones as observaciones,p.cons,p.estado FROM (((principal p INNER JOIN ciudades c ON c.cons=p.codciudad) INNER JOIN departamentos d ON d.cons=p.coddepartamento) inner join actividad a on a.cons=p.codactividad) WHERE codagente='".mysqli_real_escape_string($mysqli,$_POST["listanUsuario"])."' AND a.estado='Activo' AND fechaactividad=CURDATE() order by ordenamiento,p.cons  ";

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
              'observaciones'=>$row[15], 
              'cons'=>$row[16], 
              'estado'=>$row[17] ,
              'proyecto'=>"Generico",
				'EspEnelcodactividad'=>"",
				'EspEnelfechaactividad'=>"",
				'EspEnelproducto'=>"",
				'EspEnelorden'=>"",
				'EspEnelguia'=>"",
				'EspEnelcuenta'=>"",
				'EspEnelidventa'=>"",
				'EspEneldireccion'=>"",
				'EspEnelciudad'=>"",
				'EspEnelcuadratula'=>"",
				'EspEnelcons'=>"",
				'EspEnelEstado'=>"",
				'EspEnelEspecial1'=>"",
				'EspEnelLote'=>"",
				'EspEnelCiclo'=>"",
				'EspEnelSuscriptor'=>""
            );
            
            array_push($responseArray,$Datos);        
          }


      $Busqueda="SELECT codactividad,fechaactividad,producto,orden,guia,cuenta,idventa,direccion,ciudad,cuadratula,p.cons,p.estado,p.especial1,p.lote,p.ciclo,p.suscriptor
      FROM proyectoespecialenel p  inner join actividad a on a.cons=p.codactividad WHERE codagente='".mysqli_real_escape_string($mysqli,$_POST["listanUsuario"])."' AND a.estado='Activo' AND fechaactividad<=CURDATE()    ";
 
        $sql=mysqli_query($mysqli,$Busqueda);

          while( $row=mysqli_fetch_row($sql) ){         
            $Datos=array('codactividad'=>"", 
              'destinatario'=>"", 
              'direccion'=>"", 
              'ciudad'=>"", 
              'depto'=>"", 
              'cliente'=>"", 
              'referencia1'=>"", 
              'referencia2'=>"", 
              'referencia3'=>"", 
              'referencia4'=>"", 
              'referencia5'=>"", 
              'ruta'=>"", 
              'ordenamiento'=> "", 
              'tipoactividad'=>"", 
              'tiposoporte'=>"", 
              'observaciones'=>"", 
              'cons'=>"", 
              'estado'=>"" ,
              'proyecto'=>"EspecialEnel",
				'EspEnelcodactividad'=>$row[0],
				'EspEnelfechaactividad'=>$row[1],
				'EspEnelproducto'=>$row[2],
				'EspEnelorden'=>$row[3],
				'EspEnelguia'=>$row[4],
				'EspEnelcuenta'=>$row[5],
				'EspEnelidventa'=>$row[6],
				'EspEneldireccion'=>$row[7],
				'EspEnelciudad'=>$row[8],
				'EspEnelcuadratula'=>$row[9],
				'EspEnelcons'=>$row[10],
				'EspEnelEstado'=>$row[11],
				'EspEnelEspecial1'=>$row[12],
				'EspEnelLote'=>$row[13],
				'EspEnelCiclo'=>$row[14],
				'EspEnelSuscriptor'=>$row[15]
            );
            array_push($responseArray,$Datos);        
          }
          

          header('Content-type: application/json');
          $array=array();
            $array['mensaje']=($responseArray);
            echo json_encode($array);
  }



	function listaNotificacion($mysqli){


				$Busqueda="SELECT encabezado,descripcion,fechacarga FROM notificaciones WHERE  
				(rango='".mysqli_real_escape_string($mysqli,$_POST["listanUsuario"])."' or rango='') AND tipo='Entrada' order by fechacarga desc ";
				$responseArray = array();
				$sql=mysqli_query($mysqli,$Busqueda);

					while( $row=mysqli_fetch_row($sql) ){					
						$Datos=array('Titulo'=>$row[0], 'Descripcion'=>$row[1], 'Fecha'=>$row[2]);
						array_push($responseArray,$Datos);				
					}

					header('Content-type: application/json');			
					$array=array();
			     	$array['mensaje']=($responseArray);
			    	echo json_encode($array);
	}



function Notificacion($mysqli){

if($_POST["not_token"]!="" && $_POST["not_token"]!="null"){

     $consulta="UPDATE  agentes SET
    token_notif='".mysqli_real_escape_string($mysqli,$_POST["not_token"])."'
    where usuario='".mysqli_real_escape_string($mysqli,$_POST["not_usuario"])."'"; 
    if($datos=mysqli_query($mysqli,$consulta)){

    $array=array();
    $array['mensaje']="Guardado";
    header('Content-type: application/json');
    echo json_encode($array);
     }else{
      $array=array();
      $array['mensaje']="No Guardado";
      header('Content-type: application/json');
      echo json_encode($array);
     }
 }
  

}
        
function Publicidad($mysqli){
 
 $valores=explode("|", $_POST["insert"]);
$consulta="INSERT publicidad(usuario,hora,red,lat,lon,bateria,carga,bluet,equipo,fecha) 
values ".$valores[0]." "; 
  if( $datos=mysqli_query($mysqli,$consulta) ){   


 
$consulta2="UPDATE agentes SET fechapublicidad=CURDATE() 
WHERE usuario='".mysqli_real_escape_string($mysqli,$valores[1])."'"; 
 $datos2=mysqli_query($mysqli,$consulta2);  

    $array=array();
    $array['mensaje']="Guardado";
    header('Content-type: application/json');
    echo json_encode($array);

  }else{

    $array=array();
    $array['mensaje']="No Guardado";
    header('Content-type: application/json');
    echo json_encode($array);
  }

}

function Tracking($mysqli){

if(date("H")<18){

$valores=explode("|", $_POST["insert"]);

$consulta="INSERT tracking(usuario,hora,red,lat,lon,bateria,carga,bluet,equipo,fecha) 
values ". $valores[0]." "; 
  if( $datos=mysqli_query($mysqli,$consulta) ){   

    $consulta1="UPDATE  agentes SET
    lat='".mysqli_real_escape_string($mysqli,$valores[1])."',
    lon='".mysqli_real_escape_string($mysqli,$valores[2])."',
    fechageo=now() where usuario='".mysqli_real_escape_string($mysqli,$valores[3])."'"; 
    $datosx=mysqli_query($mysqli,$consulta1);

    $array=array();
    $array['mensaje']="Guardado";
    header('Content-type: application/json');
    echo json_encode($array);
     
  }else{
    $consulta="INSERT tracking(usuario,fecha) 
    values('".mysqli_real_escape_string($mysqli,$_POST["trk_usuario"])."',curdate())"; 
  $datos=mysqli_query($mysqli,$consulta);

    $array=array();
    $array['mensaje']="No Guardado";
    header('Content-type: application/json');
    echo json_encode($array);
  }
}

}
											
function logearse($mysqli){


   $consulta="SELECT  u.nombre,u.usuario,u.tipo,u.codempresa,a.unidad_negocio FROM usuarios  u INNER JOIN agentes a ON a.usuario=u.usuario
  WHERE   u.usuario='".mysqli_real_escape_string($mysqli,$_POST["usuario"])."' 
  AND  u.pass='".mysqli_real_escape_string($mysqli,$_POST["pass"])."' AND  u.estado='Activo' AND  u.tipo='Agente'  "; 
	$datos=mysqli_query($mysqli,$consulta);

            if($row=mysqli_fetch_row($datos)){ 

					$consulta="update usuarios set 
					WHERE  usuario='".mysqli_real_escape_string($mysqli,$_POST["usuario"])."' 
					AND pass='".mysqli_real_escape_string($mysqli,$_POST["pass"])."' "; 
					$datos=mysqli_query($mysqli,$consulta);

					$consulta="update agentes set sesioninicio=NOW(),sesionfin= NULL
					WHERE  usuario='".mysqli_real_escape_string($mysqli,$_POST["usuario"])."'  "; 
					$datos=mysqli_query($mysqli,$consulta);

					$array=array();
					$array['estado']="200";
					$array['nombreUsuario']=$row[0];
					$array['codigoEmpresa']=$row[3];
					$array['unidadNegocio']=$row[4];
					header('Content-type: application/json');
					echo json_encode($array);
               
          }else{
			$array=array();
			$array['estado']="400";
			header('Content-type: application/json');
			echo json_encode($array);
          }
}

?>