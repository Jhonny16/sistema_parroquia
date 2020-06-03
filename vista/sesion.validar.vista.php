<?php

require_once '../util/funciones/Funciones.class.php'; //para imprimir estilos y mensajes personalizados

session_name("programacionII");
session_start();

/*Validamos si el usuario ha iniciado sesión.
 *En el caso no ha iniciado sesion, se mostrara
 * un error y despues será redireccionado a la pagina index.html 
 */

if( ! isset($_SESSION["nombre"])){
    Funciones::mensaje("No has iniciado sesión", "e", "index.html",5);
    exit;    
}

/*Leer los datos almacenados en la sesión*/
$sesion_nombre_usuario = ucwords(strtolower ($_SESSION["nombre"]));
$sesion_cargo_usuario =  ucwords(strtolower ($_SESSION["cargo"]));
$sesion_email_usuario =  $_SESSION["email"];
$sesion_dni_usuario =  $_SESSION["dni"];
$sesion_cargo_id =  $_SESSION["cargo_id"];
$sesion_capilla_id =  $_SESSION["capilla_id"];
$sesion_rol_name =  $_SESSION["rol_name"];
$sesion_rol_id  =  $_SESSION["rol_id"];
$sesion_parroquia_id  =  $_SESSION["parroquia_id"];
$sesion_user_id  =  $_SESSION["user_id"];

/*Validar si existe la foto con el DNI del usuario*/

$foto = $sesion_dni_usuario;

if (file_exists("../fotos/" . $foto. ".jpg")) {
   $foto = "../fotos/"  . $foto. ".jpg";    
} else if (file_exists("../fotos/" . $foto. ".png")) {
   $foto = "../fotos/"  . $foto. ".png";    
}else {
    $foto ="../fotos/default.jpg";    
}

