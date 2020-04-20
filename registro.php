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
					echo "<p>Las contraseñas no coinciden.</p>";

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

	<?php if (isset($passNoCoinciden)) {
		
		echo "<p>Las contraseñas no coinciden.</p>";
			
	}	
	?>
	
	<form action="registro.php" method="post">
		<p>No estás registrado. Establece una contraseña : </p>
		<div><label for="pass">CONTRASEÑA: </label><input type="password" name="pass" id="pass" /></div>
		<div><label for="passC">CONFIRMAR CONTRASEÑA: </label><input type="password" name="passC" id="passC" /></div>
		<input type="submit" name="submit" value="submit" />
	</form>
		

</body>
</html>


		