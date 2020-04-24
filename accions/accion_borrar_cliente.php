<?php	
	session_start();	
	
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
		else Header("Location: ../muestra/muestraCliente.php");
	}
	else Header("Location: ../muestra/muestraCliente.php"); // Se ha tratado de acceder directamente a este PHP
?>