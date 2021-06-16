<?php
	$mysqli = new mysqli("localhost","root","","db_variedadesotaci"); 
	
	if(mysqli_connect_errno()){
		echo 'Conexion Fallida : ', mysqli_connect_error();
		exit();
	}
?>