<form action="../controlador/intencion_pdf_controlador.php" method="post" target="_blank">

    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <button type="button" class="btn btn-info
                         btn-sm pull-right" data-toggle="modal" data-target="#myModal"
                            id="nueva_reserva"><i class="fa fa-plus"></i> Nueva Reserva
                    </button>&nbsp;
                    <h5 class="box-title" style="color: #01a189">Filtrar por:</h5>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-xs-12 col-md-6 col-lg-3">
                            <div class="form-group">
                                <input type="text" style="display: none;" name="usuario"
                                       value="<?php echo $sesion_nombre_usuario; ?>">
                                <input type="text" style="display: none;" id="int_id" name="int_id">
                                <label>Fecha Inicio:</label>

                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="date" class="form-control pull-right" id="busqueda_fecha1"
                                           value="<?php date_default_timezone_set("America/Lima");
                                           echo date('Y-m-d'); ?>">
                                </div>
                                <!-- /.input group -->
                            </div>
                            <div class="form-group">
                                <label>Fecha Final:</label>

                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="date" class="form-control pull-right" id="busqueda_fecha2"
                                           value="<?php date_default_timezone_set("America/Lima");
                                           echo date('Y-m-d'); ?>">
                                </div>
                                <!-- /.input group -->
                            </div>
                        </div>

                        <div class="col-xs-12 col-md-6 col-lg-4">
                            <div class="form-group">
                                <label for="">Capilla</label>
                                <select name="" id="busqueda_capilla_id" class="form-control">
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-6 col-lg-4">
                            <div class="form-group">
                                <label for="">Celebración</label>
                                <select name="" id="busqueda_celebracion" class="form-control">
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-6 col-lg-4">
                            <div class="form-group">
                                <label for="">Hora</label>
                                <select name="" id="busqueda_estado" class="form-control">
                                    <option value="Pendiente">Pendiente</option>
                                    <option value="Anulado">Anulado</option>
                                    <option value="Pagado">Pagado</option>
                                </select>
                            </div>

                        </div>
                        <div class="col-xs-12 col-md-6 col-lg-4">
                            <div class="form-group">
                                <label for="">Tipo</label>
                                <select name="" id="busqueda_type" class="form-control">
                                    <option value="I">Individual</option>
                                    <option value="C">Comunitaria</option>
                                </select>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="button" onclick="listar_reservas()" class="btn btn-default pull-right"><i
                                class="fa fa-search-plus"></i> <strong>Buscar</strong>
                    </button>
                </div>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-default">
                <div class="box-header">
                    <span style="color: #01a189">Resultados de la búsqueda:</span>
                    <button type="submit" class="btn btn-danger pull-right"><i
                                class="fa fa-file-pdf-o"></i> <strong>PDF</strong>
                    </button>
                    <hr>
                </div>
                <div class="box-body">
                    <div id="list_reservas"></div>
                </div>
            </div>
        </div>
    </div>
</form>
