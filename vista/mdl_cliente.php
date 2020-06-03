<form id="frm_save_cliente">
    <div class="modal modal-primary fade" id="mdl_cliente" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <h4 class="modal-title" id="titulomodal">NUEVO CLIENTE</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-6">
                            <p>
                                DNI
                                <input type="text"
                                       name="txtDNI"
                                       id="txtDNI"
                                       class="form-control input-sm text-bold" required="">
                            </p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12">
                            <p>
                                Apellido Paterno
                                <input type="text"
                                       name="txtApellidoPaterno"
                                       id="txtApellidoPaterno"
                                       class="form-control input-sm text-bold" required="">
                            </p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12">
                            <p>
                                Apellido Materno
                                <input type="text"
                                       name="txtApellidoMaterno"
                                       id="txtApellidoMaterno"
                                       class="form-control input-sm text-bold" required="">
                            </p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12">
                            <p>
                                Nombres
                                <input type="text"
                                       name="txtNombre"
                                       id="txtNombre"
                                       class="form-control input-sm text-bold" required="">
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <p>
                                Dirección <input type="text"
                                                 name="txtDireccion"
                                                 id="txtDireccion"
                                                 class="form-control input-sm text-bold" required="">
                            </p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12">
                            <p>
                                Correo Electronico <input type="email"
                                                          name="txtEmail"
                                                          id="txtEmail"
                                                          class="form-control input-sm text-bold"
                                                          required />
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <p>
                                Celular <input type="number"
                                               maxlength="9"
                                               id="celular"
                                               class="form-control input-sm text-bold"
                                               required="">
                            </p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-6">
                            <p>
                                Ocupación
                                <select name="cboOcupacion"
                                        id="cboOcupacion"
                                        class="form-control input-sm" required="">

                                </select>
                            </p>
                        </div>
                        <div class="col-xs-6">
                            <p>
                                Cargo
                                <select name="cboCargo"
                                        id="cboCargo"
                                        class="form-control input-sm" required="" >
                                </select>
                            </p>
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" aria-hidden="true"><i
                            class="fa fa-save"></i> Grabar
                    </button>
                    <button type="button" class="btn btn-default" data-dismiss="modal" id="close_mld_cliente"><i
                            class="fa fa-close"></i> Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>