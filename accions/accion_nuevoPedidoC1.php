<?php	
	session_start();	
	
	$infoPag = $_SESSION["paginacion"];
	$PAG_NUM = $infoPag['PAG_NUM'];
	$PAG_TAM = $infoPag['PAG_TAM'];
	
	if (isset($_SESSION["newpedidocliente"])) {
		$pedido = $_SESSION["newpedidocliente"];
		unset($_SESSION["newpedidocliente"]);
		
		require_once("../gestionas/gestionBD.php");
		require_once("../gestionas/gestionarPC.php");
		
		$conexion = crearConexionBD();	
		
		$excepcion = crearpedido($conexion,$pedido["OID_CLI"],$pedido["OID_EMP"]);
		
		
		if ($excepcion<>"") {
			$_SESSION["excepcion"] = $excepcion;
			$_SESSION["destino"] = "nuevoPedidoC1.php";
			Header("Location: ../excepcion.php");
		}
		$oid_pedcli = obtenerultimopedido($conexion);
		$_SESSION["oid_pedcli"] = $oid_pedcli[0];
		$_SESSION["oid_pedcli_costetotal"] = $oid_pedcli[1];
		cerrarConexionBD($conexion);
		Header("Location: ../modificar/nuevoPedidoC2.php");
	}
	else Header("Location: ../muestra/muestraPedidosClientes.php?PAG_NUM=".$PAG_NUM."&PAG_TAM=".$PAG_TAM); // Se ha tratado de acceder directamente a este PHP
?>
