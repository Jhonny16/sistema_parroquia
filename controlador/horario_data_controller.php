<?php
/**
 * Created by PhpStorm.
 * User: jhonny
 * Date: 24/04/19
 * Time: 10:48 PM
 */
require_once '../logica/Horario.php';
require_once '../util/funciones/Funciones.php';

try {
    $capilla = $_POST["capilla"];
    $tipo_culto = $_POST["tipo_culto"];
    $horario = $_POST["horario"];

    $obj = new Horario();
    $obj->setCapillaId($capilla);
    $obj->setTipocultoId($tipo_culto);
    $obj->setId($horario);

    $resultado = $obj->get_data();
    if($resultado){
        Funciones::imprimeJSON(200, "", $resultado);// JSON permite compartir datos entre aplicaciones; 200 CORRECTO
    }else{
        Funciones::imprimeJSON(203, "No se encontró resultado en la búsqueda", $resultado);// JSON permite compartir datos entre aplicaciones; 200 CORRECTO
    }


} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");

}