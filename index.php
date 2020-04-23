<?php

$alert= '';
session_start();

if (!empty($_SESSION['active']))
{

header('location: sistema/');

}else{

if (!empty($_POST))
{
	IF (empty($_POST['usuario'] ) or empty($_POST['clave']))
	{
		$alert= 'Ingrese su Usuario y su clave';

	}else{	

		require_once "conexion.php";
		$user=mysqli_real_escape_string($conexion,$_POST['usuario']);
		$pass=md5 (mysqli_real_escape_string($conexion,$_POST['clave']));

		$query=mysqli_query($conexion,"SELECT *FROM usuario WHERE usuario = '$user' AND clave='$pass'");

		mysqli_close($conexion);
		//GUARDAR VARIABLES
		$resultado= mysqli_num_rows($query);

		IF($resultado> 0 )
		{
			$data=mysqli_fetch_array($query);
			$_SESSION['active'] = true;
			$_SESSION['iduser'] = $data['idusuario'];
			$_SESSION['nombre'] = $data['nombre'];
			$_SESSION['email'] = $data['correo'];
			$_SESSION['user'] = $data['usuario'];
			$_SESSION['rol'] = $data['rol'];

			header('location: sistema/');
			}else
			{
				$alert ='El usuario o la clave son incorrecta';
				session_destroy();
				
			}
		}
	}

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Login-Sistema Facturacion</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
   <section id="container">
   	  <form action="" method="post" accept-charset="utf-8">
				<h3>Iniciar Sesión</h3>
		<img src="img/login.png" alt="Login">
		<input type="text" name="usuario" placeholder="Usuario">
		<input type="password" name="clave" placeholder="Contraseñas">
		<div class="alert"><?php echo isset($alert) ? $alert : ''; ?> </div>
		<input type="submit" value="Ingresar">
		</form>
	</section>
  </body>
</html>
