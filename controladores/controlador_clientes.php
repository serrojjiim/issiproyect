<?php	
	session_start();
	
	if (isset($_REQUEST["CIF"])){
		$cliente["OID_CLI"] = $_REQUEST["OID_CLI"];
		$cliente["CIF"] = $_REQUEST["CIF"];
		$cliente["NOMBRE"] = $_REQUEST["NOMBRE"];
		$cliente["DIRECCION"] = $_REQUEST["DIRECCION"];
		$cliente["TELEFONO"] = $_REQUEST["TELEFONO"];
		$cliente["EMAIL"] = $_REQUEST["EMAIL"];
		
		$_SESSION["cliente"] = $cliente;
			
		if (isset($_REQUEST["editar"])) Header("Location: ../modificarCliente.php");
		else if (isset($_REQUEST["borrar"])) Header("Location: ../accion_borrar_cliente.php");
		
		//else (isset($_REQUEST["grabar"])) Header("Location: accion_modificar_libro.php");
	}
	else 
		Header("Location: muestraCliente.php");

?>