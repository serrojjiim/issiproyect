<?php	
	session_start();	
	
	$infoPag = $_SESSION["paginacion"];
	$PAG_NUM = $infoPag['PAG_NUM'];
	$PAG_TAM = $infoPag['PAG_TAM'];
	
	if (isset($_SESSION["maquina"])) {
		$maquina = $_SESSION["maquina"];
		unset($_SESSION["maquina"]);
		
		require_once("../gestionas/gestionBD.php");
		require_once("../gestionas/gestionarMaquina.php");
				
		
		$conexion = crearConexionBD();		
		$oid =  $maquina['OID_MAQ'];
		$error = quitarEmpleadosMaquina($conexion,$oid);
		$error2 = borrarMaq($conexion,$oid);
		if(($error and $error2)==1) $_SESSION['mOkBorrarMaq'] = "Ok";
	 Header("Location: ../muestra/muestraMaquinas.php?PAG_NUM=".$PAG_NUM."&PAG_TAM=".$PAG_TAM);
	}
	else Header("Location: ../muestra/muestraMaquinas.php?PAG_NUM=".$PAG_NUM."&PAG_TAM=".$PAG_TAM); 
?>