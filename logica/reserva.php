<?php
/**
 * Created by PhpStorm.
 * User: jhonny
 * Date: 01/06/20
 * Time: 06:37 PM
 */
require_once '../datos/Conexion.php';

class reserva extends Conexion
{

    private $id;
    private $code;
    private $estado;
    private $ofrece;
    private $detail;
    private $total;
    private $cliente_dni;
    private $padre_id;
    private $cantor_id;
    private $horario_id;
    private $detalle_reserva;

    /**
     * @return mixed
     */
    public function getDetail()
    {
        return $this->detail;
    }

    /**
     * @param mixed $detail
     */
    public function setDetail($detail)
    {
        $this->detail = $detail;
    }



    /**
     * @return mixed
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @param mixed $total
     */
    public function setTotal($total)
    {
        $this->total = $total;
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
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * @param mixed $estado
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;
    }

    /**
     * @return mixed
     */
    public function getOfrece()
    {
        return $this->ofrece;
    }

    /**
     * @param mixed $ofrece
     */
    public function setOfrece($ofrece)
    {
        $this->ofrece = $ofrece;
    }

    /**
     * @return mixed
     */
    public function getClienteDni()
    {
        return $this->cliente_dni;
    }

    /**
     * @param mixed $cliente_dni
     */
    public function setClienteDni($cliente_dni)
    {
        $this->cliente_dni = $cliente_dni;
    }

    /**
     * @return mixed
     */
    public function getPadreId()
    {
        return $this->padre_id;
    }

    /**
     * @param mixed $padre_id
     */
    public function setPadreId($padre_id)
    {
        $this->padre_id = $padre_id;
    }

    /**
     * @return mixed
     */
    public function getCantorId()
    {
        return $this->cantor_id;
    }

    /**
     * @param mixed $cantor_id
     */
    public function setCantorId($cantor_id)
    {
        $this->cantor_id = $cantor_id;
    }

    /**
     * @return mixed
     */
    public function getHorarioId()
    {
        return $this->horario_id;
    }

    /**
     * @param mixed $horario_id
     */
    public function setHorarioId($horario_id)
    {
        $this->horario_id = $horario_id;
    }

    /**
     * @return mixed
     */
    public function getDetalleReserva()
    {
        return $this->detalle_reserva;
    }

    /**
     * @param mixed $detalle_reserva
     */
    public function setDetalleReserva($detalle_reserva)
    {
        $this->detalle_reserva = $detalle_reserva;
    }

    public function create()
    {
        $this->dbLink->beginTransaction();
        try {
            $sql = "select numero from correlativo where tabla = 'reserva' ";
            $sentencia = $this->dbLink->prepare($sql);
            $sentencia->execute();
            $resultado = $sentencia->fetch();

            $secuencia = $resultado["numero"];
            $secuencia = $secuencia + 1;

            $correlativo = str_pad($secuencia, 6, "0", STR_PAD_LEFT);

            $numeracion = "RESERVA-" . $correlativo;

            $sql = "
                    INSERT INTO reserva (code, estado, ofrece, total, cliente_dni, horario_id) 
                    VALUES (:p_code, :p_estado, :p_ofrece, :p_total, :p_cliente_dni, :p_horario_id);
                        ";
            $sentencia = $this->dbLink->prepare($sql);
            $sentencia->bindParam(":p_code", $numeracion);
            $sentencia->bindParam(":p_estado", $this->estado);
            $sentencia->bindParam(":p_ofrece", $this->ofrece);
            $sentencia->bindParam(":p_total", $this->total);
            $sentencia->bindParam(":p_cliente_dni", $this->cliente_dni);
            $sentencia->bindParam(":p_padre_id", $this->padre_id);
            $sentencia->execute();
            //SELECT int_id FROM intencion order by 1 desc limit 1

            $sql2 = " select id from reserva ORDER by 1 DESC limit 1 ";
            $sentencia1 = $this->dbLink->prepare($sql2);
            $sentencia1->execute();
            $resultado1 = $sentencia1->fetch();

            if ($sentencia1->rowCount()) {
                $reserva_id = $resultado1["id"];
                $datosDetalle = json_decode($this->detalle_reserva);

                foreach ($datosDetalle as $key => $value) {
                    $sql = "insert into 
                        detalle_reserva (dirigido, importe, reserva_id, tipoculto_detalle) values(:p_dirigido, :p_importe,:p_reserva_id, :p_detalle)";
                    $sentencia = $this->dbLink->prepare($sql);
                    $sentencia->bindParam(":p_dirigido", $value->dirigido);
                    $sentencia->bindParam(":p_importe", $value->importe);
                    $sentencia->bindParam(":p_detalle", $value->detalle);
                    $sentencia->bindParam(":p_reserva_id", $reserva_id);
                    $sentencia->execute();
                }

            }

            $sql = "update correlativo set numero = :p_secuencia where tabla = 'reserva' ";
            $sentencia = $this->dbLink->prepare($sql);
            $sentencia->bindParam(":p_secuencia", $secuencia);
            $sentencia->execute();

            $this->dbLink->commit();


            if ($this->estado == 'Pagado') {
                $this->create_pago($reserva_id);
            }

            return true;

        } catch (Exception $exc) {
            $this->dbLink->rollBack();
            throw $exc;
        }
    }

