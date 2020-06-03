<?php

require_once '../logica/TipoCulto.class.php';
require_once '../util/funciones/Funciones.php';

try {
    if(
        ! isset($_POST["p_tc_id"]) || 
          empty($_POST["p_tc_id"])                
       ){
           Funciones::imprimeJSON(500, "Falta completar datos requeridos", "");
           exit; //se detiene la aplicacion
        }
        $tc_id = $_POST["p_tc_id"];
        
        $objTipoCulto =  new TipoCulto();
        $respuesta = $objTipoCulto->eliminar($tc_id);
        
        if ($respuesta){//pregunta si la respuesta es TRUE
            Funciones::imprimeJSON(200, "El registro se ha eliminado correctamente", "");                              
        }
        
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}
