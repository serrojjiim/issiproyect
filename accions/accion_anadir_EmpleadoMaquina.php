<?php
	session_start();
	include_once('../gestionas/gestionBD.php');
	include_once('../gestionas/gestionarMaquina.php');
	$paginacion = $_SESSION['paginacion'];
	if(isset($_SESSION['maquina'])){
		
	
	$conexion = crearConexionBD();
	$maquina = $_SESSION['maquina'];
	$empleadoMod = $_SESSION['empleadoMod'];
	
	

	$error = actualizarEmpleadoMaquina($conexion,$empleadoMod['DNI'],$maquina['OID_MAQ']);

	cerrarConexionBD($conexion);

	
	Header("Location: ../modificar/modificarMaquina.php?PAG_NUM=" . $paginacion['PAG_NUM'] . "&PAG_TAM=" . $paginacion['PAG_TAM']);
	}
	else Header("Location: ../modificar/modificarMaquina.php?PAG_NUM=" . $paginacion['PAG_NUM'] . "&PAG_TAM=" . $paginacion['PAG_TAM']);
		
?>