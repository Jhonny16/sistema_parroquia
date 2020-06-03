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
        
        $objHorarioPatron =  new HorarioPatron();
        $respuesta = $objHorarioPatron->eliminar($hora_id);
        
        if ($respuesta){//pregunta si la respuesta es TRUE
            Funciones::imprimeJSON(200, "El registro se ha elminado correctamente", "");                              
        }
        
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}
