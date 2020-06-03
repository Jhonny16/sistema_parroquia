<?php require_once 'sesion.validar.vista.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Mantenimiento de Parroquia</title>
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
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Mantenimiento de Capilla
            </h1>
            <ol class="breadcrumb">
                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#myModal" id="btnagregar">
                    <i class="fa fa-copy"></i> Agregar Capilla</button>&nbsp;&nbsp;&nbsp;
                <li><a href="#"><i class="fa fa-dashboard"></i> Menú Principal</a></li>
                <li><a href="#">Mantenimientos</a></li>
                <li class="active">Mantenimiento de Capilla</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-default">
                        <div class="box-body">
                            <div id="listado"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- INICIO del formulario modal -->
            <small>
                <form id="frmgrabar">
                    <div class="modal fade" id="myModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title" id="titulomodal">Título de la ventana</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <p>
                                                <input type="hidden" value="" id="txtTipoOperacion" name="txtTipoOperacion">
                                                Código <input type="text"
                                                              name="txtCodigo"
                                                              id="txtCodigo"
                                                              class="form-control input-sm text-bold"
                                                              readonly="">
                                            </p>
                                        </div>
                                    </div>
                                    <div class="row" id="div_pasar_parroquia" style="display: none">
                                        <div class="col-xs-12">
                                            <div class="form-group">
                                                <label>
                                                    <input type="checkbox" class="flat-red" id="pasar_parroquia" name="pasar_parroquia">
                                                    Desea pasar a parroquia?
                                                </label>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="row" id="div_estado">
                                        <div class="col-xs-12">
                                            <div class="form-group">
                                                <label>
                                                    Activo<input type="radio" name="r3" id="activo" class="flat-red" checked>
                                                </label>
                                                <label>
                                                    No Activo<input type="radio" name="r3" id="no_activo" class="flat-red">
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <p>
                                                Nombre de la Capilla
                                                <input type="text"
                                                       name="nombre"
                                                       id="nombre"
                                                       class="form-control input-sm text-bold" required="">
                                            </p>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-xs-12">
                                            <p>
                                                Dirección <input type="text"
                                                                 name="direccion"
                                                                 id="direccion"
                                                                 class="form-control input-sm text-bold" required="">
                                            </p>
                                        </div>
                                    </div>
                                    <div class="row" id="div_parroquia">
                                        <div class="col-xs-12">
                                            <p>
                                                Parroquia
                                                <select name="combo_paroquia"
                                                        id="combo_paroquia"
                                                        class="form-control input-sm" required="">

                                                </select>
                                            </p>
                                        </div>
                                    </div>


                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-success" aria-hidden="true"><i class="fa fa-save"></i> Grabar</button>
                                    <button type="button" class="btn btn-default" data-dismiss="modal" id="btncerrar"><i class="fa fa-close"></i> Cerrar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </small>
            <!-- FIN del formulario modal -->


        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <?php require_once 'menu.pie.vista.php'; ?>

    <!-- Control Sidebar -->
    <?php require_once 'menu.derecha.vista.php'; ?>
    <!-- /.control-sidebar -->
    <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<?php require_once 'scripts.vista.php'; ?>

<!-- Scripts para mantenimiento -->
<script src="js/capilla.js" type="text/javascript"></script>

</body>
</html>