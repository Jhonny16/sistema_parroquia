<?php
/**
 * Created by PhpStorm.
 * User: jhonny
 * Date: 29/06/20
 * Time: 06:21 PM
 */
require_once '../logica/Reportes.php';
require_once '../util/funciones/Funciones.php';

try {
    $fecha_inicial =$_POST['fecha_inicial'];
    $fecha_final =$_POST['fecha_final'];
    $hora_inicial =$_POST['hora_inicial'];
    $hora_final =$_POST['hora_final'];
    $capilla_id =$_POST['capilla_id'];
    $tipoculto_id =$_POST['tipoculto_id'];
    $tipo_culto =$_POST['tipo_culto'];
    $obj = new Reportes();

    $hora1 = strtotime( $hora_inicial );
    $hora2 = strtotime( $hora_final );
    if($hora1 > $hora2){
        Funciones::imprimeJSON(203, "La hora inicial no debe ser mayor a la hora final", null);
        exit();
    }

    $resultado = $obj->find_misa($fecha_inicial,$fecha_final,$hora_inicial,$hora_final,$capilla_id,$tipo_culto,$tipoculto_id);
    if($resultado){
        Funciones::imprimeJSON(200, "", $resultado);
    }else{
        Funciones::imprimeJSON(203, "No se encontró resultado en la búsqueda", $resultado);
    }


} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");

}
