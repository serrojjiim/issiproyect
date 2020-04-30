<?php
	session_start();
  	
  	include_once("gestionas/gestionBD.php");
 	include_once("gestionas/gestionarEmpleado.php");
	
	if (isset($_POST['submit'])){
		$pass= $_POST['pass'];
		$conexion = crearConexionBD();
		$usuario = consultaPassBD($conexion,$pass,$_SESSION['dni']);
	
			 
		if ($usuario['DNI']==null){
			$error=1;
		
		}else{
		$_SESSION['login'] = $usuario['DNI'];	
		$_SESSION['nombre'] = $usuario['NOMBRE'];
		$_SESSION['apellidos']=$usuario['APELLIDOS'];	
		$_SESSION['cargo']=getCargoString($usuario['CARGO']);
		$_SESSION['oid_emp']=$usuario['OID_EMP'];
		Header("Location: muestra/index1.php");
		}
	}

?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="css/formLogin.css" />
    <link rel="icon" href="img/logo_coenca.png" />

  <title>Coenca | Acceso</title>
</head>

<body>
		<div align="center" class="login">
		<img class="logoCoenca" src="img/logo_coenca.png">

 	<?php if(isset($error)) echo "<div class=\"error\"><p>¡Contraseña incorrecta!</p></div>"; ?>
		<form action="acceso.php" method="post">
		<div><input placeholder="Introduce tu contraseña" type="password" name="pass" id="pass"/></div>
		<input class="botonLogin" type="submit" name="submit" value="Acceder" style="width:150px; height:30px;"/>
	</form>
	</div>

</body>
</html>


		