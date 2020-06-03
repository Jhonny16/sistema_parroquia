<?php


require_once '../logica/Capilla.php';
require_once '../util/funciones/Funciones.php';

try {
    $dni = $_POST['dni'];
    $obj = new Capilla();
    $resultado = $obj->listar_group_parroquia($dni);
    Funciones::imprimeJSON(200, "", $resultado);// JSON permite compartir datos entre aplicaciones; 200 CORRECTO


} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");

}

