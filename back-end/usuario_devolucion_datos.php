<?php
$conexion = new mysqli("localhost", "root", "", "tienda");

$id_compra = $_POST["id_pedido"];

$consulta = "SELECT * FROM compra_productos WHERE id_compra = '$id_compra'";
$resultado = $conexion->query($consulta);

$json = "[{\"id_compra\" : \"".$id_compra."\"},";

while ($fila = $resultado-> fetch_assoc()){
    $json .= "{";
    $json .= "\"id_producto\" : \"".$fila["id_producto"]."\",";
    $json .= "\"cantidad\" : \"".$fila["cantidad"]."\",";

    $id_producto = $fila["id_producto"];
    $consulta2 = "SELECT * FROM productos WHERE id_producto = '$id_producto'";
    $resultado2 = $conexion->query($consulta2);
    $nombre = $resultado2-> fetch_assoc()["nombre"];

    $json .= "\"nombre\" : \"".$nombre."\"";
    $json .= "},";
}
$json = substr($json, 0, strlen($json)-1);
echo $json."]";

?>