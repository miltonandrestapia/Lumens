<?php

ini_set('max_execution_time', 600);
set_time_limit(600);

require_once("../Conexion.php");

session_start(); 
   if ($_SESSION['LMNS-USER_USUARIO']=='') {
  echo '<script  type="text/javascript">alert("Debe volver a iniciar sesión);
            window.location="inicio.php";</script>';
}else{		
	if(isset($_POST["CargaBase"])){		
		CargaBase($mysqli);								
	}else{	 		
		if(isset($_POST["validarCarganombre"])){		
			validarCarganombre($mysqli);								
		}else{	 				
				if(isset($_POST["CargaBaseAdd"])){		
					CargaBaseAdd($mysqli);								
				}else{	 				
						if(isset($_POST["ActualizaZonas"])){		
							ActualizaZonas($mysqli);								
						}else{	 		
							echo "Archivo Erroneo";	
						}
			}
		}
	}
}


function ActualizaZonas($mysqli){



	foreach ($_FILES as $key) {
		if($key['error'] == UPLOAD_ERR_OK){//Verificamos si se subio correctamente
		  
			$nombre="Actualizazonas.xlsx";
		  	$temporal = $key['tmp_name']; //Obtenemos el nombre del archivo temporal
	
		  	move_uploaded_file($temporal, 'gs://lumensarchivostemporales/'.$nombre); //Movemos el archivo temporal a la ruta especificada			

			include 'SimpleXLSX.php';
			$xlsx = SimpleXLSX::parse('gs://lumensarchivostemporales/'.$nombre);
			list($num_cols, $num_rows) = $xlsx->dimension(0);
			$cont=1;
			$reg_error = '';
			$cont_error = 0;
			$Ok=0;
			$guarda=0;
			
			$swx=0;
			foreach( $xlsx->rows() as $row ) {

				if($cont>1){

				if($row[0]!=""){

					$c="SELECT codigo FROM zonas WHERE  
					nombre='".mysqli_real_escape_string($mysqli,trim($row[0]))."' ";

						$d=mysqli_query($mysqli,$c);
						if(!$r=mysqli_fetch_row($d)){ 
							$cont_error++;
							$reg_error .=  '* Error Fila Nº '.$cont.' zona no encontrada
';
						}else{
						$c1="SELECT nombre FROM agentes WHERE  
						usuario='".mysqli_real_escape_string($mysqli,($row[1]))."' ";
						$d1=mysqli_query($mysqli,$c1);
						if($r1=mysqli_fetch_row($d1)){ 

									$c1="update agentes set 
									sector='".mysqli_real_escape_string($mysqli,$r[0])."'
									where usuario='".mysqli_real_escape_string($mysqli,$row[1])."'"; 
				         			 if( $d1=mysqli_query($mysqli,$c1) ){
										$guarda++;
				         			 }else{
				         			 	$cont_error++;
										$reg_error .=  '* Error Fila Nº '.$cont.' no se pudo actualizar
';
				         			 }

							 }else{
				         			 	$cont_error++;
										$reg_error .=  '* Error Fila Nº '.$cont.' no existe agente
';
				         	 }


							}
				}else{
					break;
				}
			}
				$cont++;

			}//End foreach	



			$array=array();				
			if(($cont-1)!=1){				
				$Regis=$num_rows-1;
				$array['validacion']='OK';
				$array['icono']='success';	
				$array['cantidad']= $guarda;				
				$mensaje="Se Actualizaron ".($guarda)." Registros
";

				if($cont_error!=0){
					$mensaje.=$reg_error;	
					$array['icono']='error';
				}else{
					$mensaje.="Ningun error encontrado";	
				}
				$array['Mensaje']=$mensaje;
			}else{
				$array['validacion']="Error";
				$array['Mensaje']="No se encontró ningun registro, ".$cont." verifique el archivo";
			}
				

	  header('Content-type: application/json');
	  echo json_encode($array);
	 // unlink($nombre);

		}
	}
}






function CargaBaseAdd(){		
				$array=array();
				foreach ($_FILES as $key) {
					if($key['error'] == UPLOAD_ERR_OK){//Verificamos si se subio correctamente
					  	$nombre = time().".xlsx";//Obtenemos el nombre del archivo
					  	$temporal = $key['tmp_name']; //Obtenemos el nombre del archivo temporal
				
					  	move_uploaded_file($temporal, 'gs://lumensarchivostemporales/'.$nombre); //Movemos el archivo temporal a la ruta especificada											  
								
						include 'SimpleXLSX.php';
						$xlsx = SimpleXLSX::parse('gs://lumensarchivostemporales/'.$nombre);
						list($num_cols, $num_rows) = $xlsx->dimension(0);
						$array['validacion']="OK";
						$array['nombre']=$nombre;
						$array['cantidad']=$num_rows-1;								
					}else{
						$array['validacion']="Error";
						$array['Mensaje']="Error al cargar el archivo";
					}							
				 }
				  header('Content-type: application/json');
				  echo json_encode($array);				 
}






