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
  <section class="invoice" >
                                    
        <div class="row">
            <div class="col-xs-12">
                <h2 class="page-header">
                    <img src="../imagenes/cruz.png" style="width: 1em" alt="">' . $result[0]["pago_code"] . '
                    <small class="pull-right">Fecha: ' . $result[0]["fecha"] . '</small>
                </h2>
            </div>
            <!-- /.col -->
        </div>
          <div class="row">
              <div class="col-xs-12">
                   <table class="table" style="border: 0px;
                                            margin: 0px;
                                            padding: 0px;">
                        <tbody >
                            <tr>
                                <td>
                                                                <div class="col-sm-4 invoice-col">
                                                    Cliente
                                                    <address>
                                                <strong>' . $result[0]["cliente"] . '</strong><br>
                                                Ofrece(n): ' . $result[0]["ofrece"] . '<br>
                                                Horario: ' . $result[0]["horario"] . '<br>
                                                </address>
                                                </div>
                                </td>
                                <td>
                                                                <div class="col-sm-4 invoice-col">
                                                    Padre
                                                    <address>
                                                <strong> ' . $result[0]["padre"] . '</strong><br>
                                                Cantor: ' . $result[0]["cantor"] . '<br>
                                                Tipo comunitaria: ' . $result[0]["detail_comunitaria"] . '<br>
                                                </address>
                                                </div>
                                </td>
                                <td>
                                 <div class="col-sm-4 invoice-col">
                                                    <b>' . $result[0]["code"] . '</b><br>
                                                    <b>Estado:</b> ' . $result[0]["estado"] . '<br>
                                                
                                                </div>
                                 </td>
                            </tr>

                        </tbody>
                    </table>
               </div>
           
              
          </div>
           <div class="row">
                <div class="col-xs-12" style="border: 0px;margin: 0px;padding: 0px;"">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Intención</th>
                                <th>Importe</th>
                            </tr>
                            </thead>
                            <tbody >';

                            for ($i = 0; $i < count($result); $i++) {

                                $htmlDatos .= '<tr>';
                                $htmlDatos .= '<td>' . ($i + 1) . '</td>';
                                $htmlDatos .= '<td>' . $result[$i]["dirigido"] . '</td>';
                                $htmlDatos .= '<td style="text-align: right">S/. ' . $result[$i]["importe"] . '</td>';
                                $htmlDatos .= '</tr>';
                            }

$htmlDatos .= '                 </tbody>
                        </table>
                    </div>
           </div>
          <div class="row">
                <div class="col-xs-12">
                    <table class="table" style="border: 0px;margin: 0px;padding: 0px;">
                        
                        <tbody >
                        <tr>
                             <td>
                                                          <p class="lead">Métodos de pago:</p>
                                                <img src="../util/lte/dist/img/credit/visa.png" alt="Visa">
                                                <img src="../util/lte/dist/img/credit/mastercard.png" alt="Mastercard">
                                                <img src="../util/lte/dist/img/credit/american-express.png" alt="American Express">
                                                <img src="../util/lte/dist/img/credit/paypal2.png" alt="Paypal">
                            
                                                <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                                                    Puede realizar pagos por éstas entidades, de lo contrario puede hacer el depóstio
                                                    a la cuenta bancaria BCP : 010022525822
                                                </p>
                            </td>
                             <td>
                                                              <table class="table">
                                                            <tr>
                                                                <th style="width:50%">Subtotal:</th>
                                                                <td style="text-align: right">s/. ' . $result[0]["total"] . '</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Impuesto(18%)</th>
                                                                <td style="text-align: right">s/. 0.00</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Total:</th>
                                                                <td style="text-align: right">s/. ' . $result[0]["total"] . '</td>
                                                            </tr>
                                                        </table>
                            </td>
                        </tr>

                        </tbody>
                    </table>
                </div>
           </div>

           
       
    </section>';
//echo $htmlDatos;
$titulo = 'IMPRESIÓN DE RESERVA';
$htmlReporte = Help::exportar_pdf(utf8_encode($htmlDatos));
Help::generarReporte($htmlReporte, 2, 'PDF_reserva');




