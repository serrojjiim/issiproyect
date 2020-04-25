<?php	
	session_start();	
	
	$infoPag = $_SESSION["paginacion"];
	$PAG_NUM = $infoPag['PAG_NUM'];
	$PAG_TAM = $infoPag['PAG_TAM'];
	
	if (isset($_SESSION["maquina"])) {
		$maquina = $_SESSION["maquina"];
		unset($_SESSION["maquina"]);
		
		require_once("../gestionas/gestionBD.php");
		require_once("../gestionas/gestionarMaquina.php");
				
		
		$conexion = crearConexionBD();		
		$excepcion = borrarMaq($conexion,$maquina['OID_MAQ']);
		cerrarConexionBD($conexion);	
		
		if ($excepcion<>"") {
			$_SESSION["excepcion"] = $excepcion;
			$_SESSION["destino"] = "muestraMaquinas.php";
			Header("Location: ../excepcion.php");
		}
		else Header("Location: ../muestra/muestraMaquinas.php?PAG_NUM=".$PAG_NUM."&PAG_TAM=".$PAG_TAM);
	}
	else Header("Location: ../muestra/muestraMaquinas.php?PAG_NUM=".$PAG_NUM."&PAG_TAM=".$PAG_TAM); // Se ha tratado de acceder directamente a este PHP
?>