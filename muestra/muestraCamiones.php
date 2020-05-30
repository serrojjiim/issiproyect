<?php

	session_start();
	
	if(!isset($_SESSION["cargo"]) or ($_SESSION['cargo']!="CAMIONERO" and $_SESSION['cargo']!="PRESIDENTE" and $_SESSION['cargo']!="VICEPRESIDENTE" and $_SESSION['cargo']!="CAPATAZ")){
		echo "</p>No tienes permisos para acceder a esta página</p>";
	} else {

    require_once("../gestionas/gestionBD.php");
    require_once("../consultaPaginada.php");
	unset($_SESSION["paginacion"]);
	
	if (isset($_SESSION["paginacion"])) $paginacion = $_SESSION["paginacion"];
	$pagina_seleccionada = isset($_GET["PAG_NUM"])? (int)$_GET["PAG_NUM"]: (isset($paginacion)? (int)$paginacion["PAG_NUM"]: 1);

	$pag_tam = isset($_GET["PAG_TAM"])? (int)$_GET["PAG_TAM"]: (isset($paginacion)? (int)$paginacion["PAG_TAM"]: 5);

	if ($pagina_seleccionada < 1) $pagina_seleccionada = 1;
	if ($pag_tam < 1) $pag_tam = 5;

	unset($_SESSION["paginacion"]);

	$conexion = crearConexionBD();

	if ($_SESSION["cargo"] == "PRESIDENTE" or $_SESSION["cargo"]=="VICEPRESIDENTE") {
		$query = "SELECT * FROM CAMION";
	} else if ($_SESSION["cargo"] == "CAMIONERO") {
		$query = "SELECT c.oid_cam, c.matricula, r.oid_emp, r.nombre, r.apellidos, r.fechainicio, r.fechafin FROM CAMION C LEFT JOIN (SELECT cc.oid_cam, e.oid_emp, e.nombre, e.apellidos, cc.fechainicio,
				  cc.fechafin FROM COGECAMION CC, EMPLEADO E WHERE cc.oid_emp = e.oid_emp) R ON c.oid_cam = r.oid_cam AND r.fechafin IS NULL";
	}

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
  <link rel="stylesheet" type="text/css" href="../css/popupocultar.css" />

  <script type="text/javascript" src="../js/filtro.js"></script>
  <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
  <title>Lista de camiones</title>
</head>

<body style="background-color:#dfdfdf7d;>


<?php
	include_once ("header.php");
	?>
