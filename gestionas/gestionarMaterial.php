<?php 

function consultarMateriales($conexion) {
 	$consulta = "SELECT * FROM MATERIAL";
	return $conexion->query($consulta);
}

?>