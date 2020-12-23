<?php
require_once("Conexion.php");
session_start(); 


	if(!empty($_POST["Guardar"])){
		Guardar($mysqli);
	}else if(!empty($_POST["Listar"])){
		Lista($mysqli);
	}else if(!empty($_POST["Editar"])){
		Editar($mysqli);
	}else if(!empty($_POST["Actulizar"])){
		Actualizar($mysqli);
	}else if(!empty($_POST["Eliminar"])){
		Eliminar($mysqli);
	}else{
		echo "Archivo Erroneo";	
	}	


	//*** Guardar Noticias
	function Guardar($mysqli){

		$nombre='';
		$ruta="../Archivos/Noticias/";
		foreach ($_FILES as $key) {
			if($key['error'] == UPLOAD_ERR_OK ){//Verificamos si se subio correctamente
			  $nombre = time().$key['name'];
			  $temporal = $key['tmp_name']; //Obtenemos el nombre del archivo temporal
			  move_uploaded_file($temporal, $ruta.$nombre); //Movemos el archivo temporal a la ruta especificada					

			}	
		}

  			$consulta="INSERT noticias (encabezado,archivo,descripcion,usuariocarga,codempresa,fechacarga) VALUES(
  			'".mysqli_real_escape_string($mysqli,strtoupper($_POST["titulo"]))."',
  			'".mysqli_real_escape_string($mysqli,$nombre)."',
  			'".mysqli_real_escape_string($mysqli,strtoupper($_POST["descripcion"]))."',
  			'".mysqli_real_escape_string($mysqli,($_POST["codusuario"]))."',
  			'".mysqli_real_escape_string($mysqli,($_POST["codcode"]))."',CURDATE())";            
          if( $datos=mysqli_query($mysqli,$consulta) ){ 
            echo 'OK';
          }else{
            echo 'Error';
          }			
	}

	//*** Funcion listar todas las noticias
	function Lista($mysqli){

		$consulta="SELECT cons,encabezado,archivo,fechacarga,usuariocarga FROM noticias where 
		usuariocarga='".mysqli_real_escape_string($mysqli,$_POST["Listaruser"])."' ORDER BY cons ASC";
	

$datos=mysqli_query($mysqli,$consulta);

		$tabla='<table id="example" class="display" cellspacing="0" width="100%" style="font-size:12px; text-align:left;">
				<thead>
					<tr>
					<th width="1%">Cons</th>
						<th >Encabezado</th>
					    <th  width="80">Fecha</th>
						<th  width="80">Archivo</th>
						<th  width="80">Opciones</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th width="1%">Cons</th>
						<th >Encabezado</th>
					    <th  width="80">Fecha</th>
						<th  width="80">Archivo</th>
						<th  width="80">Opciones</th>
					</tr>
				</tfoot>	
				<tbody>';	
		
				$count=1;    
while($row=mysqli_fetch_row($datos)){ 

			   $tabla .='<tr>
			            <td class="sobretd text-left" tittle="'.$row[0].'">'.$count.'</td>
			            <td class="sobretd text-left" tittle="'.$row[0].'">'.$row[1].'</td>';
						
						if($row[2]!=''){
							$archivo='<a class="btn btn-success " href="Archivos/Noticias/'.$row[2].'" target="_blank" ">Descargar 
							<i class="fa fa-cloud-download"></i></a>';
						}else{
							$archivo='<span>Sin archivos</span>';
						}
	$optione="";
						if($row[4]==$_POST["Listaruser"]){
							$optione='<button class="btn btn-danger " onclick="Eliminar('.$row[0].');" title="Eliminar Noticias">
							<i class="fa fa-trash-o"></i></button>
<a href="AdmNoticiasDetalle.php?cod='.$row[0].' ">
							<button class="btn btn-primary "  title="Ver">
							<i class="fa fa-search"></i></button></a>';
						}


				$tabla.='
						<td class="sobretd text-left" tittle="'.$row[0].'">'.$row[3].'</td><td class="sobretd text-left" tittle="'.$row[0].'">'.$archivo.'</td>
						<td ><center>'.$optione.'
							</center>
						</td>
					</tr>';
								
					$count++;
				}

			$tabla.="</tbody></table>";

			echo $tabla;

	}


	//*** Funcion Eliminar Noticia
	function Eliminar($mysqli){
	
			$consulta="DELETE FROM noticias WHERE 
			cons='".mysqli_real_escape_string($mysqli,strtoupper($_POST["Eliminar"]))."'";            
          if( $datos=mysqli_query($mysqli,$consulta) ){ 
            echo 'OK';
          }else{
            echo 'Error';
          }			
	}




?>