<?php
	session_start();
  	
  	include_once("gestionas/gestionBD.php");
 	include_once("gestionas/gestionarEmpleado.php");
	
	if (isset($_POST['submit'])){
		$dni= $_POST['dni'];

		$conexion = crearConexionBD();
		$usuario = consultaBaseDatosDni($conexion,$dni);
		cerrarConexionBD($conexion);	
		
		
	
		if ($usuario['pass'] == null){
			$_SESSION['dni'] = $dni;
			Header("Location: registro.php");
		
		}
		else {
			$_SESSION['dni'] = $dni;
			Header("Location: acceso.php");
		}	
	}

?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="css/biblio.css" />
  <title>Gestión de biblioteca: Login</title>
</head>

<body>

	
	<form action="login.php" method="post">
		<div><label for="dni">DNI: </label><input type="text" name="dni" id="dni" /></div>
		<input type="submit" name="submit" value="submit" />
	</form>
		

</body>
</html>
		