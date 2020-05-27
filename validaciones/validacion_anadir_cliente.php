<?php 	
	session_start();	
	require_once("../gestionas/gestionBD.php");
	
			$clienteS = $_SESSION["ncliente"];
	
			$cliente["OID_CLI"] = $clienteS["OID_CLI"];
			$cliente["CIF"] = $clienteS["CIF"];
			$cliente["NOMBRE"] = $clienteS["NOMBRE"];
			$cliente["DIRECCION"] = $clienteS["DIRECCION"];
			$cliente["TELEFONO"] =$clienteS["TELEFONO"];
			$cliente["EMAIL"] = $clienteS["EMAIL"];
			$_SESSION['cliente'] = $cliente;		
			
		
		
	// Validamos el formulario en servidor
	$conexion = crearConexionBD(); 
	$errores = validarDatosUsuario($conexion, $cliente);
	cerrarConexionBD($conexion);
	
	
		
	// Si se han detectado errores
	if (count($errores)>0) {
		// Guardo en la sesión los mensajes de error y volvemos al formulario
		$_SESSION["errores"] = $errores;
		Header("Location: ../modificar/nuevoCliente.php");
	} 
		// Si todo va bien, vamos a la página de acción (inserción del usuario en la base de datos)
		//Header('Location: ../accions/accion_nuevo_cliente.php');
		
function validarDatosUsuario($conexion, $cliente){
	$errores=array();
	// Validación del NIF
	if($cliente["CIF"]=="") 
		$errores[] = "<p>El CIF no puede estar vacío</p>";
	else if(!preg_match("/^[a-zA-Z]{1}[0-9]{7}[a-zA-Z]{1}$/", $cliente["CIF"])){
		$errores[] = "<p>El CIF debe contener 7 números y dos letra mayúscula: " . $cliente["CIF"] . "</p>";
	}

	// Validación del Nombre			
	if($cliente["NOMBRE"]=="") 
		$errores[] = "<p>El nombre no puede estar vacío</p>";
	
	// Validación del email
	if($cliente["EMAIL"]==""){ 
		$errores[] = "<p>El email no puede estar vacío</p>";
	}else if(!filter_var($cliente["EMAIL"], FILTER_VALIDATE_EMAIL)){
		$errores[] = "<p>El email es incorrecto: " . $cliente["EMAIL"] . "</p>";
	}
		
	//Validación de la dirección
	
	if($cliente["DIRECCION"]==""){
		$errores[] = "<p>La dirección no puede estar vacío</p>";	
	}
	
	//Validación del teléfono
	 if($cliente["TELEFONO"]==""){
		$errores[] = "<p>El teléfono no puede estar vacío</p>";	
	 }else if(!preg_match("/^[0-9]{9}$/", $cliente["TELEFONO"])){
	$errores[] = "<p>El teléfono no es correcto.</p>";	
		
	 }
	
	return $errores;
}		
?>