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
  <!-- <script type="text/javascript" src="./js/boton.js"></script> -->
  <title>Lista de Empleados</title>
</head>

<body>

<?php
	include_once ("header.php");
	?>
<main>

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



		<form method="get" action="muestraProducto.php">

			<input id="PAG_NUM" name="PAG_NUM" type="hidden" value="<?php echo $pagina_seleccionada?>"/>

			Mostrando

			<input id="PAG_TAM" name="PAG_TAM" type="number"

				min="1" max="<?php echo $total_registros;?>"

				value="<?php echo $pag_tam?>" autofocus="autofocus" />

			entradas de <?php echo $total_registros?>

			<input type="submit" value="Cambiar">

		</form>

	</nav></br>
	
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

					<input id="OID_PROD" name="OID_PROD"

						type="hidden" value="<?php echo $fila["OID_PROD"]; ?>"/>

					<input id="PRECIO" name="PRECIO"

						type="hidden" value="<?php echo $fila["PRECIO"]; ?>"/>

					<input id="LONGITUD" name="LONGITUD"

						type="hidden" value="<?php echo $fila["LONGITUD"]; ?>"/>
					
					<input id="PROFUNDIDAD" name="PROFUNDIDAD"

						type="hidden" value="<?php echo $fila["PROFUNDIDAD"]; ?>"/>
					
					<input id="ALTURA" name="ALTURA"

						type="hidden" value="<?php echo $fila["ALTURA"]; ?>"/>
						
					<input id="ACABADO" name="ACABADO"

						type="hidden" value="<?php echo $fila["ACABADO"]; ?>"/>

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


						<!-- <h3><input id="DNI" name="DNI" type="text" value="<?php echo $fila["DNI"]; ?>"/>	</h3>

						<h4><?php echo $fila["NOMBRE"]." ".$fila["APELLIDOS"]; ?></h4> -->

				<?php }	else { ?>

						<tr>
							<td align="center"><?php echo $fila['NOMBRE'] ?></td>
    						<td align="center"><?php echo $fila['PRECIO'] ?></td>
    						<td align="center"><?php echo $fila['LONGITUD'] ?></td>
    						<td align="center"><?php echo $fila['PROFUNDIDAD'] ?></td>
    						<td align="center"><?php echo $fila['ALTURA'] ?></td>
    						<td align="center"><?php echo $fila['ACABADO'] ?></td>
						</tr>
						
						<!-- <input id="OID_PROD" name="OID_PROD" type="hidden" value="<?php echo $fila["NOMBRE"]; ?>"/>

						<div class="fila"><b><?php echo $fila["NOMBRE"]." "; echo $fila["PRECIO"]; ?></b></div>
						<div class="acabado"><b><?php echo $fila["ACABADO"]; ?></b></div> -->
				<?php } ?>

				</div>


				<!--<div id="botones_fila">

				<?php if (isset($empleado) and ($empleado["OID_EMP"] == $fila["OID_EMP"])) { ?>

						<button id="grabar" name="grabar" type="submit" class="editar_fila">

							<img src="images/bag_menuito.bmp" class="editar_fila" alt="Guardar modificación">

						</button>

				 <?php } else {?>

						 <button id="editar" name="editar" type="submit" class="editar_fila">

							<img src="images/pencil_menuito.bmp" class="editar_fila" alt="Editar libro">

						</button>
				<?php } ?>

					<button id="borrar" name="borrar" type="submit" class="editar_fila">

						<img src="images/remove_menuito.bmp" class="editar_fila" alt="Borrar libro">

					</button> 

				</div> -->

			</div>

		</form>

	



	<?php } ?>
	
		 </table>
	</div>
</main>
</body>
</html>




<!-- <!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title></title>
</head>
<body>
	<table style="width:50%">
  <tr>
    <th>Tipo de material</th>
    <th>Precio</th>
    <th>Longitud</th>
    <th>Profundidad</th>
    <th>Altura</th>
    <th>Acabado</th>
  </tr>
  <tr>
  	
  	<?php 
  	require_once("gestionas/gestionBD.php");
	require_once("gestionas/gestionarProducto.php");
	$conexion=crearConexionBD();	
	$consulta = "SELECT * FROM PRODUCTO";
	
  	$p = consultarProductos($conexion);	
	while($p2 = $p->fetch(PDO::FETCH_ASSOC)){
		?>
    <td align="center"><?php echo $p2['NOMBRE'] ?></td>
    <td align="center"><?php echo $p2['PRECIO'] ?></td>
    <td align="center"><?php echo $p2['LONGITUD'] ?></td>
    <td align="center"><?php echo $p2['PROFUNDIDAD'] ?></td>
    <td align="center"><?php echo $p2['ALTURA'] ?></td>
    <td align="center"><?php echo $p2['ACABADO'] ?></td>
  </tr>
  <?php
	}
	?>
</table>	

	<?php
	cerrarConexionBD($conexion);

?>
</body>
</html> -->