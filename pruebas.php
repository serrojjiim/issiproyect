<?php 
	session_start();
	include_once("gestionas/gestionBD.php");
 	include_once("gestionas/gestionarEmpleado.php");
	$conexion = crearConexionBD();
	$usuario = consultaPassBD($conexion,"123","70878980W");
	$_SESSION['oof']= $usuario['DNI'];
	
?>
