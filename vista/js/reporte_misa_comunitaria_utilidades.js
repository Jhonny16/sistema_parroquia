$(document).ready(function () {
    cargarCapillaId("#busqueda_capilla_id");
    $("#user_id").val($("#sesion_user_name").val());
    cargarSecretario("#busqueda_secretario_id");

});

function cargarCapillaId(p_nombreCombo) {
    $("#lp_cb_capill_id").html("");

    var parroquia_id = $("#sesion_parroquia_id").val();
    var rol_id = $("#sesion_rol_id").val();
    var data = {'parroquia': parroquia_id, 'rol_id' : rol_id};

    $.ajax({
        data: data,
        url: "../controlador/capillas_por_parroquia.php",
        type: "post",
        success: function (resultado) {
            if (resultado.estado === 200) {
                var html = "";
                html += '<option value="0" >--Todas--</option>';

                var sw=0;
                $.each(resultado.datos, function (i, item) {
                    console.log(item.is_parroquia)
                    if (item.is_parroquia == true){
                        html += '<option value="' + item.cap_id + '">' + item.cap_nombre + '</option>';

                    }else{
                        console.log(item.cap_id)
                        console.log($("#sesion_capilla_id").val());
                        if (item.cap_id == parseInt($("#sesion_capilla_id").val())){
                            sw=1;
                            html += '<option value="' + item.cap_id + '" selected>' + item.cap_nombre + '</option>';


                        }

                    }
                });
                if (sw==1){
                    $(p_nombreCombo).attr('disabled','disabled');
                     $("#busqueda_tipo_culto_id").removeAttr('disabled');
                     cargarTipoCultoId(parseInt($("#sesion_capilla_id").val()))
                }

                $(p_nombreCombo).html(html);
            } else {
                swal("Mensaje del sistema", resultado.mensaje, "warning");
            }


        },
        error: function (error) {
            console.log(error);
            var datosJSON = $.parseJSON(error.responseText);
            swal("Error", datosJSON.mensaje, "error");
        }
    });
}

function cargarSecretario(p_nombreCombo){

    $.ajax({
        data: {},
        url: "../controlador/secretario_listar_controlador.php",
        type: "post",
        success: function (resultado) {
            if (resultado.estado === 200) {
                var html = "";
                html += '<option value="0" selected>--Todos--</option>';

                $.each(resultado.datos, function (i, item) {
                        html += '<option value="' + item.usu_id + '" >' + item.secretario + '</option>';
                });
                $(p_nombreCombo).html(html);
            } else {
                swal("Mensaje del sistema", resultado.mensaje, "warning");
            }


        },
        error: function (error) {
            console.log(error);
            var datosJSON = $.parseJSON(error.responseText);
            swal("Error", datosJSON.mensaje, "error");
        }
    });
}
$("#busqueda_capilla_id").change(function(){
    var cap_id = $(this).val();
    cargarTipoCultoId(cap_id);

    $("#busqueda_tipo_culto_id").removeAttr('disabled')
});


function cargarTipoCultoId(capilla_id) {
    $("#lp_cb_capill_id").html("");


    var data = {'capilla_id': capilla_id};

    $.ajax({
        data: data,
        url: "../controlador/find_type_cult_controller.php",
        type: "post",
        success: function (resultado) {
            if (resultado.estado === 200) {
                var html = "";
                html += '<option value="0">-- Todos --</option>';

                $.each(resultado.datos, function (i, item) {
                    html += '<option value="' + item.det_id + '">' + item.det_nombre+ '</option>';
                });

                $("#busqueda_tipo_culto_id").html(html);
            } else {
                var html = "";
                html += '<option value="0">-- Todos --</option>';

                $("#busqueda_tipo_culto_id").html(html);
                $("#busqueda_tipo_culto_id").attr('disabled','disabled');
            }


        },
        error: function (error) {
            console.log(error);
            var datosJSON = $.parseJSON(error.responseText);
            swal("Error", datosJSON.mensaje, "error");
        }
    });
}


function listado(){


    var data = {
        'fecha_inicial': $("#busqueda_fecha_inicial").val(),
        'fecha_final': $("#busqueda_fecha_final").val(),
        'hora_inicial': $("#busqueda_hora_inicial").val(),
        'hora_final': $("#busqueda_hora_final").val(),
        'capilla_id': $("#busqueda_capilla_id").val(),
        'tipo_culto': 'C',
        'tipoculto_id': $("#busqueda_tipo_culto_id").val(),
        'secretario_id': $("#busqueda_secretario_id").val(),
        'estado': $("#busqueda_estado").val(),

    };

    console.log(data);
    $.ajax({
        data: data,
        url: "../controlador/reporte_misa_comunitaria_utilidades_vista.php",
        type: "post",
        success: function (resultado) {
            console.log(resultado);
            var datosJSON = resultado;
            if (datosJSON.estado === 200) {
                list_horarios_reservas = resultado.datos;
                $("#lista_misas_comunitarias_utilidades").html("");

                var html = "";
                html += '<table id="table_lista_misas_comunitarias_utilidades" class="table table-bordered table-hover">' +
                    '<thead>' +
                    '<tr style="background-color: #01a189; color: white">' +
                    '<th  style="text-align: center; color: #00c0ef">#.</th>' +
                    '<th>Fecha</th>' +
                    '<th>Hora</th>' +
                    '<th>Nombres y apellidos</th>' +
                    '<th>Culto</th>' +
                    '<th>Documento</th>' +
                    '<th>Recibo</th>' +
                    '<th>Estado</th>' +
                    '<th>Importe</th>' +
                    '</tr>' +
                    '</thead>' +
                    '<tbody>';
                var suma = 0;
                $.each(datosJSON.datos, function (i, item) {
                    html += '<tr>';

                    html += '<td>' + (i+1) + '</td>';
                    html += '<td>' + item.fecha + '</td>';
                    html += '<td>' + item.hora_hora + '</td>';
                    html += '<td>' + item.dirigido + '</td>';
                    html += '<td>' + item.tipoculto_detalle + '</td>';
                    html += '<td>' + item.reserva + '</td>';
                    html += '<td>' + item.pago + '</td>';
                    suma = suma + parseFloat(item.importe);
                    html += '<td>' + item.estado + '</td>';
                    html += '<td style="text-align: right">s/. ' + item.importe + '</td>';
                    html += '</tr>';

                });
                html += '</tbody>';
                html += '<tfoot>';
                html += '<tr>';
                html += '<th colspan="8" style="text-align:center">TOTAL</th>';
                html += '<th style="text-align: right">s/. '+ suma.toFixed(2) +'</th>';
                html += '</tr>';
                html += '</tfoot>';
                html += '</table>';
                $("#lista_misas_comunitarias_utilidades").html(html);

                $('#table_lista_misas_comunitarias_utilidades').dataTable({
                    "aaSorting": [[2, "asc"]],
                    "bScrollCollapse": true,
                    "bPaginate": true,
                    // "sScrollX": "120%",
                    // "sScrollXInner": "150%"
                });

            } else {
                $("#lista_misas_comunitarias_utilidades").empty();
                swal("Nota",  "No hay resultados en la búsqueda.", "warning");
            }

        },
        error: function (error) {
            console.log(error);
            var datosJSON = $.parseJSON(error.responseText);
        }
    });


}