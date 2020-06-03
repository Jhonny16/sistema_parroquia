<?php
/**
 * Created by PhpStorm.
 * User: jhonny
 * Date: 19/05/19
 * Time: 06:24 PM
 */
require_once '../logica/TipoCultoDetalle.php';
require_once '../util/funciones/Funciones.php';

try {
    if(
        ! isset($_POST["id"]) ||
        empty($_POST["id"])
    ){
        Funciones::imprimeJSON(500, "Falta completar datos requeridos", "");
        exit; //se detiene la aplicacion
    }
    $id = $_POST["id"];

    $objTipoCulto = new TipoCultoDetalle();
    $resultado = $objTipoCulto->read($id);
    Funciones::imprimeJSON(200, "", $resultado);



} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");

}
