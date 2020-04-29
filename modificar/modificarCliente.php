<?php	
	session_start();	
		if( !isset($_SESSION["cargo"]) or ($_SESSION['cargo']!="GERENTEVENTAS")){
		echo "</p>No tienes permisos para acceder a esta página</p>";
		
	}else{
	if (isset($_SESSION["cliente"])) {
		$cliente = $_SESSION["cliente"];


?>


<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

 <link rel="stylesheet" type="text/css" href="../css/header.css" />
 <link rel="stylesheet" type="text/css" href="../css/modificarForm.css" />
</head>
<body>
	<?php
	include_once ("../muestra/header.php");
	?>
<main>
<?php 
	if (isset($_SESSION["mensajeok"])) {
			unset($_SESSION["mensajeok"]);
			
		echo "<div>
	<div class=\"error\">
		<div class=\"tick\"><img src=\"../img/tick.png\" /></div>
		<div class=\"errortext\" style=\"display: inline-block; align-items: center;\" ><p>¡El cliente ha sido editado correctamente!</p></div>
	</div>";
		
		
	}  
	?>
	
	
	
	<?php } ?>
	<div class="divMod">
	
	<form method="post" action="../controladores/controlador_clientes.php">
	
		<input id="OID_CLI" name="OID_CLI" type="hidden"  value="<?php echo $cliente['OID_CLI'] ?>"/>

	
	<div class="linea">
			<label for="NOMBRE" class="textoMod">Nombre</label></br>	
			<input align="center" class="largo" id="NOMBRE" name="NOMBRE" type="text" value="<?php echo $cliente['NOMBRE'];?>"/><br />
	</div>
	
	<div class="linea2">
	<div class="dividido">
	<label class="textoMod">Cif</label></br>		
	<input class="corto" pattern="^[a-zA-Z]{1}[0-9]{7}[a-zA-Z]{1}" id="CIF" name="CIF" type="text" value="<?php echo $cliente['CIF'];?>"/><br />
	</div>
	
	<div class="dividido">
	<label class="textoMod">Teléfono</label></br>	
	<input class="corto" pattern="^[0-9]{9}" id="TELEFONO" name="TELEFONO" type="text" value="<?php echo $cliente['TELEFONO'];?>"/><br />
	</div>
	</div>
	
	
	
	
	<div class="linea">
	<label class="textoMod">Direccion</label></br>	
	<input class="largo" id="DIRECCION" name="DIRECCION" type="text" value="<?php echo $cliente['DIRECCION'];?>"/><br />
	</div>
	
	<div class="linea">
	<label class="textoMod">Email</label></br>	
	<input class="largo" pattern="[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*@[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{1,5}" id="EMAIL" name="EMAIL" type="text" value="<?php echo $cliente['EMAIL'];?>"/><br />
	</div>
		
    	
   	<br />
  	<div class="linea2">
		<button title="Guardar" id="guardar" name="guardar" type="submit" class="botonG">
			<img src="../img/salvar.png" class="imagen" alt="Guardar">
	</button>
	
	<button title="Volver a la tabla" id="patras" name="patras" type="submit" class="botonG2">
			<img src="../img/atras.png" class="imagen" alt="Volver">
	</button>
	
   	</div>
   	</div>
   	




	</form>

</main>
</body>
</html>
<?php } ?>