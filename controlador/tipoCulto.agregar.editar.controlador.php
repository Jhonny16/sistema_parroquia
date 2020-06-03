<?php

require_once '../logica/TipoCulto.class.php';
require_once '../util/funciones/Funciones.php';

try {
    /*VALIDAR SI ESTAN LLEGANDO TODOS LOS DATOS NECESARIOS PARA GRABAR (AGREGAR/EDITAR)*/
    if(
        ! isset($_POST["p_tc_id"]) || 
          empty($_POST["p_tc_id"]) ||   
        
        ! isset($_POST["p_tc_nombre"]) || 
          empty($_POST["p_tc_nombre"]) || 
        
        ! isset($_POST["p_tc_descripcion"]) || 
          empty($_POST["p_tc_descripcion"]) ||

        ! isset($_POST["p_tc_tipo"]) || 
          empty($_POST["p_tc_tipo"]) ||
            
        ! isset($_POST["p_tc_tiempo_maximo"]) || 
          empty($_POST["p_tc_tiempo_maximo"]) ||
            
        ! isset($_POST["p_tc_precio"]) || 
          empty($_POST["p_tc_precio"]) ||
            
        ! isset($_POST["p_cul_id"]) || 
          empty($_POST["p_cul_id"]) 
                
       ){
           Funciones::imprimeJSON(500, "Falta completar datos requeridos", "");
           exit; //se detiene la aplicacion
        }
        
        /*CAPTURAR LOS DATOS QUE LLEGAN POR LA VARIABLE $_POST*/
        $tc_id = $_POST["p_tc_id"];
        $tc_nombre = $_POST["p_tc_nombre"];
        $tc_descripcion = $_POST["p_tc_descripcion"];        
        $tc_tipo = $_POST["p_tc_tipo"];
        $tc_tiempo_maximo = $_POST["p_tc_tiempo_maximo"];
        $tc_precio = $_POST["p_tc_precio"];        
        $cul_id = $_POST["p_cul_id"];
       
        
         /*EL TIPO DE OPERACION PERMITE SABER SI ESTAMOS INSERTANDO (AGREGANDO) O  ACTUALIZANDO(EDITANDO)*/
        $tipoOperacion = $_POST["p_tipo_operacion"];
        
        /*INSTANCIAR LA CLASE CULTO*/
         $objTipoCulto = new TipoCulto();
         
         /*ENVIAR LOS DATOS RECIBIDOS DEL FORMULARIO HACIA LA CLASE*/
         $objTipoCulto->setTc_id($tc_id);
         $objTipoCulto->setTc_nombre($tc_nombre);
         $objTipoCulto->setTc_descripcion($tc_descripcion);         
         $objTipoCulto->setTc_tipo($tc_tipo);
         $objTipoCulto->setTc_tiempo_maximo($tc_tiempo_maximo);
         $objTipoCulto->setTc_precio($tc_precio);         
         $objTipoCulto->setCul_id($cul_id);
         
         
                  /*PREGUNTAR POR EL TIPO DE OPERACION*/
        if($tipoOperacion=="agregar"){            
             $respuesta = $objTipoCulto->agregar();
             
             if ($respuesta == true){
                 Funciones::imprimeJSON(200, "Se ha agregado correctamente", "");
             }
           
        }else {
             //AQUI SE TIENE QUE LLAMAR AL METODO EDITAR
            
             $respuesta = $objTipoCulto->editar();
             
             if ($respuesta == true){
                 Funciones::imprimeJSON(200, "Se ha actualizado correctamente", "");                 
             }
        }
        
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}


