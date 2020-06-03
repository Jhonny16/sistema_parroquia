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
        
        $objCulto =  new Culto();
        $respuesta = $objCulto->eliminar($cul_id);
        
        if ($respuesta){//pregunta si la respuesta es TRUE
            Funciones::imprimeJSON(200, "El registro se ha eliminado correctamente", "");                              
        }
        
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}
