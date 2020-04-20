<?php
function consultarTodosEmpleados($conexion) {
	$consulta = "SELECT * FROM PEDIDOCLIENTE";
		
    return $conexion->query($consulta);
}
  ?>