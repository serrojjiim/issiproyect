<?php 

function consultarMaquinas($conexion) {
 	$consulta = "SELECT * FROM MAQUINA";
	return $conexion->query($consulta);
}

?>