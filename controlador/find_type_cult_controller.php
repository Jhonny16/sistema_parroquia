<?php
/**
 * Created by PhpStorm.
 * User: jhonny
 * Date: 29/06/20
 * Time: 05:16 PM
 */

require_once '../logica/Reportes.php';
require_once '../util/funciones/Funciones.php';

try {
    $capilla_id =$_POST['capilla_id'];
    $obj = new Reportes();

    $resultado = $obj->types_cult_list($capilla_id);
    if($resultado){
        Funciones::imprimeJSON(200, "", $resultado);
    }else{
        Funciones::imprimeJSON(203, "No se encontró resultado en la búsqueda", $resultado);
    }


} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");

}
