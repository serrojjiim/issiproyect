<?php	
	session_start();	
	
	$infoPag = $_SESSION["paginacion"];
	$PAG_NUM = $infoPag['PAG_NUM'];
	$PAG_TAM = $infoPag['PAG_TAM'];
	
	if (isset($_SESSION["cliente"])) {
		$cliente = $_SESSION["cliente"];
		unset($_SESSION["cliente"]);
		
		require_once("../gestionas/gestionBD.php");
		require_once("../gestionas/gestionarCliente.php");
				
		
		$conexion = crearConexionBD();		
		$excepcion = ocultarC($conexion,$cliente['CIF']);
		cerrarConexionBD($conexion);	
		
		if ($excepcion<>"") {
			$_SESSION["excepcion"] = $excepcion;
			$_SESSION["destino"] = "muestraCliente.php";
			Header("Location: ../excepcion.php");
		}
		else Header("Location: ../muestra/muestraCliente.php?PAG_NUM=".$PAG_NUM."&PAG_TAM=".$PAG_TAM);
	}
	else Header("Location: ../muestra/muestraCliente.php?PAG_NUM=".$PAG_NUM."&PAG_TAM=".$PAG_TAM); // Se ha tratado de acceder directamente a este PHP
?>