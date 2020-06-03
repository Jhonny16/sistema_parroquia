<?php
/**
 * Created by PhpStorm.
 * User: jhonny
 * Date: 01/06/20
 * Time: 07:17 PM
 */
require_once '../logica/reserva.php';
require_once '../util/funciones/Funciones.php';

$fecha= $_POST["fecha"];
$parroquia_id = $_POST["parroquia_id"];

try {

    $obj = new reserva();
    $resultado = $obj->listar($fecha,$parroquia_id);
    if($resultado){
        Funciones::imprimeJSON(200, "", $resultado);

    }else{
        Funciones::imprimeJSON(203, "No hubo resultados en la búsqueda. ", $resultado);

    }


} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");

}
