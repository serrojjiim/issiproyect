<?php
	session_start();

	if(isset($_REQUEST['CIF'])){
		$ncliente['NOMBRE'] = $_REQUEST['NOMBRE'];
		$ncliente['CIF'] = $_REQUEST['CIF'];
		$ncliente['TELEFONO'] = $_REQUEST['TELEFONO'];
		$ncliente['DIRECCION'] = $_REQUEST['DIRECCION'];
		$ncliente['EMAIL']= $_REQUEST['EMAIL'];

		$_SESSION["ncliente"]  = $ncliente;		
		
		if(isset($_REQUEST['guardar'])) Header("Location: ../validaciones/validacion_anadir_cliente.php");
		else if(isset($_REQUEST['patras'])) Header("Location: ../muestra/muestraCliente.php");
		else Header("Location: ../modificar/nuevoCliente.php");
	}


?>