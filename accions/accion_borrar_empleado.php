<?php	
	session_start();	
	
	if (isset($_SESSION["empleado"])) {
		$empleado = $_SESSION["empleado"];
		unset($_SESSION["empleado"]);
		
		require_once("gestionas/gestionBD.php");
		require_once("gestionas/gestionarEmpleado.php");
		
		$conexion = crearConexionBD();		
		$excepcion = quitar_empleado($conexion,$empleado["DNI"]);
		cerrarConexionBD($conexion);
			
		if ($excepcion<>"") {
			$_SESSION["excepcion"] = $excepcion;
			$_SESSION["destino"] = "muestraEmpleados.php";
			Header("Location: excepcion.php");
		}
		else Header("Location: muestraEmpleados.php");
	}
	else Header("Location: muestraEmpleados.php"); // Se ha tratado de acceder directamente a este PHP
?>
