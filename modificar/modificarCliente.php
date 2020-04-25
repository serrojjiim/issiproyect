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
 <link rel="stylesheet" type="text/css" href="css/modificarForm.css?v=1" />
</head>
<body>
<main>
	
	<div align="center" class="divMod">
		
	<div>
	<form class="modForm"  method="post" action="../controladores/controlador_modificarCliente.php">
	<input id="OID_CLI" name="OID_CLI" type="hidden"  value="<?php echo $cliente['OID_CLI'] ?>"/>
	
	<div>
	<label class="textoMod">Nombre</label></br>
	<input class="inMod" id="NOMBRE" name="NOMBRE" type="text" value="<?php echo $cliente["NOMBRE"]; ?>"/>
	</div>
	
	<div class="lineaxd">
	<div>
	<label class="textoMod2" >Cif</label></br>
	<input class="inMod2" pattern="^[a-zA-Z]{1}[0-9]{7}[a-zA-Z]{1}"  id="CIF" name="CIF" type="text" value="<?php echo $cliente["CIF"]; ?>"/></br>
	</div>
	<div >
	<label class="textoMod3" >Telefono</label></br>
	<input class="inMod3" pattern="^[0-9]{9}" id="TELEFONO" name="TELEFONO" type="text" value="<?php echo $cliente["TELEFONO"]; ?>"/>
	</div>
	</div>
	<div>
	<label class="textoMod">Direccion</label></br>
	<input class="inMod" id="DIRECCION" name="DIRECCION" type="text" value="<?php echo $cliente["DIRECCION"]; ?>" />
	</div>
	
	<div>
	<label class="textoMod">Email</label></br>
	<input class="inMod" pattern="[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*@[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{1,5}" 
	id="EMAIL" name="EMAIL" type="text" value="<?php echo $cliente["EMAIL"]; ?>"/>
	</div>
	
	</div>
	</div>

	<button id="guardar" name="guardar" type="submit" class="botonG">
			<img src="../img/guardar.png" class="imagen" >
	</button>
	
	<button id="patras" name="patras" type="submit" class="botonG2">
			<img src="../img/back.png" class="editar_fila" alt="Modificar cargo empleado">
	</button>

	</form>
	
	<?php 
	if (isset($_SESSION["mensajeok"])) {
			unset($_SESSION["mensajeok"]);
			
		echo "<div align=\"center\" class=\"error\"><p>¡El cliente ha sido modificado correctamente!</p></div>";
		
	}  
	?>
	
	
	
	<?php } ?>
</main>
</body>
</html>