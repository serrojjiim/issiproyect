<?php	
	session_start();
	
	if (isset($_REQUEST["OID_PETICIONDIAS"])){
		$solicitud["OID_PETICIONDIAS"] = $_REQUEST["OID_PETICIONDIAS"];
		$solicitud["OID_EMP"] = $_REQUEST["OID_EMP"];
		$solicitud["DIAS"] = $_REQUEST["DIAS"];
		$solicitud["MOTIVO"] = $_REQUEST["MOTIVO"];
		
		
		
		$_SESSION["solicitud"] = $solicitud;
			
		if (isset($_REQUEST["aceptar"])) Header("Location: ../accions/accion_aceptarsolicitud.php"); 
		elseif (isset($_REQUEST["denegar"])) Header("Location: ../accions/accion_denegarsolicitud.php"); 
	}
	else 
		Header("Location: ../peticiondias.php");

?>
