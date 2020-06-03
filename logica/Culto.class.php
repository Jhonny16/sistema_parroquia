<?php

require_once '../datos/Conexion.php';

class Culto extends Conexion {
    
    private $cul_id;
    private $cul_nombre;
    private $cul_descripcion;
    private $cel_id;
    
    function getCul_id() {
        return $this->cul_id;
    }

    function getCul_nombre() {
        return $this->cul_nombre;
    }

    function getCul_descripcion() {
        return $this->cul_descripcion;
    }

    function getCel_id() {
        return $this->cel_id;
    }

    function setCul_id($cul_id) {
        $this->cul_id = $cul_id;
    }

    function setCul_nombre($cul_nombre) {
        $this->cul_nombre = $cul_nombre;
    }

    function setCul_descripcion($cul_descripcion) {
        $this->cul_descripcion = $cul_descripcion;
    }

    function setCel_id($cel_id) {
        $this->cel_id = $cel_id;
    }

         
    public function listar () {
        try {
            $sql="
                select
                        c.cul_id,
                        c.cul_nombre,
                        c.cul_descripcion,
                        d.cel_nombre as celebracion

                from
                        culto c
                        inner join celebracion d on ( d.cel_id = c.cel_id)

                order by
                        c.cul_nombre
                    
                 ";
            $sentencia = $this->dbLink->prepare("$sql");
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);      
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;            
        }
    }  
    
    public function eliminar ($p_cul_id){
       /*Validar si el culto tiene tipo de cultos*/
        $sql = "
                select 
                        cul_id

                from
                        tipo_culto

                where
                        cul_id = :p_cul_id;
                 ";
            $sentencia = $this->dbLink->prepare("$sql");
            $sentencia->bindParam(":p_cul_id", $p_cul_id);
            $sentencia->execute();
            
            if ($sentencia->rowcount()){
                throw new Exception("No es posible eliminar este culto por motivos que tiene tipos de culto registrados");           
            }
 
        /*Iniciar la transacción*/
        $this->dbLink->beginTransaction();
        try {
            /*Elaborar la cosulta SQL para eliminar el culto por codigo de culto*/
            $sql="
                delete from culto 
                where cul_id = :p_cul_id";
            
            //declarar una sentencia en base a la consulta SQL
            $sentencia = $this->dbLink->prepare("$sql");
            
            //Enviar los valores a los parámetros de la sentencia
            $sentencia->bindParam(":p_cul_id", $p_cul_id);
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
            $sql = "select * from f_generar_correlativo('culto') as correlativo";
            $sentencia = $this->dbLink->prepare($sql);
            $sentencia->execute();
            
            if($sentencia->rowCount()){ /*rowcount es un metodo por tanto lleva parentesis*/
                //si se encontro el correlativo para la tabla parroquia
                $resultado = $sentencia->fetch(PDO::FETCH_ASSOC); /*FETCH_ASSOC para no repetir la informacion y obtenerla con el nombre del campo*/
                $nuevocul_id = $resultado["correlativo"]; //cargar nuevo codigo de culto
                $this->setcul_id($nuevocul_id);
                
                /*INSERTAR EN LA TABLA CULTO*/
                $sql = "
                    INSERT INTO culto
                                (
                                cul_id, 
                                cul_nombre, 
                                cul_descripcion, 
                                cel_id
                               )

                        VALUES (
                                :p_cul_id, 
                                :p_cul_nombre, 
                                :p_cul_descripcion, 
                                :p_cel_id
                                );
                        ";
                $sentencia= $this->dbLink->prepare($sql);
                $sentencia->bindParam(":p_cul_id", $this->cul_id);
                $sentencia->bindParam(":p_cul_nombre", $this->cul_nombre);
                $sentencia->bindParam(":p_cul_descripcion", $this->cul_descripcion);
                $sentencia->bindParam(":p_cel_id", $this->cel_id);
                $sentencia->execute();
                
                /*ACTUALIZAR EL CORRELATIVO PARA LA TABLA CULTO  EN + 1*/
                $sql = "update correlativo set numero = numero + 1 where tabla = 'culto'";
                $sentencia= $this->dbLink->prepare($sql); 
                $sentencia->execute();
                
                //CONFIRMAR LA TRANSACCION
                $this->dbLink->commit();
                
                return TRUE; //RETORNA VERDARERO CUANDO HA REGISTRADO TODO CORRECTAMENTE
            }else{
                //no se encontro el correlativo para la tabla parroquia
                throw new Exception("No se encontró el correlativo para la tabla Culto");                
            }
        } catch (Exception $exc) {
            $this->dbLink->rollback();//ABORTAR /DESHACER TODO LO QUE SE HA             
            throw $exc;            
        }
    }
    
    /*EDITAR CULTO POR EL CODIGO*/
    public function leerDatos($p_cul_id) {
        try {
            $sql = "
                    select 
                            cul_id,
                            cul_nombre,
                            cul_descripcion,
                            cel_id
                    from
                            culto c

                    where   cul_id = :p_cul_id
                   ";
            
            $sentencia = $this->dbLink->prepare($sql);
            $sentencia->bindParam(":p_cul_id",$p_cul_id);
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
                        culto
                SET	
                        cul_nombre		= :p_cul_nombre, 
                        cul_descripcion		= :p_cul_descripcion, 
                        cel_id   		= :p_cel_id

                 WHERE 
                        cul_id                  = :p_cul_id

                 ";
            $sentencia= $this->dbLink->prepare($sql);
                
                $sentencia->bindParam(":p_cul_nombre", $this->cul_nombre);
                $sentencia->bindParam(":p_cul_descripcion", $this->cul_descripcion);
                $sentencia->bindParam(":p_cel_id", $this->cel_id);
                $sentencia->bindParam(":p_cul_id", $this->cul_id);
                $sentencia->execute();
                
                $this->dbLink->commit();
                
                return TRUE;
                
        } catch (Exception $exc) {
            $this->dbLink->rollBack();
            throw $exc;
        }
            
    }

    public function detail($culto_id) {
        try {
            $sql = "select * from det_culto where tc_id = :p_culto_id ";

            $sentencia = $this->dbLink->prepare($sql);
            $sentencia->bindParam(":p_culto_id",$culto_id);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;

        } catch (Exception $exc) {
            throw $exc;
        }
    }
}
