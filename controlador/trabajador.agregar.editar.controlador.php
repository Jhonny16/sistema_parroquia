<?php

require_once '../logica/Trabajador.class.php';
require_once '../util/funciones/Funciones.php';

try {
    /*VALIDAR SI ESTAN LLEGANDO TODOS LOS DATOS NECESARIOS PARA GRABAR (AGREGAR/EDITAR)*/
    if(
        ! isset($_POST["p_tra_iddni"]) || 
          empty($_POST["p_tra_iddni"]) ||   
        
        ! isset($_POST["p_tra_apellido_paterno"]) || 
          empty($_POST["p_tra_apellido_paterno"]) || 
        
        ! isset($_POST["p_tra_apellido_materno"]) || 
          empty($_POST["p_tra_apellido_materno"]) ||
        
        ! isset($_POST["p_tra_nombre"]) || 
          empty($_POST["p_tra_nombre"]) ||
            
        ! isset($_POST["p_tra_direccion"]) || 
          empty($_POST["p_tra_direccion"]) ||
            
        ! isset($_POST["p_tra_email"]) || 
          empty($_POST["p_tra_email"]) ||   
            
         ! isset($_POST["p_car_id"]) || 
           empty($_POST["p_car_id"]) ||
            
        ! isset($_POST["p_ocu_id"]) || 
          empty($_POST["p_ocu_id"]) 
                
       ){
           Funciones::imprimeJSON(500, "Falta completar datos requeridos", "");
           exit; //se detiene la aplicacion
        }
        
        /*CAPTURAR LOS DATOS QUE LLEGAN POR LA VARIABLE $_POST*/
        $tra_iddni = $_POST["p_tra_iddni"];
        $tra_apellido_paterno = $_POST["p_tra_apellido_paterno"];
        $tra_apellido_materno = $_POST["p_tra_apellido_materno"];
        $tra_nombre = $_POST["p_tra_nombre"];
        $tra_direccion = $_POST["p_tra_direccion"];
        $tra_email = $_POST["p_tra_email"];
        $car_id = $_POST["p_car_id"];
        $ocu_id = $_POST["p_ocu_id"];
        $telefono = $_POST["p_telefono"];

        
         /*EL TIPO DE OPERACION PERMITE SABER SI ESTAMOS INSERTANDO (AGREGANDO) O  ACTUALIZANDO(EDITANDO)*/
        $tipoOperacion = $_POST["p_tipo_operacion"];
        
        /*INSTANCIAR LA CLASE CULTO*/
         $objTrabajador = new Trabajador();
         
         /*ENVIAR LOS DATOS RECIBIDOS DEL FORMULARIO HACIA LA CLASE*/
         $objTrabajador->setTra_iddni($tra_iddni);
         $objTrabajador->setTra_apellido_paterno($tra_apellido_paterno);
         $objTrabajador->setTra_apellido_materno($tra_apellido_materno);
         $objTrabajador->setTra_nombre($tra_nombre);
         $objTrabajador->setTra_direccion($tra_direccion);
         $objTrabajador->setTra_email($tra_email);
         $objTrabajador->setCar_id($car_id);
         $objTrabajador->setOcu_id($ocu_id);
         $objTrabajador->setTelefono($telefono);

         
                  /*PREGUNTAR POR EL TIPO DE OPERACION*/
        if($tipoOperacion=="agregar"){            
             $respuesta = $objTrabajador->agregar();
             if ($respuesta == true){
                 Funciones::imprimeJSON(200, "Se ha agregado correctamente", "");
             }
           
        }else {
             //AQUI SE TIENE QUE LLAMAR AL METODO EDITAR
            
             $respuesta = $objTrabajador->editar($tra_iddni);
             
             if ($respuesta == true){
                 Funciones::imprimeJSON(200, "Se ha actualizado correctamente", "");                 
             }
        }
        
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}


