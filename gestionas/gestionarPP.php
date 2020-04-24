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
  
 

function lineaspedidoP($conexion,$oid_pedprov) {
	$consulta = "SELECT * FROM LINEAPEDIDOPROVEEDOR WHERE(OID_PEDPROV='$oid_pedprov')";
		
    return $conexion->query($consulta);
}
?>