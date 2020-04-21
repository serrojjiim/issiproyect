<?php
	session_start();
  	
  	include_once("gestionas/gestionBD.php");
 	include_once("gestionas/gestionarEmpleado.php");
	
	if (isset($_POST['submit'])){
		$dni= $_POST['dni'];

		$conexion = crearConexionBD();
		$usuario = consultaBaseDatosDni($conexion,$dni);
		$usuariop=consultaBaseDatosPass($conexion,$dni);
		cerrarConexionBD($conexion);	
		
		
		if($usuario['dni']==null){
			echo "<div class=\"error\"><p align=\"center\">El DNI indicado no tiene acceso.</p></div>";
		}else{
			if ($usuariop['pass'] == null){
			$_SESSION['dni'] = $dni;
			Header("Location: registro.php");
		
			}
			else {
				$_SESSION['dni'] = $dni;
				Header("Location: acceso.php");
			}
		}
	
			
	}

?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="css/formLogin.css" />
  <title>¡Bienvenid@!</title>
</head>

<body>

	<div align="center" class="login">
	<form action="login.php" method="post">
		<div><label for="dni"></label><input style="border-radius:15px" type="text" name="dni" id="dni" placeholder="      Introduce tu DNI" /></div>
		<div class="botonLogin"><input style="border-radius:15px" type="submit" name="submit" value="submit" /></div>
	</form>
	</div>

</body>
</html>
		