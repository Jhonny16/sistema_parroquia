<?php

require_once '../datos/Conexion.php';

class HorarioPatron extends Conexion {
    
    private $hora_id;
    private $hora_hora;
    
    function getHora_id() {
        return $this->hora_id;
    }

    function getHora_hora() {
        return $this->hora_hora;
    }

    function setHora_id($hora_id) {
        $this->hora_id = $hora_id;
    }

    function setHora_hora($hora_hora) {
        $this->hora_hora = $hora_hora;
    }

    
                  
    public function listar () {
        try {
            $sql="select
                        h.hora_id,
                        h.hora_hora 
                        
                from

                        horario_patron h

                order by 

                        h.hora_hora
                    ";
            $sentencia = $this->dbLink->prepare("$sql");
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);      
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;            
        }
    }  
    
    public function eliminar ($p_hora_id){
       /*Validar si el cargo tiene horario programados*/
        $sql = "
                select 
                        hora_id

                from
                        horario_programado

                where
                        hora_id = :p_hora_id;
                 ";
            $sentencia = $this->dbLink->prepare("$sql");
            $sentencia->bindParam(":p_hora_id", $p_hora_id);
            $sentencia->execute();
            
            if ($sentencia->rowcount()){
                throw new Exception("No es posible eliminar este Horario por motivos que tiene horarios en la parroquia registrados");           
            }
 
        /*Iniciar la transacción*/
        $this->dbLink->beginTransaction();
        try {
            /*Elaborar la cosulta SQL para eliminar la parroquia por codigo de parroquia*/
            $sql="
                delete from horario_patron 
                where hora_id = :p_hora_id";
            
            //declarar una sentencia en base a la consulta SQL
            $sentencia = $this->dbLink->prepare("$sql");
            
            //Enviar los valores a los parámetros de la sentencia
            $sentencia->bindParam(":p_hora_id", $p_hora_id);
            //Ejecutar la sentencia
            $sentencia->execute();
            //Si todo lo anterior se ha ejecutado correctamente, entonces se confirma la transacción
            $this->dbLink->commit();
            //Si retorna "TRUE", significa que la transacciòn ha sido exitosa
            return true;
            
        } catch (Exception $exc) {
            //Abortamos la transaccion
             $this->dbLink->rollBack();
             //Lanzar el error hacia la siguiente capa (controlador)
            throw $exc;
        }   
    }
    public function agregar () {
        $this->dbLink->beginTransaction();
        try {
            /*generar el correlativo del codigo de la parroquia que se ha de registrar*/
            $sql = "select * from f_generar_correlativo('horario_patron') as correlativo";
            $sentencia = $this->dbLink->prepare($sql);
            $sentencia->execute();
            
            if($sentencia->rowCount()){ /*rowcount es un metodo por tanto lleva parentesis*/
                //si se encontro el correlativo para la tabla cargo
                $resultado = $sentencia->fetch(PDO::FETCH_ASSOC); /*FETCH_ASSOC para no repetir la informacion y obtenerla con el nombre del campo*/
                $nuevohora_id = $resultado["correlativo"]; //cargar nuevo codigo de horario_patron
                $this->setHora_id($nuevohora_id);
                
                /*INSERTAR EN LA TABLA HORARIO_PATRON*/
                $sql = "
                    INSERT INTO horario_patron
                                (
                                 hora_id, 
                                 hora_hora 
                                )

                        VALUES (
                                :p_hora_id, 
                                :p_hora_hora
                                );
                        ";
                $sentencia= $this->dbLink->prepare($sql);
                $sentencia->bindParam(":p_hora_id", $this->getHora_id());
                $sentencia->bindParam(":p_hora_hora", $this->getHora_hora());
                                
                $sentencia->execute();
                
                /*ACTUALIZAR EL CORRELATIVO PARA LA TABLA HORARIO_PATRON EN + 1*/
                $sql = "update correlativo set numero = numero + 1 where tabla = 'horario_patron'";
                $sentencia= $this->dbLink->prepare($sql); 
                $sentencia->execute();
                
                //CONFIRMAR LA TRANSACCION
                $this->dbLink->commit();
                
                return TRUE; //RETORNA VERDARERO CUANDO HA REGISTRADO TODO CORRECTAMENTE
            }else{
                //no se encontro el correlativo para la tabla parroquia
                throw new Exception("No se encontró el correlativo para la tabla horario_patron");                
            }
        } catch (Exception $exc) {
            $this->dbLink->rollback();//ABORTAR /DESHACER TODO LO QUE SE HA             
            throw $exc;            
        }
    }
    
    /*EDITAR HORARIO POR EL CODIGO*/
    public function leerDatos($p_hora_id) {
        try {
            $sql = "
                    select 
                            hora_id,
                            hora_hora
                    from
                            horario_patron h

                    where   hora_id = :p_hora_id
                   ";
            
            $sentencia = $this->dbLink->prepare($sql);
            $sentencia->bindParam(":p_hora_id",$p_hora_id);
            $sentencia->execute();
            $resultado = $sentencia->fetch (PDO::FETCH_ASSOC);
            return $resultado;
            
        } catch (Exception $exc) {
            throw $exc;
        }
    }
    
    
    public function editar() {
        $this->dbLink->beginTransaction();
        
        try {
            $sql = "
                UPDATE 
                        horario_patron
                SET	
                        hora_hora		= :p_hora_hora

                 WHERE 
                        hora_id                 = :p_hora_id

                 ";
            $sentencia= $this->dbLink->prepare($sql);
                
                $sentencia->bindParam(":p_hora_hora", $this->getHora_hora());
                $sentencia->bindParam(":p_hora_id", $this->getHora_id());
                $sentencia->execute();
                
                $this->dbLink->commit();
                
                return TRUE;
                
        } catch (Exception $exc) {
            $this->dbLink->rollBack();
            throw $exc;
        }
            
    }
}
