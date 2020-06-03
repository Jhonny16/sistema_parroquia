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

    public function agregar()
    {

        try {



                $sql = "
                    INSERT INTO det_culto
                                (
                                 det_nombre, 
                                 det_descripcion,
                                 tc_id                                 
                                )

                        VALUES  (
                                :p_nombre, 
                                :p_descripcion, 
                                :p_tipoculto                              
                                );
                        ";
                $sentencia = $this->dbLink->prepare($sql);
                $sentencia->bindParam(":p_nombre", $this->nombre);
                $sentencia->bindParam(":p_descripcion", $this->descripcion);
                $sentencia->bindParam(":p_tipoculto", $this->tipoculto_id);
                $sentencia->execute();
                return TRUE;

        } catch (Exception $exc) {
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