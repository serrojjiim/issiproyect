<?php
	session_start();
	if(!isset($_SESSION["cargo"])){
		echo "</p>No tienes permisos para acceder a esta página</p>";
		
	}else{
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
	$oid_emp = $_SESSION['oid_emp'];
	$query = "SELECT * FROM PETICIONDIAS WHERE OID_EMP = $oid_emp";

	$total_registros = total_consulta($conexion,$query);
	$total_paginas = (int) ($total_registros / $pag_tam);

	if ($total_registros % $pag_tam > 0) $total_paginas++;
	if ($pagina_seleccionada > $total_paginas) $pagina_seleccionada = $total_paginas;

	$paginacion["PAG_NUM"] = $pagina_seleccionada;
	$paginacion["PAG_TAM"] = $pag_tam;
	$_SESSION["paginacion"] = $paginacion;
	
	$filas = consulta_paginada($conexion, $query, 1, 5);
	
    cerrarConexionBD($conexion);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" type="text/css" href="../css/peticiondias.css" />
    <link rel="stylesheet" type="text/css" href="../css/muestraTabla.css" />
    <link rel="stylesheet" type="text/css" href="../css/footer.css" />

    	<!-- <script type="text/javascript" src="./js/boton.js"></script> -->
  <title>Peticion de dias</title>
</head>

<body>
	<?php
		include_once ("header.php"); ?>

	<div class="global">
		<div class="solicitudes">
			<div class="titulotabla">
	 			<div><p class="titulo">TUS PETICIONES</p></div>
	 		</div>
		
		<div class ="tabla">
	 	<table style="width: 80%;" class="tabla" id="tablaPeticiones">
	 	
		<tr>
    		<th class="primera">DIAS</th>
    		<th class="ultima">MOTIVO</th>
  		</tr>

	<?php
		foreach($filas as $fila) {

	?>


			<div class="fila_peticion">

				<div class="datos_maquina">
						<?php 
						if ($fila['ACEPTADA'] == 0) {
							
						?>
						<tr class="denegada" class="fila">
							<td class="dias" align="center"><p><?php echo $fila['DIAS'] ?></p></td>
							<td class="motivo" align="center"><p><?php echo $fila['MOTIVO'] ?></p></td>

						</tr>
						<?php } 
						else if ($fila['ACEPTADA'] == 1) {
							
						?>
						<tr class="aceptada" class="fila">
							<td class="dias" align="center"><p><?php echo $fila['DIAS'] ?></p></td>
							<td class="motivo" align="center"><p><?php echo $fila['MOTIVO'] ?></p></td>

						</tr>
						<?php }else if($fila['ACEPTADA'] == 3) {
						?>
						<tr class="pendiente" class="fila">
							<td class="dias" align="center"><p><?php echo $fila['DIAS'] ?></p></td>
							<td class="motivo" align="center"><p><?php echo $fila['MOTIVO'] ?></p></td>

						</tr>
						<?php } ?>
				</div>
			</div>
		<?php } ?>
	 </table>
	</div> 
		</div>
		
		<div class="formsolicitud">
			<div class="titulotabla">
	 			<div><P class="titulo">SOLICITUD DE DÍAS</P></div>
	 		</div>
	 		<div class ="formdias">
			<form method="post" action="../controladores/controlador_solicituddias.php" id="FORMULARIOPETICIONDIAS">
			<input id="DNI" name="DNI" type="hidden" value="<?php echo $_SESSION["dni"]; ?>"/>
			<div class="linea">
				
				<input class="diasapedir" id="DIASAPEDIR" name="DIASAPEDIR" type="text" placeholder="INTRODUZCA EL NÚMERO DE DÍAS" value=""/>
			</div>
			<div class="linea">
				
				<textarea class="areamotivo" name="MOTIVO" form="FORMULARIOPETICIONDIAS" placeholder="Redacte el motivo de la solicitud (Máximo 400 caracteres)" cols="30" rows="10" maxlength="400"></textarea>
			</div>
			<div class="lineab">
			<button id="PEDIR" name="PEDIR" type="submit" class="send">
			<img class="boton" src="../img/send.png"  alt="SOLICITAR DIAS" width="40px" height="40px">
			</button>
			</div>
			</form>
			</div>
			
		</div>
		
	</div>
	
<?php
	include_once ("footer.php");
	?>
</body>
</html>
<?php } ?>