<?php
if(!isset($_SESSION["cargo"])){
		echo "</p>No tienes permisos para acceder a esta página</p>";
		
	}else{ ?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
 <link rel="stylesheet" type="text/css" href="../css/header.css" />
</head>
<body>
	
<?php if($_SESSION['cargo']=="GERENTEVENTAS"){?>
<ul class="topnav">
  <li class="logo"><a href="index1.php"><img border="0" alt="Logout" src="../img/header/logocoenca.png" width="40" height="30"></a></li>
  <li class="letras"><a class="letras" href="../muestra/muestraPedidosClientes.php">PEDIDOS DE CLIENTES</a></li>
  <li class="letras"><a class="letras" href="../muestra/muestraCliente.php">CLIENTES</a></li>
  <li class="right"><a href="../logout.php">
<img border="0" alt="Logout" src="../img/header/logout.png" width="22" height="22">
</a></li>
   <?php }else if($_SESSION['cargo']=="GERENTECOMPRAS"){ ?>
<ul class="topnav">
  <li class="logo"><a href="index1.php"><img border="0" alt="Logout" src="../img/header/logocoenca.png" width="40" height="30"></a></li>
  <li class="letras"><a class="letras" href="../muestra/muestraPedidosProveedores.php">PEDIDOS A PROVEEDORES</a></li>
  <li class="letras"><a class="letras" href="../muestra/muestraProveedor.php">PROVEEDORES</a></li>
  <li class="right"><a href="../logout.php">
<img border="0" alt="Logout" src="../img/header/logout.png" width="22" height="22">
</a></li>
</ul>
  <?php }else if($_SESSION['cargo']=="PEON" or $_SESSION['cargo']=="JEFEMAQUINA"){ ?>
<ul class="topnav">
  <li class="logo"><a href="index1.php"><img border="0" alt="Logout" src="../img/header/logocoenca.png" width="40" height="30"></a></li>
  <li class="letras"><a class="letras" href="#news">MI MAQUINA</a></li>
  <li class="letras"><a class="letras" href="../muestra/peticiondias.php">SOLICITAR DIAS</a></li>
   <li class="right"><a href="../logout.php">
<img border="0" alt="Logout" src="../img/header/logout.png" width="22" height="22">
</a></li>
</ul>
  <?php }else if($_SESSION['cargo']=="CAMIONERO"){ ?>
<ul class="topnav">
  <li class="logo"><a href="index1.php"><img border="0" alt="Logout" src="../img/header/logocoenca.png" width="40" height="30"></a></li>
  <li class="letras"><a class="letras" href="../muestra/muestraCamiones.php">CAMIONES</a></li>
  <li class="letras"><a class="letras" href="../muestra/peticiondias.php">SOLICITAR DIAS</a></li>
  <li class="letras"><a class="letras" href="../muestra/muestraCliente.php">CLIENTES</a></li>
  <li class="right"><a href="../logout.php">
<img border="0" alt="Logout" src="../img/header/logout.png" width="22" height="22">
</a></li>
</ul>
  <?php }else if($_SESSION['cargo']=="JEFEPERSONAL"){ ?>
<ul class="topnav">
  <li class="logo"><a href="index1.php"><img border="0" alt="Logout" src="../img/header/logocoenca.png" width="40" height="30"></a></li>
  <li class="letras"><a class="letras" href="../muestra/muestraEmpleados.php">EMPLEADOS</a></li>
  <li class="letras"><a class="letras" href="../muestra/muestraMaquinas.php">MÁQUINAS</a></li>
  <li class="letras"><a class="letras" href="../muestra/solicitudesdedias.php">SOLICITUDES DE DIAS</a></li>
   <li class="letras"><a class="letras" href="../muestra/peticiondias.php">SOLICITAR DIAS</a></li>
   <li class="right"><a href="../logout.php">
<img border="0" alt="Logout" src="../img/header/logout.png" width="22" height="22">
</a></li>
</ul>
  <?php }else if($_SESSION['cargo']=="CAPATAZ"){ ?>
<ul class="topnav">
  <li class="logo"><a href="index1.php"><img border="0" alt="Logout" src="../img/header/logocoenca.png" width="40" height="30"></a></li>
  <li class="letras"><a class="letras" href="#news">MÁQUINAS</a></li>
  <li class="letras"><a class="letras" href="../muestra/muestraPedidosClientes.php">PEDIDOS DE CLIENTES</a></li>
  <li class="letras"><a class="letras" href="../muestra/muestraEmpleados.php">EMPLEADOS</a></li>
  <li class="right"><a href="../logout.php">
<img border="0" alt="Logout" src="../img/header/logout.png" width="22" height="22">
</a></li>
</ul>
  <?php }else if($_SESSION['cargo']=="PRESIDENTE" or $_SESSION['cargo']=="VICEPRESIDENTE"){ ?>
<ul class="topnav">
  <li class="logo"><a href="index1.php"><img border="0" alt="Logout" src="../img/header/logocoenca.png" width="40" height="30"></a></li>
  <li class="letras"><a class="letras" href="../muestra/muestraPedidosClientes.php">PEDIDOS DE CLIENTES</a></li>
  <li class="letras"><a class="letras" href="../muestra/muestraCliente.php">CLIENTES</a></li>
  <li class="letras"><a class="letras" href="../muestra/muestraPedidosProveedores.php">PEDIDOS A PROVEEDORES</a></li>
  <li class="letras"><a class="letras" href="../muestra/muestraProveedor.php">PROVEEDORES</a></li>
  <li class="letras"><a class="letras" href="../muestra/muestraMaquinas.php">MAQUINAS</a></li>
  <li class="letras"><a class="letras" href="../muestra/muestraEmpleados.php">EMPLEADOS</a></li>
  <li class="letras"><a class="letras" href="../muestra/muestraCamiones.php">CAMIONES</a></li>
  <li class="letras"><a class="letras" href="../muestra/muestraAlmacen.php">ALMACÉN</a></li>
  <li class="letras"><a class="letras" href="../muestra/peticiondias.php">PETICION DIAS</a></li>

  <li class="right"><a href="../logout.php">
<img border="0" alt="Logout" src="../img/header/logout.png" width="22" height="22">
</a></li>
</ul>
  <?php }else if($_SESSION['cargo']=="SECRETARIO"){ ?>
<ul class="topnav">
  <li class="logo"><a href="index1.php"><img border="0" alt="Logout" src="../img/header/logocoenca.png" width="40" height="30"></a></li>
  <li class="letras"><a class="letras" href="../muestra/peticiondias.php">SOLICITAR DIAS</a></li>
   <li class="right"><a href="../logout.php">
<img border="0" alt="Logout" src="../img/header/logout.png" width="22" height="22">
</a></li>
</ul>
  <?php }else if($_SESSION['cargo']=="TESORERO"){ ?>
<ul class="topnav">
  <li class="logo"><a href="index1.php"><img border="0" alt="Logout" src="../img/header/logocoenca.png" width="40" height="30"></a></li>
  <li class="letras"><a class="letras" href="../muestra/muestraPedidosClientes.php">PEDIDOS DE CLIENTES</a></li>
  <li class="letras"><a class="letras" href="../muestra/muestraPedidosProveedores.php">PEDIDOS A PROVEEDORES</a></li>
  <li class="right"><a href="../logout.php">
<img border="0" alt="Logout" src="../img/header/logout.png" width="22" height="22">
</a></li>
</ul>
  <?php  }  ?> 

</body>
</html>
 <?php  }  ?>