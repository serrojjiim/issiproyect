<?php session_start(); 
if(!isset($_SESSION["cargo"])){
		echo "</p>No tienes permisos para acceder a esta página</p>";
		
	}else{?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="../css/index.css" />
  <title>Gestión de biblioteca: Login</title>
</head>

<body>
	<?php
	include_once ("header.php");
	?>


	<div>
		<div class="indexpa"></div>
		<div></div>
	</div>

<p>Hola <?php echo $_SESSION['nombre']?></p>
<p>Hola <?php echo $_SESSION['dni']?></p>
<p>Hola <?php echo $_SESSION['cargo']?></p>
<p>Hola <?php echo $_SESSION['oid_emp']?></p>
<p>Hola <?php echo $_SESSION['oid_maq']?></p>
<footer>
	<?php include("../muestra/footer.php");?>
</footer>
</body>
</html>

<?php } ?>