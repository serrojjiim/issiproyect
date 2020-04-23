<?php

	session_start();

    require_once("gestionas/gestionBD.php");
    require_once("gestionas/gestionarCamion.php");
    require_once("gestionas/gestionarMaquina.php");
    require_once("gestionas/gestionarMaterial.php");
    require_once("gestionas/gestionarNomina.php");
    require_once("gestionas/gestionarProducto.php");
    require_once("consultaPaginada.php");
	
	if (isset($_SESSION["paginacion"])) $paginacion = $_SESSION["paginacion"];
	$pagina_seleccionada = isset($_GET["PAG_NUM"])? (int)$_GET["PAG_NUM"]: (isset($paginacion)? (int)$paginacion["PAG_NUM"]: 1);

	$pag_tam = isset($_GET["PAG_TAM"])? (int)$_GET["PAG_TAM"]: (isset($paginacion)? (int)$paginacion["PAG_TAM"]: 5);

	if ($pagina_seleccionada < 1) $pagina_seleccionada = 1;
	if ($pag_tam < 1) $pag_tam = 5;

	unset($_SESSION["paginacion"]);

	$conexion = crearConexionBD();

	$query = "SELECT * FROM PRODUCTO";

	
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
  <title>Lista de Empleados</title>
</head>

<body>

<?php
	include_once ("header.php");
	?>
<main>

	<div style="overflow-x:auto; overflow-y:auto;">
	 <table style="width:50%" class="producto">
	 	<caption>Listado de los productos disponibles</caption>

		<tr>
    		<th>Tipo de material</th>
    		<th>Precio</th>
    		<th>Longitud</th>
    		<th>Profundidad</th>
    		<th>Altura</th>
    		<th>Acabado</th>
  		</tr>

	<?php
	
		foreach($filas as $fila) {

	?>

		<form method="post" action="controladores/controlador_productos.php">

			<div class="fila_producto">

				<div class="datos_producto">

					<input id="OID_PROD" name="OID_PROD" type="hidden" value="<?php echo $fila["OID_PROD"]; ?>"/>
					<input id="PRECIO" name="PRECIO" type="hidden" value="<?php echo $fila["PRECIO"]; ?>"/>
					<input id="LONGITUD" name="LONGITUD" type="hidden" value="<?php echo $fila["LONGITUD"]; ?>"/>
					<input id="PROFUNDIDAD" name="PROFUNDIDAD" type="hidden" value="<?php echo $fila["PROFUNDIDAD"]; ?>"/>
					<input id="ALTURA" name="ALTURA" type="hidden" value="<?php echo $fila["ALTURA"]; ?>"/>
					<input id="ACABADO" name="ACABADO" type="hidden" value="<?php echo $fila["ACABADO"]; ?>"/>

				<?php

					if (isset($producto) and ($producto["OID_PROD"] == $fila["OID_PROD"])) { ?>
						
						<tr>
							<td align="center"<?php echo $fila['NOMBRE'] ?></td>
    						<td align="center"><?php echo $fila['PRECIO'] ?></td>
    						<td align="center"><?php echo $fila['LONGITUD'] ?></td>
    						<td align="center"><?php echo $fila['PROFUNDIDAD'] ?></td>
    						<td align="center"><?php echo $fila['ALTURA'] ?></td>
    						<td align="center"><?php echo $fila['ACABADO'] ?></td>
						</tr>

				<?php }	else { ?>

						<tr>
							<td align="center"><?php echo $fila['NOMBRE'] ?></td>
    						<td align="center"><?php echo $fila['PRECIO'] ?></td>
    						<td align="center"><?php echo $fila['LONGITUD'] ?></td>
    						<td align="center"><?php echo $fila['PROFUNDIDAD'] ?></td>
    						<td align="center"><?php echo $fila['ALTURA'] ?></td>
    						<td align="center"><?php echo $fila['ACABADO'] ?></td>
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
	
	<form method="get" action="muestraProducto.php">

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
						<a href="muestraProductos.php?PAG_NUM=<?php echo $pagina; ?>&PAG_TAM=<?php echo $pag_tam; ?>"><?php echo $pagina; ?></a>
			<?php } ?>
		</div>
	</nav>
	
</main>
</body>
</html>