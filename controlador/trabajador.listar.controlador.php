<?php

require_once '../logica/Trabajador.class.php';
require_once '../util/funciones/Funciones.php';

try {
    $cargo_id = $_POST['cargo_id'];
    $objTrabajador = new Trabajador();
    $resultado = $objTrabajador->listar($cargo_id);
    Funciones::imprimeJSON(200, "", $resultado);// JSON permite compartir datos entre aplicaciones; 200 CORRECTO
    
        
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
    
}


