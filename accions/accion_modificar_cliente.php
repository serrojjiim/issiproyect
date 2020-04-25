<?php 
	session_start();
	if(isset($_SESSION['cliente'])){
		$cliente = $_SESSION['cliente'];
		unset($_SESSION['cliente']);
	
	require_once("../gestionas/gestionBD.php");
	require_once("../gestionas/gestionarCliente.php");
 
	$conexion = crearConexionBD();
	$actualizaCli = actualizarDatosCliente($conexion,$cliente['OID_CLI'],$cliente['CIF'],$cliente['NOMBRE']
	,$cliente['DIRECCION'],$cliente['TELEFONO'],$cliente['EMAIL'],$cliente['OCULTO']);
	
	$_SESSION['cliente'] = getClienteOid($conexion, $cliente['OID_CLI']);
	cerrarConexionBD($conexion);
	if($actualizaCli<>""){
		$_SESSION["excepcion"] = $actualizaCli;
		$_SESSION["destino"] = "modificarCliente.php";
			Header("Location: ../excepcion.php");
	}else 
		$_SESSION["mensajeok"] = 1;
		Header("Location: ../modificar/modificarCliente.php");	
	}
		else Header("Location: ../muestra/muestraCliente.php"); // Se ha tratado de acceder directamente a este PHP
	
	
	



 ?>
