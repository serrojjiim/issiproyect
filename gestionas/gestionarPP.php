<?php
function consultarTodosEmpleados($conexion) {
	$consulta = "SELECT * FROM PEDIDOPROVEEDOR";
		
    return $conexion->query($consulta);
}
  ?>