<?php
	
	session_start();
	
	$infoPag = $_SESSION["paginacion"];
	$PAG_NUM = $infoPag['PAG_NUM'];
	$PAG_TAM = $infoPag['PAG_TAM'];
	
	
	if(isset($_SESSION['pedidoprov'])){
		$pedprov = $_SESSION['pedidoprov'];
	
	require_once("../gestionas/gestionBD.php");
	require_once("../gestionas/gestionarPP.php");
 
	if($pedprov['FECHAPAGO']==" ") $pedprov['FECHAPAGO']=NULL;

	$conexion = crearConexionBD();
	
	$error = modificarPP($conexion,$pedprov['OID_PEDPROV'],$pedprov['FECHAPEDIDO'],$pedprov['FECHAPAGO'],$pedprov['COSTETOTAL'],$pedprov['OID_PROV'],$pedprov['OID_EMP']);
	
	
	echo $error;
	
		if($error==1){
		$_SESSION['mOkModPedProv'] = "Ok";
		Header("Location: ../muestra/muestraPedidosProveedores.php?PAG_NUM=".$PAG_NUM."&PAG_TAM=".$PAG_TAM);
	}
	}
		else Header("Location: ../muestra/muestraPedidosProveedores.php?PAG_NUM=".$PAG_NUM."&PAG_TAM=".$PAG_TAM); // Se ha tratado de acceder directamente a este PHP
	
		



?>