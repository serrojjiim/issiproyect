<?php

	session_start();

    require_once("gestionas/gestionBD.php");
	require_once("gestionas/gestionarEmpleado.php");
	require_once("gestionas/gestionarCliente.php");
    require_once("consultaPaginada.php");
	
	if (isset($_SESSION["paginacion"])) $paginacion = $_SESSION["paginacion"];
	$pagina_seleccionada = isset($_GET["PAG_NUM"])? (int)$_GET["PAG_NUM"]: (isset($paginacion)? (int)$paginacion["PAG_NUM"]: 1);

	$pag_tam = isset($_GET["PAG_TAM"])? (int)$_GET["PAG_TAM"]: (isset($paginacion)? (int)$paginacion["PAG_TAM"]: 5);

	if ($pagina_seleccionada < 1) $pagina_seleccionada = 1;
	if ($pag_tam < 1) $pag_tam = 5;

	unset($_SESSION["paginacion"]);

	$conexion = crearConexionBD();

	$query = "SELECT * FROM PEDIDOCLIENTE";

	
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
  <link rel="stylesheet" type="text/css" href="css/muestraTabla.css" />
  <script type="text/javascript" src="js/filtro.js"></script>
  <title>Lista de pedidos de clientes</title>
</head>

<body>


<?php
	include_once ("header.php");
	?>
<main>

	<div style="overflow-x:auto; overflow-y:auto;">
	 <table style="width:50%" id="tablaPedidosClientes">
	 	<caption>Listado de los pedidos de clientes</caption>
	 	<input type="text" id="filtro" onkeyup="filtrar()" placeholder="Filtrar por acabado.." title="Escribe un acabado">

		<tr>
    		<th>Fecha del pedido</th>
    		<th>Fin de fabricación</th>
    		<th>Fecha de envío</th>
    		<th>Fecha de llegada</th>
    		<th>Fecha de pago</th>
    		<th>Coste total</th>
    		<th>Cliente</th>
    		<th>Empleado</th>
  		</tr>

	<?php
	
		foreach($filas as $fila) {

	?>

		<form method="post" action="controladores/controlador_pedidosClientes.php">

			<div class="fila_pedidosClientes">

				<div class="datos_pedidosClientes">

					<input id="OID_PEDCLI" name="OID_PEDCLI" type="hidden" value="<?php echo $fila["OID_PEDCLI"]; ?>"/>
					<input id="FECHAPEDIDO" name="FECHAPEDIDO" type="hidden" value="<?php echo $fila["FECHAPEDIDO"]; ?>"/>
					<input id="FECHAFINFABRICACION" name="FECHAFINFABRICACION" type="hidden" value="<?php echo $fila["FECHAFINFABRICACION"]; ?>"/>
					<input id="FECHAENVIO" name="FECHAENVIO" type="hidden" value="<?php echo $fila["FECHAENVIO"]; ?>"/>
					<input id="FECHALLEGADA" name="FECHALLEGADA" type="hidden" value="<?php echo $fila["FECHALLEGADA"]; ?>"/>
					<input id="FECHAPAGO" name="FECHAPAGO" type="hidden" value="<?php echo $fila["FECHAPAGO"]; ?>"/>
					<input id="COSTETOTAL" name="COSTETOTAL" type="hidden" value="<?php echo $fila["COSTETOTAL"]; ?>"/>
					<input id="OID_CLI" name="OID_CLI" type="hidden" value="<?php echo $fila["OID_CLI"]; ?>"/>
					<input id="OID_EMP" name="OID_EMP" type="hidden" value="<?php echo $fila["OID_EMP"]; ?>"/>

				<?php

					if (isset($pedcli) and ($pedcli["OID_PEDCLI"] == $fila["OID_PEDCLI"])) { ?>
						
						<tr>
							<td align="center"<?php echo $fila['FECHAPEDIDO'] ?></td>
						</tr>

				<?php }	else {
											
					$cliente= getClienteOid($conexion, $fila['OID_CLI']);
					$empleado = obtener_empleado_oid($conexion, $fila['OID_EMP']);?>

						<tr>
							<td align="center"><?php echo $fila['FECHAPEDIDO'] ?></td>
							<td align="center"><?php echo $fila['FECHAFINFABRICACION'] ?></td>
							<td align="center"><?php echo $fila['FECHAENVIO'] ?></td>
							<td align="center"><?php echo $fila['FECHALLEGADA'] ?></td>
							<td align="center"><?php echo $fila['FECHAPAGO'] ?></td>
							<td align="center"><?php echo $fila['COSTETOTAL']."€"?></td>
							<td align="center"><?php echo $cliente['NOMBRE']?></td>
							<td align="center"><?php echo $empleado['NOMBRE']." ".$empleado['APELLIDOS']?></td>
    						<td><a href="#"><img src="img/lapizEditar.png" alt="Lapiz Editar" height="40" width="40"></a></td>
							<td><a href="#"><img src="img/papeleraBorrar.png" alt="Papelera Borrar" height="40" width="40"></a></td>
						</tr>
						
				<?php } ?>

				</div>
			</div>
		</form>

	<?php } ?>
	
	 </table>
	</div>
	
	</br>
	<form method="get" action="muestraPedidosClientes.php">

			<input id="PAG_NUM" name="PAG_NUM" type="hidden" value="<?php echo $pagina_seleccionada?>"/>

			Mostrando

			<input id="PAG_TAM" name="PAG_TAM" type="number"

				min="1" max="<?php echo $total_registros;?>"

				value="<?php echo $pag_tam?>" autofocus="autofocus" />

			entradas de <?php echo $total_registros?>

			<input type="submit" value="Cambiar">
	</form>
	
	<nav>
		<div id="enlaces">
			<?php
				for( $pagina = 1; $pagina <= $total_paginas; $pagina++ )

					if ( $pagina == $pagina_seleccionada) { 	?>
						<span class="current"><?php echo $pagina; ?></span>
			<?php }	else { ?>
						<a href="muestraPedidosClientes.php?PAG_NUM=<?php echo $pagina; ?>&PAG_TAM=<?php echo $pag_tam; ?>"><?php echo $pagina; ?></a>
			<?php } ?>
		</div>
	</nav>
	
</main>
</body>
</html>