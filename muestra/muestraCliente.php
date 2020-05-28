<?php

	session_start();
	if(!isset($_SESSION["cargo"]) or ($_SESSION['cargo']!="CAMIONERO" and $_SESSION['cargo']!="PRESIDENTE" and $_SESSION['cargo']!="VICEPRESIDENTE" and $_SESSION['cargo']!="GERENTEVENTAS")){
		echo "</p>No tienes permisos para acceder a esta página</p>";
		
	}else{
	
    require_once("../gestionas/gestionBD.php");
    require_once("../consultaPaginada.php");
	unset($_SESSION["paginacion"]);
	unset($_SESSION["mensajeoka"]);
	
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
  <link rel="stylesheet" type="text/css" href="../css/popupocultar.css" />
 <link rel="stylesheet" type="text/css" href="../css/footer.css" />
  <script type="text/javascript" src="../js/filtro.js"></script>
  <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
  <title>Lista de clientes</title>
</head>

<body style="background-color:#dfdfdf7d;overflow:hidden;>


<?php
	include_once ("header.php");
	?>
<main>
	
	<div class="titulotabla">
	 	<div><p class="titulo">CLIENTES</p></div>
	 </div>
	 
	<div class="selectpag">
		<form class ="formpag" style="display: inline-block" method="get" action="muestraCliente.php">

			<input id="PAG_NUM" name="PAG_NUM" type="hidden" value="<?php echo $pagina_seleccionada?>"/>

			Mostrando

			<input id="PAG_TAM" name="PAG_TAM" type="number"

				min="1" max="<?php echo $total_registros;?>"

				value="<?php echo $pag_tam?>" autofocus="autofocus" />

			entradas de <?php echo $total_registros?>

			<input style="cursor: pointer;" type="submit" value="Cambiar">

		</form>
		<?php if($_SESSION['cargo']=="GERENTEVENTAS") {?>
		<button style="float:right;" onclick="window.location.href='../modificar/nuevoCliente.php'" class="anadir">
		<img src="../img/anadir.png" width="25" height="25" >
		</button>
		<?php } ?>
		</div>
		
		<?php if($_SESSION['cargo']!="CAMIONERO") {?>
		<div class="popup">
			<span class="popuptext" id="filtroCIF">
				<input type="text" class="filtro" id="input1" placeholder="Filtrar por CIF..." title="Escribe un CIF">
			</span>
		</div>
		<?php } ?>
		<div class="popup">
			<span class="popuptext" id="filtroNombre">
				<input type="text" class="filtro" id="input2" placeholder="Filtrar por nombre..." title="Escribe un nombre">
			</span>
		</div>
		<div class="popup">
			<span class="popuptext" id="filtroDireccion">
				<input type="text" class="filtro" id="input3" placeholder="Filtrar por direccion..." title="Escribe un direccion">
			</span>
		</div>
		<div class="popup">
			<span class="popuptext" id="filtroTelefono">
				<input type="text" class="filtro" id="input4" placeholder="Filtrar por telefono..." title="Escribe un telefono">
			</span>
		</div>
		<?php if($_SESSION['cargo']!="CAMIONERO") {?>
		<div class="popup">
			<span class="popuptext" id="filtroEmail">
				<input type="text" class="filtro" id="input5" placeholder="Filtrar por email..." title="Escribe un email">
			</span>
		</div>
		<?php } ?>
	
	
	<div class ="tabla">
			
	 <table  id="tablaClientes">
	 	
		<tr id="cabecera">
			<?php if($_SESSION['cargo']=="CAMIONERO"){ ?>
			<th class="primera">Nombre <img class="filterIcon" src="../img/filter.png" alt="Filtro" onclick="popup(0)"></th>
    		<th>Dirección <img class="filterIcon" src="../img/filter.png" alt="Filtro" onclick="popupUltimo(1)"> </th>
    		<th class="ultima">Teléfono  <img class="filterIcon" src="../img/filter.png" alt="Filtro" onclick="popupPrimero(2)"></th>
    		<th class="boton" style="width: 56px;"><button id="borrarFiltros" name="editar" type="submit" class="vistacliente" onclick="limpiarFiltros()">
				<img src="../img/limpiarFiltros.png" class="limpiar_filtro" alt="Limpiar filtros" height="30" width="30">
			</button></th>
			<?php  }else{ ?>
    		<th class="primera">CIF <img class="filterIcon" src="../img/filter.png" alt="Filtro" onclick="popupPrimero(0)"></th>
    		<th>Nombre <img class="filterIcon" src="../img/filter.png" alt="Filtro" onclick="popup(1)"> </th>
    		<th>Dirección <img class="filterIcon" src="../img/filter.png" alt="Filtro" onclick="popup(2)"> </th>
    		<th>Teléfono <img class="filterIcon" src="../img/filter.png" alt="Filtro" onclick="popup(3)"></th>
    		<th class="ultima">Email <img class="filterIcon" src="../img/filter.png" alt="Filtro" onclick="popupUltimo(4)"></th>
    		<th class="boton"><button id="borrarFiltros" name="editar" type="submit" class="vistacliente" onclick="limpiarFiltros()">
			<img src="../img/limpiarFiltros.png" class="limpiar_filtro" alt="Limpiar filtros" height="30" width="30">
			</button></th>
    		<?php } ?>
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
							<?php if($_SESSION['cargo']=="CAMIONERO"){ ?>
							<td class="oculto" align="center"><p class="fOculto"><?php echo $fila['NOMBRE'] ?></p></td>
							<td class="oculto" align="center"><p class="fOculto"><?php echo $fila['DIRECCION'] ?></p></td>
							<td class="oculto" align="center"><p class="fOculto"><?php echo $fila['TELEFONO'] ?></p></td>
							<?php  }else{?>
							<td class="oculto" align="center"><p class="fOculto"><?php echo $fila['CIF'] ?></p></td>
							<td class="oculto" align="center"><p class="fOculto"><?php echo $fila['NOMBRE'] ?></p></td>
							<td class="oculto" align="center"><p class="fOculto"><?php echo $fila['DIRECCION'] ?></p></td>
							<td class="oculto" align="center"><p class="fOculto"><?php echo $fila['TELEFONO'] ?></p></td>
							<td class="oculto" align="center"><p class="fOculto"><?php echo $fila['EMAIL']?></p></td>
							<?php } ?>
							<?php if($_SESSION['cargo']=="GERENTEVENTAS") {?>
							
							<form action="../controladores/controlador_clientes.php">
								
								<td class="boton"><button id="editar" name="editar" type="submit" class="vistacliente">
									<img src="../img/lapizEditar.png" class="editar_fila" alt="Lapiz Editar" height="40" width="40">
								</button></td>
						
								<td class="boton"><button id="activar" name="activar" type="submit" class="vistacliente">
									<img src="../img/activar.png" class="borrar_fila" alt="Papelera Borrar" height="34" width="34">
								</button></td>
								
							</form>
							<?php } ?>
						</tr>
						
				<?php } else { ?>

						<tr class="fila">
							<?php if($_SESSION['cargo']=="CAMIONERO"){ ?>

							<td align="center"><p><?php echo $fila['NOMBRE'] ?></p></td>
							<td align="center"><?php echo $fila['DIRECCION'] ?></td>
							<td align="center"><?php echo $fila['TELEFONO'] ?></td>
							
							<?php }else{ ?>
							<td align="center"><p><?php echo $fila['CIF'] ?></p></td>
							<td align="center"><?php echo $fila['NOMBRE'] ?></td>
							<td align="center"><?php echo $fila['DIRECCION'] ?></td>
							<td align="center"><?php echo $fila['TELEFONO'] ?></td>
							<td align="center"><?php echo $fila['EMAIL']?></td>
							<?php }?>
							
							<?php if($_SESSION['cargo']=="GERENTEVENTAS") {?>

							
							<form action="../controladores/controlador_clientes.php">
								
								<td class ="boton"><button id="editar" name="editar" type="submit" class="vistacliente">
									<img src="../img/lapizEditar.png" class="editar_fila" alt="Lapiz Editar" height="40" width="40">
								</button></td>
						
								<td class ="boton">
									<button id="b" name="b" type="button" class="vistacliente" 
									onclick="window.location='#popup<?php echo $fila["OID_CLI"]; ?>';" >
									<img src="../img/ocultar.png" class="borrar_fila" alt="Papelera Borrar" height="34" width="34">
								</button></td>
								<div id="popup<?php echo $fila["OID_CLI"]; ?>" class="overlay" align="left">
									<div class="popup">
										<a class="close" href="#">X</a>
										<p class="textp" align="center">¿Seguro que quieres dar de baja al cliente <?php echo $fila['NOMBRE'];?>?</p>
									</br>
										<button id="borrar" name="borrar" type="submit" class="bPop"><img src="../img/ocultar.png" width="30px" height="30px"/></button>
									</div>
								</div>
							</form>
							
							<?php } ?>
							
						</tr>
						
				<?php } ?>

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

						<a href="muestraCliente.php?PAG_NUM=<?php echo $pagina; ?>&PAG_TAM=<?php echo $pag_tam; ?>"><?php echo $pagina; ?></a>

			<?php }
			 }
				
				else if($pagina_seleccionada >= $total_paginas-3) {
					 for( $pagina = $pagina_seleccionada-(6-($total_paginas-$pagina_seleccionada)); $pagina <= $total_paginas; $pagina++ )
						if ( $pagina == $pagina_seleccionada) { 	?>

						<span class="current"><?php echo $pagina; ?></span>

			<?php }	else { ?>

						<a href="muestraCliente.php?PAG_NUM=<?php echo $pagina; ?>&PAG_TAM=<?php echo $pag_tam; ?>"><?php echo $pagina; ?></a>

			<?php }
			 }
				else if($pagina_seleccionada <= 4) { 
					for( $pagina = 1; $pagina <= $pagina_seleccionada+(7-$pagina_seleccionada); $pagina++ )
					if ( $pagina == $pagina_seleccionada) { 	?>

						<span class="current"><?php echo $pagina; ?></span>

			<?php }	else { ?>

						<a href="muestraCliente.php?PAG_NUM=<?php echo $pagina; ?>&PAG_TAM=<?php echo $pag_tam; ?>"><?php echo $pagina; ?></a>

			<?php } 
				}
				else {
					for( $pagina = $pagina_seleccionada-3; $pagina <= $pagina_seleccionada+3; $pagina++ )
				if ( $pagina == $pagina_seleccionada) { 	?>

						<span class="current"><?php echo $pagina; ?></span>

			<?php }	else { ?>

						<a href="muestraCliente.php?PAG_NUM=<?php echo $pagina; ?>&PAG_TAM=<?php echo $pag_tam; ?>"><?php echo $pagina; ?></a>

			<?php } 
				} ?>
			

		</div>
		</nav>
		</div>
		<footer>
			<?php
	include_once ("footer.php");
	?>
		</footer>

