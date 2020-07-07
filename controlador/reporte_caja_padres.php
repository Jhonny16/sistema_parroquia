<?php
require_once '../logica/Reportes.php';
require_once '../util/funciones/Funciones.php';

try {

    $capilla_id =$_POST['capilla_id'];
    $anio =$_POST['anio'];
    $obj = new Reportes();
    $pagos= $obj->pago_por_padre($capilla_id, $anio);
    $misas = $obj->misas_por_padre($capilla_id, $anio);

    $data = array();
    $data[0] = $pagos;
    $data[1] = $misas;
    Funciones::imprimeJSON(200, "", $data);

} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");

}

