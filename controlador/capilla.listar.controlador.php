<?php

require_once '../logica/Capilla.php';
require_once '../util/funciones/Funciones.php';

try {
    $cargo = $_POST["p_cargo"];
    $capilla_id= $_POST["capilla_id"];
    $rol_id= $_POST["rol_id"];
    $obj = new Capilla();
    $resultado = $obj->listar_por_cargo($cargo,$capilla_id,$rol_id);
    Funciones::imprimeJSON(200, "", $resultado);// JSON permite compartir datos entre aplicaciones; 200 CORRECTO
    
        
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
    
}


