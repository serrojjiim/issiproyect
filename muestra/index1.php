<?php session_start(); 
if(!isset($_SESSION["cargo"])){
		echo "</p>No tienes permisos para acceder a esta página</p>";
		
	}else{
		$user =  $_SESSION['user']?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="../css/index1.css" />
  <title>Gestión Coenca: TUS DATOS</title>
</head>

<body>
	<?php
	include_once ("header.php");
	?>


	<div>
		<div class="index11"><h1>¡BIENVENIDO <?php echo $_SESSION['nombre']?>!</h1><br />
			
		</div>
		<div class="index12">
			<h3 class="lineadatos1">TUS DATOS:</h3>
			<div class="lineadatos" >
			<div class="dato" style="display: inline-block;width: 30%;">Nombre y apellidos: <?php echo $user['NOMBRE'];echo" ";echo $user['APELLIDOS'];?></div>
			<div class="dato" style="display: inline-block;width: 30%;">DNI: <?php echo $user['DNI']?></div>
			<div class="dato" style="display: inline-block;width: 30%;">Teléfono: <?php echo $user['TELEFONO']?></div>
			</div>
			<div class="lineadatos" >
			<div class="dato" style="display: inline-block;width: 30%;">Dirección: <?php echo $user['DIRECCION'];?></div>
			<div class="dato" style="display: inline-block;width: 30%;">Cargo: <?php echo $_SESSION['cargo']?></div>
			<div class="dato" style="display: inline-block;width: 30%;">Capital social: <?php echo $user['CAPITALSOCIAL']?> €</div>
			</div>
			<div class="lineadatos" >
			<div class="dato" style="display: inline-block;width: 30%;">Fecha de contratación: <?php echo $user['FECHACONTRATACION'];?></div>
			<div class="dato" style="display: inline-block;width: 30%;">Dias de vacaciones: <?php echo $user['DIASVACACIONES']?></div>
			<div class="dato" style="display: inline-block;width: 30%;">Máquina asignada: <?php 
								if($user['OID_MAQ']==""){ echo "Ninguna" ;}else{
									echo $user['OID_MAQ'];
								}?></div>
			</div>
		</div>
	</div>


<footer>
	<?php include("../muestra/footer.php");?>
</footer>
</body>
</html>

<?php } ?>