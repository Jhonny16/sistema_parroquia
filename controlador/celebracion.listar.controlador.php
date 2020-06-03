<?php

require_once '../logica/Celebracion.class.php';
require_once '../util/funciones/Funciones.php';

try {
    $objCelebracion = new Celebracion();
    $resultado = $objCelebracion->listar();
    Funciones::imprimeJSON(200, "", $resultado);// JSON permite compartir datos entre aplicaciones; 200 CORRECTO
    
        
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
    
}


