<?php

require_once '../logica/Cargo.class.php';
require_once '../util/funciones/Funciones.php';

try {
    /*VALIDAR SI ESTAN LLEGANDO TODOS LOS DATOS NECESARIOS PARA GRABAR (AGREGAR/EDITAR)*/
    if(
        ! isset($_POST["p_car_id"]) || 
          empty($_POST["p_car_id"]) ||   
        
        ! isset($_POST["p_car_nombre"]) || 
          empty($_POST["p_car_nombre"]) 
                
       ){
           Funciones::imprimeJSON(500, "Falta completar datos requeridos", "");
           exit; //se detiene la aplicacion
        }
        
        /*CAPTURAR LOS DATOS QUE LLEGAN POR LA VARIABLE $_POST*/
        $car_id = $_POST["p_car_id"];
        $car_nombre = $_POST["p_car_nombre"];
        
        
         /*EL TIPO DE OPERACION PERMITE SABER SI ESTAMOS INSERTANDO (AGREGANDO) O  ACTUALIZANDO(EDITANDO)*/
        $tipoOperacion = $_POST["p_tipo_operacion"];
        
        /*INSTANCIAR LA CLASE CARGO*/
         $objCargo = new Cargo();
         
         /*ENVIAR LOS DATOS RECIBIDOS DEL FORMULARIO HACIA LA CLASE*/
         $objCargo->setCar_id($car_id);
         $objCargo->setCar_nombre($car_nombre);
         
         
         /*PREGUNTAR POR EL TIPO DE OPERACION*/
        if($tipoOperacion=="agregar"){            
             $respuesta = $objCargo->agregar();
             
             if ($respuesta == true){
                 Funciones::imprimeJSON(200, "Se ha agregado correctamente", "");
             }
           
        }else {
             //AQUI SE TIENE QUE LLAMAR AL METODO EDITAR
            
             $respuesta = $objCargo->editar();
             
             if ($respuesta == true){
                 Funciones::imprimeJSON(200, "Se ha actualizado correctamente", "");                 
             }
        }
        
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}


