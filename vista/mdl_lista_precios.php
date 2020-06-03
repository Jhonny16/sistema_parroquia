<small>
    <div class="modal fade" id="mdl_lista_precios" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="title_lista_precios">Título de la ventana</h4>
                </div>
                <div class="modal-body">
                    <form role="form">
                        <input type="text" style="display: none;" id="lp_id">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="">Capilla</label>
                                <select name="" id="lp_cb_capill_id" class="form-control">
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="">Tipo de culto</label>
                                <select name="" id="lp_cb_tipoculto_id" class="form-control">
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Fecha inicio</label>

                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="date" class="form-control pull-right" id="lp_fecha_inicio"
                                           value="<?php date_default_timezone_set("America/Lima");
                                           echo date('Y-m-d'); ?>">
                                </div>
                                <!-- /.input group -->
                            </div>
                            <div class="form-group">
                                <label>Fecha fin</label>

                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="date" class="form-control pull-right" id="lp_fecha_fin"
                                           value="<?php date_default_timezone_set("America/Lima");
                                           echo date('Y-m-d'); ?>">
                                </div>
                                <!-- /.input group -->
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Limosna S/.</label>
                                <input type="number" class="form-control" id="lp_limosna" min="0" max="100" value="0.00"
                                       onkeypress="return decimales(event);">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Templo S/.</label>
                                <input type="number" class="form-control" id="lp_templo" min="0" max="100" value="0.00"
                                       onkeypress="return decimales(event);">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Cantor S/.</label>
                                <input type="number" class="form-control" id="lp_cantor" min="0" max="100" value="0.00"
                                       onkeypress="return decimales(event);">
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Total/.</label>
                                <input type="number" class="form-control" id="lp_precio_total"  value="0.00" readonly>
                            </div>

                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" onclick="create_update()"><i class="fa fa-save"></i> Grabar
                    </button>
                    <button type="button" class="btn btn-default" data-dismiss="modal" id="lp_btn_close"><i
                                class="fa fa-close"></i> Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>
</small>