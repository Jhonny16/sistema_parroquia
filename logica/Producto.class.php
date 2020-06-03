<?php

require_once '../datos/Conexion.php';

class Producto extends Conexion {
    
    private $codigoProducto;
    private $nombre;
    private $descripcion;
    private $precioVenta;
    private $codigoCategoria;
    private $controlaStock; 
    
    function getCodigoProducto() {
        return $this->codigoProducto;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getDescripcion() {
        return $this->descripcion;
    }

    function getPrecioVenta() {
        return $this->precioVenta;
    }

    function getCodigoCategoria() {
        return $this->codigoCategoria;
    }

    function getControlaStock() {
        return $this->controlaStock;
    }

    function setCodigoProducto($codigoProducto) {
        $this->codigoProducto = $codigoProducto;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    function setPrecioVenta($precioVenta) {
        $this->precioVenta = $precioVenta;
    }

    function setCodigoCategoria($codigoCategoria) {
        $this->codigoCategoria = $codigoCategoria;
    }

    function setControlaStock($controlaStock) {
        $this->controlaStock = $controlaStock;
    }

    
    public function listar () {
        try {
            $sql="select

                            p.codigo_producto,
                            p.nombre,
                            p.descripcion,
                            p.precio_venta,
                            p.controla_stock,
                            p.stock,
                            c.nombre as categoria

                  from
                            producto p
                            inner join categoria c on (c.codigo_categoria = p.codigo_categoria)
                  order by
                            p.nombre  
                    ";
            $sentencia = $this->dbLink->prepare("$sql");
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);      
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;            
        }
    
    }  
    
    public function eliminar ($p_codigo_producto){
        /*Validar si el producto tiene pedidos*/
        $sql = "
                select 
                        codigo_producto

                from
                        comanda_detalle

                where
                        codigo_producto = :p_cod_pro;
                 ";
        
        
            $sentencia = $this->dbLink->prepare("$sql");
            $sentencia->bindParam(":p_cod_pro", $p_codigo_producto);
            $sentencia->execute();
            
            if ($sentencia->rowcount()){
                throw new Exception("No es posible eliminar este producto por motivos que tiene pedidos registrados");           
            }
        
        
        
        /*Iniciar la transacción*/
        $this->dbLink->beginTransaction();
        try {
            /*Elaborar la cosulta SQL para eliminar el producto por codigo de de producto*/
            $sql="
                delete from producto 
                where codigo_producto = :p_cod_pro";
            
            //declarar una sentencia en base a la consulta SQL
            $sentencia = $this->dbLink->prepare("$sql");
            
            //Enviar los valores a los parámetros de la sentencia
            $sentencia->bindParam(":p_cod_pro", $p_codigo_producto);
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
    public function agregar () {
        $this->dbLink->beginTransaction();
        try {
            /*generar el correlativo del codigo del producto que se ha registrar*/
            $sql = "select * from f_generar_correlativo('producto') as correlativo";
            $sentencia = $this->dbLink->prepare($sql);
            $sentencia->execute();
            
            if($sentencia->rowCount()){ /*rowcount es un metodo por tanto lleva parentesis*/
                //si se encontro el correlativo para la tabla producto
                $resultado = $sentencia->fetch(PDO::FETCH_ASSOC); /*FETCH_ASSOC para no repetir la informacion y obtenerla con el nombre del campo*/
                $nuevoCodigoProducto = $resultado["correlativo"];
                $this->setCodigoProducto($nuevoCodigoProducto);
                
                /*INSERTAR EN LA TABLA PRODUCTO*/
                $sql = "
                    INSERT INTO producto
                                (
                                codigo_producto, 
                                nombre, 
                                descripcion, 
                                precio_venta, 
                                codigo_categoria, 
                                controla_stock 
                                )

                        VALUES (
                                :p_codigo_producto, 
                                :p_nombre, 
                                :p_descripcion, 
                                :p_precio_venta, 
                                :p_codigo_categoria, 
                                :p_controla_stock 
                                );
                        ";
                $sentencia= $this->dbLink->prepare($sql);
                $sentencia->bindParam(":p_codigo_producto", $this->getCodigoProducto());
                $sentencia->bindParam(":p_nombre", $this->getNombre());
                $sentencia->bindParam(":p_descripcion", $this->getDescripcion());
                $sentencia->bindParam(":p_precio_venta", $this->getPrecioVenta());
                $sentencia->bindParam(":p_codigo_categoria", $this->getCodigoCategoria());
                $sentencia->bindParam(":p_controla_stock", $this->getControlaStock());                
                $sentencia->execute();
                
                /*ACTUALIZAR EL CORRELATIVO PARA LA TABLA PRODUCTO EN + 1*/
                $sql = "update correlativo set numero = numero + 1 where tabla = 'producto'";
                $sentencia= $this->dbLink->prepare($sql); 
                $sentencia->execute();
                
                //CONFIRMAR LA TRANSACCION
                $this->dbLink->commit();
                
                return TRUE; //RETORNA VERDARERO CUANDO HA REGISTRADO TODO CORRECTAMENTE
            }else{
                //no se encontro el correlativo para la tabla producto
                throw new Exception("No se encontró el correlativo para la tabla producto");
                
            }
        } catch (Exception $exc) {
            $this->dbLink->rollback();//ABORTAR /DESHACER TODO LO QUE SE HA             
            throw $exc;
            
        }
           
    }
    
    /*EDITAR PRODUCTO POR EL CODIGO*/
    public function leerDatos($p_codigo_producto) {
        try {
            $sql = "
                    select 
                            codigo_producto,
                            nombre,
                            descripcion,
                            precio_venta,
                            controla_stock,
                            codigo_categoria

                    from

                            producto p

                    where   codigo_producto = :p_codigo_producto
                   ";
            
            $sentencia = $this->dbLink->prepare($sql);
            $sentencia->bindParam(":p_codigo_producto",$p_codigo_producto );
            $sentencia->execute();
            $resultado = $sentencia->fetch (PDO::FETCH_ASSOC);
            return $resultado;
            
            
        } catch (Exception $exc) {
            throw $exc;
        }
            
    }
    
    
    public function editar() {
        $this->dbLink->beginTransaction();
        
        try {
            $sql = "
                UPDATE 
                        producto
                SET	
                        nombre 			= :p_nombre, 
                        descripcion 		= :p_descripcion, 
                        precio_venta 		= :p_precio_venta, 
                        codigo_categoria 	= :p_codigo_categoria, 
                        controla_stock 		= :p_controla_stock 

                 WHERE 
                        codigo_producto		= :p_codigo_producto

                 ";
            $sentencia= $this->dbLink->prepare($sql);
                
                $sentencia->bindParam(":p_nombre", $this->getNombre());
                $sentencia->bindParam(":p_descripcion", $this->getDescripcion());
                $sentencia->bindParam(":p_precio_venta", $this->getPrecioVenta());
                $sentencia->bindParam(":p_codigo_categoria", $this->getCodigoCategoria());
                $sentencia->bindParam(":p_controla_stock", $this->getControlaStock());   
                $sentencia->bindParam(":p_codigo_producto", $this->getCodigoProducto());
                $sentencia->execute();
                
                $this->dbLink->commit();
                
                return TRUE;
                
        } catch (Exception $exc) {
            $this->dbLink->rollBack();
            throw $exc;
        }
            
    }
}
