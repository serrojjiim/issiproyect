<?php 
	session_start();
	
	
	include_once("../gestionas/gestionBD.php");
	include_once("../gestionas/gestionarPP.php");
	require_once("../gestionas/gestionBD.php");
    require_once("../consultaPaginada.php");
	unset($_SESSION["paginacion"]);
	$conexion = crearConexionBD();	
	$filas1 = consultarPP($conexion);

	if (isset($_SESSION["paginacion"])) $paginacion = $_SESSION["paginacion"];
	$pagina_seleccionada = isset($_GET["PAG_NUM"])? (int)$_GET["PAG_NUM"]: (isset($paginacion)? (int)$paginacion["PAG_NUM"]: 1);

	$pag_tam = isset($_GET["PAG_TAM"])? (int)$_GET["PAG_TAM"]: (isset($paginacion)? (int)$paginacion["PAG_TAM"]: 5);

	if ($pagina_seleccionada < 1) $pagina_seleccionada = 1;
	if ($pag_tam < 1) $pag_tam = 5;

	unset($_SESSION["paginacion"]);
	
	$query = "SELECT * FROM MATERIAL";

	
	$total_registros = total_consulta($conexion,$query);
	$total_paginas = (int) ($total_registros / $pag_tam);

	if ($total_registros % $pag_tam > 0) $total_paginas++;
	if ($pagina_seleccionada > $total_paginas) $pagina_seleccionada = $total_paginas;

	$paginacion["PAG_NUM"] = $pagina_seleccionada;
	$paginacion["PAG_TAM"] = $pag_tam;
	$_SESSION["paginacion"] = $paginacion;
	
	
	$filas = consulta_paginada($conexion, $query, $pagina_seleccionada, $pag_tam);
	
	
	
	foreach($filas1 as $fila1){
		if($fila1['FECHAPAGO']!=null){
				
			//echo $fila['OID_PEDPROV']; echo "</br>";
			
			$filas2 = lineaspedidoP($conexion,$fila1['OID_PEDPROV']);
			
			//echo "---------------------";echo "</br>";
			
			foreach($filas2 as $fila2){
				
				//echo $fila2['CANTIDAD'] . "</br>";
				//echo $fila2['ANADIDO'] . "</br>";
				
			$material= getCantidadMaterial($conexion,$fila2['OID_MAT']);
			 foreach($material as $m){
			 
				 if($fila2['ANADIDO']==0){
				 	//echo $m['NOMBRE'] . " : " . $m['STOCK'] . "</br>";
					$suma = $m['STOCK'] +$fila2['CANTIDAD'];
					//echo $suma . "</br>" . "---------</br>"; 
					
					$error = insertarMaterial($conexion,$m['OID_MAT'],$suma);
					$errar = actualizarAnadir($conexion,$fila2['OID_PEDPROV']);
				 } 
			 }
			
				
			}
			
			//echo "---------------------";echo "</br>";
			
			
		}
	}
	
	
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link rel="stylesheet" type="text/css" href="../css/muestraTabla.css" />
  <link rel="stylesheet" type="text/css" href="../css/amoal_lio.css" />
   <link rel="stylesheet" type="text/css" href="../css/footer.css" />

  <title>Lista de materiales</title>
</head>

<body style="background-color:#dfdfdf7d;>


<?php
	include_once ("header.php");
	?>
<main>
	
	<div class="titulotabla">
	 	<div><p class="titulo">ALMACÉN DE MATERIALES</p></div>
	 </div>
	 
	<div class="selectpag">
		<form class ="formpag" style="display: inline-block" method="get" action="muestraAlmacen.php">

			<input id="PAG_NUM" name="PAG_NUM" type="hidden" value="<?php echo $pagina_seleccionada?>"/>

			Mostrando

			<input id="PAG_TAM" name="PAG_TAM" type="number"

				min="1" max="<?php echo $total_registros;?>"

				value="<?php echo $pag_tam?>" autofocus="autofocus" />

			entradas de <?php echo $total_registros?>

			<input style="cursor: pointer;" type="submit" value="Cambiar">

		</form>
		</div>
	
	
	
	<div class ="tabla">
			
	 <table  id="tablaClientes">
	 	
		<tr id="cabecera">
    		<th class="primera" >Nombre</th>
    		<th class="ultima">Stock</th>
  		</tr>

	<?php
	
		foreach($filas as $fila) {

	?>


			<div class="fila_cliente">

				<div class="datos_cliente">
	
							<?php if($fila['STOCK']<=1500){ ?> 

							<tr class="tmuerto" style="border-bottom: 2px solid #e53440" class="fila">
							<?php }else if($fila['STOCK']>1500 and $fila['STOCK']<=5000 ) { ?>
							<tr class="tmuerto" style="border-bottom: 2px solid #f4964a" class="fila">
							<?php }else { ?>
							<tr class="tmuerto" style="border-bottom: 2px solid #73b887" class="fila">
							<?php } ?>

								<td align="center"><p><?php echo $fila['NOMBRE'] ?></p></td>
								<td align="center"><?php echo $fila['STOCK'] ?></td>
								
												
							</tr>

				</div>
			</div>

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

						<a href="muestraAlmacen.php?PAG_NUM=<?php echo $pagina; ?>&PAG_TAM=<?php echo $pag_tam; ?>"><?php echo $pagina; ?></a>

			<?php }
			 }
				
				else if($pagina_seleccionada >= $total_paginas-3) {
					 for( $pagina = $pagina_seleccionada-(6-($total_paginas-$pagina_seleccionada)); $pagina <= $total_paginas; $pagina++ )
						if ( $pagina == $pagina_seleccionada) { 	?>

						<span class="current"><?php echo $pagina; ?></span>

			<?php }	else { ?>

						<a href="muestraAlmacen.php?PAG_NUM=<?php echo $pagina; ?>&PAG_TAM=<?php echo $pag_tam; ?>"><?php echo $pagina; ?></a>

			<?php }
			 }
				else if($pagina_seleccionada <= 4) { 
					for( $pagina = 1; $pagina <= $pagina_seleccionada+(7-$pagina_seleccionada); $pagina++ )
					if ( $pagina == $pagina_seleccionada) { 	?>

						<span class="current"><?php echo $pagina; ?></span>

			<?php }	else { ?>

						<a href="muestraAlmacen.php?PAG_NUM=<?php echo $pagina; ?>&PAG_TAM=<?php echo $pag_tam; ?>"><?php echo $pagina; ?></a>

			<?php } 
				}
				else {
					for( $pagina = $pagina_seleccionada-3; $pagina <= $pagina_seleccionada+3; $pagina++ )
				if ( $pagina == $pagina_seleccionada) { 	?>

						<span class="current"><?php echo $pagina; ?></span>

			<?php }	else { ?>

						<a href="muestraAlmacen.php?PAG_NUM=<?php echo $pagina; ?>&PAG_TAM=<?php echo $pag_tam; ?>"><?php echo $pagina; ?></a>

			<?php } 
				} ?>
			

		</div>
		</nav>
		</div>
<?php
	include_once ("footer.php");
	?>
</main>

</body>
</html>
