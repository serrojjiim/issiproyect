<?php 

function consultarProductos($conexion) {
 	$consulta = "SELECT * FROM PRODUCTO";
	return $conexion->query($consulta);
}

?>