<?php

require_once '../logica/Intencion.class.php';
require_once '../util/funciones/Funciones.php';

try {
    $datosJSONDetalle = $_POST["p_datosJSONDetalle"];

    $tipoOperacion = $_POST["operation"];

    /*INSTANCIAR LA CLASE PARROQUIA*/
    $objParroquia = new Intencion();

    /*ENVIAR LOS DATOS RECIBIDOS DEL FORMULARIO HACIA LA CLASE*/
    $objParroquia->setCosto($_POST["p_total"]);
    $objParroquia->setFecha($_POST["p_fecha"]);
    $objParroquia->setHora($_POST["p_hora"]);
    $objParroquia->setCapId($_POST["p_capilla"]);
    $objParroquia->setAnio($_POST["p_anio"]);
    $objParroquia->setDetalle($datosJSONDetalle);

    /*PREGUNTAR POR EL TIPO DE OPERACION*/
    if ($tipoOperacion == "agregar") {
        $respuesta = $objParroquia->create();

        if ($respuesta == true) {
            Funciones::imprimeJSON(200, "Se ha agregado correctamente", "");
        }

    } else {

    }

} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}


