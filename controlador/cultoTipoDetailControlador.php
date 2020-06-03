<?php
/**
 * Created by PhpStorm.
 * User: jhonny
 * Date: 30/04/19
 * Time: 11:44 PM
 */

require_once '../logica/Culto.class.php';
require_once '../util/funciones/Funciones.php';

try {
    $culto_id = $_POST['culto_id'];

    $objCulto = new Culto();
    $resultado = $objCulto->detail($culto_id);
    Funciones::imprimeJSON(200, "", $resultado);// JSON permite compartir datos entre aplicaciones; 200 CORRECTO


} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");

}
