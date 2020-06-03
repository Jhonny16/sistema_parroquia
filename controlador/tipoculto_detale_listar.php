<?php
/**
 * Created by PhpStorm.
 * User: jhonny
 * Date: 19/05/19
 * Time: 05:40 PM
 */
require_once '../logica/TipoCultoDetalle.php';
require_once '../util/funciones/Funciones.php';

try {
    $objTipoCulto = new TipoCultoDetalle();
    $resultado = $objTipoCulto->listar();
    Funciones::imprimeJSON(200, "", $resultado);// JSON permite compartir datos entre aplicaciones; 200 CORRECTO


} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");

}