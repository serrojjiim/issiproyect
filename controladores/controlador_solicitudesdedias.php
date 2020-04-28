<?php	
	session_start();
	
	if (isset($_REQUEST["OID_PETICIONDIAS"])){
		$solicitud["OID_PETICIONDIAS"] = $_REQUEST["OID_PETICIONDIAS"];
	
		
		
		$_SESSION["solicitud"] = $solicitud;
			
		if (isset($_REQUEST["aceptarr"])) Header("Location: ../accions/accion_aceptarsolicitud.php"); 
		elseif (isset($_REQUEST["denegarr"])) Header("Location: ../accions/accion_denegarsolicitud.php"); 
	}
	else 
		Header("Location: ../muestra/peticiondias.php");

?>
