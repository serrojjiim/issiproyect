<?php

	session_start();

    require_once("../gestionas/gestionBD.php");
    require_once("../consultaPaginada.php");
	
	if (isset($_SESSION["paginacion"])) $paginacion = $_SESSION["paginacion"];
	$pagina_seleccionada = isset($_GET["PAG_NUM"])? (int)$_GET["PAG_NUM"]: (isset($paginacion)? (int)$paginacion["PAG_NUM"]: 1);

	$pag_tam = isset($_GET["PAG_TAM"])? (int)$_GET["PAG_TAM"]: (isset($paginacion)? (int)$paginacion["PAG_TAM"]: 5);

	if ($pagina_seleccionada < 1) $pagina_seleccionada = 1;
	if ($pag_tam < 1) $pag_tam = 5;

	unset($_SESSION["paginacion"]);

	$conexion = crearConexionBD();

	$query = "SELECT * FROM CLIENTE";

	
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
  <script type="text/javascript" src="../js/filtro.js"></script>
  <title>Lista de clientes</title>
</head>

<body>


<?php
	include_once ("header.php");
	?>
<main>

	<div style="overflow-x:auto; overflow-y:auto;">
	 <table  id="tablaClientes">
	 	<caption>Listado de los pedidos de clientes</caption>
	 	<input type="text" id="filtro" onkeyup="filtrar()" placeholder="Filtrar por acabado.." title="Escribe un acabado">

		<tr>
    		<th>CIF</th>
    		<th>Nombre</th>
    		<th>Dirección</th>
    		<th>Teléfono</th>
    		<th>Email</th>
  		</tr>

	<?php
	
		foreach($filas as $fila) {

	?>

		<form method="post" action="../controladores/controlador_clientes.php">

			<div class="fila_cliente">

				<div class="datos_cliente">

					<input id="OID_CLI" name="OID_CLI" type="hidden" value="<?php echo $fila["OID_CLI"]; ?>"/>
					<input id="CIF" name="CIF" type="hidden" value="<?php echo $fila["CIF"]; ?>"/>
					<input id="NOMBRE" name="NOMBRE" type="hidden" value="<?php echo $fila["NOMBRE"]; ?>"/>
					<input id="DIRECCION" name="DIRECCION" type="hidden" value="<?php echo $fila["DIRECCION"]; ?>"/>
					<input id="TELEFONO" name="TELEFONO" type="hidden" value="<?php echo $fila["TELEFONO"]; ?>"/>
					<input id="EMAIL" name="EMAIL" type="hidden" value="<?php echo $fila["EMAIL"]; ?>"/>

				<?php 
				if ($fila["OCULTO"] == 1)  {?>
					
						<tr class="fila">
							<td class="oculto" align="center"><p class="fOculto"><?php echo $fila['CIF'] ?></p></td>
							<td class="oculto" align="center"><p class="fOculto"><?php echo $fila['NOMBRE'] ?></p></td>
							<td class="oculto" align="center"><p class="fOculto"><?php echo $fila['DIRECCION'] ?></p></td>
							<td class="oculto" align="center"><p class="fOculto"><?php echo $fila['TELEFONO'] ?></p></td>
							<td class="oculto" align="center"><p class="fOculto"><?php echo $fila['EMAIL']?></p></td>
							
							<form action="../controladores/controlador_clientes.php">
								
								<td class="boton" class ="boton"><button id="editar" name="editar" type="submit" class="vistacliente">
									<img src="../img/lapizEditar.png" class="editar_fila" alt="Lapiz Editar" height="40" width="40">
								</button></td>
						
								<td class="boton" class ="boton"><button id="borrar" name="borrar" type="submit" class="vistacliente">
									<img src="../img/papeleraBorrar.png" class="borrar_fila" alt="Papelera Borrar" height="40" width="40">
								</button></td>
							</form>
						</tr>
						
				<?php } else { ?>

						<tr class="fila">
							<td align="center"><?php echo $fila['CIF'] ?></td>
							<td align="center"><?php echo $fila['NOMBRE'] ?></td>
							<td align="center"><?php echo $fila['DIRECCION'] ?></td>
							<td align="center"><?php echo $fila['TELEFONO'] ?></td>
							<td align="center"><?php echo $fila['EMAIL']?></td>
							
							<form action="../controladores/controlador_clientes.php">
								
								<td class ="boton"><button id="editar" name="editar" type="submit" class="vistacliente">
									<img src="../img/lapizEditar.png" class="editar_fila" alt="Lapiz Editar" height="40" width="40">
								</button></td>
						
								<td class ="boton"><button id="borrar" name="borrar" type="submit" class="vistacliente">
									<img src="../img/papeleraBorrar.png" class="borrar_fila" alt="Papelera Borrar" height="40" width="40">
								</button></td>
							</form>
						</tr>
						
				<?php } ?>

				</div>
			</div>
		</form>

	<?php } ?>
	
	 </table>
	</div>
	
	</br>
	<form method="get" action="muestraCliente.php">

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
						<a href="muestraCliente.php?PAG_NUM=<?php echo $pagina; ?>&PAG_TAM=<?php echo $pag_tam; ?>"><?php echo $pagina; ?></a>
			<?php } ?>
		</div>
	</nav>

</main>
</body>
</html>