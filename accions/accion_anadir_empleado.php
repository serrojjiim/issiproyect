<?php	
	session_start();	
	
	$infoPag = $_SESSION["paginacion"];
	$PAG_NUM = $infoPag['PAG_NUM'];
	$PAG_TAM = $infoPag['PAG_TAM'];
	
	if (isset($_SESSION["nempleado"])) {
		$nempleado = $_SESSION["nempleado"];
		unset($_SESSION["nempleado"]);
		
		require_once("../gestionas/gestionBD.php");
		require_once("../gestionas/gestionarEmpleado.php");
		
		$conexion = crearConexionBD();	
	
		$excepcion = anadirempleado($conexion,$nempleado["DNI"],$nempleado["NOMBRE"],$nempleado["APELLIDOS"],$nempleado["TELEFONO"],$nempleado["DIRECCION"]
		,$nempleado["CARGO"],$nempleado["CAPITALSOCIAL"],$nempleado["FECHACONTRATACION"],$nempleado["DIASVACACIONES"],$nempleado["OID_MAQ"]);
		

		
	
		
		
		cerrarConexionBD($conexion);
		if ($excepcion<>"") {
			$_SESSION["excepcion"] = $excepcion;
			$_SESSION["destino"] = "anadirEmpleado.php";
			Header("Location: ../excepcion.php");
		}
		
		$_SESSION["mensajeoka"] = 1;
		Header("Location: ../muestra/muestraEmpleados.php?PAG_NUM=".$PAG_NUM."&PAG_TAM=".$PAG_TAM);
	}
	else Header("Location: ../muestra/muestraEmpleados.php?PAG_NUM=".$PAG_NUM."&PAG_TAM=".$PAG_TAM); // Se ha tratado de acceder directamente a este PHP
?>
