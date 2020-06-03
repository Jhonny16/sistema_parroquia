<?php
/**
 * Created by PhpStorm.
 * User: jhonny
 * Date: 19/05/19
 * Time: 04:21 PM
 */

require_once '../client-php-master/autoload.php';
require_once '../logica/Intencion.class.php';
require_once '../util/funciones/Funciones.php';


use SMSGatewayMe\Client\ApiClient;
use SMSGatewayMe\Client\Configuration;
use SMSGatewayMe\Client\Api\MessageApi;
use SMSGatewayMe\Client\Model\SendMessageRequest;

$config = Configuration::getDefaultConfiguration();
$token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJhZG1pbiIsImlhdCI6MTU1NzA3MTEwOCwiZXhwIjo0MTAyNDQ0ODAwLCJ1aWQiOjI1MDUzLCJyb2xlcyI6WyJST0xFX1VTRVIiXX0.0UIOe6eY68mUADu8gy5zTHFGmHCliqpePEgcSuKYp44';

$config->setApiKey('Authorization', $token);
$apiClient = new ApiClient($config);
$messageClient = new MessageApi($apiClient);


$id = $_POST['id'];
$obj = new Intencion();

$resultado = $obj->sms($id);
$lista = array();

if($resultado){
    $telefono =$resultado['per_telefono'];
    $mensaje = "Sr(a) ". $resultado['cliente']. " su reserva de tipo ". $resultado['tc_nombre'] ." se celebrará el día 
    ".$resultado['fecha']." a horas ". $resultado['hora_hora']. " en la capilla ". $resultado['cap_nombre'] ." ";

    $sendMessageRequest1 = new SendMessageRequest([
        'phoneNumber' => $telefono,
        'message' => $mensaje,
        'deviceId' => 106060
    ]);

    $sendMessages = $messageClient->sendMessages([
        $sendMessageRequest1]);

    Funciones::imprimeJSON(200, "Mensaje Enviado", $sendMessages);

}else{
    Funciones::imprimeJSON(203, "No se envio mensaje", "");
}



