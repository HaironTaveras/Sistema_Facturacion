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

			$idproveedor  =	$_POST['id'];
			$proveedor    = strtoupper($_POST['proveedor']);
			$rnc   		  = $_POST['rnc'];
			$contacto     = strtoupper($_POST['contacto']);
			$telefono 	  = $_POST['telefono'];
			$direccion    = strtoupper($_POST['direccion']);
			$usuario_id   = $_SESSION['iduser'];

		

			$sql_update= mysqli_query($conexion,"UPDATE proveedor
													SET proveedor='$proveedor', rnc = '$rnc', contacto='$contacto',telefono='$telefono', direccion='$direccion' 
													WHERE codproveedor= $idproveedor ");
			
			
			if ($sql_update)
				{
					 $alert='<p class="msg_save">Proveedor actualizado correctamente.</p>';
					 //header('Location: lista_usuario.php');
				

			}else{

					 $alert='<p class="msg_error">Error al actualizar el Proveedor.</p>';
				}

			}

		}

	

		
	//MOSTRAR DATOS
	if(empty($_REQUEST['id']))
	{

		header('Location: lista_proveedor.php');
		mysqli_close($conexion);

	}

	$idproveedor = $_REQUEST['id'];

	$sql= mysqli_query($conexion,"SELECT * FROM proveedor WHERE codproveedor=$idproveedor and estatus=1");
	mysqli_close($conexion);
	$resultado_sql= mysqli_num_rows($sql);

		if ($resultado_sql	== 0){
		
			header('Location: lista_proveedor.php');
 		}else{	

			while ($data = mysqli_fetch_array($sql)){

			$idproveedor = $data['codproveedor'];
			$proveedor = strtoupper($data['proveedor']);
			$rnc       = $data['rnc'];
			$contacto    = strtoupper($data['contacto']);
			$telefono  = $data['telefono'];
			$direccion = strtoupper($data['direccion']);
				
		}	
	}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
		<?php include "includes/scripts.php";?>
	
	<title>Actualizar Proveedor</title>
</head>
<body>
		<?php include "includes/header.php";?>

	<section id="container">
	
<div class="form_register">
	<h1><i class="fas fa-edit"></i> Actualizar proveedor</h1>
	<hr>
	<div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>

	<form accion="" method="post">

		<input type="hidden" name="id" value="<?php echo $idproveedor  ?>"  >
	
		<label for="proveedor">Proveedor</label>
		<input type="text" name="proveedor" id="proveedor" placeholder="Nombre del Proveedor" value="<?php echo $proveedor  ?>" >

		<label for="rnc">RNC</label>
		<input type="number" name="rnc" id="rnc" placeholder="RNC o Cedula del Proveedor" value="<?php echo $rnc  ?>" >

		<label for="contacto">Contacto</label>
		<input type="text" name="contacto" id="contacto" placeholder="Nombre Completo del Contacto" value="<?php echo $contacto  ?>">

		<label for="telefono">Teléfono</label>
		<input type="number" name="telefono" id="telefono" placeholder="Teléfono" value="<?php echo $telefono  ?>">

		<label for="clave">Dirección</label>
		<input type="text" name="direccion" id="direccion" placeholder="Dirección Completa" value="<?php echo $direccion  ?>">

			
	
		 <button type="submit" class="btn_save"><i class="fas fa-edit"></i> Actualizar Proveedor</button>
 </form>
	
		
				
		</div>


	</section>

		<?php include "includes/footer.php";?>

</body>
</html>