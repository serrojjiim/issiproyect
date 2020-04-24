<?php
	session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <!-- <link rel="stylesheet" type="text/css" href="css/biblio.css" /> -->
    	<!-- <script type="text/javascript" src="./js/boton.js"></script> -->
  <title>Peticion de dias</title>
</head>

<body>
	<?php
		include_once ("header.php"); ?>

	<p>DNI <?php echo $_SESSION['dni']?></p>

	<form method="post" action="../controladores/controlador_solicituddias.php" id="FORMULARIOPETICIONDIAS">
	<input id="DNI" name="DNI" type="hidden" value="<?php echo $_SESSION["dni"]; ?>"/>
	<input id="DIASAPEDIR" name="DIASAPEDIR" type="text" value=""/><br />
	<button id="PEDIR" name="PEDIR" type="submit" class="editar_fila">
			<img src="img/bag_menuito.bmp" class="editar_fila" alt="SOLICITAR DIAS">
	</button>

	</form>
	<textarea name="MOTIVO" form="FORMULARIOPETICIONDIAS">Enter text here...</textarea>

</body>
</html>