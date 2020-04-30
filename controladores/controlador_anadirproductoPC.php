
<?php	
	session_start();
	
	// $infoPag = $_SESSION["paginacion"];
	// $PAG_NUM = $infoPag['PAG_NUM'];
	// $PAG_TAM = $infoPag['PAG_TAM'];
		
	if (isset($_REQUEST["CANTIDAD"])){
		$panadir["OID_PROD"] = $_REQUEST["OID_PROD"];
		$panadir["OID_PEDCLI"] = $_REQUEST["OID_PEDCLI"];
		$panadir["CANTIDAD"] = $_REQUEST["CANTIDAD"];
		

		
		
		
		$_SESSION["panadir"] = $panadir;
			
		if (isset($_REQUEST["anadir"])) Header("Location: ../accions/accion_anadir_lineapedidocliente.php"); 
		// else if(isset($_REQUEST['patras'])) Header("Location: ../muestra/muestraEmpleados.php?PAG_NUM=".$PAG_NUM."&PAG_TAM=".$PAG_TAM);
	}
	else 
		Header("Location: ../muestra/modificarEmpleado.php");

?>
