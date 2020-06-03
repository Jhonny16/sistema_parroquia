<?php

require_once '../logica/Trabajador.class.php';
require_once '../util/funciones/Funciones.php';

$capilla = $_POST["capilla"];
try {

    $obj = new Trabajador();
    $resultado = $obj->lista_cantores($capilla);
    Funciones::imprimeJSON(200, "", $resultado);// JSON permite compartir datos entre aplicaciones; 200 CORRECTO
    
        
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
    
}


