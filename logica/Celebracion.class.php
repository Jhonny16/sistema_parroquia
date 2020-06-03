<?php

require_once '../datos/Conexion.php';

class Celebracion extends Conexion {
    
    private $cel_id;
    private $cel_nombre;
    private $cel_descripcion;
    
    function getCel_id() {
        return $this->cel_id;
    }

    function getCel_nombre() {
        return $this->cel_nombre;
    }

    function getCel_descripcion() {
        return $this->cel_descripcion;
    }

    function setCel_id($cel_id) {
        $this->cel_id = $cel_id;
    }

    function setCel_nombre($cel_nombre) {
        $this->cel_nombre = $cel_nombre;
    }

    function setCel_descripcion($cel_descripcion) {
        $this->cel_descripcion = $cel_descripcion;
    }

    
         
    public function listar () {
        try {
            $sql="select
                        c.cel_id,
                        c.cel_nombre, 
                        c.cel_descripcion
                from

                        celebracion c

                order by 

                        c.cel_nombre 
                    ";
            $sentencia = $this->dbLink->prepare("$sql");
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);      
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;            
        }
    }  
    
    public function eliminar ($p_cel_id){
       /*Validar si el celebracion tiene cultos*/
        $sql = "
                select 
                        cel_id

                from
                        culto

                where
                        cel_id = :p_cel_id;
                 ";
            $sentencia = $this->dbLink->prepare("$sql");
            $sentencia->bindParam(":p_cel_id", $p_cel_id);
            $sentencia->execute();
            
            if ($sentencia->rowcount()){
                throw new Exception("No es posible eliminar esta Celebración por motivos que tiene Cultos registrados");           
            }
 
        /*Iniciar la transacción*/
        $this->dbLink->beginTransaction();
        try {
            /*Elaborar la cosulta SQL para eliminar la celebración por codigo de celebración*/
            $sql="
                delete from celebracion 
                where cel_id = :p_cel_id";
            
            //declarar una sentencia en base a la consulta SQL
            $sentencia = $this->dbLink->prepare("$sql");
            
            //Enviar los valores a los parámetros de la sentencia
            $sentencia->bindParam(":p_cel_id", $p_cel_id);
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
            $sql = "select * from f_generar_correlativo('celebracion') as correlativo";
            $sentencia = $this->dbLink->prepare($sql);
            $sentencia->execute();
            
            if($sentencia->rowCount()){ /*rowcount es un metodo por tanto lleva parentesis*/
                //si se encontro el correlativo para la tabla parroquia
                $resultado = $sentencia->fetch(PDO::FETCH_ASSOC); /*FETCH_ASSOC para no repetir la informacion y obtenerla con el nombre del campo*/
                $nuevocel_id = $resultado["correlativo"]; //cargar nuevo codigo de celebracion
                $this->setCel_id($nuevocel_id);
                
                /*INSERTAR EN LA TABLA CELEBRACION*/
                $sql = "
                    INSERT INTO celebracion
                                (
                                cel_id, 
                                cel_nombre, 
                                cel_descripcion
                               )

                        VALUES (
                                :p_cel_id, 
                                :p_cel_nombre, 
                                :p_cel_descripcion
                                );
                        ";
                $sentencia= $this->dbLink->prepare($sql);
                $sentencia->bindParam(":p_cel_id", $this->cel_id);
                $sentencia->bindParam(":p_cel_nombre", $this->cel_nombre);
                $sentencia->bindParam(":p_cel_descripcion", $this->cel_descripcion);
                $sentencia->execute();
                
                /*ACTUALIZAR EL CORRELATIVO PARA LA TABLA CELEBRACION  EN + 1*/
                $sql = "update correlativo set numero = numero + 1 where tabla = 'celebracion'";
                $sentencia= $this->dbLink->prepare($sql); 
                $sentencia->execute();
                
                //CONFIRMAR LA TRANSACCION
                $this->dbLink->commit();
                
                return TRUE; //RETORNA VERDARERO CUANDO HA REGISTRADO TODO CORRECTAMENTE
            }else{
                //no se encontro el correlativo para la tabla celebración
                throw new Exception("No se encontró el correlativo para la tabla celebracion");                
            }
        } catch (Exception $exc) {
            $this->dbLink->rollback();//ABORTAR /DESHACER TODO LO QUE SE HA             
            throw $exc;            
        }
    }
    
    /*EDITAR CELEBRACION POR EL CODIGO*/
    public function leerDatos($p_cel_id) {
        try {
            $sql = "
                    select 
                            cel_id,
                            cel_nombre,
                            cel_descripcion
                    from
                            celebracion c

                    where   cel_id = :p_cel_id
                   ";
            
            $sentencia = $this->dbLink->prepare($sql);
            $sentencia->bindParam(":p_cel_id",$p_cel_id);
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
                        celebracion
                SET	
                        cel_nombre		= :p_cel_nombre, 
                        cel_descripcion 	= :p_cel_descripcion

                 WHERE 
                        cel_id                  = :p_cel_id

                 ";
            $sentencia= $this->dbLink->prepare($sql);
                
                $sentencia->bindParam(":p_cel_nombre", $this->cel_nombre);
                $sentencia->bindParam(":p_cel_descripcion", $this->cel_descripcion);
                $sentencia->bindParam(":p_cel_id", $this->cel_id);
                $sentencia->execute();
                
                $this->dbLink->commit();
                
                return TRUE;
                
        } catch (Exception $exc) {
            $this->dbLink->rollBack();
            throw $exc;
        }
            
    }
}
