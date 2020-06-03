<?php

require_once '../logica/Parroquia.class.php';
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
        
        $objParroquia =  new Parroquia();
        $respuesta = $objParroquia->eliminar($par_id);
        
        if ($respuesta){//pregunta si la respuesta es TRUE
            Funciones::imprimeJSON(200, "El registro se ha elminado correctamente", "");                              
        }
        
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}
