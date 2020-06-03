<?php
/**
 * Created by PhpStorm.
 * User: jhonny
 * Date: 02/06/20
 * Time: 01:00 PM
 */
require_once '../logica/pago.php';
require_once '../util/funciones/Funciones.php';

try {


    $obj = new pago();

    $obj->setReservaId($_POST["reserva_id"]);


    $respuesta = $obj->create();

    if ($respuesta > 0) {
        Funciones::imprimeJSON(200, "Se ha realizado el pago de la reserva", $respuesta);
    } else {
        Funciones::imprimeJSON(203, "Error al guardar", "");
    }


} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}