<main>
	
	<div class="titulotabla">
	 	<div><p class="titulo">CAMIONES</p></div>
	 </div>
	 
	<div class="selectpag">
		<form class ="formpag" style="display: inline-block" method="get" action="muestraCamiones.php">

			<input id="PAG_NUM" name="PAG_NUM" type="hidden" value="<?php echo $pagina_seleccionada?>"/>

			Mostrando

			<input id="PAG_TAM" name="PAG_TAM" type="number"

				min="1" max="<?php echo $total_registros;?>"

				value="<?php echo $pag_tam?>" autofocus="autofocus" />

			entradas de <?php echo $total_registros?>

			<input style="cursor: pointer;" type="submit" value="Cambiar">

		</form>
		<?php if($_SESSION['cargo']=="PRESIDENTE" or $_SESSION['cargo']=="VICEPRESIDENTE") {?>
		<button style="float:right;" onclick="window.location.href='../modificar/nuevoCamion.php'" class="anadir">
		<img src="../img/anadir.png" width="25" height="25" >
		</button>
		<?php } ?>
		</div>
		
		<?php if ($_SESSION["cargo"] == "PRESIDENTE" or $_SESSION["cargo"]=="VICEPRESIDENTE") { ?>
		
	<div class ="tabla">
			
	 <table  id="tablaCamiones">
	 	
		<tr id="cabecera">
    		<th class="primera">Matricula</th>
  		</tr>
  		
	<?php
	
		foreach($filas as $fila) {

	?>

		<form method="post" action="../controladores/controlador_camiones.php">

			<div class="fila_camion">

				<div class="datos_camion">

					<input id="OID_CAM" name="OID_CAM" type="hidden" value="<?php echo $fila["OID_CAM"]; ?>"/>
					<input id="MATRICULA" name="MATRICULA" type="hidden" value="<?php echo $fila["MATRICULA"]; ?>"/>

						<tr class="fila">
							<td align="center"><p><?php echo $fila['MATRICULA'] ?></p></td>
							
							<form action="../controladores/controlador_camiones.php">
								
								<td class ="boton">
									<button id="b" name="b" type="button" class="vistacliente" 
									onclick="window.location='#popup<?php echo $fila["OID_CAM"]; ?>';" >
									<img src="../img/ocultar.png" class="borrar_fila" alt="Papelera Borrar" height="34" width="34">
								</button></td>
								<div id="popup<?php echo $fila["OID_CAM"]; ?>" class="overlay" align="left">
									<div class="popup">
										<a class="close" href="#">X</a>
										<p class="textp" align="center">¿Seguro que quieres eliminar el camion con matrícula: <?php echo $fila['MATRICULA'];?>?</p>
									</br>
										<button id="borrar" name="borrar" type="submit" class="bPop"><img src="../img/ocultar.png" width="30px" height="30px"/></button>
									</div>
								</div>
							</form>
						</tr>
				</div>
			</div>
		</form>

	<?php } ?>
	
	 </table>
	</div>
		
		<?php } else if ($_SESSION["cargo"] == "CAMIONERO") {?>
			
		<div class="popup">
			<span class="popuptext" id="filtroMatricula">
				<input type="text" class="filtro" id="input1" placeholder="Filtrar por matrícula..." title="Escribe una matrícula">
			</span>
		</div>
		<div class="popup">
			<span class="popuptext" id="filtroNombre">
				<input type="text" class="filtro" id="input2" placeholder="Filtrar por nombre..." title="Escribe un nombre">
			</span>
		</div>
		<div class="popup">
			<span class="popuptext" id="filtroApellidos">
				<input type="text" class="filtro" id="input3" placeholder="Filtrar por apellidos..." title="Escribe unos apellidos">
			</span>
		</div>
		<div class="popup">
			<span class="popuptext" id="filtroFechaInicio">
				<input type="text" class="filtro" id="input4" placeholder="Filtrar por fecha de inicio..." title="Escribe una fecha de inicio">
			</span>
		</div>
		<div class="popup">
			<span class="popuptext" id="filtroFechaFin">
				<input type="text" class="filtro" id="input5" placeholder="Filtrar por fecha de fin..." title="Escribe una fecha de fin">
			</span>
		</div>
		
	<div class ="tabla">
	 <table  id="tablaCamiones">
	 	
		<tr id="cabecera">
    		<th class="primera">Matricula <img class="filterIcon" src="../img/filter.png" alt="Filtro" onclick="popupPrimero(0)"></th>
    		<th>Nombre del camionero <img class="filterIcon" src="../img/filter.png" alt="Filtro" onclick="popup(1)"></th>
    		<th>Apellidos del camionero <img class="filterIcon" src="../img/filter.png" alt="Filtro" onclick="popup(2)"></th>
    		<th>Fecha de inicio <img class="filterIcon" src="../img/filter.png" alt="Filtro" onclick="popup(3)"></th>
    		<th class="ultima">Fecha de fin <img class="filterIcon" src="../img/filter.png" alt="Filtro" onclick="popupPrimero(4)"></th>
    		<th class="boton"><button id="borrarFiltros" name="editar" type="submit" class="vistacliente" onclick="limpiarFiltros()">
				<img src="../img/limpiarFiltros.png" class="limpiar_filtro" alt="Limpiar filtros" height="30" width="30">
			</button></th>
  		</tr>
  		
	<?php
	
		foreach($filas as $fila) {

	?>

		<form method="post" action="../controladores/controlador_camiones.php">

			<div class="fila_camion">

				<div class="datos_camion">

					<input id="OID_CAM" name="OID_CAM" type="hidden" value="<?php echo $fila["OID_CAM"]; ?>"/>
					<input id="OID_EMP" name="OID_EMP" type="hidden" value="<?php echo $fila["OID_EMP"]; ?>"/>
					<input id="MATRICULA" name="MATRICULA" type="hidden" value="<?php echo $fila["MATRICULA"]; ?>"/>
					<input id="NOMBRE" name="NOMBRE" type="hidden" value="<?php echo $fila["NOMBRE"]; ?>"/>
					<input id="APELLIDOS" name="APELLIDOS" type="hidden" value="<?php echo $fila["APELLIDOS"]; ?>"/>
					<input id="FECHAINICIO" name="FECHAINICIO" type="hidden" value="<?php echo $fila["FECHAINICIO"]; ?>"/>
					<input id="FECHAFIN" name="FECHAFIN" type="hidden" value="<?php echo $fila["FECHAFIN"]; ?>"/>

						<tr class="fila">
							<td align="center"><p><?php echo $fila['MATRICULA'] ?></p></td>
							<td align="center"><?php echo $fila['NOMBRE'] ?></td>
							<td align="center"><?php echo $fila['APELLIDOS'] ?></td>
							<td align="center"><?php echo $fila['FECHAINICIO'] ?></td>
							<td align="center"><?php echo $fila['FECHAFIN']?></td>
							
							<?php if ($fila['NOMBRE'] == null) {?>
							<form action="../controladores/controlador_camiones.php">
								
								<td class ="boton">
									<button id="b" name="b" type="button" class="vistacliente" 
									onclick="window.location='#popup<?php echo $fila["OID_CAM"]; ?>';" >
									<img src="../img/cogerCamion.png" class="coger_camion" alt="Coger camion" height="34" width="34">
								</button></td>
								<div id="popup<?php echo $fila["OID_CAM"]; ?>" class="overlay" align="left">
									<div class="popup">
										<a class="close" href="#">X</a>
										<p class="textp" align="center">¿Quieres empezar a usar el camion con matrícula: <?php echo $fila['MATRICULA'];?>?</p>
									</br>
										<button id="coger" name="coger" type="submit" class="bPop"><img src="../img/cogerCamion.png" width="30px" height="30px"/></button>
									</div>
								</div>
							</form>
							<?php }?>
							<?php if ($_SESSION['nombre']==$fila['NOMBRE']) {?>
							<form action="../controladores/controlador_camiones.php">
								
								<td class ="boton">
									<button id="b" name="b" type="button" class="vistacliente" 
									onclick="window.location='#popup<?php echo $fila["OID_CAM"]; ?>';" >
									<img src="../img/soltarCamion.png" class="soltar_camion" alt="Soltar 	camion" height="34" width="34">
								</button></td>
								<div id="popup<?php echo $fila["OID_CAM"]; ?>" class="overlay" align="left">
									<div class="popup">
										<a class="close" href="#">X</a>
										<p class="textp" align="center">¿Has finalizado la ruto con el camion cuya matrícula es: <?php echo $fila['MATRICULA'];?>?</p>
									</br>
										<button id="soltar" name="soltar" type="submit" class="bPop"><img src="../img/soltarCamion.png" width="30px" height="30px"/></button>
									</div>
								</div>
							</form>
							<?php }?>
						</tr>
				</div>
			</div>
		</form>

	<?php } ?>
	
	 </table>
	</div>
	
	<?php }?>

	<div class="paginas">
		<nav>
			<div id="enlaces">
			<?php
			
				if($total_paginas <=6){
					 for( $pagina = 1; $pagina <= $total_paginas; $pagina++ )
						if ( $pagina == $pagina_seleccionada) { 	?>
							<span class="current"><?php echo $pagina; ?></span>

			<?php }	else { ?>

						<a href="muestraCamiones.php?PAG_NUM=<?php echo $pagina; ?>&PAG_TAM=<?php echo $pag_tam; ?>"><?php echo $pagina; ?></a>

			<?php }
			 }
				
				else if($pagina_seleccionada >= $total_paginas-3) {
					 for( $pagina = $pagina_seleccionada-(6-($total_paginas-$pagina_seleccionada)); $pagina <= $total_paginas; $pagina++ )
						if ( $pagina == $pagina_seleccionada) { 	?>

						<span class="current"><?php echo $pagina; ?></span>

			<?php }	else { ?>

						<a href="muestraCamiones.php?PAG_NUM=<?php echo $pagina; ?>&PAG_TAM=<?php echo $pag_tam; ?>"><?php echo $pagina; ?></a>

			<?php }
			 }
				else if($pagina_seleccionada <= 4) { 
					for( $pagina = 1; $pagina <= $pagina_seleccionada+(7-$pagina_seleccionada); $pagina++ )
					if ( $pagina == $pagina_seleccionada) { 	?>

						<span class="current"><?php echo $pagina; ?></span>

			<?php }	else { ?>

						<a href="muestraCamiones.php?PAG_NUM=<?php echo $pagina; ?>&PAG_TAM=<?php echo $pag_tam; ?>"><?php echo $pagina; ?></a>

			<?php } 
				}
				else {
					for( $pagina = $pagina_seleccionada-3; $pagina <= $pagina_seleccionada+3; $pagina++ )
				if ( $pagina == $pagina_seleccionada) { 	?>

						<span class="current"><?php echo $pagina; ?></span>

			<?php }	else { ?>

						<a href="muestraCamiones.php?PAG_NUM=<?php echo $pagina; ?>&PAG_TAM=<?php echo $pag_tam; ?>"><?php echo $pagina; ?></a>

			<?php } 
				} ?>
			

		</div>
		</nav>
		</div>
	
