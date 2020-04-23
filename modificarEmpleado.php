<?php	
	session_start();	
	
	if (isset($_SESSION["empleado"])) {
		$empleado = $_SESSION["empleado"];
		
	
		

?>


<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
 <link rel="stylesheet" type="text/css" href="css/header.css" />
</head>
<body>
<main>
	<?php 
	if (isset($_SESSION["mensajeok"])) {
			unset($_SESSION["mensajeok"]);
		
		echo "¡El empleado ha sido modificado correctamente!";
		
	}  
	?>
	<form method="post" action="controladores/controlador_modificarempleados.php">
	<input id="OID_EMP" name="OID_EMP" type="text" value="<?php echo $empleado["OID_EMP"]; ?>"/><br />
	<input id="NOMBRE" name="NOMBRE" type="text" value="<?php echo $empleado["NOMBRE"]; ?>"/><br />
	<input id="APELLIDOS" name="APELLIDOS" type="text" value="<?php echo $empleado["APELLIDOS"]; ?>"/><br />
	<input id="DNI" name="DNI" type="text" value="<?php echo $empleado["DNI"]; ?>"/><br />
	<input id="TELEFONO" name="TELEFONO" type="text" value="<?php echo $empleado["TELEFONO"]; ?>"/><br />
	<input id="DIRECCION" name="DIRECCION" type="text" value="<?php echo $empleado["DIRECCION"]; ?>"/><br />
	<input id="CARGO" name="CARGO" type="text" value="<?php echo $empleado["CARGO"]; ?>"/><br />
	<input id="FECHACONTRATACION" name="FECHACONTRATACION" type="text" value="<?php echo $empleado["FECHACONTRATACION"]; ?>"/><br />
	<input id="CAPITALSOCIAL" name="CAPITALSOCIAL" type="text" value="<?php echo $empleado["CAPITALSOCIAL"]; ?>"/><br />
	<input id="DIASVACACIONES" name="DIASVACACIONES" type="text" value="<?php echo $empleado["DIASVACACIONES"]; ?>"/><br />
	<input id="OID_MAQ" name="OID_MAQ" type="text" value="<?php echo $empleado["OID_MAQ"]; ?>"/><br />
	
	<button id="guardar" name="guardar" type="submit" class="editar_fila">
			<img src="img/bag_menuito.bmp" class="editar_fila" alt="Modificar cargo empleado">
	</button>



	</form>
	<?php } ?>
</main>
</body>
</html>