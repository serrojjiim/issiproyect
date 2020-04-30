<?php


function lineaspedidoC($conexion,$oid_pedcli) {
	$consulta = "SELECT * FROM LINEAPEDIDOCLIENTE WHERE(OID_PEDCLI='$oid_pedcli')";
		
    return $conexion->query($consulta);
}


function gerenteCompras($conexion){
	$consulta = "SELECT * FROM EMPLEADO WHERE EMPLEADO.CARGO=5";
	
	return $conexion->query($consulta);
}

function modificarPC($conexion,$oid,$fp,$ff,$fe,$fl,$fpa,$ct,$oidcli,$oidemp){
	if($ff==null){
			try{
	$consulta = "UPDATE PEDIDOCLIENTE SET PEDIDOCLIENTE.FECHAPEDIDO='$fp',PEDIDOCLIENTE.FECHAFINFABRICACION=NULL,PEDIDOCLIENTE.FECHAENVIO=NULL,PEDIDOCLIENTE.FECHALLEGADA=NULL,PEDIDOCLIENTE.FECHAPAGO=NULL
	,PEDIDOCLIENTE.COSTETOTAL='$ct',PEDIDOCLIENTE.OID_CLI='$oidcli',PEDIDOCLIENTE.OID_EMP='$oidemp'  WHERE PEDIDOCLIENTE.OID_PEDCLI='$oid'";
	$stmt = $conexion->prepare($consulta);
	$stmt->execute();
	return 1;
		}catch(PDOException $e){
			return $e->getMessage();
		}
	}else if($ff!=null and $fe==null){
				try{
	$consulta = "UPDATE PEDIDOCLIENTE SET PEDIDOCLIENTE.FECHAPEDIDO='$fp',PEDIDOCLIENTE.FECHAFINFABRICACION='$ff',PEDIDOCLIENTE.FECHAENVIO=NULL,PEDIDOCLIENTE.FECHALLEGADA=NULL,PEDIDOCLIENTE.FECHAPAGO=NULL,PEDIDOCLIENTE.COSTETOTAL='$ct',PEDIDOCLIENTE.OID_CLI='$oidcli',PEDIDOCLIENTE.OID_EMP='$oidemp'  WHERE PEDIDOCLIENTE.OID_PEDCLI='$oid'";
	$stmt = $conexion->prepare($consulta);
	$stmt->execute();
	return 1;
		}catch(PDOException $e){
			return $e->getMessage();
		}
	}else if($ff!=null and $fe!=null and $fl==null){
				try{
	$consulta = "UPDATE PEDIDOCLIENTE SET PEDIDOCLIENTE.FECHAPEDIDO='$fp',PEDIDOCLIENTE.FECHAFINFABRICACION='$ff',PEDIDOCLIENTE.FECHAENVIO='$fe',PEDIDOCLIENTE.FECHALLEGADA=NULL,PEDIDOCLIENTE.FECHAPAGO=NULL,PEDIDOCLIENTE.COSTETOTAL='$ct',PEDIDOCLIENTE.OID_CLI='$oidcli',PEDIDOCLIENTE.OID_EMP='$oidemp'  WHERE PEDIDOCLIENTE.OID_PEDCLI='$oid'";
	$stmt = $conexion->prepare($consulta);
	$stmt->execute();
	return 1;
		}catch(PDOException $e){
			return $e->getMessage();
		}
	}else if($ff!=null and $fe!=null and $fl!=null and $fpa==null){
				try{
	$consulta = "UPDATE PEDIDOCLIENTE SET PEDIDOCLIENTE.FECHAPEDIDO='$fp',PEDIDOCLIENTE.FECHAFINFABRICACION='$ff',PEDIDOCLIENTE.FECHAENVIO='$fe',PEDIDOCLIENTE.FECHALLEGADA='$fl',PEDIDOCLIENTE.FECHAPAGO=NULL,PEDIDOCLIENTE.COSTETOTAL='$ct',PEDIDOCLIENTE.OID_CLI='$oidcli',PEDIDOCLIENTE.OID_EMP='$oidemp'  WHERE PEDIDOCLIENTE.OID_PEDCLI='$oid'";
	$stmt = $conexion->prepare($consulta);
	$stmt->execute();
	return 1;
		}catch(PDOException $e){
			return $e->getMessage();
		}
	}else if($ff!=null and $fe!=null and $fl!=null and $fpa!=null){
				try{
	$consulta = "UPDATE PEDIDOCLIENTE SET PEDIDOCLIENTE.FECHAPEDIDO='$fp',PEDIDOCLIENTE.FECHAFINFABRICACION='$ff',PEDIDOCLIENTE.FECHAENVIO='$fe',PEDIDOCLIENTE.FECHALLEGADA='$fl',PEDIDOCLIENTE.FECHAPAGO='$fpa',PEDIDOCLIENTE.COSTETOTAL='$ct',PEDIDOCLIENTE.OID_CLI='$oidcli',PEDIDOCLIENTE.OID_EMP='$oidemp'  WHERE PEDIDOCLIENTE.OID_PEDCLI='$oid'";
	$stmt = $conexion->prepare($consulta);
	$stmt->execute();
	return 1;
		}catch(PDOException $e){
			return $e->getMessage();
		}
	}
}

