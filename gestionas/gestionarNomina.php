<?php

function consultarNominas($conexion) {
 	$consulta = "SELECT * FROM NOMINA";
	return $conexion->query($consulta);
}

?>