    public function create_pago($reserva_id)
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
            $sentencia->bindParam(":p_reserva_id", $reserva_id);
            $sentencia->bindParam(":p_fecha", $fecha);
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


    public function listar($fecha, $parroquia_id)
    {
        try {
            $sql = "
               select
                      h.id,
                      h.fecha,
                      hp.hora_hora as hora,
                      tc.tc_id as tipoculto_id,
                      tc.tc_tiempo_maximo as dias,
                      tc.tc_nombre as tipoculto_nombre,
                      (case when tc.tc_tipo = 'I' then 'Individual' else 'Comunitario'end) as tipoculto_type,
                      coalesce('Limosna: '||(select limosna from lista_precio where capilla_id = c.cap_id and tipo_culto_id = tc.tc_id
                                                                       and (h.fecha between fecha_inicio and fecha_fin) order by 1 desc limit 1) || ' / ' ||
                      'Templo: ' || (select templo from lista_precio where capilla_id = c.cap_id and tipo_culto_id = tc.tc_id
                                                                       and (h.fecha between fecha_inicio and fecha_fin) order by 1 desc limit 1) || ' / ' ||
                      'Cantor: '|| (select cantor from lista_precio where capilla_id = c.cap_id and tipo_culto_id = tc.tc_id
                                                                      and (h.fecha between fecha_inicio and fecha_fin) order by 1 desc limit 1),'-') as precio_detalle,
                      coalesce((select precio from lista_precio where capilla_id = c.cap_id and tipo_culto_id = tc.tc_id
                                                         and (h.fecha between fecha_inicio and fecha_fin) order by 1 desc limit 1),0) as precio_normal,
                      c.cap_id as capilla_id,
                      c.cap_nombre,
                      (case
                         when (tc.tc_tipo = 'I' and (select count(id) from reserva where horario_id = h.id) = 0) then 'Disponible'
                         when tc.tc_tipo = 'C' then 'Disponible'
                         else 'No disponible'
                        end) as disponibilidad,
                      coalesce((select count(id) from reserva where horario_id = h.id),0) as numero_reservas
                from
                horario h inner join capilla c on h.capilla_id = c.cap_id
                  inner join parroquia p on c.par_id = p.par_id
                inner join horario_patron hp on h.hora_id = hp.hora_id
                inner join tipo_culto tc on h.tipoculto_id = tc.tc_id
                where h.fecha  = :p_fecha and h.estado = 'A'
                and p.par_id = :p_parroquia_id;
                ";
            $sentencia = $this->dbLink->prepare($sql);
            $sentencia->bindParam(":p_fecha", $fecha);
            $sentencia->bindParam(":p_parroquia_id", $parroquia_id);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);

            return $resultado;

        } catch (Exception $exc) {
            throw $exc;
        }
    }

    public function sms($id)
    {

        try {

            $sql = "select
                          r.*,
                          p.per_apellido_paterno ||' '||p.per_apellido_materno||' '||p.per_nombre as cliente,
                          p.per_telefono, hp.hora_hora, h.fecha, tc.tc_nombre,c.cap_nombre
                        from reserva r inner join persona p on r.cliente_dni = p.per_iddni
                                       inner join detalle_reserva dr on r.id = dr.reserva_id
                                       inner join horario h on r.horario_id = h.id
                                       inner join tipo_culto tc on h.tipoculto_id = tc.tc_id
                                       inner join horario_patron hp on h.hora_id = hp.hora_id
                                       inner join capilla c on h.capilla_id = c.cap_id
                        where r.id= :p_id limit 1;";
            $sentencia = $this->dbLink->prepare($sql);
            $sentencia->bindParam(":p_id", $id);
            $sentencia->execute();
            $resultado = $sentencia->fetch(PDO::FETCH_ASSOC);
            return $resultado;

        } catch (Exception $exc) {
            throw $exc;
        }

    }


    public function listar_por_horario()
    {
        try {
            $sql = "
              select  
              c.cap_id as capilla_id,
                       r.id,
                       r.code,
                       r.fecha as fecha_reserva,
                       h.fecha ||' / '||hp.hora_hora as horario,
                       r.estado,
                       r.ofrece,
                       tc.tc_nombre,
                      (case when tc.tc_tipo = 'I' then 'Individual' else 'Comunitario'end) as tipoculto_type,
                       cli.per_apellido_paterno ||' '|| cli.per_apellido_materno ||' '|| cli.per_nombre as cliente,
                       padre.per_iddni as padre_dni,
                       cantor.per_iddni as cantor_dni,
                       coalesce(padre.per_apellido_paterno ||' '|| padre.per_apellido_materno ||' '|| padre.per_nombre, '-') as padre,
                       coalesce(cantor.per_apellido_paterno ||' '|| cantor.per_apellido_materno ||' '|| cantor.per_nombre,'-') as nombre_cantor,
                       r.total,
                       dr.dirigido,
                       dr.importe,
                       dr.tipoculto_detalle,
                       coalesce(p.code, '-') as pago_code,
                       p.fecha as fecha_pago,
                       (select limosna from lista_precio where capilla_id = c.cap_id and tipo_culto_id = tc.tc_id
                                                                       and (h.fecha between fecha_inicio and fecha_fin) order by 1 desc limit 1) as limosna,  
                       (select templo from lista_precio where capilla_id = c.cap_id and tipo_culto_id = tc.tc_id
                                                                       and (h.fecha between fecha_inicio and fecha_fin) order by 1 desc limit 1) as templo,
                       (select cantor from lista_precio where capilla_id = c.cap_id and tipo_culto_id = tc.tc_id
                                                                       and (h.fecha between fecha_inicio and fecha_fin) order by 1 desc limit 1) as cantor
                from reserva r inner join horario h on r.horario_id = h.id
                inner join persona cli on r.cliente_dni = cli.per_iddni
                left join persona padre on h.padre_dni = padre.per_iddni
                left join persona cantor on h.cantor_dni = cantor.per_iddni
                inner join detalle_reserva dr on r.id = dr.reserva_id
                inner join horario_patron hp on h.hora_id = hp.hora_id
                inner join tipo_culto tc on h.tipoculto_id = tc.tc_id
                inner join capilla c on h.capilla_id = c.cap_id
                left join pago p on r.id = p.reserva_id
                where 
                  (case when :p_reserva_id = 0 then true else r.id = :p_reserva_id end)
                    and (case when :p_horario_id = 0 then TRUE else h.id = :p_horario_id end)
                    and (case when :p_persona_dni = '0' then TRUE else cli.per_iddni = :p_persona_dni end);

                ";
            $sentencia = $this->dbLink->prepare($sql);
            $sentencia->bindParam(":p_reserva_id", $this->id);
            $sentencia->bindParam(":p_horario_id", $this->horario_id);
            $sentencia->bindParam(":p_persona_dni", $this->cliente_dni);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;

        } catch (Exception $exc) {
            throw $exc;
        }
    }


    public function listar_por_horario_filtros($parroquia_id)
    {
        try {
            $sql = "
              select
                h.id as horario_id,
                h.fecha ||' / '||hp.hora_hora as horario,
                p.per_iddni as persona_dni,
                p.per_apellido_paterno ||' '|| p.per_apellido_materno ||' '|| p.per_nombre as persona_nombre,
                r.id as reserva_id,
                r.code as reserva_code
                from reserva r inner join horario h on r.horario_id = h.id
                               inner join horario_patron hp on h.hora_id = hp.hora_id
                               inner join tipo_culto tc on h.tipoculto_id = tc.tc_id
                inner join persona p on r.cliente_dni = p.per_iddni
                inner join capilla c on h.capilla_id = c.cap_id
                where c.par_id = :p_parroquia_id
                ";
            $sentencia = $this->dbLink->prepare($sql);
            $sentencia->bindParam(":p_parroquia_id", $parroquia_id);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;

        } catch (Exception $exc) {
            throw $exc;
        }
    }

    public function anular()
    {

        $this->dbLink->beginTransaction();

        try {

            $anulado = 'Anulado';

            $sql = "update reserva set estado = :p_estado where id = :p_id ";
            $sentencia = $this->dbLink->prepare($sql);
            $sentencia->bindParam(":p_estado", $anulado);
            $sentencia->bindParam(":p_id", $this->id);
            $sentencia->execute();

            $sql = "update pago set estado = :p_estado where reserva_id = :p_reserva_id ";
            $sentencia = $this->dbLink->prepare($sql);
            $sentencia->bindParam(":p_estado", $anulado);
            $sentencia->bindParam(":p_reserva_id", $this->id);
            $sentencia->execute();

            $this->dbLink->commit();

            return true;

        } catch (Exception $exc) {
            $this->dbLink->rollBack();
            throw $exc;
        }


    }



}