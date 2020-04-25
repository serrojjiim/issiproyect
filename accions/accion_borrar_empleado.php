<?php	
	session_start();
	
	$infoPag = $_SESSION["paginacion"];
	$PAG_NUM = $infoPag['PAG_NUM'];
	$PAG_TAM = $infoPag['PAG_TAM'];	
	
	if (isset($_SESSION["empleado"])) {
		$empleado = $_SESSION["empleado"];
		unset($_SESSION["empleado"]);
		
		require_once("../gestionas/gestionBD.php");
		require_once("../gestionas/gestionarEmpleado.php");
		
		$conexion = crearConexionBD();		
		//$excepcion = quitar_empleado($conexion,$empleado["DNI"]);              LO QUE TENÍAS
		$excepcion = ocultar($conexion,$empleado['OID_EMP']);
		cerrarConexionBD($conexion);
			
		
		if ($excepcion<>"") {
			$_SESSION["excepcion"] = $excepcion;
			$_SESSION["destino"] = "muestraEmpleados.php";
			Header("Location: ../excepcion.php");
		}
		else Header("Location: ../muestra/muestraEmpleados.php?PAG_NUM=".$PAG_NUM."&PAG_TAM=".$PAG_TAM);
	}
	else Header("Location: ../muestra/muestraEmpleados.php?PAG_NUM=".$PAG_NUM."&PAG_TAM=".$PAG_TAM); // Se ha tratado de acceder directamente a este PHP
?>
