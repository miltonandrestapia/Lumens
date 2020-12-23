<?php

use google\appengine\api\cloud_storage\CloudStorageTools;/*
$gs_name = "cover4.jpg";
echo $gs_namelocal = "https://lumens-1554145071773.appspot.com/cover4.jpg";
// put to cloud storage
$image = file_get_contents($gs_name);
$options = [ "gs" => [ "Content-Type" => "image/jpeg"]];
$ctx = stream_context_create($options);
file_put_contents("gs://lumensarchivostemporales/111".$gs_name, $gs_namelocal, , $ctx);
*/

// get image from Form 
$gs_name = $_FILES["uploaded_files"]["tmp_name"];
 $fileType = $_FILES["uploaded_files"]["type"]; 
 $fileSize = $_FILES["uploaded_files"]["size"]; 
 $fileErrorMsg = $_FILES["uploaded_files"]["error"];
  $fileExt = pathinfo($_FILES['uploaded_files']['name'], PATHINFO_EXTENSION); 
// change name if you want 
$fileName = 'foo.jpg'; 
// put to cloud storage 
$image = file_get_contents($gs_name);
 $options = [ "gs" => [ "Content-Type" => "image/jpeg"]]; 
 $ctx = stream_context_create($options); 
 file_put_contents("gs://lumensarchivostemporales/".$fileName, $gs_name, 0, $ctx); 
 // or move 
 $moveResult = move_uploaded_file($gs_name, 'gs://<bucketname>/'.$fileName); 



// or move 
/*
echo $moveResult = move_uploaded_file($gs_name, 
	'gs://lumensarchivostemporales/'.$gs_name); */



/*
//importamos la libreria de Cloud Storage
use google\appengine\api\cloud_storage\CloudStorageTools;
echo "<br>-<br>";
// obtenemos el nombre del bucket por defecto
// que normalmente, es el mismo nombre del proyecto
echo $bucket = CloudStorageTools::getDefaultGoogleStorageBucketName();
echo "<br>-<br>";

// definimos la ruta inicial para almacenar los archivos
// las ruta privadas del bucket, comienzan por GS://
echo $root_path = 'gs://lumensarchivostemporales/enviados';
echo "<br>-<br>";
$name="TEST.php";
echo $path = $root_path . '/' . $name;

if(file_exists("TEST.php")){
	echo "<br>s1";
}else{
	echo "<br>n1";
}

if(move_uploaded_file("TEST.php", $path)){
	echo "<br>s2";
}else{
	echo "<br>n2";
}

*/
/*
// obtenemos el nombre del archivo via multipart form
$name = $_FILES['file']['name'];

// obtenemos el nombre de la carpeta a donde se almacenara el archivo
// via multipart form
$folder = 'general';

if (isset($_REQUEST['folder'])) {
	$folder = $_REQUEST['folder'];
}

// fijamos la nueva ruta para almacenar los archivos
// esta es una ruta privada del Bucket
$path = $root_path . '/' . $folder . '/' . $name;

// guardamos el archivo
move_uploaded_file($_FILES['file']['tmp_name'], $path);

// respuesta de la carga
$request['state']='archivo almacenado';
$request['folder']=$folder;
$request['path']=$path;

//enviamos la respuesta al usuario
echo json_encode($request);
*/