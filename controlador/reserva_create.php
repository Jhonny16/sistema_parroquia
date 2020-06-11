<?php

require_once '../logica/reserva.php';
require_once '../util/funciones/Funciones.php';

try {


    $obj = new reserva();

    $obj->setEstado($_POST["estado"]);
    $obj->setOfrece($_POST["ofrece"]);
    $obj->setTotal($_POST["total"]);
    $obj->setClienteDni($_POST["cliente_dni"]);
    $obj->setHorarioId($_POST["horario_id"]);
    $obj->setDetalleReserva($_POST["detalle"]);

    $respuesta = $obj->create();

    if ($respuesta > 0) {
        Funciones::imprimeJSON(200, "Se ha realizado con exito la reserva", $respuesta);
    } else {
        Funciones::imprimeJSON(203, "Error al guardar", "");
    }


} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}


