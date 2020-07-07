<?php

/**
 * Created by PhpStorm.
 * User: tito_
 * Date: 15/12/2018
 * Time: 11:29 A
 */

require_once '../datos/Conexion.php';
class Capilla extends Conexion
{
    private $id;
    private $nombre;
    private $direccion;
    private $estado;
    private $tipo;
    private $parroquia_id;
    private $parroquia;

    /**
     * @return mixed
     */
    public function getParroquia()
    {
        return $this->parroquia;
    }

    /**
     * @param mixed $parroquia
     */
    public function setParroquia($parroquia)
    {
        $this->parroquia = $parroquia;
    }



    /**
     * @return mixed
     */
    public function getParroquiaId()
    {
        return $this->parroquia_id;
    }

    /**
     * @param mixed $parroquia_id
     */
    public function setParroquiaId($parroquia_id)
    {
        $this->parroquia_id = $parroquia_id;
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
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * @param mixed $direccion
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;
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
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * @param mixed $tipo
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    }

    public function lista() {
        try {
            $sql="select
                c.*, p.par_nombre
                from capilla c inner join parroquia p on c.par_id = p.par_id                
               ";
            $sentencia = $this->dbLink->prepare("$sql");
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }
    public function listar_por_dni($dni) {
        try {
            $sql="select c.cap_id,c.cap_nombre, c.cap_direccion, ap.per_iddni
                    from capilla c inner join asignacion_personal ap on c.cap_id = ap.cap_id
                    inner join persona p on ap.per_iddni = p.per_iddni
                    where p.per_iddni = :p_dni
                    and c.cap_estado = true
               ";
            $sentencia = $this->dbLink->prepare("$sql");
            $sentencia->bindParam(":p_dni", $dni);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }
    public function listar_por_parroquia($paroquia,$rol) {

        try {
            if($rol == 3 or $rol == '3'){
                $sql="select c.cap_id,c.cap_nombre, c.cap_direccion, c.parroquia as is_parroquia
                    from capilla c  inner join parroquia p on c.par_id = p.par_id
                    where c.cap_estado = true
               ";
                $sentencia = $this->dbLink->prepare("$sql");
                $sentencia->execute();
                $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            }else{
                $sql="select c.cap_id,c.cap_nombre, c.cap_direccion, c.parroquia as is_parroquia
                    from capilla c  inner join parroquia p on c.par_id = p.par_id
                    where p.par_id = :p_parroquia_id
                    and c.cap_estado = true
               ";
                $sentencia = $this->dbLink->prepare("$sql");
                $sentencia->bindParam(":p_parroquia_id", $paroquia);
                $sentencia->execute();
                $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            }

            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }

    public function listar_group_parroquia($dni) {
        try {
            $sql="select
                cap.*
                from
                capilla cap left join parroquia p on cap.par_id = p.par_id
                inner join capilla c on p.par_id = c.par_id inner join asignacion_personal ap on c.cap_id = ap.cap_id
                where ap.per_iddni= :p_dni
        and cap.cap_estado = true;
               ";
            $sentencia = $this->dbLink->prepare("$sql");
            $sentencia->bindParam(":p_dni", $dni);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }

    public function read($id)
    {
        try {
            $sql = "select
                c.*, p.par_nombre
                from capilla c inner join parroquia p on c.par_id = p.par_id
                where c.cap_id = :p_id
               ";
            $sentencia = $this->dbLink->prepare("$sql");
            $sentencia->bindParam(":p_id", $id);

            $sentencia->execute();
            $resultado = $sentencia->fetch(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }

    public function agregar () {
        $this->dbLink->beginTransaction();
        try {
            /*generar el correlativo del codigo de la parroquia que se ha de registrar*/
            $sql = "select * from f_generar_correlativo('capilla') as correlativo";
            $sentencia = $this->dbLink->prepare($sql);
            $sentencia->execute();

            if($sentencia->rowCount()){ /*rowcount es un metodo por tanto lleva parentesis*/
                //si se encontro el correlativo para la tabla parroquia
                $resultado = $sentencia->fetch(PDO::FETCH_ASSOC); /*FETCH_ASSOC para no repetir la informacion y obtenerla con el nombre del campo*/
                $nuevopar_id = $resultado["correlativo"]; //cargar nuevo codigo de parroquia
                $this->setId($nuevopar_id);

                /*INSERTAR EN LA TABLA PARROQUIA*/
                $sql = "
                    INSERT INTO capilla
                                (
                                cap_id, 
                                cap_nombre, 
                                cap_direccion, 
                                cap_estado, 
                                par_id                                
                               )

                        VALUES (
                                :p_id, 
                                :p_nombre, 
                                :p_direccion, 
                                :p_estado,  
                                :p_parroquia_id                                );
                        ";
                $sentencia= $this->dbLink->prepare($sql);
                $sentencia->bindParam(":p_id", $this->id);
                $sentencia->bindParam(":p_nombre", $this->nombre);
                $sentencia->bindParam(":p_direccion", $this->direccion);
                $sentencia->bindParam(":p_estado", $this->estado);
                $sentencia->bindParam(":p_parroquia_id", $this->parroquia_id);
                $sentencia->execute();

                /*ACTUALIZAR EL CORRELATIVO PARA LA TABLA PARROQUIA  EN + 1*/
                $sql = "update correlativo set numero = numero + 1 where tabla = 'capilla'";
                $sentencia= $this->dbLink->prepare($sql);
                $sentencia->execute();

                //CONFIRMAR LA TRANSACCION
                $this->dbLink->commit();

                return TRUE; //RETORNA VERDARERO CUANDO HA REGISTRADO TODO CORRECTAMENTE
            }else{
                //no se encontro el correlativo para la tabla parroquia
                throw new Exception("No se encontró el correlativo para la tabla parroquia");
            }
        } catch (Exception $exc) {
            $this->dbLink->rollback();//ABORTAR /DESHACER TODO LO QUE SE HA
            throw $exc;
        }
    }

    public function editar() {
        $this->dbLink->beginTransaction();

        try {
            $sql = "
                UPDATE 
                        capilla
                SET	
                        cap_nombre		= :p_nombre, 
                        cap_direccion  	= :p_direccion, 
                        cap_estado      = :p_estado, 
                        par_id 		= :p_parroquia_id,
                        parroquia 		= :p_parroquia

                 WHERE 
                        cap_id                  = :p_id

                 ";
            $sentencia= $this->dbLink->prepare($sql);

            $sentencia->bindParam(":p_nombre", $this->nombre);
            $sentencia->bindParam(":p_direccion", $this->direccion);
            $sentencia->bindParam(":p_estado", $this->estado);
            $sentencia->bindParam(":p_parroquia_id", $this->parroquia_id);
            $sentencia->bindParam(":p_parroquia", $this->parroquia);
            $sentencia->bindParam(":p_id", $this->id);
            $sentencia->execute();

            $this->dbLink->commit();

            return TRUE;

        } catch (Exception $exc) {
            $this->dbLink->rollBack();
            throw $exc;
        }

    }

    public function listar_por_cargo ($cargo,$capilla_id,$rol_id) {
        try {
            if($rol_id==3 or $rol_id=='3'){
                $sql="select
                  c.*
                from                
                  capilla c inner join asignacion_personal ap  on c.cap_id = ap.cap_id
                inner join persona p on p.per_iddni = ap.per_iddni inner join cargo ca on ca.car_id = p.car_id
                where  c.cap_estado = true ";
                $sentencia = $this->dbLink->prepare("$sql");
                $sentencia->execute();
                $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
                return $resultado;
            }else{
                $sql="select
                  c.*
                from                
                  capilla c inner join asignacion_personal ap  on c.cap_id = ap.cap_id
                inner join persona p on p.per_iddni = ap.per_iddni inner join cargo ca on ca.car_id = p.car_id
                where ca.car_id = :p_cargo and c.cap_estado = true and c.cap_id = :p_capilla_id ";
                $sentencia = $this->dbLink->prepare("$sql");
                $sentencia->bindParam(":p_cargo", $cargo);
                $sentencia->bindParam(":p_capilla_id", $capilla_id);
                $sentencia->execute();
                $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
                return $resultado;
            }


        } catch (Exception $exc) {
            throw $exc;
        }
    }

    public function listar () {
        try {
            $sql="select
                  *
                from                
                  capilla c where c.cap_estado =true
               ";
            $sentencia = $this->dbLink->prepare("$sql");
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }

    public function utilidades($fecha1,$fecha2,$capilla) {
        try {
            $sql="
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
                  where i.estado = 'Pagado' and (h.fecha BETWEEN :p_inicio and :p_fin)
                  and ca.cap_id = :p_capilla
                  group by i.cliente_dni,p.per_apellido_paterno , p.per_apellido_materno, p.per_nombre,
                  ce.cel_nombre, hp.hora_hora, h.fecha, p.per_telefono,i.estado,i.total,
                    ca.cap_nombre                
                 ";
            $sentencia = $this->dbLink->prepare($sql);
            $sentencia->bindParam(":p_inicio", $fecha1);
            $sentencia->bindParam(":p_fin", $fecha2);
            $sentencia->bindParam(":p_capilla", $capilla);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);

            return $resultado;

        } catch (Exception $exc) {
            throw $exc;
        }
    }


}