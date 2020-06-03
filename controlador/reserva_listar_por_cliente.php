<?php
require_once '../logica/Intencion.class.php';
require_once '../util/funciones/Funciones.php';

$fecha_inicio= $_POST["fecha_inicio"];
$fecha_fin = $_POST["fecha_fin"];
$dni = $_POST["dni"];
try {

    $obj = new Intencion();
    $resultado = $obj->listar_por_cliente($fecha_inicio,$fecha_fin,$dni);
    if($resultado){
        Funciones::imprimeJSON(200, "", $resultado);// JSON permite compartir datos entre aplicaciones; 200 CORRECTO

    }else{
        Funciones::imprimeJSON(203, "", $resultado);// JSON permite compartir datos entre aplicaciones; 200 CORRECTO

    }


} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");

}
