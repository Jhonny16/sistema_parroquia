<?php

require_once '../datos/Conexion.php';

class Parroquia extends Conexion {
    
    private $par_id;
    private $par_nombre;
    private $par_direccion;
    private $par_telefono;
    private $par_email;
     
    function getPar_id() {
        return $this->par_id;
    }

    function getPar_nombre() {
        return $this->par_nombre;
    }

    function getPar_direccion() {
        return $this->par_direccion;
    }

    function getPar_telefono() {
        return $this->par_telefono;
    }

    function getPar_email() {
        return $this->par_email;
    }

    function setPar_id($par_id) {
        $this->par_id = $par_id;
    }

    function setPar_nombre($par_nombre) {
        $this->par_nombre = $par_nombre;
    }

    function setPar_direccion($par_direccion) {
        $this->par_direccion = $par_direccion;
    }

    function setPar_telefono($par_telefono) {
        $this->par_telefono = $par_telefono;
    }

    function setPar_email($par_email) {
        $this->par_email = $par_email;
    }

         
    public function listar () {
        try {
            $sql="select
                        p.par_id,
                        p.par_nombre, 
                        p.par_direccion, 
                        p.par_telefono, 
                        p.par_email
                from

                        parroquia p

                order by 

                        p.par_nombre 
                    ";
            $sentencia = $this->dbLink->prepare("$sql");
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);      
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;            
        }
    }
    public function listar_xuser () {
        try {
            $sql="select
                        p.par_id,
                        p.par_nombre, 
                        p.par_direccion, 
                        p.par_telefono, 
                        p.par_email
                from

                        parroquia p

                order by 

                        p.par_nombre 
                    ";
            $sentencia = $this->dbLink->prepare("$sql");
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }
    
    public function eliminar ($p_par_id){
       /*Validar si el parroquia tiene capillas*/
        $sql = "
                select 
                        par_id

                from
                        capilla

                where
                        par_id = :p_par_id;
                 ";
            $sentencia = $this->dbLink->prepare("$sql");
            $sentencia->bindParam(":p_par_id", $p_par_id);
            $sentencia->execute();
            
            if ($sentencia->rowcount()){
                throw new Exception("No es posible eliminar esta Parroquia por motivos que tiene Capillas registradas");           
            }
 
        /*Iniciar la transacción*/
        $this->dbLink->beginTransaction();
        try {
            /*Elaborar la cosulta SQL para eliminar la parroquia por codigo de parroquia*/
            $sql="
                delete from parroquia 
                where par_id = :p_par_id";
            
            //declarar una sentencia en base a la consulta SQL
            $sentencia = $this->dbLink->prepare("$sql");
            
            //Enviar los valores a los parámetros de la sentencia
            $sentencia->bindParam(":p_par_id", $p_par_id);
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
    public function agregar_parroquia () {
        $this->dbLink->beginTransaction();
        try {
            /*generar el correlativo del codigo de la parroquia que se ha de registrar*/
            $sql = "select * from f_generar_correlativo('parroquia') as correlativo";
            $sentencia = $this->dbLink->prepare($sql);
            $sentencia->execute();

            if($sentencia->rowCount()){ /*rowcount es un metodo por tanto lleva parentesis*/
                //si se encontro el correlativo para la tabla parroquia
                $resultado = $sentencia->fetch(PDO::FETCH_ASSOC); /*FETCH_ASSOC para no repetir la informacion y obtenerla con el nombre del campo*/
                $nuevopar_id = $resultado["correlativo"]; //cargar nuevo codigo de parroquia
                $this->setPar_id($nuevopar_id);

                /*INSERTAR EN LA TABLA PARROQUIA*/
                $sql = "
                    INSERT INTO parroquia
                                (
                                par_id, 
                                par_nombre, 
                                par_direccion, 
                                par_telefono, 
                                par_email
                               )

                        VALUES (
                                :p_par_id, 
                                :p_par_nombre, 
                                :p_par_direccion, 
                                :p_par_telefono,  
                                :p_par_email
                                );
                        ";
                $sentencia= $this->dbLink->prepare($sql);
                $sentencia->bindParam(":p_par_id", $this->par_id);
                $sentencia->bindParam(":p_par_nombre", $this->par_nombre);
                $sentencia->bindParam(":p_par_direccion", $this->par_direccion);
                $sentencia->bindParam(":p_par_telefono", $this->par_telefono);
                $sentencia->bindParam(":p_par_email", $this->par_email);
                $sentencia->execute();

                /*ACTUALIZAR EL CORRELATIVO PARA LA TABLA PARROQUIA  EN + 1*/
                $sql = "update correlativo set numero = numero + 1 where tabla = 'parroquia'";
                $sentencia= $this->dbLink->prepare($sql);
                $sentencia->execute();

                //CONFIRMAR LA TRANSACCION
                $this->dbLink->commit();

                return $nuevopar_id; //RETORNA VERDARERO CUANDO HA REGISTRADO TODO CORRECTAMENTE
            }else{
                //no se encontro el correlativo para la tabla parroquia
                throw new Exception("No se encontró el correlativo para la tabla parroquia");
            }
        } catch (Exception $exc) {
            $this->dbLink->rollback();//ABORTAR /DESHACER TODO LO QUE SE HA
            throw $exc;
        }
    }
    public function agregar () {
        $this->dbLink->beginTransaction();
        try {
            /*generar el correlativo del codigo de la parroquia que se ha de registrar*/
            $sql = "select * from f_generar_correlativo('parroquia') as correlativo";
            $sentencia = $this->dbLink->prepare($sql);
            $sentencia->execute();
            
            if($sentencia->rowCount()){ /*rowcount es un metodo por tanto lleva parentesis*/
                //si se encontro el correlativo para la tabla parroquia
                $resultado = $sentencia->fetch(PDO::FETCH_ASSOC); /*FETCH_ASSOC para no repetir la informacion y obtenerla con el nombre del campo*/
                $nuevopar_id = $resultado["correlativo"]; //cargar nuevo codigo de parroquia
                $this->setPar_id($nuevopar_id);
                
                /*INSERTAR EN LA TABLA PARROQUIA*/
                $sql = "
                    INSERT INTO parroquia
                                (
                                par_id, 
                                par_nombre, 
                                par_direccion, 
                                par_telefono, 
                                par_email
                               )

                        VALUES (
                                :p_par_id, 
                                :p_par_nombre, 
                                :p_par_direccion, 
                                :p_par_telefono,  
                                :p_par_email
                                );
                        ";
                $sentencia= $this->dbLink->prepare($sql);
                $sentencia->bindParam(":p_par_id", $this->par_id);
                $sentencia->bindParam(":p_par_nombre", $this->par_nombre);
                $sentencia->bindParam(":p_par_direccion", $this->par_direccion);
                $sentencia->bindParam(":p_par_telefono", $this->par_telefono);
                $sentencia->bindParam(":p_par_email", $this->par_email);
                $sentencia->execute();
                
                /*ACTUALIZAR EL CORRELATIVO PARA LA TABLA PARROQUIA  EN + 1*/
                $sql = "update correlativo set numero = numero + 1 where tabla = 'parroquia'";
                $sentencia= $this->dbLink->prepare($sql); 
                $sentencia->execute();
                
                //CONFIRMAR LA TRANSACCION
                $this->dbLink->commit();
                
                return TRUE; //RETORNA VERDARERO CUANDO HA REGISTRADO TODO CORRECTAMENTE
            }else{
                //no se encontro el correlativo para la tabla parroquia
                throw new Exception("No se encontró el correlativo para la tabla parroquia");                
            }
        } catch (Exception $exc) {
            $this->dbLink->rollback();//ABORTAR /DESHACER TODO LO QUE SE HA             
            throw $exc;            
        }
    }
    
    /*EDITAR PRODUCTO POR EL CODIGO*/
    public function leerDatos($p_par_id) {
        try {
            $sql = "
                    select 
                            par_id,
                            par_nombre,
                            par_direccion,
                            par_telefono,
                            par_email
                    from
                            parroquia p

                    where   par_id = :p_par_id
                   ";
            
            $sentencia = $this->dbLink->prepare($sql);
            $sentencia->bindParam(":p_par_id",$p_par_id);
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
                        parroquia
                SET	
                        par_nombre		= :p_par_nombre, 
                        par_direccion  		= :p_par_direccion, 
                        par_telefono 		= :p_par_telefono, 
                        par_email 		= :p_par_email 

                 WHERE 
                        par_id                  = :p_par_id

                 ";
            $sentencia= $this->dbLink->prepare($sql);
                
                $sentencia->bindParam(":p_par_nombre", $this->par_nombre);
                $sentencia->bindParam(":p_par_direccion", $this->par_direccion);
                $sentencia->bindParam(":p_par_telefono", $this->par_telefono);
                $sentencia->bindParam(":p_par_email", $this->par_email);
                $sentencia->bindParam(":p_par_id", $this->par_id);
                $sentencia->execute();
                
                $this->dbLink->commit();
                
                return TRUE;
                
        } catch (Exception $exc) {
            $this->dbLink->rollBack();
            throw $exc;
        }
            
    }
}
