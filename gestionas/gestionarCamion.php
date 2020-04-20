<?php
function consultarCamiones($conexion) {
 	$consulta = "SELECT * FROM CAMION";
	return $conexion->query($consulta);
}
?>