<?php 

function consultarMaquinas($conexion) {
 	$consulta = "SELECT * FROM MAQUINA";
	return $conexion->query($consulta);
}

function getMaquinaOid($conexion,$oid){
	$consulta = "SELECT * FROM CLIENTE WHERE (MAQUINA.OID_MAQ = '$oid')";
	$stmt = $conexion->prepare($consulta);
	$stmt->execute();
	return $stmt->fetch();
}

function borrarMaq($conexion,$oid){
		try{
	$consulta = "DELETE FROM MAQUINA WHERE (MAQUINA.OID_MAQ = '$oid')";
	$stmt = $conexion->prepare($consulta);
	$stmt->execute();
	return "";
		}catch(PDOException $e) {
		return $e->getMessage();
    }
}

?>