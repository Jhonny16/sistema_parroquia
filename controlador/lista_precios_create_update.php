<?php
/**
 * Created by PhpStorm.
 * User: jhonny
 * Date: 31/05/20
 * Time: 08:01 PM
 */

require_once '../logica/listaPrecios.php';
require_once '../util/funciones/Funciones.php';

try {
    /*CAPTURAR LOS DATOS QUE LLEGAN POR LA VARIABLE $_POST*/
    $capilla_id = $_POST["capilla_id"];
    $tipoculto_id = $_POST["tipoculto_id"];
    $fecha_inicio = $_POST["fecha_inicio"];
    $fecha_fin = $_POST["fecha_fin"];
    $limosna = $_POST["limosna"];
    $templo = $_POST["templo"];
    $cantor = $_POST["cantor"];
    $precio = $_POST["precio"];
    $id = $_POST["id"];
    $operacion = $_POST["operation"];

    if(
        ! isset($capilla_id) ||
        empty($capilla_id) ||

        ! isset($tipoculto_id) ||
        empty($tipoculto_id) ||

        ! isset($fecha_inicio) ||
        empty($fecha_inicio) ||

        ! isset($fecha_fin) ||
        empty($fecha_fin) ||

        ! isset($limosna) ||
        empty($limosna) ||

        ! isset($templo) ||
        empty($templo) ||

        ! isset($cantor) ||
        empty($cantor) ||

        ! isset($precio) ||
        empty($precio)

    ){
        Funciones::imprimeJSON(500, "Falta completar datos requeridos", "");
        exit; //se detiene la aplicacion
    }

    $datetime1 = new DateTime($fecha_inicio);
    $datetime2 = new DateTime($fecha_fin);
    $interval = $datetime1->diff($datetime2);
    $dias = $interval->format('%R%a');
    if ($dias < 0) {
        Funciones::imprimeJSON(203, "La fecha inicial no debe ser mayor a la fecha final", "");
        exit();
    }

    $obj= new listaPrecios();
    $obj->setCapillaId($capilla_id);
    $obj->setTipoCultoId($tipoculto_id);
    $obj->setFechaInicio($fecha_inicio);
    $obj->setFechaFin($fecha_fin);
    $obj->setLimosna($limosna);
    $obj->setTemplo($templo);
    $obj->setCantor($cantor);
    $obj->setPrecio($precio);
    $obj->setId($id);

    if($operacion=="agregar"){
        $res = $obj->create();

        if ($res == true){
            Funciones::imprimeJSON(200, "Se ha agregado correctamente", "");
        }

    }else {

        $res = $obj->update();

        if ($res == true){
            Funciones::imprimeJSON(200, "Se ha actualizado correctamente", "");
        }
    }

} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}


