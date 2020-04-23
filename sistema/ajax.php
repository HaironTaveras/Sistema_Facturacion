<?php 
	
	include "../conexion.php";

	session_start();

	//print_r($_POST); exit;


	

	if (!empty($_POST))
	{

		//EXTRAER DATOS DEL PRODUCTO
		if($_POST['action'] == 'infoProducto')
		{

			$producto_id = $_POST['producto'];

			$query = mysqli_query($conexion,"SELECT codproducto, descripcion  
										     FROM producto
										     WHERE codproducto=$producto_id AND estatus = 1");
 
				mysqli_close($conexion);

				$result= mysqli_num_rows($query);

				if ($result >0 ) 
				{
					$data = mysqli_fetch_assoc($query);
					echo json_encode($data,JSON_UNESCAPED_UNICODE);
					exit;
				}

				echo 'Error';
				exit;
			}
			

			# AGREGAR PRODUCTO A LA ENTRADA
			if ($_POST['action'] == 'addproduct') 
			{
				if(!empty($_POST['cantidad']) || !empty($_POST['costo'])  || !empty($_POST['producto_id']))
					
				{
					$cantidad    = $_POST['cantidad'];
					$costo	     = $_POST['costo'];
					$producto_id = $_POST['producto_id'];
					$usuario_id  = $_SESSION['iduser'];

					$query_insert = mysqli_query($conexion,"INSERT INTO entradas (codproducto,cantidad,costo, usuario_id)						     				     VALUES ($producto_id,$cantidad,$costo,$usuario_id)");


					if($query_insert){
						//EJECUTAR PROCEDIMIENTO ALMACENADO
						$query_upd =mysqli_query($conexion,"CALL actualizar_costo_producto($cantidad,$costo,
															$producto_id)");
						$result_pro=mysqli_num_rows($query_upd);
						if ($result_pro > 0) {

							$data= mysqli_fetch_assoc($query_upd);
							$data['producto_id'] = $producto_id;
							echo json_encode($data,JSON_UNESCAPED_UNICODE);
							exit;

						}
						



					}else{

						echo 'Error';
					}

						mysqli_close($conexion);

				}else{

						echo 'Error';
					}

					exit;
				}

		//DESACTIVAR DATOS DEL PRODUCTO
		if($_POST['action'] == 'delproduct')
		{

			if(empty($_POST['producto_id']) || !is_numeric($_POST['producto_id'])){
				echo 'Error';
			}else{


			$idproducto = $_POST['producto_id'];
			$query_delete= mysqli_query($conexion, " UPDATE producto SET estatus = 0 WHERE codproducto = $idproducto ");
			mysqli_close($conexion);

			


			if($query_delete)
			{
				echo 'ok';
			}else{

				echo 'Error al desactivar';
			}
		}
		echo 'error';
		}
			exit;
	}

	

		exit;

 ?>