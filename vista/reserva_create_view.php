<div class="row">
    <!-- left column -->
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Nueva Reserva</h3>
            </div>
            <form role="form">
                <div class="box-body">
                    <div class="row">
                        <div class="col-xs-6">
                            <input type="date" class="form-control pull-right" id="date_hoy" style="display: none"
                                   value="<?php date_default_timezone_set("America/Lima");
                                   echo date('Y-m-d'); ?>">

                            <div class="form-group">
                                <label for="">Padre</label>
                                <select name="" id="combo_padre_id" class="form-control"></select>
                            </div>
                            <div class="form-group">
                                <label for="">Cantor</label>
                                <select name="" id="combo_cantor_id" class="form-control"></select>
                            </div>

                            <div class="form-group">
                                <label for="">Cliente</label>
                                <select name="" id="combo_cliente_id" class="form-control"></select>
                            </div>
                            <div class="form-group">
                                <label for="">Dirigido a:</label>
                                <input type="text" class="form-control" id="dirigido">
                            </div>
                            <div class="row">
                                <div class="col-xs-9">
                                    <div class="form-group">
                                        <label for="">Estado</label>
                                        <select name="" id="combo_estado" class="form-control">
                                            <option value="Pendiente" selected>Pendiente</option>
                                            <option value="Pagado">Pagado</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-3">
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
                            <input type="text" class="form-control" id="horario_id" style="display: none">
                            <input type="text" class="form-control" id="type" style="display: none">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">Capilla</label>
                                        <select name="" id="combo_capilla_id" class="form-control" disabled=""></select>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Tipo Culto</label>
                                        <select name="" id="combo_tipoculto_id" class="form-control"
                                                disabled=""></select>
                                    </div> 
                                    
                                    <div class="form-group" id="tipo_culto_misa_comunitaria">
                                        <label for="">Tipo</label>
                                        <select name="" id="combo_detail" class="form-control">
                                            <option value="Salud">Salud</option>
                                            <option value="Difunto">Difunto</option>
                                        </select>
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
                                <div class="col-md-6" id="div_aprobar_precio_res">
                                    <div class="form-group">
                                        <label>
                                            <input type="checkbox" class="minimal" id="aprobacion"> Aprobar Precio
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="box-footer">
                    <button type="button" class="btn btn-primary pull-right" onclick="save_reserva()"><i
                                class="fa fa-save"></i> Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>