<?php

require_once '../logica/Horario.php';
require_once '../util/funciones/Funciones.php';

try {

    $array_horarios = $_POST["array"];

    $obj = new Horario();
    $respuesta = $obj->eliminar($array_horarios);
    if ($respuesta) {//pregunta si la respuesta es TRUE
        Funciones::imprimeJSON(200, "Eliminación exitosa", "");
    }
    else{
        Funciones::imprimeJSON(203, "Problemas al momento de eliminar", "");
    }

} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}