function quitarPC($conexion,$oid){
		try {
		$stmt=$conexion->prepare('CALL QUITAR_PC(:oid)');
		$stmt->bindParam(':oid',$oid);
		$stmt->execute();
		return 1;
	} catch(PDOException $e) {
		return $e->getMessage();
    }
}

function obtenerultimopedido($conexion){
		try {
		$consulta = "select * from 
 		 (SELECT OID_PEDCLI,COSTETOTAL FROM PEDIDOCLIENTE ORDER BY OID_PEDCLI DESC) 
			where rownum=1";
		$stmt=$conexion->prepare($consulta);
		$stmt->execute();
		return $stmt->fetch();
	} catch(PDOException $e) {
		return $e->getMessage();
    }
}
function crearpedido($conexion,$oid_cli,$oid_emp){
		try {
		$consulta = " INSERT INTO PEDIDOCLIENTE(OID_CLI,OID_EMP) VALUES ($oid_cli, $oid_emp)";
		$stmt=$conexion->prepare($consulta);
		$stmt->execute();
		return 1;
	} catch(PDOException $e) {
		return $e->getMessage();
    }
}

function anadirproducto($conexion,$oid_prod,$oid_pedcli,$cantidad){
		try {
		$consulta = " INSERT INTO LINEAPEDIDOCLIENTE(CANTIDAD,OID_PEDCLI,OID_PROD) VALUES (:cantidad, :oid_pedcli,:oid_prod)";
		$stmt=$conexion->prepare($consulta);
		$stmt->bindParam(':oid_prod',$oid_prod);
		$stmt->bindParam(':oid_pedcli',$oid_pedcli);
		$stmt->bindParam(':cantidad',$cantidad);
		$stmt->execute();
		return 1;
	} catch(PDOException $e) {
		return $e->getMessage();
    }
}

function eliminarlpc($conexion,$oid_linpedcli){
		try {
		$consulta = " DELETE FROM LINEAPEDIDOCLIENTE WHERE OID_LINPEDCLI = $oid_linpedcli";
		$stmt=$conexion->prepare($consulta);
		$stmt->execute();
		return $stmt;
	} catch(PDOException $e) {
		return $e->getMessage();
    }
}

function pedidocliente($conexion,$oid_pedcli) {
	$consulta = "SELECT * FROM PEDIDOCLIENTE WHERE(OID_PEDCLI='$oid_pedcli')";
	$stmt=$conexion->prepare($consulta);	
    $stmt->execute();
	return $stmt->fetch();
}
  ?>