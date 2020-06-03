<?php
/**
 * Created by PhpStorm.
 * User: jhonny
 * Date: 09/05/19
 * Time: 09:23 PM
 */
require_once '../logica/Trabajador.class.php';
require_once '../util/funciones/Funciones.php';



try {

    $dni = $_POST["dni"];

    $obj = new Trabajador();
    $resultado = $obj->read($dni);

    if($resultado){
        Funciones::imprimeJSON(200, "", $resultado);
    }else{
        Funciones::imprimeJSON(203, "Algun error", $resultado);
    }


} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");

}
