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
	<form method="post" action="../controladores/controlador_modificarempleados.php">
	<input id="OID_EMP" name="OID_EMP" type="text" value="<?php echo $empleado["OID_EMP"]; ?>"/><br />
	<input id="NOMBRE" name="NOMBRE" type="text" value="<?php echo $empleado["NOMBRE"]; ?>"/><br />
	<input id="APELLIDOS" name="APELLIDOS" type="text" value="<?php echo $empleado["APELLIDOS"]; ?>"/><br />
	<input pattern="^[0-9]{8}[A-Z]" id="DNI" name="DNI" type="text" value="<?php echo $empleado["DNI"]; ?>"/><br />
	<input pattern="^[0-9]{9}" id="TELEFONO" name="TELEFONO" type="text" value="<?php echo $empleado["TELEFONO"]; ?>"/><br />
	<input id="DIRECCION" name="DIRECCION" type="text" value="<?php echo $empleado["DIRECCION"]; ?>"/><br />
	
	<select id="CARGO" name="CARGO">
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
   	<br />

	<input pattern="(0[1-9]|1[0-9]|2[0-9]|3[01])/(0[1-9]|1[012])/[0-9]{2}" id="FECHACONTRATACION" name="FECHACONTRATACION" type="text" value="<?php echo $empleado["FECHACONTRATACION"]; ?>"/><br />
	<input id="CAPITALSOCIAL" name="CAPITALSOCIAL" type="text" value="<?php echo $empleado["CAPITALSOCIAL"]; ?>"/><br />
	<input id="DIASVACACIONES" name="DIASVACACIONES" type="text" value="<?php echo $empleado["DIASVACACIONES"]; ?>"/><br />
	
	<select id="OID_MAQ" name="OID_MAQ">
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
	<button id="guardar" name="guardar" type="submit" class="editar_fila">
			<img src="../img/bag_menuito.bmp" class="editar_fila" alt="Modificar cargo empleado">
	</button>
	<button id="patras" name="patras" type="submit" class="editar_fila">
			<img src="../img/back.png" class="editar_fila" alt="Modificar cargo empleado">
	</button>



	</form>
	<?php } ?>
</main>
</body>
</html>