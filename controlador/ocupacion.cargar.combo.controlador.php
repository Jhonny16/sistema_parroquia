<?php
require_once '../logica/Trabajador.ocup.class.php';

require_once '../util/funciones/Funciones.php';

try {
    $objOcup = new Ocup();
    $resultado = $objOcup->cargarDatosOcup();
    Funciones::imprimeJSON(200, "", $resultado);
    
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}


