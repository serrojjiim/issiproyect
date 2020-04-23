<?php 

function consultarClientes($conexion) {
 	$consulta = "SELECT * FROM CLIENTE";
	return $conexion->query($consulta);
}

function actualizarDatosCliente($conexion, $oidcli , $cif, $nombre,$direccion,$telefono,$email){
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

?>