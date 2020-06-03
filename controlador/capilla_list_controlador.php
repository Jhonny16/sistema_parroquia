<?php
/**
 * Created by PhpStorm.
 * User: jhonny
 * Date: 09/05/19
 * Time: 11:59 PM
 */
require_once '../logica/Capilla.php';
require_once '../util/funciones/Funciones.php';

try {
    $obj = new Capilla();
    $resultado = $obj->lista();
    Funciones::imprimeJSON(200, "", $resultado);// JSON permite compartir datos entre aplicaciones; 200 CORRECTO


} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");

}