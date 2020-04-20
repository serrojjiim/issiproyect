<?php
    require_once("gestionas/gestionBD.php");
	require_once("gestionas/gestionarPC.php");
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
	
	<p><?php echo $fila["OID_PEDCLI"]; ?> <?php echo $fila["FECHAPEDIDO"]; ?> <?php echo $fila["COSTETOTAL"]; ?> <?php echo $fila["OID_CLI"]; ?></p>
	
<?php } ?>
</main>
</body>
</html>