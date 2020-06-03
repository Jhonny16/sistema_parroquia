<?php
/**
 * Created by PhpStorm.
 * User: tito_
 * Date: 19/12/2018
 * Time: 10:10 AM
 */
require_once '../util/funciones/Funciones.php';


$fecha_hoy  = $_POST["fecha_hoy"];
$dias  = $_POST["dias"];
$fecha  = $_POST["fecha_tipo_culto"];
try {

    $date1 = new DateTime($fecha_hoy);
    $date2 = new DateTime($fecha);
    $interval = $date1->diff($date2);
    $dia = $interval->format('%R%a');
    if((int)$dia < (int)$dias){
        Funciones::imprimeJSON(203, "No puede seleccionar esta fecha. No se acerca al tiempo mínimo de " . $dias." día(s) ", "");
    }else{
        Funciones::imprimeJSON(200, "Bien, esta dentro del tiempo estimado" , $dias);
    }



} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}


