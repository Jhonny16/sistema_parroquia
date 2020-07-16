<?php
/**
 * Created by PhpStorm.
 * User: tito_
 * Date: 16/10/2018
 * Time: 1:59 AM
 */

require_once '../logica/Reportes.php';
require_once '../util/funciones/Funciones.php';
require_once '../reportes/Help.php';

$fecha_inicial = $_POST["busqueda_fecha_inicial"];
$fecha_final = $_POST["busqueda_fecha_final"];
$hora_inicial = $_POST["busqueda_hora_inicial"];
$hora_final = $_POST["busqueda_hora_final"];
$capilla_id = $_POST["busqueda_capillaid"];
$tipo_culto_id = $_POST["busqueda_tipo_culto_id"];
$tipo_culto = "C";
$user_name = $_POST["user_name"];


try {
    $obj = new Reportes();

    $result = $obj->find_misa($fecha_inicial,$fecha_final,$hora_inicial,$hora_final,$capilla_id,$tipo_culto,$tipo_culto_id);

} catch (Exception $exc) {
    Funciones::mensaje($exc->getMessage(), "e");
}

$htmlDatos = '  
   <table style="font-size:16px;width:100%">
        <head >
            <tr style="text-align: center">
                <th colspan="2"><img src="../imagenes/cruz.png" style="width: 3em" alt=""><h3> ' . $result[0]["cap_nombre"] . '</h3></th>
                <th></th>
            </tr>
            <tr style="color:#878787">
                <td style="text-align: left;font-style: oblique">Desde: ' . $fecha_inicial . ' / Hasta:  ' . $fecha_final . '</td>    
                <td style="text-align: left;font-style: oblique">Hora: ' . $hora_inicial . ' - ' . $hora_final . '</td>    
            </tr>
              
            <tr style="color:#878787">
                <td style="text-align: left;font-style: oblique">Tipo: Misa Comunitaria</td>    
            </tr>
        </head>
   </table>
   <hr>
       <table style="font-size:16px;width:98%">
           
            <body>
                <tr>
                    <td >
                        <table style="font-size:12px;width:100%;  border-collapse: collapse;margin: 15px;padding: 15px;
                        border: 1px solid #9d9d9d;" class="table table-bordered">
                            <head>
                                <tr style=" border: 1px solid #9d9d9d;color: #00cc66">
                                    <th>#</th>
                                    <th>Fecha</th>
                                    <th>Hora</th>
                                    <th>Nombres y Apellidos</th>
                                    <th>Culto</th>
                                    <th>Documento</th>
                                    <th>Recibo</th>
                                    <th>Importe</th>
                                    <th>Estado</th>
                                </tr>                                
                            </head>
                            <body> ';

for ($i = 0; $i < count($result); $i++) {

    $htmlDatos .= '<tr style="color: #3a87ad">';
    $htmlDatos .= '<td style=" border: 0.5px solid #dcd9de;">' . ($i + 1) . '</td>';
    $htmlDatos .= '<td style=" border: 0.5px solid #dcd9de;">' . $result[$i]["fecha"] . '</td>';
    $htmlDatos .= '<td style=" border: 0.5px solid #dcd9de;">' . $result[$i]["hora_hora"] . '</td>';
    $htmlDatos .= '<td style=" border: 0.5px solid #dcd9de;">' . $result[$i]["dirigido"] . '</td>';
    $htmlDatos .= '<td style=" border: 0.5px solid #dcd9de;">' . $result[$i]["tipoculto_detalle"] . '</td>';
    $htmlDatos .= '<td style=" border: 0.5px solid #dcd9de;">' . $result[$i]["reserva"] . '</td>';
    $htmlDatos .= '<td style=" border: 0.5px solid #dcd9de;">' . $result[$i]["pago"] . '</td>';
    $htmlDatos .= '<td style=" border: 0.5px solid #dcd9de;">' . $result[$i]["importe"] . '</td>';
    $htmlDatos .= '<td style=" border: 0.5px solid #dcd9de;">' . $result[$i]["estado"] . '</td>';

    $htmlDatos .= '</tr>';
}

$htmlDatos .= '</body>';

//echo $htmlDatos;
$titulo = 'REPORTE MISA COMUNITARIA';
$htmlReporte = Help::exportar_pdf(utf8_encode($htmlDatos));
Help::generarReporte($htmlReporte, 2, 'Reporte_misa_comunitaria',"horizontal");




