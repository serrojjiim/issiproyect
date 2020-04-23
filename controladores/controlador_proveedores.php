<?php	
	session_start();
	
	if (isset($_REQUEST["CIF"])){
		$proveedor["OID_PROV"] = $_REQUEST["OID_PROV"];
		$proveedor["CIF"] = $_REQUEST["CIF"];
		$proveedor["NOMBRE"] = $_REQUEST["NOMBRE"];
		$proveedor["DIRECCION"] = $_REQUEST["DIRECCION"];
		$proveedor["TELEFONO"] = $_REQUEST["TELEFONO"];
		$proveedor["EMAIL"] = $_REQUEST["EMAIL"];
		
		$_SESSION["proveedor"] = $proveedor;
			
		// if (isset($_REQUEST["editar"])) Header("Location: consulta_libros.php"); 
		// else if (isset($_REQUEST["grabar"])) Header("Location: accion_modificar_libro.php");
		// else Header("Location: accion_borrar_libro.php"); 
	}
	else 
		Header("Location: pruebaPaginacion.php");

?>
