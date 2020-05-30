<?php

	session_start();

    require_once("../gestionas/gestionBD.php");
	require_once("../gestionas/gestionarEmpleado.php");
	require_once("../gestionas/gestionarProveedor.php");
	require_once("../gestionas/gestionarPP.php");
	require_once("../gestionas/gestionarMaterial.php");
    require_once("../consultaPaginada.php");
	unset($_SESSION["paginacion"]);
	
	if (isset($_SESSION["paginacion"])) $paginacion = $_SESSION["paginacion"];
	$pagina_seleccionada = isset($_GET["PAG_NUM"])? (int)$_GET["PAG_NUM"]: (isset($paginacion)? (int)$paginacion["PAG_NUM"]: 1);

	$pag_tam = isset($_GET["PAG_TAM"])? (int)$_GET["PAG_TAM"]: (isset($paginacion)? (int)$paginacion["PAG_TAM"]: 5);

	if ($pagina_seleccionada < 1) $pagina_seleccionada = 1;
	if ($pag_tam < 1) $pag_tam = 5;

	unset($_SESSION["paginacion"]);
	

	$conexion = crearConexionBD();

	$query = "SELECT * FROM PEDIDOPROVEEDOR";

	
	$total_registros = total_consulta($conexion,$query);
	$total_paginas = (int) ($total_registros / $pag_tam);

	if ($total_registros % $pag_tam > 0) $total_paginas++;
	if ($pagina_seleccionada > $total_paginas) $pagina_seleccionada = $total_paginas;

	$paginacion["PAG_NUM"] = $pagina_seleccionada;
	$paginacion["PAG_TAM"] = $pag_tam;
	$_SESSION["paginacion"] = $paginacion;
	
	$filas = consulta_paginada($conexion, $query, $pagina_seleccionada, $pag_tam);
	
    cerrarConexionBD($conexion);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link rel="stylesheet" type="text/css" href="../css/muestraTabla.css" />
  <link rel="stylesheet" type="text/css" href="../css/popup.css" />
   <link rel="stylesheet" type="text/css" href="../css/footer.css" />

  <script type="text/javascript" src="../js/filtro.js"></script>
  <title>Lista de proveedores</title>
</head>

<body style="background-color: #dfdfdf7d">


<?php
	include_once ("header.php");
	?>
