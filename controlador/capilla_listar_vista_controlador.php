<?php

require_once '../logica/Capilla.php';
require_once '../util/funciones/Funciones.php';

$fecha1 = $_POST["fecha_inicio"];
$fecha2 = $_POST["fecha_fin"];
$capilla = $_POST["capilla"];

try {

    $object = new Capilla();
    $resultado = $object->utilidades($fecha1,$fecha2,$capilla);
    if($resultado){
        Funciones::imprimeJSON(200, "", $resultado);// JSON permite compartir datos entre aplicaciones; 200 CORRECTO
    }else{
        Funciones::imprimeJSON(203, "No hubo resultados en la busqueda","");// JSON permite compartir datos entre aplicaciones; 200 CORRECTO

    }


        
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
    
}


