<?php

require_once '../logica/Celebracion.class.php';
require_once '../util/funciones/Funciones.php';

try {
    if(
        ! isset($_POST["p_cel_id"]) || 
          empty($_POST["p_cel_id"])                
       ){
           Funciones::imprimeJSON(500, "Falta completar datos requeridos", "");
           exit; //se detiene la aplicacion
        }
         $cel_id = $_POST["p_cel_id"];
        
    $objCelebracion = new Celebracion();
    $resultado = $objCelebracion->leerDatos($cel_id);
    
    Funciones::imprimeJSON(200, "", $resultado);
    
    
    
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
    
}
