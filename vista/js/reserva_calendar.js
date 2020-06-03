var fecha = null;
var list_horarios_reservas = [];
var horario_seleccionado = null;
$(document).ready(function () {
    $('#calendario').datepicker().on("changeDate", function (e) {
        console.log(e.format(0, "yyyy-mm-dd"));
        fecha = e.format(0, "yyyy-mm-dd");
        lista();
    });

    cargarCapillaId("#combo_capilla_id");
    cargarTipoCultoId("#combo_tipoculto_id");
    cargarClienteId("#combo_cliente_id");


});

function cargarCapillaId(p_nombreCombo) {
    var dni = $("#sesion_dni").val()
    var data = {'dni': dni};

    console.log(data);
    $.post
    (
        "../controlador/capillas_listar_por_dni.php", data
    ).done(function (resultado) {
        console.log(resultado);

        var datosJSON = resultado;

        if (datosJSON.estado === 200) {
            var html = "";

            html += '<option value="0">Seleccione Capilla</option>';
            $.each(datosJSON.datos, function (i, item) { //each para recorrer todos los elementos de array
                html += '<option value="' + item.cap_id + '">' + item.cap_nombre + ' / ' + item.cap_direccion + '</option>';
            });
            $(p_nombreCombo).html(html);
        } else {
            swal("Mensaje del sistema", resultado, "warning");
        }
    }).fail(function (error) {
        var datosJSON = $.parseJSON(error.responseText);
        swal("Error", datosJSON.mensaje, "error");
    });
}

function cargarTipoCultoId(p_nombreCombo) {
    $.post
    (
        "../controlador/tipoCulto.listar.controlador.php"
    ).done(function (resultado) {
        var datosJSON = resultado;

        if (datosJSON.estado === 200) {
            var html = "";
            html += '<option value="0">Seleccione Tipo Culto</option>';
            $.each(datosJSON.datos, function (i, item) { //each para recorrer todos los elementos de array

                html += '<option value="' + item.tc_id + '">' + item.tc_nombre + ' / ' + item.culto + '</option>';
            });
            $(p_nombreCombo).html(html);
        } else {
            swal("Mensaje del sistema", resultado, "warning");
        }
    }).fail(function (error) {
        var datosJSON = $.parseJSON(error.responseText);
        swal("Error", datosJSON.mensaje, "error");
    });
}

function cargarClienteId(p_nombreCombo) {
    $.post
    (
        "../controlador/persona_cliente_listar_controlador.php"
    ).done(function (resultado) {
        var datosJSON = resultado;

        if (datosJSON.estado === 200) {
            var html = "";
            html += '<option value="0">Seleccione Cliente</option>';
            $.each(datosJSON.datos, function (i, item) { //each para recorrer todos los elementos de array

                html += '<option value="' + item.per_iddni + '">' + item.cliente + '</option>';
            });
            $(p_nombreCombo).html(html);
        } else {
            swal("Mensaje del sistema", resultado, "warning");
        }
    }).fail(function (error) {
        var datosJSON = $.parseJSON(error.responseText);
        swal("Error", datosJSON.mensaje, "error");
    });
}

$("#combo_capilla_id").change(function () {
    cargarPadreId("#combo_padre_id");
    cargarCantorId("#combo_cantor_id");
});

function cargarPadreId(p_nombreCombo) {
    var data = {
        'capilla': $("#combo_capilla_id").val()
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

                html += '<option value="' + item.per_iddni + '">' + item.padre + '</option>';
            });
            $(p_nombreCombo).html(html);
        } else {
            swal("Mensaje del sistema", resultado, "warning");
        }
    }).fail(function (error) {
        var datosJSON = $.parseJSON(error.responseText);
        swal("Error", datosJSON.mensaje, "error");
    });
}

