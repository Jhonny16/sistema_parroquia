<?php
/**
 * Created by PhpStorm.
 * User: jhonny
 * Date: 19/05/19
 * Time: 05:40 PM
 */
require_once '../datos/Conexion.php';
class TipoCultoDetalle extends Conexion
{
    private $id;
    private $nombre;
    private $descripcion;
    private $tipoculto_id;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param mixed $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     * @return mixed
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * @param mixed $descripcion
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }

    /**
     * @return mixed
     */
    public function getTipocultoId()
    {
        return $this->tipoculto_id;
    }

    /**
     * @param mixed $tipoculto_id
     */
    public function setTipocultoId($tipoculto_id)
    {
        $this->tipoculto_id = $tipoculto_id;
    }

    public function listar()
    {
        try {
            $sql = "
                select
                        c.det_id,
                        c.det_nombre,
                        c.det_descripcion,
                        t.tc_nombre as tipo_culto

                from
                        tipo_culto t
                        inner join det_culto c on c.tc_id =t.tc_id

                order by 

                        c.det_id, c.det_nombre desc 
                 ";
            $sentencia = $this->dbLink->prepare("$sql");
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }

    public function listar_por_tipoculto($tipoculto_id)
    {
        try {
            $sql = "
              select * from det_culto where tc_id = :p_tipoculto_id  ";
            $sentencia = $this->dbLink->prepare("$sql");
            $sentencia->bindParam(":p_tipoculto_id", $tipoculto_id);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }

    public function agregar()
    {
        $this->dbLink->beginTransaction();

        try {

            $sql = "select * from f_generar_correlativo('detalle_tipoculto') as correlativo";
            $sentencia = $this->dbLink->prepare($sql);
            $sentencia->execute();


            if($sentencia->rowCount()) { /*rowcount es un metodo por tanto lleva parentesis*/
                //si se encontro el correlativo para la tabla parroquia
                $resultado = $sentencia->fetch(PDO::FETCH_ASSOC); /*FETCH_ASSOC para no repetir la informacion y obtenerla con el nombre del campo*/
                $nuevocul_id = $resultado["correlativo"]; //cargar nuevo codigo de culto
                $this->setId($nuevocul_id);

                $sql = "
                    INSERT INTO det_culto
                                (
                                det_id,
                                 det_nombre, 
                                 det_descripcion,
                                 tc_id                                 
                                )

                        VALUES  (
                                :p_id,
                                :p_nombre, 
                                :p_descripcion, 
                                :p_tipoculto                              
                                );
                        ";
                $sentencia = $this->dbLink->prepare($sql);
                $sentencia->bindParam(":p_nombre", $this->nombre);
                $sentencia->bindParam(":p_descripcion", $this->descripcion);
                $sentencia->bindParam(":p_tipoculto", $this->tipoculto_id);
                $sentencia->bindParam(":p_id", $this->id);
                $sentencia->execute();


                $sql = "update correlativo set numero = numero + 1 where tabla = 'detalle_tipoculto'";
                $sentencia= $this->dbLink->prepare($sql);
                $sentencia->execute();

                //CONFIRMAR LA TRANSACCION
                $this->dbLink->commit();


                return TRUE;
            }
            else{
                //no se encontro el correlativo para la tabla parroquia
                throw new Exception("No se encontró el correlativo para la tabla Culto");
            }


        } catch (Exception $exc) {
            $this->dbLink->rollback();//ABORTAR /DESHACER TODO LO QUE SE HA
            throw $exc;
        }
    }

    public function read($id)
    {
        try {
            $sql = "
                    select 
                            det_id,
                            det_nombre,
                            det_descripcion,
                            tc_id                          
                    from
                           det_culto

                    where   det_id = :p_id
                   ";

            $sentencia = $this->dbLink->prepare($sql);
            $sentencia->bindParam(":p_id", $id);
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
                        det_culto
                SET	
                        det_nombre		= :p_nombre, 
                        det_descripcion  = :p_descripcion,
                        tc_id        = :p_tipoculto                       

                 WHERE 
                        det_id                   = :p_id

                 ";
            $sentencia = $this->dbLink->prepare($sql);

            $sentencia->bindParam(":p_nombre", $this->nombre);
            $sentencia->bindParam(":p_descripcion", $this->descripcion);
            $sentencia->bindParam(":p_tipoculto", $this->tipoculto_id);
            $sentencia->bindParam(":p_id", $this->id);
            $sentencia->execute();

            $this->dbLink->commit();

            return TRUE;

        } catch (Exception $exc) {
            $this->dbLink->rollBack();
            throw $exc;
        }

    }

}