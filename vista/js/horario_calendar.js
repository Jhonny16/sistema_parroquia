var sesion_capilla_id = $("#sesion_capilla_id").val();

$(document).ready(function () {
    console.log(capilla_id);
    listar();


});
var operacion = null;
var list_detail = [];

function listar() {

    var data = {'capilla_id': sesion_capilla_id};

    $.post
    (
        "../controlador/horarioCalendarControlador.php",data
    ).done(function (resultado) {
        var datosJSON = resultado
        console.log(resultado);
        if (datosJSON.estado === 200) { //validamos si el controlador se ha ejecutado correctamente

            console.log(resultado);

            var data = [];
            var result = resultado.datos;
            list_detail = resultado.datos;
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

            $('#calendar').fullCalendar({
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
            })


        } else {
            $("#list_horarios").html("");
            swal("Nota", datosJSON.mensaje, "warning");
        }

    }).fail(function (error) {
        var datosJSON = $.parseJSON(error.responseText);
        swal("Ocurrió un error", datosJSON.mensaje, "error");
    });


}
var fecha="";
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
        if (datosJSON.estado === 200) {

            selection(resultado.datos[0].dias, resultado.datos[0].id,resultado.datos[0].cap_id, resultado.datos[0].tc_id, resultado.datos[0].fecha  )

                detail(resultado.datos[0].tc_id);

        }else{
            $("#reserva_list").html("");
            swal("Nota", datosJSON.mensaje, "warning");
        }

    }).fail(function (error) {
        var datosJSON = $.parseJSON(error.responseText);
        swal("Ocurrió un error", datosJSON.mensaje, "error");
    });
}

function detail(culto_id){
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
                html += '<option value="' + item.det_nombre + '">' + item.det_nombre+ ' / ' + item.det_descripcion + '</option>';
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

function selection(dias,id,capilla_id, tipoculto_id,fecha){
    console.log(dias);
    console.log(id);
    var state = null;
    for(var i=0; i< list_detail.length; i++){
        if(list_detail[i].id == id){
            state = list_detail[i].reserva;
            break;
        }
    }

    if(state == 1){
        operacion = 'update';
        swal("Sugerencia!", "Ud. podrá editar la reserva", "info");

        add_data_form(id,capilla_id,tipoculto_id);
    }
    else{
        operacion = 'create';
        console.log(dias);
        console.log(fecha);
        comparar_fechas(dias,fecha,id,capilla_id,tipoculto_id);
    }





}

$("#btn_editar").click(function () {
    //$("#operation").val("agregar");
    $("#content_create_reserva").removeAttr('style');
    $("#content_lista_reserva").attr('style','display:none');

//    limpiar();


});

function comparar_fechas(dias, fecha,id,capilla_id,tipoculto_id){


    var data = {
        'fecha_hoy' : $("#date_hoy").val(),
        'dias' : dias,
        'fecha_tipo_culto' : fecha
    }
    console.log(data);
    $.post
    (
        "../controlador/comparar_fecha.php",data
    ).done(function (resultado) {
        var datosJSON = resultado;
        console.log(resultado);

        if (datosJSON.estado === 200) {
            //$("#btn_editar").removeAttr('style');
            swal("Bien!", resultado.mensaje, "info");
            add_data_form(id,capilla_id,tipoculto_id);
        } else {
            if(datosJSON.estado === 203){
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

function add_data_form(id,capilla_id,tipoculto_id){
    $("#btn_save").removeAttr('style');
    cargaPadreId(capilla_id);
    cargaCantorId(capilla_id)
    cargaCapillaId();
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
            if (operacion == 'create'){
                $("#combo_detail_id").val("0");
            }else{
                $("#combo_detail_id").val(data[0].detail);
            }
            $("#combo_estado").val(data[0].estado);

            $("#ofrece").val(data[0].ofrece);

            $("#fecha_ref").val(data[0].fecha);
            $("#hora_ref").val(data[0].hora_hora);
            $("#precio").val(data[0].tc_precio);
            $("#horario_id").val(data[0].horario_id);
            $("#type").val(data[0].tipo);



            //var cliente = $("#combo_cliente_id").val();
            if (data[0].importe == null){

            }else{
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



        }else{
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

function habililtar(){
    $("#combo_padre_id").removeAttr('disabled');
    $("#combo_cantor_id").removeAttr('disabled');
    $("#combo_cliente_id").removeAttr('disabled');
    $("#combo_detail_id").removeAttr('disabled');
    $("#dirigido").removeAttr('disabled');
    $("#combo_estado").removeAttr('disabled');
    $("#ofrece").removeAttr('disabled');
}

function desahibilitar(){
    $("#combo_padre_id").attr('disabled','disabled');
    $("#combo_cantor_id").attr('disabled','disabled');
    $("#combo_cliente_id").attr('disabled','disabled');
    $("#dirigido").attr('disabled','disabled');
    $("#combo_estado").attr('disabled','disabled');

}
function cargaCapillaId(p_nombreCombo) {
    var cargo = $("#cargo_id").val()
    var data = {'p_cargo': cargo};
    console.log(data);
    $.post
    (
        "../controlador/capilla.listar.controlador.php",data
    ).done(function (resultado) {
        console.log(resultado);

        var datosJSON = resultado;

        if (datosJSON.estado === 200) {
            var html = "";

            html += '<option value="0">Seleccione Capilla</option>';
            $.each(datosJSON.datos, function (i, item) { //each para recorrer todos los elementos de array
                html += '<option value="' + item.cap_id + '">' + item.cap_nombre+ ' / ' + item.cap_direccion + '</option>';
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
        'capilla' : capilla_id
    };
    $.post
    (
        "../controlador/persona_padres_listar_controlador.php",data
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
        'capilla' : capilla_id
    };
    $.post
    (
        "../controlador/persona_cantores_listar_controlador.php",data
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

