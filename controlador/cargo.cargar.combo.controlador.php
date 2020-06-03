<?php
require_once '../logica/Trabajador.cargo.class.php';
require_once '../util/funciones/Funciones.php';

try {
    $objCargo = new Cargo();
    $resultado = $objCargo->cargarDatosCargo();
    Funciones::imprimeJSON(200, "", $resultado);
    
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}


