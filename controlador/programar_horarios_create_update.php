<?php

require_once '../logica/HorarioProgramado.class.php';
require_once '../util/funciones/Funciones.php';

try {
    /*VALIDAR SI ESTAN LLEGANDO TODOS LOS DATOS NECESARIOS PARA GRABAR (AGREGAR/EDITAR)*/

    $domingo = $_POST["domingo"];
    $lunes = $_POST["lunes"];
    $martes = $_POST["martes"];
    $miercoles = $_POST["miercoles"];
    $jueves = $_POST["jueves"];
    $viernes = $_POST["viernes"];
    $sabado = $_POST["sabado"];
    $hora = $_POST["hora"];
    $capilla = $_POST["capilla"];
    $anio = $_POST["anio"];
    $tipoOperacion = $_POST["operation"];

    $obj = new HorarioProgramado();

    $obj->setHp_domingo($domingo);
    $obj->setHp_lunes($lunes);
    $obj->setHp_martes($martes);
    $obj->setHp_miercoles($miercoles);
    $obj->setHp_jueves($jueves);
    $obj->setHp_viernes($viernes);
    $obj->setHp_sabado($sabado);
    $obj->setHora_id($hora);
    $obj->setCap_id($capilla);
    $obj->setAnno_nombre($anio);


    /*PREGUNTAR POR EL TIPO DE OPERACION*/
    if ($tipoOperacion == "agregar") {
        $respuesta = $obj->create();
        if ($respuesta == true) {
            Funciones::imprimeJSON(200, "Se ha agregado correctamente", "");
        }
    } else {
        //AQUI SE TIENE QUE LLAMAR AL METODO EDITAR

        $respuesta = $objCargo->editar();

        if ($respuesta == true) {
            Funciones::imprimeJSON(200, "Se ha actualizado correctamente", "");
        }
    }

} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}


