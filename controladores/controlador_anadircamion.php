<?php
	session_start();

	if(isset($_REQUEST['MATRICULA'])){
		$ncamion['MATRICULA'] = $_REQUEST['MATRICULA'];

		$_SESSION["ncamion"]  = $ncamion;		
		
		if(isset($_REQUEST['guardar'])) Header("Location: ../accions/accion_nuevo_camion.php");
		else if(isset($_REQUEST['patras'])) Header("Location: ../muestra/muestraCamiones.php");
		else Header("Location: ../modificar/nuevoCamion.php");
	}
?>