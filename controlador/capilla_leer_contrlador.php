<?php
/**
 * Created by PhpStorm.
 * User: jhonny
 * Date: 10/05/19
 * Time: 01:04 AM
 */
require_once '../logica/Capilla.php';
require_once '../util/funciones/Funciones.php';

try {

    $id = $_POST["p_id"];

    $obj = new Capilla();
    $resultado = $obj->read($id);
    Funciones::imprimeJSON(200, "", $resultado);



} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");

}
