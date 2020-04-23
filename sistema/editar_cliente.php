<?php

session_start();


	// if ($_SESSION['rol'] !=1)
	//  {
	//  	header("location: ./");
			
	//  }

	require "../conexion.php";

	 if(!empty($_POST))
	{

		$alert='';
		if (empty($_POST['nombre']) || empty($_POST['telefono']) || empty($_POST['direccion']))		
		{
		  $alert='<p class="msg_error">Todos los campos son obligatorio.</p>';

		}else{

			
			$idcliente  = $_POST['id'];
			$rnc  		= $_POST['rnc'];
			$nombre 	= strtoupper($_POST['nombre']);
			$telefono   = $_POST['telefono'];
			$direccion  = strtoupper($_POST['direccion']);

			$result=0;
			
			if(is_numeric($rnc) and $rnc !=0)
			 {
				$query = mysqli_query($conexion,"SELECT * FROM cliente 
												 WHERE (rnc = '$rnc' and idcliente !=$idcliente)
												 ");


				$result = mysqli_fetch_array($query);
				//$result = count($result);
	
			 
			}
			if($result > 0)
			{

				 $alert='<p class="msg_error">El RNC ya existen.</p>';

		}else{
			if($rnc =='') 
			{
				$rnc = 0;
			}

			$sql_update= mysqli_query($conexion,"UPDATE cliente
													SET  rnc = '$rnc', nombre='$nombre',telefono='$telefono', direccion='$direccion' 
													WHERE idcliente= $idcliente");
			
			
			if ($sql_update)
				{
					 $alert='<p class="msg_save">Cliente actualizado correctamente.</p>';
					 //header('Location: lista_usuario.php');
				

			}else{

					 $alert='<p class="msg_error">Error al actualizar el Cliente.</p>';
				}

			}

		}

	}

		
	//MOSTRAR DATOS
	if(empty($_REQUEST['id']))
	{

		header('Location: lista_cliente.php');
		mysqli_close($conexion);

	}

	$idcliente = $_REQUEST['id'];

	$sql= mysqli_query($conexion,"SELECT * FROM cliente WHERE idcliente=$idcliente and estatus=1 ");
	mysqli_close($conexion);
	$resultado_sql= mysqli_num_rows($sql);

		if ($resultado_sql	== 0){
		
			header('Location: lista_cliente.php');
 		}else{	

			while ($data = mysqli_fetch_array($sql)){

			$idcliente = $data['idcliente'];
			$rnc       = $data['rnc'];
			$nombre    = $data['nombre'];
			$telefono  = $data['telefono'];
			$direccion = $data['direccion'];
				
		}	
	}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
		<?php include "includes/scripts.php";?>
	
	<title>Actualizar Cliente</title>
</head>
<body>
		<?php include "includes/header.php";?>

	<section id="container">
	
<div class="form_register">
	<h1><i class="fas fa-edit"></i> Actualizar Cliente</h1>
	<hr>
	<div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>
	
		<form accion="" method="post">

		<input type="hidden" name="id" value="<?php echo $idcliente; ?>">
	
		<label for="rnc">RNC</label>
		<input type="number" name="rnc" id="rnc" placeholder="Número RNC" value="<?php echo $rnc; ?>">

		<label for="nombre">Nombre</label>
		<input type="text" name="nombre" id="nombre" placeholder="Nombre Completo" value="<?php echo $nombre; ?>">

		<label for="telefono">Teléfono</label>
		<input type="number" name="telefono" id="telefono" placeholder="Teléfono" value="<?php echo $telefono; ?>">

		<label for="direccion">Dirección</label>
		<input type="text" name="direccion" id="direccion" placeholder="Dirección Completa" value="<?php echo $direccion; ?>">

			
	
		 <button type="submit" class="btn_save"><i class="far fa-save"></i> Actualizar Usuario</button>	
 </form>
				
		</div>


	</section>

		<?php include "includes/footer.php";?>

</body>
</html>