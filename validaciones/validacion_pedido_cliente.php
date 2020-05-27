<?php
	session_start();

	// Importar librerías necesarias para gestionar direcciones y géneros literarios
	require_once("../gestionas/gestionBD.php");


	// Comprobar que hemos llegado a esta página porque se ha rellenado el formulario
	if (isset($_SESSION["newpedidocliente"])) {
		$pedidocliente = $_SESSION["newpedidocliente"];
	
	
				
	}
	else // En caso contrario, vamos al formulario
		Header("Location: ../modificar/nuevoPedidoC1.php");

	// Validamos el formulario en servidor
	$conexion = crearConexionBD(); 
	$errores = validarDatosPedido($conexion, $pedidocliente);
	cerrarConexionBD($conexion);
	
	// Si se han detectado errores
	if (count($errores)>0) {
		// Guardo en la sesión los mensajes de error y volvemos al formulario
		$_SESSION["errores"] = $errores;
		$_SESSION["pedidoerror"] = $pedidocliente;
		Header('Location: ../modificar/nuevoPedidoC1.php');
	} else
		// Si todo va bien, vamos a la página de acción (inserción del usuario en la base de datos)
		Header('Location: ../accions/accion_nuevoPedidoC1.php');

///////////////////////////////////////////////////////////
// Validación en servidor del formulario de alta de usuario
///////////////////////////////////////////////////////////
function validarDatosPedido($conexion, $nuevoPedido){
	$errores=array();


	// Validación del cliente			
	if($nuevoPedido["OID_CLI"]=="") 
		$errores[] = "<p>El cliente no puede estar vacío</p>";
	
	// Validación del empleado
	if($nuevoPedido["OID_EMP"]=="")
		$errores[] = "<p>El empleado no puede estar vacío</p>";
	
	
	
	
	return $errores;
}




?>

