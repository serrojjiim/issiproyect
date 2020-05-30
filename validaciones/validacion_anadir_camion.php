<?php 	
	session_start();	
	require_once("../gestionas/gestionBD.php");
	
			$camionS = $_SESSION["ncamion"];
			$camion["MATRICULA"] = $camionS["MATRICULA"];
			$_SESSION['camion'] = $camion;		
			
		
		
	// Validamos el formulario en servidor
	$conexion = crearConexionBD(); 
	$errores = validarDatosUsuario($conexion, $camion);
	cerrarConexionBD($conexion);
	
	
	// Si se han detectado errores
	if (count($errores)>0) {
		// Guardo en la sesión los mensajes de error y volvemos al formulario
		$_SESSION["errores"] = $errores;
		Header("Location: ../modificar/nuevoCamion.php");
	} else{
		//Si todo va bien, vamos a la página de acción (inserción del usuario en la base de datos)
		Header('Location: ../accions/accion_nuevo_camion.php');
	}
		
		
function validarDatosUsuario($conexion, $camion){
	$errores=array();
	// Validación del CIF
	if($camion["MATRICULA"]=="") 
		$errores[] = "<p>La matrícula no puede estar vacía</p>";
	else if(!preg_match("/^[0-9]{4}[A-Z]{3}$/", $camion["MATRICULA"])){
		$errores[] = "<p>La matrícula debe contener 4 números y tres letras mayúsculas: " . $camion["MATRICULA"] . "</p>";
	}
	return $errores;
}		
?>