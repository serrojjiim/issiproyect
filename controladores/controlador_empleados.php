<?php	
	session_start();
	
	if (isset($_REQUEST["OID_EMP"])){
		$empleado["OID_EMP"] = $_REQUEST["OID_EMP"];
		$empleado["NOMBRE"] = $_REQUEST["NOMBRE"];
		$empleado["APELLIDOS"] = $_REQUEST["APELLIDOS"];
		$empleado["DNI"] = $_REQUEST["NOMBRE"];
		
		$_SESSION["empleado"] = $empleado;
			
		// if (isset($_REQUEST["editar"])) Header("Location: consulta_libros.php"); 
		// else if (isset($_REQUEST["grabar"])) Header("Location: accion_modificar_libro.php");
		// else Header("Location: accion_borrar_libro.php"); 
	}
	else 
		Header("Location: pruebaPaginacion.php");

?>
