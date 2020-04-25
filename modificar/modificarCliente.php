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
 <link rel="stylesheet" type="text/css" href="css/modificarForm.css" />
</head>
<body>
<main>
	<?php 
	if (isset($_SESSION["mensajeok"])) {
			unset($_SESSION["mensajeok"]);
		
		echo "¡El cliente ha sido modificado correctamente!";
		
	}  
	?>
	<div align="center" class="divMod">
		<div>
	<form class="modForm"  method="post" action="../controladores/controlador_modificarCliente.php">

	<div>
	<input class="xd2" pattern="^[a-zA-Z]{1}[0-9]{7}[a-zA-Z]{1}"  id="CIF" name="CIF" type="text" value="<?php echo $cliente["CIF"]; ?>"/>

	<input class="xd2" pattern="^[0-9]{9}" id="TELEFONO" name="TELEFONO" type="text" value="<?php echo $cliente["TELEFONO"]; ?>"/>

	</div>
	<div>
	<label class="textoMod">Direccion</label></br>
	<input class="xd" id="DIRECCION" name="DIRECCION" type="text" value="<?php echo $cliente["DIRECCION"]; ?>" />
	</div>
	<div>
	<label class="textoMod">Nombre</label></br>
	<input class="xd" id="NOMBRE" name="NOMBRE" type="text" value="<?php echo $cliente["NOMBRE"]; ?>"/>
	</div>
	<div>
	<label class="textoMod">Email</label></br>
	<input class="xd" pattern="[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*@[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{1,5}" 
	id="EMAIL" name="EMAIL" type="text" value="<?php echo $cliente["EMAIL"]; ?>"/>
	</div>
	
	</div>
	</div>

	<button id="guardar" name="guardar" type="submit" class="editar_fila">
			<img src="../img/bag_menuito.bmp" class="editar_fila" >
	</button>

	</form>
	
	
	
	
	<?php } ?>
</main>
</body>
</html>