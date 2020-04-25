<?php	
	session_start();	
	
	if (isset($_SESSION["empleado"])) {
		$empleado = $_SESSION["empleado"];
		
	
		

?>


<!DOCTYPE html>
<html>
<head>
 <link rel="stylesheet" type="text/css" href="css/header.css" />
 <link rel="stylesheet" type="text/css" href="css/modificarForm.css" />
</head>
<body>
<main>
		<div align="center" class="divMod">
	<div>

	<form method="post" action="../controladores/controlador_modificarempleados.php">
	<input class="inMod" id="OID_EMP" name="OID_EMP" type="hidden" value="<?php echo $empleado["OID_EMP"]; ?>"/><br />
	
	<div class="lineaxd">
	<div>
	<label class="textoMod2">Nombre</label></br>		
	<input class="inMod2" id="NOMBRE" name="NOMBRE" type="text" value="<?php echo $empleado["NOMBRE"]; ?>"/><br />
	</div>
	
	<div>
	<label class="textoMod3">Apellidos</label></br>	
	<input class="inMod3" id="APELLIDOS" name="APELLIDOS" type="text" value="<?php echo $empleado["APELLIDOS"]; ?>"/><br />
	</div>
	</div>
	
	<div>
	<label class="textoMod">Direccion</label></br>	
	<input class="inMod" id="DIRECCION" name="DIRECCION" type="text" value="<?php echo $empleado["DIRECCION"]; ?>"/><br />
	</div>
	
	
	
	<div class="lineaxd">
	<div>
	<label class="textoMod2">Dni</label></br>	
	<input class="inMod2" pattern="^[0-9]{8}[A-Z]" id="DNI" name="DNI" type="text" value="<?php echo $empleado["DNI"]; ?>"/><br />
	</div>
	<div>
	<label class="textoMod3">Telefono</label></br>	
	<input class="inMod3" pattern="^[0-9]{9}" id="TELEFONO" name="TELEFONO" type="text" value="<?php echo $empleado["TELEFONO"]; ?>"/><br />
	</div>
	</div>	

	
	
	<div>
	<label class="textoMod">Fecha de contratacion</label></br>	
	<input class="inMod" pattern="(0[1-9]|1[0-9]|2[0-9]|3[01])/(0[1-9]|1[012])/[0-9]{2}" id="FECHACONTRATACION" name="FECHACONTRATACION" type="text" value="<?php echo $empleado["FECHACONTRATACION"]; ?>"/><br />
	</div>
	
	<div>
	<label class="textoMod">Capital Social</label></br>	
	<input class="inMod" id="CAPITALSOCIAL" name="CAPITALSOCIAL" type="text" value="<?php echo $empleado["CAPITALSOCIAL"]; ?>"/><br />
	</div>
	
	<div>
	<label class="textoMod">Dias de vacaciones</label></br>	
	<input class="inMod" id="DIASVACACIONES" name="DIASVACACIONES" type="text" value="<?php echo $empleado["DIASVACACIONES"]; ?>"/><br/>
	</div>
	
	 	<div>
	<label class="textoMod">Cargo</label></br>	
	<select  align="center" class="seleccion" id="CARGO" name="CARGO">
     	<option value="1"<?php if($empleado['CARGO']==1) echo "selected"; ?>>Presidente</option> 
    	<option value="2"<?php if($empleado['CARGO']==2) echo "selected"; ?>>Vicepresidente</option> 
    	<option value="3"<?php if($empleado['CARGO']==3) echo "selected"; ?>>Secretario</option>
    	<option value="4"<?php if($empleado['CARGO']==4) echo "selected"; ?>>Tesorero</option> 
    	<option value="5"<?php if($empleado['CARGO']==5) echo "selected"; ?>>Gerente de Ventas</option> 
    	<option value="6"<?php if($empleado['CARGO']==6) echo "selected"; ?>>Gerente de Compras</option> 
    	<option value="7"<?php if($empleado['CARGO']==7) echo "selected"; ?>>Capataz</option> 
    	<option value="8"<?php if($empleado['CARGO']==8) echo "selected"; ?>>Jefe de Personal</option> 
    	<option value="9"<?php if($empleado['CARGO']==9) echo "selected"; ?>>Jefe de Máquina</option> 
    	<option value="10"<?php if($empleado['CARGO']==10) echo "selected"; ?>>Peón</option> 
    	<option value="11"<?php if($empleado['CARGO']==11) echo "selected"; ?>>Camionero</option> 
    	</select>
  
	</div>
	
	
	
	<div>
	<label class="textoMod">Maquina</label></br>	
	<select class="seleccion" id="OID_MAQ" name="OID_MAQ">
     	<option value="1"<?php if($empleado['OID_MAQ']==1) echo "selected"; ?>>Pintura</option> 
    	<option value="2"<?php if($empleado['OID_MAQ']==2) echo "selected"; ?>>Fresadora</option> 
    	<option value="3"<?php if($empleado['OID_MAQ']==3) echo "selected"; ?>>Serigrafiadora</option>
    	<option value="4"<?php if($empleado['OID_MAQ']==4) echo "selected"; ?>>Caldera</option> 
    	<option value="5"<?php if($empleado['OID_MAQ']==5) echo "selected"; ?>>Robot</option> 
    	<option value="6"<?php if($empleado['OID_MAQ']==6) echo "selected"; ?>>Bajeras</option> 
    	<option value="7"<?php if($empleado['OID_MAQ']==7) echo "selected"; ?>>Robot2</option> 
    	<option value="8"<?php if($empleado['OID_MAQ']==8) echo "selected"; ?>>Pintura2</option> 
    	<option value="9"<?php if($empleado['OID_MAQ']==9) echo "selected"; ?>>Almacen1</option> 
    	<option value="10"<?php if($empleado['OID_MAQ']==10) echo "selected"; ?>>Almacen2</option> 
    	<option value="10"<?php if($empleado['OID_MAQ']==null) echo "selected"; ?>>Ninguna</option> 

    	</select>
    	
   	<br />
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
			
		echo "<div align=\"center\" class=\"error\"><p>¡El empleado ha sido modificado correctamente!</p></div>";
		
	}  
	?>
	<?php } ?>
</main>
</body>
</html>