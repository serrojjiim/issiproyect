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
		
		$soltarCamion = soltarCamion($conexion,$camion['OID_CAM']);
	
		cerrarConexionBD($conexion);
		if($soltarCamion<>""){
			$_SESSION["excepcion"] = $soltarCamion;
			$_SESSION["destino"] = "accion_soltar_camion.php";
				Header("Location: ../excepcion.php");
		}else 
			$_SESSION["mensajeok"] = 1;
			Header("Location: ../muestra/muestraCamiones.php?PAG_NUM=".$PAG_NUM."&PAG_TAM=".$PAG_TAM);	
		}
		else Header("Location: ../muestra/muestraCamiones.php?PAG_NUM=".$PAG_NUM."&PAG_TAM=".$PAG_TAM);
	
	
	



 ?>
