<?php require_once 'sesion.validar.vista.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Asignación</title>
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

        <section class="content" >
            <?php
            require_once 'persona_asignacion_vistar.php';
            require_once 'modal_detalle_capillas.php';
            ?>
        </section>
    </div>

    <?php require_once 'menu.pie.vista.php'; ?>
</div>



<?php require_once 'scripts.vista.php'; ?>

<script src="js/asignacion.js" type="text/javascript"></script>

</body>
</html>