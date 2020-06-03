<?php

require_once '../logica/HorarioPatron.class.php';
require_once '../util/funciones/Funciones.php';

try {
    if(
        ! isset($_POST["p_hora_id"]) || 
          empty($_POST["p_hora_id"])                
       ){
           Funciones::imprimeJSON(500, "Falta completar datos requeridos", "");
           exit; //se detiene la aplicacion
        }
         $hora_id = $_POST["p_hora_id"];
        
    $objHorarioPatron = new HorarioPatron();
    $resultado = $objHorarioPatron->leerDatos($hora_id);
    
    Funciones::imprimeJSON(200, "", $resultado);
    
    
    
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
    
}
