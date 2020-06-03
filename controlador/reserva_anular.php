<?php
/**
 * Created by PhpStorm.
 * User: jhonny
 * Date: 02/06/20
 * Time: 09:44 PM
 */

require_once '../logica/reserva.php';
require_once '../util/funciones/Funciones.php';

try {


    $obj = new reserva();

    $obj->setId($_POST["reserva_id"]);


    $respuesta = $obj->anular();

    if ($respuesta > 0) {
        Funciones::imprimeJSON(200, "Se anuló la reserva.", $respuesta);
    } else {
        Funciones::imprimeJSON(203, "Error al guardar", "");
    }


} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}



