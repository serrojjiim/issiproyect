<?php

function solicitardias($conexion,$dnie,$diasapedir,$motivoo) {
	
	try {
		$stmt=$conexion->prepare('CALL SOLICITARDIAS(:dni,:dias,:motivo)');
		$stmt->bindParam(':dni',$dnie);
		$stmt->bindParam(':dias',$diasapedir);
		$stmt->bindParam(':motivo',$motivoo);
		$stmt->execute();
		return "";
	} catch(PDOException $e) {
		return $e->getMessage();
    }
}

function aceptarpeticiondias($conexion,$oid_peticiondias) {
	
	try {
		$stmt=$conexion->prepare('CALL ACEPTARPETICIONDIAS(:oid_peticiondias)');
		$stmt->bindParam(':oid_peticiondias',$oid_peticiondias);
		
		$stmt->execute();
		return "";
	} catch(PDOException $e) {
		return $e->getMessage();
    }
}
function denegarpeticiondias($conexion,$oid_peticiondias) {
	
	try {
		$stmt=$conexion->prepare('CALL DENEGARPETICIONDIAS(:oid_peticiondias)');
		$stmt->bindParam(':oid_peticiondias',$oid_peticiondias);
		
		$stmt->execute();
		return "";
	} catch(PDOException $e) {
		return $e->getMessage();
    }
}
?>