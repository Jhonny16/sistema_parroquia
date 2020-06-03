<?php require_once 'sesion.validar.vista.php'; ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Mantenimiento de Tipo de Culto</title>
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
                        Mantenimiento Detalle Tipo Culto
                    </h1>
                    <ol class="breadcrumb">
                        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#mdl_detail_tipoculto" id="btn_add_detail"><i class="fa fa-copy"></i> Agregar
                            Detalle Tipo Culto</button>&nbsp;&nbsp;&nbsp;
                        <li><a href="#"><i class="fa fa-dashboard"></i> Menú Principal</a></li>
                        <li><a href="#">Mantenimientos</a></li>
                        <li class="active">Mantenimiento Detalle Tipo de Culto</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-default">
                                <div class="box-body">
                                    <div id="listado_detalle"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- INICIO del formulario modal -->
                    <small>
                        <form id="frm_detail_tipoculto">
                            <div class="modal fade" id="mdl_detail_tipoculto" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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

                                            <div class="row">
                                                <div class="col-xs-12">
                                                    <p>
                                                        Nombre
                                                               <input type="text"
                                                                      name="nombre_detalletc"
                                                                      id="nombre_detalletc"
                                                                      class="form-control input-sm text-bold" required="">
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-xs-12">
                                                    <p>
                                                        Descripción <input type="text"
                                                                      name="descripcion_detalletc"
                                                                        id="descripcion_detalletc"
                                                                      class="form-control input-sm text-bold" required="">
                                                    </p>
                                                </div>
                                            </div>


                                            <div class="row">
                                                <div class="col-xs-6">
                                                    <p>
                                                        Tipo Culto
                                                        <select name="combo_tipoculto" id="combo_tipoculto" class="form-control input-sm" required="">

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
        <script src="js/tipo_culto_detalle.js" type="text/javascript"></script>

    </body>
</html>