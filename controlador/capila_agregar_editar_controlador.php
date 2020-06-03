<?php
/**
 * Created by PhpStorm.
 * User: jhonny
 * Date: 10/05/19
 * Time: 12:43 AM
 */
require_once '../logica/Capilla.php';
require_once '../logica/Parroquia.class.php';
require_once '../util/funciones/Funciones.php';

try {
    /*VALIDAR SI ESTAN LLEGANDO TODOS LOS DATOS NECESARIOS PARA GRABAR (AGREGAR/EDITAR)*/
    if(

        ! isset($_POST["p_nombre"]) ||
        empty($_POST["p_nombre"]) ||

        ! isset($_POST["p_direccion"]) ||
        empty($_POST["p_direccion"]) ||

        ! isset($_POST["p_parroquia"]) ||
        empty($_POST["p_parroquia"])
    ){
        Funciones::imprimeJSON(500, "Falta completar datos requeridos", "");
        exit; //se detiene la aplicacion
    }

    $id = $_POST["p_id"];
    $nombre = $_POST["p_nombre"];
    $direccion = $_POST["p_direccion"];
    $estado = $_POST["p_estado"];
    $parroquia = $_POST["p_parroquia"];

    $tipoOperacion = $_POST["p_tipo_operacion"];
    $pasar_parroquia = $_POST["p_pasar_parroquia"];

    $obj = new Capilla();

    /*ENVIAR LOS DATOS RECIBIDOS DEL FORMULARIO HACIA LA CLASE*/
    $obj->setId($id);
    $obj->setNombre($nombre);
    $obj->setDireccion($direccion);
    $obj->setEstado($estado);
    $obj->setParroquiaId($parroquia);

    /*PREGUNTAR POR EL TIPO DE OPERACION*/
    if($tipoOperacion=="agregar"){
        $respuesta = $obj->agregar();

        if ($respuesta == true){
            Funciones::imprimeJSON(200, "Se ha agregado correctamente", "");
        }

    }else {
        //AQUI SE TIENE QUE LLAMAR AL METODO EDITAR

        if($pasar_parroquia == 1){
            $objParroquia = new Parroquia();
            $objParroquia->setPar_nombre($nombre);
            $objParroquia->setPar_direccion($direccion);
            $objParroquia->setPar_telefono("");
            $objParroquia->setPar_email("");

            $respuesta = $objParroquia->agregar_parroquia();

            if ($respuesta > 1){
                $obj->setParroquia(true);
                $obj->editar();

                $obj->setDireccion($direccion);
                $obj->setEstado(true);
                $obj->setNombre($nombre.' - Principal');
                $obj->setParroquiaId($respuesta);

                $res = $obj->agregar();
                if ($res){
                    Funciones::imprimeJSON(200, "Se ha agregado como parroquia, además se creo una capilla nueva", "");
                }
            }


        }else{
            $respuesta = $obj->editar();

            if ($respuesta == true){
                Funciones::imprimeJSON(200, "Se ha actualizado correctamente", "");
            }
        }


    }

} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}
