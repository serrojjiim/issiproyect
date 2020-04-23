<?php 

function consultarClientes($conexion) {
 	$consulta = "SELECT * FROM CLIENTE";
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

function ocultar($conexion,$cif){
		try{
	$consulta = "UPDATE CLIENTE SET OCULTO=1 WHERE (CLIENTE.CIF='$cif')";
	$stmt = $conexion->prepare($consulta);
	$stmt->execute();
	return "";
		}catch(PDOException $e) {
		return $e->getMessage();
    }
}