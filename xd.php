<?php 

	session_start();
	include_once("/gestionas/gestionBD.php");
	include_once("/gestionas/gestionarPC.php");
	include_once("/gestionas/gestionarCliente.php");
	$pedcli = $_SESSION['pedcli'];
	$conexion = crearConexionBD();
	$cs = gerenteCompras($conexion);
	$cs2 = consultarClientes($conexion);
	
	
		print_r($pedcli); echo "</br>";
	
	
	
	
	print_r($pedcli['OID_CLI']); echo "</br>";
	
	foreach($cs2 as $c){
		if($pedcli['OID_CLI']==$c['OID_CLI']){
			echo $c['NOMBRE'];
		}
	}
?>






