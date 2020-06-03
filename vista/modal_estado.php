<div class="modal fade" id="modal_estado" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" >Cambiar Estado</h4>
            </div>
            <div class="modal-body">
                <div class="row" style="display: none">
                    <div class="col-xs-3">
                        <p>
                            <input type="text" id="intencion_id" style="display:none">
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="form-group">
                            <label>Capilla</label>

                            <select name="" id="combo_estado_actualizar" class="form-control">
                                <option value="Pendiente">Pendiente</option>
                                <option value="Anulado">Anulado</option>
                                <option value="Pagado">Pagado</option>
                            </select>
                        </div>
                    </div>
                </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" aria-hidden="true" onclick="actualizar_estado();">
                    <i class="fa fa-save"></i> Actualizar
                </button>
                <button type="button" class="btn btn-default" data-dismiss="modal" id="estado_close"><i
                        class="fa fa-close"></i> Cerrar
                </button>
            </div>
        </div>
    </div>
</div>