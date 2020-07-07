<?php
require_once '../logica/Reportes.php';
require_once '../util/funciones/Funciones.php';

try {

    $capilla_id =$_POST['capilla_id'];
    $anio =$_POST['anio'];
    $obj = new Reportes();
    $ingresos= $obj->ingresos_por_tipoculto($capilla_id, $anio);
    $egresos = $obj->egresos_por_cantor($capilla_id, $anio);

    $data = array();
    $data[0] = $ingresos;
    $data[1] = $egresos;
    Funciones::imprimeJSON(200, "", $data);



} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");

}