function validarCarganombre($mysqli){

			 $nombre=$_POST['validarCarganombre'];
			include 'SimpleXLSX.php';
			$xlsx = SimpleXLSX::parse('gs://lumensarchivostemporales/'.$nombre);
			list($num_cols, $num_rows) = $xlsx->dimension(0);
			$cont=1;
			$reg_error = '';
			$cont_error = 0;
			$Ok=0;
			$guarda=0;
			$estado='0';
			$time = time();
			$ordenruta="";
			
				$swx=0;
			foreach( $xlsx->rows() as $row ) {

			if($cont!=1){//Encabezado				


				$row[4]=substr($row[4], 0, 90); 



				if($row[0]!=""){
					$c=" SELECT  nombre FROM agentes WHERE 
					usuario='".mysqli_real_escape_string($mysqli,$row[0])."' "; 
					 $datos2=mysqli_query($mysqli,$c);
					  if(mysqli_num_rows($datos2)<1){
						$cont_error++;
						$reg_error .= '<span>* Error Fila Nº '.$cont.' Agente No Existe.</span></br>';
						$guarda++;
					  }
				} 

				if($row[1]==""){  
					$cont_error++;
					$reg_error .= '<span>* Error Fila Nº '.$cont.' campo  producto vacio.</span></br>';
					$guarda++;
				}else{
						if( strtoupper($row[1]) !=strtoupper('FACTURAS CODENSA') &&   
							strtoupper($row[1]) !=strtoupper('FACTURAS CUNDINAMARCA') &&
							strtoupper($row[1]) !=strtoupper('AVISOS DE SUSPENSION') && 
							strtoupper($row[1]) !=strtoupper('FACTURA EMPRESARIALES') &&					
							strtoupper($row[1]) !=strtoupper('Facturas Unicuentas') && 
							strtoupper($row[1]) !=strtoupper('FACTURAS CICLO 70') &&
							strtoupper($row[1]) !=strtoupper('FACTURAS CICLO 72') &&					
							strtoupper($row[1]) !=strtoupper('AJUSTES') && 
							strtoupper($row[1]) !=strtoupper('BRAYLES') &&						
							strtoupper($row[1]) !=strtoupper('ACUSES INFORMATIVAS CNR') && 
							strtoupper($row[1]) !=strtoupper('ACUSES HALLAZGOS') &&
							strtoupper($row[1]) !=strtoupper('FACTURAS INHIBIDAS') &&
							strtoupper($row[1]) !=strtoupper('FACTURAS UNICUENTAS') &&
							strtoupper($row[1]) !=strtoupper('POLIZAS MAPFRE') ){ 
							$cont_error++;
							$reg_error .= '<span>* Error Fila Nº '.$cont.'  producto no es valido.</span></br>';
							$guarda++; 
						}
				}


				if($row[2]==""){
					$cont_error++;
					$reg_error .= '<span>* Error Fila Nº '.$cont.' campo cuenta vacio.</span></br>';
					$guarda++;
				}

				if($row[3]==""){
					$cont_error++;
					$reg_error .= '<span>* Error Fila Nº '.$cont.' campo id venta vacio.</span></br>';
					$guarda++;
				}


				if($row[4]==""){
					$cont_error++;
					$reg_error .= '<span>* Error Fila Nº '.$cont.' campo direccion vacio.</span></br>';
					$guarda++;
				}



				if($row[5]==""){
					$cont_error++;
					$reg_error .= '<span>* Error Fila Nº '.$cont.' campo ciudad vacio.</span></br>';
					$guarda++;
				}

				if($row[6]==""){
					$cont_error++;
					$reg_error .= '<span>* Error Fila Nº '.$cont.' campo cuadratula vacio.</span></br>';
					$guarda++;
				}

				if($row[7]==""){
					$cont_error++;
					$reg_error .= '<span>* Error Fila Nº '.$cont.' campo ciclo vacio.</span></br>';
					$guarda++;
				}

				if($row[8]==""){
					$cont_error++;
					$reg_error .= '<span>* Error Fila Nº '.$cont.' campo suscriptor vacio.</span></br>';
					$guarda++;
				}
				if($row[9]==""){
					$cont_error++;
					$reg_error .= '<span>* Error Fila Nº '.$cont.' campo grupo vacio.</span></br>';
					$guarda++;
				}
				if($row[10]==""){
					$cont_error++;
					$reg_error .= '<span>* Error Fila Nº '.$cont.' campo sucursal vacio.</span></br>';
					$guarda++;
				}
				if($row[11]==""){
					$cont_error++;
					$reg_error .= '<span>* Error Fila Nº '.$cont.' campo supervisor vacio.</span></br>';
					$guarda++;
				}



			}//End encabezado
			$cont++;

			}//End foreach	


		//Si no hay ningun error procedemos a guardar
			if($guarda==0){


					$c1="INSERT actividad(fechacreacion,fecha,tipo,soporte,observaciones,usuariocarga,cantidad,proyecto)
					VALUES(NOW(),
					'".mysqli_real_escape_string($mysqli,($_POST["validarCargaFecha"]))."',
					'".mysqli_real_escape_string($mysqli,($_POST["validarCargaTipo"]))."',
					'".mysqli_real_escape_string($mysqli,($_POST["validarCargaSoporte"]))."',
					'".mysqli_real_escape_string($mysqli,strtoupper($_POST["validarCargaObservaciones"]))."',
					'".$_SESSION['LMNS-USER_USUARIO']."',
					'".($cont-2)."','Especial Enel')";          
         			 if( $d1=mysqli_query($mysqli,$c1) ){

						$c="SELECT MAX(cons) FROM actividad  WHERE  
						usuariocarga='".mysqli_real_escape_string($mysqli,$_SESSION['LMNS-USER_USUARIO'])."' ";
						$d=mysqli_query($mysqli,$c);
						if($r=mysqli_fetch_row($d)){ 
								$swx=$r[0];
						}
					}

				$inseR=1;
				if($swx!=0){

			$codcliente="";
			$enombrecliente="";
				foreach( $xlsx->rows() as $row ) {


				if($inseR!=1){ 
 


						$numeroguia="";
						$c2="SELECT consguiasespecialenel FROM configuraciones ";
						$d2=mysqli_query($mysqli,$c2);
						if($r2=mysqli_fetch_row($d2)){ 
							$numeroguia=$r2[0]+1;
							$c2="update configuraciones set consguiasespecialenel='".$numeroguia."'   ";
							$d2=mysqli_query($mysqli,$c2);
						}
					


	$dias="P3D";

	if (strtoupper($row[5])=="BOGOTA") {

			if (strtoupper($row[1])=="FACTURA EMPRESARIALES" ||
				strtoupper($row[1])=="FACTURAS CICLO 70" ||
				strtoupper($row[1])=="FACTURAS CICLO 72" ||
				strtoupper($row[1])=="FACTURAS CODENSA" ||
				strtoupper($row[1])=="FACTURAS CUNDINAMARCA" ||
				strtoupper($row[1])=="FACTURAS INHIBIDAS" ||
				strtoupper($row[1])=="FACTURAS UNICUENTAS") {
					$dias="P1D";
			}else{
					if (strtoupper($row[1])=="POLIZAS MAPFRE") {
						$dias="P2D";
					}
			}
	}else{
			if (strtoupper($row[1])=="FACTURA EMPRESARIALES" ||
				strtoupper($row[1])=="FACTURAS CICLO 70" ||
				strtoupper($row[1])=="FACTURAS CICLO 72" ||
				strtoupper($row[1])=="FACTURAS CODENSA" ||
				strtoupper($row[1])=="FACTURAS CUNDINAMARCA" ||
				strtoupper($row[1])=="FACTURAS INHIBIDAS" ||
				strtoupper($row[1])=="FACTURAS UNICUENTAS") {
					$dias="P2D";
			}else{
					if (strtoupper($row[1])=="POLIZAS MAPFRE") {
						$dias="P3D";
					}
			}
	}


	$mFecha = DateTime::createFromFormat('Y-m-d', $row[12]);
	$mFecha->add(new DateInterval($dias));




					
 $c1="INSERT proyectoespecialenel(archivocarga,fechacargue,usuariocargue,fechaactividad,codactividad,codagente,producto,cuenta,idventa,direccion,ciudad,cuadratula,ciclo,suscriptor,grupo,sucursal,supervisor,fecha_llegada_fisico,lote,documento,especial1,orden,guia,fecha_max_entrega)
VALUES('".($nombre)."',NOW(),
					'".mysqli_real_escape_string($mysqli,$_SESSION['LMNS-USER_USUARIO'])."',
					'".mysqli_real_escape_string($mysqli,$_POST['validarCargaFecha'])."',
					'".mysqli_real_escape_string($mysqli,$swx)."',
					'".mysqli_real_escape_string($mysqli,$row[0])."',
					'".mysqli_real_escape_string($mysqli,$row[1])."',
					'".mysqli_real_escape_string($mysqli,$row[2])."', 
					'".mysqli_real_escape_string($mysqli,$row[3])."',
					'".mysqli_real_escape_string($mysqli,sanear_string($row[4]))."', 
					'".mysqli_real_escape_string($mysqli,$row[5])."',
					'".mysqli_real_escape_string($mysqli,$row[6])."',
					'".mysqli_real_escape_string($mysqli,$row[7])."',
					'".mysqli_real_escape_string($mysqli,$row[8])."',
					'".mysqli_real_escape_string($mysqli,$row[9])."',
					'".mysqli_real_escape_string($mysqli,$row[10])."', 
					'".mysqli_real_escape_string($mysqli,$row[11])."',
					'".mysqli_real_escape_string($mysqli,$row[12])."',
					'".mysqli_real_escape_string($mysqli,$row[13])."',
					'".mysqli_real_escape_string($mysqli,$row[14])."',
					'".mysqli_real_escape_string($mysqli,$row[15])."',  
					'".mysqli_real_escape_string($mysqli,$swx)."',
					'".mysqli_real_escape_string($mysqli,$numeroguia)."',
					'".mysqli_real_escape_string($mysqli,$mFecha->format('Y-m-d'))."') "; 

					if($d1=mysqli_query($mysqli,$c1)){
						$Ok++;
					}else{	
						$cont_error++;
						$reg_error.='<span>* Error Fila Nº '.$inseR.' No se pudo guardar el registro, verifique los datos '. $c1.'.</span></br>';
					}					
				}//End encabezado

				$inseR++;

				}//End foreach

			}//End guardar

			}

			$array=array();	

			if(($cont-1)!=1){

				$Regis=$num_rows-1;
				$array['validacion']='OK';
				$array['icono']='success';	
			
				$mensaje="Se validaron ".($Ok)." Registros de ".$Regis."
						>>> Codigo de Actividad: ".$swx." <<<";
			

				if($cont_error!=0){

					$mensaje="No se puede procesar,  errores encontrados ".$cont_error.".
									Revise detalles de validación.";
					$detalleerror=$reg_error;	
					$array['icono']='error';
					$array['detalleerror']=$detalleerror;
				}

				$array['Mensaje']=$mensaje;


			}else{
				$array['validacion']="Error";
				$array['Mensaje']="No se encontró ningun registro, verifique el archivo";
			}
				

	  header('Content-type: application/json');
	  echo json_encode($array);
	  unlink(''.$nombre);
}






