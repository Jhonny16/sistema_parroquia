<?php

require_once '../datos/Conexion.php';

class Ocupacion extends Conexion {
    
    private $ocu_id;
    private $ocu_nombre;
    private $ocu_abreviatura;
    
    function getOcu_id() {
        return $this->ocu_id;
    }

    function getOcu_nombre() {
        return $this->ocu_nombre;
    }

    function getOcu_abreviatura() {
        return $this->ocu_abreviatura;
    }

    function setOcu_id($ocu_id) {
        $this->ocu_id = $ocu_id;
    }

    function setOcu_nombre($ocu_nombre) {
        $this->ocu_nombre = $ocu_nombre;
    }

    function setOcu_abreviatura($ocu_abreviatura) {
        $this->ocu_abreviatura = $ocu_abreviatura;
    }

    
    public function listar () {
        try {
            $sql="select
                        o.ocu_id,
                        o.ocu_nombre, 
                        o.ocu_abreviatura
                from

                        ocupacion o
                where o.ocu_id != 3

                order by 

                        o.ocu_nombre 
                    ";
            $sentencia = $this->dbLink->prepare("$sql");
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);      
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;            
        }
    }  
    
    public function eliminar ($p_ocu_id){
       /*Validar si el ocupacion tiene trabajadores*/
        $sql = "
                select 
                        ocu_id

                from
                        trabajador

                where
                        ocu_id = :p_ocu_id;
                 ";
            $sentencia = $this->dbLink->prepare("$sql");
            $sentencia->bindParam(":p_ocu_id", $p_ocu_id);
            $sentencia->execute();
            
            if ($sentencia->rowcount()){
                throw new Exception("No es posible eliminar esta ocupación por motivos que tiene trabajadores registrados");           
            }
 
        /*Iniciar la transacción*/
        $this->dbLink->beginTransaction();
        try {
            /*Elaborar la cosulta SQL para eliminar la ocupación por codigo de ocupación*/
            $sql="
                delete from ocupacion 
                where ocu_id = :p_ocu_id";
            
            //declarar una sentencia en base a la consulta SQL
            $sentencia = $this->dbLink->prepare("$sql");
            
            //Enviar los valores a los parámetros de la sentencia
            $sentencia->bindParam(":p_ocu_id", $p_ocu_id);
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
            /*generar el correlativo del codigo de la ocupacion que se ha de registrar*/
            $sql = "select * from f_generar_correlativo('ocupacion') as correlativo";
            $sentencia = $this->dbLink->prepare($sql);
            $sentencia->execute();
            
            if($sentencia->rowCount()){ /*rowcount es un metodo por tanto lleva parentesis*/
                //si se encontro el correlativo para la tabla parroquia
                $resultado = $sentencia->fetch(PDO::FETCH_ASSOC); /*FETCH_ASSOC para no repetir la informacion y obtenerla con el nombre del campo*/
                $nuevoocu_id = $resultado["correlativo"]; //cargar nuevo codigo de parroquia
                $this->setOcu_id($nuevoocu_id);
                
                /*INSERTAR EN LA TABLA OCUPACION*/
                $sql = "
                    INSERT INTO ocupacion
                               (
                                ocu_id, 
                                ocu_nombre, 
                                ocu_abreviatura
                               )

                        VALUES (
                                :p_ocu_id, 
                                :p_ocu_nombre, 
                                :p_ocu_abreviatura
                                );
                        ";
                $sentencia= $this->dbLink->prepare($sql);
                $sentencia->bindParam(":p_ocu_id", $this->getOcu_id());
                $sentencia->bindParam(":p_ocu_nombre", $this->getOcu_nombre());
                $sentencia->bindParam(":p_ocu_abreviatura", $this->getOcu_abreviatura());
                $sentencia->execute();
                
                /*ACTUALIZAR EL CORRELATIVO PARA LA TABLA PARROQUIA  EN + 1*/
                $sql = "update correlativo set numero = numero + 1 where tabla = 'ocupacion'";
                $sentencia= $this->dbLink->prepare($sql); 
                $sentencia->execute();
                
                //CONFIRMAR LA TRANSACCION
                $this->dbLink->commit();
                
                return TRUE; //RETORNA VERDARERO CUANDO HA REGISTRADO TODO CORRECTAMENTE
            }else{
                //no se encontro el correlativo para la tabla parroquia
                throw new Exception("No se encontró el correlativo para la tabla ocupacion");                
            }
        } catch (Exception $exc) {
            $this->dbLink->rollback();//ABORTAR /DESHACER TODO LO QUE SE HA             
            throw $exc;            
        }
    }
    
    /*EDITAR OCUPACION POR EL CODIGO*/
    public function leerDatos($p_ocu_id) {
        try {
            $sql = "
                    select 
                            ocu_id,
                            ocu_nombre,
                            ocu_abreviatura
                    from
                            ocupacion o

                    where   ocu_id = :p_ocu_id
                   ";
            
            $sentencia = $this->dbLink->prepare($sql);
            $sentencia->bindParam(":p_ocu_id",$p_ocu_id);
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
                        ocupacion
                SET	
                        ocu_nombre		= :p_ocu_nombre, 
                        ocu_abreviatura 	= :p_ocu_abreviatura

                 WHERE 
                        ocu_id                  = :p_ocu_id

                 ";
            $sentencia= $this->dbLink->prepare($sql);
                
                $sentencia->bindParam(":p_ocu_nombre", $this->getOcu_nombre());
                $sentencia->bindParam(":p_ocu_abreviatura", $this->getOcu_abreviatura());
                $sentencia->bindParam(":p_ocu_id", $this->getOcu_id());
                $sentencia->execute();
                
                $this->dbLink->commit();
                
                return TRUE;
                
        } catch (Exception $exc) {
            $this->dbLink->rollBack();
            throw $exc;
        }
            
    }
}
