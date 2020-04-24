<?php

	session_start();

    require_once("../gestionas/gestionBD.php");
    require_once("../gestionas/gestionarCamion.php");
    require_once("../gestionas/gestionarMaquina.php");
    require_once("../gestionas/gestionarMaterial.php");
    require_once("../gestionas/gestionarNomina.php");
    require_once("../gestionas/gestionarEmpleado.php");
    require_once("../consultaPaginada.php");

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
  <title>Lista de Empleados</title>
 


</head>

<body>

<?php
	include_once ("header.php");
	?>
<main>


	<div style="overflow-x:auto; overflow-y:auto;">
	 	<table  id="tablaClientes">	
	 	<caption>Listado de los pedidos de empleados</caption>
	 	<input type="text" id="filtro" onkeyup="filtrar()" placeholder="Filtrar por acabado.." title="Escribe un acabado">

		<tr>
    		<th>DNI</th>
    		<th>Nombre</th>
    		<th>Apellidos</th>
    		<th>Teléfono</th>
    		<th>Direccion</th>
    		<th>Cargo</th>
    		<th>Capital Social</th>
    		<th>Fecha de Contratacion</th>
    		<th>Dias de vacaciones</th>
    		<th>Maquina	</th>
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





				<!-- <?php

					if (isset($empleado) and ($empleado["DNI"] == $fila["DNI"])) { ?>


						<h3><input id="DNI" name="DNI" type="text" value="<?php echo $fila["DNI"]; ?>"/>	</h3>

						<h4><?php echo $fila["NOMBRE"]." ".$fila["APELLIDOS"]; ?></h4>

				<?php }	else { ?> -->
					<?php	if($fila['OCULTO']==1) { ?>
							<tr class="fila">
							<td class="oculto" align="center"><p class="fOculto"><?php echo $fila['DNI'] ?></p></td>
							<td class="oculto" align="center"><p class="fOculto"><?php echo $fila['NOMBRE'] ?></p></td>
							<td class="oculto" align="center"><p class="fOculto"><?php echo $fila['APELLIDOS'] ?></p></td>
							<td class="oculto" align="center"><p class="fOculto"><?php echo $fila['TELEFONO'] ?></p></td>
							<td class="oculto" align="center"><p class="fOculto"><?php echo $fila['DIRECCION'] ?></p></td>
							<td class="oculto" align="center"><p class="fOculto"><?php echo $fila['CARGO']?></p></td>
							<td class="oculto" align="center"><p class="fOculto"><?php echo $fila['CAPITALSOCIAL']?></p></td>
							<td class="oculto" align="center"><p class="fOculto"><?php echo $fila['FECHACONTRATACION']?></p></td>
							<td class="oculto" align="center"><p class="fOculto"><?php echo $fila['DIASVACACIONES']?></p></td>
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
								
								<td class ="boton"><button id="editar" name="editar" type="submit" class="vistacliente">
									<img src="../img/lapizEditar.png" class="editar_fila" alt="Lapiz Editar" height="40" width="40">
								</button></td>
						
								<td class ="boton"><button id="borrar" name="borrar" type="submit" class="vistacliente">
									<img src="../img/papeleraBorrar.png" class="borrar_fila" alt="Papelera Borrar" height="40" width="40">
								</button></td>
							</form>
						</tr>
					<?php }else{ ?>
						<tr class="fila">
							<td align="center"><?php echo $fila['DNI'] ?></td>
							<td align="center"><?php echo $fila['NOMBRE'] ?></td>
							<td align="center"><?php echo $fila['APELLIDOS'] ?></td>
							<td align="center"><?php echo $fila['TELEFONO'] ?></td>
							<td align="center"><?php echo $fila['DIRECCION'] ?></td>
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
							
							
								<td class ="boton"><button id="editar" name="editar" type="submit" class="vistacliente">
									<img src="../img/lapizEditar.png" class="editar_fila" alt="Lapiz Editar" height="40" width="40">
								</button></td>
						
								<td class ="boton"><button id="borrar" name="borrar" type="submit" class="vistacliente" 
									onclick="return confirm('¿Seguro que quieres dar de baja a <?php echo $fila['NOMBRE'] ?> ?')" >
									<img src="../img/papeleraBorrar.png" class="borrar_fila" alt="Papelera Borrar" height="40" width="40">
								</button></td>
							
						</tr>
						
						<?php } ?>
				<?php } ?>

				</div>
				</div>
		</form>





	<?php } ?>
	</table>
	</div>
	</br>


		<form method="get" action="muestraEmpleados.php">

			<input id="PAG_NUM" name="PAG_NUM" type="hidden" value="<?php echo $pagina_seleccionada?>"/>

			Mostrando

			<input id="PAG_TAM" name="PAG_TAM" type="number"

				min="1" max="<?php echo $total_registros;?>"

				value="<?php echo $pag_tam?>" autofocus="autofocus" />

			entradas de <?php echo $total_registros?>

			<input type="submit" value="Cambiar">

		</form>
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




	</nav>



</main>

</body>
</html>
