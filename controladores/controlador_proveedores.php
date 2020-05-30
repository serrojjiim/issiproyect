<?php	
	session_start();
	
	$infoPag = $_SESSION["paginacion"];
	$PAG_NUM = $infoPag['PAG_NUM'];
	$PAG_TAM = $infoPag['PAG_TAM'];
	
	if (isset($_REQUEST["CIF"])){
		$proveedor["OID_PROV"] = $_REQUEST["OID_PROV"];
		$proveedor["CIF"] = $_REQUEST["CIF"];
		$proveedor["NOMBRE"] = $_REQUEST["NOMBRE"];
		$proveedor["DIRECCION"] = $_REQUEST["DIRECCION"];
		$proveedor["TELEFONO"] = $_REQUEST["TELEFONO"];
		$proveedor["EMAIL"] = $_REQUEST["EMAIL"];
		
		$_SESSION["proveedor"] = $proveedor;
			
		if (isset($_REQUEST["editar"])) Header("Location: ../modificar/modificarProveedor.php");
		else if (isset($_REQUEST["borrar"])) Header("Location: ../accions/accion_borrar_proveedor.php");
		else if (isset($_REQUEST["activar"])) Header("Location: ../accions/accion_activar_proveedor.php");
		else if(isset($_REQUEST["guardar"])) Header("Location: ../validaciones/validacion_editar_proveedor.php");
		else if(isset($_REQUEST["patras"])) Header("Location: ../muestra/muestraProveedor.php?PAG_NUM=".$PAG_NUM."&PAG_TAM=".$PAG_TAM);
	}
	else 
		Header("Location: ../muestra/muestraProveedor.php?PAG_NUM=".$PAG_NUM."&PAG_TAM=".$PAG_TAM);

?>
