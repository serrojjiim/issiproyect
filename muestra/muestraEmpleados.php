<?php

	session_start();
	if(!isset($_SESSION["cargo"]) or ($_SESSION['cargo']!="JEFEPERSONAL" and $_SESSION['cargo']!="PRESIDENTE" and $_SESSION['cargo']!="VICEPRESIDENTE")){
		echo "</p>No tienes permisos para acceder a esta página</p>";
		
	}else{
		
    require_once("../gestionas/gestionBD.php");
    require_once("../gestionas/gestionarCamion.php");
    require_once("../gestionas/gestionarMaquina.php");
    require_once("../gestionas/gestionarMaterial.php");
    require_once("../gestionas/gestionarNomina.php");
    require_once("../gestionas/gestionarEmpleado.php");
    require_once("../consultaPaginada.php");
	unset($_SESSION["paginacion"]);

	if (isset($_SESSION["paginacion"])) $paginacion = $_SESSION["paginacion"];
	$pagina_seleccionada = isset($_GET["PAG_NUM"])? (int)$_GET["PAG_NUM"]: (isset($paginacion)? (int)$paginacion["PAG_NUM"]: 1);

	$pag_tam = isset($_GET["PAG_TAM"])? (int)$_GET["PAG_TAM"]: (isset($paginacion)? (int)$paginacion["PAG_TAM"]: 5);

	if ($pagina_seleccionada < 1) $pagina_seleccionada = 1;
	if ($pag_tam < 1) $pag_tam = 5;

	unset($_SESSION["paginacion"]);

	$conexion = crearConexionBD();

	$query = "SELECT * FROM EMPLEADO"; 

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
  <title>Lista de Empleados</title>
 


</head>

<body style="background-color:#dfdfdf7d;">

<?php
	include_once ("header.php");
	?>
<main> 	
	<!-- <input type="text" id="filtro" onkeyup="filtrar()" placeholder="Filtrar por acabado.." title="Escribe un acabado"> -->
	<div class="titulotabla">
	 	<div><p class="titulo">EMPLEADOS</p></div>
	 </div>
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
		<?php
								if($_SESSION['cargo']=="PRESIDENTE"){ ?>
		<div style="display: inline-block;float:right;">
			

			<button onclick="window.location.href='../modificar/nuevoEmpleado.php'" id="anadir" name="anadir" type="button" class="anadir">
			<img src="../img/anadir.png" class="" alt="Añadir Empleado" height="25" width="25">
			</button>
			
		</div>
		
		<?php } ?>
		
		
		
		</div>
		
		<div class ="tabla">
	 	<table  id="tablaClientes">	
		<tr>
    		<th class="primera">DNI</th>
    		<th>Nombre</th>
    		<th>Apellidos</th>
    		<th>Teléfono</th>
    		<th>Direccion</th>
    		<?php
								if($_SESSION['cargo']=="PRESIDENTE"){ ?>
    		<th>Cargo</th>
    		<th>Capital Social</th>
    		<th>Fecha de Contratacion</th>
    		<th>Dias de vacaciones</th>
    		<?php } ?>
    		<th class="ultima">Maquina	</th>
  		</tr>
			
	<?php

		foreach($filas as $fila) {

	?>




		<form method="post" action="../controladores/controlador_empleados.php">

			<div class="fila_empleado">

				<div class="datos_empleado">
					
					<input id="OID_EMP" name="OID_EMP"  type="hidden" value="<?php echo $fila["OID_EMP"]; ?>"/>
					<input id="DNI" name="DNI" type="hidden" value="<?php echo $fila["DNI"]; ?>"/>
					<input id="NOMBRE" name="NOMBRE" type="hidden" value="<?php echo $fila["NOMBRE"]; ?>"/>
					<input id="APELLIDOS" name="APELLIDOS" type="hidden" value="<?php echo $fila["APELLIDOS"]; ?>"/>
					<input id="TELEFONO" name="TELEFONO" type="hidden" value="<?php echo $fila["TELEFONO"]; ?>"/>
					<input id="DIRECCION" name="DIRECCION" type="hidden" value="<?php echo $fila["DIRECCION"]; ?>"/>
					<input id="CARGO" name="CARGO" type="hidden" value="<?php echo $fila["CARGO"]; ?>"/>
					<input id="CAPITALSOCIAL" name="CAPITALSOCIAL" type="hidden" value="<?php echo $fila["CAPITALSOCIAL"]; ?>"/>
					<input id="FECHACONTRATACION" name="FECHACONTRATACION" type="hidden" value="<?php echo $fila["FECHACONTRATACION"]; ?>"/>
					<input id="DIASVACACIONES" name="DIASVACACIONES" type="hidden" value="<?php echo $fila["DIASVACACIONES"]; ?>"/>
					<input id="OID_MAQ" name="OID_MAQ" type="hidden" value="<?php echo $fila["OID_MAQ"]; ?>"/>



					<?php	if($fila['OCULTO']==1) { ?>
							<tr class="fila">
							<td class="oculto" align="center"><p class="fOculto"><?php echo $fila['DNI'] ?></p></td>
							<td class="oculto" align="center"><p class="fOculto"><?php echo $fila['NOMBRE'] ?></p></td>
							<td class="oculto" align="center"><p class="fOculto"><?php echo $fila['APELLIDOS'] ?></p></td>
							<td class="oculto" align="center"><p class="fOculto"><?php echo $fila['TELEFONO'] ?></p></td>
							<td class="oculto" align="center"><p class="fOculto"><?php echo $fila['DIRECCION'] ?></p></td>
							<?php
								if($_SESSION['cargo']=="PRESIDENTE"){ ?>
							<td class="oculto" align="center"><p class="fOculto"><?php echo $fila['CARGO']?></p></td>
							<td class="oculto" align="center"><p class="fOculto"><?php echo $fila['CAPITALSOCIAL']?></p></td>
							<td class="oculto" align="center"><p class="fOculto"><?php echo $fila['FECHACONTRATACION']?></p></td>
							<td class="oculto" align="center"><p class="fOculto"><?php echo $fila['DIASVACACIONES']?></p></td>
							<?php } ?>
							<td class="oculto" align="center"><p class="fOculto"><?php 
								if($fila['OID_MAQ']==1) echo "Pintura";
								else if($fila['OID_MAQ']==2) echo "Fresadora";
								else if($fila['OID_MAQ']==3) echo "Serigrafiadora";
								else if($fila['OID_MAQ']==4) echo "Caldera";
								else if($fila['OID_MAQ']==5) echo "Robot";
								else if($fila['OID_MAQ']==6) echo "Bajeras";
								else if($fila['OID_MAQ']==7) echo "Robot 2";
								else if($fila['OID_MAQ']==8) echo "Pintura 2";
								else if($fila['OID_MAQ']==9) echo "Almacen 1";
								else if($fila['OID_MAQ']==10) echo "Almacen 2";
								
								else if($fila['OID_MAQ']==null) echo "Ninguna";
								
							?></p></td>
							
							<form action="../controladores/controlador_empleados.php">
								<?php
								if($_SESSION['cargo']=="PRESIDENTE"){ ?>
								<td class ="boton"><button id="editar" name="editar" type="submit" class="vistacliente">
									<img src="../img/lapizEditar.png" class="boton" alt="Lapiz Editar" height="40" width="40">
								</button></td>
						
								<td class ="boton"><button id="activar" name="activar" type="submit" class="vistacliente">
									<img src="../img/activar.png" class="boton" alt="Papelera Borrar" height="34" width="34">
								</button></td>
								<?php } ?>

							</form>
						</tr>
					<?php }else{ ?>
						<tr class="fila">
							<td align="center"><p><?php echo $fila['DNI'] ?></p></td>
							<td align="center"><?php echo $fila['NOMBRE'] ?></td>
							<td align="center"><?php echo $fila['APELLIDOS'] ?></td>
							<td align="center"><?php echo $fila['TELEFONO'] ?></td>
							<td align="center"><?php echo $fila['DIRECCION'] ?></td>
							<?php
								if($_SESSION['cargo']=="PRESIDENTE"){ ?>
							<td align="center"><?php
								if($fila['CARGO']==1) echo "Presidente";
								else if($fila['CARGO']==2) echo "Vicepresidente";
								else if($fila['CARGO']==3) echo "Secretario";
								else if($fila['CARGO']==4) echo "Tesorero";
								else if($fila['CARGO']==5) echo "Gerente de Ventas";
								else if($fila['CARGO']==6) echo "Gerente de Compras";
								else if($fila['CARGO']==7) echo "Capataz";
								else if($fila['CARGO']==8) echo "Jefe de Personal";
								else if($fila['CARGO']==9) echo "Jefe de Máquina";
								else if($fila['CARGO']==10) echo "Peón";
								else if($fila['CARGO']==11) echo "Camionero";
								?></td>
								
							<td align="center"><?php echo $fila['CAPITALSOCIAL']?></td>
							<td align="center"><?php echo $fila['FECHACONTRATACION']?></td>
							<td align="center"><?php echo $fila['DIASVACACIONES']?></td>
							<?php } ?>
							<td align="center"><?php 
								if($fila['OID_MAQ']==1) echo "Pintura";
								else if($fila['OID_MAQ']==2) echo "Fresadora";
								else if($fila['OID_MAQ']==3) echo "Serigrafiadora";
								else if($fila['OID_MAQ']==4) echo "Caldera";
								else if($fila['OID_MAQ']==5) echo "Robot";
								else if($fila['OID_MAQ']==6) echo "Bajeras";
								else if($fila['OID_MAQ']==7) echo "Robot 2";
								else if($fila['OID_MAQ']==8) echo "Pintura 2";
								else if($fila['OID_MAQ']==9) echo "Almacen 1";
								else if($fila['OID_MAQ']==10) echo "Almacen 2";
								
								else if($fila['OID_MAQ']==null) echo "Ninguna";
							?></td>
							<?php
								if($_SESSION['cargo']=="PRESIDENTE"){ ?>
								<td class ="boton"><button id="editar" name="editar" type="submit" class="vistacliente">
									<img src="../img/lapizEditar.png" class="boton" alt="Lapiz Editar" height="40" width="40">
								</button></td>
						
								<td class ="boton"><button id="b" name="b" type="button" class="vistacliente" 
									onclick="window.location='#popup<?php echo $fila["OID_EMP"]; ?>';" >
									<img src="../img/ocultar.png" class="boton" alt="Papelera Borrar" height="34" width="34">
								</button></td>
							<div id="popup<?php echo $fila["OID_EMP"]; ?>" class="overlay" align="left">
									<div class="popup">
										<a class="close" href="#">X</a>
										<p class="textp" align="center">¿Seguro que quieres dar de baja a <?php echo $fila['NOMBRE']; echo " "; echo $fila['APELLIDOS'];?>?</p>
									</br>
										<button id="borrar" name="borrar" type="submit" class="bPop"><img src="../img/ocultar.png" width="30px" height="30px"/></button>
									</div>
								</div>
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

						<a href="muestraEmpleados.php?PAG_NUM=<?php echo $pagina; ?>&PAG_TAM=<?php echo $pag_tam; ?>"><?php echo $pagina; ?></a>

			<?php }
			 }
				
				else if($pagina_seleccionada >= $total_paginas-3) {
					 for( $pagina = $pagina_seleccionada-(5-($total_paginas-$pagina_seleccionada)); $pagina <= $total_paginas; $pagina++ )
						if ( $pagina == $pagina_seleccionada) { 	?>

						<span class="current"><?php echo $pagina; ?></span>

			<?php }	else { ?>

						<a href="muestraEmpleados.php?PAG_NUM=<?php echo $pagina; ?>&PAG_TAM=<?php echo $pag_tam; ?>"><?php echo $pagina; ?></a>

			<?php }
			 }
				else if($pagina_seleccionada <= 4) { 
					for( $pagina = 1; $pagina <= $pagina_seleccionada+(7-$pagina_seleccionada); $pagina++ )
					if ( $pagina == $pagina_seleccionada) { 	?>

						<span class="current"><?php echo $pagina; ?></span>

			<?php }	else { ?>

						<a href="muestraEmpleados.php?PAG_NUM=<?php echo $pagina; ?>&PAG_TAM=<?php echo $pag_tam; ?>"><?php echo $pagina; ?></a>

			<?php } 
				}
				else {
					for( $pagina = $pagina_seleccionada-3; $pagina <= $pagina_seleccionada+3; $pagina++ )
				if ( $pagina == $pagina_seleccionada) { 	?>

						<span class="current"><?php echo $pagina; ?></span>

			<?php }	else { ?>

						<a href="muestraEmpleados.php?PAG_NUM=<?php echo $pagina; ?>&PAG_TAM=<?php echo $pag_tam; ?>"><?php echo $pagina; ?></a>

			<?php } 
				} ?>
			

		</div>
		</nav>
		</div>
	<footer><?php
	include_once ("footer.php");
	?>
	</footer>

</main>

</body>
</html>
<?php } ?>