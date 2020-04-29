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

  <script type="text/javascript" src="../js/filtro.js"></script>
  <title>Lista de clientes</title>
</head>

<body style="background-color:#dfdfdf7d;>


<?php
	include_once ("header.php");
	?>
<main>

	<div class="titulotabla">
	 	<div><p class="titulo">Listado de los clientes</p></div>
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
									<?php if($_SESSION['cargo']=="GERENTEVENTAS") { ?>

		<button style="float:right;" onclick="window.location.href='../modificar/nuevoCliente.php'" class="anadir">
		<img src="../img/anadir.png" width="25" height="25" >
		</button>
		<?php } ?>
		</div>
		
		<div class ="tabla">
	 <table  id="tablaClientes">
	 	
		<tr>
			<?php if($_SESSION['cargo']=="GERENTEVENTAS" or $_SESSION['cargo']=="PRESIDENTE" or $_SESSION['cargo']=="VICEPRESIDENTE") { ?>
    		<th class="primera">CIF</th>
    		<th>Nombre</th>
    		<th>Dirección</th>
    		<th>Teléfono</th>
    		<th class="ultima">Email</th>
    		<?php }else if($_SESSION['cargo']=="CAMIONERO"){?>
    		<th>Nombre</th>
    		<th>Dirección</th>
    		<th>Teléfono</th>
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
							<?php if($_SESSION['cargo']=="GERENTEVENTAS" or $_SESSION['cargo']=="PRESIDENTE" or $_SESSION['cargo']=="VICEPRESIDENTE") { ?>
							<td class="oculto" align="center"><p class="fOculto"><?php echo $fila['CIF'] ?></p></td>
							<td class="oculto" align="center"><p class="fOculto"><?php echo $fila['NOMBRE'] ?></p></td>
							<td class="oculto" align="center"><p class="fOculto"><?php echo $fila['DIRECCION'] ?></p></td>
							<td class="oculto" align="center"><p class="fOculto"><?php echo $fila['TELEFONO'] ?></p></td>
							<td class="oculto" align="center"><p class="fOculto"><?php echo $fila['EMAIL']?></p></td>
							<?php }else if($_SESSION['cargo']=="CAMIONERO"){?>
							<td class="oculto" align="center"><p class="fOculto"><?php echo $fila['NOMBRE'] ?></p></td>
							<td class="oculto" align="center"><p class="fOculto"><?php echo $fila['DIRECCION'] ?></p></td>
							<td class="oculto" align="center"><p class="fOculto"><?php echo $fila['TELEFONO'] ?></p></td>
							<?php } ?>
							<?php if($_SESSION['cargo']=="PRESIDENTE") { ?>
							<form action="../controladores/controlador_clientes.php">
								
								<td class="boton" class ="boton"><button id="editar" name="editar" type="submit" class="vistacliente">
									<img src="../img/lapizEditar.png" class="editar_fila" alt="Lapiz Editar" height="40" width="40">
								</button></td>
						
								<td class="boton" class ="boton"><button id="activar" name="activar" type="submit" class="vistacliente">
									<img src="../img/activar.png" class="borrar_fila" alt="Papelera Borrar" height="34" width="34">
								</button></td>
							</form>
							<?php } ?>
						</tr>
						
				<?php } else { ?>

						<tr class="fila">
							<?php if($_SESSION['cargo']=="GERENTEVENTAS" or $_SESSION['cargo']=="PRESIDENTE"  or $_SESSION['cargo']=="VICEPRESIDENTE") { ?>

							<td align="center"><p><?php echo $fila['CIF'] ?></p></td>
							<td align="center"><?php echo $fila['NOMBRE'] ?></td>
							<td align="center"><?php echo $fila['DIRECCION'] ?></td>
							<td align="center"><?php echo $fila['TELEFONO'] ?></td>
							<td align="center"><?php echo $fila['EMAIL']?></td>
							<?php } else if($_SESSION['cargo']=="CAMIONERO"){?>
							<td align="center"><p><?php echo $fila['NOMBRE'] ?></p></td>
							<td align="center"><?php echo $fila['DIRECCION'] ?></td>
							<td align="center"><?php echo $fila['TELEFONO'] ?></td>
								
								<?php } ?>

														<?php if($_SESSION['cargo']=="GERENTEVENTAS") { ?>

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
										<p class="textp" align="center">¿Seguro que quieres dar de baja a <?php echo $fila['NOMBRE'];?>?</p>
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

</main>
</body>
</html>
<?php } ?>