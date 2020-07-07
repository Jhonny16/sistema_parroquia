<?php require_once 'sesion.validar.vista.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Reservas</title>
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

        <section class="content">
            <div class="row">
                <div class="col-sm-4">

                    <!--                    <div class="box box-solid bg-green-gradient">-->
                    <div class="box box-solid"
                         style="background-image: linear-gradient(150deg, rgb(127, 255, 196) 150px, rgb(60,141,188) 95%);">
                        <div class="box-header">
                            <i class="fa fa-calendar"></i>

                            <h3 class="box-title" style="color: #00af84">Calendario</h3>
                            <!-- tools box -->
                            <div class="pull-right box-tools">
                                <!-- button with a dropdown -->


                            </div>
                            <!-- /. tools -->
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body no-padding">
                            <!--The calendar -->
                            <div id="calendario" style="width: 100%"></div>

                        </div>
                        <!-- /.box-body -->
                    </div>
                </div>
                <div class="col-sm-8">
                    <!--Aqui irán eventos del calendario-->
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">

                    <div class="box box-info">
                        <form id="form_dia_celebracion" action="../controlador/reporte_misa_por_dia.php" method="post"
                              target="_blank">

                            <div class="box-header with-border">
                                <span style="color: #01a189">Resultados de la búsqueda del <span id="day_title"></span> : </span>
                                <input type="text" style="display: none" id="fecha" name="fecha">
                                <input type="text" style="display: none" id="user_name" name="user_name">
                                <a type="button" class="btn btn-info pull-right"
                                   id="btn_reservar_calendar" style="display: none"
                                   onclick="horario_reservar();"><i
                                            class="fa fa-check-circle"></i>
                                    <strong>Reservar</strong></a>

                                <a class="pull-right" href="javascript:void();"
                                   onclick="document.getElementById('form_dia_celebracion').submit()">
                                    <u> <i class="fa fa-file-pdf-o text-danger"> Genera PDF</i></u></a>
                            </div>
                        </form>

                        <div class="box-body" id="reserva_lista">
                        </div>
                    </div>
                </div>

            </div>
            <?php require_once 'modal_reserva.php'; ?>
            <?php require_once 'modal_reserva_lista.php'; ?>
            <?php require_once 'mdl_cliente.php'; ?>

        </section>


    </div>

    <?php require_once 'menu.pie.vista.php'; ?>
</div>


<?php require_once 'scripts.vista.php'; ?>
<script src="js/reserva_calendar.js" type="text/javascript"></script>
<script src="js/reserva_calendar_lista.js" type="text/javascript"></script>
<script src="js/add_cliente.js" type="text/javascript"></script>

</body>
</html> 