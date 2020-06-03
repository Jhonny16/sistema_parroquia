<?php

require_once '../logica/Categoria.class.php';
require_once '../util/funciones/Funciones.php';

try {
    $objCategoria = new Categoria();
    $resultado = $objCategoria->cargarDatosCategoria();
    Funciones::imprimeJSON(200, "", $resultado);
    
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}


