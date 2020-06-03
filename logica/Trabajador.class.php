<?php

require_once '../datos/Conexion.php';

class Trabajador extends Conexion
{

    private $tra_iddni;
    private $tra_apellido_paterno;
    private $tra_apellido_materno;
    private $tra_nombre;
    private $car_id;
    private $ocu_id;
    private $tra_direccion;
    private $tra_email;
    private $telefono;

    /**
     * @return mixed
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * @param mixed $telefono
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;
    }


    function getTra_iddni()
    {
        return $this->tra_iddni;
    }

    function getTra_apellido_paterno()
    {
        return $this->tra_apellido_paterno;
    }

    function getTra_apellido_materno()
    {
        return $this->tra_apellido_materno;
    }

    function getTra_nombre()
    {
        return $this->tra_nombre;
    }

    function getCar_id()
    {
        return $this->car_id;
    }

    function getOcu_id()
    {
        return $this->ocu_id;
    }

    function getTra_direccion()
    {
        return $this->tra_direccion;
    }

    function getTra_email()
    {
        return $this->tra_email;
    }

    function setTra_iddni($tra_iddni)
    {
        $this->tra_iddni = $tra_iddni;
    }

    function setTra_apellido_paterno($tra_apellido_paterno)
    {
        $this->tra_apellido_paterno = $tra_apellido_paterno;
    }

    function setTra_apellido_materno($tra_apellido_materno)
    {
        $this->tra_apellido_materno = $tra_apellido_materno;
    }

    function setTra_nombre($tra_nombre)
    {
        $this->tra_nombre = $tra_nombre;
    }

    function setCar_id($car_id)
    {
        $this->car_id = $car_id;
    }

    function setOcu_id($ocu_id)
    {
        $this->ocu_id = $ocu_id;
    }

    function setTra_direccion($tra_direccion)
    {
        $this->tra_direccion = $tra_direccion;
    }

    function setTra_email($tra_email)
    {
        $this->tra_email = $tra_email;
    }


    public function listar($cargo_id)
    {
        try {
            if($cargo_id=='6' or $cargo_id ==6){
                $sql = "
                    select
                    t.*,
                    c.car_nombre as cargo                    
                    from
                    persona t
                    inner join cargo c on ( c.car_id = t.car_id)   
                    where c.car_id = 1                                  
                    order by                    
                    t.per_nombre
                 ";
            }
            else{
                if($cargo_id=='1' or $cargo_id ==1){
                    $sql = "
                    select
                    t.*,
                    c.car_nombre as cargo                    
                    from
                    persona t
                    inner join cargo c on ( c.car_id = t.car_id)   
                    where c.car_id in (2,3,4)                                  
                    order by                    
                    t.per_nombre
                 ";
                }else{
                    if($cargo_id=='3' or $cargo_id ==3){
                        $sql = "
                    select
                    t.*,
                    c.car_nombre as cargo                    
                    from
                    persona t
                    inner join cargo c on ( c.car_id = t.car_id)   
                    where c.car_id = 5                                 
                    order by                    
                    t.per_nombre
                 ";
                    }
                }
            }

            $sentencia = $this->dbLink->prepare("$sql");
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }

    public function read($dni)
    {
        try {
            $sql = "
                    select
                    t.*,
                    c.car_nombre as cargo                    
                    from
                    persona t
                    inner join cargo c on ( c.car_id = t.car_id)
                    where t.per_iddni = :p_dni                                      
                    order by                    
                    t.per_nombre
                 ";
            $sentencia = $this->dbLink->prepare("$sql");
            $sentencia->bindParam(":p_dni", $dni);
            $sentencia->execute();
            $resultado = $sentencia->fetch(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }

    public function lista_clientes()
    {
        try {
            $sql = "
                select per_iddni,
                per_apellido_paterno ||' '|| per_apellido_materno ||' '|| per_nombre
                as cliente
                from persona WHERE car_id = 5;
                 ";
            $sentencia = $this->dbLink->prepare("$sql");
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }

    public function lista_padres($capilla)
    {
        try {
            $sql = "
                select p.per_iddni,
                p.per_apellido_paterno ||' '|| p.per_apellido_materno ||' '|| p.per_nombre
                as padre
                from persona p inner join asignacion_personal a on p.per_iddni = a.per_iddni
                WHERE p.car_id = 1 and a.cap_id = :p_capilla ;
                 ";
            $sentencia = $this->dbLink->prepare($sql);
            $sentencia->bindParam(":p_capilla", $capilla);
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
        try {
            /*INSERTAR EN LA TABLA TIPO_CULTO*/
            $sql = "
                    INSERT INTO persona
                                (
                                 per_iddni, 
                                 per_apellido_paterno,
                                 per_apellido_materno,
                                 per_nombre,
                                 per_direccion,
                                 per_email,
                                 car_id, 
                                 per_telefono,
                                 ocu_id
                                )

