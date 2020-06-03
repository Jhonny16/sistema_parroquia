<?php

require_once '../datos/Conexion.php';


class Hora extends Conexion {
    public function cargarDatosHora(){
        try {
            $sql = "select
                            *

                    from 
                            horario_patron

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
