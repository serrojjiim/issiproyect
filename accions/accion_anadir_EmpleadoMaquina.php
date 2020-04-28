<?php
	session_start();
	include_once('../gestionas/gestionBD.php');
	include_once('../gestionas/gestionarMaquina.php');
	$conexion = crearConexionBD();
	$maquina = $_SESSION['maquina'];
	$empleadoMod = $_SESSION['empleadoMod'];
	$paginacion = $_SESSION['paginacion'];
	

	$error = actualizarEmpleadoMaquina($conexion,$empleadoMod['DNI'],$maquina['OID_MAQ']);

	echo $error;

	 if($error==1){
		 $_SESSION['mOkModMaq'] = "EL EMPLEADO" . $empleadoMod['NOMBRE'] . $empleadoMod['APELLIDOS'] . "SE MA MOVIDO A LA MÁQUINA" . $maquina['OID_MAQ'] ;
	 }else{
		 $_SESSION['mOkModMaq'] = "Error al actualizar :(";
 		
	 }
	Header("Location: ../modificar/modificarMaquina.php?PAG_NUM=" . $paginacion['PAG_NUM'] . "&PAG_TAM=" . $paginacion['PAG_TAM']);
	
?>