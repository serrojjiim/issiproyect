<?php	
	session_start();	
	
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
		else Header("Location: ../muestra/muestraPedidosProveedores.php");
	}
	else Header("Location: ../muestra/muestraPedidosProveedores.php"); // Se ha tratado de acceder directamente a este PHP
?>