</main>
<script>
	<?php if($_SESSION['cargo']=="CAMIONERO"){ ?>
var $filas = $('#tablaClientes tr:gt(0)');
	$('#input2, #input3, #input4').on('input', function() {
		var val1 = $.trim($('#input2').val()).replace(/ +/g, ' ').toLowerCase();
		var val2 = $.trim($('#input3').val()).replace(/ +/g, ' ').toLowerCase();
		var val3 = $.trim($('#input4').val()).replace(/ +/g, ' ').toLowerCase();

		$filas.show().filter(function() {
			var text1 = $(this).find('td:nth-child(1)').text().replace(/\s+/g, ' ').toLowerCase();
			var text2 = $(this).find('td:nth-child(2)').text().replace(/\s+/g, ' ').toLowerCase();
			var text3 = $(this).find('td:nth-child(3)').text().replace(/\s+/g, ' ').toLowerCase();
			return !~text1.indexOf(val1) || !~text2.indexOf(val2) || !~text3.indexOf(val3);
		}).hide();
	});
	
	function limpiarFiltros() {
		$('#input2').val('');
		$('#input3').val('');
		$('#input4').val('');
		$('#tablaClientes tr').show();
}
<?php } else { ?>
	var $filas = $('#tablaClientes tr:gt(0)');
	$('#input1, #input2, #input3, #input4, #input5').on('input', function() {
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
		$('#tablaClientes tr').show();
}
<?php } ?>
</script>
</body>
</html>
<?php } ?>