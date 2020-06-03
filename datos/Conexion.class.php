<?php

require_once 'configuracion.php';

class Conexion {
    protected $dbLink;
    

    public function __construct() {
        $this->abrirConexion();
    }
    
    public function __destruct() {
        $this->dbLink = NULL;
    }

    protected function abrirConexion(){
        $servidor = "pgsql:host=".BD_SERVIDOR.";port=".BD_PUERTO.";dbname=".BD_NOMBRE_BD;
        $usuario = BD_USUARIO;
        $clave = BD_CLAVE;
        
        try {
            $this->dbLink = new PDO($servidor, $usuario, $clave);
            $this->dbLink->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
        return $this->dbLink;
    }
    
}
