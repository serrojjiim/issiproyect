<?php 

function consultarMateriales($conexion) {
 	$consulta = "SELECT * FROM MATERIAL";
	return $conexion->query($consulta);
}

function obtenerMaterial($conexion,$oid_mat) {
 	$consulta = "SELECT * FROM MATERIAL WHERE(OID_MAT = '$oid_mat')";
	$stmt = $conexion->prepare($consulta);
	$stmt->execute();
	return $stmt->fetch();
}
?>