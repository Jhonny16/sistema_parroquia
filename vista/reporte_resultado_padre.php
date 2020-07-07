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
    <title>Reporte general padres</title>
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
                            <form method="post" target="_blank">
                                <div class="row">

                                    <div class="col-xs-12 col-md-12 col-lg-4">
                                        <div class="form-group">
                                            <span style="color: #01a189">Seleccione capilla: </span>
                                            <select id="busqueda_capilla_id" name="busqueda_capilla_id" class="form-control">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-md-12 col-lg-2">
                                        <div class="form-group">
                                            <span style="color: #01a189">Seleccione año: </span>
                                            <select id="busqueda_anio" name="busqueda_anio" class="form-control" >
                                                <option value="2020"> 2020 </option>
                                                <option value="2021"> 2021 </option>
                                                <option value="2022"> 2022 </option>
                                                <option value="2023"> 2023 </option>
                                                <option value="2024"> 2024 </option>
                                                <option value="2025"> 2025 </option>
                                                <option value="2026"> 2026 </option>
                                                <option value="2027"> 2027 </option>
                                                <option value="2028"> 2028 </option>
                                                <option value="2029"> 2029 </option>
                                                <option value="2030"> 2030 </option>

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
                                </div>
                                <div class="row">
                                    <br>
                                    <div class="col-xs-12 col-md-12 col-lg-12">
                                        <span style="color: #01a189"><i class="fa fa-check"></i>Resultado de la búsqueda:
                                        <span style="color: #9d9d9d">Limosnas y número de misas.</span></span>
<!--                                        <button type="submit" class="btn btn-danger pull-right">   <i-->
<!--                                                    class="fa fa-file-pdf-o"></i> <strong> &nbsp;&nbsp; PDF&nbsp;&nbsp;&nbsp;</strong>-->
<!--                                        </button>-->
                                        <hr>
                                        <div id="lista_limosnas"></div>
                                        <div id="lista_misas"></div>
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
<script src="js/reporte_resultado_padres.js" type="text/javascript"></script>

</body>
</html>