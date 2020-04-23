<?php	
	session_start();	
	
	if (isset($_SESSION["solicitud"])) {
		$solicitud = $_SESSION["solicitud"];
		unset($_SESSION["solicitud"]);
		
		require_once("gestionas/gestionBD.php");
		require_once("gestionas/gestionarSolicitud.php");
		
		$conexion = crearConexionBD();		
		$excepcion = solicitardias($conexion,$solicitud["DNI"],$solicitud["DIASAPEDIR"],$solicitud["MOTIVO"]);
		cerrarConexionBD($conexion);
			
		if ($excepcion<>"") {
			$_SESSION["excepcion"] = $excepcion;
			$_SESSION["destino"] = "index1.php";
			Header("Location: excepcion.php");
		}
		else Header("Location: index1.php");
	}
	else Header("Location: index1.php"); // Se ha tratado de acceder directamente a este PHP
?>
