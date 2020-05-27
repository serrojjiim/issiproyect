
<?php	
	session_start();
	
	$infoPag = $_SESSION["paginacion"];
	$PAG_NUM = $infoPag['PAG_NUM'];
	$PAG_TAM = $infoPag['PAG_TAM'];
		
	if (isset($_REQUEST["DNI"])){
		$nempleado["DNI"] = $_REQUEST["DNI"];
		$nempleado["NOMBRE"] = $_REQUEST["NOMBRE"];
		$nempleado["APELLIDOS"] = $_REQUEST["APELLIDOS"];
		$nempleado["TELEFONO"] = $_REQUEST["TELEFONO"];
		$nempleado["DIRECCION"] = $_REQUEST["DIRECCION"];
		$nempleado["CARGO"] = $_REQUEST["CARGO"];
		$nempleado["CAPITALSOCIAL"] = $_REQUEST["CAPITALSOCIAL"];
		$nempleado["FECHACONTRATACION"] = $_REQUEST["FECHACONTRATACION"];
		$nempleado["DIASVACACIONES"] = $_REQUEST["DIASVACACIONES"];
		$nempleado["OID_MAQ"] = $_REQUEST["OID_MAQ"];
		
		
		
		$_SESSION["nempleado"] = $nempleado;
			
		if (isset($_REQUEST["guardar"])) Header("Location: ../validaciones/validacion_alta_empleado.php"); 
		else if(isset($_REQUEST['patras'])) Header("Location: ../muestra/muestraEmpleados.php?PAG_NUM=".$PAG_NUM."&PAG_TAM=".$PAG_TAM);
	}
	else 
		Header("Location: ../muestra/modificarEmpleado.php");

?>
