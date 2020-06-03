<?php
/**
 * Created by PhpStorm.
 * User: jhonny
 * Date: 02/05/19
 * Time: 10:00 PM
 */

require_once '../logica/Usuario.php';
require_once '../util/funciones/Funciones.php';

try {
    $user_id = $_POST["user_id"];
    $password = $_POST["clave"];

    $objUsuario = new Usuario();


    $resultado = $objUsuario->validar_password($user_id,$password);
    if($resultado == 1){
        Funciones::imprimeJSON(200, "Contraseña Válida", $resultado);// JSON permite compartir datos entre aplicaciones; 200 CORRECTO
    }else{
        Funciones::imprimeJSON(200, "Password no válido",  "");
    }

} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}
