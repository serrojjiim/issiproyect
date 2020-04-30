<?php
session_start();
if(!isset($_SESSION["cargo"]) or $_SESSION['cargo']!="JEFEPERSONAL"){
		echo "</p>No tienes permisos para acceder a esta página</p>";
		
	}else{

    require_once("../gestionas/gestionBD.php");
    require_once("../consultaPaginada.php");
	 require_once("../gestionas/gestionarEmpleado.php");

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

	$query = "SELECT * FROM PETICIONDIAS WHERE ACEPTADA = 3"; //consulta_paginada($conexion, $query, 3, 3);

	
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
  <link rel="stylesheet" type="text/css" href="../css/muestraTabla.css" />    
  <link rel="stylesheet" type="text/css" href="../css/popupocultar.css" />  	
   <link rel="stylesheet" type="text/css" href="../css/footer.css" />
  <title>Lista de solicitudes</title>
</head>

<body style="background-color: #dfdfdf7d">

<?php
	include_once ("header.php");
	?>
<main>

	

<div class="titulotabla">
	 	<div><p class="titulo">PETICIONES PENDIENTE DE REVISAR</p></div>
	 </div>

		
	<div style ="width: 60%;margin-left: auto;margin-right: auto" class ="tabla">
		<div class="selectpag">
	
			<div style="display: inline-block;width: 50%;">
			<form class="formpag" method="get" action="muestraEmpleados.php">

			<input id="PAG_NUM" name="PAG_NUM" type="hidden" value="<?php echo $pagina_seleccionada?>"/>

			Mostrando

			<input id="PAG_TAM" name="PAG_TAM" type="number"

				min="1" max="<?php echo $total_registros;?>"

				value="<?php echo $pag_tam?>" autofocus="autofocus" />

			entradas de <?php echo $total_registros?>

			<input style="cursor: pointer;" type="submit" value="Cambiar">

			</form>
			</div>
	
		</div>
		
	 	<table id="tablaClientes">	
		<tr>
    		<th class="primera">Empleado</th>
    		<th>Dias</th>
    		<th class="ultima">Motivo	</th>  		
    		</tr>
			
	<?php

		foreach($filas as $fila) {

	?>
		<?php if ($fila["ACEPTADA"] == 3) { ?>
			
		
		<form method="post" action="../controladores/controlador_solicitudesdedias.php">

			<div class="fila_solicitud">

				<div class="datos_solicitud">
					
					<input id="OID_PETICIONDIAS" name="OID_PETICIONDIAS"  type="hidden" value="<?php echo $fila["OID_PETICIONDIAS"]; ?>"/>
					<?php 
						$emple = obtener_empleado_oid($conexion,$fila["OID_EMP"]);
						?> 
						<tr class="fila">
							<td align="middle"><?php echo $emple['NOMBRE']; echo " "; echo $emple['APELLIDOS']; ?></td>
							
							<td align="center"><?php echo $fila['DIAS'] ?></td>
							
							<td style="word-wrap:break-word;max-width:0;padding-right: 3%;width: 40%;" align="center"><?php echo $fila['MOTIVO'] ?></td>					
								
							<td class ="boton">
								<button title="Aceptar petición" id="acepta" name="acepta" type="button" class="vistacliente" 
								onclick="window.location='#popupa<?php echo $fila["OID_PETICIONDIAS"]; ?>';">
									<img src="../img/aceptar.png" class="boton" alt="Aceptar petición" height="40" width="40">
								</button>
							</td>
						
							<td class ="boton">
								<button title="Denegar petición" id="denegar" name="denegar" type="button" class="vistacliente" 
									onclick="window.location='#popupd<?php echo $fila["OID_PETICIONDIAS"]; ?>';" >
									<img src="../img/denegar.png" class="boton" alt="Denegar petición" height="40" width="40">
								</button>
								</td>
								
							<div id="popupd<?php echo $fila["OID_PETICIONDIAS"]; ?>" class="overlay" align="left">
									<div class="popup">
										<a class="close" href="#">X</a>
										<p class="textp" align="center">¿Seguro que quieres denegar la petición a <?php echo $emple['NOMBRE']; echo " "; echo $emple['APELLIDOS'];?>?</p>
										</br>
										<button id="denegarr" name="denegarr" type="submit" class="bPop"><img src="../img/denegar.png" width="30px" height="30px"/></button>
									</div>
							</div>
							
							<div id="popupa<?php echo $fila["OID_PETICIONDIAS"]; ?>" class="overlay" align="left">
									<div class="popup">
										<a class="close" href="#">X</a>
										<p class="textp" align="center">¿Seguro que quieres aceptar la petición a <?php echo $emple['NOMBRE']; echo " "; echo $emple['APELLIDOS'];?>?</p>
										</br>
										<button id="aceptarr" name="aceptarr" type="submit" class="bPop"><img src="../img/aceptar.png" width="30px" height="30px"/></button>
									</div>
							</div>
								
						</tr>
						
					
				

				</div>
				</div>
		</form>





	<?php } ?>
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

						<a href="solicitudesdedias.php?PAG_NUM=<?php echo $pagina; ?>&PAG_TAM=<?php echo $pag_tam; ?>"><?php echo $pagina; ?></a>

			<?php }
			 }
				
				else if($pagina_seleccionada >= $total_paginas-3) {
					 for( $pagina = $pagina_seleccionada-(6-($total_paginas-$pagina_seleccionada)); $pagina <= $total_paginas; $pagina++ )
						if ( $pagina == $pagina_seleccionada) { 	?>

						<span class="current"><?php echo $pagina; ?></span>

			<?php }	else { ?>

						<a href="solicitudesdedias.php?PAG_NUM=<?php echo $pagina; ?>&PAG_TAM=<?php echo $pag_tam; ?>"><?php echo $pagina; ?></a>

			<?php }
			 }
				else if($pagina_seleccionada <= 4) { 
					for( $pagina = 1; $pagina <= $pagina_seleccionada+(7-$pagina_seleccionada); $pagina++ )
					if ( $pagina == $pagina_seleccionada) { 	?>

						<span class="current"><?php echo $pagina; ?></span>

			<?php }	else { ?>

						<a href="solicitudesdedias.php?PAG_NUM=<?php echo $pagina; ?>&PAG_TAM=<?php echo $pag_tam; ?>"><?php echo $pagina; ?></a>

			<?php } 
				}
				else {
					for( $pagina = $pagina_seleccionada-3; $pagina <= $pagina_seleccionada+3; $pagina++ )
				if ( $pagina == $pagina_seleccionada) { 	?>

						<span class="current"><?php echo $pagina; ?></span>

			<?php }	else { ?>

						<a href="solicitudesdedias.php?PAG_NUM=<?php echo $pagina; ?>&PAG_TAM=<?php echo $pag_tam; ?>"><?php echo $pagina; ?></a>

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
	<?php } ?>

