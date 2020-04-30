<?php	
	session_start();	
	if( !isset($_SESSION["cargo"]) or ($_SESSION['cargo']!="PRESIDENTE" and $_SESSION['cargo']!="VICEPRESIDENTE")){
		echo "</p>No tienes permisos para acceder a esta página</p>";
		
	}else{
	if (isset($_SESSION["pedidoprov"])) {
		$pedprov = $_SESSION["pedidoprov"];

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
	if (isset($_SESSION["mOkModPedProv"])) {
			unset($_SESSION["mOkModPedProv"]);
			
		echo "<div>
	<div class=\"error\">
		<div class=\"tick\"><img src=\"../img/tick.png\" /></div>
		<div class=\"errortext\" style=\"display: inline-block; align-items: center;\" ><p>¡El pedido proveedor ha sido modificado correctamente!</p></div>
	</div>";
		
	}  
	?>
	
		<div class="divMod">
	
	<form method="post" action="../controladores/controlador_pedidosProveedores.php">
	<input class="inMod" id="OID_PEDPROV" name="OID_PEDPROV" type="hidden" value="<?php echo $pedprov["OID_PEDPROV"]; ?>"/><br />
	
	<div class="linea2">
	<div class="dividido">
	<label class="textoMod">Fecha del pedido</label></br>	
	<input class="corto"  id="FECHAPEDIDO" name="FECHAPEDIDO" type="text" value="<?php echo $pedprov["FECHAPEDIDO"]; ?> "/><br />
	</div>
	<div class="dividido">
	<label class="textoMod">Fecha de pago</label></br>	
	<input class="corto"  id="FECHAPAGO" name="FECHAPAGO" type="text" value="<?php echo $pedprov["FECHAPAGO"]; ?>"/><br />
	</div>
	</div>	

	
	
	<div class="linea">
	<label class="textoMod">Coste total</label></br>	
	<input class="largo" pattern="[0-9]{2.}" id="COSTETOTAL" name="COSTETOTAL" type="text" value="<?php echo $pedprov["COSTETOTAL"]; ?>" required/><br />
	</div>
	
	<div class="linea">
	<label class="textoMod">Proveedor</label></br>	
	<select class="seleccion" id="OID_PROV" name="OID_PROV" required>
		<?php 
		include_once("../gestionas/gestionBD.php");	
		include_once("../gestionas/gestionarProveedor.php");	
		$conexion = crearConexionBD();
		$cs = consultarProveedoresNoOcultos($conexion);	
		cerrarConexionBD($conexion);	
		?>
		<?php foreach($cs as $c){ ?>
    	<option value="<?php echo $pedprov['OID_PROV']?>" <?php if($c['OID_PROV']==$pedprov['OID_PROV']) echo "selected"; ?>><?php echo $c['NOMBRE']; echo " "; ?></option> 
    	<?php } ?>
    	</select>
  
	</div>
	
	 	<div class="linea">
	<label class="textoMod">Empleado</label></br>	
	<select class="seleccion" id="OID_EMP" name="OID_EMP" required>
		<?php 
		include_once("../gestionas/gestionBD.php");	
		include_once("../gestionas/gestionarProveedor.php");	
		$conexion = crearConexionBD();
		$cs = gerenteVentas($conexion);
				cerrarConexionBD($conexion);	
				
		?>
		<?php foreach($cs as $c){ ?>
    	<option value=<?php echo $pedprov['OID_EMP']?> <?php if($c['OID_EMP']==$pedprov['OID_EMP']) echo "selected"; ?>><?php echo $c['NOMBRE']; echo " "; echo $c['APELLIDOS'] ?></option> 
    	<?php } ?>
    	</select>
  
	</div>
	

  	<div class="linea2">
		<button title="Guardar" id="guardarMod" name="guardarMod" type="submit" class="botonG">
			<img src="../img/salvar.png" class="imagen" alt="Guardar">
	</button>
	
	<button onclick="window.location.href='../muestra/muestraPedidosProveedores.php'" title="Volver a la tabla" id="patras" name="patras" type="button" class="botonG2">
			<img src="../img/atras.png" class="imagen" alt="Volver">
	</button>
	
   	</div>
   	</div>
   	




	</form>

</main>
</body>
</html>
<?php } ?>