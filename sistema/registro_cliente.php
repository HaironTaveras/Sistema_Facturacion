<?php

	session_start();


	require "../conexion.php";

	if(!empty($_POST))
	{

		$alert='';
		if (empty($_POST['nombre']) || empty($_POST['telefono']) || empty($_POST['direccion']))		
		{
		  $alert='<p class="msg_error">Todos los campos son obligatorio.</p>';

		}else{

			
			$rnc   		 = $_POST['rnc'];
			$nombre      = strtoupper($_POST['nombre']);
			$telefono 	 = $_POST['telefono'];
			$direccion   = strtoupper($_POST['direccion']);
			$usuario_id  = $_SESSION['iduser'];

			$result=0;
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
			{
				$query_insert=mysqli_query($conexion,"INSERT INTO cliente(rnc,nombre,telefono,direccion,usuario_id)
													  VALUES ('$rnc','$nombre','$telefono','$direccion','$usuario_id')");


					if($query_insert){
					$alert='<p class="msg_save">Cliente registrador correctamente.</p>';
					header('Location: lista_cliente.php');

			}else{
					$alert='<p class="msg_error">Error al registrar el cliente.</p>';
				}
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
	
	<title>Registro Cliente</title>
</head>
<body>
		<?php include "includes/header.php";?>

	<section id="container">
	
<div class="form_register">
	<h1><i class="fas fa-user-plus"></i> Registro Cliente</h1>
	<hr>
	<div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>
	
<form accion="" method="post">
	
		<label for="rnc">RNC</label>
		<input type="number" name="rnc" id="rnc" placeholder="Número RNC">

		<label for="nombre">Nombre</label>
		<input type="text" name="nombre" id="nombre" placeholder="Nombre Completo">

		<label for="telefono">Teléfono</label>
		<input type="number" name="telefono" id="telefono" placeholder="Teléfono">

		<label for="clave">Dirección</label>
		<input type="text" name="direccion" id="direccion" placeholder="Dirección Completa">

			
	
		 <button type="submit" class="btn_save"><i class="far fa-save"></i> Guardar Cliente</button>
 </form>
				



		</div>


	</section>

		<?php include "includes/footer.php";?>

</body>
</html>