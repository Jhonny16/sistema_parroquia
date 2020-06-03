<?php
require_once '../logica/Asignacion.php';
require_once '../util/funciones/Funciones.php';

try {
    $dni = $_POST["dni"];
    $obj = new Asignacion();
    $resultado = $obj->lista_capillas_por_persona($dni);
    Funciones::imprimeJSON(200, "", $resultado);// JSON permite compartir datos entre aplicaciones; 200 CORRECTO


} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");

}