<?php
/**
 * Created by PhpStorm.
 * User: jhonny
 * Date: 31/05/20
 * Time: 02:40 PM
 */
require_once '../datos/Conexion.php';

class listaPrecios extends Conexion
{
    private $id;
    private $limosna;
    private $templo;
    private $cantor;
    private $precio;
    private $fecha_inicio;
    private $fecha_fin;
    private $capilla_id;
    private $tipo_culto_id;

    /**
     * @return mixed
     */
    public function getLimosna()
    {
        return $this->limosna;
    }

    /**
     * @param mixed $limosna
     */
    public function setLimosna($limosna)
    {
        $this->limosna = $limosna;
    }

    /**
     * @return mixed
     */
    public function getTemplo()
    {
        return $this->templo;
    }

    /**
     * @param mixed $templo
     */
    public function setTemplo($templo)
    {
        $this->templo = $templo;
    }

    /**
     * @return mixed
     */
    public function getCantor()
    {
        return $this->cantor;
    }

    /**
     * @param mixed $cantor
     */
    public function setCantor($cantor)
    {
        $this->cantor = $cantor;
    }



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
    public function getPrecio()
    {
        return $this->precio;
    }

    /**
     * @param mixed $precio
     */
    public function setPrecio($precio)
    {
        $this->precio = $precio;
    }

    /**
     * @return mixed
     */
    public function getFechaInicio()
    {
        return $this->fecha_inicio;
    }

    /**
     * @param mixed $fecha_inicio
     */
    public function setFechaInicio($fecha_inicio)
    {
        $this->fecha_inicio = $fecha_inicio;
    }

    /**
     * @return mixed
     */
    public function getFechaFin()
    {
        return $this->fecha_fin;
    }

    /**
     * @param mixed $fecha_fin
     */
    public function setFechaFin($fecha_fin)
    {
        $this->fecha_fin = $fecha_fin;
    }

    /**
     * @return mixed
     */
    public function getCapillaId()
    {
        return $this->capilla_id;
    }

    /**
     * @param mixed $capilla_id
     */
    public function setCapillaId($capilla_id)
    {
        $this->capilla_id = $capilla_id;
    }

    /**
     * @return mixed
     */
    public function getTipoCultoId()
    {
        return $this->tipo_culto_id;
    }

    /**
     * @param mixed $tipo_culto_id
     */
    public function setTipoCultoId($tipo_culto_id)
    {
        $this->tipo_culto_id = $tipo_culto_id;
    }



    public function listar ($paroquia_id,$rol) {
        try {

            if($rol == 3 or $rol == '3'){

            }else{
                $sql="select
                          lp.id,
                          lp.limosna,
                          lp.templo,
                          lp.cantor,
                           lp.precio,
                           lp.fecha_inicio || ' / ' || lp.fecha_fin as fechas,
                           p.par_nombre || ' / '|| c.cap_nombre as parroquia_capilla,
                           tc.tc_nombre as tipo_culto,
                          --(case when current_date between lp.fecha_inicio and lp.fecha_fin then 'Vigente' else 'Expiró vigencia' end) as vigencia
                          (case when current_date < lp.fecha_fin then 'Vigente' else 'Expiró vigencia' end) as vigencia
                    from lista_precio lp inner join capilla c on lp.capilla_id = c.cap_id
                    inner join tipo_culto tc on lp.tipo_culto_id = tc.tc_id
                    inner join parroquia p on c.par_id = p.par_id
                    where c.par_id = :p_parroquia_id
                    --(case when c.parroquia = TRUE then TRUE else c.cap_id = :p_capilla_id end)
                    ";
                $sentencia = $this->dbLink->prepare("$sql");
                $sentencia->bindParam(":p_parroquia_id", $paroquia_id);
                $sentencia->execute();
                $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            }

            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }

    }

    public function read () {
        try {
            $sql="select
                        lp.*,
                        tc.cul_id as tipo_culto_id,
                        c.cap_id as capilla_id
                    from lista_precio lp inner join capilla c on lp.capilla_id = c.cap_id
                    inner join tipo_culto tc on lp.tipo_culto_id = tc.tc_id
                    inner join parroquia p on c.par_id = p.par_id
                    where lp.id = :p_id
                    ";
            $sentencia = $this->dbLink->prepare("$sql");
            $sentencia->bindParam(":p_id", $this->id);
            $sentencia->execute();
            $resultado = $sentencia->fetch(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }

    }

    public function create()
    {
        try {

                $sql = "
                    insert into lista_precio (limosna,templo,cantor, precio, capilla_id, tipo_culto_id,fecha_inicio,fecha_fin)
                      values (:p_limosna, :p_templo, :p_cantor, :p_precio, :p_capilla_id, :p_tipoculto_id, :p_fecha_inicio, :p_fecha_fin);
                        ";
                $sentencia = $this->dbLink->prepare($sql);
                $sentencia->bindParam(":p_limosna", $this->limosna);
                $sentencia->bindParam(":p_templo", $this->templo);
                $sentencia->bindParam(":p_cantor", $this->cantor);
                $sentencia->bindParam(":p_precio", $this->precio);
                $sentencia->bindParam(":p_capilla_id", $this->capilla_id);
                $sentencia->bindParam(":p_tipoculto_id", $this->tipo_culto_id);
                $sentencia->bindParam(":p_fecha_inicio", $this->fecha_inicio);
                $sentencia->bindParam(":p_fecha_fin", $this->fecha_fin);
                $sentencia->execute();

                return true;

        } catch (Exception $exc) {
            throw $exc;
        }
    }

    public function update()
    {


        try {

            $this->dbLink->beginTransaction();

            $sql = "
                UPDATE lista_precio SET limosna = :p_limosna, templo = :p_templo, cantor = :p_cantor,
                                        precio = :p_precio, capilla_id = :p_capilla_id, tipo_culto_id = :p_tipoculto_id,
                                        fecha_inicio = :p_fecha_inicio, fecha_fin = :p_fecha_fin 
                WHERE id = :p_id 

                 ";
            $sentencia = $this->dbLink->prepare($sql);

            $sentencia->bindParam(":p_limosna", $this->limosna);
            $sentencia->bindParam(":p_templo", $this->templo);
            $sentencia->bindParam(":p_cantor", $this->cantor);
            $sentencia->bindParam(":p_precio", $this->precio);
            $sentencia->bindParam(":p_capilla_id", $this->capilla_id);
            $sentencia->bindParam(":p_tipoculto_id", $this->tipo_culto_id);
            $sentencia->bindParam(":p_fecha_inicio", $this->fecha_inicio);
            $sentencia->bindParam(":p_fecha_fin", $this->fecha_fin);
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