function cargarCantorId(p_nombreCombo) {
    var data = {
        'capilla': $("#combo_capilla_id").val()
    };
    $.post
    (
        "../controlador/persona_cantores_listar_controlador.php", data
    ).done(function (resultado) {
        console.log("cantor");
        console.log(resultado);
        var datosJSON = resultado;

        if (datosJSON.estado === 200) {
            var html = "";
            html += '<option value="">Seleccione Cantor</option>';
            $.each(datosJSON.datos, function (i, item) { //each para recorrer todos los elementos de array

                html += '<option value="' + item.per_iddni + '">' + item.cantor + '</option>';
            });
            $(p_nombreCombo).html(html);
        } else {
            swal("Mensaje del sistema", resultado, "warning");
        }
    }).fail(function (error) {
        var datosJSON = $.parseJSON(error.responseText);
        swal("Error", datosJSON.mensaje, "error");
    });
}


$('#aprobacion').on('ifChecked', function (event) {
    $("#precio").removeAttr('disabled');
});
$('#aprobacion').on('ifUnchecked', function (event) {
    $("#precio").attr('disabled', 'disabled');

});

function lista() {


    var data = {
        'fecha': fecha,
        'parroquia_id': $("#sesion_parroquia_id").val()

    };

    console.log(data);
    $.ajax({
        data: data,
        url: "../controlador/reserva_listar_por_parroquia.php",
        type: "post",
        success: function (resultado) {
            console.log(resultado);
            var datosJSON = resultado;
            if (datosJSON.estado === 200) {//validamos si el controlador se ha ejecutado correctamente
                list_horarios_reservas = resultado.datos;
                $("#reserva_lista").html("");

                var html = "";

                html += '<table id="table_reserva_lista" class="table table-bordered table-striped">' +
                    '<thead>' +
                    '<tr>' +
                    '<th  style="text-align: center; color: #00c0ef">Sel.</th>' +
                    '<th>Disponibilidad</th>' +
                    '<th>Hora</th>' +
                    '<th>Tipo culto</th>' +
                    '<th>Tipo</th>' +
                    '<th>Precio</th>' +
                    '<th>Capilla</th>' +
                    '<th># Reservas</th>' +
                    '<th>Ver reservas</th>' +
                    '</tr>' +
                    '</thead>' +
                    '<tbody>';
                //Detalle
                $.each(datosJSON.datos, function (i, item) {


                    html += '<tr>';
                    if (item.disponibilidad == 'Disponible') {
                        html += '<td style="text-align: center">';
                        html += '<input type="radio" name="radio_reserva_id" class="flat-red" onclick="horario_selection(' + item.id + ')">';
                        html += '</td>';
                    } else {
                        html += '<td style="text-align: center">-</td>';

                    }

                    if (item.disponibilidad == 'Disponible') {
                        html += '<td style="text-align: center"><span class="badge bg-green">' + item.disponibilidad + '</span></td>';
                    } else {
                        html += '<td style="text-align: center"><span class="badge bg-yellow-active">' + item.disponibilidad + '</span></td>';
                    }


                    html += '<td>' + item.hora + '</td>';
                    html += '<td>' + item.tipoculto_nombre + '</td>';
                    html += '<td>' + item.tipoculto_type + '</td>';
                    html += '<td>' + item.precio_normal + '</td>';
                    html += '<td>' + item.cap_nombre + '</td>';
                    html += '<td style="text-align: center">' + item.numero_reservas + '</td>';
                    if (item.disponibilidad == 'No Disponible' && item.tipoculto_type == 'Individual') {
                        html += '<td style="text-align: center"><i class="fa fa-eye text-info" title="Lista de reservas"></i></td>';
                    } else {
                        if (item.disponibilidad == 'Disponible' && item.tipoculto_type == 'Individual') {
                            html += '<td style="text-align: center">-</td>';

                        } else {
                            html += '<td style="text-align: center"><a href="../vista/reserva_por_horario.php?horario_id=' + item.id + '" class="nav-link">' +
                                '<i class="fa fa-list-ol text-info" title="Lista de reservas"></i></a></td>';
                        }

                    }
                    html += '</tr>';


                });
                html += '</tbody>';
                html += '</table>';
                //Mostrar el resultado de la variable html en el div "listado"
                $("#reserva_lista").html(html);

                //Aplicar la funcion datatable a la tabla donde se muestra el resultado
                $('#table_reserva_lista').dataTable({
                    "aaSorting": [[0, "asc"]],
                    "bScrollCollapse": true,
                    "bPaginate": true,
                    // "sScrollX": "120%",
                    // "sScrollXInner": "150%"
                });

            } else {
                $("#list_reservas").html("");
                swal("Nota", datosJSON.mensaje, "warning");
            }

        },
        error: function (error) {
            console.log(error);
            var datosJSON = $.parseJSON(error.responseText);
        }
    });


}

