<?php

require_once '../logica/Culto.class.php';
require_once '../util/funciones/Funciones.php';

try {
    /*VALIDAR SI ESTAN LLEGANDO TODOS LOS DATOS NECESARIOS PARA GRABAR (AGREGAR/EDITAR)*/
    if(
        ! isset($_POST["p_cul_id"]) || 
          empty($_POST["p_cul_id"]) ||   
        
        ! isset($_POST["p_cul_nombre"]) || 
          empty($_POST["p_cul_nombre"]) || 
        
        ! isset($_POST["p_cul_descripcion"]) || 
          empty($_POST["p_cul_descripcion"]) ||
            
        ! isset($_POST["p_cel_id"]) || 
          empty($_POST["p_cel_id"]) 
                
       ){
           Funciones::imprimeJSON(500, "Falta completar datos requeridos", "");
           exit; //se detiene la aplicacion
        }
        
        /*CAPTURAR LOS DATOS QUE LLEGAN POR LA VARIABLE $_POST*/
        $cul_id = $_POST["p_cul_id"];
        $cul_nombre = $_POST["p_cul_nombre"];
        $cul_descripcion = $_POST["p_cul_descripcion"];
        $cel_id = $_POST["p_cel_id"];
       
        
         /*EL TIPO DE OPERACION PERMITE SABER SI ESTAMOS INSERTANDO (AGREGANDO) O  ACTUALIZANDO(EDITANDO)*/
        $tipoOperacion = $_POST["p_tipo_operacion"];
        
        /*INSTANCIAR LA CLASE CULTO*/
         $objCulto = new Culto();
         
         /*ENVIAR LOS DATOS RECIBIDOS DEL FORMULARIO HACIA LA CLASE*/
         $objCulto->setCul_id($cul_id);
         $objCulto->setCul_nombre($cul_nombre);
         $objCulto->setCul_descripcion($cul_descripcion);
         $objCulto->setCel_id($cel_id);
         
         
                  /*PREGUNTAR POR EL TIPO DE OPERACION*/
        if($tipoOperacion=="agregar"){            
             $respuesta = $objCulto->agregar();
             
             if ($respuesta == true){
                 Funciones::imprimeJSON(200, "Se ha agregado correctamente", "");
             }
           
        }else {
             //AQUI SE TIENE QUE LLAMAR AL METODO EDITAR
            
             $respuesta = $objCulto->editar();
             
             if ($respuesta == true){
                 Funciones::imprimeJSON(200, "Se ha actualizado correctamente", "");                 
             }
        }
        
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}


