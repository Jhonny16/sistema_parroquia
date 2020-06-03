<?php

require_once '../logica/Cargo.class.php';
require_once '../util/funciones/Funciones.php';

try {
    if(
        ! isset($_POST["p_car_id"]) || 
          empty($_POST["p_car_id"])                
       ){
           Funciones::imprimeJSON(500, "Falta completar datos requeridos", "");
           exit; //se detiene la aplicacion
        }
        $car_id = $_POST["p_car_id"];
        
        $objCargo =  new Cargo();
        $respuesta = $objCargo->eliminar($car_id);
        
        if ($respuesta){//pregunta si la respuesta es TRUE
            Funciones::imprimeJSON(200, "El registro se ha elminado correctamente", "");                              
        }
        
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}
