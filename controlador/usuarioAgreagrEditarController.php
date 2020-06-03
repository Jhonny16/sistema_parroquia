<?php
/**
 * Created by PhpStorm.
 * User: jhonny
 * Date: 02/05/19
 * Time: 10:24 PM
 */
try {
    require_once '../logica/Usuario.php';
    require_once '../util/funciones/Funciones.php';


    $objUser = new Usuario();

    $operacion = $_POST["p_operacion"];
    $check = $_POST["p_check"];

    $user_id = $_POST["p_usuario_id"];
    $documento = $_POST["p_documento"];
    $rol_id = $_POST["p_rol_id"];
    $password  = $_POST["p_password"];
    $estado = $_POST["p_estado"];
    $finicio = $_POST["p_fecha_inicio"];
    $ffin = $_POST["p_fecha_fin"];




    $objUser->setId($user_id);
    $objUser->setClave($password);
    $objUser->setEstado($estado);
    $objUser->setDni($documento);
    $objUser->setFechaInicio($finicio);
    $objUser->setFechaFin($ffin);
    $objUser->setRolId($rol_id);



    if ($operacion == 'agregar') {
        if($password == ""){
            Funciones::imprimeJSON(203, "Debe ingresar el password", "");

        }else{
            $resultado = $objUser->create();
            if ($resultado) {
                Funciones::imprimeJSON(200, "Usuario agregado correctamente", "");
            }
        }


    } else { //Editar
        if($check == 1){
            if($password == ""){
                Funciones::imprimeJSON(203, "Debe ingresar el password", "");
            }else{
                $resultado = $objUser->update_con_password();
                if ($resultado) {
                    Funciones::imprimeJSON(200, "Usuario actualizado correctamente", "");
                }
            }
        }else{
            $resultado = $objUser->update();
            if ($resultado) {
                Funciones::imprimeJSON(200, "Usuario actualizado correctamente", "");
            }
        }


    }




} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}
