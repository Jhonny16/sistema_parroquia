<?php
/**
 * Created by PhpStorm.
 * User: jhonny
 * Date: 12/05/19
 * Time: 11:12 AM
 */

require_once '../datos/Conexion.php';

class Asignacion extends Conexion
{

    private $id;
    private $fecha_inicio;
    private $fecha_fin;
    private $capilla;
    private $estado;
    private $dni;

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


    public function lista($parroquia_id,$rol)
    {
        try {
            if($rol==3 or $rol=='3'){
                $sql = "select
                ap.per_iddni,
                p.per_apellido_paterno ||' '|| p.per_apellido_materno||' '|| p.per_nombre as persona               
                from persona p inner join asignacion_personal ap on p.per_iddni = ap.per_iddni
                inner join capilla c on ap.cap_id = c.cap_id
                inner join parroquia p2 on c.par_id = p2.par_id               
                group by   
                 ap.per_iddni,
                p.per_apellido_paterno , p.per_apellido_materno, p.per_nombre       
               ";
                $sentencia = $this->dbLink->prepare($sql);
                $sentencia->execute();
                $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            }
            else{
                $sql = "select
                ap.per_iddni,
                p.per_apellido_paterno ||' '|| p.per_apellido_materno||' '|| p.per_nombre as persona               
                from persona p inner join asignacion_personal ap on p.per_iddni = ap.per_iddni
                inner join capilla c on ap.cap_id = c.cap_id
                inner join parroquia p2 on c.par_id = p2.par_id
                where p2.par_id = :p_parroquia_id   
                group by   
                 ap.per_iddni,
                p.per_apellido_paterno , p.per_apellido_materno, p.per_nombre       
               ";
                $sentencia = $this->dbLink->prepare($sql);
                $sentencia->bindParam(":p_parroquia_id", $parroquia_id);
                $sentencia->execute();
                $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            }


            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }

    public function lista_capillas_por_persona($dni)
    {
        try {
            $sql = "select
                ap.per_iddni,
                p.per_apellido_paterno ||' '|| p.per_apellido_materno||' '|| p.per_nombre as persona,
                c.cap_nombre,
                p2.par_nombre
                from persona p inner join asignacion_personal ap on p.per_iddni = ap.per_iddni
                inner join capilla c on ap.cap_id = c.cap_id
                inner join parroquia p2 on c.par_id = p2.par_id
                inner join cargo c2 on p.car_id = c2.car_id
                where ap.per_iddni = :p_dni ;
               ";
            $sentencia = $this->dbLink->prepare($sql);
            $sentencia->bindParam(":p_dni", $dni);
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
            $sql = "select
                    ap.per_iddni as dni, c.cap_id as capilla_id, c.cap_nombre capilla_nombre
                    from persona p inner join asignacion_personal ap on 
                    p.per_iddni = ap.per_iddni
                    inner  join capilla c on ap.cap_id = c.cap_id
                    where ap.per_iddni = :p_dni
               ";
            $sentencia = $this->dbLink->prepare($sql);
            $sentencia->bindParam(":p_dni", $dni);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }

    public function agregar()
    {
        $this->dbLink->beginTransaction();
        try {

            $array = $this->capilla;
            for ($j = 0; $j < count($array); $j++) {

                $sql = "select * from f_generar_correlativo('asignacion') as correlativo";
                $sentencia = $this->dbLink->prepare($sql);
                $sentencia->execute();

                if ($sentencia->rowCount()) {
                    $resultado = $sentencia->fetch(PDO::FETCH_ASSOC); /*FETCH_ASSOC para no repetir la informacion y obtenerla con el nombre del campo*/
                    $id = $resultado["correlativo"];

                    $sql = "select count(*) as cant from asignacion_personal
                                where per_iddni = :p_dni and cap_id = :p_capilla ";
                    $sentencia = $this->dbLink->prepare($sql);
                    $sentencia->bindParam(":p_dni", $this->dni);
                    $sentencia->bindParam(":p_capilla", $array[$j]);
                    $sentencia->execute();
                    $resultado = $sentencia->fetch(PDO::FETCH_ASSOC);


                    if ($sentencia->rowCount()) {
                        $cant = $resultado["cant"];
                        if ($cant == 0) {
                            $fecha_inicio = "2019-01-01";
                            $fecha_fin = "2019-12-31";
                            $estado = true;
                            $sql = "
                    INSERT INTO asignacion_personal
                                (
                                ap_id,
                                ap_fecha_inicio,
                                ap_fecha_final,
                                cap_id,
                                ap_estado,
                                per_iddni
                               )

                        VALUES (
                                :p_id,
                                :p_fechai,
                                :p_fechaf,
                                :p_capilla,
                                :p_estado,
                                :p_dni );
                        ";
                            $sentencia = $this->dbLink->prepare($sql);
                            $sentencia->bindParam(":p_id", $id);
                            $sentencia->bindParam(":p_fechai", $fecha_inicio);
                            $sentencia->bindParam(":p_fechaf", $fecha_fin);
                            $sentencia->bindParam(":p_capilla", $array[$j]);
                            $sentencia->bindParam(":p_estado", $estado);
                            $sentencia->bindParam(":p_dni", $this->dni);
                            $sentencia->execute();

                            $sql = "update correlativo set numero = numero + 1 where tabla = 'asignacion'";
                            $sentencia = $this->dbLink->prepare($sql);
                            $sentencia->execute();

                            $this->dbLink->commit();
                        }
//
                    }

                }
            }


             return TRUE;


        } catch
        (Exception $exc) {
            $this->dbLink->rollback();
            throw $exc;
        }
    }


    public function editar()
    {
        $this->dbLink->beginTransaction();

        try {

            $array = $this->capilla;
            for ($j = 0; $j < count($array); $j++) {

                $sql = "select count(*) as cant from asignacion_personal
                                where per_iddni = :p_dni and cap_id = :ṕ_capilla";
                $sentencia = $this->dbLink->prepare($sql);
                $sentencia->bindParam(":p_dni", $this->dni);
                $sentencia->bindParam(":ṕ_capilla", $this->capilla);
                $sentencia->execute();
                $resultado = $sentencia->fetch(PDO::FETCH_ASSOC);

                if ($sentencia->rowCount()) {

                } else {

                }


                $sql = "
                UPDATE 
                        asignacion_personal
                SET	
                        cap_id		= :p_capilla, 
                        per_iddni  		= :p_par_direccion                      
                 WHERE 
                        par_id                  = :p_par_id

                 ";
                $sentencia = $this->dbLink->prepare($sql);
                //$sentencia->bindParam(":p_id", $id);
                $sentencia->bindParam(":p_fechai", "2019-01-01");
                $sentencia->bindParam(":p_fechaf", "2019-12-31");
                $sentencia->bindParam(":p_capilla", $array[$j]);
                $sentencia->bindParam(":p_estado", true);
                $sentencia->bindParam(":p_dni", $this->dni);
                $sentencia->execute();


            }
            $this->dbLink->commit();

            return TRUE;

            $sql = "
                UPDATE 
                        parroquia
                SET	
                        par_nombre		= :p_par_nombre, 
                        par_direccion  		= :p_par_direccion, 
                        par_telefono 		= :p_par_telefono, 
                        par_email 		= :p_par_email 

                 WHERE 
                        par_id                  = :p_par_id

                 ";
            $sentencia = $this->dbLink->prepare($sql);

            $sentencia->bindParam(":p_par_nombre", $this->par_nombre);
            $sentencia->bindParam(":p_par_direccion", $this->par_direccion);
            $sentencia->bindParam(":p_par_telefono", $this->par_telefono);
            $sentencia->bindParam(":p_par_email", $this->par_email);
            $sentencia->bindParam(":p_par_id", $this->par_id);
            $sentencia->execute();

            $this->dbLink->commit();

            return TRUE;

        } catch (Exception $exc) {
            $this->dbLink->rollBack();
            throw $exc;
        }

    }

}