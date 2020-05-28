<?php 
	session_start();
	$paginacion = $_SESSION['paginacion'];
	
	if(isset($_SESSION['ncamion'])){
		include_once('../gestionas/gestionBD.php');
		include_once('../gestionas/gestionarCamion.php');
		$ncamion = $_SESSION['ncamion'];
		$conexion = crearConexionBD();
		$matricula = $ncamion['MATRICULA'];
		$error = nuevoCamion($conexion,$matricula);
		if($error==1) $_SESSION['mOkAnadeCamion'] = "Ok";
		else if($error==0) $_SESSION['mOkAnadeCamion'] = 0;
		Header('Location: ../modificar/nuevoCamion.php');
	}else
		Header('Location: ../modificar/nuevoCamion.php');


?>