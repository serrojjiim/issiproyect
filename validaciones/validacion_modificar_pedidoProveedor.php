<?php 	
	session_start();	
	require_once("../gestionas/gestionBD.php");
	
			$pedidoprovS = $_SESSION["pedidoprov"];
	
		$pedidoprov["OID_PEDPROV"] = $pedidoprovS["OID_PEDPROV"];
		$pedidoprov["FECHAPEDIDO"] = $pedidoprovS["FECHAPEDIDO"];
		$eliminar = "00:00:00 EUROPE/PARIS";
		
		$pedidoprov["FECHAPAGO"] = str_replace($eliminar, "", $pedidoprovS["FECHAPAGO"]);
		$pedidoprov["FECHAPAGO"] = 	$pedidoprov["FECHAPAGO"] . "00:00:00 EUROPE/PARIS";
		$pedidoprov["COSTETOTAL"] = $pedidoprovS["COSTETOTAL"];
		$pedidoprov["OID_PROV"] = $pedidoprovS["OID_PROV"];
		$pedidoprov["OID_EMP"] = $pedidoprovS["OID_EMP"];
	
			$_SESSION['pedidoprov'] = $pedidoprov;		
			
		
		
	// Validamos el formulario en servidor
	$conexion = crearConexionBD(); 
	$errores = validarDatosUsuario($conexion, $pedidoprov);
	cerrarConexionBD($conexion);
	
		
	// Si se han detectado errores
	if (count($errores)>0) {
		// Guardo en la sesión los mensajes de error y volvemos al formulario
		$_SESSION["errores"] = $errores;
		Header("Location: ../modificar/modificarPedidoProveedor.php");
	} else
		// Si todo va bien, vamos a la página de acción (inserción del usuario en la base de datos)
		Header('Location: ../accions/accion_modificar_pedidoProveedor.php');
		
function validarDatosUsuario($conexion, $pedidoprov){
	$errores=array();
	// Validación del CosteTotal
	if($pedidoprov["COSTETOTAL"]=="") 
		$errores[] = "<p>El coste total no puede estar vacío</p>";
	else if(!preg_match("/^[0-9]{1,100}$/", $pedidoprov["COSTETOTAL"])){
		$errores[] = "<p>El coste total debe contener entre 1 y 100 números : " . $pedidoprov["COSTETOTAL"] . "</p>";
	}	
	
	
	
	if(isDate($pedidoprov["FECHAPAGO"])==false) 
		$errores[] = "<p>La fecha tiene que tener el formato dd-mm-yy</p>";
	
	if(isDate($pedidoprov["FECHAPEDIDO"])==false) 
		$errores[] = "<p>La fecha tiene que tener el formato dd-mm-yy</p>";
	
	return $errores;
}		

function isDate($string) {
    $matches = array();
    $pattern = '/^([0-9]{1,2})\\/([0-9]{1,2})\\/([0-9]{2})/';
    if (!preg_match($pattern, $string, $matches)) return false;
    if (!checkdate($matches[2], $matches[1], $matches[3])) return false;
    return true;
}
?>