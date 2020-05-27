<?php
	session_start();

	// Importar librerías necesarias para gestionar direcciones y géneros literarios
	require_once("../gestionas/gestionBD.php");


	// Comprobar que hemos llegado a esta página porque se ha rellenado el formulario
	if (isset($_SESSION["empleado"])) {
		$empleado = $_SESSION["empleado"];
	
	}
	else // En caso contrario, vamos al formulario
		Header("Location: ../modificar/modificarEmpleado.php");

	// Validamos el formulario en servidor
	$conexion = crearConexionBD(); 
	$errores = validarDatosEmpleado($conexion, $empleado);
	cerrarConexionBD($conexion);
	
	// Si se han detectado errores
	if (count($errores)>0) {
		// Guardo en la sesión los mensajes de error y volvemos al formulario
		$_SESSION["errores"] = $errores;
		$_SESSION["emplerror"] = $empleado;
		Header('Location: ../modificar/modificarEmpleado.php');
	} else
		// Si todo va bien, vamos a la página de acción (inserción del usuario en la base de datos)
		Header('Location: ../accions/accion_modificar_empleado.php');

///////////////////////////////////////////////////////////
// Validación en servidor del formulario de alta de usuario
///////////////////////////////////////////////////////////
function validarDatosEmpleado($conexion, $nuevoEmpleado){
	$errores=array();
	// Validación del NIF
	if($nuevoEmpleado["DNI"]=="") 
		$errores[] = "<p>El NIF no puede estar vacío</p>";
	else if(!preg_match("/^[0-9]{8}[A-Z]$/", $nuevoEmpleado["DNI"])){
		$errores[] = "<p>El NIF debe contener 8 números y una letra mayúscula: " . $nuevoEmpleado["DNI"]. "</p>";
	}

	// Validación del Nombre			
	if($nuevoEmpleado["NOMBRE"]=="") 
		$errores[] = "<p>El nombre no puede estar vacío</p>";
	
	// Validación del email
	if($nuevoEmpleado["APELLIDOS"]=="")
		$errores[] = "<p>Los apellidos no pueden estar vacío</p>";
	
		
	if($nuevoEmpleado["TELEFONO"]=="") 
		$errores[] = "<p>El telefono no puede estar vacío</p>";
	else if(!preg_match("/^[6-7]{1}[0-9]{8}/", $nuevoEmpleado["TELEFONO"])){
		$errores[] = "<p>El telefono debe contener 9 números: " . $nuevoEmpleado["TELEFONO"]. "</p>";
	}
	
	if($nuevoEmpleado["DIRECCION"]=="")
		$errores[] = "<p>La direccion no puedea estar vacía</p>";
	
	if($nuevoEmpleado["CAPITALSOCIAL"]=="")
		$errores[] = "<p>El capital no puede estar vacío</p>";
	else if((int)$nuevoEmpleado["CAPITALSOCIAL"] < 10000){
		$errores[] = "<p>El capital social debe ser mayor a 10000€: " . $nuevoEmpleado["CAPITALSOCIAL"]. "</p>";
	}	
	
	if($nuevoEmpleado["FECHACONTRATACION"]=="")
		$errores[] = "<p>La fecha contratación no puede estar vacía</p>";
	else if(isDate($nuevoEmpleado["FECHACONTRATACION"]) == FALSE){
		$errores[] = "<p>La fecha no tiene un formato correcto: " . $nuevoEmpleado["FECHACONTRATACION"]. "</p>";
	}	
	
	if($nuevoEmpleado["DIASVACACIONES"]=="")
		$errores[] = "<p>Los dias de vacaciones no puede estar vacío</p>";
	else if(((int)$nuevoEmpleado["DIASVACACIONES"] < 0) or ((int)$nuevoEmpleado["DIASVACACIONES"] > 31)){
		$errores[] = "<p>Los dias de vacaciones debe ser mayor a 0 y menor que 31: " . $nuevoEmpleado["DIASVACACIONES"]. "</p>";
	}	
	
	
	
	return $errores;
}

function isDate($string) {
    $matches = array();
    $pattern = '/^([0-9]{1,2})\\/([0-9]{1,2})\\/([0-9]{2})$/';
    if (!preg_match($pattern, $string, $matches)) return false;
    if (!checkdate($matches[2], $matches[1], $matches[3])) return false;
    return true;
}


?>

