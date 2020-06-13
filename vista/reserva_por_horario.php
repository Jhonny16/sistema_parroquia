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
    <?php require_once 'menu.izquierda.vista.php'; ?>

    <div class="content-wrapper" style="background-color: white">

        <section class="content">
            <small>
                <div class="row">
                    <div class="col-md-2">
                        <div class="box box-info">
                            <div class="box-header ">
                                <span style="color: #01a189">Búsqueda por:</span>
                                <a type="button" class="btn-sm btn-info pull-right "
                                   id="btn_reservar_calendar_add" onclick="buscar_reservas();"><i
                                            class="fa fa-search-plus"></i>
                                    <strong>Buscar</strong></a>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-xs-12 col-md-12">
                                        <div class="form-group">
                                            <label for="">Fecha / hora</label>
                                            <select name="" id="busqueda_horario_id" class="form-control select2"
                                                    style="width: 100%;">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-md-12">
                                        <div class="form-group">
                                            <label for="">DNI / Cliente</label>
                                            <select name="" id="busqueda_persona_dni" class="form-control select2"
                                                    style="width: 100%;">
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-md-12">
                                        <div class="form-group">
                                            <label for="">Código de reserva</label>
                                            <select name="" id="busqueda_reserva_id" class="form-control select2"
                                                    style="width: 100%;">
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box box-info">
                            <div class="box-header ">
                                <span style="color: #01a189">¡ Ayuda !</span>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <p style="color: #999580">Dentro del resultado de la búsqueda, ud tendrá las siguientes opciones:</p>
                                <p><i class="fa fa-eye text-info"></i>&nbsp;Muestra todo el detalle de la reserva, del mismo modo
                                    se asemeja al formato de impresión</p>
                                <p><i class="fa fa-trash-o text-orange"></i>&nbsp;Al presionar este botón podrá hacer la anulación
                                de la reserva y del pago de la reserva</p>
                                <p><i class="fa fa-credit-card text-success"></i>&nbsp;Podrá realizar y completar el pago de la reserva</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-10">

                        <div class="box box-default">
                            <div class="box-header">
                                <span style="color: #01a189">Resulados de la búsqueda:</span>
                                <button type="button" class="btn btn-info pull-right" id="btn_update_padre_cantor"
                                        data-toggle="modal" data-target="#mdl_padre_cantor"
                                title="Asignación de padre y cantor"><i class="fa fa-odnoklassniki">

                                    </i> Asignar</button>

                            </div>
                            <div class="box-body">
                                <!--Lista de reservas obtenido por medio de busqueda-->
                                <div id="list_reservas_horario"></div>

                                <!--Gif de carga-->
                                <div id="load" style="text-align: center"></div>

                                <!--PDF en modo vista de la reserva-->
                                <form action="../controlador/reserva_pdf.php" method="post" target="_blank">
                                    <section class="invoice" id="formato_reserva" >
                                        <!-- title row -->
                                        <input type="text" style="display: none" id="reserva_id" name="reserva_id">
                                        <input type="text" style="display: none" id="user_name" name="user_name">
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <h2 class="page-header">
                                                    <img src="../imagenes/cruz.png" style="width: 1em" alt=""> <span id="fr_codigopago"></span>
                                                    <small class="pull-right">Fecha: <span id="fr_fecha"></span></small>
                                                </h2>
                                            </div>
                                            <!-- /.col -->
                                        </div>
                                        <!-- info row -->
                                        <div class="row invoice-info">
                                            <div class="col-sm-4 invoice-col">
                                                Capilla:
                                                <address>
                                                    <strong><span id="fr_capilla"></span></strong><br>
                                                    Cliente : <span id="fr_cliente"></span><br>
                                                    Tipo de culto : <span id="fr_tipoculto"></span><br>
                                                    <span id="fr_detalle_tipoculto"> </span><br>
                                                </address>
                                            </div>
                                            <!-- /.col -->
                                            <div class="col-sm-4 invoice-col">
                                                Ofrece(n):
                                                <address>
                                                    <strong> <span id="fr_ofrece"></span></strong><br>
                                                Horario: <span id="fr_horario"></span><br>
                                                </address>


                                            </div>
                                            <!-- /.col -->
                                            <div class="col-sm-4 invoice-col">
                                                <b># <span id="fr_codigoreserva"></span></b><br>
                                                Estado: <span id="fr_estado"></span><br>
                                                Fecha reserva: <span id="fr_fecha_hora"></span><br>


                                            </div>
                                            <!-- /.col -->
                                        </div>

                                        <div class="row">
                                            <div class="col-xs-6 table-responsive">
                                                <table class="table table-striped">
                                                    <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th id="fr_detalle_detalle">Detalle</th>
                                                        <th>Intención</th>
                                                        <th id="fr_detalle_importe">Importe</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody id="fr_detalle">

                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="col-xs-6">
                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <tr>
                                                            <th style="width:50%">Limosna:</th>
                                                            <td style="text-align: right">s/. <span id="fr_limosna"</span></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Templo</th>
                                                            <td style="text-align: right">s/. <span id="fr_templo" ></span></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Cantor</th>
                                                            <td style="text-align: right">s/. <span id="fr_cantor" ></span></td>
                                                        </tr>   <tr>
                                                            <th>Total:</th>
                                                            <td style="text-align: right">s/. <span id="fr_total" ></span></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                            <!-- /.col -->
                                        </div>

                                        <div class="row">
                                            <div class="col-xs-6">
                                                <p class="lead">Métodos de pago:</p>
                                                <img src="../util/lte/dist/img/credit/visa.png" alt="Visa">
                                                <img src="../util/lte/dist/img/credit/mastercard.png" alt="Mastercard">
                                                <img src="../util/lte/dist/img/credit/american-express.png" alt="American Express">
                                                <img src="../util/lte/dist/img/credit/paypal2.png" alt="Paypal">

                                                <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                                                    Puede realizar pagos por éstas entidades, de lo contrario puede hacer el depóstio
                                                    a la cuenta bancaria BCP : 010022525822
                                                </p>
                                            </div>

                                            <div class="col-xs-6 table-responsive">
                                                <table class="table table-striped">
                                                    <thead>
                                                    <tr>
                                                        <th>Recordamos:</th>
                                                        <th></th>
                                                        <th></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td>1. La Santa Misa es la renovación del Sacrificio de Cristo en la Cruz. Tiene un valor
                                                            espiritual infinito. Lo que por su celebración es una limosna no un pago</td>
                                                    </tr>
                                                    <tr>
                                                        <td>2. Es conveniente participantes en la Comunión Eucarística. Confiesa con anticipación.</td>
                                                    </tr>
                                                    <tr>
                                                        <td>3. No traer imágenes o cuadros de Santos a la Iglesia.</td>
                                                    </tr>

                                                    </tbody>
                                                </table>
                                            </div>

                                        </div>

                                        <div class="row no-print">
                                            <div class="col-xs-12">
                                                <button  type="submit" class="btn btn-danger pull-right" style="margin-right: 5px;">
                                                    <img src="../imagenes/pdf.png" style="width: 1.5em" alt=""> PDF
                                                </button>
                                            </div>
                                        </div>
                                    </section>


                                </form>
                            </div>
                        </div>


                    </div>
                </div>
            </small>
            <?php require_once 'modal_cambiar_padre_cantor.php'; ?>
        </section>
    </div>

    <?php require_once 'menu.pie.vista.php'; ?>
</div>


<?php require_once 'scripts.vista.php'; ?>
<script src="js/reservas_por_horario.js" type="text/javascript"></script>

</body>
</html>