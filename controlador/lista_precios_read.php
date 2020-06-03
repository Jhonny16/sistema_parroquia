<?php
/**
 * Created by PhpStorm.
 * User: jhonny
 * Date: 31/05/20
 * Time: 08:00 PM
 */

require_once '../logica/listaPrecios.php';
require_once '../util/funciones/Funciones.php';


$lp_id= $_POST["lp_id"];

try {

    $object = new listaPrecios();
    $object->setId($lp_id);

    $resultado = $object->read();
    if($resultado){
        Funciones::imprimeJSON(200, "", $resultado);// JSON permite compartir datos entre aplicaciones; 200 CORRECTO
    }else{
        Funciones::imprimeJSON(203, "No hubo resultados en la busqueda","");

    }

} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");

}
