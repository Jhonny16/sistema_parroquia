<?php
/**
 * Created by PhpStorm.
 * User: jhonny
 * Date: 02/06/20
 * Time: 01:49 PM
 */
require_once '../logica/reserva.php';
require_once '../util/funciones/Funciones.php';

$horario_id = $_POST["horario_id"];
$reserva_id = $_POST["reserva_id"];
$persona_dni = $_POST["persona_dni"];

try {

    $obj = new reserva();
    $obj->setHorarioId($horario_id);
    $obj->setId($reserva_id);
    $obj->setClienteDni($persona_dni);

    $resultado = $obj->listar_por_horario();
    if($resultado){
        Funciones::imprimeJSON(200, "", $resultado);

    }else{
        Funciones::imprimeJSON(203, "", $resultado);

    }


} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");

}
