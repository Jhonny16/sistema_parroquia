<?php

require_once '../logica/Reportes.php';
require_once '../util/funciones/Funciones.php';
require_once '../reportes/Help.php';

$fecha = $_POST["fecha"];
$user_name = $_POST["user_name"];

try {
    $obj = new Reportes();

    $result = $obj->misas_por_dia($fecha);

} catch (Exception $exc) {
    Funciones::mensaje($exc->getMessage(), "e");
}

$htmlDatos = '  
   <table style="font-size:16px;width:100%">
        <head >
            <tr style="text-align: center">
                <th colspan="2"><img src="../imagenes/cruz.png" style="width: 4em" alt=""><h2> ' . $result[0]["capilla_nombre"] . '</h2></th>
                <th></th>
            </tr>
            <tr style="color:#878787">
                <td style="text-align: left;font-style: oblique">
                <i class="fa fa-check"></i> Relación de misas.</td>    
           
            </tr>
              
            <tr style="color:#878787">
                <td style="text-align: left;font-style: oblique">Usuario : ' . $user_name. '</td>  
                <td style="text-align: left;font-style: oblique">Fecha: ' . $fecha . '</td>   ';

$htmlDatos .= '    
            </tr>
        </head>
   </table>
   <hr>
       <table style="font-size:16px;width:98%">
           
            <body>
                <tr>
                    <td >
                        <table style="width:100%;  border-collapse: collapse;margin: 15px;padding: 15px;
                        border: 0.2px solid #dcd9de;" class="table table-bordered">
                            <head>
                                <tr style=" border: 0.2px solid #dcd9de;color: #00cc66">
                                    <th>#</th>
                                    <th>Hora</th> 
                                    <th>Sacerdote</th> 
                                    <th>Cantor</th> 
                                </tr>                                
                            </head>
                            <body> ';
$array = array();
$array[0] = $result[0];
for ($i = 1; $i < count($result); $i++) {
    $sw = 0;
    for ($j = 0; $j < count($array); $j++) {
        if($result[$i]['id'] == $array[$j]['id']){
            $sw=1;
        }
    }
    if($sw==0){
        array_push($array,$result[$i]);
    }
}
for ($i = 0; $i < count($array); $i++) {
    $htmlDatos .= '<tr style="color: #2166a0">';
    $htmlDatos .= '<td style=" border: 0.2px solid #dcd9de;">' . ($i + 1) . '</td>';
    $htmlDatos .= '<td style=" border: 0.2px solid #dcd9de;">' . $result[$i]["horario_hora"]  . '</td>';
    $htmlDatos .= '<td style=" border: 0.2px solid #dcd9de;">' . $result[$i]["padre"] . '</td>';
    $htmlDatos .= '<td style=" border: 0.2px solid #dcd9de;">' . $result[$i]["nombre_cantor"] . '</td>';
    $htmlDatos .= '</tr>';
    $htmlDatos .= '<tr style="color: #878787" >
                                <td></td><td colspan="2">Itención:</td><td>Detalle: </td> </tr>';
    for ($j = 0; $j < count($result); $j++) {
        if($array[$i]['id'] == $result[$j]['id']){

            $htmlDatos .= '<tr style="color: #3a87ad; font-size: 14px">';
            $htmlDatos .= '<td></td><td style="" colspan="2">' . $result[$i]["dirigido"] . '</td>';
            $htmlDatos .= '<td style="" >' . $result[$i]["tipoculto_detalle"] . '</td>';
            $htmlDatos .= '</tr>';
        }
    }

}
//for ($i = 0; $i < count($result); $i++) {
//
//    $htmlDatos .= '<tr style="color: #3a87ad">';
//    $htmlDatos .= '<td style=" border: 0.2px solid #dcd9de;">' . ($i + 1) . '</td>';
//    $htmlDatos .= '<td style=" border: 0.2px solid #dcd9de;">' . $result[$i]["horario_hora"]  . '</td>';
//    $htmlDatos .= '<td style=" border: 0.2px solid #dcd9de;">' . $result[$i]["dirigido"] . '</td>';
//    $htmlDatos .= '</tr>';
//}

$htmlDatos .= '</body>';
$htmlDatos .= '</table>';

//echo $htmlDatos;
$htmlReporte = Help::exportar_pdf(utf8_encode($htmlDatos));
Help::generarReporte($htmlReporte, 2, 'Reporte_celebracion_' . $fecha, "vertical");




