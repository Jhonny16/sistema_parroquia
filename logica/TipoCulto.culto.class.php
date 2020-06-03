<?php

require_once '../datos/Conexion.php';


class Culto extends Conexion {
    public function cargarDatosCulto(){
        try {
            $sql = "select
                            *

                    from 
                            culto

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
