<?php
    require_once("gestionas/gestionBD.php");
    require_once("gestionas/gestionarCamion.php");
    require_once("gestionas/gestionarMaquina.php");
    require_once("gestionas/gestionarMaterial.php");
    require_once("gestionas/gestionarNomina.php");
    require_once("gestionas/gestionarEmpleado.php");
    $conexion = crearConexionBD();
    $empleados = consultarEmpleados($conexion);
    $maquinas = consultarMaquinas($conexion);
    $materiales = consultarMateriales($conexion);
    $camiones = consultarCamiones($conexion);
    $nominas = consultarNominas($conexion);
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
	echo "<h2>Empleados:</h2> \n<table><tr><th>Nombre</th><th>Apellidos</th><th>DNI</th><th>OID_MAQ</th>";
        foreach($empleados as $fila) {
        	        echo "<tr><td>".$fila["NOMBRE"]."</td><td>".$fila["APELLIDOS"]."</td><td>".$fila["DNI"]."</td><td>".$fila["OID_MAQ"]."</td></tr>";
			
    ?>
    
    <!-- <p></p><?php echo "Nombre: ".$fila["NOMBRE"]." ";
			  echo "Apellidos: ".$fila["APELLIDOS"]." ";
			  echo "DNI: ".$fila["DNI"]." ";
			  echo "OID_MAQ: ".$fila["OID_MAQ"]; ?></p> -->
    
<?php } echo "</table></br>"; ?>

<?php
	echo "<h2>Maquinas:</h2> \n<table><tr><th>Nombre</th><th>OID_MAQ</th>";
        foreach($maquinas as $fila) {
        	echo "<tr><td>".$fila["NOMBRE"]."</td><td>".$fila["OID_MAQ"]."</td></tr>";
    ?>
    
    <!-- <p><?php echo "Nombre: ".$fila["NOMBRE"]." ";
			 echo "OID_MAQ: ".$fila["OID_MAQ"]; ?></p> -->
    
<?php } echo "</table></br>"; ?>

<?php
	echo "<h2>Materiales:</h2> \n<table><tr><th>Nombre</th><th>Stock</th><th>OID_MAT</th>";
        foreach($materiales as $fila) {
        	echo "<tr><td>".$fila["NOMBRE"]."</td><td>".$fila["STOCK"]."</td><td>".$fila["OID_MAT"]."</td></tr>";
    ?>
    
    
    <!-- <p><?php echo "Nombre: ".$fila["NOMBRE"]." ";
			 echo "Stock: ".$fila["STOCK"]. " ";
			 echo "OID_MAT: ".$fila["OID_MAT"]; ?></p> -->
    
<?php } echo "</table></br>"; ?>

<?php
	echo "<h2>Camiones:</h2> \n<table><tr><th>Matricula</th><th>OID_CAM</th>";
        foreach($camiones as $fila) {
        	echo "<tr><td>".$fila["MATRICULA"]."</td><td>".$fila["OID_CAM"]."</td></tr>";
    ?>
    
    <!-- <p><?php echo "Matricula: ".$fila["MATRICULA"]." ";
			 echo "OID_CAM: ".$fila["OID_CAM"]; ?></p> -->
    
<?php } echo "</table></br>"; ?>

<?php
	echo "<h2>Nóminas:</h2> \n<table><tr><th>Año</th><th>Salario</th><th>OID_EMP</th><th>OID_NOM</th>";
        foreach($nominas as $fila) {
        	echo "<tr><td>".$fila["AÑO"]."</td><td>".$fila["SALARIO"]."</td><td>".$fila["OID_EMP"]."</td><td>".$fila["OID_NOM"]."</td></tr>";
    ?>
    
    <!-- <p><?php echo "Mes: ".$fila["MES"]." ";
			 echo "Año: ".$fila["AÑO"]." ";
			 echo "Salario: ".$fila["SALARIO"]." ";
			 echo "OID_EMP: ".$fila["OID_EMP"]." ";
			 echo "OID_NOM: ".$fila["OID_NOM"]; ?></p> -->
    
<?php } echo "</table></br>"; ?>
</main>
</body>
</html>
