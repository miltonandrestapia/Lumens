<?php

echo $server_ip = gethostbyname($_SERVER['SERVER_NAME']);
echo gethostbyname($host) . "-<BR>"; //Esto da la ip del cliente. 
echo $ip = $_SERVER['SERVER_ADDR'] . "-<BR>"; //Esto da la ip del Servidor. 
echo $ip = $_SERVER['LOCAL_ADDR'] . "-<BR>"; //Esto da la ip del Servidor. 
	/*
	if(include 'SimpleXLSX.php'){
		echo "s";
	}else{
		echo "n";
	}


if ( $xlsx = SimpleXLSX::parse('https://storage.googleapis.com/lumens-1554145071773.appspot.com/1559946834.xlsx' ) ) {
	list($num_cols, $num_rows) = $xlsx->dimension(0); // don't dimension trust extracted from xml
	echo $xlsx->sheetName(0).':'.$num_cols.'x'.$num_rows;


			foreach( $xlsx->rows() as $row ) {
				echo "<br>".$row[1];
			}
} else {
	echo SimpleXLSX::parseError();
}
*/
?>