<?php
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
			if(isset($_POST["BaseActualizar"])){		
				BaseActualizar($mysqli);								
			}else{	 		
				if(isset($_POST["CargaBaseAdd"])){		
					CargaBaseAdd($mysqli);								
				}else{	 		
					if(isset($_POST["validarCargaAddnombre"])){		
						validarCargaAddnombre($mysqli);								
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



function validarCargaAddnombre($mysqli){

			 $nombre=$_POST['validarCargaAddnombre'];
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


				$row[1]=substr($row[1], 0, 90);
				$row[0]=substr($row[0], 0, 90);

			if($row[11]==""){
					if($ordenruta==""){
						$ordenruta="vacio";
					}else{
						if($ordenruta!="vacio"){
							$cont_error++;
							$reg_error .= '<span>* Error Fila Nº '.$cont.' No Concuerda Ordenamiento.</span></br>';
							$guarda++;
						}
					}				
			}else{
					if($ordenruta==""){
						$ordenruta="ordenado";
					}else{
						if($ordenruta!="ordenado"){
							$cont_error++;
							$reg_error .= '<span>* Error Fila Nº '.$cont.' No Concuerda Ordenamiento.</span></br>';
							$guarda++;
						}
					}
			}

				if($row[0]==""){
					$cont_error++;
					$reg_error .= '<span>* Error Fila Nº '.$cont.' No Cuenta con destinatario.</span></br>';
					$guarda++;
				}


				if($row[1]==""){
					$cont_error++;
					$reg_error .= '<span>* Error Fila Nº '.$cont.' No Cuenta con direccion.</span></br>';
					$guarda++;
				}
				//Verificamos campo ciudad
				if($row[2]==""){
					$cont_error++;
					$reg_error .= '<span>* Error Fila Nº '.$cont.' No Cuenta con Ciudad.</span></br>';
					$guarda++;
				}
				//Verificar campo departamento
				if($row[3]==""){
					$cont_error++;
					$reg_error .= '<span>* Error Fila Nº '.$cont.' No Cuenta con Departamento.</span></br>';
					$guarda++;
				}

				//Verificamos que la ciudad y dpto coincidan
				if($row[2]!='' and $row[3]!=''){


					$c="SELECT d.cons,c.cons FROM ciudades c 
					INNER JOIN  departamentos d ON c.id_departamento=d.cons WHERE  
					c.nombre='".mysqli_real_escape_string($mysqli,($row[2]))."' 
					AND  d.nombre='".mysqli_real_escape_string($mysqli,($row[3]))."' ";
						$d=mysqli_query($mysqli,$c);
						if(!$r=mysqli_fetch_row($d)){ 
							$cont_error++;
							$reg_error .=  '<span>* Error Fila Nº '.$cont.' la Ciudad o Departamento no coincide</span></br>';
							$guarda++;
						}
				}

				if($row[5]==""){
					$cont_error++;
					$reg_error .= '<span>* Error Fila Nº '.$cont.' No Cuenta con referencia 1.</span></br>';
					$guarda++;
				}


				if($row[12]==""){
					$cont_error++;
					$reg_error .= '<span>* Error Fila Nº '.$cont.' No Cuenta con Agente.</span></br>';
					$guarda++;
				}

					if($row[10]==""){
					$cont_error++;
					$reg_error .= '<span>* Error Fila Nº '.$cont.' No Cuenta con Ruta.</span></br>';
					$guarda++;
				}


			if($row[12]!=""){
				$c=" SELECT  nombre FROM agentes WHERE 
				usuario='".mysqli_real_escape_string($mysqli,$row[12])."' "; 
				 $datos2=mysqli_query($mysqli,$c);
				  if(mysqli_num_rows($datos2)<1){
					$cont_error++;
					$reg_error .= '<span>* Error Fila Nº '.$cont.' Agente No Existe.</span></br>';
					$guarda++;
				  }
			}

				if($row[4]!=""){
				$c=" SELECT  cons FROM clientes WHERE 
				nombre='".mysqli_real_escape_string($mysqli,$row[4])."'  "; 
				$datos2=mysqli_query($mysqli,$c);
				  if(mysqli_num_rows($datos2)<1){
				  	$cont_error++;
					$reg_error .= '<span>* Error Fila Nº '.$cont.' Cliente No Existe.</span></br>';
					$guarda++;
				}
			}else{
					$cont_error++;
					$reg_error .= '<span>* Error Fila Nº '.$cont.' No Cuenta con Cliente.</span></br>';
					$guarda++;
			}

			}//End encabezado
			$cont++;

			}//End foreach	


		//Si no hay ningun error procedemos a guardar
			if($guarda==0){




				$swx=$_POST['validarCargaAddCodigo'];
				$inseR=1;
				if($swx!=0){

			$codcliente="";
			$enombrecliente="";
				foreach( $xlsx->rows() as $row ) {

				if($inseR!=1){
						$IdCiudad="";
						$IdDepto="";
					$c="SELECT d.cons,c.cons FROM ciudades c 
					INNER JOIN  departamentos d ON c.id_departamento=d.cons WHERE  
					c.nombre='".mysqli_real_escape_string($mysqli,sanear_string($row[2]))."' 
					AND  d.nombre='".mysqli_real_escape_string($mysqli,sanear_string($row[3]))."' ";
					$d=mysqli_query($mysqli,$c);
					if($r=mysqli_fetch_row($d)){ 
						$IdCiudad=$r[1];
						$IdDepto=$r[0];
					}		


			if($enombrecliente!=strtoupper($row[4])){			
					$c=" SELECT  cons,nombre FROM clientes WHERE 
					nombre='".mysqli_real_escape_string($mysqli,$row[4])."'  "; 
					$datos2=mysqli_query($mysqli,$c);
					if($row2=mysqli_fetch_row($datos2)){ 
						$codcliente=$row2[0];
						$enombrecliente=$row2[1];
					}		
					$Xc=" SELECT  cons FROM actividadclientes WHERE 
					codcliente='".mysqli_real_escape_string($mysqli,$codcliente)."' and 
					codactividad='".mysqli_real_escape_string($mysqli,$swx)."' "; 
					$Xdatos2=mysqli_query($mysqli,$Xc);
					if(!$Xrow2=mysqli_fetch_row($Xdatos2)){ 

					$c1="INSERT actividadclientes(fechacreacion,fecha,tipo,soporte,
					observaciones,usuariocarga,codcliente,codactividad)
					VALUES(NOW(),
					'".mysqli_real_escape_string($mysqli,($_POST["validarCargaFecha"]))."',
					'".mysqli_real_escape_string($mysqli,($_POST["validarCargaTipo"]))."',
					'".mysqli_real_escape_string($mysqli,($_POST["validarCargaSoporte"]))."',
					'".mysqli_real_escape_string($mysqli,strtoupper($_POST["validarCargaObservaciones"]))."',
					'".$_SESSION['LMNS-USER_USUARIO']."',
					'".mysqli_real_escape_string($mysqli,$codcliente)."',
					'".mysqli_real_escape_string($mysqli,$swx)."')";          
         			 $d1=mysqli_query($mysqli,$c1);

         			}
			}

$datosgeo=geodatos(sanear_string($row[2]),sanear_string($row[1]),$mysqli);

	$suglatitud="";	
	$suglongitud="";
	$sugzona="";
	$sugbarrio="";

	if($datosgeo!="Error"){
		$datosgeo = explode('|', $datosgeo);    
		$suglatitud=$datosgeo[2];	
		$suglongitud=$datosgeo[3];
		$sugzona=$datosgeo[1];
		$sugbarrio=$datosgeo[4];
	}


 $c1="
INSERT principal(archivocarga,fechacargue,usuariocargue,fechaactividad,codactividad,destinatario,direccion,codciudad,
coddepartamento,cliente,referencia1,referencia2,referencia3,referencia4,referencia5,ruta,ordenamiento,codagente,codcliente,suglatitud,suglongitud,sugzona,sugbarrio)
					VALUE('".($nombre)."',NOW(),
					'".mysqli_real_escape_string($mysqli,$_SESSION['LMNS-USER_USUARIO'])."',
					'".mysqli_real_escape_string($mysqli,$_POST['validarCargaAddFechaa'])."',
					'".mysqli_real_escape_string($mysqli,$swx)."',
					'".mysqli_real_escape_string($mysqli,$row[0])."',
					'".mysqli_real_escape_string($mysqli,$row[1])."',
					'".mysqli_real_escape_string($mysqli,$IdCiudad)."',
					'".mysqli_real_escape_string($mysqli,$IdDepto)."',
					'".mysqli_real_escape_string($mysqli,$row[4])."',
					'".mysqli_real_escape_string($mysqli,$row[5])."',
					'".mysqli_real_escape_string($mysqli,$row[6])."',
					'".mysqli_real_escape_string($mysqli,$row[7])."',
					'".mysqli_real_escape_string($mysqli,$row[8])."',
					'".mysqli_real_escape_string($mysqli,$row[9])."',
					'".mysqli_real_escape_string($mysqli,$row[10])."',
					'".mysqli_real_escape_string($mysqli,$row[11])."',
					'".mysqli_real_escape_string($mysqli,$row[12])."',
					'".mysqli_real_escape_string($mysqli,$codcliente)."',
					'".mysqli_real_escape_string($mysqli,$suglatitud)."',
					'".mysqli_real_escape_string($mysqli,$suglongitud)."',
					'".mysqli_real_escape_string($mysqli,$sugzona)."',
					'".mysqli_real_escape_string($mysqli,$sugbarrio)."')";

					if($d1=mysqli_query($mysqli,$c1)){

						$Ok++;						
						$c2="UPDATE actividad
						set cantidad=cantidad+1
						where cons='".mysqli_real_escape_string($mysqli,$swx)."'";
						$d2=mysqli_query($mysqli,$c2);
						

					}else{	
						$cont_error++;
						$reg_error.='<span>* Error Fila Nº '.$inseR.' No se pudo guardar el registro.</span></br>';
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
	  unlink('gs://lumensarchivostemporales/'.$nombre);
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




function BaseActualizar($mysqli){



	foreach ($_FILES as $key) {
		if($key['error'] == UPLOAD_ERR_OK){//Verificamos si se subio correctamente
		  
			$nombre="ReasignarVisitas.xlsx";
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

					$c="SELECT codagente FROM principal WHERE  
					codactividad='".mysqli_real_escape_string($mysqli,($_POST["BaseActualizarCodigoAct"]))."' 
					AND  cons='".mysqli_real_escape_string($mysqli,($row[0]))."' ";
						$d=mysqli_query($mysqli,$c);
						if(!$r=mysqli_fetch_row($d)){ 
							$cont_error++;
							$reg_error .=  '* Error Fila Nº '.$cont.' visita no encontrada
';
						}else{
								if($r[0]==$row[1]){
									$cont_error++;
									$reg_error .=  '* Error Fila Nº '.$cont.' ya fue asignada a este agente
';
								}else{	



						$c="SELECT nombre FROM agentes WHERE  
						usuario='".mysqli_real_escape_string($mysqli,($row[1]))."'  ";
						$d=mysqli_query($mysqli,$c);
						if($r=mysqli_fetch_row($d)){ 

									$c1="update principal set 
									codagente='".mysqli_real_escape_string($mysqli,$row[1])."',
									fechareasignado=now()
									where cons='".mysqli_real_escape_string($mysqli,$row[0])."'"; 
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


				$row[1]=substr($row[1], 0, 90);
				$row[0]=substr($row[0], 0, 90);

			if($row[11]==""){
					if($ordenruta==""){
						$ordenruta="vacio";
					}else{
						if($ordenruta!="vacio"){
							$cont_error++;
							$reg_error .= '<span>* Error Fila Nº '.$cont.' No Concuerda Ordenamiento.</span></br>';
							$guarda++;
						}
					}				
			}else{
					if($ordenruta==""){
						$ordenruta="ordenado";
					}else{
						if($ordenruta!="ordenado"){
							$cont_error++;
							$reg_error .= '<span>* Error Fila Nº '.$cont.' No Concuerda Ordenamiento.</span></br>';
							$guarda++;
						}
					}
			}

				if($row[0]==""){
					$cont_error++;
					$reg_error .= '<span>* Error Fila Nº '.$cont.' No Cuenta con destinatario.</span></br>';
					$guarda++;
				}


				if($row[1]==""){
					$cont_error++;
					$reg_error .= '<span>* Error Fila Nº '.$cont.' No Cuenta con direccion.</span></br>';
					$guarda++;
				}
				//Verificamos campo ciudad
				if($row[2]==""){
					$cont_error++;
					$reg_error .= '<span>* Error Fila Nº '.$cont.' No Cuenta con Ciudad.</span></br>';
					$guarda++;
				}
				//Verificar campo departamento
				if($row[3]==""){
					$cont_error++;
					$reg_error .= '<span>* Error Fila Nº '.$cont.' No Cuenta con Departamento.</span></br>';
					$guarda++;
				}

				//Verificamos que la ciudad y dpto coincidan
				if($row[2]!='' and $row[3]!=''){


					$c="SELECT d.cons,c.cons FROM ciudades c 
					INNER JOIN  departamentos d ON c.id_departamento=d.cons WHERE  
					c.nombre='".mysqli_real_escape_string($mysqli,($row[2]))."' 
					AND  d.nombre='".mysqli_real_escape_string($mysqli,($row[3]))."' ";
						$d=mysqli_query($mysqli,$c);
						if(!$r=mysqli_fetch_row($d)){ 
							$cont_error++;
							$reg_error .=  '<span>* Error Fila Nº '.$cont.' la Ciudad o Departamento no coincide</span></br>';
							$guarda++;
						}
				}

				if($row[5]==""){
					$cont_error++;
					$reg_error .= '<span>* Error Fila Nº '.$cont.' No Cuenta con referencia 1.</span></br>';
					$guarda++;
				}


				if($row[12]==""){
					$cont_error++;
					$reg_error .= '<span>* Error Fila Nº '.$cont.' No Cuenta con Agente.</span></br>';
					$guarda++;
				}

					if($row[10]==""){
					$cont_error++;
					$reg_error .= '<span>* Error Fila Nº '.$cont.' No Cuenta con Ruta.</span></br>';
					$guarda++;
				}


			if($row[12]!=""){
				$c=" SELECT  nombre FROM agentes WHERE 
				usuario='".mysqli_real_escape_string($mysqli,$row[12])."' "; 
				 $datos2=mysqli_query($mysqli,$c);
				  if(mysqli_num_rows($datos2)<1){
					$cont_error++;
					$reg_error .= '<span>* Error Fila Nº '.$cont.' Agente No Existe.</span></br>';
					$guarda++;
				  }
			}

			if($row[4]!=""){
				$c=" SELECT  cons FROM clientes WHERE 
				nombre='".mysqli_real_escape_string($mysqli,$row[4])."'  "; 
				$datos2=mysqli_query($mysqli,$c);
				  if(mysqli_num_rows($datos2)<1){
				  	$cont_error++;
					$reg_error .= '<span>* Error Fila Nº '.$cont.' Cliente No Existe.</span></br>';
					$guarda++;
				}
			}else{
					$cont_error++;
					$reg_error .= '<span>* Error Fila Nº '.$cont.' No Cuenta con Cliente.</span></br>';
					$guarda++;
			}


			}//End encabezado
			$cont++;

			}//End foreach	


		//Si no hay ningun error procedemos a guardar
			if($guarda==0){


					$c1="INSERT actividad(fechacreacion,fecha,tipo,soporte,observaciones,usuariocarga,cantidad)
					VALUES(NOW(),
					'".mysqli_real_escape_string($mysqli,($_POST["validarCargaFecha"]))."',
					'".mysqli_real_escape_string($mysqli,($_POST["validarCargaTipo"]))."',
					'".mysqli_real_escape_string($mysqli,($_POST["validarCargaSoporte"]))."',
					'".mysqli_real_escape_string($mysqli,strtoupper($_POST["validarCargaObservaciones"]))."',
					'".$_SESSION['LMNS-USER_USUARIO']."',
					'".($cont-2)."')";          
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
						$IdCiudad="";
						$IdDepto="";
					$c="SELECT d.cons,c.cons FROM ciudades c 
					INNER JOIN  departamentos d ON c.id_departamento=d.cons WHERE  
					c.nombre='".mysqli_real_escape_string($mysqli,sanear_string($row[2]))."' 
					AND  d.nombre='".mysqli_real_escape_string($mysqli,sanear_string($row[3]))."' ";
					$d=mysqli_query($mysqli,$c);
					if($r=mysqli_fetch_row($d)){ 
						$IdCiudad=$r[1];
						$IdDepto=$r[0];
					}		

			if($enombrecliente!=strtoupper($row[4])){			
					$c=" SELECT  cons,nombre FROM clientes WHERE 
					nombre='".mysqli_real_escape_string($mysqli,$row[4])."' "; 
					$datos2=mysqli_query($mysqli,$c);
					if($row2=mysqli_fetch_row($datos2)){ 
						$codcliente=$row2[0];
						$enombrecliente=$row2[1];
					}	
					$Xc=" SELECT  cons FROM actividadclientes WHERE 
					codcliente='".mysqli_real_escape_string($mysqli,$codcliente)."' and 
					codactividad='".mysqli_real_escape_string($mysqli,$swx)."' "; 
					$Xdatos2=mysqli_query($mysqli,$Xc);
					if(!$Xrow2=mysqli_fetch_row($Xdatos2)){ 

					$c1="INSERT actividadclientes(fechacreacion,fecha,tipo,soporte,
					observaciones,usuariocarga,codcliente,codactividad)
					VALUES(NOW(),
					'".mysqli_real_escape_string($mysqli,($_POST["validarCargaFecha"]))."',
					'".mysqli_real_escape_string($mysqli,($_POST["validarCargaTipo"]))."',
					'".mysqli_real_escape_string($mysqli,($_POST["validarCargaSoporte"]))."',
					'".mysqli_real_escape_string($mysqli,strtoupper($_POST["validarCargaObservaciones"]))."',
					'".$_SESSION['LMNS-USER_USUARIO']."',
					'".mysqli_real_escape_string($mysqli,$codcliente)."',
					'".mysqli_real_escape_string($mysqli,$swx)."')";          
         			 $d1=mysqli_query($mysqli,$c1);

         			}


			}


	$datosgeo=geodatos(sanear_string($row[2]),sanear_string($row[1]),$mysqli);

	$suglatitud="";	
	$suglongitud="";
	$sugzona="";
	$sugbarrio="";

	if($datosgeo!="Error"){
		$datosgeo = explode('|', $datosgeo);    
		$suglatitud=$datosgeo[2];	
		$suglongitud=$datosgeo[3];
		$sugzona=$datosgeo[1];
		$sugbarrio=$datosgeo[4];
	}

					
 $c1="
INSERT principal(archivocarga,fechacargue,usuariocargue,fechaactividad,codactividad,destinatario,direccion,codciudad,
coddepartamento,cliente,referencia1,referencia2,referencia3,referencia4,referencia5,ruta,ordenamiento,codagente,codcliente,suglatitud,suglongitud,sugzona,sugbarrio)
					VALUE('".($nombre)."',NOW(),
					'".mysqli_real_escape_string($mysqli,$_SESSION['LMNS-USER_USUARIO'])."',
					'".mysqli_real_escape_string($mysqli,$_POST['validarCargaFecha'])."',
					'".mysqli_real_escape_string($mysqli,$swx)."',
					'".mysqli_real_escape_string($mysqli,$row[0])."',
					'".mysqli_real_escape_string($mysqli,sanear_string($row[1]))."',
					'".mysqli_real_escape_string($mysqli,$IdCiudad)."',
					'".mysqli_real_escape_string($mysqli,$IdDepto)."',
					'".mysqli_real_escape_string($mysqli,strtoupper($row[4]))."',
					'".mysqli_real_escape_string($mysqli,$row[5])."',
					'".mysqli_real_escape_string($mysqli,$row[6])."',
					'".mysqli_real_escape_string($mysqli,$row[7])."',
					'".mysqli_real_escape_string($mysqli,$row[8])."',
					'".mysqli_real_escape_string($mysqli,$row[9])."',
					'".mysqli_real_escape_string($mysqli,$row[10])."',
					'".mysqli_real_escape_string($mysqli,$row[11])."',
					'".mysqli_real_escape_string($mysqli,$row[12])."',
					'".mysqli_real_escape_string($mysqli,$codcliente)."',
					'".mysqli_real_escape_string($mysqli,$suglatitud)."',
					'".mysqli_real_escape_string($mysqli,$suglongitud)."',
					'".mysqli_real_escape_string($mysqli,$sugzona)."',
					'".mysqli_real_escape_string($mysqli,$sugbarrio)."')";

					if($d1=mysqli_query($mysqli,$c1)){
						$Ok++;
					}else{	
						$cont_error++;
						$reg_error.='<span>* Error Fila Nº '.$inseR.' No se pudo guardar el registro.</span></br>';
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
	  unlink('gs://lumensarchivostemporales/'.$nombre);
}




function CargaBase(){		
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