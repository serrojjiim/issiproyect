<?php	
	
	session_start();	
	if( !isset($_SESSION["cargo"]) or ($_SESSION['cargo']!="PRESIDENTE" and $_SESSION['cargo']!="VICEPRESIDENTE") ){
		echo "</p>No tienes permisos para acceder a esta página</p>";
		
	}else{
	if (isset($_SESSION["errores"])){
		$errores = $_SESSION["errores"];
		$emperrores = $_SESSION["emplerror"];
		unset($_SESSION["errores"]);
		unset($_SESSION["emplerror"]);
	}

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
	if (isset($_SESSION["mensajeoka"])) {
			unset($_SESSION["mensajeoka"]);
			
		echo "<div>
	<div class=\"error\">
		<div class=\"tick\"><img src=\"../img/tick.png\" /></div>
		<div class=\"errortext\" style=\"display: inline-block; align-items: center;\" ><p>¡El empleado ha sido añadido correctamente!</p></div>
	</div>";
		
	}  
	?>
	<?php 
	
		if (isset($errores) && count($errores)>0) { 
	    	echo "<div id=\"div_errores\" class=\"error2\">";
			echo "<h4> Se han encontrado errores en el formulario:</h4>";
    		foreach($errores as $error){
    			echo $error;
			} 
    		echo "</div>";
  		}
	?>
	

		<div class="divMod">
	
	<form method="post" action="../controladores/controlador_anadirempleados.php">
	
	<div class="linea2">
	<div class="dividido">
	<label class="textoMod">Nombre</label></br>		
	<input class="corto" id="NOMBRE" name="NOMBRE" type="text" value="<?php if (isset($errores)){ echo $emperrores["NOMBRE"];}?>" required/><br />
	</div>
	
	<div class="dividido">
	<label class="textoMod">Apellidos</label></br>	
	<input class="corto" id="APELLIDOS" name="APELLIDOS" type="text" value="<?php if (isset($errores)) echo $emperrores["APELLIDOS"];?>" required/><br />
	</div>
	</div>
	
	<div class="linea">
			<label for="DIRECCION" class="textoMod">Direccion</label></br>	
			<input align="center" class="largo" id="DIRECCION" name="DIRECCION" type="text" value="<?php if (isset($errores)) echo $emperrores["DIRECCION"];?>" required/><br />
	</div>
	
	
	
	<div class="linea2">
	<div class="dividido">
	<label class="textoMod">Dni</label></br>	
	<input class="corto" pattern="^[0-9]{8}[A-Z]" id="DNI" name="DNI" type="text" value="<?php if (isset($errores)) echo $emperrores["DNI"];?>" required/><br />
	</div>
	<div class="dividido">
	<label class="textoMod">Telefono</label></br>	
	<input class="corto" pattern="^[0-9]{9}" id="TELEFONO" name="TELEFONO" type="text" value="<?php if (isset($errores)) echo $emperrores["TELEFONO"];?>" required/><br />
	</div>
	</div>	

	
	
	<div class="linea">
	<label class="textoMod">Fecha de contratacion</label></br>	
	<input class="largo" pattern="[0-9]{2}/[0-9]{2}/[0-9]{2}"  id="FECHACONTRATACION" name="FECHACONTRATACION" type="text" value="<?php if (isset($errores)) echo $emperrores["FECHACONTRATACION"];?>" required/><br />
	</div>
	
	<div class="linea">
	<label class="textoMod">Capital Social</label></br>	
	<input class="largo" pattern="[0-9]+" id="CAPITALSOCIAL" name="CAPITALSOCIAL" type="text" value="<?php if (isset($errores)) echo $emperrores["CAPITALSOCIAL"];?>" required/><br />
	</div>
	
	<div class="linea">
	<label class="textoMod">Dias de vacaciones</label></br>	
	<input class="largo" pattern="[0-9]+" id="DIASVACACIONES" name="DIASVACACIONES" type="text" value="<?php if (isset($errores)) echo $emperrores["DIASVACACIONES"];?>" required/><br/>
	</div>
	
	 	<div class="linea">
	<label class="textoMod">Cargo</label></br>	
	<select class="seleccion" id="CARGO" name="CARGO" disabled="">
     	<option value="1">Presidente</option> 
    	<option value="2">Vicepresidente</option> 
    	<option value="3">Secretario</option>
    	<option value="4">Tesorero</option> 
    	<option value="5">Gerente de Ventas</option> 
    	<option value="6">Gerente de Compras</option> 
    	<option value="7">Capataz</option> 
    	<option value="8">Jefe de Personal</option> 
    	<option value="9">Jefe de Máquina</option> 
    	<option value="10" selected="">Peón</option> 
    	<option value="11">Camionero</option> 
    	</select>
  
	</div>
	
	
	
	<div class="linea">
	<label class="textoMod">Maquina</label></br>	
	<select  class="seleccion" id="OID_MAQ" name="OID_MAQ">
     	<option value="1">Pintura</option> 
    	<option value="2">Fresadora</option> 
    	<option value="3">Serigrafiadora</option>
    	<option value="4">Caldera</option> 
    	<option value="5">Robot</option> 
    	<option value="6">Bajeras</option> 
    	<option value="7">Robot2</option> 
    	<option value="8">Pintura2</option> 
    	<option value="9">Almacen1</option> 
    	<option value="10">Almacen2</option> 
    	<option value="null">Ninguna</option> 

    	</select>
    	
   	<br />
   	</div>
  	<div class="linea2">
		<button title="Guardar" id="guardar" name="guardar" type="submit" class="botonG">
			<img src="../img/salvar.png" class="imagen" alt="Guardar">
	</button>
	
	<button onclick="window.location.href='../muestra/muestraEmpleados.php'" title="Volver a la tabla" id="patras" name="patras" type="button" class="botonG2">
			<img src="../img/atras.png" class="imagen" alt="Volver">
	</button>
	
   	</div>
   	</div>
   	




	</form>
<footer>
	<?php include("../muestra/footer.php");?>
</footer>
</main>
</body>
</html>

<?php 
		

} ?>