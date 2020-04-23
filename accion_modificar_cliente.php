<?php 
	session_start();
	if(isset($_SESSION['cliente'])){
		$cliente = $_SESSION['cliente'];
		unset($_SESSION['cliente']);
	
	require_once("gestionas/gestionBD.php");
	require_once("gestionas/gestionarCliente.php");
	
	$conexion = crearConexion();
	
	
	}
	
	



 ?>
