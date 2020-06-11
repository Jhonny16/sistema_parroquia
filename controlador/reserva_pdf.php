<?php
/**
 * Created by PhpStorm.
 * User: tito_
 * Date: 16/10/2018
 * Time: 1:59 AM
 */

require_once '../logica/reserva.php';
require_once '../util/funciones/Funciones.php';
require_once '../reportes/Help.php';

$horario_id = 0;
$reserva_id = $_POST["reserva_id"];
$persona_dni = '0';
$user_name = $_POST['user_name'];

try {
    $obj = new reserva();
    $obj->setHorarioId($horario_id);
    $obj->setId($reserva_id);
    $obj->setClienteDni($persona_dni);

    $result = $obj->listar_por_horario();

} catch (Exception $exc) {
    Funciones::mensaje($exc->getMessage(), "e");
}

$htmlDatos = '  
   <table style="font-size:14px;width:100%">
        <head>
            <th>
                <td style="text-align: left"><img src="../imagenes/cruz.png" style="width: 1em" alt=""> ' . $result[0]["pago_code"] . '</td>    
                <td style="text-align: right">Fecha: ' . $result[0]["fecha_pago"] . '</td>    
            </th>
        </head>
   </table>
   <hr>
   <table style="font-size:12px;width:100%">
            <body>
                <tr>
                    <td>
                        <p><strong>Cliente:</strong></p>
                        <p>' . $result[0]["cliente"] . '</p>
                        <p>Tipo de culto: ' . $result[0]["tc_nombre"] . '</p>
                    </td>
                    <td>
                        <p>Ofrece(n):</p>
                        <p>' . $result[0]["ofrece"] . '</p>
                        <p>Horario: ' . $result[0]["horario"] . '</p>
                    </td>
                    <td>
                        <p><strong># ' . $result[0]["code"] . '</strong></p>
                        <p>Estado: ' . $result[0]["estado"] . '</p>
                        <p>Fecha reserva: ' . $result[0]["fecha_reserva"] . '</p>
                    </td>
                </tr>    
            </body>
    </table>
    <table style="font-size:12px;width:100%">
            <body>
                <tr>
                    <td >
                        <table style="font-size:12px;width:90%" class="table table-bordered">
                            <head>
                                <tr>
                                    <th>#</th>
                                    <th>Detalle</th>
                                    <th>Intención</th>
                                    <th>Importe</th>
                                </tr>                                
                            </head>
                            <body> ';
                                $total_limosna = 0;
                                $total_templo = 0;
                                $total_cantor = 0;
                                for ($i = 0; $i < count($result); $i++) {
                                    $total_limosna = $total_limosna + $result[$i]["limosna"] ;
                                    $total_templo = $total_templo + $result[$i]["templo"] ;
                                    $total_cantor = $total_cantor + $result[$i]["cantor"] ;

                                    $htmlDatos .= '<tr>';
                                    $htmlDatos .= '<td >' . ($i + 1) . '</td>';
                                    $htmlDatos .= '<td>' . $result[$i]["tipoculto_detalle"] . '</td>';
                                    $htmlDatos .= '<td>' . $result[$i]["dirigido"] . '</td>';
                                    if ($result[$i]['tipoculto_type'] == 'Comunitario'){
                                        $htmlDatos .= '<td style="text-align: right">S/. ' . $result[$i]["importe"] . '</td>';

                                    }else{
                                        $htmlDatos .= '<td style="text-align: right">S/. -</td>';

                                    }
                                    $htmlDatos .= '</tr>';
                                }

            $htmlDatos .= '</body>
                        </table>
                    </td> 
                     <td >
                        <table style="font-size:12px;width:90%" class="table table-bordered">
                            <body>
                                <tr>
                                    <th>Limosna: </th>';
                                    if ($result[0]['tipoculto_type'] == 'Comunitario'){
                                        $htmlDatos .=  '<td  style="text-align: right">s/.' . $result[0]['total'].'</td>';
                                    }else{
                                        $htmlDatos .= ' <td  style="text-align: right">s/. ' . $total_limosna .'</td>';
                                    };
                    $htmlDatos .=  '
                                </tr>  
                                <tr>
                                    <th>Templo</th>';
                                        if ($result[0]['tipoculto_type'] == 'Comunitario'){
                                            $htmlDatos .=  '<td  style="text-align: right">s/. -</td>';
                                        }else{
                                            $htmlDatos .= ' <td  style="text-align: right">s/. ' . $total_templo .'</td>';
                                        };
                    $htmlDatos .=   ' 
                                </tr>    
                                <tr>
                                    <th>Cantor</th>';
                                        if ($result[0]['tipoculto_type'] == 'Comunitario'){
                                            $htmlDatos .=  '<td  style="text-align: right">s/. -</td>';
                                        }else{
                                            $htmlDatos .= ' <td  style="text-align: right">s/. ' . $total_cantor .'</td>';
                                        };
                                        $htmlDatos .=   ' 
                                </tr>   
                                <tr>
                                    <th>Total</th>
                                    <td  style="text-align: right">s/. ' . $result[0]["total"] . '</td>
                                </tr> 
                            </body>
                        </table>
                    </td>
                   
                  
                </tr>    
            </body>
    </table>
<table style="font-size:11px;width:100%">
            <body>
                <tr>
                    <td >
                        <table style="font-size:11px;width: 90%" class="table table-bordered">
                            
                            <body> <tr><td>
                             <div class="col-xs-6">
                                                <p class="lead">Métodos de pago:</p>
                                                <img src="../util/lte/dist/img/credit/visa.png" alt="Visa">
                                                <img src="../util/lte/dist/img/credit/mastercard.png" alt="Mastercard">
                                                <img src="../util/lte/dist/img/credit/american-express.png" alt="American Express">
                                                <img src="../util/lte/dist/img/credit/paypal2.png" alt="Paypal">

                                                <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                                                    Puede realizar pagos por éstas entidades, de lo contrario puede hacer el depóstio
                                                    a la cuenta bancaria BCP : 010022525822
                                                </p>
                                            </div>

                                          
</td></tr></body>
                        </table>
                    </td> 
                     <td>
                    <table  style="font-size:11px;width: 90%" class="table table-striped">
                    <thead>
                    <tr>
                    <th>Recordamos:</th>
                    <th></th>
                    <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                    <td>1. La Santa Misa es la renovación del Sacrificio de Cristo en la Cruz. Tiene un valor
                    espiritual infinito. Lo que por su celebración es una limosna no un pago</td>
                    </tr>
                    <tr>
                    <td>2. Es conveniente participantes en la Comunión Eucarística. Confiesa con anticipación.</td>
                    </tr>
                    <tr>
                    <td>3. No traer imágenes o cuadros de Santos a la Iglesia.</td>
                    </tr>
                    
                    </tbody>
                    </table>
                    </td>
                   
                  
                </tr>    
            </body>
    </table>







';

//echo $htmlDatos;
$titulo = 'IMPRESIÓN DE RESERVA';
$htmlReporte = Help::exportar_pdf(utf8_encode($htmlDatos));
Help::generarReporte($htmlReporte, 2, 'PDF_reserva');




