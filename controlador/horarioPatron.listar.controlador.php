<?php

require_once '../logica/HorarioPatron.class.php';
require_once '../util/funciones/Funciones.php';

try {
    $objHorarioPatron = new HorarioPatron();
    $resultado = $objHorarioPatron->listar();
    Funciones::imprimeJSON(200, "", $resultado);// JSON permite compartir datos entre aplicaciones; 200 CORRECTO
    
        
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
    
}


