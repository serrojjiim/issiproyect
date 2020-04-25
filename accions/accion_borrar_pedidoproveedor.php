<?php	
	session_start();	
	
	$infoPag = $_SESSION["paginacion"];
	$PAG_NUM = $infoPag['PAG_NUM'];
	$PAG_TAM = $infoPag['PAG_TAM'];
	
	if (isset($_SESSION["pedidoprov"])) {
		$pedidoprov = $_SESSION["pedidoprov"];
		unset($_SESSION["pedidoprov"]);
		
		require_once("../gestionas/gestionBD.php");
		require_once("../gestionas/gestionarPP.php");
		
		$conexion = crearConexionBD();		
		$excepcion = eliminarPP($conexion,$pedidoprov['OID_PEDPROV']);
		cerrarConexionBD($conexion);
			
		
		if ($excepcion<>"") {
			$_SESSION["excepcion"] = $excepcion;
			$_SESSION["destino"] = "muestraPedidosProveedores.php";
			Header("Location: ../excepcion.php");
		}
		else Header("Location: ../muestra/muestraPedidosProveedores.php?PAG_NUM=".$PAG_NUM."&PAG_TAM=".$PAG_TAM);
	}
	else Header("Location: ../muestra/muestraPedidosProveedores.php?PAG_NUM=".$PAG_NUM."&PAG_TAM=".$PAG_TAM); // Se ha tratado de acceder directamente a este PHP
?>
