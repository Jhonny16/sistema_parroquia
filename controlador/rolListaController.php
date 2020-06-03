<?php
/**
 * Created by PhpStorm.
 * User: jhonny
 * Date: 02/05/19
 * Time: 09:04 PM
 */

require_once '../logica/Rol.php';
require_once '../util/funciones/Funciones.php';

try {

    $obj = new Rol();


    $resultado = $obj->lista();
    if($resultado){
        Funciones::imprimeJSON(200, "", $resultado);// JSON permite compartir datos entre aplicaciones; 200 CORRECTO
    }else{
        Funciones::imprimeJSON(203, "No se encontró resultado en la búsqueda", $resultado);// JSON permite compartir datos entre aplicaciones; 200 CORRECTO
    }


} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");

}