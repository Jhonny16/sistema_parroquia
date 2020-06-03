<?php
/**
 * Created by PhpStorm.
 * User: jhonny
 * Date: 02/05/19
 * Time: 09:05 PM
 */

require_once '../datos/Conexion.php';

class Rol extends Conexion
{

    public function lista () {
        try {
            $sql="
                select * from rol  ";
            $sentencia = $this->dbLink->prepare("$sql");
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }

}