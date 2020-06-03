<?php

require_once '../logica/Parroquia.class.php';
require_once '../util/funciones/Funciones.php';

try {
    /*VALIDAR SI ESTAN LLEGANDO TODOS LOS DATOS NECESARIOS PARA GRABAR (AGREGAR/EDITAR)*/
    if(
        ! isset($_POST["p_par_id"]) || 
          empty($_POST["p_par_id"]) ||   
        
        ! isset($_POST["p_par_nombre"]) || 
          empty($_POST["p_par_nombre"]) || 
        
        ! isset($_POST["p_par_direccion"]) || 
          empty($_POST["p_par_direccion"]) ||
            
        ! isset($_POST["p_par_telefono"]) || 
          empty($_POST["p_par_telefono"]) ||
        
        ! isset($_POST["p_par_email"]) || 
          empty($_POST["p_par_email"])
                
       ){
           Funciones::imprimeJSON(500, "Falta completar datos requeridos", "");
           exit; //se detiene la aplicacion
        }
        
        /*CAPTURAR LOS DATOS QUE LLEGAN POR LA VARIABLE $_POST*/
        $par_id = $_POST["p_par_id"];
        $par_nombre = $_POST["p_par_nombre"];
        $par_direccion = $_POST["p_par_direccion"];
        $par_telefono = $_POST["p_par_telefono"];
        $par_email = $_POST["p_par_email"];
        
         /*EL TIPO DE OPERACION PERMITE SABER SI ESTAMOS INSERTANDO (AGREGANDO) O  ACTUALIZANDO(EDITANDO)*/
        $tipoOperacion = $_POST["p_tipo_operacion"];
        
        /*INSTANCIAR LA CLASE PARROQUIA*/
         $objParroquia = new Parroquia();
         
         /*ENVIAR LOS DATOS RECIBIDOS DEL FORMULARIO HACIA LA CLASE*/
         $objParroquia->setPar_id($par_id);
         $objParroquia->setPar_nombre($par_nombre);
         $objParroquia->setPar_direccion($par_direccion);
         $objParroquia->setPar_telefono($par_telefono);
         $objParroquia->setPar_email($par_email);
         
                  /*PREGUNTAR POR EL TIPO DE OPERACION*/
        if($tipoOperacion=="agregar"){            
             $respuesta = $objParroquia->agregar();
             
             if ($respuesta == true){
                 Funciones::imprimeJSON(200, "Se ha agregado correctamente", "");
             }
           
        }else {
             //AQUI SE TIENE QUE LLAMAR AL METODO EDITAR
            
             $respuesta = $objParroquia->editar();
             
             if ($respuesta == true){
                 Funciones::imprimeJSON(200, "Se ha actualizado correctamente", "");                 
             }
        }
        
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}


