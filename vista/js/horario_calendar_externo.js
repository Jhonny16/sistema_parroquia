$(document).ready(function () {

});
var operacion = null;
var list_detail = [];

var cont = 0
$("#combo_capilla_id").change(function () {
    cont++;
    var capilla_id = $("#combo_capilla_id").val();
    console.log(cont);
    if (cont > 1) {
        swal({
                title: "Confirme",
                text: "¿Desea cambiar de capilla?",
                showCancelButton: true,
                confirmButtonColor: '#3d9205',
                confirmButtonText: 'Si',
                cancelButtonText: "No",
                closeOnConfirm: false,
                closeOnCancel: true
            },
            function (isConfirm) {
                if (isConfirm) {
                    location.reload();
                }
            }
        );
    } else {
        listar(capilla_id);
    }


});

function listar(capilla_id) {

    //$('#calendario').empty();

    var data = {'capilla_id': capilla_id}
    console.log(data);

    $.post
    (
        "../controlador/horarioCalenarExternoControlador.php", data
    ).done(function (resultado) {
        var datosJSON = resultado;
        console.log(resultado);
        if (datosJSON.estado === 200) { //validamos si el controlador se ha ejecutado correctamente

            console.log(resultado);
            $("#msg").attr('style', 'display:none');
            var data = [];
            var result = resultado.datos;
            list_detail = resultado.datos;
            //$('#calendar').attr('class','fc fc-unthemed fc-ltr');
            for (var i = 0; i < result.length; i++) {
                var background = "";
                var bordercolor = "";
                if (parseInt(result[i].reserva) == 1) {
                    background = '#d34100'; //aqua
                    bordercolor = '#cf0052';
                } else {
                    background = '#00a65a';
                    bordercolor = '#00a65a';
                }
                var start = result[i].date_start;
                var end = result[i].date_end;
                var eve = {
                    title: result[i].id,
                    description: result[i].tc_descripcion,
                    start: start,
                    end: end,
                    allDay: false,
                    backgroundColor: background,
                    borderColor: bordercolor
                }
                data.push(eve);
            }

            //console.log(data);

            //var calendar = new Calendar()

            $('#calendar').fullCalendar(
                {
                    header: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'month,agendaWeek,agendaDay'
                    },
                    buttonText: {
                        today: 'Hoy',
                        month: 'Mes',
                        week: 'Semana',
                        day: 'Dia'
                    },
                    //Random default events

                    eventRender: function (eventObj, $el) {
                        $el.popover({
                            title: eventObj.title,
                            content: eventObj.description,
                            trigger: 'hover',
                            placement: 'top',
                            container: 'body'
                        });
                    },

                    events: data,
                    editable: false,
                    droppable: false, // this allows things to be dropped onto the calendar !!!
                    eventClick: function (calEvent, jsEvent, view) {
                        console.log('click', calEvent.title);
                        show_detail_tipo_culto(calEvent.title);
                    }
                }
            )


        } else {
            $("#list_horarios").html("");
            swal("Nota", datosJSON.mensaje, "warning");
        }

    }).fail(function (error) {
        var datosJSON = $.parseJSON(error.responseText);
        swal("Ocurrió un error", datosJSON.mensaje, "error");
    });


}

var fecha = "";
// var tipo_culto_id ="";
// var capilla_id = ""
function show_detail_tipo_culto(id) {

    var data = {
        'p_id': id
    }
    console.log(data);
    $.post
    (
        "../controlador/reserva_list_id_controlador.php", data
    ).done(function (resultado) {
        var datosJSON = resultado;
        console.log(resultado)
        if (datosJSON.estado === 200) {//validamos si el controlador se ha ejecutado correctamente

            selection(resultado.datos[0].dias, resultado.datos[0].id, resultado.datos[0].cap_id, resultado.datos[0].tc_id)
            detail(resultado.datos[0].tc_id);
        } else {
            $("#reserva_list").html("");
            swal("Nota", datosJSON.mensaje, "warning");
        }

    }).fail(function (error) {
        var datosJSON = $.parseJSON(error.responseText);
        swal("Ocurrió un error", datosJSON.mensaje, "error");
    });
}

