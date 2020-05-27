<?php
	session_start();

	// Importar librerías necesarias para gestionar direcciones y géneros literarios
	require_once("../gestionas/gestionBD.php");


	// Comprobar que hemos llegado a esta página porque se ha rellenado el formulario
	if (isset($_SESSION["solicitud"])) {
		$solicitud = $_SESSION["solicitud"];
	
	$user =  $_SESSION['user'];
	$vacas = $user["DIASVACACIONES"];			
	}
	else // En caso contrario, vamos al formulario
		Header("Location: ../muestra/peticiondias.php");

	// Validamos el formulario en servidor
	$conexion = crearConexionBD(); 
	$errores = validarDatosSolicitud($conexion, $solicitud);
	cerrarConexionBD($conexion);
	
	// Si se han detectado errores
	if (count($errores)>0) {
		// Guardo en la sesión los mensajes de error y volvemos al formulario
		$_SESSION["errores"] = $errores;
		$_SESSION["peticionerror"] = $solicitud;
		Header('Location: ../muestra/peticiondias.php');
	} else
		// Si todo va bien, vamos a la página de acción (inserción del usuario en la base de datos)
		Header('Location: ../accions/accion_solicituddias.php');

///////////////////////////////////////////////////////////
// Validación en servidor del formulario de alta de usuario
///////////////////////////////////////////////////////////
function validarDatosSolicitud($conexion, $solicitud){
	$errores=array();

    if($solicitud["DNI"]=="") 
		$errores[] = "<p>El dni no puede estar vacío</p>";
	else if(!preg_match("/^[0-9]{8}[A-Z]$/", $solicitud["DNI"])){
		$errores[] = "<p>El NIF debe contener 8 números y una letra mayúscula: " . $solicitud["DNI"]. "</p>";
	}
	
	// Validación del cliente			
	if($solicitud["DIASAPEDIR"]=="") 
		$errores[] = "<p>Los dias a pedir no pueden estar vacío</p>";
	else if(((int)$solicitud["DIASAPEDIR"] <= 0) or ((int)$solicitud["DIASAPEDIR"] > (int)$_SESSION['vacas'])){
		$errores[] = "<p>El numero de días a pedir debe estar entre 1 y " .  $_SESSION['vacas'] . "</p>";
	}
	// Validación del empleado
	if($solicitud["MOTIVO"]=="")
		$errores[] = "<p>El motivo no puede estar vacío</p>";
	else if(strlen($solicitud["MOTIVO"]) > 400){
		$errores[] = "<p>El motivo no puede tener más de 400 caracteres</p>";
	}
	
	
	
	
	return $errores;
}




?>

