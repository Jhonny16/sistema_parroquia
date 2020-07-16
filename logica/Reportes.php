<?php
/**
 * Created by PhpStorm.
 * User: jhonny
 * Date: 29/06/20
 * Time: 05:17 PM
 */

require_once '../datos/Conexion.php';


class Reportes  extends Conexion
{


    public function types_cult_list($capilla_id) {
        try {
            $sql="
                select dc.det_id, dc.det_nombre
                from lista_precio lp inner join tipo_culto tc on lp.tipo_culto_id = tc.tc_id
                inner join det_culto dc on tc.tc_id = dc.tc_id
                where tc.tc_tipo = 'C' and  lp.capilla_id  = :p_capilla_id 
                group by dc.det_id, dc.det_nombre";
            $sentencia = $this->dbLink->prepare("$sql");
            $sentencia->bindParam(":p_capilla_id", $capilla_id);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }

    }

    public function typescult_super_list($capilla_id) {
        try {
            $sql="
            select tc.tc_id, tc.tc_nombre
            from lista_precio lp inner join tipo_culto tc on lp.tipo_culto_id = tc.tc_id
            where tc.tc_tipo = 'I'
              and  lp.capilla_id  = :p_capilla_id
            group by  tc.tc_id, tc.tc_nombre";
            $sentencia = $this->dbLink->prepare("$sql");
            $sentencia->bindParam(":p_capilla_id", $capilla_id);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }

    }


      public function find_misa($f_inicial,$f_final,$h_inicial,$h_final,$capilla_id, $tipo_culto, $tipoculto_id) {
            try {
                $sql="
                  select
                        h.id, h.fecha, hp.hora_hora,
                        dr.dirigido,
                        dr.tipoculto_detalle,
                        p.code as pago, r.code as reserva,
                        p.estado as pago_estado, r.estado as estado,
                        dr.importe,
                        c2.cap_nombre
                    from horario h right join reserva r on h.id = r.horario_id
                                   inner join detalle_reserva dr on r.id = dr.reserva_id
                                   left join horario_patron hp on h.hora_id = hp.hora_id
                                   inner join tipo_culto tc on h.tipoculto_id = tc.tc_id
                                   inner join det_culto dc on dr.tipoculto_detalle = dc.det_nombre
                                   inner join pago p on r.id = p.reserva_id
                                   inner join capilla c2 on h.capilla_id = c2.cap_id
                    
                    where
                      (h.fecha between :p_fecha_inicial and :p_fecha_final)
                      and (hp.hora_hora between :p_hora_inicial and :p_hora_final )
                      and h.capilla_id = :p_capilla_id
                      and (case when :p_tipoculto_id = 0 then true else dc.det_id = :p_tipoculto_id end)
                      and tc.tc_tipo = :p_tipo_culto
                      and r.estado != 'Anulado'
                    group by   h.id, h.fecha, hp.hora_hora,
                    dr.dirigido,
                    dr.tipoculto_detalle,
                    p.code , r.code ,
                    p.estado , r.estado, dr.importe,  c2.cap_nombre";
                $sentencia = $this->dbLink->prepare("$sql");
                $sentencia->bindParam(":p_fecha_inicial", $f_inicial);
                $sentencia->bindParam(":p_fecha_final", $f_final);
                $sentencia->bindParam(":p_hora_inicial", $h_inicial);
                $sentencia->bindParam(":p_hora_final", $h_final);
                $sentencia->bindParam(":p_capilla_id", $capilla_id);
                $sentencia->bindParam(":p_tipoculto_id", $tipoculto_id);
                $sentencia->bindParam(":p_tipo_culto", $tipo_culto);

                $sentencia->execute();
                $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
                return $resultado;
            } catch (Exception $exc) {
                throw $exc;
            }

        }
         public function find_misa_utilidades($f_inicial,$f_final,$capilla_id, $tipo_culto, $tipoculto_id,$secretario_id,$estado) {
                    try {
                        $sql="
                          select
                            p.fecha, hp.hora_hora, dr.dirigido, dr.tipoculto_detalle, r.code as code_reserva,
                            p.code as code_pago, r.estado, dr.importe
                            --*, p.code as pago, r.code as reserva, p.estado as pago_estado, r.estado as estado
                            from horario h right join reserva r on h.id = r.horario_id
                                           inner join detalle_reserva dr on r.id = dr.reserva_id
                                           left join horario_patron hp on h.hora_id = hp.hora_id
                                           inner join tipo_culto tc on h.tipoculto_id = tc.tc_id
                                           inner join det_culto dc on dr.tipoculto_detalle = dc.det_nombre
                                           inner join pago p on r.id = p.reserva_id
                                           inner join capilla c2 on h.capilla_id = c2.cap_id
                            
                            
                            where
                              (p.fecha between :p_fecha_inicial and :p_fecha_final)
                              and h.capilla_id = :p_capilla_id
                              and (case when :p_tipoculto_id = 0 then true else dc.det_id = :p_tipoculto_id end)
                              and tc.tc_tipo = :p_tipo_culto
                              and (case when :p_user_id = 0 then true else r.user_id = :p_user_id  end)
                              and (case when :p_estado = '0' then true else r.estado = :p_estado end) 
                            group by
                                p.fecha, hp.hora_hora, dr.dirigido, dr.tipoculto_detalle, r.code,
                                p.code, r.estado, dr.importe";
                        $sentencia = $this->dbLink->prepare("$sql");
                        $sentencia->bindParam(":p_fecha_inicial", $f_inicial);
                        $sentencia->bindParam(":p_fecha_final", $f_final);
                        $sentencia->bindParam(":p_capilla_id", $capilla_id);
                        $sentencia->bindParam(":p_tipoculto_id", $tipoculto_id);
                        $sentencia->bindParam(":p_tipo_culto", $tipo_culto);
                        $sentencia->bindParam(":p_user_id", $secretario_id);
                        $sentencia->bindParam(":p_estado", $estado);

                        $sentencia->execute();
                        $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
                        return $resultado;
                    } catch (Exception $exc) {
                        throw $exc;
                    }

                }

