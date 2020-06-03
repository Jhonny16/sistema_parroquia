<?php
/**
 * Created by PhpStorm.
 * User: jhonny
 * Date: 19/05/19
 * Time: 08:08 PM
 */
require_once '../logica/Trabajador.class.php';
require_once '../logica/Usuario.php';
require_once '../util/funciones/Funciones.php';

try {
    if (
        !isset($_POST["ap_paterno"]) ||
        empty($_POST["ap_paterno"]) ||

        !isset($_POST["ap_materno"]) ||
        empty($_POST["ap_materno"]) ||

        !isset($_POST["nombres"]) ||
        empty($_POST["nombres"]) ||

        !isset($_POST["celular"]) ||
        empty($_POST["celular"]) ||

        !isset($_POST["email"]) ||
        empty($_POST["email"]) ||

        !isset($_POST["password"]) ||
        empty($_POST["password"])
        ||
        !isset($_POST["dni"]) ||
        empty($_POST["dni"])
        ||
        !isset($_POST["direccion"]) ||
        empty($_POST["direccion"])

    ) {
        Funciones::imprimeJSON(500, "Falta completar datos requeridos", "");
        exit;
    }

    $tra_iddni = $_POST["dni"];
    $tra_apellido_paterno = $_POST["ap_paterno"];
    $tra_apellido_materno = $_POST["ap_materno"];
    $tra_nombre = $_POST["nombres"];
    $tra_direccion = $_POST["direccion"];
    $tra_email = $_POST["email"];
    $car_id = '5';
    $ocu_id = '7';
    $telefono = $_POST["celular"];


    $objTrabajador = new Trabajador();

    $objTrabajador->setTra_iddni($tra_iddni);
    $objTrabajador->setTra_apellido_paterno($tra_apellido_paterno);
    $objTrabajador->setTra_apellido_materno($tra_apellido_materno);
    $objTrabajador->setTra_nombre($tra_nombre);
    $objTrabajador->setTra_direccion($tra_direccion);
    $objTrabajador->setTra_email($tra_email);
    $objTrabajador->setCar_id($car_id);
    $objTrabajador->setOcu_id($ocu_id);
    $objTrabajador->setTelefono($telefono);

    $objUser = new Usuario();

    $objUser->setClave($_POST["password"]);
    $objUser->setEstado("A");
    $objUser->setDni($tra_iddni);
    $objUser->setFechaInicio('2019-01-01');
    $objUser->setFechaFin('2019-12-31');
    $objUser->setRolId(4);



    $respuesta = $objTrabajador->agregar();
    if ($respuesta == true) {
        $res = $objUser->create();
        if($res){
            header("location:../vista/principal_cliente_vista.php");
        }else{
            Funciones::mensaje("No se pudo crear el usuario", "i", "../vista/index.html", 5);
        }
    }else{
        Funciones::mensaje("No se pudo crear el Trabajador", "i", "../vista/index.html", 5);

    }

} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}
