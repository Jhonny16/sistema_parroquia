<?php
/**
 * Created by PhpStorm.
 * User: jhonny
 * Date: 12/05/19
 * Time: 03:31 PM
 */
require_once '../logica/Asignacion.php';
require_once '../util/funciones/Funciones.php';

try {
    $dni = $_POST["dni"];
    $obj = new Asignacion();
    $resultado = $obj->read($dni);
    if($resultado){
        Funciones::imprimeJSON(200, "", $resultado);
    }else{
        Funciones::imprimeJSON(203, "Error en la consulta", $resultado);
    }



} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}
