<?php 
	session_start();
	
	$infoPag = $_SESSION["paginacion"];
	$PAG_NUM = $infoPag['PAG_NUM'];
	$PAG_TAM = $infoPag['PAG_TAM'];
	
	if(isset($_SESSION['proveedor'])){
		$proveedor = $_SESSION['proveedor'];
	
	require_once("../gestionas/gestionBD.php");
	require_once("../gestionas/gestionarProveedor.php");
 
 
	$conexion = crearConexionBD();
	$actualizaProv = actualizarDatosProveedor($conexion,$proveedor['OID_PROV'],$proveedor['CIF'],$proveedor['NOMBRE']
	,$proveedor['DIRECCION'],$proveedor['TELEFONO'],$proveedor['EMAIL']);
			
	
	cerrarConexionBD($conexion);
	if($actualizaProv<>""){
		$_SESSION["excepcion"] = $actualizaProv;
		$_SESSION["destino"] = "modificarProveedor.php";
			Header("Location: ../excepcion.php");
	}else 
		$_SESSION["mensajeok"] = 1;
		Header("Location: ../modificar/modificarProveedor.php?PAG_NUM=".$PAG_NUM."&PAG_TAM=".$PAG_TAM);	
	}
		else Header("Location: ../muestra/muestraProveedor.php?PAG_NUM=".$PAG_NUM."&PAG_TAM=".$PAG_TAM); // Se ha tratado de acceder directamente a este PHP
	
	
	



 ?>
