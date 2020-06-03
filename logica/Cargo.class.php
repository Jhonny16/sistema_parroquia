<?php

require_once '../datos/Conexion.php';

class Cargo extends Conexion {
    
    private $car_id;
    private $car_nombre;
    
    function getCar_id() {
        return $this->car_id;
    }

    function getCar_nombre() {
        return $this->car_nombre;
    }

    function setCar_id($car_id) {
        $this->car_id = $car_id;
    }

    function setCar_nombre($car_nombre) {
        $this->car_nombre = $car_nombre;
    }

                  
    public function listar () {
        try {
            $sql="select
                        c.car_id,
                        c.car_nombre 
                        
                from

                        cargo c
                where c.car_id != 6
                order by 

                        c.car_nombre 
                    ";
            $sentencia = $this->dbLink->prepare("$sql");
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);      
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;            
        }
    }  
    
    public function eliminar ($p_car_id){
       /*Validar si el cargo tiene trabajadores*/
        $sql = "
                select 
                        car_id

                from
                        trabajador

                where
                        car_id = :p_car_id;
                 ";
            $sentencia = $this->dbLink->prepare("$sql");
            $sentencia->bindParam(":p_car_id", $p_car_id);
            $sentencia->execute();
            
            if ($sentencia->rowcount()){
                throw new Exception("No es posible eliminar esta Cargo por motivos que tiene trabajadores registrados");           
            }
 
        /*Iniciar la transacción*/
        $this->dbLink->beginTransaction();
        try {
            /*Elaborar la cosulta SQL para eliminar la parroquia por codigo de parroquia*/
            $sql="
                delete from cargo 
                where car_id = :p_car_id";
            
            //declarar una sentencia en base a la consulta SQL
            $sentencia = $this->dbLink->prepare("$sql");
            
            //Enviar los valores a los parámetros de la sentencia
            $sentencia->bindParam(":p_car_id", $p_car_id);
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
            $sql = "select * from f_generar_correlativo('cargo') as correlativo";
            $sentencia = $this->dbLink->prepare($sql);
            $sentencia->execute();
            
            if($sentencia->rowCount()){ /*rowcount es un metodo por tanto lleva parentesis*/
                //si se encontro el correlativo para la tabla cargo
                $resultado = $sentencia->fetch(PDO::FETCH_ASSOC); /*FETCH_ASSOC para no repetir la informacion y obtenerla con el nombre del campo*/
                $nuevocar_id = $resultado["correlativo"]; //cargar nuevo codigo de cargo
                $this->setCar_id($nuevocar_id);
                
                /*INSERTAR EN LA TABLA PARROQUIA*/
                $sql = "
                    INSERT INTO cargo
                                (
                                car_id, 
                                car_nombre 
                              
                               )

                        VALUES (
                                :p_car_id, 
                                :p_car_nombre
                                );
                        ";
                $sentencia= $this->dbLink->prepare($sql);
                $sentencia->bindParam(":p_car_id", $this->getCar_id());
                $sentencia->bindParam(":p_car_nombre", $this->getCar_nombre());
                                
                $sentencia->execute();
                
                /*ACTUALIZAR EL CORRELATIVO PARA LA TABLA CARGO  EN + 1*/
                $sql = "update correlativo set numero = numero + 1 where tabla = 'cargo'";
                $sentencia= $this->dbLink->prepare($sql); 
                $sentencia->execute();
                
                //CONFIRMAR LA TRANSACCION
                $this->dbLink->commit();
                
                return TRUE; //RETORNA VERDARERO CUANDO HA REGISTRADO TODO CORRECTAMENTE
            }else{
                //no se encontro el correlativo para la tabla parroquia
                throw new Exception("No se encontró el correlativo para la tabla cargo");                
            }
        } catch (Exception $exc) {
            $this->dbLink->rollback();//ABORTAR /DESHACER TODO LO QUE SE HA             
            throw $exc;            
        }
    }
    
    /*EDITAR CARGO POR EL CODIGO*/
    public function leerDatos($p_car_id) {
        try {
            $sql = "
                    select 
                            car_id,
                            car_nombre
                    from
                            cargo c

                    where   car_id = :p_car_id
                   ";
            
            $sentencia = $this->dbLink->prepare($sql);
            $sentencia->bindParam(":p_car_id",$p_car_id);
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
                        cargo
                SET	
                        car_nombre		= :p_car_nombre

                 WHERE 
                        car_id                  = :p_car_id

                 ";
            $sentencia= $this->dbLink->prepare($sql);
                
                $sentencia->bindParam(":p_car_nombre", $this->getCar_nombre());
                $sentencia->bindParam(":p_car_id", $this->getCar_id());
                $sentencia->execute();
                
                $this->dbLink->commit();
                
                return TRUE;
                
        } catch (Exception $exc) {
            $this->dbLink->rollBack();
            throw $exc;
        }
            
    }
}
