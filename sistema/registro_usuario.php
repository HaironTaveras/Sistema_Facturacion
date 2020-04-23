<?php

	session_start();
	if ($_SESSION['rol'] !=1)
	 {
	 	header("location: ./");
			
	 }
	
	require "../conexion.php";

	if(!empty($_POST))
	{

		$alert='';
		if (empty($_POST['nombre']) || empty($_POST['correo']) || empty($_POST['usuario']) || empty($_POST['clave']) || empty($_POST['rol']))		
		{
		  $alert='<p class="msg_error">Todos los campos son obligatorio.</p>';

		}else{

			

			$nombre = strtoupper($_POST['nombre']);
			$email 	= strtoupper($_POST['correo']);
			$user   = strtoupper($_POST['usuario']);
			$clave  = md5($_POST['clave']);
			$rol    = strtoupper($_POST['rol']);

			$query = mysqli_query($conexion,"SELECT * FROM usuario WHERE usuario = '$user' OR correo = '$email'");

			
			$result = mysqli_fetch_array($query);


			if ($result > 0 )
			{

				 $alert='<p class="msg_error">El correo o el usuario ya existen.</p>';

		}else{

				$query_insert=mysqli_query($conexion,"INSERT INTO usuario(nombre,correo,usuario,clave,rol)
																VALUES ('$nombre','$email','$user','$clave','$rol')");
		
				if($query_insert){

						 $alert='<p class="msg_save">Usuario registrador correctamente.</p>';

						 //header('Location: lista_usuario.php');


				}else{

					 $alert='<p class="msg_error">Error al registrar el usuario.</p>';
				}

			}

		}
		
		
		
		
	

}


?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
		<?php include "includes/scripts.php";?>
	
	<title>RegistroUsuario</title>
</head>
<body>
		<?php include "includes/header.php";?>

	<section id="container">
	
<div class="form_register">
	<h1><i class="fas fa-user-plus"></i> Registro Usuario</h1>
	<hr>
	<div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>
	
		<form accion="" method="post">
<label for="nombre">Nombre</label>
<input type="text" name="nombre" id="nombre" placeholder="Nombre Completo">
<label for="correo">Correo Electrónico</label>
<input type="email" name="correo" id="correo" placeholder="Correo Electrónico">
<label for="usuario">Usuario</label>
<input type="text" name="usuario" id="usuario" placeholder="Usuario">
<label for="clave">Clave</label>
<input type="password" name="clave" id="clave" placeholder="Clave de Acceso">
<label for="rol">Tipo Usuario</label>

<?php 
	$query_rol = mysqli_query($conexion,"SELECT * FROM rol");
	mysqli_close($conexion);
	$result_rol= mysqli_num_rows($query_rol);

?>

 	<select name="rol" id="rol">

 <?php
	if ($result_rol > 0)
	{

		while ($rol = mysqli_fetch_array($query_rol)){
	?>
		<option value="<?php echo $rol["idrol"]; ?>"><?php echo $rol["rol"] ?></option>
	<?php
	
    		}
	    }
	?>
	 
 </select>


<button type="submit" class="btn_save"><i class="far fa-save"></i> Crear Usuario</button>

				</form>
				



		</div>


	</section>

		<?php include "includes/footer.php";?>

</body>
</html>