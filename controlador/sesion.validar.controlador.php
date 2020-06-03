<?php

require_once '../logica/Sesion.class.php';
require_once '../util/funciones/Funciones.php';

try {
    $objSesion = new Sesion();
    $email = $_POST["txtEmail"];
    $clave = $_POST["txtClave"];
    
    $objSesion->setEmail($email);
    $objSesion->setClave($clave);
    
    $respuesta = $objSesion->iniciarSesion();
    
    //echo $respuesta;  
    
    switch ($respuesta) {
        case "CI": // Contraseña incorrecta
            Funciones::mensaje("La contraseña ingresada es incorrecta", "e", "../vista/index.html", 5);
            break;
        case "NE": // Usuario no existe
            Funciones::mensaje("El usuario no existe", "e", "../vista/index.html", 5);
            break;
        case "UI": // usuario inactivo
            Funciones::mensaje("El usuario está inactivo", "a", "../vista/index.html", 5);
            break;
        case "UC": // usuario CLIENTE
//            header("location:../vista/menu.principal.vista.php");
            header("location:../vista/principal_cliente_vista.php");
            break;
       
        default: // si ingresa al sistema
            header("location:../vista/menu.principal.vista.php");
            break;
    }
    
} catch (Exception $exc) {
    Funciones::mensaje($exc->getMessage(), "e");
}


