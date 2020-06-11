<div class="modal fade" id="mdl_padre_cantor" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" ><img src="../imagenes/cruz.png" style="width: 2em" alt="">Asignar</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">

                        <div class="form-group input-group-sm">
                            <label for="">Padre</label>
                            <select name="" id="fr_combo_padre_id" class="form-control" disabled></select>
                        </div>



                    </div>

                    <div class="col-md-6">
                        <div class="form-group input-group-sm" >
                            <label for="">Cantor</label>
                            <select name="" id="fr_combo_cantor_id" class="form-control" disabled></select>
                        </div>

                    </div>

                </div>
                <div class="row">
                    <div class="col-md-12">
                        <p style="color: #999580">NOTA : Asignación de padre y cantor para este horario. Puede cambiar el seleccionable de padre y/o cantor, posteriormente
                            de click en de <strong>grabar</strong></p>
                    </div>

                </div>

            </div>

            <div class="modal-footer">
                <button type="on" class="btn btn-success" onclick="update_padre_cantor()"><i class="fa fa-save"></i> Grabar</button>

                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
            </div>
        </div>
    </div>
</div>