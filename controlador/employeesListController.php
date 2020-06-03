<?php
/**
 * Created by PhpStorm.
 * User: jhonny
 * Date: 02/05/19
 * Time: 10:58 PM
 */

require_once '../logica/Trabajador.class.php';
require_once '../util/funciones/Funciones.php';

try {
    $rol_id =$_POST['rol_id'];
    $parroquia =$_POST['parroquia'];
    $dni =$_POST['dni'];
    $obj = new Trabajador();

    $resultado = $obj->lista_employees($rol_id,$parroquia,$dni);
    if($resultado){
        Funciones::imprimeJSON(200, "", $resultado);// JSON permite compartir datos entre aplicaciones; 200 CORRECTO
    }else{
        Funciones::imprimeJSON(203, "No se encontró resultado en la búsqueda", $resultado);// JSON permite compartir datos entre aplicaciones; 200 CORRECTO
    }


} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");

}
