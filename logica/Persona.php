<?php
/**
 * Created by PhpStorm.
 * User: jhonny
 * Date: 12/05/19
 * Time: 12:55 PM
 */

require_once '../datos/Conexion.php';

class Persona extends Conexion
{

    public function listar()
    {
        try {

            $sql = "
                select p.*, c2.car_nombre from persona p inner join cargo c2 on p.car_id = c2.car_id 
                where p.car_id not in (5,6)";
            $sentencia = $this->dbLink->prepare($sql);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;


        } catch (Exception $exc) {
            throw $exc;
        }
    }

}