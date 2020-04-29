<?php
	session_start();
	
	if(isset($_REQUEST['FECHAPEDIDO'])){
		$pedcli['OID_PEDCLI'] = $_REQUEST['OID_PEDCLI'];
		$pedcli['FECHAPEDIDO'] = $_REQUEST['FECHAPEDIDO'];
		$pedcli['FECHAFINFABRICACION'] = $_REQUEST['FECHAFINFABRICACION'];
		$pedcli['FECHAENVIO'] = $_REQUEST['FECHAENVIO']; 
		$pedcli['FECHALLEGADA'] = $_REQUEST['FECHALLEGADA']; 
		$pedcli['FECHAPAGO'] = $_REQUEST['FECHAPAGO']; 
		$pedcli['COSTETOTAL'] = $_REQUEST['COSTETOTAL']; 
		$pedcli['OID_CLI'] = $_REQUEST['OID_CLI']; 
		$pedcli['OID_EMP'] = $_REQUEST['OID_EMP'];
		
		$_SESSION['pedcli'] = $pedcli;
		
		if(isset($_REQUEST['editar'])) Header("Location: ../modificar/modificarPedidoCliente.php") ;
		else if(isset($_REQUEST['guardarMod'])) Header("Location: ../accions/accion_modificar_pedidoCliente.php");
		else if(isset($_REQUEST['borrar'])) Header("Location: ../accions/accion_borrar_pedidoCliente.php");
	}


?>