var ide = 0;

function horario_selection(id) {
    for (var i = 0; i < list_horarios_reservas.length; i++) {
        if (id == list_horarios_reservas[i].id) {

            if (list_horarios_reservas[i].precio_normal == null) {
                swal("Aviso!", "Este tipo de culto no tiene precio definido", "warning");
                return 0;
                break;
            }
            ide = id;
            horario_seleccionado = list_horarios_reservas[i];
            console.log(list_horarios_reservas[i].tipoculto_id);
            if (list_horarios_reservas[i].tipoculto_id == 3) {
                $("#tipo_culto_misa_comunitaria").removeAttr('style');
            } else {
                $("#tipo_culto_misa_comunitaria").removeAttr('style');
                $("#tipo_culto_misa_comunitaria").attr('style', 'display:none')

            }
            break;
            //horario_seleccionado.push(list_horarios_reservas[i]);
        }
    }

    comparar_fecha(horario_seleccionado.dias, horario_seleccionado.fecha)

}

function horario_reservar() {
    if (horario_seleccionado == null) {
        swal("Nota", "Para realizar una reserva debe seleccionar algún horario disponible", "warning");
        return 0;
    } else {
        $("#modal_reserva_calendar").modal("show");
        $("#title_reserva_calendar").html("Nueva reserva");
        $("#horario_id").val(ide);
        $("#combo_capilla_id").removeAttr('disabled');
        $("#combo_capilla_id").val(horario_seleccionado.capilla_id);

        //Se activaran para selccionar los combos para padre y cantor
        cargarPadreId("#combo_padre_id");
        cargarCantorId("#combo_cantor_id");

        $("#ofrece").removeAttr('disabled');
        $("#combo_tipoculto_id").val(horario_seleccionado.tipoculto_id);
        $("#combo_padre_id").removeAttr('disabled');
        $("#fecha_ref").val(horario_seleccionado.fecha);
        $("#hora_ref").val(horario_seleccionado.hora);
        $("#precio").val(horario_seleccionado.precio_normal);


    }

}

function comparar_fecha(dias, fecha, id) {
    console.log("Emtrooo");
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
            $("#btn_reservar_calendar_add").removeAttr('style');
            swal("Bien!", resultado.mensaje, "info");
        } else {
            if (datosJSON.estado === 203) {
                $("#btn_reservar_calendar_add").removeAttr('style');
                $("#btn_reservar_calendar_add").attr('style', 'display:none');
                swal("Nota", resultado.mensaje, "info");
                return 0;
            }
        }
    }).fail(function (error) {
        console.log(error);
        var datosJSON = $.parseJSON(error.responseText);
        //swal("Error", datosJSON.mensaje, "error");
    });

}

function plus_add() {
    console.log(horario_seleccionado.tipoculto_type);

    var dirigido = $("#dirigido").val();
    var costo = $("#precio").val();
    console.log(dirigido);
    if ($("#dirigido").val() == "") {
        swal("Nota", 'Ingrese el campo : "Dirigido a ... "', "info");
        return 0;
    }

    var fila = "<tr>" +
        "<td align=\"center\" id=\"celiminar\"><a href=\"javascript:void();\"><i class=\"fa fa-trash text-orange\"></i></a></td>" +
        "<td>" + dirigido + "</td>" +
        "<td style=\"text-align: right\">" + costo + "</td>" +
        "</tr>";

    var cont = 0
    $("#detalle tr").each(function () {
        cont = cont + 1;
    });


    if (horario_seleccionado.tipoculto_type == 'Individual' && cont > 5) {
        swal("Nota", 'El tipo de culto es indiviual por lo tanto no puede agregar mas de un item', "info");
        $("#dirigido").val("");
        return 0;
    } else {
        $("#detalle").append(fila);
        $("#precio").val("0");
        $("#dirigido").val("");
        calcularTotales();
    }


}


