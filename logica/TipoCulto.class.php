<?php

require_once '../datos/Conexion.php';

class TipoCulto extends Conexion
{

    private $tc_id;
    private $tc_nombre;
    private $tc_descripcion;
    private $cul_id;
    private $tc_tipo;
    private $tc_tiempo_maximo;
    private $tc_precio;

    function getTc_id()
    {
        return $this->tc_id;
    }

    function getTc_nombre()
    {
        return $this->tc_nombre;
    }

    function getTc_descripcion()
    {
        return $this->tc_descripcion;
    }

    function getCul_id()
    {
        return $this->cul_id;
    }

    function getTc_tipo()
    {
        return $this->tc_tipo;
    }

    function getTc_tiempo_maximo()
    {
        return $this->tc_tiempo_maximo;
    }

    function getTc_precio()
    {
        return $this->tc_precio;
    }

    function setTc_id($tc_id)
    {
        $this->tc_id = $tc_id;
    }

    function setTc_nombre($tc_nombre)
    {
        $this->tc_nombre = $tc_nombre;
    }

    function setTc_descripcion($tc_descripcion)
    {
        $this->tc_descripcion = $tc_descripcion;
    }

    function setCul_id($cul_id)
    {
        $this->cul_id = $cul_id;
    }

    function setTc_tipo($tc_tipo)
    {
        $this->tc_tipo = $tc_tipo;
    }

    function setTc_tiempo_maximo($tc_tiempo_maximo)
    {
        $this->tc_tiempo_maximo = $tc_tiempo_maximo;
    }

    function setTc_precio($tc_precio)
    {
        $this->tc_precio = $tc_precio;
    }


