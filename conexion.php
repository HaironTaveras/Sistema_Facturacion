<?php


$host='localhost';
$user='root';
$password='';
$db='facturacion';


$conexion = @mysqli_connect($host,$user,$password,$db);

		//mysqli_close($conexion);


	if(!$conexion){

	echo "Error en la conexion";

	}
	
?>



