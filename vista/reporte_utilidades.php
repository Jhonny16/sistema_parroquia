<?php require_once 'sesion.validar.vista.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Reporte Utilidades</title>
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
                Reporte Utilidades
            </h1>
            <ol class="breadcrumb">

                <li><a href="#"><i class="fa fa-dashboard"></i> Menú Principal</a></li>
                <li><a href="#">Reportes</a></li>
                <li class="active">Utilidades</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <form action="../controlador/capilla_utilidades_pdf_controlador.php" method="post" target="_blank">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-info">
                            <div class="box-header with-border">
                                <h5 class="box-title" style="color: #01a189">Filtrar por:</h5>
                                <input type="text" style="display: none;" name="usuario"
                                       value="<?php echo $sesion_nombre_usuario; ?>">
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-xs-12 col-md-12 col-lg-4">
                                        <div class="form-group">
                                            <label>Fecha Inicio:</label>

                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input type="date" class="form-control pull-right"
                                                       id="busqueda_fecha_incial" name="fecha_inicio"
                                                       value="<?php date_default_timezone_set("America/Lima");
                                                       echo date('Y-m-d'); ?>">
                                            </div>
                                            <!-- /.input group -->
                                        </div>

                                    </div>
                                    <div class="col-xs-12 col-md-12 col-lg-4">
                                        <div class="form-group">
                                            <label>Fecha Final:</label>

                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input type="date" class="form-control pull-right"
                                                       id="busqueda_fecha_final" name="fecha_fin"
                                                       value="<?php date_default_timezone_set("America/Lima");
                                                       echo date('Y-m-d'); ?>">
                                            </div>
                                            <!-- /.input group -->
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-md-12 col-lg-4">
                                        <div class="form-group">
                                            <label for="">Capilla</label>
                                            <select id="busqueda_capilla" name="capilla" class="form-control">
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="box-footer">
                                <button type="button" onclick="listar_utilidades()" class="btn btn-default pull-right"><i
                                            class="fa fa-eye"></i> <strong> Vista Previa</strong>
                                </button>
                                <button type="submit"  class="btn btn-danger pull-right"><i
                                            class="fa fa-file-pdf-o"></i> <strong>Expotar PDF</strong>
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
            </form>
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-default">
                        <div class="box-header">
                            <span style="color: #01a189">Resulados de la búsqueda:</span>
                        </div>
                        <div class="box-body">
                            <div id="list_utilidades"></div>
                        </div>
                    </div>
                </div>
            </div>

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

<script src="js/capilla_reporte_vista.js" type="text/javascript"></script>

</body>
</html> 