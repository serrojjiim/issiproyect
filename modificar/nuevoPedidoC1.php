<?php	
	session_start();	
	if( !isset($_SESSION["cargo"]) or ($_SESSION['cargo']!="PRESIDENTE" and $_SESSION['cargo']!="GERENTEVENTAS")){
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
	<!-- 
		<?php 
	if (isset($_SESSION["mOkModPedCli"])) {
			unset($_SESSION["mOkModPedCli"]);
			
		echo "<div>
	<div class=\"error\">
		<div class=\"tick\"><img src=\"../img/tick.png\" /></div>
		<div class=\"errortext\" style=\"display: inline-block; align-items: center;\" ><p>¡El pedido cliente ha sido modificado correctamente!</p></div>
	</div>";
		
	}  
	?> -->
	
		<div class="divMod">
	
	<form method="post" action="../controladores/controlador_nuevopedidoC1.php">
	<input class="inMod" id="OID_EMP" name="OID_EMP" type="hidden" value="<?php echo $_SESSION["oid_emp"]; ?>"/><br />
	
	<div class="linea">
	<label class="textoMod">Fecha del pedido</label></br>	
	<input class="largo" id="FECHAPEDIDO" name="FECHAPEDIDO" type="text" 
	value="<?php
			$hoy = getdate();
			echo $hoy['mday'];echo"/";echo $hoy['mon'];echo"/";echo $hoy['year'];?>" disabled/><br />
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
    	<option value="<?php echo $c['OID_CLI']?>"><?php echo $c['NOMBRE']; echo " "; ?></option> 
    	<?php } ?>
    	</select>
  
	</div>
	
	<div class="linea">
	<label class="textoMod">Empleado que realiza el pedido</label></br>	
	<input class="largo" id="EMPLEADO" name="EMPLEADO" type="text" 
	value="<?php echo $_SESSION['nombre'];echo " "; echo $_SESSION['apellidos']?>" disabled/><br />
	</div>
	

  	<div class="linea2">
		<button title="Realizar pedido" id="comprar" name="comprar" type="submit" class="botonG">
			<img src="../img/carrito.png" class="imagen" alt="Guardar">
	</button>
	
	<button onclick="window.location.href='../muestra/muestraPedidosClientes.php'" title="Volver" id="patras" name="patras" type="button" class="botonG2">
			<img src="../img/atras.png" class="imagen" alt="Volver">
	</button>
	
   	</div>
   	
	</form>
</div>
</main>
</body>
</html>
<?php } ?>