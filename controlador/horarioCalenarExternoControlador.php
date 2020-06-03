<?php
/**
 * Created by PhpStorm.
 * User: jhonny
 * Date: 23/04/19
 * Time: 09:42 PM
 */

require_once '../logica/Horario.php';
require_once '../util/funciones/Funciones.php';

try {

    $obj = new Horario();

    $capilla_id = $_POST['capilla_id'] ;

    $resultado = $obj->calendar_list_por_capilla($capilla_id);
    if($resultado){
        Funciones::imprimeJSON(200, "", $resultado);// JSON permite compartir datos entre aplicaciones; 200 CORRECTO
    }else{
        Funciones::imprimeJSON(203, "No se encontró resultado en la búsqueda", $resultado);// JSON permite compartir datos entre aplicaciones; 200 CORRECTO
    }


} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");

}
