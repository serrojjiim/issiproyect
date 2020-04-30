<?php	
	session_start();
	
	if (isset($_REQUEST["OID_PEDPROV"])){
		$pedidoprov["OID_PEDPROV"] = $_REQUEST["OID_PEDPROV"];
		$pedidoprov["FECHAPEDIDO"] = $_REQUEST["FECHAPEDIDO"];
		$pedidoprov["FECHAPAGO"] = $_REQUEST["FECHAPAGO"];
		$pedidoprov["COSTETOTAL"] = $_REQUEST["COSTETOTAL"];
		$pedidoprov["OID_PROV"] = $_REQUEST["OID_PROV"];
		$pedidoprov["OID_EMP"] = $_REQUEST["OID_EMP"];
	
		
		
		
		$_SESSION["pedidoprov"] = $pedidoprov;
			
		if (isset($_REQUEST["editar"])) Header("Location: ../modificar/modificarPedidoProveedor.php"); 
		else if(isset($_REQUEST["borrar"])) Header("Location: ../accions/accion_borrar_pedidoproveedor.php"); 
		else if(isset($_REQUEST["guardarMod"])) Header("Location: ../accions/accion_modificar_pedidoProveedor.php");
	}
	else 
		Header("Location: ../muestra/muestraPedidosProveedores.php");

?>