function detail(culto_id) {
    $("#combo_detail_id").empty();
    var data = {
        'culto_id': culto_id
    };

    console.log(data);
    $.post
    (
        "../controlador/cultoTipoDetailControlador.php", data
    ).done(function (resultado) {
        console.log(resultado);
        if (resultado.estado === 200) {
            var html = "";

            html += '<option value="0">Seleccione Detalle</option>';
            $.each(resultado.datos, function (i, item) { //each para recorrer todos los elementos de array
                html += '<option value="' + item.det_nombre + '">' + item.det_nombre + ' / ' + item.det_descripcion + '</option>';
            });
            $("#combo_detail_id").html(html);
        } else {
            swal("Mensaje del sistema", resultado, "warning");
        }

    }).fail(function (error) {
        var datosJSON = $.parseJSON(error.responseText);
        swal("Ocurrió un error", datosJSON.mensaje, "error");
    });
}

function selection(dias, id, capilla_id, tipoculto_id) {
    console.log(dias);
    console.log(id);
    var state = null;
    for (var i = 0; i < list_detail.length; i++) {
        if (list_detail[i].id == id) {
            state = list_detail[i].reserva;
            break;
        }
    }
    if (state == 1) {
        operacion = 'update';
        swal("Sugerencia!", "Ud. No podrá editar la reserva", "info");
        return 0;

        //add_data_form(id, capilla_id, tipoculto_id);
    } else {
        operacion = 'create';
        console.log(dias);
        console.log(fecha);
        comparar_fechas(dias, fecha, id, capilla_id, tipoculto_id);
    }


}

$("#btn_editar").click(function () {
    //$("#operation").val("agregar");
    $("#content_create_reserva").removeAttr('style');
    $("#content_lista_reserva").attr('style', 'display:none');

//    limpiar();


});

function comparar_fechas(dias, fecha, id, capilla_id, tipoculto_id) {


    var data = {
        'fecha_hoy': $("#date_hoy").val(),
        'dias': dias,
        'fecha_tipo_culto': fecha
    }
    console.log(data);
    $.post
    (
        "../controlador/comparar_fecha.php", data
    ).done(function (resultado) {
        var datosJSON = resultado;
        console.log(resultado);

        if (datosJSON.estado === 200) {
            //$("#btn_editar").removeAttr('style');
            swal("Bien!", resultado.mensaje, "info");
            add_data_form(id, capilla_id, tipoculto_id);
        } else {
            if (datosJSON.estado === 203) {
                swal("Nota!", resultado.mensaje, "info");
                console.log("maluu");

            }
        }
    }).fail(function (error) {
        console.log(error);
        var datosJSON = $.parseJSON(error.responseText);
        //swal("Error", datosJSON.mensaje, "error");
    });

}

function add_data_form(id, capilla_id, tipoculto_id) {
    $("#btn_save").removeAttr('style');
    cargaPadreId(capilla_id);
    cargaCantorId(capilla_id)
    //cargaCapillaId();
    var data = {
        'tipo_culto': tipoculto_id,
        'capilla': capilla_id,
        'horario': id,

    }
    console.log(data);
    $.post
    (
        "../controlador/horario_data_controller.php", data
    ).done(function (resultado) {
        var datosJSON = resultado;
        console.log(resultado);
        if (datosJSON.estado === 200) {//validamos si el controlador se ha ejecutado correctamente
            var data = datosJSON.datos;
            console.log("data");

            $("#reserva_id").val(data[0].id);

            $("#combo_capilla_id").val(data[0].capilla_id);
            $("#combo_tipoculto_id").val(data[0].tipoculto_id);
            $("#combo_padre_id").val(data[0].padre);
            $("#combo_cantor_id").val(data[0].cantor);
            $("#combo_cliente_id").val(data[0].cliente_dni);
            if (operacion == 'create') {
                $("#combo_detail_id").val("0");
                $("#combo_estado").val("Pendiente");
            } else {
                $("#combo_estado").val(data[0].estado);
                $("#combo_detail_id").val(data[0].detail);
            }


            $("#fecha_ref").val(data[0].fecha);
            $("#hora_ref").val(data[0].hora_hora);
            $("#precio").val(data[0].tc_precio);
            $("#horario_id").val(data[0].horario_id);
            $("#type").val(data[0].tipo);
            $("#ofrece").val(data[0].ofrece);

            //var cliente = $("#combo_cliente_id").val();
            if (data[0].importe == null) {

            } else {
                var html = "";
                $.each(datosJSON.datos, function (i, item) {
                    html += '<tr>';
                    html += '<td align="center" id="celiminar"><a href="javascript:void();"><i class="fa fa-trash text-orange"></i></a></td>';
                    html += '<td>' + item.horario_id + '</td>';
                    html += '<td>' + item.dirigido + '</td>';
                    // html += '<td>' + cliente + '</td>';
                    html += '<td style="text-align: right">' + item.importe + '</td>';
                    html += '</tr>';
                });

                $("#detalle").html(html);

                calcularTotales();
            }


            habililtar();


        } else {
            //$("#horarios").html("");
            console.log(resultado);
            cargaPadreId(capilla_id);
            cargaCantorId(capilla_id)
            $("#combo_capilla_id").val(data[0].capilla_id);
            swal("DISPONIBLE", "Ud. Puede crear una nueva reserva", "success");
        }

    }).fail(function (error) {
        console.log(error);
        var datosJSON = $.parseJSON(error.responseText);
        swal("Ocurrió un error", datosJSON.mensaje, "error");
    });

}

