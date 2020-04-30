<?php	
	session_start();	
	
	$infoPag = $_SESSION["paginacion"];
	$PAG_NUM = $infoPag['PAG_NUM'];
	$PAG_TAM = $infoPag['PAG_TAM'];
	
	if (isset($_SESSION["proveedor"])) {
		$proveedor = $_SESSION["proveedor"];
		unset($_SESSION["proveedor"]);
		
		require_once("../gestionas/gestionBD.php");
		require_once("../gestionas/gestionarProveedor.php");
				
		
		$conexion = crearConexionBD();		
		$excepcion = ocultarP($conexion,$proveedor['CIF']);
		cerrarConexionBD($conexion);	
		
		if ($excepcion<>"") {
			$_SESSION["excepcion"] = $excepcion;
			$_SESSION["destino"] = "muestraProveedor.php";
			Header("Location: ../excepcion.php");
		}
		else Header("Location: ../muestra/muestraProveedor.php?PAG_NUM=".$PAG_NUM."&PAG_TAM=".$PAG_TAM);
	}
	else Header("Location: ../muestra/muestraProveedor.php?PAG_NUM=".$PAG_NUM."&PAG_TAM=".$PAG_TAM); // Se ha tratado de acceder directamente a este PHP
?>