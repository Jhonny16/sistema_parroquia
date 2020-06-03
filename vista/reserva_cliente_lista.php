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
    <title>Lista Reservas</title>
    <?php require_once 'metas.vista.php'; ?>
    <?php require_once 'estilos.vista.php'; ?>
</head>
<body class="hold-transition skin-blue sidebar-mini sidebar-collapse">
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
                            <h5 class="box-title" style="color: #01a189">HISTORIAL DE RESERVAS
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <span class="pull-right-container"></span>
                            </h5>

                        </div>
                        <div class="box-body">

                            <div class="row">
                                <div class="col-xs-12 col-lg-12">
                                    <form  method="post" target="_blank">

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="box box-default">
                                                    <div class="box-header with-border">
                                                        <h5 class="box-title" style="color: #01a189">Filtrar por:</h5>
                                                    </div>
                                                    <!-- /.box-header -->
                                                    <div class="box-body">
                                                        <div class="row">
                                                            <div class="col-lg-3"></div>
                                                            <div class="col-lg-3">
                                                                <div class="form-group">
                                                                    <input type="text" style="display: none;" name="usuario"
                                                                           value="<?php echo $sesion_nombre_usuario; ?>">
                                                                    <input type="text" style="display: none;" id="int_id" name="int_id">
                                                                    <label>Fecha Inicio:</label>

                                                                    <div class="input-group date">
                                                                        <div class="input-group-addon">
                                                                            <i class="fa fa-calendar"></i>
                                                                        </div>
                                                                        <input type="date" class="form-control pull-right" id="busqueda_fecha1"
                                                                               value="2019-01-01">
                                                                    </div>
                                                                    <!-- /.input group -->
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <div class="form-group">
                                                                    <label>Fecha Final:</label>

                                                                    <div class="input-group date">
                                                                        <div class="input-group-addon">
                                                                            <i class="fa fa-calendar"></i>
                                                                        </div>
                                                                        <input type="date" class="form-control pull-right" id="busqueda_fecha2"
                                                                               value="<?php date_default_timezone_set("America/Lima");
                                                                               echo date('Y-m-d'); ?>">
                                                                    </div>
                                                                    <!-- /.input group -->
                                                                </div>

                                                            </div>
                                                            <div class="col-lg-3"></div>
                                                        </div>
                                                    </div>
                                                    <div class="box-footer">
                                                        <button type="button" onclick="listar_reservas()" class="btn btn-default pull-right"><i
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
                                                        <span style="color: #01a189">Resultados de la búsqueda:</span>
                                                        <hr>
                                                    </div>
                                                    <div class="box-body">
                                                        <div id="list_reservas"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
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

<script src="js/reserva_lista_por_cliente.js" type="text/javascript"></script>



</body>
</html>