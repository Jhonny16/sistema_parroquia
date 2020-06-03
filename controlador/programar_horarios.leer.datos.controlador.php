<?php

require_once '../logica/HorarioProgramado.class.php';
require_once '../util/funciones/Funciones.php';

try {
    if(
        ! isset($_POST["p_par_id"]) || 
        empty($_POST["p_par_id"])                
       ){
           Funciones::imprimeJSON(500, "Falta completar datos requeridos", "");
           exit; //se detiene la aplicacion
        }
         $par_id = $_POST["p_par_id"];
        
    $obj = new HorarioProgramado();
    $resultado = $obj->read($par_id);
    
    Funciones::imprimeJSON(200, "", $resultado);
    
    
    
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
    
}
