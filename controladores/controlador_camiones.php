<?php	
	session_start();
	
	$infoPag = $_SESSION["paginacion"];
	$PAG_NUM = $infoPag['PAG_NUM'];
	$PAG_TAM = $infoPag['PAG_TAM'];
	
	if (isset($_REQUEST["OID_CAM"])){
		$camion["OID_CAM"] = $_REQUEST["OID_CAM"];
		$camion["OID_EMP"] = $_SESSION['oid_emp'];
		$camion["MATRICULA"] = $_REQUEST["MATRICULA"];
		$camion["NOMBRE"] = $_REQUEST["NOMBRE"];
		$camion["APELLIDOS"] = $_REQUEST["APELLIDOS"];
		$camion["FECHAINICIO"] = $_REQUEST["FECHAINICIO"];
		$camion["FECHAFIN"] = $_REQUEST["FECHAFIN"];
		
		$_SESSION["camion"] = $camion;
			
		if (isset($_REQUEST["borrar"])) Header("Location: ../accions/accion_borrar_camion.php");
		else if (isset($_REQUEST["coger"])) Header("Location: ../accions/accion_coger_camion.php");
		else if (isset($_REQUEST["soltar"])) Header("Location: ../accions/accion_soltar_camion.php");
	}
	else 
		Header("Location: ../muestra/muestraCamiones.php?PAG_NUM=".$PAG_NUM."&PAG_TAM=".$PAG_TAM);

?>
