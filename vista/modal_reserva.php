<small>
    <div class="modal fade" id="modal_reserva_calendar" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" ><img src="../imagenes/cruz.png" style="width: 2em" alt=""><span id="title_reserva_calendar">Título de la ventana</span></h4>
                </div>
                <div class="modal-body">
                    <form role="form">
                        <div class="box-body">
                            <!--ID del horario-->
                            <input type="text" class="form-control" id="horario_id" style="display: none">

                            <!--Fecha de hoy-->
                            <input type="date" id="date_hoy" style="display: none"
                                   value="<?php date_default_timezone_set("America/Lima");
                                   echo date('Y-m-d'); ?>">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group input-group-sm">
                                        <label for="">Capilla</label>
                                        <select name="" id="combo_capilla_id" class="form-control" disabled=""></select>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group input-group-sm">
                                                <label for="ads">Fecha</label>
                                                <input type="text" class="form-control" id="fecha_ref" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group input-group-sm"><label for="e">Hora</label>
                                                <input type="text" class="form-control" id="hora_ref" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group input-group-sm">
                                        <label for="">Cliente</label>
                                        <select name="" id="combo_cliente_id" class="form-control"></select>
                                    </div>

                                </div>


                            </div>
                            <div class="row">
                                <hr style="color:#00ad9c;background: #00ad9c">
                                <div class="col-md-3">
                                    <div class="form-group input-group-sm" >
                                        <label for="">Tipo</label>
                                        <select name="" id="combo_detail" class="form-control">
                                            <option value="-" selected>Seleccione detalle tipo de culto</option>
                                            <option value="Salud">Salud</option>
                                            <option value="Difunto">Difunto</option>
                                        </select>
                                    </div>

                                </div>
                                <div class="col-md-3">
                                    <div class="form-group input-group-sm">
                                        <label for="" style="color: #00ad9c">
                                            <input type="checkbox" class="minimal" id="aprobacion"> Aprobar precio
                                        </label>

                                        <div class="input-group input-group-sm">
                                            <span class="input-group-addon" style="color: #00ad9c">S/. </span>
                                            <input type="number" class="form-control" id="precio" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="" style="color: #00ad9c">Dirigido a:</label>
                                        <div class="input-group input-group-sm">
                                            <input type="text" class="form-control" id="dirigido">
                                            <span class="input-group-btn">
                                          <button type="button" class="btn btn-block btn-default pull-right"
                                                  onclick="plus_add()"><i class="fa fa-plus text-blue"></i>
                                              <span style="color: #00ad9c">Añadir</span>
                                            </button>
                                        </span>
                                        </div>
                                    </div>

                                </div>


                            </div>
                            <div class="row">

                                <div class="col-md-12">
                                    <table class="table table-condensed">
                                        <thead>
                                        <tr>
                                            <th>Quitar</th>
                                            <th>Intención</th>
                                            <th>Detalle</th>
                                            <th>Precio</th>
                                        </tr>
                                        </thead>
                                        <tbody id="detalle">

                                        </tbody>
                                        <thead>
                                        <tr style="background: #A5DC86">
                                            <td></td>
                                            <td></td>
                                            <td style="text-align: left">Total</td>
                                            <td style="text-align: right"><strong>S/. <span id="total">0.00</span></strong></td>
                                        </tr>
                                        </thead>
                                    </table>

                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <label  style="color: #00ad9c">Ofrece(n)</label>
                                        <textarea class="form-control" rows="3"
                                                  placeholder=""
                                                  id="ofrece" disabled></textarea>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group input-group-sm">
                                        <label for="" style="color: #00ad9c">Estado pago</label>
                                        <select name="" id="combo_estado" class="form-control">
                                            <option value="Pendiente">Pendiente</option>
                                            <option value="Pagado">Pagado</option>
                                        </select>
                                    </div>
                                </div>
                            </div>


                        </div>

                    </form>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" onclick="create_reserva()"><i class="fa fa-save"></i> Grabar</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal" id=""><i class="fa fa-close"></i> Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</small>