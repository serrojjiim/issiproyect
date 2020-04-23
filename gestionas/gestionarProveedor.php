<?php 

function consultarProveedor($conexion) {
 	$consulta = "SELECT * FROM PROVEEDOR";
	return $conexion->query($consulta);
}

function obtener_proveedor_oid($conexion, $oidprov){
	$consulta = "SELECT * FROM PROVEEDOR WHERE (PROVEEDOR.OID_PROV = '$oidprov')";
	  $stmt = $conexion->prepare($consulta);
	$stmt->execute();
	return $stmt->fetch();
}

?>