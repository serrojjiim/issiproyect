<?php	
	session_start();	
		if(!isset($_SESSION["cargo"]) or ($_SESSION['cargo']!="PRESIDENTE") and ($_SESSION['cargo']!="VICEPRESIDENTE")){
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
		 
	if (isset($_SESSION["mOkAnadeCamion"]) and $_SESSION["mOkAnadeCamion"]=="Ok") {
			unset($_SESSION["mOkAnadeCamion"]);
			
		echo "<div>
	<div class=\"error\">
		<div class=\"tick\"><img src=\"../img/tick.png\" /></div>
		<div class=\"errortext\" style=\"display: inline-block; align-items: center;\" ><p>¡El camión ha sido añadido correctamente!</p></div>
	</div>";
		
	}else if(isset($_SESSION["mOkAnadeCamion"]) and $_SESSION["mOkAnadeCamion"]==0 ){
	unset($_SESSION["mOkAnadeCamion"]);
		
		echo "<div>
	<div class=\"error2\">
		<div class=\"tick\"><img src=\"../img/no.png\" style=\"width:70px;height:70px;padding:5px; \"/></div>
		<div class=\"errortext\" style=\"display: inline-block; align-items: center;\" ><p>¡El camión NO se ha podido añadir!</p></div>
	</div>";
	}  
	?>
	
	<div class="divMod">
	
	<form method="post" action="../controladores/controlador_anadircamion.php">
	
	<div class="linea">
			<label for="MATRICULA" class="textoMod">Matricula</label></br>	
			<input align="center" class="largo" placeholder="Ejemplo: 1234ABC" pattern="^[0-9]{4}[A-Z]{3}" id="MATRICULA" name="MATRICULA" type="text" value="" required/><br />
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