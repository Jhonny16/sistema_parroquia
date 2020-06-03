<?php
require_once '../logica/TipoCulto.culto.class.php';
require_once '../util/funciones/Funciones.php';

try {
    $objCulto = new Culto();
    $resultado = $objCulto->cargarDatosCulto();
    Funciones::imprimeJSON(200, "", $resultado);

} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}


