<?php

require_once 'conexion_base_datos.php';

$conexion = conexionBaseDatos();

if(isset($_POST['email'])){
    $email = $_POST['email'];

    

    $consulta = "SELECT * FROM usuarios WHERE email = '$email'";
    $resultado = $conexion->query($consulta);
    $id_usuario = "";

    while ($fila = $resultado-> fetch_assoc()){
        $id_usuario = $fila["id_usuario"];
    }


    $consulta = "SELECT i.* FROM incidencias i JOIN compra c ON i.id_compra = c.id_compra WHERE c.id_usuario = '$id_usuario'";
    $resultado = $conexion->query($consulta);

    if($resultado->num_rows > 0){

        $json = "[";

        while ($fila = $resultado-> fetch_assoc()){
            $json .= "{";
            $json .= "\"id_incidencia\" : \"".$fila["id_incidencia"]."\",";
            $json .= "\"id_compra\" : \"".$fila["id_compra"]."\",";
            $json .= "\"asunto\" : \"".addslashes($fila["asunto"])."\",";
            $json .= "\"consulta\" : \"".addslashes($fila["consulta"])."\",";
            $json .= "\"estado\" : \"".$fila["estado"]."\",";//1 hay stock 0 no hay stock
            $json .= "\"fecha\" : \"".$fila["fecha"]."\"";
            $json .= "},";
        }
        $json = substr($json, 0, strlen($json)-1);
        echo $json."]";

    }else{
        echo "";
    }
}else{
    echo "Algo ha fallado. Inténtelo de nuevo más tarde.";
}



$conexion->close();
?>