<?php	
	session_start();
	
	if (isset($_REQUEST["OID_EMP"])){
		
		$pedidocli["OID_CLI"] = $_REQUEST["OID_CLI"];
		$pedidocli["OID_EMP"] = $_REQUEST["OID_EMP"];
		
		
		$_SESSION["newpedidocliente"] = $pedidocli;
			
		if (isset($_REQUEST["comprar"])) Header("Location: ../accions/accion_nuevoPedidoC1.php"); 
		
	}
	else 
		Header("Location: ../muestra/muestraPedidosClientes.php");

?>
