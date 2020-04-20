<?php 

function consultarProveedor($conexion) {
 	$consulta = "SELECT * FROM PROVEEDOR";
	return $conexion->query($consulta);
}

?>