<?php

	session_start();

    require_once("../gestionas/gestionBD.php");
    require_once("../gestionas/gestionarCamion.php");
    require_once("../gestionas/gestionarMaquina.php");
    require_once("../gestionas/gestionarMaterial.php");
    require_once("../gestionas/gestionarNomina.php");
    require_once("../gestionas/gestionarEmpleado.php");
    require_once("../consultaPaginada.php");
	
	// if (isset($_SESSION["libro"])){
		// $libro = $_SESSION["libro"];
		// unset($_SESSION["libro"]);
	// }

	// ¿Venimos simplemente de cambiar página o de haber seleccionado un registro ?
	// ¿Hay una sesión activa?

	if (isset($_SESSION["paginacion"])) $paginacion = $_SESSION["paginacion"];
	$pagina_seleccionada = isset($_GET["PAG_NUM"])? (int)$_GET["PAG_NUM"]: (isset($paginacion)? (int)$paginacion["PAG_NUM"]: 1);

	$pag_tam = isset($_GET["PAG_TAM"])? (int)$_GET["PAG_TAM"]: (isset($paginacion)? (int)$paginacion["PAG_TAM"]: 5);

	if ($pagina_seleccionada < 1) $pagina_seleccionada = 1;
	if ($pag_tam < 1) $pag_tam = 5;

	// Antes de seguir, borramos las variables de sección para no confundirnos más adelante

	unset($_SESSION["paginacion"]);

	$conexion = crearConexionBD();

	// La consulta que ha de paginarse

	$query = "SELECT * FROM EMPLEADO"; //consulta_paginada($conexion, $query, 3, 3);

	
	// Se comprueba que el tamaño de página, página seleccionada y total de registros son conformes.
	// En caso de que no, se asume el tamaño de página propuesto, pero desde la página 1

	$total_registros = total_consulta($conexion,$query);
	$total_paginas = (int) ($total_registros / $pag_tam);

	if ($total_registros % $pag_tam > 0) $total_paginas++;
	if ($pagina_seleccionada > $total_paginas) $pagina_seleccionada = $total_paginas;

	// Generamos los valores de sesión para página e intervalo para volver a ella después de una operación

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
    <!-- <link rel="stylesheet" type="text/css" href="css/biblio.css" /> -->
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

						<a href="muestraEmpleados.php?PAG_NUM=<?php echo $pagina; ?>&PAG_TAM=<?php echo $pag_tam; ?>"><?php echo $pagina; ?></a>

			<?php } ?>

		</div>



		<form method="get" action="muestraEmpleados.php">

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



	 <article class="empleado">

		<form method="post" action="../controladores/controlador_empleados.php">

			<div class="fila_empleado">

				<div class="datos_empleado">
					<input id="OID_EMP" name="OID_EMP"

						type="hidden" value="<?php echo $fila["OID_EMP"]; ?>"/>
					<input id="DNI" name="DNI"

						type="hidden" value="<?php echo $fila["DNI"]; ?>"/>

					<input id="NOMBRE" name="NOMBRE"

						type="hidden" value="<?php echo $fila["NOMBRE"]; ?>"/>

					<input id="APELLIDOS" name="APELLIDOS"

						type="hidden" value="<?php echo $fila["APELLIDOS"]; ?>"/>
					<input id="TELEFONO" name="TELEFONO"

						type="hidden" value="<?php echo $fila["TELEFONO"]; ?>"/>

					<input id="DIRECCION" name="DIRECCION"

						type="hidden" value="<?php echo $fila["DIRECCION"]; ?>"/>

					<input id="CARGO" name="CARGO"

						type="hidden" value="<?php echo $fila["CARGO"]; ?>"/>
					<input id="CAPITALSOCIAL" name="CAPITALSOCIAL"

						type="hidden" value="<?php echo $fila["CAPITALSOCIAL"]; ?>"/>

					<input id="FECHACONTRATACION" name="FECHACONTRATACION"

						type="hidden" value="<?php echo $fila["FECHACONTRATACION"]; ?>"/>

					<input id="DIASVACACIONES" name="DIASVACACIONES"

						type="hidden" value="<?php echo $fila["DIASVACACIONES"]; ?>"/>
					<input id="OID_MAQ" name="OID_MAQ"

						type="hidden" value="<?php echo $fila["OID_MAQ"]; ?>"/>





				<?php

					if (isset($empleado) and ($empleado["DNI"] == $fila["DNI"])) { ?>


						<h3><input id="DNI" name="DNI" type="text" value="<?php echo $fila["DNI"]; ?>"/>	</h3>

						<h4><?php echo $fila["NOMBRE"]." ".$fila["APELLIDOS"]; ?></h4>

				<?php }	else { ?>


						<input id="DNI" name="DNI" type="hidden" value="<?php echo $fila["DNI"]; ?>"/>

						<div class="fila"><b><?php echo $fila["NOMBRE"]." "; echo $fila["APELLIDOS"]; ?></b></div>
						<div class="dni"><b><?php echo $fila["DNI"]; ?></b></div>
					</br>

				<?php } ?>

				</div>



				<div id="botones_fila">

				<?php if (isset($empleado) and ($empleado["OID_EMP"] == $fila["OID_EMP"])) { ?>

						<button id="grabar" name="grabar" type="submit" class="editar_fila">

							<img src="img/bag_menuito.bmp" class="editar_fila" alt="Guardar modificación">

						</button>

				 <?php } else {?>

						 <button id="editar" name="editar" type="submit" class="editar_fila">

							<img src="../img/pencil_menuito.bmp" class="editar_fila" alt="Editar libro">

						</button>
				<?php } ?>

					<button id="borrar" name="borrar" type="submit" class="editar_fila">

						<img src="../img/remove_menuito.bmp" class="editar_fila" alt="Borrar empleado">

					</button> 

				</div>

			</div>

		</form>

	</article>



	<?php } ?>

</main>
</body>
</html>
