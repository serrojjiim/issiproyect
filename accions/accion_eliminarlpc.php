<?php	
	session_start();	
	
	
	
	if (isset($_REQUEST["ELIMINARLINEA"])) {
		
		
		require_once("../gestionas/gestionBD.php");
		require_once("../gestionas/gestionarPC.php");
				
		
		$conexion = crearConexionBD();		
		
		$error = eliminarlpc($conexion,$_REQUEST["OID_LINPEDCLI"]);
		cerrarConexionBD($conexion);
		// if(($error and $error2)==1) $_SESSION['mOkBorrarMaq'] = "Ok";
	 Header("Location: ../modificar/nuevopedidoC2.php");
	}
	else Header("Location: ../muestra/muestraPedidosClientes.php"); 
?>