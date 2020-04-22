<?php
	session_start();
	if($_SESSION['cargo']!="GERENTEVENTAS"){
		echo "</p>No tienes permisos para acceder a esta página</p>";
		
	}else{
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="css/formLogin.css" />
  <title>¡Bienvenid@!</title>
</head>

<body>
</p>Pagina de control de gerente de ventas</p>
<form action="../../logout.php" method="post">
    <input type="submit" value="Logout" name="Submit" id="logout" />
</form>
</body>
</html>
<?php } ?>