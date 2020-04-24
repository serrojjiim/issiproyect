<?php
function consultarTodosEmpleados($conexion) {
	$consulta = "SELECT * FROM EMPLEADO";
		
    return $conexion->query($consulta);
}

function ocultar($conexion,$oid){
		try{
	$consulta = "UPDATE EMPLEADO SET OCULTO=1, CARGO=null,OID_MAQ=null,DIASVACACIONES=null  WHERE EMPLEADO.OID_EMP='$oid'";
	$stmt = $conexion->prepare($consulta);
	$stmt->execute();
	return "";
		}catch(PDOException $e) {
		return $e->getMessage();
    }
	
}


function obtener_empleado_dni($conexion, $dniemp){
	$consulta = "SELECT * FROM EMPLEADO WHERE (EMPLEADO.DNI = '$dniemp')";
	  $stmt = $conexion->prepare($consulta);
	$stmt->execute();
	return $stmt->fetch();
	
}

function obtener_empleado_oid($conexion, $oidemp){
	$consulta = "SELECT * FROM EMPLEADO WHERE (EMPLEADO.OID_EMP = '$oidemp')";
	  $stmt = $conexion->prepare($consulta);
	$stmt->execute();
	return $stmt->fetch();
}

function quitar_empleado($conexion,$dniemp) {
	try {
		$stmt=$conexion->prepare('CALL QUITAR_EMPLEADO(:dni)');
		$stmt->bindParam(':dni',$dniemp);
		$stmt->execute();
		return "";
	} catch(PDOException $e) {
		return $e->getMessage();
    }
}

function modificar_cargo($conexion,$dniemp,$cargonuevo) {
	try {
		$stmt=$conexion->prepare('CALL ACTUALIZARCARGO(:dni,:cargo)');
		$stmt->bindParam(':dni',$dniemp);
		$stmt->bindParam(':cargo',$cargonuevo);
		$stmt->execute();
		return "";
	} catch(PDOException $e) {
		return $e->getMessage();
    }
}

function modificar_datospersonales($conexion,$oid_emp,$dni_emp,$nombren,$apellidosn,$telefonon,$direccionn,$capitalsocialn,$fechacontratacionn,$diasvacacionesn) {
	try {
		$stmt=$conexion->prepare('CALL ACTUALIZARDATOSPERSONALES(:oidemp,:dni,:nombre,:apellidos,:telefono,:direccion,:capitalsocial,:fechacontratacion,:diasvacaciones)');
		$stmt->bindParam(':oidemp',$oid_emp);
		$stmt->bindParam(':dni',$dni_emp);
		$stmt->bindParam(':nombre',$nombren);
		$stmt->bindParam(':apellidos',$apellidosn);
		$stmt->bindParam(':telefono',$telefonon);
		$stmt->bindParam(':direccion',$direccionn);
		$stmt->bindParam(':capitalsocial',$capitalsocialn);
		$stmt->bindParam(':fechacontratacion',$fechacontratacionn);
		$stmt->bindParam(':diasvacaciones',$diasvacacionesn);		
		$stmt->execute();
		return "";
	} catch(PDOException $e) {
		return $e->getMessage();
    }
}

function modificar_maquina($conexion,$dniemp,$maquinanueva) {
	try {
		$stmt=$conexion->prepare('CALL ACTUALIZARMAQUINA(:dni,:maquina)');
		$stmt->bindParam(':dni',$dniemp);
		$stmt->bindParam(':maquina',$maquinanueva);
		$stmt->execute();
		return "";
	} catch(PDOException $e) {
		return $e->getMessage();
    }
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