<main>

	<div class="titulotabla">
	 	<div><p class="titulo">PEDIDOS A PROVEEDORES</p></div>
	 </div>
	<div class="selectpag">
	
	
	<form class="formpag" method="get" action="muestraPedidosProveedores.php">

			<input id="PAG_NUM" name="PAG_NUM" type="hidden" value="<?php echo $pagina_seleccionada?>"/>

			Mostrando

			<input id="PAG_TAM" name="PAG_TAM" type="number"

				min="1" max="<?php echo $total_registros;?>"

				value="<?php echo $pag_tam?>" autofocus="autofocus" />

			entradas de <?php echo $total_registros?>

			<input type="submit" value="Cambiar">

		</form>
		
		</div>
		
		<div class ="tabla">
	 <table id="tablaPedidosProveedores">
		<tr>
    		<th class="primera">Fecha pedido</th>
    		<th>Fecha pago</th>
    		<th>Coste total</th>
    		<th>Proveedor</th>
    		<th class="ultima">Empleado</th>
  		</tr>

	<?php
	
		foreach($filas as $fila) {

	

		$lineas = lineaspedidoP($conexion,$fila["OID_PEDPROV"]);
		 
		 ?>
		<div id="popup<?php echo $fila["OID_PEDPROV"]; ?>" class="overlay" align="left">
	<div class="popup">
		<a class="close" href="#">&times;</a>
				<div>
				<p style="display: inline-block">CANTIDAD</p>
				<p style="display: inline-block;margin-left: 20%">PRECIO</p>
				<p style="display: inline-block;margin-left: 30%">MATERIAL</p></br>
				</div>
		<?php foreach($lineas as $linea) { 
			$nombreMat = obtenerMaterial($conexion,$linea["OID_MAT"]);
			?>
 				<div>
				<p style="display: inline-block;margin-left:3%"><?php echo $linea["CANTIDAD"]; ?> uds</p>
				<p style="display: inline-block;margin-left: 20%"><?php echo $linea["PRECIO"]; ?>€/ud</p>
				<p style="display: inline-block;margin-left: 33%"><?php echo $nombreMat["NOMBRE"];?></p></br>
				</div>
	<?php
	
	 } ?>
		</div>
		
	</div> 
	
</div>
		<form method="post" action="../controladores/controlador_pedidosProveedores.php">

			<div class="fila_pedidoProveedor">

				<div class="datos_pedidoProveedor">

					<input id="OID_PEDPROV" name="OID_PEDPROV" type="hidden" value="<?php echo $fila["OID_PEDPROV"]; ?>"/>
					<input id="FECHAPEDIDO" name="FECHAPEDIDO" type="hidden" value="<?php echo $fila["FECHAPEDIDO"]; ?>"/>
					<input id="FECHAPAGO" name="FECHAPAGO" type="hidden" value="<?php echo $fila["FECHAPAGO"]; ?>"/>
					<input id="COSTETOTAL" name="COSTETOTAL" type="hidden" value="<?php echo $fila["COSTETOTAL"]; ?>"/>
					<input id="OID_PROV" name="OID_PROV" type="hidden" value="<?php echo $fila["OID_PROV"]; ?>"/>
					<input id="OID_EMP" name="OID_EMP" type="hidden" value="<?php echo $fila["OID_EMP"]; ?>"/>

				<?php

				
					$proveedor = obtener_proveedor_oid2($conexion, $fila['OID_PROV']);
					$empleado = obtener_empleado_oid($conexion, $fila['OID_EMP']);?>
					
	
						<tr class="fila">
							<td align="center" onclick="window.location='#popup<?php echo $fila["OID_PEDPROV"]; ?>';"><p><?php echo $fila['FECHAPEDIDO'] ?></p></td>
							<td align="center" onclick="window.location='#popup<?php echo $fila["OID_PEDPROV"]; ?>';"><?php echo $fila['FECHAPAGO'] ?></td>
							<td align="center" onclick="window.location='#popup<?php echo $fila["OID_PEDPROV"]; ?>';"><?php echo $fila['COSTETOTAL']."€" ?></td>
							<td align="center" onclick="window.location='#popup<?php echo $fila["OID_PEDPROV"]; ?>';"><?php echo $proveedor["NOMBRE"]?></td>
							<td align="center" onclick="window.location='#popup<?php echo $fila["OID_PEDPROV"]; ?>';"><?php echo $empleado['NOMBRE']." ".$empleado['APELLIDOS']?></td>
    						<?php if ($_SESSION['cargo']=="GERENTECOMPRAS") { ?>
    						<td class ="boton"><button id="editar" name="editar" type="submit" class="vistacliente">
									<img src="../img/lapizEditar.png" class="editar_fila" alt="Lapiz Editar" height="40" width="40">
								</button></td>
						
							<?php if($fila["FECHAPAGO"]==""){?>
								<td class ="boton"><button id="borrar" name="borrar" type="submit" class="vistacliente">
									<img src="../img/ocultar.png" class="borrar_fila" alt="Papelera Borrar" height="34" width="34">
								</button></td>
								
								<?php 
							}
									} ?>
						</tr>
						
				

				</div>
			</div>
		</form>

	<?php } ?>
	
	 </table>
	</div>
	
	<div class="paginas">
		<nav>
			<div id="enlaces">
			<?php
			
				if($total_paginas <=6){
					 for( $pagina = 1; $pagina <= $total_paginas; $pagina++ )
						if ( $pagina == $pagina_seleccionada) { 	?>
							<span class="current"><?php echo $pagina; ?></span>

			<?php }	else { ?>

						<a href="muestraPedidosProveedores.php?PAG_NUM=<?php echo $pagina; ?>&PAG_TAM=<?php echo $pag_tam; ?>"><?php echo $pagina; ?></a>

			<?php }
			 }
				
				else if($pagina_seleccionada >= $total_paginas-3) {
					 for( $pagina = $pagina_seleccionada-(6-($total_paginas-$pagina_seleccionada)); $pagina <= $total_paginas; $pagina++ )
						if ( $pagina == $pagina_seleccionada) { 	?>

						<span class="current"><?php echo $pagina; ?></span>

			<?php }	else { ?>

						<a href="muestraPedidosProveedores.php?PAG_NUM=<?php echo $pagina; ?>&PAG_TAM=<?php echo $pag_tam; ?>"><?php echo $pagina; ?></a>

			<?php }
			 }
				else if($pagina_seleccionada <= 4) { 
					for( $pagina = 1; $pagina <= $pagina_seleccionada+(7-$pagina_seleccionada); $pagina++ )
					if ( $pagina == $pagina_seleccionada) { 	?>

						<span class="current"><?php echo $pagina; ?></span>

			<?php }	else { ?>

						<a href="muestraPedidosProveedores.php?PAG_NUM=<?php echo $pagina; ?>&PAG_TAM=<?php echo $pag_tam; ?>"><?php echo $pagina; ?></a>

			<?php } 
				}
				else {
					for( $pagina = $pagina_seleccionada-3; $pagina <= $pagina_seleccionada+3; $pagina++ )
				if ( $pagina == $pagina_seleccionada) { 	?>

						<span class="current"><?php echo $pagina; ?></span>

			<?php }	else { ?>

						<a href="muestraPedidosProveedores.php?PAG_NUM=<?php echo $pagina; ?>&PAG_TAM=<?php echo $pag_tam; ?>"><?php echo $pagina; ?></a>

			<?php } 
				} ?>
			

		</div>
		</nav>
		</div>
	
	<?php
	include_once ("footer.php");
	?>
</main>

</body>
</html>