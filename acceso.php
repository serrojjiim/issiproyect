<?php
	session_start();
  	
  	include_once("gestionas/gestionBD.php");
 	include_once("gestionas/gestionarEmpleado.php");
	
	if (isset($_POST['submit'])){
		$pass= $_POST['pass'];
		$conexion = crearConexionBD();
		$usuario = consultaPassBD($conexion,$pass,$_SESSION['dni']);
	
			
		if ($usuario['DNI']==null){
			echo "<div class=\"error\"><p align=\"center\">Contraseña incorrecta</p></div>";
		
		}else{
		$_SESSION['login'] = $usuario['DNI'];	
		$_SESSION['nombre'] = $usuario['NOMBRE'];	
		$_SESSION['cargo']=getCargoString($usuario['CARGO']);
		Header("Location: muestra/index1.php");
		}
	}

?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="css/formLogin.css" />
  <title>Gestión de biblioteca: Login</title>
</head>

<body>

	<div align="center" class="login">
	<form action="acceso.php" method="post">
		<div><label for="pass"></label><input style="border-radius:15px" placeholder="Introduce tu contraseña" type="password" name="pass" id="pass" /></div>
		<input style="border-radius:15px" type="submit" name="submit" value="submit" />
	</form>
	</div>

</body>
</html>


		