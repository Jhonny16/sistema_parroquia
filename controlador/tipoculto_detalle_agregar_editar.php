<?php
/**
 * Created by PhpStorm.
 * User: jhonny
 * Date: 19/05/19
 * Time: 05:37 PM
 */

require_once '../logica/TipoCultoDetalle.php';
require_once '../util/funciones/Funciones.php';

try {
    /*VALIDAR SI ESTAN LLEGANDO TODOS LOS DATOS NECESARIOS PARA GRABAR (AGREGAR/EDITAR)*/
    if(
        ! isset($_POST["id"]) ||
        empty($_POST["id"]) ||

        ! isset($_POST["nombre"]) ||
        empty($_POST["nombre"]) ||

        ! isset($_POST["descripcion"]) ||
        empty($_POST["descripcion"]) ||

        ! isset($_POST["tipo_culto"]) ||
        empty($_POST["tipo_culto"])
    ){
        Funciones::imprimeJSON(500, "Falta completar datos requeridos", "");
        exit; //se detiene la aplicacion
    }

    $id = $_POST["id"];
    $nombre = $_POST["nombre"];
    $descripcion = $_POST["descripcion"];
    $tipo = $_POST["tipo_culto"];



    $tipoOperacion = $_POST["operacion"];

    $objTipoCulto = new TipoCultoDetalle();

    $objTipoCulto->setId($id);
    $objTipoCulto->setNombre($nombre);
    $objTipoCulto->setDescripcion($descripcion);
    $objTipoCulto->setTipocultoId($tipo);

    if($tipoOperacion=="agregar"){
        $respuesta = $objTipoCulto->agregar();

        if ($respuesta == true){
            Funciones::imprimeJSON(200, "Se ha agregado correctamente", "");
        }

    }else {
        //AQUI SE TIENE QUE LLAMAR AL METODO EDITAR

        $respuesta = $objTipoCulto->editar();

        if ($respuesta == true){
            Funciones::imprimeJSON(200, "Se ha actualizado correctamente", "");
        }
    }

} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}

