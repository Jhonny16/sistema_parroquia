<?php

require_once '../logica/Ocupacion.class.php';
require_once '../util/funciones/Funciones.php';

try {
    if(
        ! isset($_POST["p_ocu_id"]) || 
          empty($_POST["p_ocu_id"])                
       ){
           Funciones::imprimeJSON(500, "Falta completar datos requeridos", "");
           exit; //se detiene la aplicacion
        }
         $ocu_id = $_POST["p_ocu_id"];
        
    $objOcupacion = new Ocupacion();
    $resultado = $objOcupacion->leerDatos($ocu_id);
    
    Funciones::imprimeJSON(200, "", $resultado);
    
    
    
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
    
}
