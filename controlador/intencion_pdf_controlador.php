<?php
/**
 * Created by PhpStorm.
 * User: tito_
 * Date: 16/10/2018
 * Time: 1:59 AM
 */

require_once '../logica/Intencion.class.php';
require_once '../util/funciones/Funciones.php';
require_once '../reportes/Help.php';

$id = $_POST["reserva_id"];
$usuario = $_POST['usuario'];

try {
    $object = new Intencion();
    $result = $object->report($id);
} catch (Exception $exc) {
    Funciones::mensaje($exc->getMessage(), "e");
}

$htmlDatos = '  
 <table style="font-size:12px;width:100%">
      <head>
        <tr>
        <th>CLIENTE:</th>
        <th>NUM. RESERVA:</th>
        <th>FECHA/HORA:</th>
        <th>ESTADO:</th>
        </tr>
    </head> 
    <body>
        <tr>
            <td>'. $result[0]["cliente"].'</td>
            <td>'. $result[0]["code"].'</td>
            <td>'. $result[0]["fecha"].' / '. $result[0]["hora_hora"].'  </td>
            <td>'. $result[0]["estado"].'</td>
        </tr>
    </body>
 </table>
 <br>
<table style="font-size:12px;width:100%">
    <thead>
         <tr style="background-color: #f9f9f9; height:25px;">
            <th style="color:#26B99A">Tipo Culto</th>
            <th style="color:#26B99A">Diridigo a</th>
            <th style="color:#26B99A">Tipe</th>
            <th style="color:#26B99A">Importe</th>           
        </tr>
    </thead>
    <tbody >';
$num = 0;
$suma = 0.00;
for ($i = 0; $i < count($result); $i++) {

    $htmlDatos .= '<tr>';
    $htmlDatos .= '<td>' . $result[$i]["tipo_culto"] . '</td>';
    $htmlDatos .= '<td>' . $result[$i]["dirigido"] . '</td>';
    $htmlDatos .= '<td>' . $result[$i]["type"] . '</td>';
    $htmlDatos .= '<td style="text-align: right">S/. ' . $result[$i]["importe"] . '</td>';
    $htmlDatos .= '</tr>';
}
$htmlDatos .= '</tbody>';
$htmlDatos .= '<tfoot>';
$htmlDatos .= '<tr>';
$htmlDatos .= '<th colspan="3" style="text-align: center">TOTAL</th>';
$htmlDatos .= '<th style="text-align: right">S/. ' . $result[0]["total"] . '</th>';
$htmlDatos .= '<th></th>';
$htmlDatos .= '</tr>';
$htmlDatos .= '</tfoot>';
$htmlDatos .= '</table>';

$capilla = $result[0]["capilla"];
//echo $htmlDatos;
$titulo = 'IMPRESIÓN DE RESERVA';
$nombre = 'REP_'. $result[0]["code"];
$htmlReporte = Help::export_pdf(utf8_encode($htmlDatos), $usuario, utf8_encode($titulo), utf8_encode($capilla));
Help::generarReporte($htmlReporte, 2, $nombre);




