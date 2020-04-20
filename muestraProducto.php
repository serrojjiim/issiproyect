<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title></title>
</head>
<body>
	<table style="width:50%">
  <tr>
    <th>Tipo de material</th>
    <th>Precio</th>
    <th>Longitud</th>
    <th>Profundidad</th>
    <th>Altura</th>
    <th>Acabado</th>
  </tr>
  <tr>
  	
  	<?php 
  	require_once("gestionas/gestionBD.php");
	require_once("gestionas/gestionarProducto.php");
	$conexion=crearConexionBD();	
	$consulta = "SELECT * FROM PRODUCTO";
	
  	$p = consultarProductos($conexion);	
	while($p2 = $p->fetch(PDO::FETCH_ASSOC)){
		?>
    <td align="center"><?php echo $p2['NOMBRE'] ?></td>
    <td align="center"><?php echo $p2['PRECIO'] ?></td>
    <td align="center"><?php echo $p2['LONGITUD'] ?></td>
    <td align="center"><?php echo $p2['PROFUNDIDAD'] ?></td>
    <td align="center"><?php echo $p2['ALTURA'] ?></td>
    <td align="center"><?php echo $p2['ACABADO'] ?></td>
  </tr>
  <?php
	}
	?>
</table>	

	<?php
	cerrarConexionBD($conexion);

?>
</body>
</html>