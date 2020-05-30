<?php
	session_start();
	include_once('../gestionas/gestionBD.php');
	include_once('../gestionas/gestionarMaquina.php');
	if(isset($_SESSION['maquina'])){
			$conexion = crearConexionBD();
	$maquina = $_SESSION['maquina'];
	$maquina['NOMBRE']=$_SESSION['NOMBREMAQUINA'];
	$_SESSION['maquina'] = $maquina;
	$empleadoMod = $_SESSION['empleadoMod'];
	$paginacion = $_SESSION['paginacion'];
	
	
	$error = actualizarMaquina($conexion,$maquina['OID_MAQ'],$_SESSION['NOMBREMAQUINA']);
	
	
	if($error==1) $_SESSION['mOkEditarMaq'] = "Ok";
		cerrarConexionBD($conexion);
	
	Header("Location: ../modificar/modificarMaquina.php?PAG_NUM=" . $paginacion['PAG_NUM'] . "&PAG_TAM=" . $paginacion['PAG_TAM']);
	}else
			Header("Location: ../modificar/modificarMaquina.php?PAG_NUM=" . $paginacion['PAG_NUM'] . "&PAG_TAM=" . $paginacion['PAG_TAM']);
		
	
	
?>