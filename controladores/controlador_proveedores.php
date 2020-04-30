<?php	
	session_start();
	
	$infoPag = $_SESSION["paginacion"];
	$PAG_NUM = $infoPag['PAG_NUM'];
	$PAG_TAM = $infoPag['PAG_TAM'];
	
	if (isset($_REQUEST["CIF"])){
		$cliente["OID_PROV"] = $_REQUEST["OID_PROV"];
		$cliente["CIF"] = $_REQUEST["CIF"];
		$cliente["NOMBRE"] = $_REQUEST["NOMBRE"];
		$cliente["DIRECCION"] = $_REQUEST["DIRECCION"];
		$cliente["TELEFONO"] = $_REQUEST["TELEFONO"];
		$cliente["EMAIL"] = $_REQUEST["EMAIL"];
		
		$_SESSION["proveedor"] = $proveedor;
			
		if (isset($_REQUEST["editar"])) Header("Location: ../modificar/modificarProveedor.php");
		else if (isset($_REQUEST["borrar"])) Header("Location: ../accions/accion_borrar_proveedor.php");
		else if (isset($_REQUEST["activar"])) Header("Location: ../accions/accion_activar_proveedor.php");
		else if(isset($_REQUEST["guardar"])) Header("Location: ../accions/accion_modificar_proveedor.php");
		else if(isset($_REQUEST["patras"])) Header("Location: ../muestra/muestraProveedor.php?PAG_NUM=".$PAG_NUM."&PAG_TAM=".$PAG_TAM);
	}
	else 
		Header("Location: ../muestra/muestraProveedor.php?PAG_NUM=".$PAG_NUM."&PAG_TAM=".$PAG_TAM);

?>