    public function find_misa_invidual($f_inicial,$f_final,$capilla_id, $tipoculto_id,$tipo_culto, $dni,$estado) {
        try {
            $sql="
                 select
                    pa.fecha,
                    r.code as reserva_code,
                    p.per_apellido_paterno || ' '|| p.per_apellido_materno || ' '|| p.per_nombre as cliente,
                    pa.code as pago_code,
                    tc.tc_nombre,
                    r.total,
                    r.estado
                    from horario h right join reserva r on h.id = r.horario_id
                    left join horario_patron hp on h.hora_id = hp.hora_id
                    inner join persona p on r.cliente_dni = p.per_iddni
                    left outer join detalle_reserva dr on r.id = dr.reserva_id
                    inner join tipo_culto tc on h.tipoculto_id = tc.tc_id
                    inner join det_culto dc on dr.tipoculto_detalle = dc.det_nombre
                    inner join pago pa on r.id = pa.reserva_id
                    inner join capilla c2 on h.capilla_id = c2.cap_id
                    where
                    (pa.fecha between :p_fecha_inicial and :p_fecha_final)
                    and h.capilla_id = :p_capilla_id
                    and (case when :p_tipo_id = 0 then true else tc.tc_id= :p_tipo_id end)
                    and tc.tc_tipo = :p_tipo_culto
                    and (case when :p_dni = '0' then true else p.per_iddni = :p_dni  end)
                    and (case when :p_estado = '0' then true else r.estado = :p_estado end)
                   group by
                    pa.fecha,
                    r.code ,
                    p.per_apellido_paterno , p.per_apellido_materno, p.per_nombre ,
                    pa.code ,
                    tc.tc_nombre,
                    r.total,
                    r.estado;";
            $sentencia = $this->dbLink->prepare("$sql");
            $sentencia->bindParam(":p_fecha_inicial", $f_inicial);
            $sentencia->bindParam(":p_fecha_final", $f_final);
            $sentencia->bindParam(":p_capilla_id", $capilla_id);
            $sentencia->bindParam(":p_tipo_id", $tipoculto_id);
            $sentencia->bindParam(":p_tipo_culto", $tipo_culto);
            $sentencia->bindParam(":p_dni", $dni);
            $sentencia->bindParam(":p_estado", $estado);

            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }

    }

