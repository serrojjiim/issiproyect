<?php	
	session_start();
	
	if (isset($_REQUEST["DNI"])){
		$empleado["OID_EMP"] = $_REQUEST["OID_EMP"];
		$empleado["DNI"] = $_REQUEST["DNI"];
		$empleado["NOMBRE"] = $_REQUEST["NOMBRE"];
		$empleado["APELLIDOS"] = $_REQUEST["APELLIDOS"];
		$empleado["TELEFONO"] = $_REQUEST["TELEFONO"];
		$empleado["DIRECCION"] = $_REQUEST["DIRECCION"];
		$empleado["CARGO"] = $_REQUEST["CARGO"];
		$empleado["CAPITALSOCIAL"] = $_REQUEST["CAPITALSOCIAL"];
		$empleado["FECHACONTRATACION"] = $_REQUEST["FECHACONTRATACION"];
		$empleado["DIASVACACIONES"] = $_REQUEST["DIASVACACIONES"];
		$empleado["OID_MAQ"] = $_REQUEST["OID_MAQ"];
		
		
		
		$_SESSION["empleado"] = $empleado;
			
		if (isset($_REQUEST["editar"])) Header("Location: ../modificar/modificarEmpleado.php"); 
		else Header("Location: ../accions/accion_borrar_empleado.php"); 
	}
	else 
		Header("Location: ../muestra/muestraempleados.php");

?>
