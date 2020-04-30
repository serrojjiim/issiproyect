<?php	
	session_start();	
	if( !isset($_SESSION["cargo"]) or !isset($_SESSION["oid_pedcli"]) or $_SESSION['cargo']!="GERENTEVENTAS"){
		echo "</p>No tienes permisos para acceder a esta página</p>";
		
	}else{
	if (isset($_SESSION["oid_pedcli"])) {
		$oid_pedcli = $_SESSION["oid_pedcli"];
		
	require_once("../gestionas/gestionBD.php");
	require_once("../gestionas/gestionarProducto.php");
	require_once("../gestionas/gestionarPC.php");
	$conexion = crearConexionBD();

	$productos = consultarProductos($conexion);
	$tamaño = count($productos);
	$minimo = ceil($tamaño/4);
	cerrarConexionBD($conexion);
?>
<?php } ?>

<!DOCTYPE html>
<html>
<head>
 <link rel="stylesheet" type="text/css" href="../css/header.css" />

 <link rel="stylesheet" type="text/css" href="../css/muestratabla.css" />
 <link rel="stylesheet" type="text/css" href="../css/muestraproductospedido.css" />
 <link rel="stylesheet" type="text/css" href="../css/popupañadirproducto.css" />
</head>
<body style="background-color: #dfdfdf7d">
	<?php
	include_once ("../muestra/header.php");
	?>
<main>
	<div class="titulotabla">
	 	<div><p class="titulo">AÑADE PRODUCTOS A SU PEDIDO</p></div>
	 </div>
	 <div class="productosycarrito">
	<div class="totalmuestraproductos">
		<?php
		for ($x = 0; $x < $tamaño; $x = $x+4) {
			
			if(array_key_exists($x, $productos)){
   			$prod1 = $productos[$x];
			} else{}
			if(array_key_exists($x+1, $productos)){
   			$prod2 = $productos[$x+1];
			} else{}
			if(array_key_exists($x+2, $productos)){
   			$prod3 = $productos[$x+2];
			} else{}
			if(array_key_exists($x+3, $productos)){
   			$prod4 = $productos[$x+3];
			} else{}
			
			
			
			?>
			

		<div class="lineaproducto">
			
			<?php if(array_key_exists($x, $productos)){?><div class="fotoprod">
												<form  method="post" action="../controladores/controlador_anadirproductoPC.php">
												<input id="OID_PROD" name="OID_PROD" type="hidden" value="<?php echo $prod1["OID_PROD"]?>"/>
												<input id="OID_PEDCLI" name="OID_PEDCLI" type="hidden" value="<?php echo $_SESSION["oid_pedcli"]?>"/>
												<button class="botonproducto"  id="elegir" name="elegir" type="button" onclick="window.location='#popup<?php echo $prod1["OID_PROD"]; ?>';">
													<img class="imagenprod" src="<?php echo $prod1["URLFOTO"];?>" />
												</button>
												
												
												<div id="popup<?php echo $prod1["OID_PROD"]; ?>" class="overlay" align="left">
													<div class="popup">
													<a class="close" href="#">&times;</a>
													<div>
													<input id="CANTIDAD" name="CANTIDAD" type="text" placeholder="Introduce la cantidad"/>
													<button id="anadir" name="anadir" type="submit">AÑADIR</button>
													</div>
													</div>
												</div>
												 
   												</form>
												</div>
												<?php } else{} ?>
												
			<?php if(array_key_exists($x+1, $productos)){?><div class="fotoprod">
												<form  method="post" action="../controladores/controlador_anadirproductoPC.php">
												<input id="OID_PROD" name="OID_PROD" type="hidden" value="<?php echo $prod2["OID_PROD"]?>"/>
												<input id="OID_PEDCLI" name="OID_PEDCLI" type="hidden" value="<?php echo $_SESSION["oid_pedcli"]?>"/>
												<button class="botonproducto"  id="elegir" name="elegir" type="button" onclick="window.location='#popup<?php echo $prod2["OID_PROD"]; ?>';">
													<img class="imagenprod" src="<?php echo $prod2["URLFOTO"];?>" />
												</button>
												
												
												<div id="popup<?php echo $prod2["OID_PROD"]; ?>" class="overlay" align="left">
													<div class="popup">
													<a class="close" href="#">&times;</a>
													<div>
													<input id="CANTIDAD" name="CANTIDAD" type="text" placeholder="Introduce la cantidad"/>
													<button id="anadir" name="anadir" type="submit">AÑADIR</button>
													</div>
													</div>
												</div>
												 
   												</form>
												</div> 
												<?php } else{} ?>
			
			<?php if(array_key_exists($x+2, $productos)){?><div class="fotoprod">
													<form  method="post" action="../controladores/controlador_anadirproductoPC.php">
												<input id="OID_PROD" name="OID_PROD" type="hidden" value="<?php echo $prod3["OID_PROD"]?>"/>
												<input id="OID_PEDCLI" name="OID_PEDCLI" type="hidden" value="<?php echo $_SESSION["oid_pedcli"]?>"/>
												<button class="botonproducto"  id="elegir" name="elegir" type="button" onclick="window.location='#popup<?php echo $prod3["OID_PROD"]; ?>';">
													<img class="imagenprod" src="<?php echo $prod3["URLFOTO"];?>" />
												</button>
												
												
												<div id="popup<?php echo $prod3["OID_PROD"]; ?>" class="overlay" align="left">
													<div class="popup">
													<a class="close" href="#">&times;</a>
													<div>
													<input id="CANTIDAD" name="CANTIDAD" type="text" placeholder="Introduce la cantidad"/>
													<button id="anadir" name="anadir" type="submit">AÑADIR</button>
													</div>
													</div>
												</div>
												 
   												</form>
												</div> 
												<?php } else{} ?>
												
			<?php if(array_key_exists($x+3, $productos)){?><div class="fotoprodult">
													<form  method="post" action="../controladores/controlador_anadirproductoPC.php">
												<input id="OID_PROD" name="OID_PROD" type="hidden" value="<?php echo $prod4["OID_PROD"]?>"/>
												<input id="OID_PEDCLI" name="OID_PEDCLI" type="hidden" value="<?php echo $_SESSION["oid_pedcli"]?>"/>
												<button class="botonproducto"  id="elegir" name="elegir" type="button" onclick="window.location='#popup<?php echo $prod4["OID_PROD"]; ?>';">
													<img class="imagenprod" src="<?php echo $prod4["URLFOTO"];?>" />
												</button>
												
												
												<div id="popup<?php echo $prod4["OID_PROD"]; ?>" class="overlay" align="left">
													<div class="popup">
													<a class="close" href="#">&times;</a>
													<div>
													<input id="CANTIDAD" name="CANTIDAD" type="text" placeholder="Introduce la cantidad"/>
													<button id="anadir" name="anadir" type="submit">AÑADIR</button>
													</div>
													</div>
												</div>
												 
   												</form>
												</div> 
												<?php } else{} ?>
					
		
		</div>
		<?php } ?>
	</div>
	
	<div class="totalcompra">
		<div class="filalinea">
			<p align="center">CANTIDAD</p>
		</div>
		<div class="filalinea">
			<p align="center">PRECIO</p>
		</div>
		<div class="filalinea">
			<p align="center">PRODUCTO</p>
		</div>
		<?php $filas = lineaspedidoC($conexion,$_SESSION["oid_pedcli"]); ?>
			<?php 
	foreach ($filas as $fila) { 
		$linea = $fila;
	
	
	?>
		<div>
		<form method="post" action="../accions/accion_eliminarlpc.php">
			<input id="OID_LINPEDCLI" name="OID_LINPEDCLI" type="hidden" value="<?php echo $linea["OID_LINPEDCLI"]?>"/>
		
		<div class="filalinea">
			
		<p align="center"><?php echo $linea["CANTIDAD"];?></p>
		</div>
		<div class="filalinea">
			
			
	
		<p align="center"><?php echo $linea["PRECIO"];?></p>
	
		</div>
		<div class="filalinea">
		<?php $nombrePro = obtenerProducto($conexion,$linea["OID_PROD"]); ?>	
			
		<p align="center"><?php echo $nombrePro["NOMBRE"];?></p>
	
		</div>
		<div class="iconoquitar">
			
			
		<button class="botonproducto"  id="ELIMINARLINEA" name="ELIMINARLINEA" type="submit" ><img src="../img/quitar.png" width="20" height="20"/></button>
	
		</div>
		</form>
		</div>
	<?php } ?>
		<?php 
		$pedidoc=pedidocliente($conexion,$_SESSION["oid_pedcli"]);
		?>
		<div class="filalineatotal">
			<?php if ($pedidoc["COSTETOTAL"]==null) { ?>
				<div style="display: inline-block;font: 15px Arial, sans-serif;margin-left: 15px;margin-top: 5px;">TOTAL PEDIDO 0 €</div>
			<?php }else{ ?>
			<div style="display: inline-block;font: 15px Arial, sans-serif;margin-left: 15px;margin-top: 5px;">TOTAL PEDIDO <?php echo $pedidoc["COSTETOTAL"]; ?> €</div>
			<?php } ?>
			<div style="display:inline-block;float: right;margin-right: 15px;margin-bottom: 5%;"><button class="listo" type="button" onclick="window.location='../muestra/muestraPedidosClientes.php';">LISTO</button></div>
		</div>
	</div>
	</div>
	
</main>
<?php include("../muestra/footer.php");?>
</body>
</html>
<?php } ?>