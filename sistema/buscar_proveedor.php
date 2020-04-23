<?php

session_start();

if ($_SESSION['rol'] !=1 AND $_SESSION['rol'] !=2)
	 {
	 	header("location: ./");
			
	 }



include "../conexion.php";

?>



<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
		<?php include "includes/scripts.php";?>
	
	<title>Lista de Proveedores</title>
</head>
<body>
		<?php include "includes/header.php";?>

	<section id="container">

		<?php
			//FUNCION PARA CONVETIR EN MINUSCULA "strtolower" Y strtoupper EN MAYUSCULA
		$busqueda = strtoupper($_REQUEST['busqueda']);
			if(empty($busqueda	))
			{
				header('Location: lista_proveedor.php');
				mysqli_close($conexion);
			}


		 ?>
		
		<h1><i class="fas fa-building"></i>  Lista de Proveedores</h1>
		<a href="lista_proveedor.php" class="btn_new"><i class="fas fa-plus"></i> Registrar Proveedores</a> 

		<form action="buscar_proveedor.php" method="get" class="formulario_buscar"> 
			<input type="text" name="busqueda" id="busqueda" placeholder="Buscar" value="<?PHP echo $busqueda; ?>">
		
			<button type="submit"class="btn_buscar"> <i class="fas fa-search"></i></button>


		</form>

		<table>
		<tr>
				
				<th>ID</th>
				<th>PROVEEDOR</th>
				<th>RNC</th>
				<th>CONTACTO</th>
				<th>TELÉFONO</th>
				<th>DIRECCIÓN</th>
				<th>FECHA</th>
				<th>ACCIONES</th>

			</tr>

			<?php

				//PAGINADOR

				$sql_registro = mysqli_query($conexion,"SELECT COUNT(*) AS total_registro FROM 	proveedor 
														WHERE (codproveedor  like '%$busqueda%' OR 
																proveedor 	  like '%$busqueda%' OR
																rnc    like '%$busqueda%' OR
																contacto    like '%$busqueda%' OR
																telefono  like '%$busqueda%' OR
																direccion like '%$busqueda%')
    													AND estatus=1");


				$resultado_registro = mysqli_fetch_array($sql_registro);
				$total_registro = $resultado_registro['total_registro'];

				$por_pagina = 5;


					if(empty($_GET['pagina']))

					{
						$pagina=1;

					}else{

						$pagina =$_GET['pagina'];
					}

					$desde = ($pagina-1) * $por_pagina;
					$total_paginas = ceil($total_registro / $por_pagina);



				$query = mysqli_query($conexion,"SELECT * FROM proveedor WHERE 
											         		(codproveedor    like '%$busqueda%' OR 
																proveedor 	 like '%$busqueda%' OR
																rnc          like '%$busqueda%' OR
																contacto     like '%$busqueda%' OR
																telefono     like '%$busqueda%' OR
																direccion    like '%$busqueda%') 	 
												AND 
											    estatus =1 ORDER BY codproveedor ASC LIMIT $desde,$por_pagina");

				mysqli_close($conexion);
				$resultado = mysqli_num_rows($query);

				if($resultado > 0){

					while ($data = mysqli_fetch_array($query)){

						$formato = 'Y-m-d H:i:s';
						$fecha = DateTime::createfromformat($formato, $data["date_add"]);

			?>
				

		  	  <tr>
				
				<td><?php echo $data['codproveedor']?></td>
				<td><?php echo $data['rnc']?></td>
				<td><?php echo $data['proveedor']?></td>
				<td><?php echo $data['contacto']?></td>
				<td><?php echo $data['telefono']?></td>
				<td><?php echo $data['direccion']?></td>
				<td><?php echo $fecha->format('d-m-Y')?></td>
				
				<td>


					
					<a class="link_edit" href="editar_proveedor.php?id=<?php echo $data['codproveedor'];?>"><i class="fas fa-edit"></i>   Editar</a>

					|
					<a class="link_delete" href="eliminar_confirmar_proveedor.php?id=<?php echo $data['codproveedor'];?>"><i class="fas fa-user-times"></i> Desactivar </a>

				   </td>

				</tr>
			<?php

		  }
		

		}

	?>

		


		</table>

			<?php 

				if ($resultado != 0)

				{
					
			?>

	
		<div class="paginador">
		<ul>
			<?php 
				if($pagina!=1)
				{


			 ?>
				<li><a href="?pagina=<?php echo 1; ?>&busqueda=<?php echo $busqueda; ?>"><i class="fas fa-step-backward"></i></a></li>
				<li><a href="?pagina=<?php echo $pagina-1; ?>&busqueda=<?php echo $busqueda; ?>"><i class="fas fa-backward"></i></a></li>

		<?php
				}
					for ($i=1; $i <= $total_paginas; $i++)
				{
					if ($i==$pagina)
					{

					echo '<li class="PageSelected">'.$i.'</li>';

					}else{
					echo '<li><a href="?pagina='.$i.'&busqueda='.$busqueda.'">'.$i.'</a></li>';
				}

				}
					if($pagina!=$total_paginas)
			{
				

		?>
							
				<li><a href="?pagina=<?php echo $pagina + 1;?>&busqueda=<?php echo $busqueda; ?>"><i class="fas fa-forward"></i></a></li>
				<li><a href="?pagina=<?php echo $total_paginas;?>&busqueda=<?php echo $busqueda; ?>"><i class="fas fa-step-forward"></i></a></li>


				<?php } ?>
			
			</ul>	
		</div>

			 <?php } ?>

	</section>

		<?php include "includes/footer.php";?>

</body>
</html>