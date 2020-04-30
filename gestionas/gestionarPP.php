<?php


function eliminarPP($conexion,$oid_pedprov) {
	try {
		$stmt=$conexion->prepare('CALL QUITAR_PP(:oidpedprov)');
		$stmt->bindParam(':oidpedprov',$oid_pedprov);
		$stmt->execute();
		return "";
	} catch(PDOException $e) {
		return $e->getMessage();
    }
}

function consultarMaterial($conexion){
	$consulta = "SELECT * FROM PEDIDOPROVEEDOR";
		
    return $conexion->query($consulta); 
}

function consultarPP($conexion){
	$consulta = "SELECT * FROM PEDIDOPROVEEDOR";
		
    return $conexion->query($consulta);
}


function modificarPP($conexion,$oid,$fp,$fpa,$ct,$oidprov,$oidemp){
	if($fpa==null){
			try{
	$consulta = "UPDATE PEDIDOPROVEEDOR SET PEDIDOPROVEEDOR.FECHAPEDIDO='$fp',PEDIDOPROVEEDOR.FECHAPAGO=NULL,PEDIDOPROVEEDOR.COSTETOTAL='$ct',PEDIDOPROVEEDOR.OID_PROV='$oidprov',PEDIDOPROVEEDOR.OID_EMP='$oidemp'  WHERE PEDIDOPROVEEDOR.OID_PEDPROV='$oid'";
	$stmt = $conexion->prepare($consulta);
	$stmt->execute();
	return 1;
		}catch(PDOException $e){
			return $e->getMessage();
		}
	}else if($fpa!=null){
			try{
	$consulta = "UPDATE PEDIDOPROVEEDOR SET PEDIDOPROVEEDOR.FECHAPEDIDO='$fp',PEDIDOPROVEEDOR.FECHAPAGO='$fpa',PEDIDOPROVEEDOR.COSTETOTAL='$ct',PEDIDOPROVEEDOR.OID_PROV='$oidprov',PEDIDOPROVEEDOR.OID_EMP='$oidemp'  WHERE PEDIDOPROVEEDOR.OID_PEDPROV='$oid'";
	$stmt = $conexion->prepare($consulta);
	$stmt->execute();
	return 1;
		}catch(PDOException $e){
			return $e->getMessage();
		}
	}
	
}

function getCantidadMaterial($conexion,$oidmat){
	$consulta = "SELECT * FROM MATERIAL WHERE MATERIAL.OID_MAT='$oidmat'";
		
    return $conexion->query($consulta);
}

function lineaspedidoP($conexion,$oid_pedprov) {
	$consulta = "SELECT * FROM LINEAPEDIDOPROVEEDOR WHERE(OID_PEDPROV='$oid_pedprov')";
		
    return $conexion->query($consulta);
}

function actualizarAnadir($conexion,$oid_pedprov) {
	try{
	$consulta = "UPDATE LINEAPEDIDOPROVEEDOR SET LINEAPEDIDOPROVEEDOR.ANADIDO=1 WHERE(OID_PEDPROV='$oid_pedprov')";
	$stmt = $conexion->prepare($consulta);
	$stmt->execute();
	return 1;
		}catch(PDOException $e){
			return $e->getMessage();
		}
}
function insertarMaterial($conexion,$oidmat,$cantidad){
	try{
	$consulta = "UPDATE MATERIAL SET MATERIAL.STOCK='$cantidad' WHERE MATERIAL.OID_MAT='$oidmat'";
	$stmt = $conexion->prepare($consulta);
	$stmt->execute();
	return 1;
		}catch(PDOException $e){
			return $e->getMessage();
		}
}
?>