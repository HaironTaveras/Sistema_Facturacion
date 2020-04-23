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
		if(empty($_POST['proveedor']) || empty($_POST['producto']) || empty($_POST['costo']) || $_POST['costo'] <=0 ||  empty($_POST['precio']) || $_POST['precio'] <=0 || empty($_POST['cantidad']) || $_POST['cantidad'] <=0)		
		{
		  $alert='<p class="msg_error">Todos los campos son obligatorio.</p>';

		}else{

			$proveedor    = $_POST['proveedor'];
			$producto     = strtoupper($_POST['producto']);
			$costo 	 	  = $_POST['costo'];
			$precio 	  = $_POST['precio'];
			$cantidad 	  = $_POST['cantidad'];
			$usuario_id   = $_SESSION['iduser'];

			$foto = $_FILES ['foto'];
			$nombre_foto =$foto['name'];
			$type		 =$foto['type'];
			$url_temp	 =$foto['tmp_name'];

			$img_producto = 'img_producto.png';

			if ($nombre_foto !='') 
			{
				$destino = 'img/uploads/';
				$img_nombre='img_'.md5(date('d-m-Y H:m:s'));
				$img_producto = $img_nombre.'.jpg';
				$src          =$destino.$img_producto;
			}

	
				$query_insert=mysqli_query($conexion,"INSERT INTO producto(proveedor,descripcion,costo,precio,
																  existencia, usuario_id, foto)

													  VALUES ('$proveedor', '$producto','$costo','$precio','$cantidad','$usuario_id','$img_producto')");


			if($query_insert){

				if($nombre_foto !='') {
						move_uploaded_file($url_temp, $src);
				}
					$alert='<p class="msg_save">Producto registrador correctamente.</p>';
					

			}else{
					$alert='<p class="msg_error">Error al registrar el Producto.</p>';
				}
			}
		


		
	}


?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
		<?php include "includes/scripts.php";?>
	
	<title>Registro de Producto</title>
</head>
<body>
		<?php include "includes/header.php";?>

	<section id="container">
	
<div class="form_register">
	<h1><i class="fas fa-cubes fa-lg"></i> Registro de Producto</h1>
	<hr>
	<div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>
	
	<form accion="" method="post" enctype="multipart/form-data">

	
		<label for="proveedor">Proveedor</label>

		<?php 
			$query_proveedor=mysqli_query($conexion,"SELECT codproveedor, proveedor FROM  proveedor where estatus=1 ORDER BY proveedor asc ;");

			$result_proveedor=mysqli_num_rows($query_proveedor);
			mysqli_close($conexion);

		 ?>
		 <select name="proveedor" id="proveedor">
		 <?php 
		 	if ($query_proveedor >0) {
		 		while ($proveedor = mysqli_fetch_array($query_proveedor)) {

		 		 ?>	
		 		 	<option value="<?php echo $proveedor['codproveedor']; ?>"><?php echo $proveedor['proveedor'];  ?></option>

		 <?php
		 		}	
		 		
		 	}

		 ?>
				
		 </select>



		<label for="producto">Producto</label>
		<input type="text" name="producto" id="producto" placeholder="Nombre del Producto">



		<label for="costo">Costo</label>
		<input type="number" name="costo" id="costo" placeholder="Costo del Producto">

		<label for="precio">Precio</label>
		<input type="number" name="precio" id="precio" placeholder="Precio del Producto">

		<label for="cantidad">Cantidad</label>
		<input type="number" name="cantidad" id="cantidad" placeholder="Cantidad del Producto">


		<div class="photo">
			<label for="foto">Foto</label>
		        <div class="prevPhoto">
		        <span class="delPhoto notBlock">X</span>
		        <label for="foto"></label>
		        </div>
		        <div class="upimg">
		        <input type="file" name="foto" id="foto">
		        </div>
		        <div id="form_alert"></div>
		</div>

		
			
	
		 <button type="submit" class="btn_save"><i class="far fa-save"></i> Guardar Producto</button>
 </form>
				



		</div>


	</section>

		<?php include "includes/footer.php";?>

</body>
</html>