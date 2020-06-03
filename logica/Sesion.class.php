<?php

require_once '../datos/Conexion.php'; //para validar correo y clave de usuario

class Sesion extends Conexion {
    private $email;
    private $clave;
    
    function getEmail() {
        return $this->email;
    }

    function getClave() {
        return $this->clave;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setClave($clave) {
        $this->clave = $clave;
    }

    public function iniciarSesion(){
        try {
            $sql="
                select 
                        p.per_apellido_paterno,
                        p.per_apellido_materno,
                        p.per_nombre,
                        u.usu_clave,
                        u.usu_estado,
                        c.car_nombre as cargo,
                        c.car_id,
                        p.per_iddni,
                        ap.cap_id,
                        (case when (current_date between u.fecha_inicio and u.fecha_fin) then 1 else 0 end) as vigente,
                        r.nombre as rol_name,
                        r.id as rol_id,
                         p2.par_id as parroquia,
                         u.usu_id as user_id
                from
                        persona p
                        inner join usuario u on (u.per_iddni = p.per_iddni)
                        inner join cargo c on (c.car_id = p.car_id)
                        inner join asignacion_personal ap on p.per_iddni = ap.per_iddni
                        inner join rol r on u.rol_id = r.id
                        inner join capilla c2 on ap.cap_id = c2.cap_id
                        inner join parroquia p2 on c2.par_id = p2.par_id
                where
                        lower(p.per_email) = lower(:p_per_email)
                ";
             //lower para no distiguir las mayusculas con minusculas            
            // Decalarar la sentencia
            $sentencia = $this->dbLink->prepare($sql);
            
            // Asignar el valor a los parametros de la sentencia
            $sentencia->bindParam(":p_per_email", $this->email);
            
            // ejecutar la sentencia            
            $sentencia->execute();
            
            if ($sentencia->rowCount()){ //Le pregunta si la sentencia ha devuelto registros
                //El usuario si existe
                
                //Recoger el resulado que devuelve la sentencia
                $resultado = $sentencia->fetch();
                
                //Validar si la contraseña ingresada por el usuario es la misma que esta registada por el usuario
                if ($resultado["usu_clave"] == md5($this->clave)){
                    //Validar el estado del usuario
                    if ($resultado["vigente"] == 1){
                        //El usuario esta activo
                        
                        
                        //Crear la Sesion
                        session_name("programacionII");
                        session_start();
                        $_SESSION["nombre"] = $resultado["per_nombre"] . " " . $resultado["per_apellido_paterno"];
                        $_SESSION["cargo"] = $resultado["cargo"];
                        $_SESSION["email"] = $this->email;
                        $_SESSION["dni"] = $resultado["per_iddni"];
                        $_SESSION["cargo_id"] = $resultado["car_id"];
                        $_SESSION["capilla_id"] = $resultado["cap_id"];
                        $_SESSION["rol_name"] = $resultado["rol_name"];
                        $_SESSION["rol_id"] = $resultado["rol_id"];
                        $_SESSION["parroquia_id"] = $resultado["parroquia"];
                        $_SESSION["user_id"] = $resultado["user_id"];

                        return "SI"; // Puede ingresar a la Aplicación                        
                    }else{
                        return "UI"; // El usuario esta inactivo                        
                    }
                }else {
                    
                    return "CI"; //Contraseña Incorrecta
                }                
            }
            else{
                $res = $this->iniciarSesion2();
                if ($res == 'NE'){
                    return "NE"; //El usuario ingresado no existe
                }else{
                    return $res;
                }

            }
            
        } catch (Exception $exc) {
            throw $exc;
        }
            
    }

    public function iniciarSesion2(){
        try {
            $sql="
                select 
                        p.per_apellido_paterno,
                        p.per_apellido_materno,
                        p.per_nombre,
                        u.usu_clave,
                        u.usu_estado,
                        c.car_nombre as cargo,
                        c.car_id,
                        p.per_iddni,
                        (case when (current_date between u.fecha_inicio and u.fecha_fin) then 1 else 0 end) as vigente,
                        r.nombre as rol_name,
                        r.id as rol_id,
                        u.usu_id
                from
                        persona p
                        inner join usuario u on (u.per_iddni = p.per_iddni)
                        inner join cargo c on (c.car_id = p.car_id)
                        inner join rol r on u.rol_id = r.id
                where
                        lower(p.per_email) = lower(:p_per_email)
                ";
            //lower para no distiguir las mayusculas con minusculas
            // Decalarar la sentencia
            $sentencia = $this->dbLink->prepare($sql);

            // Asignar el valor a los parametros de la sentencia
            $sentencia->bindParam(":p_per_email", $this->email);

            // ejecutar la sentencia
            $sentencia->execute();

            if ($sentencia->rowCount()){ //Le pregunta si la sentencia ha devuelto registros
                //El usuario si existe

                //Recoger el resulado que devuelve la sentencia
                $resultado = $sentencia->fetch();

                //Validar si la contraseña ingresada por el usuario es la misma que esta registada por el usuario
                if ($resultado["usu_clave"] == md5($this->clave)){
                    //Validar el estado del usuario
                    if ($resultado["vigente"] == 1){
                        //El usuario esta activo


                        //Crear la Sesion
                        session_name("programacionII");
                        session_start();
                        $_SESSION["nombre"] = $resultado["per_nombre"] . " " . $resultado["per_apellido_paterno"];
                        $_SESSION["cargo"] = $resultado["cargo"];
                        $_SESSION["email"] = $this->email;
                        $_SESSION["dni"] = $resultado["per_iddni"];
                        $_SESSION["cargo_id"] = $resultado["car_id"];
                        $_SESSION["capilla_id"] = $resultado["cap_id"];
                        $_SESSION["rol_name"] = $resultado["rol_name"];
                        $_SESSION["rol_id"] = $resultado["rol_id"];
                        $_SESSION["parroquia_id"] = "0";
                        $_SESSION["user_id"] = $resultado["usu_id"];

                        return "UC"; // Puede ingresar a la Aplicación
                    }else{
                        return "UI"; // El usuario esta inactivo
                    }
                }else {

                    return "CI"; //Contraseña Incorrecta
                }
            }else{
                return "NE";
                //his->iniciarSesionCliente();

            }

        } catch (Exception $exc) {
            throw $exc;
        }

    }

    public function iniciarSesionCliente(){
        try {
            $sql="
                select 
                        p.per_apellido_paterno,
                        p.per_apellido_materno,
                        p.per_nombre,
                        u.usu_clave,
                        u.usu_estado,
                        c.car_nombre as cargo,
                        c.car_id,
                        p.per_iddni,
                        (case when (current_date between u.fecha_inicio and u.fecha_fin) then 1 else 0 end) as vigente,
                        r.nombre as rol_name,
                        r.id as rol_id
                from
                        persona p
                        inner join usuario u on (u.per_iddni = p.per_iddni)
                        inner join cargo c on (c.car_id = p.car_id)
                        inner join rol r on u.rol_id = r.id
                where
                        lower(p.per_email) = lower(:p_per_email)
                ";
            //lower para no distiguir las mayusculas con minusculas
            // Decalarar la sentencia
            $sentencia = $this->dbLink->prepare($sql);

            // Asignar el valor a los parametros de la sentencia
            $sentencia->bindParam(":p_per_email", $this->email);

            // ejecutar la sentencia
            $sentencia->execute();

            if ($sentencia->rowCount()){ //Le pregunta si la sentencia ha devuelto registros
                //El usuario si existe

                //Recoger el resulado que devuelve la sentencia
                $resultado = $sentencia->fetch();

                //Validar si la contraseña ingresada por el usuario es la misma que esta registada por el usuario
                if ($resultado["usu_clave"] == md5($this->clave)){
                    //Validar el estado del usuario
                    if ($resultado["vigente"] == 1){
                        //El usuario esta activo


                        //Crear la Sesion
                        session_name("programacionII");
                        session_start();
                        $_SESSION["nombre"] = $resultado["per_nombre"] . " " . $resultado["per_apellido_paterno"];
                        $_SESSION["cargo"] = $resultado["cargo"];
                        $_SESSION["email"] = $this->email;
                        $_SESSION["dni"] = $resultado["per_iddni"];
                        $_SESSION["cargo_id"] = $resultado["car_id"];
                        $_SESSION["capilla_id"] = $resultado["cap_id"];
                        $_SESSION["rol_name"] = $resultado["rol_name"];
                        $_SESSION["rol_id"] = $resultado["rol_id"];

                        return "SI"; // Puede ingresar a la Aplicación
                    }else{
                        return "UI"; // El usuario esta inactivo
                    }
                }else {

                    return "CI"; //Contraseña Incorrecta
                }
            }else{
                return "NE"; //El usuario ingresado no existe

            }

        } catch (Exception $exc) {
            throw $exc;
        }

    }

    public function cambiarclave() {
        try {
            $this->dbLink->beginTransaction();
            $sql="SELECT dni
                    FROM personal
                    where lower (email)= lower(:p_email)                
                ";
            $sentencia = $this->dbLink->prepare($sql);
            $sentencia->bindParam(":p_email", $this->getEmail());
            $sentencia->execute();
            
            if ($sentencia->rowCount()){
            $resultado = $sentencia->fetch();
            
            $sql="UPDATE usuario
                SET clave=md5(:p_clave) 
                WHERE dni_usuario=:p_dni
                and estado='A'
                ";           
             
            $sentencia = $this->dbLink->prepare($sql);
            
            //Asignar el valor a los parametros de la sentencia
            $sentencia->bindParam(":p_clave", $this->getClave());            
            $sentencia->bindParam(":p_dni", $resultado["dni"]);
                       echo $resultado["dni"];
            //Ejecutar la sentencia''
            $sentencia->execute();  
            $this->dbLink->commit();
            return true;
            }
        } catch (Exception $exc) {
            throw $exc;
        }
    }
}
