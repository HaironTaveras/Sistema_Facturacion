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
		if (empty($_POST['nombre']) || empty($_POST['correo']) || empty($_POST['usuario']) || empty($_POST['rol']))		
		{
		  $alert='<p class="msg_error">Todos los campos son obligatorio.</p>';

		}else{

			
			$idusuario=$_POST['id'];
			$nombre = strtoupper($_POST['nombre']);
			$email 	= strtoupper($_POST['correo']);
			$user   = strtoupper($_POST['usuario']);
			$clave  = md5($_POST['clave']);
			$rol    = strtoupper($_POST['rol']);

		

			$query = mysqli_query($conexion,"SELECT * FROM usuario 
													  WHERE (usuario = '$user' AND idusuario!= $idusuario)
													  OR (correo = '$email' AND idusuario != $idusuario)");


			$result = mysqli_fetch_array($query);
			//$result= count($result);


			if ($result > 0)
			{

				 $alert='<p class="msg_error">El correo o el usuario ya existen.</p>';

		}else{

			if(empty($_POST['clave']))
			{

				$sql_update= mysqli_query($conexion,"UPDATE usuario
													SET  nombre = '$nombre', correo='$email', usuario='$user', rol='$rol' 
													WHERE idusuario= $idusuario");
			}else
			{

				$sql_update= mysqli_query($conexion,"UPDATE usuario
													 SET  nombre = '$nombre', correo='$email', usuario='$user', clave='$clave', rol='$rol' 
													 WHERE idusuario= $idusuario");
			}	
			

				if ($sql_update)
				{
					 $alert='<p class="msg_save">Usuario actualizado correctamente.</p>';
					 //header('Location: lista_usuario.php');
				

				}else{

					 $alert='<p class="msg_error">Error al actualizar el usuario.</p>';
				}

			}

		}
		

	
}
	//MOSTRAR DATOS
	if(empty($_REQUEST['id']))
	{

		header('Location: lista_usuario.php');
		mysqli_close($conexion);

	}

	$iduser = $_REQUEST['id'];

	$sql= mysqli_query($conexion,"SELECT u.idusuario, u.nombre, u.correo, u.usuario, (u.rol) as idrol, (r.rol) as rol 
								  from usuario u 
								  INNER JOIN rol r 
								  ON u.rol = r.idrol 
								  WHERE idusuario=$iduser AND estatus =1 ");
								  
	mysqli_close($conexion);

	$resultado_sql= mysqli_num_rows($sql);

		if ($resultado_sql	==0){
		
			header('Location: lista_usuario.php');


		}else{	

				$option = "";

			while ($data = mysqli_fetch_array($sql)){


			$iduser = $data['idusuario'];
			$nombre = $data['nombre'];
			$correo = $data['correo'];
			$usuario= $data['usuario'];
			$idrol  = $data['idrol'];
			$rol    = $data['rol'];

			if($idrol ==1){

				$option='<option value="'.$idrol.'" select>'.$rol.'</option>';

			}else if ($idrol ==2) {

				$option='<option value="'.$idrol.'" select>'.$rol.'</option>';
				# code...
			}else if ($idrol ==3) {
				
				$option='<option value="'.$idrol.'" select>'.$rol.'</option>';
		}	
	}	
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
		<?php include "includes/scripts.php";?>
	
	<title>Actualizar Usuario</title>
</head>
<body>
		<?php include "includes/header.php";?>

	<section id="container">
	
<div class="form_register">
	<h1><i class="fas fa-edit"></i> Actualizar Usuario</h1>
	<hr>
	<div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>
	
		<form accion="" method="post">
<input type="hidden" name="id" value="<?php echo $iduser;?>">
<label for="nombre">Nombre</label>
<input type="text" name="nombre" id="nombre" placeholder="Nombre Completo" value="<?php echo $nombre; ?>" >
<label for="correo">Correo Electrónico</label>
<input type="email" name="correo" id="correo" placeholder="Correo Electrónico" value="<?php echo $correo; ?>">
<label for="usuario">Usuario</label>
<input type="text" name="usuario" id="usuario" placeholder="Usuario" value="<?php echo $usuario; ?>">
<label for="clave">Clave</label>
<input type="password" name="clave" id="clave" placeholder="Clave de Acceso">
<label for="rol">Tipo Usuario</label>

<?php 

	require "../conexion.php";
	$query_rol = mysqli_query($conexion,"SELECT * FROM rol");
	mysqli_close($conexion);
	$result_rol= mysqli_num_rows($query_rol);

?>
					<!-- CLASE PARA NO MOSTRAR LOS ITEM DUPLICADO CUANDO LO SELECIONA-->
 	<select name="rol" id="rol" class="NotItemOne">

 <?php
 	
 	echo $option;

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


 	<button type="submit" class="btn_save"><i class="far fa-save"></i> Actualizar Usuario</button>		
				
		</form>
				
		</div>


	</section>

		<?php include "includes/footer.php";?>

</body>
</html>