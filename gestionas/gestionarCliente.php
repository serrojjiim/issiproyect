<?php 

function consultarClientes($conexion) {
 	$consulta = "SELECT * FROM CLIENTE";
	return $conexion->query($consulta);
}

?>