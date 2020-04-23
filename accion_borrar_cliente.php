<?php	
	session_start();	
	
	if (isset($_SESSION["cliente"])) {
		$cliente = $_SESSION["cliente"];
		unset($_SESSION["cliente"]);
		
		require_once("gestionas/gestionBD.php");
		require_once("gestionas/gestionarCliente.php");
				
		echo $cliente['CIF'];
		
		$conexion = crearConexionBD();		
		$clienteB = eliminar_cliente($conexion,$cliente['CIF']);
		cerrarConexionBD($conexion);	
		
		if ($excepcion<>"") {
			$_SESSION["excepcion"] = $clienteB;
			$_SESSION["destino"] = "muestraCliente.php";
			Header("Location: excepcion.php");
		}
		else Header("Location: muestraCliente.php");
	}
	else Header("Location: muestraCliente.php"); // Se ha tratado de acceder directamente a este PHP
?>