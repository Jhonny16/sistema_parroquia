<?php
require_once '../logica/Asignacion.php';
require_once '../util/funciones/Funciones.php';

try {
    $parroquia_id = $_POST["parroquia_id"];
    $rol_id = $_POST["rol_id"];
    $obj = new Asignacion();
    $resultado = $obj->lista($parroquia_id,$rol_id);
    Funciones::imprimeJSON(200, "", $resultado);// JSON permite compartir datos entre aplicaciones; 200 CORRECTO


} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");

}