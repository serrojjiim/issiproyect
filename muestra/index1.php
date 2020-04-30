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
</body>
</html>

<?php } ?>