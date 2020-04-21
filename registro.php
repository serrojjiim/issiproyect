<?php
	session_start();
  	
  	include_once("gestionas/gestionBD.php");
 	include_once("gestionas/gestionarEmpleado.php");
	
	if (isset($_POST['submit'])){
		$pass= $_POST['pass'];
		$passC=$_POST['passC'];
		if($pass==$passC){
			$dni = $_SESSION['dni'];
			$conexion = crearConexionBD();
			$salida = establecePassBD($conexion,$dni,$pass);
			cerrarConexionBD($conexion);	
	
			if ($salida = true)
				Header("Location: index1.php");
				else {
			
				Header("Location: login.php");
				}	
		}else{
			echo "<div class=\"error\"><p align=\"center\">Las contraseñas no coinciden.</p></div>";

		}
		
	}

?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="css/formLogin.css" />
  <title>Registro</title>
</head>

<body>

	<?php if (isset($passNoCoinciden)) {
		
		echo "<p>Las contraseñas no coinciden.</p>";
			
	}	
	?>
	<div align="center" class="login">
	<form action="registro.php" method="post">
		<div><label for="pass"></label><input style="border-radius:15px" placeholder="Introduce una contraseña" type="password" name="pass" id="pass" /></div>
		<div><label for="passC"></label><input style="margin-top: 5%;border-radius:15px" placeholder="Confirma la contraseña"type="password" name="passC" id="passC" /></div>
		<input style="margin-top: 5%;border-radius:15px" type="submit" name="submit" value="submit" />
	</form>
	</div>	

</body>
</html>


		