<?php

session_start();


include "../conexion.php";

?>



<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
		<?php include "includes/scripts.php";?>
	
	<title>Lista de Clientes</title>
</head>
<body>
		<?php include "includes/header.php";?>

	<section id="container">

		<?php
			//FUNCION PARA CONVETIR EN MINUSCULA "strtolower" Y strtoupper EN MAYUSCULA
		$busqueda = strtoupper($_REQUEST['busqueda']);
			if(empty($busqueda	))
			{
				header('Location: lista_cliente.php');
				mysqli_close($conexion);
			}


		 ?>
		
		<h1><i class="fas fa-users"></i> Lista de Clientes</h1>
		<a href="registro_cliente.php" class="btn_new"><i class="fas fa-user-plus"></i> Registrar Clientes</a> 

		<form action="buscar_cliente.php" method="get" class="formulario_buscar"> 
			<input type="text" name="busqueda" id="busqueda" placeholder="Buscar" value="<?PHP echo $busqueda; ?>">
		
			<button type="submit"class="btn_buscar"> <i class="fas fa-search"></i></button>


		</form>

		<table>
			<tr>
				
				<th>ID</th>
				<th>RNC</th>
				<th>NOMBRE</th>
				<th>TELÉFONO</th>
				<th>DIRECCIÓN </th>
				<th>Acciones</th>

			</tr>

			<?php

				//PAGINADOR

				$sql_registro = mysqli_query($conexion,"SELECT COUNT(*) AS total_registro FROM 	cliente 
														WHERE (idcliente  like '%$busqueda%' OR 
																rnc 	  like '%$busqueda%' OR
																nombre    like '%$busqueda%' OR
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



				$query = mysqli_query($conexion,"SELECT * FROM cliente WHERE 
											         		(idcliente    like '%$busqueda%' OR 
																rnc 	  like '%$busqueda%' OR
																nombre    like '%$busqueda%' OR
																telefono  like '%$busqueda%' OR
																direccion like '%$busqueda%') 	 
												AND 
											    estatus =1 ORDER BY idcliente ASC LIMIT $desde,$por_pagina");

				mysqli_close($conexion);
				$resultado = mysqli_num_rows($query);

				if($resultado > 0){

					while ($data = mysqli_fetch_array($query)){


			?>
				

		  	 <tr>
				
				<td><?php echo $data['idcliente']?></td>
				<td><?php echo $data['rnc']?></td>
				<td><?php echo $data['nombre']?></td>
				<td><?php echo $data['telefono']?></td>
				<td><?php echo $data['direccion']?></td>
				<td>

					
					<a class="link_edit" href="editar_cliente.php?id=<?php echo $data['idcliente'];?>"><i class="fas fa-edit"></i>   Editar</a>
					

					<?php if ($_SESSION['rol'] ==1 || $_SESSION['rol'] ==2) { ?>
					

					|
					<a class="link_delete" href="eliminar_confirmar_cliente.php?id=<?php echo $data['idcliente'];?>"><i class="fas fa-user-times"></i> Desactivar </a>

					<?php }  ?>
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