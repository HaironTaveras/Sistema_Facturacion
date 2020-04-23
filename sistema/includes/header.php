 <?php

 


if (empty($_SESSION['active']))
{

header('location: Facturacion/index.php');

}

?>


<header>
		<div class="header">
			
			<h1><i class="fas fa-desktop"></i> Sistema Facturación</h1>
			<div class="optionsBar">
				<p>Repulica Dominicana, <?php echo fechaC(); ?></p>
				<span>|</span>
				<span class="user"><?php echo $_SESSION['user'].':  #'. $_SESSION['rol'].' - '.$_SESSION['email'];?></span>
				<img class="photouser" src="img/user.png" alt="Usuario">
				 <a href="salir.php"><img class="close" src="img/salir.png" alt="Salir del sistema" title="Salir"></a>
			</div>
		</div>
		<?php include "includes/nav.php";?>
	</header>

		<div class="modal"> 
		<div class="bodyModal">
		
			
		</div>

		</div>