                        VALUES  (
                                :p_tra_iddni, 
                                :p_tra_apellido_paterno, 
                                :p_tra_apellido_materno, 
                                :p_tra_nombre,
                                :p_tra_direccion,
                                :p_tra_email,
                                :p_car_id,
                                :p_telefono,
                                :p_ocu_id
                                );
                        ";
            $sentencia = $this->dbLink->prepare($sql);
            $sentencia->bindParam(":p_tra_iddni", $this->tra_iddni);
            $sentencia->bindParam(":p_tra_apellido_paterno", $this->tra_apellido_paterno);
            $sentencia->bindParam(":p_tra_apellido_materno", $this->tra_apellido_materno);
            $sentencia->bindParam(":p_tra_nombre", $this->tra_nombre);
            $sentencia->bindParam(":p_tra_direccion", $this->tra_direccion);
            $sentencia->bindParam(":p_tra_email", $this->tra_email);
            $sentencia->bindParam(":p_car_id", $this->car_id);
            $sentencia->bindParam(":p_telefono", $this->telefono);
            $sentencia->bindParam(":p_ocu_id", $this->ocu_id);
            $sentencia->execute();

            /*ACTUALIZAR EL CORRELATIVO PARA LA TABLA TIPO_CULTO  EN + 1*/
            /*$sql = "update correlativo set numero = numero + 1 where tabla = 'tipo_culto'";*/
            /*$sentencia= $this->dbLink->prepare($sql); */
            //$sentencia->execute();

            //CONFIRMAR LA TRANSACCION
            return true;

