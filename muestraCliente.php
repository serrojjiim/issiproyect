<?php

	session_start();

    require_once("gestionas/gestionBD.php");
    require_once("consultaPaginada.php");
	

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
  <link rel="stylesheet" type="text/css" href="css/collapsible.css" />
  <title>Lista de proveedores</title>
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

						<a href="muestraCliente.php?PAG_NUM=<?php echo $pagina; ?>&PAG_TAM=<?php echo $pag_tam; ?>"><?php echo $pagina; ?></a>

			<?php } ?>

		</div>



		<form method="get" action="muestraCliente.php">

			<input id="PAG_NUM" name="PAG_NUM" type="hidden" value="<?php echo $pagina_seleccionada?>"/>

			Mostrando

			<input id="PAG_TAM" name="PAG_TAM" type="number"

				min="1" max="<?php echo $total_registros;?>"

				value="<?php echo $pag_tam?>" autofocus="autofocus" />

			entradas de <?php echo $total_registros?>

			<input type="submit" value="Cambiar">

		</form>

	</nav>



	<?php

		foreach($filas as $fila) {
		
	?>
	


	 <article class="cliente">

		<form method="post" action="controladores/controlador_clientes.php">

			<div class="fila_cliente">

				<div class="datos_cliente">

					<input id="CIF" name="OID_CLI"

						type="hidden" value="<?php echo $fila["OID_CLI"]; ?>"/>

					<input id="NOMBRE" name="CIF"

						type="hidden" value="<?php echo $fila["CIF"]; ?>"/>

					<input id="TELEFONO" name="NOMBRE"

						type="hidden" value="<?php echo $fila["NOMBRE"]; ?>"/>
					
					<input id="TELEFONO" name="DIRECCION"

						type="hidden" value="<?php echo $fila["DIRECCION"]; ?>"/>
					
					<input id="TELEFONO" name="TELEFONO"

						type="hidden" value="<?php echo $fila["TELEFONO"]; ?>"/>
						
					<input id="TELEFONO" name="EMAIL"

						type="hidden" value="<?php echo $fila["EMAIL"]; ?>"/>

				<?php

					if (isset($cliente) and ($cliente["OID_CLI"] == $fila["OID_CLI"])) { ?>


						<h3><input id="CIF" name="CIF" type="text" value="<?php echo $fila["CIF"]; ?>"/>	</h3>

						<h4><?php echo $fila["NOMBRE"]." ".$fila["TELEFONO"]; ?></h4>

				<?php }	else { ?>

	
					<input id="CIF" name="CIF" type="hidden" value="<?php echo $fila["CIF"]; echo "    " ;?>"/>
				
					<button type="button" class="collapsible"><b><?php echo $fila["NOMBRE"]." ";?></b>
			
					
						
					</button>
					<div class="content">
  					<p><b><?php echo $fila["CIF"]." ";?></b></p>
  						<button id="editar" name="editar" type="submit" class="editar_fila">
						<img src="img/pencil_menuito.bmp" class="editar_fila" alt="Editar libro" height="30px" width="30px">
						</button>
						 <button id="borrar" name="borrar" type="submit" class="editar_fila">
			
						<img src="img/remove_menuito.bmp" class="editar_fila" alt="Borrar libro">

					</button> 
					</div>
					
					</br>
					<?php if($fila['hidden']==1){
						echo "asi es";
					} ?>

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

	</article>



	<?php } ?>

</main>
<script type="text/javascript" src="js/collapsible.js"></script>

</body>
</html>
