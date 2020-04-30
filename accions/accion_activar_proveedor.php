<?php 

	session_start();
	include_once('../gestionas/gestionBD.php');
	include_once('../gestionas/gestionarProveedor.php');
	$paginacion = $_SESSION['paginacion'];

	if(isset($_SESSION['proveedor'])){
		$proveedor = $_SESSION['proveedor'];
	$conexion = crearConexionBD();
	
	
	$error = activarP($conexion,$proveedor['CIF']);
	
	echo $error;
	if($error==1){
		
		Header('Location: ../muestra/muestraProveedor.php?PAG_NUM=' . $paginacion['PAG_NUM'] . "&PAG_TAM=" . $paginacion['PAG_TAM']);
		
	}else{
		Header('Location: ../muestra/muestraProveedor.php?PAG_NUM=' . $paginacion['PAG_NUM'] . "&PAG_TAM=" . $paginacion['PAG_TAM']);
		} 
	}else
		Header('Location: ../muestra/muestraProveedor.php?PAG_NUM=' . $paginacion['PAG_NUM'] . "&PAG_TAM=" . $paginacion['PAG_TAM'])
	
	
	
?>