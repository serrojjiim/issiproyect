<?php 
	session_start();
	
	$infoPag = $_SESSION["paginacion"];
	$PAG_NUM = $infoPag['PAG_NUM'];
	$PAG_TAM = $infoPag['PAG_TAM'];
	
	if(isset($_SESSION['camion'])){
		include_once('../gestionas/gestionBD.php');
		include_once('../gestionas/gestionarCamion.php');
		
		$camion = $_SESSION['camion'];
		$conexion = crearConexionBD();
		$oid_cam = $camion['OID_CAM'];$oid_emp = $camion['OID_EMP'];
		$error = cogerCamion($conexion,$oid_cam,$oid_emp);
		if($error==1) $_SESSION['mOkCogeCamion'] = "Ok";
		else if($error==0) $_SESSION['mOkCogeCamion'] = 0;
		Header("Location: ../muestra/muestraCamiones.php?PAG_NUM=".$PAG_NUM."&PAG_TAM=".$PAG_TAM);
	}else
		Header("Location: ../muestra/muestraCamiones.php?PAG_NUM=".$PAG_NUM."&PAG_TAM=".$PAG_TAM);
?>