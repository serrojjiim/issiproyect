<?php	
	session_start();	
	if( !isset($_SESSION["cargo"]) or $_SESSION['cargo']!="GERENTEVENTAS"){
		echo "</p>No tienes permisos para acceder a esta página</p>";
		
	}else{
	if (isset($_SESSION["pedcli"])) {
		$pedcli = $_SESSION["pedcli"];

?>
<?php } ?>

<!DOCTYPE html>
<html>
<head>
 <link rel="stylesheet" type="text/css" href="../css/header.css" />
 <link rel="stylesheet" type="text/css" href="../css/modificarForm.css" />
</head>
<body>
	<?php
	include_once ("../muestra/header.php");
	?>
<main>
	
		<?php 
	if (isset($_SESSION["mOkModPedCli"])) {
			unset($_SESSION["mOkModPedCli"]);
			
		echo "<div>
	<div class=\"error\">
		<div class=\"tick\"><img src=\"../img/tick.png\" /></div>
		<div class=\"errortext\" style=\"display: inline-block; align-items: center;\" ><p>¡El pedido cliente ha sido modificado correctamente!</p></div>
	</div>";
		
	}  
	?>
	
		<div class="divMod">
	
	<form method="post" action="../controladores/controlador_pedidosClientes	.php">
	<input class="inMod" id="OID_PEDCLI" name="OID_PEDCLI" type="hidden" value="<?php echo $pedcli["OID_PEDCLI"]; ?>"/><br />
	
	<div class="linea">
	<label class="textoMod">Fecha del pedido</label></br>	
	<input class="largo" id="FECHAPEDIDO" name="FECHAPEDIDO" type="text" value="<?php echo $pedcli["FECHAPEDIDO"]; ?>" required/><br />
	</div>

	
	
	<div class="linea2">
	<div class="dividido">
	<label class="textoMod">Fecha fin fabricacion</label></br>	
	<input class="corto"  id="FECHAFINFABRICACION" name="FECHAFINFABRICACION" type="text" value="<?php echo $pedcli["FECHAFINFABRICACION"]; ?> "/><br />
	</div>
	<div class="dividido">
	<label class="textoMod">Fecha de envío</label></br>	
	<input class="corto" id="FECHAENVIO" name="FECHAENVIO" type="text" value="<?php echo $pedcli["FECHAENVIO"]; ?>"/><br />
	</div>
	</div>	

	<div class="linea2">
	<div class="dividido">
	<label class="textoMod">Fecha de llegada</label></br>	
	<input class="corto"  id="FECHALLEGADA" name="FECHALLEGADA" type="text" value="<?php echo $pedcli["FECHALLEGADA"]; ?> "/><br />
	</div>
	<div class="dividido">
	<label class="textoMod">Fecha de pago</label></br>	
	<input class="corto"  id="FECHAPAGO" name="FECHAPAGO" type="text" value="<?php echo $pedcli["FECHAPAGO"]; ?>"/><br />
	</div>
	</div>	

	
	
	<div class="linea">
	<label class="textoMod">Coste total</label></br>	
	<input class="largo" pattern="[0-9]{2.}" id="COSTETOTAL" name="COSTETOTAL" type="text" value="<?php echo $pedcli["COSTETOTAL"]; ?>" required/><br />
	</div>
	
	<div class="linea">
	<label class="textoMod">Cliente</label></br>	
	<select class="seleccion" id="OID_CLI" name="OID_CLI" required>
		<?php 
		include_once("../gestionas/gestionBD.php");	
		include_once("../gestionas/gestionarPC.php");	
		include_once("../gestionas/gestionarCliente.php");	
		$conexion = crearConexionBD();
		$cs = consultarClientesNoOcultos($conexion);	
		cerrarConexionBD($conexion);	
		?>
		<?php foreach($cs as $c){ ?>
    	<option value="<?php echo $c['OID_CLI']?>" <?php if($c['OID_CLI']==$pedcli['OID_CLI']) echo "selected"; ?>><?php echo $c['NOMBRE']; echo " "; ?></option> 
    	<?php } ?>
    	</select>
  
	</div>
	
	 	<div class="linea">
	<label class="textoMod">Empleado</label></br>	
	<select class="seleccion" id="OID_EMP" name="OID_EMP" required>
		<?php 
		include_once("../gestionas/gestionBD.php");	
		include_once("../gestionas/gestionarPC.php");	
		$conexion = crearConexionBD();
		$cs = gerenteCompras($conexion);
				cerrarConexionBD($conexion);	
				
		?>
		<?php foreach($cs as $c){ ?>
    	<option value=<?php echo $pedcli['OID_EMP']?> <?php if($c['OID_EMP']==$pedcli['OID_EMP']) echo "selected"; ?>><?php echo $c['NOMBRE']; echo " "; echo $c['APELLIDOS'] ?></option> 
    	<?php } ?>
    	</select>
  
	</div>
	

  	<div class="linea2">
		<button title="Guardar" id="guardarMod" name="guardarMod" type="submit" class="botonG">
			<img src="../img/salvar.png" class="imagen" alt="Guardar">
	</button>
	
	<button onclick="window.location.href='../muestra/muestraPedidosClientes.php'" title="Volver a la tabla" id="patras" name="patras" type="button" class="botonG2">
			<img src="../img/atras.png" class="imagen" alt="Volver">
	</button>
	
   	</div>
   	</div>
   	




	</form>

</main>
</body>
</html>
<?php } ?>