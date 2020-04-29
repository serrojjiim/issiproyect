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


function lineaspedidoP($conexion,$oid_pedprov) {
	$consulta = "SELECT * FROM LINEAPEDIDOPROVEEDOR WHERE(OID_PEDPROV='$oid_pedprov')";
		
    return $conexion->query($consulta);
}
?>