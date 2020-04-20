<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title></title>
</head>
<body>
<table style="width:50%">
  <tr>
    <th>CIF</th>
    <th>NOMBRE</th>
    <th>DIRECCION</th>
    <th>TELEFONO</th>
    <th>EMAIL</th>
  </tr>
  <tr>
  	
  	<?php 
  	require_once("gestionas/gestionBD.php");
  	require_once("gestionas/gestionarCliente.php");
	$conexion=crearConexionBD();	
	
  	$p = consultarClientes($conexion);	
	while($p2 = $p->fetch(PDO::FETCH_ASSOC)){
		?>
    <td align="center"><?php echo $p2['CIF'] ?></td>
    <td align="center"><?php echo $p2['NOMBRE'] ?></td>
    <td align="center"><?php echo $p2['DIRECCION'] ?></td>
    <td align="center"><?php echo $p2['TELEFONO'] ?></td>
    <td align="center"><?php echo $p2['EMAIL'] ?></td>
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