<?php

require_once '../logica/Celebracion.class.php';
require_once '../util/funciones/Funciones.php';

try {
    /*VALIDAR SI ESTAN LLEGANDO TODOS LOS DATOS NECESARIOS PARA GRABAR (AGREGAR/EDITAR)*/
    if(
        ! isset($_POST["p_cel_id"]) || 
          empty($_POST["p_cel_id"]) ||   
        
        ! isset($_POST["p_cel_nombre"]) || 
          empty($_POST["p_cel_nombre"]) || 
        
        ! isset($_POST["p_cel_descripcion"]) || 
          empty($_POST["p_cel_descripcion"])
                
       ){
           Funciones::imprimeJSON(500, "Falta completar datos requeridos", "");
           exit; //se detiene la aplicacion
        }
        
        /*CAPTURAR LOS DATOS QUE LLEGAN POR LA VARIABLE $_POST*/
        $cel_id = $_POST["p_cel_id"];
        $cel_nombre = $_POST["p_cel_nombre"];
        $cel_descripcion = $_POST["p_cel_descripcion"];
        
         /*EL TIPO DE OPERACION PERMITE SABER SI ESTAMOS INSERTANDO (AGREGANDO) O  ACTUALIZANDO(EDITANDO)*/
        $tipoOperacion = $_POST["p_tipo_operacion"];
        
        /*INSTANCIAR LA CLASE CELEBRACION*/
         $objCelebracion = new Celebracion();
         
         /*ENVIAR LOS DATOS RECIBIDOS DEL FORMULARIO HACIA LA CLASE*/
         $objCelebracion->setCel_id($cel_id);
         $objCelebracion->setCel_nombre($cel_nombre);
         $objCelebracion->setCel_descripcion($cel_descripcion);
         
                  /*PREGUNTAR POR EL TIPO DE OPERACION*/
        if($tipoOperacion=="agregar"){            
             $respuesta = $objCelebracion->agregar();
             
             if ($respuesta == true){
                 Funciones::imprimeJSON(200, "Se ha agregado correctamente", "");
             }
           
        }else {
             //AQUI SE TIENE QUE LLAMAR AL METODO EDITAR
            
             $respuesta = $objCelebracion->editar();
             
             if ($respuesta == true){
                 Funciones::imprimeJSON(200, "Se ha actualizado correctamente", "");                 
             }
        }
        
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}


