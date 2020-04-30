<?php
	session_start();

	if(isset($_REQUEST['CIF'])){
		$nproveedor['NOMBRE'] = $_REQUEST['NOMBRE'];
		$nproveedor['CIF'] = $_REQUEST['CIF'];
		$nproveedor['TELEFONO'] = $_REQUEST['TELEFONO'];
		$nproveedor['DIRECCION'] = $_REQUEST['DIRECCION'];
		$nproveedor['EMAIL']= $_REQUEST['EMAIL'];

		$_SESSION["nproveedor"]  = $nproveedor;		
		
		if(isset($_REQUEST['guardar'])) Header("Location: ../accions/accion_nuevo_proveedor.php");
		else if(isset($_REQUEST['patras'])) Header("Location: ../muestra/muestraProveedor.php");
		else Header("Location: ../modificar/nuevoProveedor.php");
	}


?>