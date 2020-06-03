<?php
/**
 * Created by PhpStorm.
 * User: jhonny
 * Date: 02/05/19
 * Time: 08:46 PM
 */
require_once '../datos/Conexion.php';

class Usuario extends Conexion
{

    private $id;
    private $clave;
    private $estado;
    private $dni;
    private $fecha_inicio;
    private $fecha_fin;
    private $rol_id;

    /**
     * @return mixed
     */
    public function getRolId()
    {
        return $this->rol_id;
    }

    /**
     * @param mixed $rol_id
     */
    public function setRolId($rol_id)
    {
        $this->rol_id = $rol_id;
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
    public function getClave()
    {
        return $this->clave;
    }

    /**
     * @param mixed $clave
     */
    public function setClave($clave)
    {
        $this->clave = $clave;
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
    public function getDni()
    {
        return $this->dni;
    }

    /**
     * @param mixed $dni
     */
    public function setDni($dni)
    {
        $this->dni = $dni;
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


    public function create()
    {
        $this->dbLink->beginTransaction();
        try {
            /*generar el correlativo del codigo de la parroquia que se ha de registrar*/
            $sql = "select * from f_generar_correlativo('usuario') as correlativo";
            $sentencia = $this->dbLink->prepare($sql);
            $sentencia->execute();

            if($sentencia->rowCount()) { /*rowcount es un metodo por tanto lleva parentesis*/
                //si se encontro el correlativo para la tabla parroquia
                $resultado = $sentencia->fetch(PDO::FETCH_ASSOC); /*FETCH_ASSOC para no repetir la informacion y obtenerla con el nombre del campo*/
                $nuevo_id = $resultado["correlativo"];

                $sql = "INSERT INTO usuario (usu_id, usu_clave, usu_estado, per_iddni, fecha_inicio, fecha_fin, rol_id)
                  values (:p_id, md5(:p_clave), :p_estado, :p_dni, :p_fecinicio, :p_fecfin, :p_rolid)  ";
                $sentencia = $this->dbLink->prepare($sql);
                $sentencia->bindParam(":p_id", $nuevo_id);
                $sentencia->bindParam(":p_clave", $this->clave);
                $sentencia->bindParam(":p_estado", $this->estado);
                $sentencia->bindParam(":p_dni", $this->dni);
                $sentencia->bindParam(":p_fecinicio", $this->fecha_inicio);
                $sentencia->bindParam(":p_fecfin", $this->fecha_fin);
                $sentencia->bindParam(":p_rolid", $this->rol_id);
                $sentencia->execute();

                /*ACTUALIZAR EL CORRELATIVO PARA LA TABLA PARROQUIA  EN + 1*/
                $sql = "update correlativo set numero = numero + 1 where tabla = 'usuario'";
                $sentencia= $this->dbLink->prepare($sql);
                $sentencia->execute();

                //CONFIRMAR LA TRANSACCION
                $this->dbLink->commit();

                return true;

            }



        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function update()
    {
        $this->dbLink->beginTransaction();
        try {
            $sql = "UPDATE usuario SET usu_estado = :p_estado, per_iddni = :p_dni, fecha_inicio = :p_fecinicio,
                    fecha_fin  = :p_fecfin, rol_id = :p_rolid
                    WHERE usu_id = :p_id";

            $sentencia = $this->dbLink->prepare($sql);
            $sentencia->bindParam(":p_estado", $this->estado);
            $sentencia->bindParam(":p_dni", $this->dni);
            $sentencia->bindParam(":p_fecinicio", $this->fecha_inicio);
            $sentencia->bindParam(":p_fecfin", $this->fecha_fin);
            $sentencia->bindParam(":p_rolid", $this->rol_id);
            $sentencia->bindParam(":p_id", $this->id);
            $sentencia->execute();
            $this->dbLink->commit();
            return true;

        } catch (Exception $ex) {
            $this->dbLink->rollBack();
            throw $ex;
        }
    }

    public function update_con_password()
    {
        $this->dbLink->beginTransaction();
        try {
            $sql = "UPDATE usuario SET usu_estado = :p_estado, per_iddni = :p_dni, fecha_inicio = :p_fecinicio,
                    fecha_fin  = :p_fecfin, rol_id = :p_rolid, usu_clave = md5(:p_clave)
                    WHERE usu_id = :p_id";

            $sentencia = $this->dbLink->prepare($sql);
            $sentencia->bindParam(":p_estado", $this->estado);
            $sentencia->bindParam(":p_dni", $this->dni);
            $sentencia->bindParam(":p_fecinicio", $this->fecha_inicio);
            $sentencia->bindParam(":p_fecfin", $this->fecha_fin);
            $sentencia->bindParam(":p_rolid", $this->rol_id);
            $sentencia->bindParam(":p_clave", $this->clave);
            $sentencia->bindParam(":p_id", $this->id);
            $sentencia->execute();
            $this->dbLink->commit();
            return true;

        } catch (Exception $ex) {
            $this->dbLink->rollBack();
            throw $ex;
        }
    }


    public function lista ($rol_id,$parroquia_id,$dni) {
        try {

            if($rol_id==2 or $rol_id=='2'){
                $sql="
               select
                  u.usu_id,
                  p.per_apellido_paterno ||' '|| p.per_apellido_materno ||' '|| p.per_nombre as nombre_usuario,
                  u.usu_estado,
                  p.per_iddni,
                  u.fecha_inicio,
                  u.fecha_fin,
                  r.nombre,
                  r.id,
                  (case when (current_date between u.fecha_inicio and u.fecha_fin) then 1 else 0 end) as vigente
                from persona p inner join usuario u on (u.per_iddni = p.per_iddni)
                  inner join rol r on u.rol_id = r.id where u.per_iddni = :p_dni;
                 ";
                $sentencia = $this->dbLink->prepare($sql);
                $sentencia->bindParam(":p_dni", $dni);
                $sentencia->execute();
                $resultado = $sentencia->fetch(PDO::FETCH_ASSOC);
                return $resultado;
            }else{
                if($rol_id==3 or $rol_id=='3'){
                    $sql="
               select
                  u.usu_id,
                  p.per_apellido_paterno ||' '|| p.per_apellido_materno ||' '|| p.per_nombre as nombre_usuario,
                  u.usu_estado,
                  p.per_iddni,
                  u.fecha_inicio,
                  u.fecha_fin,
                  r.nombre,
                  r.id,
                  (case when (current_date between u.fecha_inicio and u.fecha_fin) then 1 else 0 end) as vigente
                from persona p inner join usuario u on (u.per_iddni = p.per_iddni)
                  inner join rol r on u.rol_id = r.id;
                 ";
                    $sentencia = $this->dbLink->prepare($sql);
                    $sentencia->execute();
                    $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
                    return $resultado;
                }else{
                    $sql = "
                          select
                          u.usu_id,
                          p.per_apellido_paterno ||' '|| p.per_apellido_materno ||' '|| p.per_nombre as nombre_usuario,
                          u.usu_estado,
                          p.per_iddni,
                          u.fecha_inicio,
                          u.fecha_fin,
                          r.nombre,
                          r.id,
                          (case when (current_date between u.fecha_inicio and u.fecha_fin) then 1 else 0 end) as vigente
                        from
                          capilla cap left join parroquia pa on cap.par_id = pa.par_id
                                      inner join capilla c on pa.par_id = c.par_id inner join asignacion_personal ap on c.cap_id = ap.cap_id
                                      inner join persona p on ap.per_iddni = p.per_iddni
                         inner join usuario u on (u.per_iddni = p.per_iddni)
                          inner join rol r on u.rol_id = r.id
                        where pa.par_id  = :p_parroquia_id
                        group by
                          u.usu_id,
                          p.per_apellido_paterno,p.per_apellido_materno,p.per_nombre ,
                          u.usu_estado,
                          p.per_iddni,
                          u.fecha_inicio,
                          u.fecha_fin,
                          r.nombre,
                          r.id
                ";
                    $sentencia = $this->dbLink->prepare($sql);
                    $sentencia->bindParam(":p_parroquia_id", $parroquia_id);
                    $sentencia->execute();
                    $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
                    return $resultado;

                }
            }




        } catch (Exception $exc) {
            throw $exc;
        }
    }

    public function read($id) {
        try {
            $sql="
               select
                  u.usu_id,
                  p.per_apellido_paterno ||' '|| p.per_apellido_materno ||' '|| p.per_nombre as nombre_usuario,
                  u.usu_estado,
                  p.per_iddni,
                  u.fecha_inicio,
                  u.fecha_fin,
                  r.nombre,
                  r.id,
                  (case when (current_date between u.fecha_inicio and u.fecha_fin) then 1 else 0 end) as vigente
                from persona p inner join usuario u on (u.per_iddni = p.per_iddni)
                  inner join rol r on u.rol_id = r.id
                  where u.usu_id = :p_user;
                 ";
            $sentencia = $this->dbLink->prepare($sql);
            $sentencia->bindParam(":p_user", $id);
            $sentencia->execute();
            $resultado = $sentencia->fetch(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }

    public function validar_password($id,$passord){

        $sql = "select * from usuario 
                    where usu_id = :p_id";
        $sentencia = $this->dbLink->prepare($sql);
        $sentencia->bindParam(":p_id", $id);
        $sentencia->execute();
        $resultado = $sentencia->fetch();
        if ($sentencia->rowCount()) {
            $contrasenia = $resultado["usu_clave"];
            if ($resultado["usu_clave"] == md5($passord)) {
                return 1;
            }
            else{
                return 0;
            }
        }
        return -1;
    }

}