<?php
/**
 * Created by PhpStorm.
 * User: tito_
 * Date: 16/10/2018
 * Time: 1:59 AM
 */

require_once '../logica/Capilla.php';
require_once '../util/funciones/Funciones.php';
require_once '../reportes/Help.php';

$fecha1 = $_POST["fecha_inicio"];
$fecha2 = $_POST["fecha_fin"];
$capilla = $_POST["capilla"];
$usuario = $_POST['usuario'];

try {
    $object = new Capilla();
    $result = $object->utilidades($fecha1,$fecha2,$capilla);
} catch (Exception $exc) {
    Funciones::mensaje($exc->getMessage(), "e");
}


$htmlDatos = '  
<table style="font-size:11px;width:100%">
    <thead>
         <tr style="background-color: #f9f9f9; height:25px;">
            <th style="color:#26B99A">N°</th>
            <th style="color:#26B99A">CLIENTE</th>
            <th style="color:#26B99A">CELEBRACION</th>
            <th style="color:#26B99A">HORA</th>
            <th style="color:#26B99A">FECHA</th>
            <th style="color:#26B99A">SUB TOTAL</th>
        </tr>
    </thead>
    <tbody >';
        $num = 0;
        $suma = 0.00;
        for ($i=0; $i<count($result);$i++) {
            $num++;
            $suma = $result[$i]["total"] + $suma;

            $htmlDatos .= '<tr>';
            $htmlDatos .= '<td>'. $num .'</td>';
            $htmlDatos .= '<td>'.$result[$i]["cliente"].'</td>';
            $htmlDatos .= '<td>'.$result[$i]["celebracion"].'</td>';
            $htmlDatos .= '<td>'.$result[$i]["hora_hora"].'</td>';
            $htmlDatos .= '<td>'.$result[$i]["fecha"].'</td>';
            $htmlDatos .= '<td style="text-align: right">S/. '.$result[$i]["total"].'</td>';
            $htmlDatos .='</tr>';
        }
$htmlDatos .= '</tbody>';
$htmlDatos .= '<tfoot>';
$htmlDatos .= '<tr>';
$htmlDatos .= '<th colspan="5" style="text-align: center">TOTAL</th>';
$htmlDatos .= '<th style="text-align: right">S/. '. round($suma,2) .'</th>';
$htmlDatos .= '<th></th>';
$htmlDatos .= '</tr>';
$htmlDatos .= '</tfoot>';
$htmlDatos .= '</table>';

$capilla = $result[0]["capilla"];
//echo $htmlDatos;
$titulo = 'Reporte de Utilidades';
$htmlReporte = Help::export_pdf(utf8_encode($htmlDatos), $usuario, $titulo,$capilla);
Help::generarReporte($htmlReporte, 2, "Reporte_ventas");




