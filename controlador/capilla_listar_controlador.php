<?php

require_once '../logica/Capilla.php';
require_once '../util/funciones/Funciones.php';

try {
    $obj = new Capilla();
    $resultado = $obj->listar();
    Funciones::imprimeJSON(200, "", $resultado);// JSON permite compartir datos entre aplicaciones; 200 CORRECTO


} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");

}


