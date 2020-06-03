<?php
require_once '../logica/HorarioProgramado.hora.class.php';
require_once '../util/funciones/Funciones.php';

try {
    $objHora = new Hora();
    $resultado = $objHora->cargarDatosHora();
    Funciones::imprimeJSON(200, "", $resultado);
    
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}