            //    return TRUE; //RETORNA VERDARERO CUANDO HA REGISTRADO TODO CORRECTAMENTE
            //  }else{
            //    //no se encontro el correlativo para la tabla parroquia
            //  throw new Exception("No se encontró el correlativo para la tabla Tipo_Culto");
            // }
        } catch (Exception $exc) {
            throw $exc;
        }
    }

    public function lista_cantores($capilla)
    {
        try {
            $sql = "
                select p.per_iddni,
                p.per_apellido_paterno ||' '|| p.per_apellido_materno ||' '|| p.per_nombre
                as cantor
                from persona p inner join asignacion_personal a on p.per_iddni = a.per_iddni
                WHERE p.car_id = 4 and a.cap_id = :p_capilla ;
                 ";
            $sentencia = $this->dbLink->prepare($sql);
            $sentencia->bindParam(":p_capilla", $capilla);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }

    public function lista_employees($rol_id,$parroquia_id,$dni)
    {
        try {
            if($rol_id==2 or $rol_id=='2'){
                $sql= "
                        select
                            p.per_iddni, p.per_apellido_paterno, p.per_apellido_materno, p.per_nombre
                            from persona p inner join asignacion_personal ap on p.per_iddni = ap.per_iddni
                            inner join capilla c on ap.cap_id = c.cap_id
                            where p.per_iddni = :p_dni              
                        ";
                $sentencia = $this->dbLink->prepare($sql);
                $sentencia->bindParam(":p_dni", $dni);
                $sentencia->execute();
                $resultado = $sentencia->fetch(PDO::FETCH_ASSOC);
                return $resultado;
            }else{
                if($rol_id== 3 or $rol_id == '3'){
                    $sql = "
                select * from persona where car_id not in (5,6)";
                    $sentencia = $this->dbLink->prepare($sql);
                    $sentencia->execute();
                    $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
                    return $resultado;
                }else{
                    if($rol_id== 4 or $rol_id == '4'){
                        $sql= "
                        select u.per_iddni, u.usu_id, u.usu_clave, u.fecha_inicio, u.fecha_fin, u.usu_estado,
                         u.rol_id, r.nombre,p.per_apellido_paterno, p.per_apellido_materno, p.per_nombre 
                         from usuario u inner join rol r on u.rol_id = r.id   
                         inner join persona p on u.per_iddni = p.per_iddni
                         where u.per_iddni = :p_dni                                   
                        ";
                        $sentencia = $this->dbLink->prepare($sql);
                        $sentencia->bindParam(":p_dni", $dni);
                        $sentencia->execute();
                        $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
                        return $resultado;
                    }else{
                        $sql= "
                        select
                            p.per_iddni, p.per_apellido_paterno, p.per_apellido_materno, p.per_nombre
                            from persona p inner join asignacion_personal ap on p.per_iddni = ap.per_iddni
                            inner join capilla c on ap.cap_id = c.cap_id
                            where c.par_id = :p_parroquia_id              
                        ";
                        $sentencia = $this->dbLink->prepare($sql);
                        $sentencia->bindParam(":p_parroquia_id", $parroquia_id);
                        $sentencia->execute();
                        $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
                        return $resultado;
                    }


                }
            }


        } catch (Exception $exc) {
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


    public function editar($dni)
    {
        $this->dbLink->beginTransaction();

        try {
            $sql = "
                UPDATE 
                        persona
                SET	
                        per_apellido_paterno		= :p_paterno, 
                        per_apellido_materno 		= :p_materno, 
                        per_nombre  		= :p_nombre,
                        per_direccion 		= :p_direccion,
                        per_email  		= :p_email,
                        per_telefono  		= :p_telefono,
                        car_id  		= :p_cargo,
                        ocu_id  		= :p_ocupacion

                 WHERE 
                        per_iddni                   = :p_dni

                 ";
            $sentencia = $this->dbLink->prepare($sql);

            $sentencia->bindParam(":p_paterno", $this->tra_apellido_paterno);
            $sentencia->bindParam(":p_materno", $this->tra_apellido_materno);
            $sentencia->bindParam(":p_nombre", $this->tra_nombre);
            $sentencia->bindParam(":p_direccion", $this->tra_direccion);
            $sentencia->bindParam(":p_email", $this->tra_email);
            $sentencia->bindParam(":p_telefono", $this->telefono);
            $sentencia->bindParam(":p_cargo", $this->car_id);
            $sentencia->bindParam(":p_ocupacion", $this->ocu_id);
            $sentencia->bindParam(":p_dni", $dni);
            $sentencia->execute();

            $this->dbLink->commit();

            return TRUE;

        } catch (Exception $exc) {
            $this->dbLink->rollBack();
            throw $exc;
        }
    }

    public function clientes_reserva_pagada()
    {
        try {
            $sql = "
                  select i.cliente_dni,(p.per_apellido_paterno ||' '|| p.per_apellido_materno||' '|| p.per_nombre) as cliente,
                  ce.cel_nombre as celebracion, hp.hora_hora, h.fecha, p.per_telefono as telefono,i.estado,i.total,
                  ca.cap_nombre as capilla
                from reserva i INNER JOIN detalle_intencion d on d.intencion_id = i.id
                  inner join persona p on i.cliente_dni = p.per_iddni
                  left join horario h on h.id = d.horario_id
                  inner join tipo_culto tc on tc.tc_id = h.tipoculto_id
                  inner join horario_patron hp on hp.hora_id = h.hora_id
                  inner join culto c on tc.cul_id = c.cul_id
                  inner join celebracion ce on c.cel_id = ce.cel_id
                  inner join capilla ca on ca.cap_id = i.capilla_id
                  where i.estado in  ('Pagado','Pendiente') and (h.fecha >= current_date );

                   ";

            $sentencia = $this->dbLink->prepare($sql);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;

        } catch (Exception $exc) {
            throw $exc;
        }
    }
}
