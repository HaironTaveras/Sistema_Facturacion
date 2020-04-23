<?php 

	session_start();
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
		<?php include "includes/scripts.php";?>
	
	<title>Sistema Facturación</title>
</head>
<body>
		<?php include "includes/header.php";?>

	<section id="container">
		<h1>Bienvenido al Sistema</h1>
		<br>
		<br>
		<span class="user"><h2><?php echo $_SESSION['user'];?></h2></span>
	</section>

		<?php include "includes/footer.php";?>

</body>
</html>