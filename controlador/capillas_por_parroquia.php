<?php
/**
 * Created by PhpStorm.
 * User: jhonny
 * Date: 12/05/19
 * Time: 12:30 PM
 */
require_once '../logica/Capilla.php';
require_once '../util/funciones/Funciones.php';

try {
    $parroquia = $_POST['parroquia'];
    $rol_id = $_POST['rol_id'];
    $obj = new Capilla();
    $resultado = $obj->listar_por_parroquia($parroquia, $rol_id);
    Funciones::imprimeJSON(200, "", $resultado);// JSON permite compartir datos entre aplicaciones; 200 CORRECTO


} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");

}
