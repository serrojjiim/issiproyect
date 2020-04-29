<?php 
	session_start();
	
	$infoPag = $_SESSION["paginacion"];
	$PAG_NUM = $infoPag['PAG_NUM'];
	$PAG_TAM = $infoPag['PAG_TAM'];
	
	if(isset($_SESSION['pedcli'])){
		$pedcli = $_SESSION['pedcli'];
	
	require_once("../gestionas/gestionBD.php");
	require_once("../gestionas/gestionarPC.php");
 
 	if($pedcli['FECHAFINFABRICACION']==" ") $pedcli['FECHAFINFABRICACION']=NULL;
	else if($pedcli['FECHAENVIO']==" ") $pedcli['FECHAENVIO']=NULL;
	else if($pedcli['FECHALLEGADA']==" ") $pedcli['FECHALLEGADA']=NULL;
	else if($pedcli['FECHAPAGO']==" ") $pedcli['FECHAPAGO']=NULL;
	$conexion = crearConexionBD();
	
	$error = modificarPC($conexion,$pedcli['OID_PEDCLI'],$pedcli['FECHAPEDIDO'],$pedcli['FECHAFINFABRICACION'],$pedcli['FECHAENVIO'],$pedcli['FECHALLEGADA'],$pedcli['FECHAPAGO'],$pedcli['COSTETOTAL'],$pedcli['OID_CLI'],$pedcli['OID_EMP']);
	
	if($error==1){
		$_SESSION['mOkModPedCli'] = "Ok";
		Header("Location: ../modificar/modificarPedidoCliente.php");
	}
	}
		else Header("Location: ../modificar/modificarPedidoCliente.php"); // Se ha tratado de acceder directamente a este PHP

 ?>
