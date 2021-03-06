<?php
/**
 * Created by PhpStorm.
 * User: jhonny
 * Date: 29/06/20
 * Time: 11:51 AM
 */
 require_once 'sesion.validar.vista.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Reporte misa comunitaria</title>
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
    <div class="content-wrapper" style="background-color: white">
        <!-- Content Header (Page header) -->
        <section class="content-header small">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-info">
                        <div class="box-body">
                            <form action="../controlador/reporte_misa_comunitaria_pdf.php" method="post" target="_blank">
                                <div class="row">
                                    <div class="col-xs-12 col-md-12 col-lg-4">
                                        <input type="text" style="display: none" id="user_id" name="user_name">
                                        <div class="form-group">
                                            <span style="color: #01a189">Seleccione rango de fechas: </span>
                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input type="date" class="form-control pull-right"
                                                       id="busqueda_fecha_inicial" name="busqueda_fecha_inicial"
                                                       value="<?php date_default_timezone_set("America/Lima");
                                                       echo date('Y-m-d'); ?>">
                                                <div class="input-group-addon">
                                                    -
                                                </div>
                                                <input type="date" class="form-control pull-right"
                                                       id="busqueda_fecha_final" name="busqueda_fecha_final"
                                                       value="<?php date_default_timezone_set("America/Lima");
                                                       echo date('Y-m-d'); ?>">
                                            </div>
                                            <!-- /.input group -->
                                        </div>

                                    </div>
                                    <div class="col-xs-12 col-md-12 col-lg-3">
                                        <div class="form-group">
                                            <span style="color: #01a189">Seleccione Hora (Formato 24 hrs): </span>
                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-clock-o"></i>
                                                </div>
                                                <input type="time" class="form-control pull-right"
                                                       id="busqueda_hora_inicial" name="busqueda_hora_inicial"
                                                       value="00:00" >
                                                <div class="input-group-addon">
                                                    -
                                                </div>
                                                <input type="time" class="form-control pull-right"
                                                       id="busqueda_hora_final" name="busqueda_hora_final"
                                                       value="23:59" >
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-md-12 col-lg-2">
                                        <div class="form-group">
                                            <span style="color: #01a189">Seleccione capilla: </span>
                                            <select id="busqueda_capilla_id" name="busqueda_capillaid" class="form-control">
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-md-12 col-lg-2">
                                        <div class="form-group">
                                            <span style="color: #01a189">Seleccione tipo culto: </span>
                                            <select id="busqueda_tipo_culto_id" name="busqueda_tipo_culto_id" class="form-control" disabled>
                                                <option value="0">-- Todos --</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-md-12 col-lg-1">
                                        <div class="form-group small">
                                            <label for=""></label><br>
                                            <button type="button" onclick="listado();" class="btn btn-info pull-right"><i
                                                        class="fa fa-search"></i> <strong>Buscar</strong>
                                            </button>
                                        </div>

                                    </div>
                                    <br>

                                    <div class="col-xs-12 col-md-12 col-lg-12">
                                        <span style="color: #01a189"><i class="fa fa-check"></i>Resultado de la búsqueda:
                                         <span style="color: #9d9d9d">Misa(s) comunitaria(s).</span></span>
                                        <button type="submit" class="btn btn-danger pull-right">   <i
                                                    class="fa fa-file-pdf-o"></i> <strong> &nbsp;&nbsp; PDF&nbsp;&nbsp;&nbsp;</strong>
                                        </button>
                                        <hr>
                                        <div id="lista_misas_comunitarias"></div>
                                    </div>

                                </div>
                            </form>


                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>
    <?php require_once 'menu.pie.vista.php'; ?>
</div>

<?php require_once 'scripts.vista.php'; ?>
<script src="js/validacion.js" type="text/javascript"></script>
<script src="js/reporte_misa_comunitaria.js" type="text/javascript"></script>

</body>
</html>