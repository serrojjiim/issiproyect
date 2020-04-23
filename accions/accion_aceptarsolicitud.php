<?php	
	session_start();	
	
	if (isset($_SESSION["solicitud"])) {
		$solicitud = $_SESSION["solicitud"];
		unset($_SESSION["solicitud"]);
		
		require_once("../gestionas/gestionBD.php");
		require_once("../gestionas/gestionarSolicitud.php");
		
		$conexion = crearConexionBD();		
		$excepcion = aceptarpeticiondias($conexion,$solicitud["OID_PETICIONDIAS"]);
		cerrarConexionBD($conexion);
			
		if ($excepcion<>"") {
			$_SESSION["excepcion"] = $excepcion;
			$_SESSION["destino"] = "solicitudesdedias.php";
			Header("Location: ../excepcion.php");
		}
		else Header("Location: ../solicitudesdedias.php");
	}
	else Header("Location: ../solicitudesdedias.php"); // Se ha tratado de acceder directamente a este PHP
?>
