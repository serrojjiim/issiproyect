<?php	
	session_start();	
	
	if (isset($_SESSION["cliente"])) {
		$cliente = $_SESSION["cliente"];
		
	
		

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
	<form method="post" action="controladores/controlador_modificarCliente.php">
	<input id="OID_EMP" name="OID_CLI" type="text" value="<?php echo $cliente["OID_CLI"]; ?>"/><br />
	<input id="NOMBRE" name="CIF" type="text" value="<?php echo $cliente["CIF"]; ?>"/><br />
	<input id="APELLIDOS" name="NOMBRE" type="text" value="<?php echo $cliente["NOMBRE"]; ?>"/><br />
	<input id="DNI" name="DIRECCION" type="text" value="<?php echo $cliente["DIRECCION"]; ?>" /><br />
	<input id="TELEFONO" name="TELEFONO" type="text" value="<?php echo $cliente["TELEFONO"]; ?>"/><br />
	<input id="DIRECCION" name="EMAIL" type="text" value="<?php echo $cliente["EMAIL"]; ?>"/><br />
	
	<button id="guardar" name="guardar" type="submit" class="editar_fila">
			<img src="img/bag_menuito.bmp" class="editar_fila" >
	</button>



	</form>
	<?php } ?>
</main>
</body>
</html>