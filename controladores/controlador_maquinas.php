<?php	
	session_start();
	
	$infoPag = $_SESSION["paginacion"];
	$PAG_NUM = $infoPag['PAG_NUM'];
	$PAG_TAM = $infoPag['PAG_TAM'];
		
	if (isset($_REQUEST["OID_MAQ"])){
		$empleado["OID_MAQ"] = $_REQUEST["OID_MAQ"];
		$empleado["NOMBRE"] = $_REQUEST["NOMBRE"];
		
		
		$_SESSION["maquina"] = $maquina;
			
		if(isset($_REQUEST['borrar'])) Header("Location: ../accions/accion_borrar_maquina.php");
	}
	else 
		Header("Location: ../modificar/modificarMaquina.php");

?>
