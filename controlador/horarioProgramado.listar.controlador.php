<?php

require_once '../logica/HorarioProgramado.class.php';
require_once '../util/funciones/Funciones.php';

try {
    $objHorarioProgramado = new HorarioProgramado();
    $resultado = $objHorarioProgramado->listar();
    Funciones::imprimeJSON(200, "", $resultado);// JSON permite compartir datos entre aplicaciones; 200 CORRECTO
    
        
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
    
}