    public function ingresos_por_tipoculto($capilla_id, $anio){
        try {
            $sql="
              select
tc.tc_nombre,
SUM(case when extract(month from h.fecha) = 1 then
(select templo + limosna  from lista_precio where capilla_id =  h.capilla_id and tipo_culto_id = h.tipoculto_id
and (h.fecha between fecha_inicio and fecha_fin) order by 1 desc limit 1)
else 0 end) as enero,
SUM(case when extract(month from h.fecha) = 2 then
(select templo + limosna  from lista_precio where capilla_id =  h.capilla_id and tipo_culto_id = h.tipoculto_id
and (h.fecha between fecha_inicio and fecha_fin) order by 1 desc limit 1)
else 0 end) as febrero,
SUM(case when extract(month from h.fecha) = 3 then
(select templo + limosna  from lista_precio where capilla_id =  h.capilla_id and tipo_culto_id = h.tipoculto_id
and (h.fecha between fecha_inicio and fecha_fin) order by 1 desc limit 1)
else 0 end) as marzo,
SUM(case when extract(month from h.fecha) = 4 then
(select templo + limosna  from lista_precio where capilla_id =  h.capilla_id and tipo_culto_id = h.tipoculto_id
and (h.fecha between fecha_inicio and fecha_fin) order by 1 desc limit 1)
else 0 end) as abril,
SUM(case when extract(month from h.fecha) = 5 then
(select templo + limosna  from lista_precio where capilla_id =  h.capilla_id and tipo_culto_id = h.tipoculto_id
and (h.fecha between fecha_inicio and fecha_fin) order by 1 desc limit 1)
else 0 end) as mayo,
SUM(case when extract(month from h.fecha) = 6 then
(select templo + limosna  from lista_precio where capilla_id =  h.capilla_id and tipo_culto_id = h.tipoculto_id
and (h.fecha between fecha_inicio and fecha_fin) order by 1 desc limit 1)
else 0 end) as junio,
SUM(case when extract(month from h.fecha) = 7 then
(select templo + limosna  from lista_precio where capilla_id =  h.capilla_id and tipo_culto_id = h.tipoculto_id
and (h.fecha between fecha_inicio and fecha_fin) order by 1 desc limit 1)
else 0 end) as julio,
SUM(case when extract(month from h.fecha) = 8 then
(select templo + limosna  from lista_precio where capilla_id =  h.capilla_id and tipo_culto_id = h.tipoculto_id
and (h.fecha between fecha_inicio and fecha_fin) order by 1 desc limit 1)
else 0 end) as agosto,
SUM(case when extract(month from h.fecha) = 9 then
(select templo + limosna  from lista_precio where capilla_id =  h.capilla_id and tipo_culto_id = h.tipoculto_id
and (h.fecha between fecha_inicio and fecha_fin) order by 1 desc limit 1)
else 0 end) as setiembre,
SUM(case when extract(month from h.fecha) = 10 then
(select templo + limosna  from lista_precio where capilla_id =  h.capilla_id and tipo_culto_id = h.tipoculto_id
and (h.fecha between fecha_inicio and fecha_fin) order by 1 desc limit 1)
else 0 end) as octubre,
SUM(case when extract(month from h.fecha) = 11 then
(select templo + limosna  from lista_precio where capilla_id =  h.capilla_id and tipo_culto_id = h.tipoculto_id
and (h.fecha between fecha_inicio and fecha_fin) order by 1 desc limit 1)
else 0 end) as noviembre,
SUM(case when extract(month from h.fecha) = 12 then
(select templo + limosna  from lista_precio where capilla_id =  h.capilla_id and tipo_culto_id = h.tipoculto_id
and (h.fecha between fecha_inicio and fecha_fin) order by 1 desc limit 1)
else 0 end) as diciembre

        
        from horario h inner join reserva r on h.id = r.horario_id
        right join tipo_culto tc on h.tipoculto_id = tc.tc_id
        where extract(year from h.fecha) = :p_anio and r.estado = 'Pagado' and h.capilla_id = :p_capilla_id
        group by tc.tc_nombre" ;
            $sentencia = $this->dbLink->prepare("$sql");
            $sentencia->bindParam(":p_capilla_id", $capilla_id);
            $sentencia->bindParam(":p_anio", $anio);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }

    }

