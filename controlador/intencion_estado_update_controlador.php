<?php

require_once '../logica/Intencion.class.php';
require_once '../util/funciones/Funciones.php';

try {

    $estado = $_POST["estado"];
    $intencion_id = $_POST["intencion_id"];

    $obj = new Intencion();
    $obj->setEstado($estado);
    $obj->setId($intencion_id);
    $respuesta = $obj->update_estado();
    if ($respuesta) {//pregunta si la respuesta es TRUE
        Funciones::imprimeJSON(200, "Actualizacion exitosa", "");
    }
    else{
        Funciones::imprimeJSON(203, "Problemas al momento de actualizar", "");
    }

} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}
