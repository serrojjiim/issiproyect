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
	return $stmt->fetch(PDO::FETCH_ASSOC);
}
function getCargoString($cargo){
	if($cargo==1){
		$res = "PRESIDENTE";
	}else if($cargo==2){
		$res = "VICEPRESIDENTE";
	}else if($cargo==3){
		$res = "SECRETARIO";
	}else if($cargo==4){
		$res = "TESORERO";
	}else if($cargo==5){
		$res = "GERENTEVENTAS";
	}else if($cargo==6){
		$res = "GERENTECOMPRAS";
	}else if($cargo==7){
		$res = "CAPATAZ";
	}else if($cargo==8){
		$res = "JEFEPERSONAL";
	}else if($cargo==9){
		$res = "JEFEMAQUINA";
	}else if($cargo==10){
		$res = "PEON";
	}else if($cargo==11){
		$res = "CAMIONERO";
	}else{
		$res="SIN_CARGO";
	}
	return $res;
}
 
  ?>