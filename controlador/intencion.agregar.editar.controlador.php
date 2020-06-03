<?php

require_once '../logica/Intencion.class.php';
require_once '../util/funciones/Funciones.php';

try {
    $datosJSONDetalle = $_POST["detalle"];

    $operacion = $_POST['operacion'];
    $reserva_id = $_POST['reserva_id'];

    /*INSTANCIAR LA CLASE PARROQUIA*/
    $obj = new Intencion();

    /*ENVIAR LOS DATOS RECIBIDOS DEL FORMULARIO HACIA LA CLASE*/
    $obj->setPadre($_POST["padre"]);
    $obj->setCliente($_POST["cliente"]);
    $obj->setTotal($_POST["total"]);
    $obj->setEstado($_POST["estado"]);
    $obj->setCapilla($_POST["capilla"]);
    $obj->setCantor($_POST["cantor"]);
    $obj->setOfrece($_POST["ofrece"]);
    $obj->setDetail($_POST["detail"]);
    $obj->setDetalle($datosJSONDetalle);

    if($operacion == 'create'){
        $respuesta = $obj->create();

        if ($respuesta > 0) {
            Funciones::imprimeJSON(200, "Se ha realizado con exito la reserva", $respuesta);
        }else{
            Funciones::imprimeJSON(203, "Error al guardar", "");
        }
    }else{
        $obj->setId($reserva_id);
        $respuesta = $obj->update();
        if ($respuesta == true) {
            Funciones::imprimeJSON(200, "Se ha actualizado la reserva", "");
        }else{
            Funciones::imprimeJSON(203, "Error al actualizar", "");
        }

    }

    /*PREGUNTAR POR EL TIPO DE OPERACION*/


} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}


