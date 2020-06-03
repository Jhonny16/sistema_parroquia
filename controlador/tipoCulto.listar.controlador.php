<?php

require_once '../logica/TipoCulto.class.php';
require_once '../util/funciones/Funciones.php';

try {
    $objTipoCulto = new TipoCulto();
    $resultado = $objTipoCulto->listar();
    Funciones::imprimeJSON(200, "", $resultado);// JSON permite compartir datos entre aplicaciones; 200 CORRECTO
    
        
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
    
}


