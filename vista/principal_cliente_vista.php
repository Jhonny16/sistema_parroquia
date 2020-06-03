<?php require_once 'sesion.validar.vista.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Menú Pricipal</title>
    <?php require_once 'metas.vista.php'; ?>
    <?php require_once 'estilos.vista.php'; ?> <!--cargar los estilos que estas en estilos.vista.php-->
</head>
<body class="hold-transition skin-blue sidebar-mini sidebar-collapse">
<!-- Site wrapper -->
<div class="wrapper">
    <?php require_once 'menu.cabecera.vista.php'; ?> <!--carga menu.cabecera.vista.php-->
    <!-- =============================================== -->
    <!-- Left side column. contains the sidebar -->
    <?php require_once './menu.izquierda.vista.php'; ?> <!--cargar el menu.izquiera.vista.php-->
    <!-- =============================================== -->
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" style="background-color: white" >
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Bienvenido al Sistema Parroquial
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Menú Principal</a></li>
                <li><a href="#">principal</a></li>
            </ol>
        </section>
        <!-- Main content -->
        <section class="content">
            <!-- Default box -->
            <!-- /.box -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <?php require_once 'menu.pie.vista.php'; ?>
    <!-- Control Sidebar -->
    <?php require_once 'menu.derecha.vista.php'; ?>
    <!-- /.control-sidebar -->
    <!-- Add the sidebar's background. This div must be placed
         immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->
<?php require_once 'scripts.vista.php'; ?>
</body>
</html>
