
<?php

session_start();
	if ($_SESSION['rol'] !=1)
	 {
	 	header("location: ./");
			
	 }

	include "../conexion.php";

	if (!empty($_POST))
	{	

			if($_POST['idusuario'] == 1){

				header('Location: lista_usuario.php');
				mysqli_close($conexion);
				exit;

			}

			$idusuario = $_POST['idusuario'];

			$query_update = mysqli_query($conexion, " UPDATE usuario SET estatus = 0 WHERE idusuario = $idusuario ");
			mysqli_close($conexion);

			//PARA ELIMINAR UN REGISTRO
			//$query_delete = mysqli_query($conexion, " DELETE FROM usuario WHERE idusuario = $idusuario ");


			if ($query_update)
			{
				header('Location: lista_usuario.php');
			}else{

				echo "Error al eliminar";
			}

		}
	
	if (empty($_REQUEST['id']) OR $_REQUEST['id']==1 )
	{

		header('Location: lista_usuario.php');
		mysqli_close($conexion);
	}else{
		

		$idusuario=$_REQUEST['id'];

				//VALIDAR QUE EN LA PAGINA EXISTAN ID

		$query = mysqli_query($conexion,"SELECT u.nombre, u.usuario, r.rol
										from usuario u 
										INNER JOIN rol r 
										ON u.rol = r.idrol 
										WHERE u.idusuario=$idusuario");

		mysqli_close($conexion);
		$resultado_sql= mysqli_num_rows($query);

		if ($resultado_sql	> 0){
		
		while ($data = mysqli_fetch_array($query)){


		
			$nombre = $data['nombre'];
			$usuario= $data['usuario'];
			$rol    = $data['rol'];

		}

	}else{

			header('Location: lista_usuario.php');
			//HASTA AQUI
	}

 
}

?>

<!DOCTYPE html>
<html lang="en">
<head>	
<meta charset="UTF-8">
		<?php include "includes/scripts.php";?>
	
	<title>Eliminar Usuario</title>
</head>
<body>
		<?php include "includes/header.php";?>

	<section id="container">
		<div class="data_delete">  
			<i class="fas fa-user-times fa-7x" style="color: #e66262" ></i>
			<br>
			<br>
			<h2>Esta seguro de desactivar el siguiente registro?</h2>
			<P>Nombre <span><?php echo $nombre; ?></span></P>
			<P>Usuario <span><?php echo $usuario; ?></span></P>
			<P>Tipo de Usuario <span><?php echo $rol; ?></span></P>

			<form method="post" action="">
				<input type="hidden" name="idusuario" value ="<?php echo $idusuario; ?>">
				<a href="lista_usuario.php" class="btn_cancel"><i class="fas fa-ban"></i> Cancelar</a>
			
				<button type="submit" class="btn_ok"><i class="fas fa-trash-alt"></i> Aceptar</button>


			</form>
			
		</div>
	</section>

		<?php include "includes/footer.php";?>

</body>
</html>	