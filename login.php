<?php
	session_start();
  	
  	include_once("gestionas/gestionBD.php");
 	include_once("gestionas/gestionarEmpleado.php");
	
	if (isset($_POST['submit'])){
		$dni= $_POST['dni'];
		if (isset($_SESSION['login']))
        unset($_SESSION['login']);
    	if(isset($_SESSION['cargo']))
   	    unset($_SESSION['cargo']);
		$conexion = crearConexionBD();
		$usuariop=consultaBaseDatosPass($conexion,$dni);
		$usuario2=obtener_empleado_dni($conexion,$dni);
		cerrarConexionBD($conexion);		
		
		
		if($usuario2['DNI']==null or $usuario2['OCULTO']==1){
			$error=1;
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
  <link rel="icon" href="img/logo_coenca.png" />
  <title>Coenca | Acceso	</title>
</head>

<body>
	
	<a href="#"><img src="img/back.png" width="50px" alt="Volver" height="30px" style="position: absolute"/></a>
	
	<div align="center" class="login">

	<img class="logoCoenca" src="img/logo_coenca.png">
	<?php if(isset($error))echo "<div class=\"error\"><p align=\"center\">El DNI indicado no tiene acceso</p></div>"; ?>
	<form action="login.php" method="post">
		<div ><label for="dni"></label><input spellcheck="false" type="text" name="dni" id="dni" placeholder="Introduce tu DNI" pattern="^[0-9]{8}[A-Z]" style="position: absolute; top: 65%; left: 18.5%;"/></div>
		<div><input class="botonLogin" type="submit" name="submit" value="Acceder" style="width:150px; height:30px;"/></div>
	</form>
	</div>

</body>
</html>
		