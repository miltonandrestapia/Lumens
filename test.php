<?php

	$fecdess="2020-12-30";
	$dias="P20D";
	$mFecha = DateTime::createFromFormat('Y-m-d', $fecdess);
	$mFecha->add(new DateInterval($dias));
	echo $mFecha->format('Y-m-d'); 

?>
 