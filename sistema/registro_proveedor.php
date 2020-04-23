<?php

	session_start();

	if ($_SESSION['rol'] !=1 AND $_SESSION['rol'] !=2)
	 {
	 	header("location: ./");
			
	 }
	


	require "../conexion.php";

	if(!empty($_POST))
	{

		$alert='';
		if(empty($_POST['proveedor']) || empty($_POST['rnc']) || empty($_POST['contacto']) || empty($_POST['telefono']) || empty($_POST['direccion']))		
		{
		  $alert='<p class="msg_error">Todos los campos son obligatorio.</p>';

		}else{

			$proveedor    = strtoupper($_POST['proveedor']);
			$rnc   		  = $_POST['rnc'];
			$contacto     = strtoupper($_POST['contacto']);
			$telefono 	  = $_POST['telefono'];
			$direccion    = strtoupper($_POST['direccion']);
			$usuario_id   = $_SESSION['iduser'];

			/*$result=0;
			//FUNCION PARA VALIDAR QUE ES NUMERICO
			if (is_numeric($rnc))
			{
				$query = mysqli_query($conexion,"SELECT * FROM cliente WHERE rnc = '$rnc' ");
				$result = mysqli_fetch_array($query);
			}

			if ($result > 0)
			{
				 $alert='<p class="msg_error">El Número de RNC ya existen.</p>';
			}else
			{*/
				$query_insert=mysqli_query($conexion,"INSERT INTO proveedor(proveedor,rnc,contacto, telefono,direccion,usuario_id)
													  VALUES ('$proveedor', '$rnc','$contacto','$telefono','$direccion','$usuario_id')");


			if($query_insert){
					$alert='<p class="msg_save">Proveedor registrador correctamente.</p>';
					

			}else{
					$alert='<p class="msg_error">Error al registrar el proveedor.</p>';
				}
			}
		
			mysqli_close($conexion);

		
	}


?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
		<?php include "includes/scripts.php";?>
	
	<title>Registro Proveedor</title>
</head>
<body>
		<?php include "includes/header.php";?>

	<section id="container">
	
<div class="form_register">
	<h1><i class="fas fa-building"></i>Registro Proveedor</h1>
	<hr>
	<div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>
	
<form accion="" method="post">
	
		<label for="proveedor">Proveedor</label>
		<input type="text" name="proveedor" id="proveedor" placeholder="Nombre del Proveedor">

		<label for="rnc">RNC</label>
		<input type="number" name="rnc" id="rnc" placeholder="RNC o Cedula del Proveedor">

		<label for="contacto">Contacto</label>
		<input type="text" name="contacto" id="contacto" placeholder="Nombre Completo del Contacto">

		<label for="telefono">Teléfono</label>
		<input type="number" name="telefono" id="telefono" placeholder="Teléfono">

		<label for="clave">Dirección</label>
		<input type="text" name="direccion" id="direccion" placeholder="Dirección Completa">

			
	
		 <button type="submit" class="btn_save"><i class="far fa-save"></i> Guardar Proveedor</button>
 </form>
				



		</div>


	</section>

		<?php include "includes/footer.php";?>

</body>
</html>