function CargaBase($mysqli)
{	

				$array=array();
				foreach ($_FILES as $key) {
					if($key['error'] == UPLOAD_ERR_OK){//Verificamos si se subio correctamente
					$nombre = time().".xlsx";
				  	$temporal = $key['tmp_name'];				
			 
				  		 move_uploaded_file($temporal, 'gs://lumensarchivostemporales/'.$nombre); 	
						include 'SimpleXLSX.php';
						$xlsx = SimpleXLSX::parse('gs://lumensarchivostemporales/'.$nombre);
 

						list($num_cols, $num_rows) = $xlsx->dimension(0);
						$array['validacion']="OK";
						$array['nombre']=$nombre;
						$array['cantidad']=$num_rows-1;								
					}else{
						$array['validacion']="Error";
						$array['Mensaje']="Error al cargar el archivo";
					}			  				
				 }
				  header('Content-type: application/json');
				  echo json_encode($array);				 
}






//Funcion quitar tildes y acentos raros
	function sanear_string($string){

 		$string=strtoupper($string);
	    $string = trim($string);
	    $string = str_replace(
	        array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
	        array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
	        $string
	    );
	 
	    $string = str_replace(
	        array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
	        array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
	        $string
	    );
	 
	    $string = str_replace(
	        array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
	        array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
	        $string
	    );
	 
	    $string = str_replace(
	        array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
	        array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
	        $string
	    );
	 
	    $string = str_replace(
	        array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
	        array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
	        $string
	    );
	 
	    $string = str_replace(
	        array('ñ', 'Ñ', 'ç', 'Ç'),
	        array('ñ', 'Ñ', 'c', 'C'),
	        $string
	    );
	 
	    //Esta parte se encarga de eliminar cualquier caracter extraño
	    $string = str_replace(
	        array("#", "@", "*", "!", "-", "_",
	             "·", "$", "%", "&", "/",
	             "(", ")", "?", "'", "¡",
	             "¿", "[", "^", "<code>", "]",
	             "+", "}", "{", "¨", "´",
	             ">", "< ", ";", ":",
	             ".", ",",
"
"),
	        ' ',
	        $string
	    );

		$string=str_replace("  "," ",$string);
		$string=substr($string, 0, 99);
		$string=mberegi_replace("[\n|\r|\n\r|\t||\x0B]", "",$string);
    	return $string;
	}

	//*****CAMPO SCANEAR DIRECCION
	function sanear_stringDireccion($string){

 		$string=strtoupper($string);
	    $string = trim($string);
	    $string = str_replace(
	        array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
	        array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
	        $string
	    );
	 
	    $string = str_replace(
	        array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
	        array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
	        $string
	    );
	 
	    $string = str_replace(
	        array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
	        array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
	        $string
	    );
	 
	    $string = str_replace(
	        array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
	        array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
	        $string
	    );
	 
	    $string = str_replace(
	        array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
	        array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
	        $string
	    );
	 
	    $string = str_replace(
	        array('ñ', 'Ñ', 'ç', 'Ç'),
	        array('ñ', 'Ñ', 'c', 'C'),
	        $string
	    );
	 
	    //Esta parte se encarga de eliminar cualquier caracter extraño
	    $string = str_replace(
	        array("#", "@", "*", "!", "-", "_",
	             "·", "$", "%", "&", "/",
	             "(", ")", "?", "'", "¡",
	             "¿", "[", "^", "<code>", "]",
	             "+", "}", "{", "¨", "´",
	             ">", "< ", ";", ":",
	             ".", ",",
"
"),
	        ' ',
	        $string
	    );


		$string=str_replace("  "," ",$string);
		$string=mberegi_replace("[\n|\r|\n\r|\t||\x0B]", "",$string);
 
    	return $string;
	}






function geodatos($ciudad,$direccion,$mysqli){

			$c="SELECT  coddane,zona,latitud,longitud,barrio FROM geodatos WHERE 
			direccion='".mysqli_real_escape_string($mysqli,$direccion)."' and 
			ciudad='".mysqli_real_escape_string($mysqli,$ciudad)."' "; 
			$d=mysqli_query($mysqli,$c);
			if($r=mysqli_fetch_row($d)){ 
					return $r[0]."|".$r[1]."|".$r[2]."|".$r[3]."|".$r[4];
			}else{
			$curl = curl_init();
			curl_setopt_array($curl, array(
			  CURLOPT_URL => "https://sitidata-stdr.appspot.com/api/zonificador/geocoder/stdr/",
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 30,
			  CURLOPT_POSTFIELDS => "{\"city\":\"$ciudad\",\"address\":\"$direccion\"}",
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "POST",
			  CURLOPT_HTTPHEADER => array(
			            "authorization: Token ITVE5LRCVAGGE11AOM5NTFX3MIB37X",
			            "cache-control: no-cache",
			            "content-type: application/json"
			  ),
			));
			$response = curl_exec($curl);
			$err = curl_error($curl);
			$cont = 0;
			curl_close($curl);
			if ($err) {
			  return "error" ;
			} else {			

			    $response=str_replace('"',"",   $response);
			    $responsed = explode(',', $response); 
			    $coddane=explode(':', $responsed[3]);
			    $Zona=explode(':', $responsed[7]);
			    $Lon=explode(':', $responsed[8]);
			    $Lat=explode(':', $responsed[10]);
			    $barrio=explode(':', $responsed[16]);


				if($Lon[1]!="0" && $Lon[1]!=""){
					return $coddane[1]."|".$Zona[1]."|".$Lat[1]."|".$Lon[1]."|".$barrio[1];
					$c1="REPLACE geodatos(coddane,zona,latitud,longitud,barrio,ciudad,direccion,fechaguardado)
					VALUE(
					'".($coddane[1])."',
					'".($Zona[1])."',
					'".($Lat[1])."',
					'".($Lon[1])."',
					'".($barrio[1])."',
					'".($ciudad)."',
					'".($direccion)."',curdate() )";
					$d1=mysqli_query($mysqli,$c1);
				}else{
					  return "error" ;
				}

			}
		}

}



?>