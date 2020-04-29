<?php

	session_start();

	$infoPag = $_SESSION["paginacion"];
	$PAG_NUM = $infoPag['PAG_NUM'];
	$PAG_TAM = $infoPag['PAG_TAM'];
	
	
	if(isset($_SESSION['pedcli'])){
		$pedcli = $_SESSION['pedcli'];	
		unset($_SESSION['pedcli']);
		
		require_once("../gestionas/gestionBD.php");
		require_once("../gestionas/gestionarPC.php");
		
		$conexion = crearConexionBD();
		
		$error = quitarPC($conexion,$pedcli['OID_PEDCLI']);
		
		echo $error;
		 Header("Location: ../muestra/muestraPedidosClientes.php?PAG_NUM=".$PAG_NUM."&PAG_TAM=".$PAG_TAM);
	}
		else Header("Location: ../muestra/muestraPedidosClientes.php?PAG_NUM=".$PAG_NUM."&PAG_TAM=".$PAG_TAM); // Se ha tratado de acceder directamente a este PHP
	

?>