</main>
<script>
	var $filas = $('#tablaCamiones tr:gt(0)');
	$('#input1, #input2, #input3, #input4').on('input', function() {
		var val1 = $.trim($('#input1').val()).replace(/ +/g, ' ').toLowerCase();
		var val2 = $.trim($('#input2').val()).replace(/ +/g, ' ').toLowerCase();
		var val3 = $.trim($('#input3').val()).replace(/ +/g, ' ').toLowerCase();
		var val4 = $.trim($('#input4').val()).replace(/ +/g, ' ').toLowerCase();
		var val5 = $.trim($('#input5').val()).replace(/ +/g, ' ').toLowerCase();

		$filas.show().filter(function() {
			var text1 = $(this).find('td:nth-child(1)').text().replace(/\s+/g, ' ').toLowerCase();
			var text2 = $(this).find('td:nth-child(2)').text().replace(/\s+/g, ' ').toLowerCase();
			var text3 = $(this).find('td:nth-child(3)').text().replace(/\s+/g, ' ').toLowerCase();
			var text4 = $(this).find('td:nth-child(4)').text().replace(/\s+/g, ' ').toLowerCase();
			var text5 = $(this).find('td:nth-child(5)').text().replace(/\s+/g, ' ').toLowerCase();
			return !~text1.indexOf(val1) || !~text2.indexOf(val2) || !~text3.indexOf(val3) || !~text4.indexOf(val4) || !~text5.indexOf(val5);
		}).hide();
	});
	
	function limpiarFiltros() {
		$('#input1').val('');
		$('#input2').val('');
		$('#input3').val('');
		$('#input4').val('');
		$('#input5').val('');
		$('#tablaCamiones tr').show();
}
</script>
</body>
</html>
<?php } ?>