<?php session_start(); 
if(!isset($_SESSION["cargo"])){
		echo "</p>No tienes permisos para acceder a esta página</p>";
		
	}else{?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="css/dropdown.css" />
  <title>Gestión de biblioteca: Login</title>
</head>

<body>
	<?php
	include_once ("header.php");
	?>
	<!-- <script>
		function despligue() {
  document.getElementById("myDropdown").classList.toggle("show");
}

window.onclick = function(event) {
  if (!event.target.matches('.dropbtn')) {
    var dropdowns = document.getElementsByClassName("dropdown-content");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }
    }
  }
	}
	</script> -->
<!-- <div class="dropdown">
	<?php if($_SESSION['cargo']=="GERENTEVENTAS"){
		
	?>
  <button onclick="despligue()" class="dropbtn">Dropdown</button>
  <div id="myDropdown" class="dropdown-content">
    <a href="vistas/gerenteVentas/pruebaGV.php">Prueba</a>
    <a href="#">Link 2</a>
    <a href="#">Link 3</a>
  </div>
  <?php }else{ ?>
  	  <button onclick="despligue()" class="dropbtn">Dropdown</button>
  <div id="myDropdown" class="dropdown-content">
    <a href="#">xd</a>
    <a href="#">xd</a>
    <a href="#">xd</a>
  </div>
  <?php  }  ?> 
</div> -->
<p>Hola <?php echo $_SESSION['nombre']?></p>
<p>Hola <?php echo $_SESSION['dni']?></p>
<p>Hola <?php echo $_SESSION['cargo']?></p>
<p>Hola <?php echo $_SESSION['oid_emp']?></p>
</body>
</html>

<?php } ?>