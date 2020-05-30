<?php
function consultarCamiones($conexion) {
 	$consulta = "SELECT * FROM CAMION";
	return $conexion->query($consulta);
}

function nuevoCamion($conexion,$matricula){
	try{
	$consulta = "INSERT INTO CAMION(CAMION.MATRICULA) VALUES('$matricula')";
	$stmt = $conexion->prepare($consulta);
	$stmt->execute();
	return 1;
		}catch(PDOException $e) {
		return 0;
    }		
}

function borrarCamion($conexion,$matricula){
		try{
	$consulta = "DELETE FROM CAMION WHERE (CAMION.MATRICULA = '$matricula')";
	$stmt = $conexion->prepare($consulta);
	$stmt->execute();
	return 1;
		}catch(PDOException $e) {
		return $e->getMessage();
    }
}

function cogerCamion($conexion,$oid_cam,$oid_emp){
	try{
	$consulta = "INSERT INTO COGECAMION (OID_CAM, OID_EMP) VALUES('$oid_cam','$oid_emp')";
	$stmt = $conexion->prepare($consulta);
	$stmt->execute();
	return 1;
		}catch(PDOException $e) {
		return 0;
    }		
}

function soltarCamion($conexion,$oid_cam){
	try {
		$consulta = "DELETE FROM COGECAMION WHERE COGECAMION.OID_CAM='$oid_cam'";
		$stmt = $conexion->prepare($consulta);
		$stmt->execute();
		return "";
	} catch(PDOException $e) {
		return $e->getMessage();
    }
}
?>