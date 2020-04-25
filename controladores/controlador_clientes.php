<?php	
	session_start();
	
	$infoPag = $_SESSION["paginacion"];
	$PAG_NUM = $infoPag['PAG_NUM'];
	$PAG_TAM = $infoPag['PAG_TAM'];
	
	if (isset($_REQUEST["CIF"])){
		$cliente["OID_CLI"] = $_REQUEST["OID_CLI"];
		$cliente["CIF"] = $_REQUEST["CIF"];
		$cliente["NOMBRE"] = $_REQUEST["NOMBRE"];
		$cliente["DIRECCION"] = $_REQUEST["DIRECCION"];
		$cliente["TELEFONO"] = $_REQUEST["TELEFONO"];
		$cliente["EMAIL"] = $_REQUEST["EMAIL"];
		
		$_SESSION["cliente"] = $cliente;
			
		if (isset($_REQUEST["editar"])) Header("Location: ../modificar/modificarCliente.php");
		else if (isset($_REQUEST["borrar"])) Header("Location: ../accions/accion_borrar_cliente.php");
		
		//else (isset($_REQUEST["grabar"])) Header("Location: accion_modificar_libro.php");
	}
	else 
		Header("Location: ../muestra/muestraCliente.php?PAG_NUM=".$PAG_NUM."&PAG_TAM=".$PAG_TAM);

?>