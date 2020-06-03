<?php

require_once '../logica/Horario.php';
require_once '../util/funciones/Funciones.php';

try {
    $fecha1= $_POST["fecha1"];
    $fecha2 = $_POST["fecha2"];
    $hora = $_POST["hora"];
    $capilla = $_POST["capilla"];
    $tipo_culto = $_POST["tipo_culto"];

    $obj = new Horario();
    $obj->setHoraId($hora);
    $obj->setCapillaId($capilla);
    $obj->setTipocultoId($tipo_culto);

    $resultado = $obj->listar($fecha1,$fecha2);
    if($resultado){
        Funciones::imprimeJSON(200, "", $resultado);// JSON permite compartir datos entre aplicaciones; 200 CORRECTO
    }else{
        Funciones::imprimeJSON(203, "No se encontró resultado en la búsqueda", $resultado);// JSON permite compartir datos entre aplicaciones; 200 CORRECTO
    }

        
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
    
}


