<?php 

	session_start();
	include_once('../gestionas/gestionBD.php');
	include_once('../gestionas/gestionarCliente.php');
	$paginacion = $_SESSION['paginacion'];

	if(isset($_SESSION['cliente'])){
		$cliente = $_SESSION['cliente'];
	$conexion = crearConexionBD();
	
	
	$error = activarC($conexion,$cliente['CIF']);
	
	echo $error;
	if($error==1){
		
		Header('Location: ../muestra/muestraCliente.php?PAG_NUM=' . $paginacion['PAG_NUM'] . "&PAG_TAM=" . $paginacion['PAG_TAM']);
		
	}else{
		Header('Location: ../muestra/muestraCliente.php?PAG_NUM=' . $paginacion['PAG_NUM'] . "&PAG_TAM=" . $paginacion['PAG_TAM']);
		} 
	}else
		Header('Location: ../muestra/muestraCliente.php?PAG_NUM=' . $paginacion['PAG_NUM'] . "&PAG_TAM=" . $paginacion['PAG_TAM'])
	
	
	
?>