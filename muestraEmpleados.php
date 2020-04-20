<?php
    require_once("gestionas/gestionBD.php");
	require_once("gestionas/gestionarEmpleado.php");
	$conexion = crearConexionBD();
	$filas = consultarTodosEmpleados($conexion);
	cerrarConexionBD($conexion);
	
	
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Gestión de biblioteca: Lista de Libros</title>
</head>

<body> 
<main>
<?php
		foreach($filas as $fila) {
	?>
	
	<p><?php echo $fila["NOMBRE"]; ?> <?php echo $fila["APELLIDOS"]; ?> <?php echo $fila["DNI"]; ?> <?php echo $fila["OID_MAQ"]; ?></p>
	
<?php } ?>
</main>
</body>
</html>