$(document).on("click", "#celiminar", function () {
    if (!confirm("Esta seguro de elimina el registro seleccionado")) {
        return 0;
    }
    var fila = $(this).parents().get(0); //capturar la fila que deseamos eliminar
    fila.remove(); //eliminar la fila
    calcularTotales();
});


function calcularTotales() {
    var importeNeto = 0;
    $("#detalle tr").each(function () {
        var importe = $(this).find("td").eq(2).html();
        importeNeto = importeNeto + parseFloat(importe);
    });
    $("#total").html(importeNeto.toFixed(2));
}


var arrayDetalle = new Array();

function create_reserva() {

    swal({
            title: "Confirme",
            text: "¿Esta seguro de guarda la reserva?",
            showCancelButton: true,
            confirmButtonColor: '#3d9205',
            confirmButtonText: 'Si',
            cancelButtonText: "No",
            closeOnConfirm: false,
            closeOnCancel: true,
            imageUrl: "../imagenes/preguntar.png"
        },
        function (isConfirm) {
            if (isConfirm) {
                arrayDetalle.splice(0, arrayDetalle.length);
                $("#detalle tr").each(function () {
                    var dirigido = $(this).find("td").eq(1).html();
                    var importe = $(this).find("td").eq(2).html();

                    var objDetalle = new Object();

                    objDetalle.dirigido = dirigido;
                    objDetalle.importe = importe;
                    arrayDetalle.push(objDetalle);

                });
                var jsonDetalle = JSON.stringify(arrayDetalle);
                var datos_frm = {
                    estado: $("#combo_estado").val(),
                    ofrece: $("#ofrece").val(),
                    detail: $("#combo_detail").val(),
                    total: $("#total").html(),
                    cliente_dni: $("#combo_cliente_id").val(),
                    padre_id: $("#combo_padre_id").val(),
                    cantor_id: $("#combo_cantor_id").val(),
                    horario_id: $("#horario_id").val(),
                    detalle: jsonDetalle,

                };
                console.log(datos_frm);
                $.post
                (
                    "../controlador/reserva_create.php",
                    datos_frm
                ).done(function (resultado) {
                    console.log(resultado);
                    var datosJSON = resultado;
                    if (datosJSON.estado === 200) {
                        swal({
                                title: "Genial",
                                text: "La Reserva se guardo con éxito!. Se enviará mensaje de texto al Cliente. ",
                                confirmButtonColor: '#3d9205',
                                confirmButtonText: 'OK',
                                closeOnConfirm: true,
                                closeOnCancel: true
                            },
                            function (isConfirm) {
                                if (isConfirm) {
                                    //cliente_sms(resultado.datos);
                                }
                            });
                    } else {
                        swal("Mensaje del sistema", resultado, "warning");
                    }
                }).fail(function (error) {
                    console.log(error);
                    var datosJSON = $.parseJSON(error.responseText);
                    swal("Ocurrió un error", datosJSON.mensaje, "error");
                });


            }
        });

}

function cliente_sms(id) {
    console.log(id);
    var data = {'id': id};
    console.log(data);
    $.post
    (
        "../controlador/reserva_sms-controlador.php", data
    ).done(function (resultado) {
        console.log(resultado);
        var datosJSON = resultado;
        if (datosJSON.estado === 200) {
            swal({
                    title: "Genial",
                    text: resultado.mensaje,
                    confirmButtonColor: '#3d9205',
                    confirmButtonText: 'OK',
                    closeOnConfirm: true,
                    closeOnCancel: true
                },
                function (isConfirm) {
                    if (isConfirm) {
                        window.location.href = '../vista/reserva_calendar.php';
                    }

                })


            swal("Exito", datosJSON.mensaje, "success");
            window.location.href = '../vista/reserva_calendar.php';
        } else {
            swal("Mensaje del sistema", resultado, "warning");
        }
    }).fail(function (error) {
        console.log(error);
        var datosJSON = $.parseJSON(error.responseText);
        swal("Ocurrió un error", datosJSON.mensaje, "error");
    });

}