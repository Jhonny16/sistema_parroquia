<?php

require_once '../datos/Conexion.php';

class Intencion extends Conexion
{

    private $id;
    private $code;
    private $padre;
    private $cliente;
    private $total;
    private $estado;
    private $detalle;
    private $capilla;
    private $cantor;
    private $ofrece;
    private $detail;

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
    public function getCapilla()
    {
        return $this->capilla;
    }

    /**
     * @param mixed $capilla
     */
    public function setCapilla($capilla)
    {
        $this->capilla = $capilla;
    }



    /**
     * @return mixed
     */
    public function getDetalle()
    {
        return $this->detalle;
    }

    /**
     * @param mixed $detalle
     */
    public function setDetalle($detalle)
    {
        $this->detalle = $detalle;
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
    public function getPadre()
    {
        return $this->padre;
    }

    /**
     * @param mixed $padre
     */
    public function setPadre($padre)
    {
        $this->padre = $padre;
    }

    /**
     * @return mixed
     */
    public function getCliente()
    {
        return $this->cliente;
    }

    /**
     * @param mixed $cliente
     */
    public function setCliente($cliente)
    {
        $this->cliente = $cliente;
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



    public function create(){
        $this->dbLink->beginTransaction();
        try {
            $sql = "select numero from correlativo where tabla = 'intencion' ";
            $sentencia = $this->dbLink->prepare($sql);
            $sentencia->execute();
            $resultado = $sentencia->fetch();

            $secuencia = $resultado["numero"];
            $secuencia = $secuencia + 1;

            $correlativo = str_pad($secuencia, 6, "0", STR_PAD_LEFT);  // produce "-=-=-Alien"

            $numeracion = "RESERVA-" . $correlativo;

            $sql = "
                    INSERT INTO reserva
                                (
                                code, 
                                padre, 
                                cliente_dni,
                                total,
                                estado,
                                capilla_id,
                                cantor,
                                ofrece,
                                detail
                               )

                        VALUES (
                                :p_code, 
                                :p_padre, 
                                :p_cliente,
                                :p_total,
                                :p_estado,
                                :p_capilla,
                                :p_cantor,
                                :p_ofrece,
                                :p_detail
                                );
                        ";
            $sentencia = $this->dbLink->prepare($sql);
            $sentencia->bindParam(":p_code", $numeracion);
            $sentencia->bindParam(":p_padre", $this->padre);
            $sentencia->bindParam(":p_cliente", $this->cliente);
            $sentencia->bindParam(":p_total", $this->total);
            $sentencia->bindParam(":p_estado", $this->estado);
            $sentencia->bindParam(":p_capilla", $this->capilla);
            $sentencia->bindParam(":p_cantor", $this->cantor);
            $sentencia->bindParam(":p_ofrece", $this->ofrece);
            $sentencia->bindParam(":p_detail", $this->detail);
            $sentencia->execute();
            //SELECT int_id FROM intencion order by 1 desc limit 1

            $sql2 = " select id from reserva ORDER by 1 DESC limit 1 ";
            $sentencia1 = $this->dbLink->prepare($sql2);
            $sentencia1->execute();
            $resultado1 = $sentencia1->fetch();

            if ($sentencia1->rowCount()) {
                $intencion_id = $resultado1["id"];
                $datosDetalle = json_decode($this->detalle);
                //print_r($datosDetalle);
                foreach ($datosDetalle as $key => $value) {
                    $sql = "insert into 
                        detalle_intencion  (horario_id, dirigido,importe,intencion_id)
                        values(
                        :p_horario, 
                        :p_dirigido, 
                        :p_importe, 
                        :p_intencion                         
                        )";
                    $sentencia = $this->dbLink->prepare($sql);
                    $sentencia->bindParam(":p_horario", $value->horario);
                    $sentencia->bindParam(":p_dirigido", $value->dirigido);
                    $sentencia->bindParam(":p_importe", $value->importe);
                    $sentencia->bindParam(":p_intencion", $intencion_id);
                    $sentencia->execute();
                }

            }

            $sql = "update correlativo set numero = :p_secuencia where tabla = 'intencion' ";
            $sentencia = $this->dbLink->prepare($sql);
            $sentencia->bindParam(":p_secuencia", $secuencia);
            $sentencia->execute();

            $this->dbLink->commit();

            return $intencion_id; //RETORNA VERDARERO CUANDO HA REGISTRADO TODO CORRECTAMENTE

        } catch (Exception $exc) {
            $this->dbLink->rollBack();
            throw $exc;
        }
    }

    public function update(){
        $this->dbLink->beginTransaction();
        try {



            $sql = "update reserva set 
                        padre = :p_padre, 
                        cliente_dni = :p_cliente,
                        total = :p_total,
                        estado = :p_estado,
                        capilla_id = :p_capilla,
                        cantor = :p_cantor,
                        ofrece = :p_ofrece,
                        detail = :p_detail
                    where id = :p_reserva_id ";
            $sentencia = $this->dbLink->prepare($sql);
            $sentencia->bindParam(":p_padre", $this->padre);
            $sentencia->bindParam(":p_cliente", $this->cliente);
            $sentencia->bindParam(":p_total", $this->total);
            $sentencia->bindParam(":p_estado", $this->estado);
            $sentencia->bindParam(":p_capilla", $this->capilla);
            $sentencia->bindParam(":p_cantor", $this->cantor);
            $sentencia->bindParam(":p_ofrece", $this->ofrece);
            $sentencia->bindParam(":p_detail", $this->detail);
            $sentencia->bindParam(":p_reserva_id", $this->id);
            $sentencia->execute();

            $sql2 = "delete from detalle_intencion where intencion_id = :p_reserva_id ";
            $sentencia1 = $this->dbLink->prepare($sql2);
            $sentencia1->bindParam(":p_reserva_id", $this->id);
            $sentencia1->execute();

            $datosDetalle = json_decode($this->detalle);
            //print_r($datosDetalle);
            foreach ($datosDetalle as $key => $value) {
                $sql = "insert into detalle_intencion (horario_id, dirigido,importe,intencion_id) values(
                    :p_horario, :p_dirigido, :p_importe, :p_intencion)";
                $sentence = $this->dbLink->prepare($sql);
                $sentence->bindParam(":p_horario", $value->horario);
                $sentence->bindParam(":p_dirigido",$value->dirigido);
                $sentence->bindParam(":p_importe", $value->importe);
                $sentence->bindParam(":p_intencion", $this->id);
                $sentence->execute();
            }


            $this->dbLink->commit();

            return TRUE; //RETORNA VERDARERO CUANDO HA REGISTRADO TODO CORRECTAMENTE

        } catch (Exception $exc) {
            $this->dbLink->rollBack();
            throw $exc;
        }
    }
    public function listar($fecha1,$fecha2,$celebracion,$estado,$type,$capilla) {
        try {
            $sql="
               select i.id, i.code,i.cliente_dni,(p.per_apellido_paterno ||' '|| p.per_apellido_materno||' '|| p.per_nombre) as cliente,
                i.estado, i.total,h.fecha,hora_hora,ce.cel_nombre as celebracion,ce.cel_id ,
                  (case when tc.tc_tipo='I' then 'Individual' else 'Comunitario' end) as type
                from reserva i INNER JOIN detalle_intencion d on d.intencion_id = i.id
                inner join persona p on i.cliente_dni = p.per_iddni
                left join horario h on h.id = d.horario_id
                inner join tipo_culto tc on tc.tc_id = h.tipoculto_id
                inner join horario_patron hp on hp.hora_id = h.hora_id
                inner join culto c on tc.cul_id = c.cul_id
                inner join celebracion ce on c.cel_id = ce.cel_id
                where (h.fecha BETWEEN :p_inicio and :p_fin) and ce.cel_id = :p_celebracion and i.estado = :p_estado
                and tc.tc_tipo = :p_type and i.capilla_id = :p_capilla 
                group by i.id, i.code,i.cliente_dni,p.per_apellido_paterno , p.per_apellido_materno, p.per_nombre,
                i.estado, i.total,h.fecha,hora_hora,ce.cel_nombre ,ce.cel_id ,tc.tc_tipo
                ";
            $sentencia = $this->dbLink->prepare($sql);
            $sentencia->bindParam(":p_inicio", $fecha1);
            $sentencia->bindParam(":p_fin", $fecha2);
            $sentencia->bindParam(":p_celebracion", $celebracion);
            $sentencia->bindParam(":p_estado", $estado);
            $sentencia->bindParam(":p_type", $type);
            $sentencia->bindParam(":p_capilla", $capilla);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);

            return $resultado;

        } catch (Exception $exc) {
            throw $exc;
        }
    }

