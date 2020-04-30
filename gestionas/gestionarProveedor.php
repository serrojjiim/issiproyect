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

function consultarProveedoresNoOcultos($conexion){
	$consulta = "SELECT * FROM PROVEEDOR";
	return $conexion->query($consulta);
}
function gerenteCompras($conexion){
	$consulta = "SELECT * FROM EMPLEADO WHERE EMPLEADO.CARGO=6";
	return $conexion->query($consulta);
}

function ocultarP($conexion,$cif){
		try{
	$consulta = "UPDATE PROVEEDOR SET OCULTO=1 WHERE (PROVEEDOR.CIF='$cif')";
	$stmt = $conexion->prepare($consulta);
	$stmt->execute();
	return "";
		}catch(PDOException $e) {
		return $e->getMessage();
    }
}

function activarP($conexion,$cif){
	try{
	$consulta = "UPDATE PROVEEDOR SET OCULTO=0 WHERE (PROVEEDOR.CIF='$cif')";
	$stmt = $conexion->prepare($consulta);
	$stmt->execute();
	return 1;
		}catch(PDOException $e) {
		return 0;
    }
}		

function nuevoProveedor($conexion,$nombre,$cif,$telefono,$direccion,$email){
	try{
	$consulta = "INSERT INTO PROVEEDOR(PROVEEDOR.NOMBRE,PROVEEDOR.CIF,PROVEEDOR.TELEFONO,PROVEEDOR.DIRECCION,PROVEEDOR.EMAIL) VALUES('$nombre','$cif','$telefono','$direccion','$email')";
	$stmt = $conexion->prepare($consulta);
	$stmt->execute();
	return 1;
		}catch(PDOException $e) {
		return 0;
    }		
}

function actualizarDatosProveedor($conexion, $oidprov,$cif,$nombre,$direccion,$telefono,$email){
	try {
		$stmt=$conexion->prepare('CALL ACTUALIZARPROVEEDOR(:oidprov,:cif,:nombre,:direccion,:telefono,:email)');
		$stmt->bindParam(':oidprov',$oidprov);
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
?>