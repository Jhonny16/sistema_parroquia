<div class="row">
    <div class="col-xs-12">
        <div class="box box-info">
            <div class="box-header with-border">
                <h5 class="box-title" style="color: #01a189">ASIGNACION DE PERSONAL
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <span class="pull-right-container"></span>
                </h5>

            </div>
            <div class="box-body">

                <div class="row">
                    <div class="col-xs-12 col-lg-5">
                        <div class="box box-default">
                            <div class="box-header with-border">
                                <h5 class="box-title" >Datos:
                                </h5>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <form role="form">
                                    <input type="text" id="usuario_id" style="display: none">

                                    <div class="form-group col-xs-12">
                                        <br>
                                        <label for="inputPassword3">Persona</label>
                                        <select name="" id="combo_persona" class="form-control">

                                        </select>
                                    </div>
                                    <div class="form-group col-xs-12" >
                                        <br>
                                        <label for="exampleInputPassword1">Seleccione Capilla(s)</label>
                                        <select id="combo_capillas" class="form-control input-sm select2"
                                                data-placeholder="Campo multi-selector"
                                                multiple="multiple" style="width: 100%;">
                                        </select>
                                    </div>
                                </form>
                            </div>
                            <div class="box-footer ">
                                <div class="col-xs-12">
                                    <button type="button" class="btn btn-success" onclick="add_asignacion()">
                                        Guardar
                                    </button>
                                    <button type="button" class="btn btn-warning pull-right" onclick="limpiar()">
                                        Limpiar
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-lg-7">
                        <div class="box box-warning">
                            <div class="box-header with-border"> <h5 class="box-title" >
                                    Lista de Personal con capillas asignadas:
                                </h5>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <div class="col-lg-12"  id="listado_asignacion"></div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
