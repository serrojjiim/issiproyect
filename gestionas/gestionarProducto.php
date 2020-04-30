<?php 

function consultarProductos($conexion) {
 	$consulta = "SELECT * FROM PRODUCTO";
	$stmt = $conexion->prepare($consulta);
	$stmt->execute();
	return $stmt->fetchAll();
	
}
function obtenerProducto($conexion,$oid_prod) {
 	$consulta = "SELECT * FROM PRODUCTO WHERE(OID_PROD = '$oid_prod')";
	$stmt = $conexion->prepare($consulta);
	$stmt->execute();
	return $stmt->fetch();
}
?>