function habililtar() {
    $("#combo_padre_id").removeAttr('disabled');
    $("#combo_cantor_id").removeAttr('disabled');
    $("#combo_cliente_id").removeAttr('disabled');
    $("#combo_capilla_id").removeAttr('disabled');
    $("#dirigido").removeAttr('disabled');
    $("#ofrece").removeAttr('disabled');
    $("#combo_detail_id").removeAttr('disabled');
}

function desahibilitar() {
    $("#combo_padre_id").attr('disabled', 'disabled');
    $("#combo_cantor_id").attr('disabled', 'disabled');
    $("#combo_cliente_id").attr('disabled', 'disabled');
    $("#dirigido").attr('disabled', 'disabled');

}

function cargaCapillaId() {

    $.post
    (
        "../controlador/capilla_listar_controlador.php"
    ).done(function (resultado) {
        console.log(resultado);

        var datosJSON = resultado;

        if (datosJSON.estado === 200) {
            var html = "";

            html += '<option value="0">Seleccione Capilla</option>';
            $.each(datosJSON.datos, function (i, item) { //each para recorrer todos los elementos de array
                html += '<option value="' + item.cap_id + '">' + item.cap_nombre + ' / ' + item.cap_direccion + '</option>';
            });
            $("#combo_capilla_id").html(html);
        } else {
            swal("Mensaje del sistema", resultado, "warning");
        }
    }).fail(function (error) {
        var datosJSON = $.parseJSON(error.responseText);
        swal("Error", datosJSON.mensaje, "error");
    });
}

function cargaPadreId(capilla_id) {
    var data = {
        'capilla': capilla_id
    };
    $.post
    (
        "../controlador/persona_padres_listar_controlador.php", data
    ).done(function (resultado) {
        var datosJSON = resultado;

        if (datosJSON.estado === 200) {
            var html = "";
            html += '<option value="">Seleccione Padre</option>';
            $.each(datosJSON.datos, function (i, item) { //each para recorrer todos los elementos de array

                html += '<option value="' + item.padre + '">' + item.padre + '</option>';
            });
            $("#combo_padre_id").html(html);
        } else {
            swal("Mensaje del sistema", resultado, "warning");
        }
    }).fail(function (error) {
        var datosJSON = $.parseJSON(error.responseText);
        swal("Error", datosJSON.mensaje, "error");
    });
}

function cargaCantorId(capilla_id) {
    var data = {
        'capilla': capilla_id
    };
    $.post
    (
        "../controlador/persona_cantores_listar_controlador.php", data
    ).done(function (resultado) {
        var datosJSON = resultado;

        if (datosJSON.estado === 200) {
            var html = "";
            html += '<option value="">Seleccione Cantor</option>';
            $.each(datosJSON.datos, function (i, item) { //each para recorrer todos los elementos de array

                html += '<option value="' + item.cantor + '">' + item.cantor + '</option>';
            });
            $("#combo_cantor_id").html(html);
        } else {
            swal("Mensaje del sistema", resultado, "warning");
        }
    }).fail(function (error) {
        var datosJSON = $.parseJSON(error.responseText);
        swal("Error", datosJSON.mensaje, "error");
    });
}

