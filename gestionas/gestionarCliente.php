<?php 

function consultarClientes($conexion) {
 	$consulta = "SELECT * FROM CLIENTE";
	return $conexion->query($consulta);
}

function consultarClientesNoOcultos($conexion) {
 	$consulta = "SELECT * FROM CLIENTE WHERE CLIENTE.OCULTO=0";
	return $conexion->query($consulta);
}

function actualizarDatosCliente($conexion, $oidcli,$cif,$nombre,$direccion,$telefono,$email){
	try {
		$stmt=$conexion->prepare('CALL ACTUALIZARCLIENTE(:oidcli,:cif,:nombre,:direccion,:telefono,:email)');
		$stmt->bindParam(':oidcli',$oidcli);
		$stmt->bindParam(':cif',$cif);
		$stmt->bindParam(':nombre',$nombre);
		$stmt->bindParam(':direccion',$direccion);
		$stmt->bindParam(':telefono',$telefono);
		$stmt->bindParam(':email',$email);	
		$stmt->execute();
		return "";
	} catch(PDOException $e) {
		return $e->getMessage();
    }
}

function getClienteCif($conexion,$cif){
	$consulta = "SELECT * FROM CLIENTE WHERE (CLIENTE.CIF = '$cif')";
	$stmt = $conexion->prepare($consulta);
	$stmt->execute();
	return $stmt->fetch();
}


function getClienteOid($conexion,$oid){
	$consulta = "SELECT * FROM CLIENTE WHERE (CLIENTE.OID_CLI = '$oid')";
	$stmt = $conexion->prepare($consulta);
	$stmt->execute();
	return $stmt->fetch();
}

function ocultarC($conexion,$cif){
		try{
	$consulta = "UPDATE CLIENTE SET OCULTO=1 WHERE (CLIENTE.CIF='$cif')";
	$stmt = $conexion->prepare($consulta);
	$stmt->execute();
	return "";
		}catch(PDOException $e) {
		return $e->getMessage();
    }
}
function activarC($conexion,$cif){
	try{
	$consulta = "UPDATE CLIENTE SET OCULTO=0 WHERE (CLIENTE.CIF='$cif')";
	$stmt = $conexion->prepare($consulta);
	$stmt->execute();
	return 1;
		}catch(PDOException $e) {
		return 0;
    }
}		

function nuevoCliente($conexion,$nombre,$cif,$telefono,$direccion,$email){
	try{
	$consulta = "INSERT INTO CLIENTE(CLIENTE.NOMBRE,CLIENTE.CIF,CLIENTE.TELEFONO,CLIENTE.DIRECCION,CLIENTE.EMAIL) VALUES('$nombre','$cif','$telefono','$direccion','$email')";
	$stmt = $conexion->prepare($consulta);
	$stmt->execute();
	return 1;
		}catch(PDOException $e) {
		return 0;
    }		
}
?>