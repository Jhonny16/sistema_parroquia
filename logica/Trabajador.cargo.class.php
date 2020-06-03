<?php

require_once '../datos/Conexion.php';


class Cargo extends Conexion {
    public function cargarDatosCargo(){
        try {
            $sql = "select
                            *

                    from 
                            cargo
                    where car_id != 6

                    order by 
                            2                
                ";
            $sentencia = $this->dbLink->prepare($sql);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC); // para que devuelva todos los registos de la tabla hacia el combo
            return $resultado;            
            
        } catch (Exception $exc) {
            throw $exc;
        }
            
            }
}
