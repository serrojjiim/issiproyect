<?php 	

	session_start();

if (isset($_REQUEST["CIF"])){
		$cliente["OID_CLI"] = $_REQUEST["OID_CLI"];
		$cliente["CIF"] = $_REQUEST["CIF"];
		$cliente["NOMBRE"] = $_REQUEST["NOMBRE"];
		$cliente["DIRECCION"] = $_REQUEST["DIRECCION"];
		$cliente["TELEFONO"] = $_REQUEST["TELEFONO"];
		$cliente["EMAIL"] = $_REQUEST["EMAIL"];
		
		$_SESSION['cliente'] = $cliente;
		
		if (isset($_REQUEST["guardar"])) Header("Location: ../accions/accion_modificar_cliente.php"); 
		
}	
		
		
		
?>
