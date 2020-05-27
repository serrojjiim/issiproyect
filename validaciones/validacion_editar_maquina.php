<?php 	
	session_start();	
	require_once("../gestionas/gestionBD.php");
	
				
			
		
		
	// Validamos el formulario en servidor
	$conexion = crearConexionBD(); 
	$errores = validarDatosUsuario($conexion, $_SESSION["NOMBREMAQUINA"]);
	cerrarConexionBD($conexion);
	
	
	// Si se han detectado errores
	if (count($errores)>0) {
		// Guardo en la sesión los mensajes de error y volvemos al formulario
		$_SESSION["errores"] = $errores;
		$maquina = $_SESSION["maquina"];
		$_SESSION["NOMBREMAQUINA"] = $maquina["NOMBRE"];
		Header("Location: ../modificar/modificarMaquina.php");
	} 
		// Si todo va bien, vamos a la página de acción (inserción del usuario en la base de datos)
			Header('Location: ../accions/accion_editar_maquina.php');
		
function validarDatosUsuario($conexion, $nombre){
	$errores=array();
	// Validación del nombre
	if($nombre=="" or $nombre==" " ) 
		$errores[] = "<p>El nombre no puede estar vacío</p>";
	
	return $errores;
}		
?>