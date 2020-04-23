<?php	
	session_start();	
	
	if (isset($_SESSION["empleado"])) {
		$empleado = $_SESSION["empleado"];
		unset($_SESSION["empleado"]);
		
		require_once("gestionas/gestionBD.php");
		require_once("gestionas/gestionarEmpleado.php");
		
		$conexion = crearConexionBD();	
		$excepcionm = modificar_maquina($conexion,$empleado["DNI"],$empleado["OID_MAQ"]);
	
		$excepcion = modificar_datospersonales($conexion,$empleado["OID_EMP"],$empleado["DNI"],$empleado["NOMBRE"],$empleado["APELLIDOS"],$empleado["TELEFONO"],$empleado["DIRECCION"]
		,$empleado["CAPITALSOCIAL"],$empleado["FECHACONTRATACION"],$empleado["DIASVACACIONES"]);
		$excepcion = modificar_cargo($conexion,$empleado["DNI"],$empleado["CARGO"]);

		
	
		$_SESSION["empleado"] = obtener_empleado_dni($conexion, $empleado["DNI"]);
		cerrarConexionBD($conexion);
		if ($excepcion<>"") {
			$_SESSION["excepcion"] = $excepcion;
			$_SESSION["destino"] = "modificarEmpleado.php";
			Header("Location: excepcion.php");
		}
		
		else 
		$_SESSION["mensajeok"] = 1;
		Header("Location: modificarEmpleado.php");
	}
	else Header("Location: muestraEmpleados.php"); // Se ha tratado de acceder directamente a este PHP
?>