    public function egresos_por_cantor($capilla_id, $anio){
        try {
            $sql="
               select
                p.per_apellido_paterno|| ' '|| p.per_apellido_materno || ' '|| p.per_nombre as cantor,
                SUM(case when extract(month from h.fecha) = 1 then
                          (select SUM(cantor) from lista_precio where capilla_id =  h.capilla_id and tipo_culto_id = h.tipoculto_id
                                                                  and (h.fecha between fecha_inicio and fecha_fin) order by 1 desc limit 1)
                      else 0 end) as enero ,
                SUM(case when extract(month from h.fecha) = 2 then
                          (select SUM(cantor) from lista_precio where capilla_id =  h.capilla_id and tipo_culto_id = h.tipoculto_id
                                                                  and (h.fecha between fecha_inicio and fecha_fin) order by 1 desc limit 1)
                      else 0 end) as febrero,
                SUM(case when extract(month from h.fecha) = 3 then
                          (select SUM(cantor) from lista_precio where capilla_id =  h.capilla_id and tipo_culto_id = h.tipoculto_id
                                                                  and (h.fecha between fecha_inicio and fecha_fin) order by 1 desc limit 1)
                      else 0 end) as marzo ,
                SUM(case when extract(month from h.fecha) = 4 then
                          (select SUM(cantor) from lista_precio where capilla_id =  h.capilla_id and tipo_culto_id = h.tipoculto_id
                                                                  and (h.fecha between fecha_inicio and fecha_fin) order by 1 desc limit 1)
                      else 0 end) as abril,
                
                SUM(case when extract(month from h.fecha) = 5 then
                          (select SUM(cantor) from lista_precio where capilla_id =  h.capilla_id and tipo_culto_id = h.tipoculto_id
                                                                  and (h.fecha between fecha_inicio and fecha_fin) order by 1 desc limit 1)
                      else 0 end) as mayo,
                SUM(case when extract(month from h.fecha) = 6 then
                (select SUM(cantor) from lista_precio where capilla_id =  h.capilla_id and tipo_culto_id = h.tipoculto_id
                                      and (h.fecha between fecha_inicio and fecha_fin) order by 1 desc limit 1)
                else 0 end) as junio ,
                SUM(case when extract(month from h.fecha) = 7 then
                (select SUM(cantor) from lista_precio where capilla_id =  h.capilla_id and tipo_culto_id = h.tipoculto_id
                                      and (h.fecha between fecha_inicio and fecha_fin) order by 1 desc limit 1)
                else 0 end) as julio,
                SUM(case when extract(month from h.fecha) = 8 then
                          (select SUM(cantor) from lista_precio where capilla_id =  h.capilla_id and tipo_culto_id = h.tipoculto_id
                                                                  and (h.fecha between fecha_inicio and fecha_fin) order by 1 desc limit 1)
                      else 0 end) as agosto ,
                SUM(case when extract(month from h.fecha) = 9 then
                          (select SUM(cantor) from lista_precio where capilla_id =  h.capilla_id and tipo_culto_id = h.tipoculto_id
                                                                  and (h.fecha between fecha_inicio and fecha_fin) order by 1 desc limit 1)
                      else 0 end) as setiembre,
                SUM(case when extract(month from h.fecha) = 10 then
                          (select SUM(cantor) from lista_precio where capilla_id =  h.capilla_id and tipo_culto_id = h.tipoculto_id
                                                                  and (h.fecha between fecha_inicio and fecha_fin) order by 1 desc limit 1)
                      else 0 end) as octubre ,
                SUM(case when extract(month from h.fecha) = 11 then
                          (select SUM(cantor) from lista_precio where capilla_id =  h.capilla_id and tipo_culto_id = h.tipoculto_id
                                                                  and (h.fecha between fecha_inicio and fecha_fin) order by 1 desc limit 1)
                      else 0 end) as noviembre,
                SUM(case when extract(month from h.fecha) = 12 then
                          (select SUM(cantor) from lista_precio where capilla_id =  h.capilla_id and tipo_culto_id = h.tipoculto_id
                                                                  and (h.fecha between fecha_inicio and fecha_fin) order by 1 desc limit 1)
                      else 0 end) as diciembre
                
                from horario h inner join reserva r on h.id = r.horario_id
                            inner join persona p on h.cantor_dni = p.per_iddni
                where extract(year from h.fecha) = :p_anio and r.estado = 'Pagado' and h.capilla_id = :p_capilla_id
                group by
                p.per_apellido_paterno,p.per_apellido_materno, p.per_nombre;" ;
            $sentencia = $this->dbLink->prepare("$sql");
            $sentencia->bindParam(":p_capilla_id", $capilla_id);
            $sentencia->bindParam(":p_anio", $anio);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }

    }

