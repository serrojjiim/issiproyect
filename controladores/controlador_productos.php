<?php	
	session_start();
	
	if (isset($_REQUEST["CIF"])){
		$producto["OID_PROD"] = $_REQUEST["OID_PROD"];
		$producto["PRECIO"] = $_REQUEST["PRECIO"];
		$producto["LONGITUD"] = $_REQUEST["LONGITUD"];
		$producto["PROFUNDIDAD"] = $_REQUEST["PROFUNDIDAD"];
		$producto["ALTURA"] = $_REQUEST["ALTURA"];
		$producto["ACABADO"] = $_REQUEST["ACABADO"];
		
		$_SESSION["producto"] = $producto;
		
		// if (isset($_REQUEST["editar"])) Header("Location: consulta_libros.php"); 
		// else if (isset($_REQUEST["grabar"])) Header("Location: accion_modificar_libro.php");
		// else Header("Location: accion_borrar_libro.php"); 
	}
	else 
		Header("Location: pruebaPaginacion.php");

?>
