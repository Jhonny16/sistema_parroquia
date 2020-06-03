<?php require_once 'sesion.validar.vista.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Mantenimiento lista de precios</title>
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
        <section class="content-header">
            <h1>
                Mantenimiento lista de precios
            </h1>
            <ol class="breadcrumb">
                <button type="button" class="btn btn-success btn-sm" data-toggle="modal"
                        data-target="#mdl_lista_precios" id="btnadd_listaprecios"><i class="fa fa-plus"></i> Agregar
                </button>&nbsp;&nbsp;&nbsp;
                <li><a href="#"><i class="fa fa-dashboard"></i> Menú Principal</a></li>
                <li><a href="#">Mantenimientos</a></li>
                <li class="active">Mantenimiento lista de precios</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-default">
                        <div class="box-body">
                            <div id="lista_precios"></div>
                        </div>
                    </div>
                </div>
            </div>
            <?php require_once 'mdl_lista_precios.php'; ?>

        </section>

    </div>
    <?php require_once 'menu.pie.vista.php'; ?>
</div>

<?php require_once 'scripts.vista.php'; ?>
<script src="js/validacion.js" type="text/javascript"></script>
<script src="js/mantenimiento_lista_precios.js" type="text/javascript"></script>

</body>
</html> 