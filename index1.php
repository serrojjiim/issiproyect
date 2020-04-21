<?php session_start(); 
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="css/biblio.css" />
  <title>Gestión de biblioteca: Login</title>
</head>

<body>
<p>Hola <?php echo $_SESSION['nombre']?> , tu cargo es <?php echo $_SESSION['cargo']?></p>
</body>
</html>

