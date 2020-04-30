<?php	
	session_start();
	
	
	if (isset($_SESSION["panadir"])) {
		$panadir = $_SESSION["panadir"];
		unset($_SESSION["panadir"]);
		
		require_once("../gestionas/gestionBD.php");
		require_once("../gestionas/gestionarPC.php");
		
		$conexion = crearConexionBD();		
		$excepcion = anadirproducto($conexion,$panadir['OID_PROD'],$panadir['OID_PEDCLI'],$panadir['CANTIDAD']);
		cerrarConexionBD($conexion);
			
		
		if ($excepcion<>"1") {
			$_SESSION["excepcion"] = $excepcion;
			$_SESSION["destino"] = "muestraEmpleados.php";
			Header("Location: ../excepcion.php");
		}
		else Header("Location: ../modificar/nuevoPedidoC2.php");
	}
	else Header("Location: ../muestra/muestraPedidosClientes.php"); // Se ha tratado de acceder directamente a este PHP
?>
