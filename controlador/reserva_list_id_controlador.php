<?php
/**
 * Created by PhpStorm.
 * User: jhonny
 * Date: 24/04/19
 * Time: 08:18 PM
 */

require_once '../logica/Intencion.class.php';
require_once '../util/funciones/Funciones.php';

try {
    $id= $_POST["p_id"];


    $obj = new Intencion();


    $resultado = $obj->reserva_list($id);
    if($resultado){
        Funciones::imprimeJSON(200, "", $resultado);// JSON permite compartir datos entre aplicaciones; 200 CORRECTO
    }else{
        Funciones::imprimeJSON(203, "No se encontró resultado en la búsqueda", $resultado);// JSON permite compartir datos entre aplicaciones; 200 CORRECTO
    }


} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");

}
