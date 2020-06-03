<?php
require_once '../client-php-master/autoload.php';
require_once '../logica/Trabajador.class.php';
require_once '../util/funciones/Funciones.php';


use SMSGatewayMe\Client\ApiClient;
use SMSGatewayMe\Client\Configuration;
use SMSGatewayMe\Client\Api\MessageApi;
use SMSGatewayMe\Client\Model\SendMessageRequest;

// Configure client
$config = Configuration::getDefaultConfiguration();
  //$token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJhZG1pbiIsImlhdCI6MTU2MDc4NzQ5NSwiZXhwIjo0MTAyNDQ0ODAwLCJ1aWQiOjY1NjQ4LCJyb2xlcyI6WyJST0xFX1VTRVIiXX0.Oev7uzSRbEuhzoAIkuGxr4V_ivyiWbPWop6eYYcyE90';

  $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJhZG1pbiIsImlhdCI6MTU2NzQ5NDczNCwiZXhwIjo0MTAyNDQ0ODAwLCJ1aWQiOjY1NjQ4LCJyb2xlcyI6WyJST0xFX1VTRVIiXX0.GYgrVKOlz16kuNl72ofwLxo9WEmRCsqtJVGFM8Apubo';
            
$config->setApiKey('Authorization', $token);
$apiClient = new ApiClient($config);
$messageClient = new MessageApi($apiClient);

$obj = new Trabajador();

$resultado = $obj->clientes_reserva_pagada();

$lista = array();
for ($i = 0; $i < count($resultado); $i++) {
    $telefono = $resultado[$i]["telefono"];
    $cliente = $resultado[$i]["cliente"];
    $hora = $resultado[$i]["hora_hora"];
    $celebracion = $resultado[$i]["celebracion"];
    $fecha = $resultado[$i]["fecha"];
    $estado = $resultado[$i]["estado"];
    $total = $resultado[$i]["total"];
    $capilla = $resultado[$i]["capilla"];

    if($estado == "Pendiente"){
        $sendMessageRequest1 = new SendMessageRequest([
            'phoneNumber' => $telefono,
            'message' => 'Sr(a). ' . $cliente. ' le hacemos recordar que el día  ' . $fecha. ' a las ' . $hora.' horas se realizará el(la) ' . $celebracion . ' en la capilla '. $capilla.' . Además adeuda el pago de la misma, por el monto de '. $total. ' Soles' ,
            'deviceId' => 113102
        ]);
    }else{
        $sendMessageRequest1 = new SendMessageRequest([
            'phoneNumber' => $telefono,
            'message' => 'Sr(a). ' . $cliente. ' le hacemos recordar que el día  ' . $fecha. ' a las ' . $hora.' horas se realizará el(la) ' . $celebracion . ' en la capilla '. $capilla ,
            'deviceId' => 113102
        ]);
    }

    $sendMessages = $messageClient->sendMessages([
        $sendMessageRequest1]);
}

Funciones::imprimeJSON(200, "Actualizacion exitosa", $sendMessages);



//print_r($sendMessages);