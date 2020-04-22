


<<?php
    require_once("gestionas/gestionBD.php");
	require_once("gestionas/gestionarEmpleado.php");
	$conexion = crearConexionBD();
	$filas = getGerenteVentas($conexion); //cambiar para que muestre los diferentes roles. Funciones en gestionarEmpleado.php
	cerrarConexionBD($conexion);
	
	
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title></title>
</head>

<body> 
<main>
<?php
		foreach($filas as $fila) {
	?>
	
	<p><?php echo $fila["NOMBRE"]; ?> <?php echo $fila["APELLIDOS"]; ?> <?php echo $fila["DNI"]; ?> <?php echo $fila["OID_MAQ"]; ?><?php echo $fila["PASS"]; ?></p>
	
<?php } ?>
</main>
</body>
</html>