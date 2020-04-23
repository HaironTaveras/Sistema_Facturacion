<?php

session_start();


include "../conexion.php";

?>



<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
		<?php include "includes/scripts.php";?>
	
	<title>Lista de Productos</title>
</head>
<body>
		<?php include "includes/header.php";?>

	<section id="container">
		
		<h1><i class="fas fa-cubes"></i> Lista de Productos</h1>
		<a href="registro_producto.php" class="btn_new"><i class="fas fa-plus"></i> Registrar Productos</a> 

		<form action="buscar_producto.php" method="get" class="formulario_buscar"> 
			<input type="text" name="busqueda" id="busqueda" placeholder="Buscar">
			

			<button type="submit"class="btn_buscar"> <i class="fas fa-search"></i></button>


		</form>

		<table>
			<tr>
				
				
				<th>CÓDIGO</th>
				<th>DESCRIPCIÓN</th>
				<th>COSTO</th>
				<th>PRECIO</th>
				<th>EXISTENCIA</th>
				<th>
						
			<?php 
				$query_proveedor=mysqli_query($conexion,"SELECT codproveedor, proveedor FROM  proveedor where estatus=1 ORDER BY proveedor asc ;");

				$result_proveedor=mysqli_num_rows($query_proveedor);
			

			 ?>
			 <select name="proveedor" id="search_proveedor">
			   <option value=""selected>Proveedor</option>}
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



				</th>
				<th>FOTO</th>
				<th>ACCIONES</th>

			</tr>

			<?php

			//QUERY DEL PAGINADOR PAGINADOR 

				$sql_registro = mysqli_query($conexion,"SELECT COUNT(*) AS total_registro FROM 	producto WHERE estatus=1");
				$resultado_registro = mysqli_fetch_array($sql_registro);
				$total_registro = $resultado_registro['total_registro'];

				$por_pagina = 10;


					if(empty($_GET['pagina']))

					{
						$pagina=1;

					}else{

						$pagina =$_GET['pagina'];
					}

					$desde = ($pagina-1) * $por_pagina;
					$total_paginas = ceil($total_registro / $por_pagina);



		$query = mysqli_query($conexion,"SELECT p.codproducto, p.descripcion, p.costo,p.precio,p.existencia, 
												pr.proveedor, p.foto 
												 FROM producto p
												 INNER JOIN proveedor pr
												 ON p.proveedor = pr.codproveedor 
												 WHERE p.estatus =1 ORDER BY p.codproducto DESC LIMIT $desde,$por_pagina
												 ");

		




				mysqli_close($conexion);

				$resultado = mysqli_num_rows($query);

				if($resultado > 0){

					while($data = mysqli_fetch_array($query)){
						if($data['foto'] != 'img_producto.png'){

							$foto='img/uploads/'.$data['foto'];
						}else{

							$foto='img/'.$data['foto'];

				}


			?>
			

		  	 <tr class="row<?php echo $data["codproducto"];?>">
				
				<td><?php echo $data['codproducto'];?></td>
				<td><?php echo $data['descripcion'];?></td>
				<td class="celCosto"><?php echo $data["costo"];?></td>
				<td><?php echo $data['precio'];?></td>
				<td class="celExistencia"><?php echo $data["existencia"];?></td>
				<td><?php echo $data['proveedor'];?></td>
				<td class="img_producto"><img src="<?php echo $foto; ?>" alt="<?php echo $data['descripcion']; ?>"></td>
				
				<td>
						<?php if ($_SESSION['rol'] ==1 || $_SESSION['rol'] ==2) { ?>

				
					<a class="link_add addproduct" product="<?php echo $data["codproducto"]; ?>" href="#"><i class="fas fa-plus"></i>  Agregar</a>
					|
					<a class="link_edit" href="editar_producto.php?id=<?php echo $data["codproducto"]; ?>"><i class="fas fa-edit"></i>  Editar</a>

					
					|
					<a class="link_delete del_product" href="#" product="<?php echo $data["codproducto"]; ?>"><i class="fas fa-user-times"></i> Desactivar </a>

				<?php } ?>

				   </td>

				</tr>
			<?php

		  }
		

		}

	?>

		


		</table>
		<div class="paginador">
		<ul>
			<?php 
				if($pagina!=1)
				{


			 ?>
				<li><a href="?pagina=<?php echo 1;?>"><i class="fas fa-step-backward"></i></a></li>
				<li><a href="?pagina=<?php echo $pagina-1;?>"><i class="fas fa-backward"></i></a></li>

		<?php
				}
					for ($i=1; $i <= $total_paginas; $i++)
				{
					if ($i==$pagina)
					{

					echo '<li class="PageSelected">'.$i.'</li>';

					}else{
					echo '<li><a href="?pagina='.$i.'">'.$i.'</a></li>';
				}

				}
					if($pagina!=$total_paginas)
			{
				

		?>
							
				<li><a href="?pagina=<?php echo $pagina+1;?>"><i class="fas fa-forward"></i></a></li>
				<li><a href="?pagina=<?php echo $total_paginas;?>"><i class="fas fa-step-forward"></i></a></li>


				<?php } ?>
			
			</ul>	
		</div>

	</section>

		<?php include "includes/footer.php";?>

</body>
</html>