<?php

	session_start();
	if(!isset($_SESSION["cargo"])){
		echo "</p>No tienes permisos para acceder a esta página</p>";
		
	}else{
	
    require_once("../gestionas/gestionBD.php");
	require_once("../gestionas/gestionarMaquina.php");
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
	
	$oidmaq = $_SESSION['oid_maq'];		
	$oidemp = $_SESSION['oid_emp'];
	$jefe = getJefeMaquina2($conexion,$oidmaq);
	$oidjefe = $jefe['OID_EMP'];	
	$query = "SELECT * FROM EMPLEADO WHERE EMPLEADO.OID_MAQ='$oidmaq' AND EMPLEADO.OID_EMP<>'$oidemp' AND EMPLEADO.OID_EMP<>'$oidjefe'";
	
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
  <title>Lista de clientes</title>
</head>

<body style="background-color:#dfdfdf7d;>


<?php
	include_once ("header.php");
	?>
<main>
	
	<div class="titulotabla">
		
	 	<div><p class="titulo">Jefe de la Máquina : <?php echo $jefe['NOMBRE'] . " " . $jefe['APELLIDOS']; ?> </p></div>
	 </div>
	 
	<div class="selectpag">
		<form class ="formpag" style="display: inline-block" method="get" action="miMaquina.php">

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
			
    		<th class="primera">Nombre</th>
    		<th class="ultima">Apellidos</th>
    		
  		</tr>

	<?php
		$contador=0;
		foreach($filas as $fila) {

	?>


			<div class="fila_cliente">

				<div class="datos_cliente">


				
						<tr class="fila" onclick="window.location='#popup<?php echo $contador; ?>';">

							<td align="center"><p><?php echo $fila['NOMBRE'] ?></p></td>
							<td align="center"><?php echo $fila['APELLIDOS'] ?></td>
					
							
						</tr>
						
						<div id="popup<?php echo $contador; ?>" class="overlay" align="left">
									<div class="popup">
										<a class="close" href="#">X</a>
										<p style="margin-top: 65%" class="textp" align="center"><p style="margin-left:35%;">Teléfono : <?php echo $fila['TELEFONO'];?></p></p>
									</br>
									</div>
						</div>
								
				<?php $contador++;} ?>


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

						<a href="miMaquina.php?PAG_NUM=<?php echo $pagina; ?>&PAG_TAM=<?php echo $pag_tam; ?>"><?php echo $pagina; ?></a>

			<?php }
			 }
				
				else if($pagina_seleccionada >= $total_paginas-3) {
					 for( $pagina = $pagina_seleccionada-(6-($total_paginas-$pagina_seleccionada)); $pagina <= $total_paginas; $pagina++ )
						if ( $pagina == $pagina_seleccionada) { 	?>

						<span class="current"><?php echo $pagina; ?></span>

			<?php }	else { ?>

						<a href="miMaquina.php?PAG_NUM=<?php echo $pagina; ?>&PAG_TAM=<?php echo $pag_tam; ?>"><?php echo $pagina; ?></a>

			<?php }
			 }
				else if($pagina_seleccionada <= 4) { 
					for( $pagina = 1; $pagina <= $pagina_seleccionada+(7-$pagina_seleccionada); $pagina++ )
					if ( $pagina == $pagina_seleccionada) { 	?>

						<span class="current"><?php echo $pagina; ?></span>

			<?php }	else { ?>

						<a href="miMaquina.php?PAG_NUM=<?php echo $pagina; ?>&PAG_TAM=<?php echo $pag_tam; ?>"><?php echo $pagina; ?></a>

			<?php } 
				}
				else {
					for( $pagina = $pagina_seleccionada-3; $pagina <= $pagina_seleccionada+3; $pagina++ )
				if ( $pagina == $pagina_seleccionada) { 	?>

						<span class="current"><?php echo $pagina; ?></span>

			<?php }	else { ?>

						<a href="miMaquina.php?PAG_NUM=<?php echo $pagina; ?>&PAG_TAM=<?php echo $pag_tam; ?>"><?php echo $pagina; ?></a>

			<?php } 
				} ?>
		

		</div>
		</nav>
		</div>
		

</main>

</body>
</html>