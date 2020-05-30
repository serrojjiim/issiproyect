<?php	
	session_start();	
	
	$infoPag = $_SESSION["paginacion"];
	$PAG_NUM = $infoPag['PAG_NUM'];
	$PAG_TAM = $infoPag['PAG_TAM'];
	
	if (isset($_SESSION["camion"])) {
		$camion = $_SESSION["camion"];
		unset($_SESSION["camion"]);
		
		require_once("../gestionas/gestionBD.php");
		require_once("../gestionas/gestionarCamion.php");
				
		$conexion = crearConexionBD();		
		$matricula =  $camion['MATRICULA'];
		$error = borrarCamion($conexion,$matricula);
		if(($error)==1) $_SESSION['mOkBorrarCam'] = "Ok";
	 Header("Location: ../muestra/muestraCamiones.php?PAG_NUM=".$PAG_NUM."&PAG_TAM=".$PAG_TAM);
	}
	else Header("Location: ../muestra/muestraCamiones.php?PAG_NUM=".$PAG_NUM."&PAG_TAM=".$PAG_TAM); 
?>