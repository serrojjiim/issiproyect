<?php	
	session_start();
	
	$infoPag = $_SESSION["paginacion"];
	$PAG_NUM = $infoPag['PAG_NUM'];
	$PAG_TAM = $infoPag['PAG_TAM'];
		
	if (isset($_REQUEST["OID_MAQ"]) or isset($_REQUEST['DNI'])){
				
		if(!isset($_REQUEST['DNI'])){
		$maquina["OID_MAQ"] = $_REQUEST["OID_MAQ"];
		$maquina["NOMBRE"] = $_REQUEST["NOMBRE"];
		$_SESSION["maquina"] = $maquina;
			}
		
		
		
		$condic = false;

			
			for ($i = 0; $i <= $PAG_TAM; $i++) {
				if(isset($_REQUEST['add' . $i])){
					$_SESSION['empleadoMod'] = $_SESSION['EMPLEADOMOD' . $i];
					$condic = true;
			
				}
			}

			
			
		
		if(isset($_REQUEST["borrar"])) Header("Location: ../accions/accion_borrar_maquina.php");
		else if(isset($_REQUEST['editar'])) Header("Location: ../modificar/modificarMaquina.php");
		else if($condic) Header("Location: ../accions/accion_anadir_EmpleadoMaquina.php");
		
	}
	else if(isset($_REQUEST['guardar'])){
		$_SESSION['NOMBREMAQUINA'] =$_REQUEST['NOMBREMAQUINA'];
		
		
		Header("Location: ../accions/accion_editar_maquina.php");
	}
	else Header("Location: ../modificar/modificarMaquina.php");

?>
