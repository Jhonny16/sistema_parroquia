<?php require_once 'sesion.validar.vista.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Programación de Horarios</title>
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
                Programación de Horarios
            </h1>
            <ol class="breadcrumb">

                <li><a href="#"><i class="fa fa-dashboard"></i> Menú Principal</a></li>
                <li><a href="#">Horarios</a></li>
                <li class="active">Programación de Horarios</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">

            <div class="row">
                <div class="col-md-12">
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <button type="button" class="btn btn-info
                         btn-sm pull-right" data-toggle="modal" data-target="#myModal"
                                    id="agregar_horario"><i class="fa fa-plus"></i> Nuevo Horario
                            </button>&nbsp;
                            <h5 class="box-title" style="color: #01a189">Filtrar por:</h5>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-xs-12 col-md-6 col-lg-3">
                                    <div class="form-group">
                                        <label>Fecha Inicio:</label>

                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="date" class="form-control pull-right" id="busqueda_date1"
                                                   value="<?php date_default_timezone_set("America/Lima");
                                                   echo date('Y-m-d'); ?>">
                                        </div>
                                        <!-- /.input group -->
                                    </div>
                                    <div class="form-group">
                                        <label>Fecha Final:</label>

                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="date" class="form-control pull-right" id="busqueda_date2"
                                                   value="<?php date_default_timezone_set("America/Lima");
                                                   echo date('Y-m-d'); ?>">
                                        </div>
                                        <!-- /.input group -->
                                    </div>
                                </div>

                                <div class="col-xs-12 col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label for="">Capilla</label>
                                        <select name="" id="busqueda_capilla" class="form-control">
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label for="">Tipo de Culto</label>
                                        <select name="" id="busqueda_tipoculto" class="form-control">
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label for="">Hora</label>
                                        <select name="" id="busqueda_hora" class="form-control">
                                        </select>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="button" onclick="listar()" class="btn btn-default pull-right"><i
                                        class="fa fa-search-plus"></i> <strong>Buscar</strong>
                            </button>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-default">
                        <div class="box-header">
                            <span style="color: #01a189">Resulados de la búsqueda:</span>
                            &nbsp;&nbsp;&nbsp;
                            <a type="button" class="btn btn-warning pull-right" onclick="anular();"><i
                                        class="fa fa-minus-circle"></i>
                                <strong>Anular</strong></a>
                            <a type="button" class="btn btn-danger pull-right" onclick="eliminar()"><i
                                        class="fa fa-remove"></i>
                                <strong>Eliminar</strong></a>
                            <hr>
                        </div>
                        <div class="box-body">
                            <div id="list_horarios"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- INICIO del formulario modal -->
            <small>
                <form id="frmgrabar">
                    <div class="modal fade" id="myModal" role="dialog" aria-labelledby="myModalLabel"
                         aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                        &times;
                                    </button>
                                    <h4 class="modal-title" id="titulomodal">Título de la ventana</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row" style="display: none">
                                        <div class="col-xs-3">
                                            <p>
                                                <input type="hidden" value="" id="operation" name="operation">
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
                                            <div class="form-group">
                                                <label>Capilla</label>

                                                <select name="" id="combo_capilla" class="form-control">

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="form-group">
                                                <label>Tipo Culto</label>

                                                <select name="" id="combo_tipoculto" class="form-control">

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <div class="form-group">
                                                <label>Fecha Inicio:</label>

                                                <div class="input-group date">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                    </div>
                                                    <input type="date" class="form-control pull-right"
                                                           id="date_inicial">
                                                </div>
                                                <!-- /.input group -->
                                            </div>
                                        </div>
                                        <div class="col-xs-6">
                                            <div class="form-group">
                                                <label>Fecha Final:</label>

                                                <div class="input-group date">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                    </div>
                                                    <input type="date" class="form-control pull-right" id="date_final">
                                                </div>
                                                <!-- /.input group -->
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">

                                        <div class="col-xs-12">
                                            <p>
                                                HORA
                                                <select id="combo_hora" class="form-control input-sm select2"
                                                        multiple="multiple" style="width: 100%;">
                                                </select>
                                            </p>
                                        </div>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-success" aria-hidden="true" onclick="save();">
                                        <i class="fa fa-save"></i> Grabar
                                    </button>
                                    <button type="button" class="btn btn-default" data-dismiss="modal" id="btncerrar"><i
                                                class="fa fa-close"></i> Cerrar
                                    </button>
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



    <!-- Control Sidebar -->

    <!-- /.control-sidebar -->
    <?php require_once 'menu.pie.vista.php'; ?>
</div>
<!-- ./wrapper -->

<?php require_once 'scripts.vista.php'; ?>

<!-- Scripts para mantenimiento -->

<script src="js/horario.js" type="text/javascript"></script>
<script src="js/horario_list.js" type="text/javascript"></script>

</body>
</html> 