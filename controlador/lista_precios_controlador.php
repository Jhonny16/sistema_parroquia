<?php

require_once '../logica/listaPrecios.php';
require_once '../util/funciones/Funciones.php';


$parroquia_id = $_POST["parroquia_id"];
$rol_id = $_POST["rol_id"];

try {

    $object = new listaPrecios();
    //$object->setCapillaId($capilla_id);

    $resultado = $object->listar($parroquia_id,$rol_id);
    if($resultado){
        Funciones::imprimeJSON(200, "", $resultado);// JSON permite compartir datos entre aplicaciones; 200 CORRECTO
    }else{
        Funciones::imprimeJSON(203, "No hubo resultados en la busqueda","");

    }

} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");

}
