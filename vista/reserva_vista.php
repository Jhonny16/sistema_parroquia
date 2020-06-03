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
    <div class="content-wrapper" style="background-color: white" >

        <section class="content" id="content_lista_reserva">

            <?php require_once 'reserva_calendar_vista.php' ;?>
            <?php require_once 'modal_estado.php' ;?>
            <?php require_once 'modal_detalle.php' ;?>
            <?php require_once 'mdl_cliente.php' ;?>
        </section>
        <section class="content" id="content_create_reserva" style="display: none;">
            <?php require_once 'reserva_create_view.php' ;?>
        </section>

    </div>

    <?php require_once 'menu.pie.vista.php'; ?>
</div>



<?php require_once 'scripts.vista.php'; ?>

<script src="js/reserva_list.js" type="text/javascript"></script>
<script src="js/horario_calendar.js" type="text/javascript"></script>
<script src="js/reserva_create.js" type="text/javascript"></script>
<script src="js/add_cliente.js" type="text/javascript"></script>



</body>
</html> 