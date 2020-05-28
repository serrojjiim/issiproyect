<?php 	
	session_start();	
	require_once("../gestionas/gestionBD.php");
	
			$proveedorS = $_SESSION["nproveedor"];
	
			$proveedor["OID_PROV"] = $proveedorS["OID_PROV"];
			$proveedor["CIF"] = $proveedorS["CIF"];
			$proveedor["NOMBRE"] = $proveedorS["NOMBRE"];
			$proveedor["DIRECCION"] = $proveedorS["DIRECCION"];
			$proveedor["TELEFONO"] =$proveedorS["TELEFONO"];
			$proveedor["EMAIL"] = $proveedorS["EMAIL"];
			$_SESSION['proveedor'] = $proveedor;		
			
		
		
	// Validamos el formulario en servidor
	$conexion = crearConexionBD(); 
	$errores = validarDatosUsuario($conexion, $proveedor);
	cerrarConexionBD($conexion);
	
	
	// Si se han detectado errores
	if (count($errores)>0) {
		// Guardo en la sesión los mensajes de error y volvemos al formulario
		$_SESSION["errores"] = $errores;
		Header("Location: ../modificar/nuevoProveedor.php");
	} 
		// Si todo va bien, vamos a la página de acción (inserción del usuario en la base de datos)
		//Header('Location: ../accions/accion_nuevo_proveedor.php');
		
function validarDatosUsuario($conexion, $proveedor){
	$errores=array();
	// Validación del CIF
	if($proveedor["CIF"]=="") 
		$errores[] = "<p>El CIF no puede estar vacío</p>";
	else if(!preg_match("/^[a-zA-Z]{1}[0-9]{7}[a-zA-Z]{1}$/", $proveedor["CIF"])){
		$errores[] = "<p>El CIF debe contener 7 números y dos letras mayúsculas: " . $proveedor["CIF"] . "</p>";
	}

	// Validación del nombre			
	if($proveedor["NOMBRE"]=="") 
		$errores[] = "<p>El nombre no puede estar vacío</p>";
	
	// Validación del email
	if($proveedor["EMAIL"]==""){ 
		$errores[] = "<p>El email no puede estar vacío</p>";
	}else if(!filter_var($proveedor["EMAIL"], FILTER_VALIDATE_EMAIL)){
		$errores[] = "<p>El email es incorrecto: " . $proveedor["EMAIL"] . "</p>";
	}
		
	//Validación de la dirección
	if($proveedor["DIRECCION"]==""){
		$errores[] = "<p>La dirección no puede estar vacío</p>";	
	}
	
	//Validación del teléfono
	 if($proveedor["TELEFONO"]==""){
		$errores[] = "<p>El teléfono no puede estar vacío</p>";	
	 }else if(!preg_match("/^[0-9]{9}$/", $proveedor["TELEFONO"])){
	$errores[] = "<p>El teléfono no es correcto.</p>";	
		
	 }
	
	return $errores;
}		
?>