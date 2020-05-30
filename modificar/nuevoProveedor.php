<?php	
	session_start();	
		if(!isset($_SESSION["cargo"]) or ($_SESSION['cargo']!="GERENTECOMPRAS")){
		echo "</p>No tienes permisos para acceder a esta página</p>";
		
	}else{
	

?>


<!DOCTYPE html>
<html>
<head>
 <link rel="stylesheet" type="text/css" href="../css/header.css" />
 <link rel="stylesheet" type="text/css" href="../css/modificarForm.css" />
</head>
<body>
	<?php
	include_once ("../muestra/header.php");
	?>
<main>
	
		 <?php 
		 
		  if(isset($_SESSION["errores"])){
		$errores = $_SESSION["errores"];
		unset($_SESSION["errores"]);
	}
	
		 if (isset($errores) && count($errores)>0) { 
	    	echo "<div id=\"div_errores\" class=\"error2\">";
			echo "<h4> Errores en el formulario:</h4>";
    		foreach($errores as $error){
    			echo $error;
			} 
    		echo "</div>";
  		}
		 
	if (isset($_SESSION["mOkAnadeProveedor"]) and $_SESSION["mOkAnadeProveedor"]=="Ok") {
			unset($_SESSION["mOkAnadeProveedor"]);
			
		echo "<div>
	<div class=\"error\">
		<div class=\"tick\"><img src=\"../img/tick.png\" /></div>
		<div class=\"errortext\" style=\"display: inline-block; align-items: center;\" ><p>¡El proveedor ha sido añadido correctamente!</p></div>
	</div>";
		
	}else if(isset($_SESSION["mOkAnadeProveedor"]) and $_SESSION["mOkAnadeProveedor"]==0 ){
	unset($_SESSION["mOkAnadeProveedor"]);
		
		echo "<div>
	<div class=\"error2\">
		<div class=\"tick\"><img src=\"../img/no.png\" style=\"width:70px;height:70px;padding:5px; \"/></div>
		<div class=\"errortext\" style=\"display: inline-block; align-items: center;\" ><p>¡El proveedor NO se ha podido añadir!</p></div>
	</div>";
	}  
	?>
	
	<div class="divMod">
	
	<form method="post" action="../controladores/controlador_anadirproveedor.php">
	
	<div class="linea">
			<label for="NOMBRE" class="textoMod">Nombre</label></br>	
			<input align="center" class="largo" id="NOMBRE" name="NOMBRE" type="text" value="" required/><br />
	</div>
	
	<div class="linea2">
	<div class="dividido">
	<label class="textoMod">Cif</label></br>		
	<input class="corto" pattern="^[a-zA-Z]{1}[0-9]{7}[a-zA-Z]{1}" id="CIF" name="CIF" type="text" value="" required/><br />
	</div>
	
	<div class="dividido">
	<label class="textoMod">Teléfono</label></br>	
	<input class="corto" pattern="^[0-9]{9}" id="TELEFONO" name="TELEFONO" type="text" value="" required/><br />
	</div>
	</div>
	
	<div class="linea">
	<label class="textoMod">Direccion</label></br>	
	<input class="largo" id="DIRECCION" name="DIRECCION" type="text" value="" required/><br />
	</div>
	
	<div class="linea">
	<label class="textoMod">Email</label></br>	
	<input class="largo" pattern="[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*@[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{1,5}" id="EMAIL" name="EMAIL" type="text" value="" required/><br />
	</div>
		
   	<br />
  	<div class="linea2">
		<button title="Guardar" id="guardar" name="guardar" type="submit" class="botonG">
			<img src="../img/salvar.png" class="imagen" alt="Guardar">
	</button>
	
	<button title="Volver a la tabla" id="patras" name="patras" type="submit" class="botonG2" formnovalidate>
			<img src="../img/atras.png" class="imagen" alt="Volver">
	</button>
	
   	</div>
   	</div>

	</form>

</main>
</body>
</html>

<?php } ?>