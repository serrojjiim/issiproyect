<?php
function consultarTodosEmpleados($conexion) {
	$consulta = "SELECT * FROM EMPLEADO";
		
    return $conexion->query($consulta);
}
  ?>