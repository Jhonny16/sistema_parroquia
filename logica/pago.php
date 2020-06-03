<?php
/**
 * Created by PhpStorm.
 * User: jhonny
 * Date: 02/06/20
 * Time: 12:50 PM
 */
require_once '../datos/Conexion.php';

class pago extends Conexion
{
    private $id;
    private $code;
    private $reserva_id;

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
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param mixed $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * @return mixed
     */
    public function getReservaId()
    {
        return $this->reserva_id;
    }

    /**
     * @param mixed $reserva_id
     */
    public function setReservaId($reserva_id)
    {
        $this->reserva_id = $reserva_id;
    }

    public function create()
    {

        $this->dbLink->beginTransaction();

        try {
            $sql = "select numero from correlativo where tabla = 'pago' ";
            $sentencia = $this->dbLink->prepare($sql);
            $sentencia->execute();
            $resultado = $sentencia->fetch();

            $secuencia = $resultado["numero"];
            $secuencia = $secuencia + 1;

            $correlativo = str_pad($secuencia, 6, "0", STR_PAD_LEFT);

            $numeracion = "PAGO-" . $correlativo;

            date_default_timezone_set("America/Lima");
            $fecha = date('Y-m-d');
            $sql = "insert into pago (code, reserva_id,fecha) values (:p_code, :p_reserva_id,:p_fecha)";
            $sentencia = $this->dbLink->prepare($sql);
            $sentencia->bindParam(":p_code", $numeracion);
            $sentencia->bindParam(":p_reserva_id", $this->reserva_id);
            $sentencia->bindParam(":p_fecha", $fecha);
            $sentencia->execute();


            $reserva_estado = 'Pagado';
            $sql = "update reserva set estado = :p_estado where id = :p_reserva_id ";
            $sentencia = $this->dbLink->prepare($sql);
            $sentencia->bindParam(":p_estado", $reserva_estado);
            $sentencia->bindParam(":p_reserva_id", $this->reserva_id);
            $sentencia->execute();

            $sql = "update correlativo set numero = :p_secuencia where tabla = 'pago' ";
            $sentencia = $this->dbLink->prepare($sql);
            $sentencia->bindParam(":p_secuencia", $secuencia);
            $sentencia->execute();


            $this->dbLink->commit();

            return true;

        } catch (Exception $exc) {
            $this->dbLink->rollBack();
            throw $exc;
        }


    }

}