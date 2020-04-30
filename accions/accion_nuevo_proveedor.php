<?php 
	session_start();
	$paginacion = $_SESSION['paginacion'];
	
	if(isset($_SESSION['nproveedor'])){
		include_once('../gestionas/gestionBD.php');
		include_once('../gestionas/gestionarProveedor.php');
		$nempleado = $_SESSION['nproveedor'];
		$conexion = crearConexionBD();
		$cif = $nempleado['CIF'];$nombre = $nempleado['NOMBRE'];$telefono = $nempleado['TELEFONO'];$direccion = $nempleado['DIRECCION'];$email = $nempleado['EMAIL'];
		$error = nuevoProveedor($conexion,$nombre,$cif,$telefono,$direccion,$email);
		if($error==1) $_SESSION['mOkAnadeProveedor'] = "Ok";
		Header('Location: ../modificar/nuevoProveedor.php');
		
	}else
		Header('Location: ../modificar/nuevoProveedor.php');


?>