<form action="../controlador/intencion_pdf_controlador.php" method="post" target="_blank">

    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <button type="submit" class="btn btn-danger pull-right"><i
                                class="fa fa-file-pdf-o"></i> <strong>PDF</strong>
                    </button>
                    <a type="button" id="btn_save" class="btn btn-info pull-right" style="display: none"
                       onclick="save_reserv()">
                        <i class="fa fa-edit"></i><strong>GUARDAR</strong></a>
                    <a type="button" id="btn_clear" class="btn btn-warning pull-right"
                       onclick="clear_reserv()">
                        <i class="fa fa-paint-brush"></i>&nbsp;<strong>LIMPIAR</strong></a>

                    <h5 class="box-title" style="color: #01a189">RESERVAS:
                        &nbsp;&nbsp;&nbsp;&nbsp;<span class="pull-right-container">
                                  <small class="label pull-right bg-green">Disponible</small>
                                  <small class="label pull-right bg-red-gradient">Ocupado</small>
                            </span>
                    </h5>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-5">
                            <div id="calendar" style="height: 500px; width: 400px">

                            </div>
                        </div>
                    </div>


                    <div class="col-md-7">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Nueva Reserva</h3>
                            </div>
                            <form role="form">
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <input type="text" style="display: none;" name="usuario"
                                                   value="<?php echo $sesion_nombre_usuario; ?>">
                                            <input type="text" style="display: none" id="reserva_id" name="reserva_id">
                                            <input type="date" class="form-control pull-right" id="date_hoy"
                                                   style="display: none"
                                                   value="<?php date_default_timezone_set("America/Lima");
                                                   echo date('Y-m-d'); ?>">

                                            <div class="form-group">
                                                <label for="">Padre</label>
                                                <select name="" id="combo_padre_id" class="form-control"
                                                        disabled></select>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Cantor</label>
                                                <select name="" id="combo_cantor_id" class="form-control"
                                                        disabled></select>
                                            </div>

                                            <div class="form-group">
                                                <p><label for="">Cliente</label>
                                                    <button type="button" class="btn btn-info btn-xs pull-right"
                                                            onclick="nuevo_cliente()"
                                                            data-toggle="modal" data-target="#mdl_cliente"
                                                            title="Agergar Cliente"><i class="fa fa-user-plus"></i>
                                                        Nuevo Cliente
                                                    </button>
                                                </p>
                                                <select name="" id="combo_cliente_id" class="form-control"
                                                        disabled></select>
                                            </div>


                                            <div class="form-group">
                                                <label for="">Dirigido a:</label>
                                                <input type="text" class="form-control" id="dirigido"
                                                       disabled>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-7">
                                                    <div class="form-group">
                                                        <label for="">Estado</label>
                                                        <select name="" id="combo_estado" class="form-control"
                                                                disabled>
                                                            <option value="Pendiente" selected>Pendiente</option>
                                                            <option value="Pagado">Pagado</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-xs-5">
                                                    <br>
                                                    <button type="button" class="btn btn-block btn-warning pull-right"
                                                            onclick="plus_add()"><i class="fa fa-plus"></i> Agregar
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="col-xs-12">
                                                <table class="table table-condensed">
                                                    <thead>
                                                    <tr>
                                                        <th>Quitar</th>
                                                        <th>#</th>
                                                        <th>Ofrece</th>
                                                        <th>Costo</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody id="detalle">

                                                    </tbody>
                                                    <thead>
                                                    <tr>
                                                        <td colspan="3" style="text-align: center">Total</td>
                                                        <td><span id="total">0.00</span></td>
                                                    </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="col-xs-6">
                                            <input type="text" class="form-control" id="horario_id"
                                                   style="display: none">
                                            <input type="text" class="form-control" id="type" style="display: none">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="">Capilla</label>
                                                        <select name="" id="combo_capilla_id" class="form-control"
                                                                disabled=""></select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">Tipo Culto</label>
                                                        <select name="" id="combo_tipoculto_id" class="form-control"
                                                                disabled=""></select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">Detalle de Tipo Culto</label>
                                                        <select name="" id="combo_detail_id" class="form-control"
                                                                disabled=""></select>
                                                    </div>

                                                </div>

                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="ads">Fecha</label>
                                                        <input type="text" class="form-control" id="fecha_ref" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group"><label for="e">Hora</label>
                                                        <input type="text" class="form-control" id="hora_ref" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="">Precio</label>
                                                        <input type="number" class="form-control" id="precio" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-6" id="div_aprobar_precio">
                                                    <div class="form-group">
                                                        <label>
                                                            <input type="checkbox" class="minimal" id="aprobacion">
                                                            Aprobar Precio
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>Ofrece(n)</label>
                                                        <textarea class="form-control" rows="3" placeholder=""
                                                                  id="ofrece" disabled></textarea>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="box-footer">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
            <div class="box-footer">
            </div>

        </div>
    </div>
    </div>

</form>
