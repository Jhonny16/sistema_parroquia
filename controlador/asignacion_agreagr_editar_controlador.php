<?php
/**
 * Created by PhpStorm.
 * User: jhonny
 * Date: 12/05/19
 * Time: 04:42 PM
 */

require_once '../logica/Asignacion.php';
require_once '../util/funciones/Funciones.php';

try {
    /*VALIDAR SI ESTAN LLEGANDO TODOS LOS DATOS NECESARIOS PARA GRABAR (AGREGAR/EDITAR)*/
    if(
        ! isset($_POST["dni"]) ||
        empty($_POST["dni"]) ||

        ! isset($_POST["capilla"]) ||
        empty($_POST["capilla"])

    ){
        Funciones::imprimeJSON(500, "Falta completar datos requeridos", "");
        exit;
    }

    $dni = $_POST["dni"];
    $capilla = $_POST["capilla"];
    $operacion = $_POST["operacion"];
    $obj = new Asignacion();

    $obj->setCapilla($capilla);
    $obj->setDni($dni);


    if($operacion=="agregar"){
        $respuesta = $obj->agregar();

        if ($respuesta == true){
            Funciones::imprimeJSON(200, "Se ha agregado correctamente", $respuesta);
        }

    }else {
        $respuesta = $obj->agregar();
        if ($respuesta == true){
            Funciones::imprimeJSON(200, "Se ha actualizado correctamente", $respuesta);
        }
    }

} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}