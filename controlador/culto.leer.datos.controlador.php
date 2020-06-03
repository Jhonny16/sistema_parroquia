<?php

require_once '../logica/Culto.class.php';
require_once '../util/funciones/Funciones.php';

try {
    if(
        ! isset($_POST["p_cul_id"]) || 
          empty($_POST["p_cul_id"])                
       ){
           Funciones::imprimeJSON(500, "Falta completar datos requeridos", "");
           exit; //se detiene la aplicacion
        }
         $cul_id = $_POST["p_cul_id"];
        
    $objCulto = new Culto();
    $resultado = $objCulto->leerDatos($cul_id);
    
    Funciones::imprimeJSON(200, "", $resultado);
    
    
    
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
    
}
