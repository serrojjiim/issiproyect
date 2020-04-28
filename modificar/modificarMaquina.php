<?php

	session_start();

    require_once("../gestionas/gestionBD.php");
    require_once("../gestionas/gestionarMaquina.php");
    require_once("../consultaPaginada.php");
	unset($_SESSION["paginacion"]);
	$maquina = $_SESSION['maquina'];
	$oid=$maquina['OID_MAQ'];
	if (isset($_SESSION["paginacion"])) $paginacion = $_SESSION["paginacion"];
	$pagina_seleccionada = isset($_GET["PAG_NUM"])? (int)$_GET["PAG_NUM"]: (isset($paginacion)? (int)$paginacion["PAG_NUM"]: 1);

	$pag_tam = isset($_GET["PAG_TAM"])? (int)$_GET["PAG_TAM"]: (isset($paginacion)? (int)$paginacion["PAG_TAM"]: 5);

	if ($pagina_seleccionada < 1) $pagina_seleccionada = 1;
	if ($pag_tam < 1) $pag_tam = 5;

	unset($_SESSION["paginacion"]);

	$conexion = crearConexionBD();

	$query = "SELECT dni,nombre,apellidos,cargo FROM EMPLEADO WHERE EMPLEADO.OID_MAQ<>'$oid'";

	
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
  <link rel="stylesheet" type="text/css" href="../css/muestraMaquinas.css" />
   <link rel="stylesheet" type="text/css" href="../css/popup3.css" />
  <script type="text/javascript" src="../js/filtro.js"></script>
  <title>Lista de máquinas</title>
</head>

<body>


<main>

	<div class="titulotabla">
		<?php 
	    if($oid==1) $maq = "Pintura";
		else if($oid==2) $maq = "Fresadora";
		else if($oid==3) $maq = "Serigrafiadora";
		else if($oid==4) $maq = "Caldera";
		else if($oid==5) $maq = "Robot";
		else if($oid==6) $maq = "Bajeras";
		else if($oid==7) $maq = "Robot2";
		else if($oid==8) $maq = "Pintura2";
		else if($oid==9) $maq = "Almacen1";
		else if($oid==10) $maq = "Almacen2";
		
		
		
		?>
		
	 	<div><h2 class="titulo">Selecciona empleados para añadirlos a la máquina <?php echo $maq ?></h2></div>
	 </div>
	<div style="display:inline-block" class="selectpag">
	
	
	<form method="get" action="modificarMaquina.php">

			<input id="PAG_NUM" name="PAG_NUM" type="hidden" value="<?php echo $pagina_seleccionada?>"/>

			Mostrando

			<input id="PAG_TAM" name="PAG_TAM" type="number"

				min="1" max="<?php echo $total_registros;?>"

				value="<?php echo $pag_tam;
				$_SESSION['pag_tam']=$pag_tam; ?>" autofocus="autofocus" />

			entradas de <?php echo $total_registros?>

			<input type="submit" value="Cambiar">

		</form>
		
		</div>
			<a style="margin-left:25%" href="../muestra/muestraMaquinas.php"><img src="../img/back.png" width="50px" alt="Volver" height="30px" style="position: absolute"/></a>

		<div class ="tabla">
	 <table class="tabla" id="tablaMaquina">
	 	
		<tr>
    		<th>Nombre</th>
    		<th>Apellidos</th>
    		<th>Cargo</th>
  		</tr>

	<?php
		$contador = 0;
		foreach($filas as $fila) {

	?>

		<form method="post" action="../controladores/controlador_maquinas.php">

			<div class="fila_maquina">

				<div class="datos_maquina">
						
					<input id="DNI" name="DNI" type="hidden" value="<?php echo $fila["DNI"]; ?>"/>
					<input id="NOMBRE" name="NOMBRE" type="hidden" value="<?php echo $fila["NOMBRE"]; ?>"/>
					<input id="APELLIDOS" name="APELLIDOS" type="hidden" value="<?php echo $fila["APELLIDOS"]; ?>"/>
					<input id="CARGO" name="CARGO" type="hidden" value="<?php echo $fila["CARGO"]; ?>"/>

						<tr class="fila">
							<td class="nombre" align="center"><p><?php echo $fila['NOMBRE'] ?></p></td>
							
							
							
							<td align="center"><?php echo $fila['APELLIDOS'] ?></td>
							<td align="center"><?php echo $fila['CARGO'] ?></td>
							
							
							
							<form method="post" action="../controladores/controlador_maquinas.php">
								
								<td class ="boton">
									<button id="add<?php echo $contador ?>" name="add<?php echo $contador ?>" type="submit" class="vistacliente">
										<?php 
										$empleadoMod['DNI'] = $fila['DNI'];
										$empleadoMod['NOMBRE'] = $fila['NOMBRE'];
										$empleadoMod['APELLIDOS'] = $fila['APELLIDOS'];
										$empleadoMod['CARGO'] = $fila['CARGO'];
									
										$_SESSION['EMPLEADOMOD' . $contador] = $empleadoMod;	
									?>
									<img src="../img/addButton.png" class="borrar_fila" alt="Papelera Borrar" height="40" width="40">
									</button>
								</td>
							   
							
								
								
								
								
								
							
								
								
							</form>
									
						</tr>
						
				<?php $contador++;} ?>

				</div>
			</div>
		</form>
	
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

						<a href="modificarMaquina.php?PAG_NUM=<?php echo $pagina; ?>&PAG_TAM=<?php echo $pag_tam; ?>"><?php echo $pagina; ?></a>

			<?php }
			 }
				
				else if($pagina_seleccionada >= $total_paginas-3) {
					 for( $pagina = $pagina_seleccionada-(6-($total_paginas-$pagina_seleccionada)); $pagina <= $total_paginas; $pagina++ )
						if ( $pagina == $pagina_seleccionada) { 	?>

						<span class="current"><?php echo $pagina; ?></span>

			<?php }	else { ?>

						<a href="modificarMaquina.php?PAG_NUM=<?php echo $pagina; ?>&PAG_TAM=<?php echo $pag_tam; ?>"><?php echo $pagina; ?></a>

			<?php }
			 }
				else if($pagina_seleccionada <= 4) { 
					for( $pagina = 1; $pagina <= $pagina_seleccionada+(7-$pagina_seleccionada); $pagina++ )
					if ( $pagina == $pagina_seleccionada) { 	?>

						<span class="current"><?php echo $pagina; ?></span>

			<?php }	else { ?>

						<a href="modificarMaquina.php?PAG_NUM=<?php echo $pagina; ?>&PAG_TAM=<?php echo $pag_tam; ?>"><?php echo $pagina; ?></a>

			<?php } 
				}
				else {
					for( $pagina = $pagina_seleccionada-3; $pagina <= $pagina_seleccionada+3; $pagina++ )
				if ( $pagina == $pagina_seleccionada) { 	?>

						<span class="current"><?php echo $pagina; ?></span>

			<?php }	else { ?>

						<a href="modificarMaquina.php?PAG_NUM=<?php echo $pagina; ?>&PAG_TAM=<?php echo $pag_tam; ?>"><?php echo $pagina; ?></a>

			<?php } 
				} ?>
			

		</div>
		</nav>
		</div>
	
</main>
</body>
</html>