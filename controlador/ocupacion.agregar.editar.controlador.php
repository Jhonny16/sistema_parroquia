<?php

require_once '../logica/Ocupacion.class.php';
require_once '../util/funciones/Funciones.php';

try {
    /*VALIDAR SI ESTAN LLEGANDO TODOS LOS DATOS NECESARIOS PARA GRABAR (AGREGAR/EDITAR)*/
    if(
        ! isset($_POST["p_ocu_id"]) || 
          empty($_POST["p_ocu_id"]) ||   
        
        ! isset($_POST["p_ocu_nombre"]) || 
          empty($_POST["p_ocu_nombre"]) || 
        
        ! isset($_POST["p_ocu_abreviatura"]) || 
          empty($_POST["p_ocu_abreviatura"]) 
                
       ){
           Funciones::imprimeJSON(500, "Falta completar datos requeridos", "");
           exit; //se detiene la aplicacion
        }
        
        /*CAPTURAR LOS DATOS QUE LLEGAN POR LA VARIABLE $_POST*/
        $ocu_id = $_POST["p_ocu_id"];
        $ocu_nombre = $_POST["p_ocu_nombre"];
        $ocu_abreviatura = $_POST["p_ocu_abreviatura"];
        
        
         /*EL TIPO DE OPERACION PERMITE SABER SI ESTAMOS INSERTANDO (AGREGANDO) O  ACTUALIZANDO(EDITANDO)*/
        $tipoOperacion = $_POST["p_tipo_operacion"];
        
        /*INSTANCIAR LA CLASE OCUPACION*/
         $objOcupacion = new Ocupacion();
         
         /*ENVIAR LOS DATOS RECIBIDOS DEL FORMULARIO HACIA LA CLASE*/
         $objOcupacion->setOcu_id($ocu_id);
         $objOcupacion->setOcu_nombre($ocu_nombre);
         $objOcupacion->setocu_abreviatura($ocu_abreviatura);
         
         
                  /*PREGUNTAR POR EL TIPO DE OPERACION*/
        if($tipoOperacion=="agregar"){            
             $respuesta = $objOcupacion->agregar();
             
             if ($respuesta == true){
                 Funciones::imprimeJSON(200, "Se ha agregado correctamente", "");
             }
           
        }else {
             //AQUI SE TIENE QUE LLAMAR AL METODO EDITAR
            
             $respuesta = $objOcupacion->editar();
             
             if ($respuesta == true){
                 Funciones::imprimeJSON(200, "Se ha actualizado correctamente", "");                 
             }
        }
        
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}


