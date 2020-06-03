<?php
/**
 * Created by PhpStorm.
 * User: jhonny
 * Date: 02/05/19
 * Time: 09:16 PM
 */

try {
    require_once '../logica/Usuario.php';
    require_once '../util/funciones/Funciones.php';

    $id = $_POST["p_id"];
    $obj = new Usuario();
    $resultado = $obj->read($id);
    Funciones::imprimeJSON(200, "", $resultado);

} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");

}