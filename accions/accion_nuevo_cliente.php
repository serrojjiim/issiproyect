<?php 
	session_start();
	$paginacion = $_SESSION['paginacion'];
	
	if(isset($_SESSION['ncliente'])){
		include_once('../gestionas/gestionBD.php');
		include_once('../gestionas/gestionarCliente.php');
		$nempleado = $_SESSION['ncliente'];
		$conexion = crearConexionBD();
		$cif = $nempleado['CIF'];$nombre = $nempleado['NOMBRE'];$telefono = $nempleado['TELEFONO'];$direccion = $nempleado['DIRECCION'];$email = $nempleado['EMAIL'];
		$error = nuevoCliente($conexion,$nombre,$cif,$telefono,$direccion,$email);
		if($error==1) $_SESSION['mOkAnadeCliente'] = "Ok";
		Header('Location: ../modificar/nuevoCliente.php');
		
	}else
		Header('Location: ../modificar/nuevoCliente.php');


?>