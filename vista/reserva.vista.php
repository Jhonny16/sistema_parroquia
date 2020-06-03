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
                        Reservas
                    </h1>
                    <ol class="breadcrumb">
                        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal_reserva" id="btn_reserva_add"><i class="fa fa-plus"></i> Nuevo </button>&nbsp;&nbsp;&nbsp;
                        <li><a href="#"><i class="fa fa-dashboard"></i> Menú Principal</a></li>
                        <li><a href="#">Operacion</a></li>
                        <li class="active">Reserva</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-default">
                                <div class="box-body">
                                    <div id="listado_reserva"></div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- INICIO del formulario modal -->
                    <small>
                        <form id="frmgrabar">
                            <div class="modal fade" id="modal_reserva" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="titulomodal">Título de la ventana</h4>
                                            <input type="text" style="display: none" id="operation">
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-xs-6">
                                                    <label>Fecha:&nbsp;</label>
                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <span class="text-blue"><i class="fa fa-calendar"></i></span>
                                                        </div>
                                                        <input type="date" id="txt_fecha" class="form-control input-sm" value="<?php date_default_timezone_set("America/Mexico_City");echo date('Y-m-d'); ?>"/>
                                                    </div><!-- /.input group -->
                                                </div>
                                                <div class="col-xs-6">
                                                    <label>Hora:&nbsp;</label>
                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <span class="text-blue"><i class="fa fa-clock-o"></i></span>
                                                        </div>
                                                        <input type="time" id="txt_hora" class="form-control input-sm"/>
                                                    </div><!-- /.input group -->
                                                </div>

                                            </div>
                                            <div class="row">
                                                <div class="col-xs-6">
                                                    <label for="x">Cliente:</label>
                                                    <input type="text"  id="txt_cliente"
                                                                  class="form-control input-sm text-bold" >
                                                </div>
                                                <div class="col-xs-6">
                                                    <label for="y">Culto:</label>
                                                    <select id="combo_culto" class="form-control"></select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-3">
                                                    <label for="x">Costo:</label>
                                                    <input type="number" min="1"  id="txt_costo"
                                                           class="form-control input-sm text-bold" >
                                                </div>
                                                <div class="col-xs-9">
                                                    <label for="x">Intención:</label>
                                                    <input type="text"  id="txt_intencion"
                                                           class="form-control input-sm text-bold" >
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-9"></div>
                                                <div class="col-xs-3">
                                                    <br>
                                                    <button type="button" class="btn btn-block btn-default pull-right"
                                                            id="btn_plus"> Agregar</button>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-12">

                                                    <table class="table table-condensed">
                                                        <thead>
                                                        <tr>
                                                            <th>Quitar</th>
                                                            <th>#</th>
                                                            <th>Intención</th>
                                                            <th>Ofrece</th>
                                                            <th>Costo</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody id="detalle">

                                                        </tbody>
                                                        <thead>
                                                            <tr>
                                                                <td colspan="4" style="text-align: center">Total</td>
                                                                <td><span id="total">0.00</span></td>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                            </div>

                                                                                        
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-success" aria-hidden="true" onclick="save_reserva()"><i class="fa fa-save" ></i> Guardar</button>
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
        <script src="js/reserva_create.js" type="text/javascript"></script>
        <script src="js/reserva_list.js" type="text/javascript"></script>

    </body>
</html> 