    public function listar()
    {
        try {
            $sql = "
                select
                        t.tc_id,
                        t.tc_nombre, 
                        t.tc_descripcion,
                        t.tc_tipo,
                        t.tc_tiempo_maximo,
                        t.tc_precio,
                        c.cul_nombre as culto

                from
                        tipo_culto t
                        inner join culto c on ( c.cul_id = t.cul_id)

                order by 

                        t.tc_id, t.tc_nombre desc 
                 ";
            $sentencia = $this->dbLink->prepare("$sql");
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }

    public function eliminar($p_tc_id)
    {
        /*Validar si el tipo de culto tiene intenciones*/
        $sql = "
                select 
                        tc_id

                from
                        detalle_intencion

                where
                        tc_id = :p_tc_id;
                 ";
        $sentencia = $this->dbLink->prepare("$sql");
        $sentencia->bindParam(":p_tc_id", $p_tc_id);
        $sentencia->execute();

        if ($sentencia->rowcount()) {
            throw new Exception("No es posible eliminar este Tipo de Culto por motivos que tiene Intenciones registradas");
        }

        /*Iniciar la transacción*/
        $this->dbLink->beginTransaction();
        try {
            /*Elaborar la cosulta SQL para eliminar el tipo de culto por codigo de tipo de culto*/
            $sql = "
                delete from tipo_culto 
                where tc_id = :p_tc_id";

            //declarar una sentencia en base a la consulta SQL
            $sentencia = $this->dbLink->prepare("$sql");

            //Enviar los valores a los parámetros de la sentencia
            $sentencia->bindParam(":p_tc_id", $p_tc_id);
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

    public function agregar()
    {
        $this->dbLink->beginTransaction();
        try {
            /*generar el correlativo del codigo de la parroquia que se ha de registrar*/
            $sql = "select * from f_generar_correlativo('tipo_culto') as correlativo";
            $sentencia = $this->dbLink->prepare($sql);
            $sentencia->execute();

            if ($sentencia->rowCount()) { /*rowcount es un metodo por tanto lleva parentesis*/
                //si se encontro el correlativo para la tabla parroquia
                $resultado = $sentencia->fetch(PDO::FETCH_ASSOC); /*FETCH_ASSOC para no repetir la informacion y obtenerla con el nombre del campo*/
                $nuevotc_id = $resultado["correlativo"]; //cargar nuevo codigo de tipo_culto
                $this->setTc_id($nuevotc_id);

                /*INSERTAR EN LA TABLA TIPO_CULTO*/
                $sql = "
                    INSERT INTO tipo_culto
                                (
                                 tc_id, 
                                 tc_nombre, 
                                 tc_descripcion,
                                 tc_tipo,
                                 tc_tiempo_maximo,
                                 tc_precio,
                                 cul_id
                                )

                        VALUES  (
                                :p_tc_id, 
                                :p_tc_nombre, 
                                :p_tc_descripcion, 
                                :p_tc_tipo,
                                :p_tc_tiempo_maximo,
                                :p_tc_precio,
                                :p_cul_id
                                );
                        ";
                $sentencia = $this->dbLink->prepare($sql);
                $sentencia->bindParam(":p_tc_id", $this->tc_id);
                $sentencia->bindParam(":p_tc_nombre", $this->tc_nombre);
                $sentencia->bindParam(":p_tc_descripcion", $this->tc_descripcion);
                $sentencia->bindParam(":p_tc_tipo", $this->tc_tipo);
                $sentencia->bindParam(":p_tc_tiempo_maximo", $this->tc_tiempo_maximo);
                $sentencia->bindParam(":p_tc_precio", $this->tc_precio);
                $sentencia->bindParam(":p_cul_id", $this->cul_id);
                $sentencia->execute();

                /*ACTUALIZAR EL CORRELATIVO PARA LA TABLA TIPO_CULTO  EN + 1*/
                $sql = "update correlativo set numero = numero + 1 where tabla = 'tipo_culto'";
                $sentencia = $this->dbLink->prepare($sql);
                $sentencia->execute();

                //CONFIRMAR LA TRANSACCION
                $this->dbLink->commit();

                return TRUE; //RETORNA VERDARERO CUANDO HA REGISTRADO TODO CORRECTAMENTE
            } else {
                //no se encontro el correlativo para la tabla parroquia
                throw new Exception("No se encontró el correlativo para la tabla Tipo_Culto");
            }
        } catch (Exception $exc) {
            $this->dbLink->rollback();//ABORTAR /DESHACER TODO LO QUE SE HA             
            throw $exc;
        }
    }

    /*EDITAR TIPO_CULTO POR EL CODIGO*/
    public function leerDatos($p_tc_id)
    {
        try {
            $sql = "
                    select 
                            tc_id,
                            tc_nombre,
                            tc_descripcion,
                            tc_tipo,
                            tc_tiempo_maximo,
                            tc_precio,
                            cul_id
                    from
                            tipo_culto t

                    where   tc_id = :p_tc_id
                   ";

            $sentencia = $this->dbLink->prepare($sql);
            $sentencia->bindParam(":p_tc_id", $p_tc_id);
            $sentencia->execute();
            $resultado = $sentencia->fetch(PDO::FETCH_ASSOC);
            return $resultado;

        } catch (Exception $exc) {
            throw $exc;
        }
    }


    public function editar()
    {
        $this->dbLink->beginTransaction();

        try {
            $sql = "
                UPDATE 
                        tipo_culto
                SET	
                        tc_nombre		= :p_tc_nombre, 
                        tc_descripcion 		= :p_tc_descripcion, 
                        tc_tipo                 = :p_tc_tipo,
                        tc_tiempo_maximo        = :p_tc_tiempo_maximo,
                        tc_precio               = :p_tc_precio,
                        cul_id  		= :p_cul_id 

                 WHERE 
                        tc_id                   = :p_tc_id

                 ";
            $sentencia = $this->dbLink->prepare($sql);

            $sentencia->bindParam(":p_tc_nombre", $this->tc_nombre);
            $sentencia->bindParam(":p_tc_descripcion", $this->tc_descripcion);
            $sentencia->bindParam(":p_tc_tipo", $this->tc_tipo);
            $sentencia->bindParam(":p_tc_tiempo_maximo", $this->tc_tiempo_maximo);
            $sentencia->bindParam(":p_tc_precio", $this->tc_precio);
            $sentencia->bindParam(":p_cul_id", $this->cul_id);
            $sentencia->bindParam(":p_tc_id", $this->tc_id);
            $sentencia->execute();

            $this->dbLink->commit();

            return TRUE;

        } catch (Exception $exc) {
            $this->dbLink->rollBack();
            throw $exc;
        }

    }
}