    public function pago_por_padre($capilla_id, $anio){
        try {
            $sql="
                select
                p.per_apellido_paterno|| ' '|| p.per_apellido_materno || ' '|| p.per_nombre as padre,
                
                    SUM(case when extract(month from h.fecha) = 1 then
                (select SUM(limosna) from lista_precio where capilla_id =  h.capilla_id and tipo_culto_id = h.tipoculto_id
                and (h.fecha between fecha_inicio and fecha_fin) order by 1 desc limit 1)
                else 0 end) as enero ,
                       SUM(case when extract(month from h.fecha) = 2 then
                (select SUM(limosna) from lista_precio where capilla_id =  h.capilla_id and tipo_culto_id = h.tipoculto_id
                and (h.fecha between fecha_inicio and fecha_fin) order by 1 desc limit 1)
                else 0 end) as febrero ,
                       SUM(case when extract(month from h.fecha) = 3 then
                (select SUM(limosna) from lista_precio where capilla_id =  h.capilla_id and tipo_culto_id = h.tipoculto_id
                and (h.fecha between fecha_inicio and fecha_fin) order by 1 desc limit 1)
                else 0 end) as marzo ,
                       SUM(case when extract(month from h.fecha) = 4 then
                (select SUM(limosna) from lista_precio where capilla_id =  h.capilla_id and tipo_culto_id = h.tipoculto_id
                and (h.fecha between fecha_inicio and fecha_fin) order by 1 desc limit 1)
                else 0 end) as abril ,
                       SUM(case when extract(month from h.fecha) = 5 then
                (select SUM(limosna) from lista_precio where capilla_id =  h.capilla_id and tipo_culto_id = h.tipoculto_id
                and (h.fecha between fecha_inicio and fecha_fin) order by 1 desc limit 1)
                else 0 end) as mayo ,
                       SUM(case when extract(month from h.fecha) = 6 then
                (select SUM(limosna) from lista_precio where capilla_id =  h.capilla_id and tipo_culto_id = h.tipoculto_id
                and (h.fecha between fecha_inicio and fecha_fin) order by 1 desc limit 1)
                else 0 end) as junio ,
                SUM(case when extract(month from h.fecha) = 7 then
                (select SUM(limosna) from lista_precio where capilla_id =  h.capilla_id and tipo_culto_id = h.tipoculto_id
                and (h.fecha between fecha_inicio and fecha_fin) order by 1 desc limit 1)
                else 0 end) as julio,
                SUM(case when extract(month from h.fecha) = 8 then
                             (select SUM(limosna) from lista_precio where capilla_id =  h.capilla_id and tipo_culto_id = h.tipoculto_id
                                                                      and (h.fecha between fecha_inicio and fecha_fin) order by 1 desc limit 1)
                         else 0 end) as agosto ,
                SUM(case when extract(month from h.fecha) = 9 then
                             (select SUM(limosna) from lista_precio where capilla_id =  h.capilla_id and tipo_culto_id = h.tipoculto_id
                                                                      and (h.fecha between fecha_inicio and fecha_fin) order by 1 desc limit 1)
                         else 0 end) as setiembre ,
                SUM(case when extract(month from h.fecha) = 10 then
                             (select SUM(limosna) from lista_precio where capilla_id =  h.capilla_id and tipo_culto_id = h.tipoculto_id
                                                                      and (h.fecha between fecha_inicio and fecha_fin) order by 1 desc limit 1)
                         else 0 end) as octubre ,
                SUM(case when extract(month from h.fecha) = 11 then
                             (select SUM(limosna) from lista_precio where capilla_id =  h.capilla_id and tipo_culto_id = h.tipoculto_id
                                                                      and (h.fecha between fecha_inicio and fecha_fin) order by 1 desc limit 1)
                         else 0 end) as noviembre ,
                SUM(case when extract(month from h.fecha) = 12 then
                             (select SUM(limosna) from lista_precio where capilla_id =  h.capilla_id and tipo_culto_id = h.tipoculto_id
                                                                      and (h.fecha between fecha_inicio and fecha_fin) order by 1 desc limit 1)
                         else 0 end) as diciembre
                from horario h inner join reserva r on h.id = r.horario_id
                               inner join persona p on h.padre_dni = p.per_iddni
                where extract(year from h.fecha) = :p_anio and r.estado = 'Pagado' and h.capilla_id = :p_capilla_id
                group by
                    p.per_apellido_paterno,p.per_apellido_materno, p.per_nombre" ;
            $sentencia = $this->dbLink->prepare($sql);
            $sentencia->bindParam(":p_capilla_id", $capilla_id);
            $sentencia->bindParam(":p_anio", $anio);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }

    }


