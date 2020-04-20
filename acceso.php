<?php
	session_start();
  	
  	include_once("gestionas/gestionBD.php");
 	include_once("gestionas/gestionarEmpleado.php");
	
	if (isset($_POST['submit'])){
		$pass= $_POST['pass'];
		$conexion = crearConexionBD();
	
			
		$usuario = consultaPassBD($conexion,$pass,$_SESSION['dni']);
		cerrarConexionBD($conexion);	
	
		if ($usuario['dni']==null){
					echo "<p>Contraseña Incorrecta</p>";
		
		}else{
		Header("Location: index1.php");
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

	
	<form action="acceso.php" method="post">
		<p>Ya estás registrado. Introduce tu contraseña : </p>
		<div><label for="pass">CONTRASEÑA: </label><input type="password" name="pass" id="pass" /></div>
		<input type="submit" name="submit" value="submit" />
	</form>
		

</body>
</html>


		