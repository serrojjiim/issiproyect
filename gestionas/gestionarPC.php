<?php


function lineaspedidoC($conexion,$oid_pedcli) {
	$consulta = "SELECT * FROM LINEAPEDIDOCLIENTE WHERE(OID_PEDCLI='$oid_pedcli')";
		
    return $conexion->query($consulta);
}
  ?>