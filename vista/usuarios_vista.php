<?php
/**
 * Created by PhpStorm.
 * User: jhonny
 * Date: 01/05/19
 * Time: 10:22 AM
 */
require_once 'sesion.validar.vista.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Usuarios</title>
    <?php require_once 'metas.vista.php'; ?>
    <?php require_once 'estilos.vista.php'; ?>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
    <?php require_once 'menu.cabecera.vista.php'; ?>
    <!-- =============================================== -->

    <!-- Left side column. contains the sidebar -->
    <?php require_once 'menu.izquierda.vista.php'; ?>
    <!-- =============================================== -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" style="background-color: white" >
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h5 class="box-title" style="color: #01a189">USUARIOS
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <span class="pull-right-container"></span>
                            </h5>

                        </div>
                        <div class="box-body">

                            <div class="row">
                                <div class="col-xs-12 col-lg-5">
                                    <div class="box box-default">
                                        <div class="box-header with-border">
                                            <h5 class="box-title" >Datos del usuario:
                                            </h5>
                                        </div>
                                        <!-- /.box-header -->
                                        <div class="box-body">
                                            <form role="form">
                                                <input type="text" id="usuario_id" style="display: none">
                                                <div class="form-group">
                                                    <br>
                                                    <label for="inputPassword3" class="col-sm-2 control-label">Activo</label>
                                                    <div class="col-sm-10">
                                                        <div class="radio">
                                                            <label>
                                                                <input type="radio" name="rbestado" class="flat-red"
                                                                       id="rbactivo"
                                                                       value="1" checked> SI
                                                            </label>
                                                            <label>
                                                                &nbsp;&nbsp;<input type="radio" class="flat-red"
                                                                                   name="rbestado"
                                                                                   id="rbnoactivo"
                                                                                   value="0"> NO
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-xs-6">
                                                        <label for="exampleInputPassword1">Fecha Inicio</label>
                                                        <input type="date" class="form-control" id="datefec_inicio" />
                                                    </div>
                                                    <div class="col-xs-6">
                                                        <label for="exampleInputPassword1">Fecha Fin</label>
                                                        <input type="date" class="form-control" id="datefec_fin" />
                                                    </div>

                                                </div>
                                                <div class="form-group col-xs-12">
                                                    <br>
                                                    <label for="inputPassword3">Usuario</label>
                                                    <select name="" id="combo_usuario" class="form-control">

                                                    </select>
                                                </div>
                                                <div class="form-group col-xs-12" id="divcheck_contrasenia" style="display:none">
                                                    <br>
                                                    <label for="exampleInputPassword1">Cambiar contraseña</label>
                                                    <label>
                                                        <input type="checkbox" class="flat-red" id="check_contrasenia" >
                                                    </label>
                                                </div>

                                                <div class="form-group col-xs-12" id="div_contrasenia" >
                                                    <br>
                                                    <label for="exampleInputPassword1">Contraseña</label>
                                                    <input type="password" class="form-control" id="txtcontrasenia"
                                                           placeholder="Ingrese contraseña ..." onblur="validar_password()"
                                                           maxlength="10">
                                                </div>
                                                <div class="form-group col-xs-12" id="divnueva_contrasenia" style="display:none">
                                                    <br>
                                                    <label for="exampleInputPassword1">Nueva Contraseña</label>
                                                    <input type="password" class="form-control" id="txtnueva_contrasenia"
                                                           maxlength="10"
                                                           placeholder="Ingrese contraseña ..." readonly>
                                                </div>
                                                <div class="form-group col-xs-12">
                                                    <br>
                                                    <label for="inputPassword3">Tipo de Usuario</label>
                                                    <select name="" id="combo_tipousuario" class="form-control">

                                                    </select>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="box-footer ">
                                            <div class="col-xs-12">
                                                <button type="button" class="btn btn-info" onclick="usuario_add()">
                                                    Guardar
                                                </button>
                                                <button type="button" class="btn btn-success pull-right" onclick="refresh()">
                                                    Nuevo
                                                </button>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-lg-7">
                                    <div class="box box-warning">
                                        <div class="box-header with-border"> <h5 class="box-title" >
                                                Lista
                                            </h5>
                                        </div>
                                        <!-- /.box-header -->
                                        <div class="box-body">
                                            <div class="col-lg-12"  id="listado_users"></div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>


        </section>
    </div>

    <?php require_once 'menu.pie.vista.php'; ?>
</div>


<?php require_once 'scripts.vista.php'; ?>

<script src="js/usuario.js" type="text/javascript"></script>



</body>
</html>