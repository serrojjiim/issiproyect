<?php 
	session_start();
	
	$infoPag = $_SESSION["paginacion"];
	$PAG_NUM = $infoPag['PAG_NUM'];
	$PAG_TAM = $infoPag['PAG_TAM'];
	
	if(isset($_SESSION['cliente'])){
		$cliente = $_SESSION['cliente'];
		unset($_SESSION['cliente']);
	
	require_once("../gestionas/gestionBD.php");
	require_once("../gestionas/gestionarCliente.php");
 
	$conexion = crearConexionBD();
	$actualizaCli = actualizarDatosCliente($conexion,$cliente['OID_CLI'],$cliente['CIF'],$cliente['NOMBRE']
	,$cliente['DIRECCION'],$cliente['TELEFONO'],$cliente['EMAIL']);
	
	$_SESSION['cliente'] = getClienteOid($conexion, $cliente['OID_CLI']);
	cerrarConexionBD($conexion);
	if($actualizaCli<>""){
		$_SESSION["excepcion"] = $actualizaCli;
		$_SESSION["destino"] = "modificarCliente.php";
			Header("Location: ../excepcion.php");
	}else 
		$_SESSION["mensajeok"] = 1;
		Header("Location: ../modificar/modificarCliente.php?PAG_NUM=".$PAG_NUM."&PAG_TAM=".$PAG_TAM);	
	}
		else Header("Location: ../muestra/muestraCliente.php?PAG_NUM=".$PAG_NUM."&PAG_TAM=".$PAG_TAM); // Se ha tratado de acceder directamente a este PHP
	
	
	



 ?>