    public function listar_por_cliente($fecha1,$fecha2,$dni) {
        try {
            $sql="
                      select i.id, i.code,i.cliente_dni,(p.per_apellido_paterno ||' '|| p.per_apellido_materno||' '|| p.per_nombre) as cliente,
               i.estado, i.total,h.fecha,hora_hora,ce.cel_nombre as celebracion,ce.cel_id ,
               (case when tc.tc_tipo='I' then 'Individual' else 'Comunitario' end) as type
        from reserva i INNER JOIN detalle_intencion d on d.intencion_id = i.id
                       inner join persona p on i.cliente_dni = p.per_iddni
                       left join horario h on h.id = d.horario_id
                       inner join tipo_culto tc on tc.tc_id = h.tipoculto_id
                       inner join horario_patron hp on hp.hora_id = h.hora_id
                       inner join culto c on tc.cul_id = c.cul_id
                       inner join celebracion ce on c.cel_id = ce.cel_id
        where (h.fecha BETWEEN :p_inicio and :p_fin) and p.per_iddni = :p_dni
        group by i.id, i.code,i.cliente_dni,p.per_apellido_paterno , p.per_apellido_materno, p.per_nombre,
                 i.estado, i.total,h.fecha,hora_hora,ce.cel_nombre ,ce.cel_id ,tc.tc_tipo
                ";
            $sentencia = $this->dbLink->prepare($sql);
            $sentencia->bindParam(":p_inicio", $fecha1);
            $sentencia->bindParam(":p_fin", $fecha2);
            $sentencia->bindParam(":p_dni", $dni);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);

            return $resultado;

        } catch (Exception $exc) {
            throw $exc;
        }
    }
    public function report($id) {
        try {
            $sql="
               select i.id, i.code,i.cliente_dni,(p.per_apellido_paterno ||' '|| p.per_apellido_materno||' '|| p.per_nombre) as cliente,
              i.estado, i.total,h.fecha,hora_hora,tc.tc_nombre as tipo_culto ,d.dirigido,d.importe,
              (case when tc.tc_tipo='I' then 'Individual' else 'Comunitario' end) as type,
              ca.cap_nombre as capilla
            from reserva i left JOIN detalle_intencion d on d.intencion_id = i.id
              inner join persona p on i.cliente_dni = p.per_iddni
              left join horario h on h.id = d.horario_id
              inner join tipo_culto tc on tc.tc_id = h.tipoculto_id
              inner join horario_patron hp on hp.hora_id = h.hora_id
              inner join culto c on tc.cul_id = c.cul_id
              inner join celebracion ce on c.cel_id = ce.cel_id
              left join capilla ca on ca.cap_id = i.capilla_id
              where i.id = :p_id;
                ";
            $sentencia = $this->dbLink->prepare($sql);
            $sentencia->bindParam(":p_id", $id);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);

            return $resultado;

        } catch (Exception $exc) {
            throw $exc;
        }
    }

    public function update_estado()
    {
        $this->dbLink->beginTransaction();
        try {
            $sql = "UPDATE reserva SET estado  = :p_estado
                        WHERE id = :p_id ";

            $sentencia = $this->dbLink->prepare($sql);
            $sentencia->bindParam(":p_id", $this->id);
            $sentencia->bindParam(":p_estado", $this->estado);
            $sentencia->execute();

            $this->dbLink->commit();

            return true;

        } catch (Exception $ex) {
            $this->dbLink->rollBack();
            throw $ex;
        }
    }

    public function reserva_list($id)
    {

        try {

            $sql = "select h.id, hp.hora_hora, tc.tc_nombre, h.fecha, c.cap_nombre,c.cap_id,
                          r.code, r.estado, r.padre, r.total,
                          (p.per_apellido_paterno||' '||p.per_apellido_materno||' '|| p.per_nombre) as cliente,
                          tc.tc_id,tc.tc_tiempo_maximo as dias
                           from horario h inner join horario_patron hp on h.hora_id = hp.hora_id
                           inner join tipo_culto tc on h.tipoculto_id = tc.tc_id
                           inner join capilla c on h.capilla_id = c.cap_id
                           left join detalle_intencion di on h.id = di.horario_id
                           left join reserva r on di.intencion_id = r.id
                           left join persona p on r.cliente_dni = p.per_iddni
                          where h.id = :p_id
                          group by h.id, hp.hora_hora, tc.tc_nombre, h.fecha, c.cap_nombre,
                          r.code, r.estado, r.padre, r.total,
                          p.per_apellido_paterno,p.per_apellido_materno,p.per_nombre,
                          tc.tc_id,c.cap_id";
            $sentencia = $this->dbLink->prepare($sql);
            $sentencia->bindParam(":p_id", $id);
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
                    inner join detalle_intencion di on r.id = di.intencion_id
                    inner join horario h on di.horario_id = h.id
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
}
