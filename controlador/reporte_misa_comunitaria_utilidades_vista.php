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
    $capilla_id =$_POST['capilla_id'];
    $tipoculto_id =$_POST['tipoculto_id'];
    $tipo_culto =$_POST['tipo_culto'];
    $secretario_id =$_POST['secretario_id'];
    $estado=$_POST['estado'];
    $obj = new Reportes();

    $resultado = $obj->find_misa_utilidades($fecha_inicial,$fecha_final,$capilla_id,$tipo_culto,$tipoculto_id,$secretario_id,$estado);
    if($resultado){
        Funciones::imprimeJSON(200, "", $resultado);
    }else{
        Funciones::imprimeJSON(203, "No se encontró resultado en la búsqueda", $resultado);
    }


} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");

}
