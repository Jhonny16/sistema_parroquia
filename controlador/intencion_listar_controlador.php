<?php

require_once '../logica/Intencion.class.php';
require_once '../util/funciones/Funciones.php';

$fecha1 = $_POST["fecha_inicio"];
$fecha2 = $_POST["fecha_fin"];
$estado = $_POST["estado"];
$celebracion = $_POST["celebracion"];
$type = $_POST["type"];
$capilla = $_POST["capilla"];

try {

    $object = new Intencion();
    $resultado = $object->listar($fecha1,$fecha2,$celebracion,$estado,$type,$capilla);
    if($resultado){
        Funciones::imprimeJSON(200, "", $resultado);// JSON permite compartir datos entre aplicaciones; 200 CORRECTO
    }else{
        Funciones::imprimeJSON(203, "No hubo resultados en la busqueda","");// JSON permite compartir datos entre aplicaciones; 200 CORRECTO

    }


        
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
    
}


