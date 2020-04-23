
<?php

session_start();
	if($_SESSION['rol'] !=1 and $_SESSION['rol'] !=2 )
	 {
	 	header("location: ./");
			
	 }

	include "../conexion.php";

	if(!empty($_POST))
	{	

			if(empty($_POST['idcliente'])) 
			{
				header('Location: lista_cliente.php');
				mysqli_close($conexion);
			}

			$idcliente = $_POST['idcliente'];

			$query_update = mysqli_query($conexion, " UPDATE cliente SET estatus = 0 WHERE idcliente = $idcliente ");
			mysqli_close($conexion);

			//PARA ELIMINAR UN REGISTRO
			//$query_delete = mysqli_query($conexion, " DELETE FROM usuario WHERE idusuario = $idusuario ");


			if ($query_update)
			{
				header('Location: lista_cliente.php');
			}else{

				echo "Error al desactivar";
			}

		}




	
	if (empty($_REQUEST['id']))
	{

		header('Location: lista_cliente.php');
		mysqli_close($conexion);
	}else{
		

		$idcliente=$_REQUEST['id'];

				//VALIDAR QUE EN LA PAGINA EXISTAN ID

		$query = mysqli_query($conexion,"SELECT * from cliente where idcliente =$idcliente");

		mysqli_close($conexion);
		$resultado_sql= mysqli_num_rows($query);

		if ($resultado_sql	> 0){
		
		while ($data = mysqli_fetch_array($query)){

			$rnc     = $data['rnc'];
			$nombre = $data['nombre'];
			
		}

	}else{

			header('Location: lista_cliente.php');
			//HASTA AQUI
	}

 
}

?>

<!DOCTYPE html>
<html lang="en">
<head>	
<meta charset="UTF-8">
		<?php include "includes/scripts.php";?>
	
	<title>Desactivar Cliente</title>
</head>
<body>
		<?php include "includes/header.php";?>

	<section id="container">
		<div class="data_delete"> 
			<i class="fas fa-user-times fa-7x" style="color: #e66262" ></i>
			<br>
			<br> 
			<h2>Esta seguro de desactivar el siguiente registro?</h2>
			<P>Nombre del Cliente : <span><?php echo $nombre; ?></span></P>
			<P>RNC : <span><?php echo $rnc; ?></span></P>
		

			<form method="post" action="">
				<input type="hidden" name="idcliente" value ="<?php echo $idcliente; ?>">
				<a href="lista_cliente.php" class="btn_cancel"><i class="fas fa-ban"></i> Cancelar</a>
			
				<button type="submit" class="btn_ok"><i class="fas fa-trash-alt"></i> Desactivar</button>


			</form>
			
		</div>
	</section>

		<?php include "includes/footer.php";?>

</body>
</html>	