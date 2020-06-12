<?php

/**
 * Created by PhpStorm.
 * User: tito_
 * Date: 15/12/2018
 * Time: 12:05 PM
 */
require_once '../datos/Conexion.php';

class Horario extends Conexion
{
    private $id;
    private $hora_id;
    private $tipoculto_id;
    private $fecha;
    private $capilla_id;
    private $padre_dni;
    private $cantor_dni;

    /**
     * @return mixed
     */
    public function getPadreDni()
    {
        return $this->padre_dni;
    }

    /**
     * @param mixed $padre_dni
     */
    public function setPadreDni($padre_dni)
    {
        $this->padre_dni = $padre_dni;
    }

    /**
     * @return mixed
     */
    public function getCantorDni()
    {
        return $this->cantor_dni;
    }

    /**
     * @param mixed $cantor_dni
     */
    public function setCantorDni($cantor_dni)
    {
        $this->cantor_dni = $cantor_dni;
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
    public function getHoraId()
    {
        return $this->hora_id;
    }

    /**
     * @param mixed $hora_id
     */
    public function setHoraId($hora_id)
    {
        $this->hora_id = $hora_id;
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

    /**
     * @return mixed
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * @param mixed $fecha
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
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

    public function create($fecha1, $fecha2)
    {
        try {


            $datetime1 = new DateTime($fecha1);
            $datetime2 = new DateTime($fecha2);
            $interval = $datetime1->diff($datetime2);
            $dias = $interval->format('%R%a');
            //print_r($datetime1);
            $date1 = date($fecha1);
            //print_r($date1);
            $sw=0;
            for ($i = 0; $i <= (int)$dias; $i++) {

                // echo "<br>";
                $fecha = date("Y-m-d", strtotime($date1 . "+" . $i . " days"));
                //echo date("d-m-Y",strtotime($datetime1."+ 1 days"));
                $array = $this->hora_id;
                for ($j = 0; $j < count($array); $j++) {

                    $sql = "select id from horario where 
                            hora_id = :p_hora and
                            tipoculto_id = :p_tipo_culto and
                            fecha = :p_fecha and
                            capilla_id = :p_capilla ";
                    $sentencia = $this->dbLink->prepare($sql);
                    $sentencia->bindParam(":p_hora", $array[$j]);
                    $sentencia->bindParam(":p_tipo_culto", $this->tipoculto_id);
                    $sentencia->bindParam(":p_fecha", $fecha);
                    $sentencia->bindParam(":p_capilla", $this->capilla_id);
                    $sentencia->execute();

                    if($sentencia->rowCount()){
                        return 0;
                    }else{
                        $sw=1;

                    }

                }

                $bnd = 0;
                for ($j = 0; $j < count($array); $j++) {

                    $sql = "select count(id) as numeros_horarios from horario where 
                            hora_id = :p_hora and
                            fecha = :p_fecha and
                            capilla_id = :p_capilla ";
                    $sentencia = $this->dbLink->prepare($sql);
                    $sentencia->bindParam(":p_hora", $array[$j]);
                    $sentencia->bindParam(":p_fecha", $fecha);
                    $sentencia->bindParam(":p_capilla", $this->capilla_id);
                    $sentencia->execute();
                    $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
                    if($sentencia->rowCount()){
                        $cant = $resultado[$i]['numeros_horarios'];
                        if($cant > 0){
                            $bnd = 1;
                            break;
                        }
                    }

                }

                if ($bnd == 1){
                    return -1;
                }else{
                    if($sw == 1){
                        for ($i = 0; $i <= (int)$dias; $i++) {
                            $fecha = date("Y-m-d", strtotime($date1 . "+" . $i . " days"));
                            //echo date("d-m-Y",strtotime($datetime1."+ 1 days"));
                            $array = $this->hora_id;
                            for ($j = 0; $j < count($array); $j++) {
                                $sql = "INSERT INTO horario (hora_id,tipoculto_id,fecha,capilla_id) VALUES (
                                :p_hora, 
                                :p_tipo_culto, 
                                :p_fecha, 
                                :p_capilla);
                        ";
                                $sentencia = $this->dbLink->prepare($sql);
                                $sentencia->bindParam(":p_hora", $array[$j]);
                                $sentencia->bindParam(":p_tipo_culto", $this->tipoculto_id);
                                $sentencia->bindParam(":p_fecha", $fecha);
                                $sentencia->bindParam(":p_capilla", $this->capilla_id);
                                $sentencia->execute();
                            }
                        }
                    }
                    return 1;
                }



            }



        } catch (Exception $exc) {
            throw $exc;
        }
    }

    public function listar($fecha1, $fecha2)
    {
        try {
            $sql = "select h.id, hp.hora_hora, tp.tc_nombre , h.fecha, c.cap_nombre,
                  (case when h.estado = 'A' then 'Disponible' else 'No Disponible' end) as estado,
                   (case
                       when extract(dow from h.fecha) = 0 then 'Domingo'
                       when extract(dow from h.fecha) = 1 then 'Lunes'
                       when extract(dow from h.fecha) = 2 then 'Martes'
                       when extract(dow from h.fecha) = 3 then 'Miercoles'
                       when extract(dow from h.fecha) = 4 then 'Jueves'
                       when extract(dow from h.fecha) = 5 then 'Viernes'
                       else 'Sábado'
                      end) as dia_semana
                  from
                  horario h
                  inner join horario_patron hp on h.hora_id = hp.hora_id
                  left join tipo_culto tp on tp.tc_id = h.tipoculto_id
                  inner join capilla c on c.cap_id = h.capilla_id
                  where
                    (case when :p_hora = 0 then True else hp.hora_id = :p_hora end) and
                    (case when :p_tipoculto = 0 then True else tp.tc_id= :p_tipoculto end) and
                    (case when :p_capilla = 0 then True else c.cap_id = :p_capilla end) AND
                    (h.fecha BETWEEN :p_fecha1 and :p_fecha2) ;

                    ";
            $sentencia = $this->dbLink->prepare("$sql");
            $sentencia->bindParam(":p_hora", $this->hora_id);
            $sentencia->bindParam(":p_tipoculto", $this->tipoculto_id);
            $sentencia->bindParam(":p_capilla", $this->capilla_id);
            $sentencia->bindParam(":p_fecha2", $fecha2);
            $sentencia->bindParam(":p_fecha1", $fecha1);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }

    public function verificar()
    {
        try {
            $sql = "select h.id, det.horario_id, hp.hora_hora, tp.tc_nombre , h.fecha, c.cap_nombre,tp.tc_precio,tp.tc_tiempo_maximo as tiempo ,
                  (case when h.estado = 'A' then 'Disponible' else 'No Disponible' end) as estado,
                   (case
                       when extract(dow from h.fecha) = 0 then 'Domingo'
                       when extract(dow from h.fecha) = 1 then 'Lunes'
                       when extract(dow from h.fecha) = 2 then 'Martes'
                       when extract(dow from h.fecha) = 3 then 'Miercoles'
                       when extract(dow from h.fecha) = 4 then 'Jueves'
                       when extract(dow from h.fecha) = 5 then 'Viernes'
                       else 'Sábado'
                      end) as dia_semana, (case when tp.tc_tipo = 'I' then 'Individual' else 'Comunitario' end) as tipo                  from
                  horario h
                  inner join horario_patron hp on h.hora_id = hp.hora_id
                  left join tipo_culto tp on tp.tc_id = h.tipoculto_id
                  inner join capilla c on c.cap_id = h.capilla_id
                  left join detalle_intencion det on det.horario_id = h.id
                  where
                    h.capilla_id = :p_capilla and h.tipoculto_id = :p_tipoculto and h.estado = 'A' and
                    h.estado = 'A' and
                    (case when tp.tc_tipo = 'C' then true else (det.horario_id is null)  end )
                    group by  h.id, det.horario_id ,hp.hora_hora, tp.tc_nombre , h.fecha, c.cap_nombre,tp.tc_precio,tp.tc_tiempo_maximo ,
                    h.estado,h.fecha,tp.tc_tipo,tp.tc_tiempo_maximo 
                    ";
            $sentencia = $this->dbLink->prepare("$sql");
            $sentencia->bindParam(":p_tipoculto", $this->tipoculto_id);
            $sentencia->bindParam(":p_capilla", $this->capilla_id);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }


    public function get_data(){
        try {
            $sql = "select r.id, h.capilla_id, h.tipoculto_id, h.fecha, hp.hora_hora,
                    r.padre, r.cantor, r.cliente_dni, r.estado,h.id as horario_id,
                    (case when t.tc_tipo = 'I' then 'Individual' else 'Comunitario' end) as tipo,
                     di.dirigido, di.importe, r.ofrece, r.detail
                    from reserva r inner join detalle_intencion di on r.id = di.intencion_id
                    right join horario h on di.horario_id = h.id
                    inner join capilla c on h.capilla_id = c.cap_id
                    inner join horario_patron hp on h.hora_id = hp.hora_id
                    inner join tipo_culto t on h.tipoculto_id = t.tc_id
                    where h.capilla_id = :p_capilla and h.tipoculto_id = :p_tipoculto and h.id = :p_horario;
                    ";
            $sentencia = $this->dbLink->prepare("$sql");
            $sentencia->bindParam(":p_tipoculto", $this->tipoculto_id);
            $sentencia->bindParam(":p_capilla", $this->capilla_id);
            $sentencia->bindParam(":p_horario", $this->id);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }
    public function verificar_data()
    {
        try {
            $sql = "select h.id, det.horario_id, hp.hora_hora, tp.tc_nombre , h.fecha, c.cap_nombre,tp.tc_precio,tp.tc_tiempo_maximo as tiempo ,
                  (case when h.estado = 'A' then 'Disponible' else 'No Disponible' end) as estado,
                   (case
                       when extract(dow from h.fecha) = 0 then 'Domingo'
                       when extract(dow from h.fecha) = 1 then 'Lunes'
                       when extract(dow from h.fecha) = 2 then 'Martes'
                       when extract(dow from h.fecha) = 3 then 'Miercoles'
                       when extract(dow from h.fecha) = 4 then 'Jueves'
                       when extract(dow from h.fecha) = 5 then 'Viernes'
                       else 'Sábado'
                      end) as dia_semana, (case when tp.tc_tipo = 'I' then 'Individual' else 'Comunitario' end) as tipo                  from
                  horario h
                  inner join horario_patron hp on h.hora_id = hp.hora_id
                  left join tipo_culto tp on tp.tc_id = h.tipoculto_id
                  inner join capilla c on c.cap_id = h.capilla_id
                  left join detalle_intencion det on det.horario_id = h.id
                  where
                    h.capilla_id = :p_capilla and h.tipoculto_id = :p_tipoculto and h.estado = 'A' and
                    h.estado = 'A' and h.id = :p_horario and 
                    (case when tp.tc_tipo = 'C' then true else (det.horario_id is null)  end )
                    group by  h.id, det.horario_id ,hp.hora_hora, tp.tc_nombre , h.fecha, c.cap_nombre,tp.tc_precio,tp.tc_tiempo_maximo ,
                    h.estado,h.fecha,tp.tc_tipo,tp.tc_tiempo_maximo 
                    ";
            $sentencia = $this->dbLink->prepare("$sql");
            $sentencia->bindParam(":p_tipoculto", $this->tipoculto_id);
            $sentencia->bindParam(":p_capilla", $this->capilla_id);
            $sentencia->bindParam(":p_horario", $this->id);
            $sentencia->execute();
            $resultado = $sentencia->fetch(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }

    public function anular($array)
    {
        $this->dbLink->beginTransaction();
        try {
            for ($i = 0; $i < count($array); $i++) {
                $sql = "update horario set estado = 'I' where id = :p_id ";
                $sentencia = $this->dbLink->prepare("$sql");
                $sentencia->bindParam(":p_id", $array[$i]);
                $sentencia->execute();
            }
            $this->dbLink->commit();
            return true;

        } catch (Exception $exc) {
            //Abortamos la transaccion
            $this->dbLink->rollBack();
            //Lanzar el error hacia la siguiente capa (controlador)
            throw $exc;
        }

    }


    public function eliminar($array)
    {
        $this->dbLink->beginTransaction();
        try {
            for ($i = 0; $i < count($array); $i++) {
                $sql = "delete from horario where id = :p_id";
                $sentencia = $this->dbLink->prepare("$sql");
                $sentencia->bindParam(":p_id", $array[$i]);
                $sentencia->execute();
            }
            $this->dbLink->commit();
            return true;

        } catch (Exception $exc) {
            //Abortamos la transaccion
            $this->dbLink->rollBack();
            //Lanzar el error hacia la siguiente capa (controlador)
            throw $exc;
        }
    }

    public function calendar_list()
    {

        try {

//                $sql = "select h.id, tc.tc_descripcion, extract(year from h.fecha)::integer as anio,
//                        extract(month from h.fecha)::integer as mes, extract(day from h.fecha)::integer as dia,
//                        extract(hour from hp.hora_hora)::integer as hora_inicio, extract(minute from hp.hora_hora)::integer
//                         as minuto_inicio,
//                        extract(hour from (hp.hora_hora + INTERVAL '50' minute))::integer as hora_fin,
//                        extract(minute from (hp.hora_hora + INTERVAL '50' minute))::integer as minuto_fin,
//                        (case when di.id is null then 0 else 1 end)::integer as reserva
//                        from horario h inner join horario_patron hp on h.hora_id = hp.hora_id
//                        inner join tipo_culto tc on h.tipoculto_id = tc.tc_id
//                        left join detalle_intencion di on h.id = di.horario_id; ";
                $sql = "select h.id, tc.tc_descripcion,h.fecha||'T'|| hp.hora_hora as date_start,
                        h.fecha||'T'||(hp.hora_hora + INTERVAL '50' minute) as date_end,
                        (case when di.id is null then 0 else 1 end) as reserva
                        from horario h inner join horario_patron hp on h.hora_id = hp.hora_id
                        inner join tipo_culto tc on h.tipoculto_id = tc.tc_id
                        left join detalle_intencion di on h.id = di.horario_id;";
                $sentencia = $this->dbLink->prepare($sql);
                $sentencia->execute();
                $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);

                return $resultado;

        } catch (Exception $exc) {
            throw $exc;
        }

    }

    public function calendar_list_por_capilla($capilla_id)
    {

        try {
            $sql = "select h.id, tc.tc_descripcion,h.fecha||'T'|| hp.hora_hora as date_start,
                        h.fecha||'T'||(hp.hora_hora + INTERVAL '50' minute) as date_end,
                        (case when di.id is null then 0 else 1 end) as reserva
                        from horario h inner join horario_patron hp on h.hora_id = hp.hora_id
                        inner join tipo_culto tc on h.tipoculto_id = tc.tc_id
                        left join detalle_intencion di on h.id = di.horario_id
                        where h.capilla_id = :p_capilla_id;";
            $sentencia = $this->dbLink->prepare($sql);
            $sentencia->bindParam(":p_capilla_id", $capilla_id);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);

            return $resultado;

        } catch (Exception $exc) {
            throw $exc;
        }

    }




    public function update_padre_cantor()
    {
        $this->dbLink->beginTransaction();
        try {


            $sql = "update horario set padre_dni = :p_padre_dni , cantor_dni = :p_cantor_dni where id = :p_id ";
            $sentencia = $this->dbLink->prepare($sql);
            $sentencia->bindParam(":p_padre_dni", $this->padre_dni);
            $sentencia->bindParam(":p_cantor_dni", $this->cantor_dni);
            $sentencia->bindParam(":p_id", $this->id);
            $sentencia->execute();

            $this->dbLink->commit();
            return true;

        } catch (Exception $exc) {
            //Abortamos la transaccion
            $this->dbLink->rollBack();
            //Lanzar el error hacia la siguiente capa (controlador)
            throw $exc;
        }
    }



}