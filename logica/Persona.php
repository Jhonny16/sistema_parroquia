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
                select p.*, c2.car_nombre,c2.car_id as cargo_id from persona p inner join cargo c2 on p.car_id = c2.car_id 
                where p.car_id not in (5,6)";
            $sentencia = $this->dbLink->prepare($sql);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;


        } catch (Exception $exc) {
            throw $exc;
        }
    }

    public function lista_secretarios()
    {
        try {

            $sql = "
               select
                u.usu_id,
                       p.per_apellido_paterno || ' '|| p.per_apellido_materno || ' ' || p.per_nombre as secretario
                from usuario u inner join persona p on u.per_iddni = p.per_iddni
                where p.car_id = 3";
            $sentencia = $this->dbLink->prepare($sql);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;


        } catch (Exception $exc) {
            throw $exc;
        }
    }

}