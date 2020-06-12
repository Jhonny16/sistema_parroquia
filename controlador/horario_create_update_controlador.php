<?php

require_once '../logica/Horario.php';
require_once '../util/funciones/Funciones.php';

try {


    $obj = new Horario();

    $operation = $_POST["operation"];
    $fecha1 = $_POST["fecha_inicial"];
    $fecha2 = $_POST["fecha_final"];
    $obj->setHoraId($_POST["hora"]);
    $obj->setTipocultoId($_POST["tipo_culto"]);
    $obj->setCapillaId($_POST["capilla"]);

    /*PREGUNTAR POR EL TIPO DE OPERACION*/
    if ($operation == "agregar") {
        $respuesta = $obj->create($fecha1,$fecha2);
        if ($respuesta == -1) {
            Funciones::imprimeJSON(203, "Ya existe registro en este horario", "");

        }else{
            if ($respuesta == 1) {
                Funciones::imprimeJSON(200, "Se ha agregado correctamente", "");
            }else{
                Funciones::imprimeJSON(203, "Esta ingresando datos que ya se encuentran registrados. 
            Verifique los parametros seleccionados. Gracias! ", "");

            }
        }


    }

} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}


