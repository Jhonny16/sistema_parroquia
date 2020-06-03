<?php
/**
 * Created by PhpStorm.
 * User: jhonny
 * Date: 02/06/20
 * Time: 01:49 PM
 */
require_once '../logica/reserva.php';
require_once '../util/funciones/Funciones.php';

$parroquia_id = $_POST["parroquia_id"];

try {

    $obj = new reserva();


    $resultado = $obj->listar_por_horario_filtros($parroquia_id);
    if($resultado){
        Funciones::imprimeJSON(200, "", $resultado);

    }else{
        Funciones::imprimeJSON(203, "", $resultado);

    }


} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");

}
