<?php

require_once '../logica/Horario.php';
require_once '../util/funciones/Funciones.php';

try {

    $horario_id = $_POST["horario_id"];
    $padre_dni = $_POST["padre_dni"];
    $cantor_dni = $_POST["cantor_dni"];

    $obj = new Horario();
    $obj->setId($horario_id);
    $obj->setPadreDni($padre_dni);
    $obj->setCantorDni($cantor_dni);
    $respuesta = $obj->update_padre_cantor();
    if ($respuesta) {
        Funciones::imprimeJSON(200, "Actualización exitosa", "");
    }
    else{
        Funciones::imprimeJSON(203, "Problemas al momento de eliminar", "");
    }

} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}
