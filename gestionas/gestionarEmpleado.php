<?php
function consultarTodosEmpleados($conexion) {
	$consulta = "SELECT * FROM EMPLEADO";
		
    return $conexion->query($consulta);
}

function getPresidente($conexion){
	$consulta = "SELECT * FROM EMPLEADO WHERE(EMPLEADO.CARGO=1)";
	
	return $conexion->query($consulta);
}

function getVicePresidente($conexion){
	$consulta = "SELECT * FROM EMPLEADO WHERE(EMPLEADO.CARGO=2)";
	
	return $conexion->query($consulta);
}

function getSecretario($conexion){
	$consulta = "SELECT * FROM EMPLEADO WHERE(EMPLEADO.CARGO=3)";
	
	return $conexion->query($consulta);
}


function getTesorero($conexion){
	$consulta = "SELECT * FROM EMPLEADO WHERE(EMPLEADO.CARGO=4)";
	
	return $conexion->query($consulta);
}

function getGerenteVentas($conexion){
	$consulta = "SELECT * FROM EMPLEADO WHERE(EMPLEADO.CARGO=5)";
	
	return $conexion->query($consulta);
}

function getGerenteCompras($conexion){
	$consulta = "SELECT * FROM EMPLEADO WHERE(EMPLEADO.CARGO=6)";
	
	return $conexion->query($consulta);
}

function getCapataz($conexion){
	$consulta = "SELECT * FROM EMPLEADO WHERE(EMPLEADO.CARGO=7)";
	
	return $conexion->query($consulta);
}

function getJefePersonal($conexion){
	$consulta = "SELECT * FROM EMPLEADO WHERE(EMPLEADO.CARGO=8)";
	
	return $conexion->query($consulta);
}

function getJefeMaquina($conexion){
	$consulta = "SELECT * FROM EMPLEADO WHERE(EMPLEADO.CARGO=9)";
	
	return $conexion->query($consulta);
}

function getPeon($conexion){
	$consulta = "SELECT * FROM EMPLEADO WHERE(EMPLEADO.CARGO=10)";
	
	return $conexion->query($consulta);
}

function getCamionero($conexion){
	$consulta = "SELECT * FROM EMPLEADO WHERE(EMPLEADO.CARGO=11)";
	
	return $conexion->query($consulta);
}
 
function consultaBaseDatosDni($conexion,$dni){
	$consulta = "SELECT dni FROM EMPLEADO WHERE(EMPLEADO.DNI='$dni')";
	$stmt = $conexion->prepare($consulta);
	$stmt->execute();
	return $stmt->fetchColumn();
}
function consultaBaseDatosPass($conexion,$dni){
	$consulta = "SELECT pass FROM EMPLEADO WHERE(EMPLEADO.DNI='$dni')";
	$stmt = $conexion->prepare($consulta);
	$stmt->execute();
	return $stmt->fetchColumn();
}
function establecePassBD($conexion,$dni,$pass){
	$consulta = "UPDATE EMPLEADO SET pass = '$pass' WHERE dni='$dni'";
	try{
	$conexion->query($consulta);
	return true;
	}catch(PDOException $e){
		return false;
	}
}
function consultaPassBD($conexion,$pass,$dni){
	$consulta = "SELECT * FROM EMPLEADO WHERE(EMPLEADO.PASS='$pass' and EMPLEADO.DNI='$dni')";
	$stmt = $conexion->prepare($consulta);
	$stmt->execute();
	return $stmt->fetchColumn();
}
 
  ?>