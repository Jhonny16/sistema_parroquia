<?php

require_once '../datos/Conexion.php';

class HorarioProgramado extends Conexion {
    
    private $hp_id;
    private $hp_domingo;
    private $hp_lunes;
    private $hp_martes;
    private $hp_miercoles;
    private $hp_jueves;
    private $hp_viernes;
    private $hp_sabado;
    private $hora_id;
    private $cap_id;
    private $anno_nombre;
     
    function getHp_id() {
        return $this->hp_id;
    }

    function getHp_domingo() {
        return $this->hp_domingo;
    }

    function getHp_lunes() {
        return $this->hp_lunes;
    }

    function getHp_martes() {
        return $this->hp_martes;
    }

    function getHp_miercoles() {
        return $this->hp_miercoles;
    }

    function getHp_jueves() {
        return $this->hp_jueves;
    }

    function getHp_viernes() {
        return $this->hp_viernes;
    }

    function getHp_sabado() {
        return $this->hp_sabado;
    }

    function getHora_id() {
        return $this->hora_id;
    }

    function getCap_id() {
        return $this->cap_id;
    }

    function getAnno_nombre() {
        return $this->anno_nombre;
    }

    function setHp_id($hp_id) {
        $this->hp_id = $hp_id;
    }

    function setHp_domingo($hp_domingo) {
        $this->hp_domingo = $hp_domingo;
    }

    function setHp_lunes($hp_lunes) {
        $this->hp_lunes = $hp_lunes;
    }

    function setHp_martes($hp_martes) {
        $this->hp_martes = $hp_martes;
    }

    function setHp_miercoles($hp_miercoles) {
        $this->hp_miercoles = $hp_miercoles;
    }

    function setHp_jueves($hp_jueves) {
        $this->hp_jueves = $hp_jueves;
    }

    function setHp_viernes($hp_viernes) {
        $this->hp_viernes = $hp_viernes;
    }

    function setHp_sabado($hp_sabado) {
        $this->hp_sabado = $hp_sabado;
    }

    function setHora_id($hora_id) {
        $this->hora_id = $hora_id;
    }

    function setCap_id($cap_id) {
        $this->cap_id = $cap_id;
    }

    function setAnno_nombre($anno_nombre) {
        $this->anno_nombre = $anno_nombre;
    }

     
         
    public function listar () {
        try {
            $sql="select
                            h.hp_id,
                            p.hora_hora as hora,
                            h.hp_domingo,
                            h.hp_lunes,
                            h.hp_martes,
                            h.hp_miercoles,
                            h.hp_jueves,
                            h.hp_viernes,
                            h.hp_sabado,
                            c.cap_nombre as capilla,
                            anno_nombre
                            

                    from
                            horario_programado h
                            inner join horario_patron p on ( p.hora_id = h.hora_id)
                            inner join capilla c on ( c.cap_id = h.cap_id)

                    order by 
                            hora asc, 
                            capilla asc
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
                $sentencia->bindParam(":p_par_id", $this->getPar_id());
                $sentencia->bindParam(":p_par_nombre", $this->getPar_nombre());
                $sentencia->bindParam(":p_par_direccion", $this->getPar_direccion());
                $sentencia->bindParam(":p_par_telefono", $this->getPar_telefono());
                $sentencia->bindParam(":p_par_email", $this->getPar_email());                
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

    public function read($p_id) {
        try {
            $sql = "
                    select 
                           *
                    from
                            horario_programado
                    where hp_id = :p_id
                   ";

            $sentencia = $this->dbLink->prepare($sql);
            $sentencia->bindParam(":p_id",$p_id);
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
                
                $sentencia->bindParam(":p_par_nombre", $this->getPar_nombre());
                $sentencia->bindParam(":p_par_direccion", $this->getPar_direccion());
                $sentencia->bindParam(":p_par_telefono", $this->getPar_telefono());  
                $sentencia->bindParam(":p_par_email", $this->getPar_email());
                $sentencia->bindParam(":p_par_id", $this->getPar_id());
                $sentencia->execute();
                
                $this->dbLink->commit();
                
                return TRUE;
                
        } catch (Exception $exc) {
            $this->dbLink->rollBack();
            throw $exc;
        }
            
    }


    public function create(){

        try {
                $sql = "
                    INSERT INTO horario_programado
                                (
                                hp_domingo, 
                                hp_lunes, 
                                hp_martes, 
                                hp_miercoles, 
                                hp_jueves, 
                                hp_viernes, 
                                hp_sabado, 
                                hora_id, 
                                cap_id, 
                                anno_nombre                               
                               )

                        VALUES (
                                :p_domingo, 
                                :p_lunes, 
                                :p_martes, 
                                :p_miercoles,  
                                :p_jueves,  
                                :p_viernes,  
                                :p_sabado,  
                                :p_hora,  
                                :p_capilla,  
                                :p_anio
                                );
                        ";
                $sentencia= $this->dbLink->prepare($sql);
                $sentencia->bindParam(":p_domingo", $this->hp_domingo);
                $sentencia->bindParam(":p_lunes", $this->hp_lunes);
                $sentencia->bindParam(":p_martes", $this->hp_martes);
                $sentencia->bindParam(":p_miercoles", $this->hp_miercoles);
                $sentencia->bindParam(":p_jueves", $this->hp_jueves);
                $sentencia->bindParam(":p_viernes", $this->hp_viernes);
                $sentencia->bindParam(":p_sabado", $this->hp_sabado);
                $sentencia->bindParam(":p_hora", $this->hora_id);
                $sentencia->bindParam(":p_capilla", $this->cap_id);
                $sentencia->bindParam(":p_anio", $this->anno_nombre);
                $sentencia->execute();
                return TRUE; //RETORNA VERDARERO CUANDO HA REGISTRADO TODO CORRECTAMENTE

        } catch (Exception $exc) {
            throw $exc;
        }
    }


}
