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
        
        $objOcupacion =  new Ocupacion();
        $respuesta = $objOcupacion->eliminar($ocu_id);
        
        if ($respuesta){//pregunta si la respuesta es TRUE
            Funciones::imprimeJSON(200, "El registro se ha elminado correctamente", "");                              
        }
        
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}