    public function misas_por_padre($capilla_id, $anio){
        try {
            $sql="
            select
            p.per_apellido_paterno|| ' '|| p.per_apellido_materno || ' '|| p.per_nombre as padre,
            SUM(case when extract(month from h.fecha) = 1 then 1 else 0 end) as enero,
            SUM(case when extract(month from h.fecha) = 2 then 1 else 0 end) as febrero,
            SUM(case when extract(month from h.fecha) = 3 then 1 else 0 end) as marzo,
            SUM(case when extract(month from h.fecha) = 4 then 1 else 0 end) as abril,
            SUM(case when extract(month from h.fecha) = 5 then 1 else 0 end) as mayo,
            SUM(case when extract(month from h.fecha) = 6 then 1 else 0 end) as junio,
            SUM(case when extract(month from h.fecha) = 7 then 1 else 0 end) as julio,
            SUM(case when extract(month from h.fecha) = 8 then 1 else 0 end) as agosto,
            SUM(case when extract(month from h.fecha) = 9 then 1 else 0 end) as setiembre,
            SUM(case when extract(month from h.fecha) = 10 then 1 else 0 end) as octubre,
            SUM(case when extract(month from h.fecha) = 11 then 1 else 0 end) as noviembre,
            SUM(case when extract(month from h.fecha) = 12 then 1 else 0 end) as diciembre
            from horario h inner join reserva r on h.id = r.horario_id
            inner join persona p on h.padre_dni = p.per_iddni
            where r.estado = 'Pagado' and extract(year from h.fecha) = :p_anio  and h.capilla_id = :p_capilla_id
            group by
            p.per_apellido_paterno,p.per_apellido_materno,p.per_nombre;" ;
            $sentencia = $this->dbLink->prepare($sql);
            $sentencia->bindParam(":p_capilla_id", $capilla_id);
            $sentencia->bindParam(":p_anio", $anio);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }

    }

    public function misas_por_hora($horario_id){
        try {
            $sql="
                select
                c.cap_id as capilla_id,
                c.cap_nombre as capilla_nombre,
                r.id,
                r.code,
                r.fecha as fecha_reserva,
                h.fecha as horario_fecha,
                hp.hora_hora as horario_hora,
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
            --where h.id = 476
            where h.id = :p_horario_id and r.estado != 'Anulado' " ;
            $sentencia = $this->dbLink->prepare($sql);
            $sentencia->bindParam(":p_horario_id", $horario_id);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }

    }


    public function misas_por_dia($fecha){
        try {
            $sql="
                select
                c.cap_id as capilla_id,
                c.cap_nombre as capilla_nombre,
                r.id,
                r.code,
                r.fecha as fecha_reserva,
                h.fecha as horario_fecha,
                hp.hora_hora as horario_hora,
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
           where h.fecha = :p_fecha and r.estado != 'Anulado'" ;
            $sentencia = $this->dbLink->prepare($sql);
            $sentencia->bindParam(":p_fecha", $fecha);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }

    }


}