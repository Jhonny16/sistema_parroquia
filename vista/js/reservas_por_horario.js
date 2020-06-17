var horario_id = 0;
var reserva_id = 0;
var persona_dni = '0';
var list_reservas = [];
var ides = [];
var capilla_id = 0;
$(document).ready(function () {
    cargarCombos();
});

function cargarCombos() {
    var data = {
        'parroquia_id': $("#sesion_parroquia_id").val()
    };

    console.log(data);
    $.post
    (
        "../controlador/reserva_horario_lista_filtros.php", data
    ).done(function (resultado) {
        console.log(resultado);

        var datosJSON = resultado;

        if (datosJSON.estado === 200) {
            var html1 = "";
            var html2 = "";
            var html3 = "";

            html1 += '<option value="0">Seleccione Horario</option>';
            $.each(datosJSON.datos, function (i, item) {
                html1 += '<option value="' + item.horario_id + '">' + item.horario + '</option>';
            });
            $("#busqueda_horario_id").html(html1);


            html2 += '<option value="0">Seleccione DNI</option>';
            $.each(datosJSON.datos, function (i, item) {
                html2 += '<option value="' + item.persona_dni + '">' + item.persona_dni + ' / ' + item.persona_nombre + '</option>';
            });
            $("#busqueda_persona_dni").html(html2);

            html3 += '<option value="0">Seleccione código</option>';
            $.each(datosJSON.datos, function (i, item) {
                html3 += '<option value="' + item.reserva_id + '">' + item.reserva_code + '</option>';
            });
            $("#busqueda_reserva_id").html(html3);

            getUrlVars();


        } else {
            swal("Mensaje del sistema", resultado.mensaje, "warning");
        }
    }).fail(function (error) {
        var datosJSON = $.parseJSON(error.responseText);
        swal("Error", datosJSON.mensaje, "error");
    });
}


function getUrlVars() {
    var vars = {};
    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function (m, key, value) {
        vars[key] = value;
    });
    console.log(vars.horario_id);
    if (vars.horario_id >= 1) {
        horario_id = vars.horario_id;
        console.log("horario_id");
        console.log(horario_id);
        $("#busqueda_horario_id").val(horario_id);
    }

    buscar_reservas();

}

$("#busqueda_horario_id").change(function () {
    horario_id = $("#busqueda_horario_id").val();
});
$("#busqueda_persona_dni").change(function () {
    persona_dni = $("#busqueda_persona_dni").val();
});
$("#busqueda_reserva_id").change(function () {
    reserva_id = $("#busqueda_reserva_id").val();
});


function buscar_reservas() {

    $("#btn_update_padre_cantor").attr('style', 'display:none');
    var data = {
        'horario_id': horario_id,
        'reserva_id': reserva_id,
        'persona_dni': persona_dni

    };
    console.log(data);

    if (horario_id == 0 && reserva_id == 0 && persona_dni == '0') {
        $("#list_reservas_horario").html("<p style='text-align: center; color: #999580'><strong>No hay resultados</strong></p>");
        swal("Mensaje", "Debe seleccionar al menos algún filtro para la búsqueda", "info");
    } else {
        $.ajax({
            data: data,
            url: "../controlador/reserva_horario_lista.php",
            type: "post",
            success: function (resultado) {
                console.log(resultado);
                var datosJSON = resultado;
                if (datosJSON.estado === 200) {
                    $("#load").html("");
                    list_reservas = resultado.datos;
                    $("#list_reservas_horario").html("");

                    var html = "";

                    html += '<table id="table_list_reservas_horario" class="table table-bordered table-hover">' +
                        '<thead>' +
                        '<tr style="background-color: #00c0ef; color: white">' +
                        '<th  style="text-align: center" >Opción</th>' +
                        '<th>Código reserva</th>' +
                        '<th>Horario</th>' +
                        '<th>Estado</th>' +
                        '<th>Ofrece(n)</th>' +
                        '<th>Cliente</th>' +
                        '<th>Padre</th>' +
                        '<th>Cantor</th>' +
                        '<th>total</th>' +
                        '</tr>' +
                        '</thead>' +
                        '<tbody>';
                    //Detalle
                    $.each(datosJSON.datos, function (i, item) {
                        //Adicionamos el id de la reserva para la generacion del pdf

                        sw = 0;
                        if (ides.length == 0) {
                            ides.push(item.id);
                        } else {

                            for (var i = 0; i < ides.length; i++) {
                                if (ides[i] == item.id) {
                                    sw = 1;
                                    break;
                                }
                            }
                            if (sw == 0) {
                                ides.push(item.id);
                            }
                        }
                        console.log(ides);

                        if (sw == 0) {
                            $("#user_name").val($("#sesion_user_name").val());

                            html += '<tr>';
                            html += '<td style="text-align: center">';
                            html += '<a style="cursor:pointer" class="nav-link" onclick="ver_comprobante(' + item.id + ')">' +
                                '<i class="fa fa-eye text-info" title="Detalle completo"></i></a> &nbsp;';
                            if (item.estado == 'Anulado'){

                            }else{
                                if (item.estado == 'Pagado') {
                                    html += '<a style="cursor:pointer" class="nav-link" onclick="anular(' + item.id + ')">' +
                                        '<i class="fa fa-trash-o text-orange" title="Anular reserva"></i></a> &nbsp;';
                                }else{
                                    html += '<a style="cursor:pointer" class="nav-link" onclick="anular(' + item.id + ')">' +
                                        '<i class="fa fa-trash-o text-orange" title="Anular reserva"></i></a> &nbsp;';
                                    html += '<a style="cursor:pointer" class="nav-link" onclick="pagar(' + item.id + ')">' +
                                        '<i class="fa fa-credit-card text-success" title="Pagar reserva"></i></a> &nbsp;';
                                }
                            }


                            // html += '<a style="cursor:pointer" class="nav-link" onclick="anular(' + item.id + ')">' +
                            //     '<i class="fa fa-trash-o text-orange" title="Anular reserva"></i></a> &nbsp;';
                            // if (item.estado != 'Pagado' || item.estado != 'Anulado') {
                            //     html += '<a style="cursor:pointer" class="nav-link" onclick="pagar(' + item.id + ')">' +
                            //         '<i class="fa fa-credit-card text-success" title="Pagar reserva"></i></a> &nbsp;';
                            // }

                            if (item.padre == '-' || item.nombre_cantor == '-') {
                                $("#btn_update_padre_cantor").removeAttr('style');
                                mostrar_modal_padre_cantor(item.capilla_id, item.padre_dni, item.cantor_dni);
                                // html += '<a style="cursor:pointer" class="nav-link" data-toggle="modal" data-target="#mdl_padre_cantor"' +
                                //     'onclick="mostrar_modal_padre_cantor('+ item.capilla_id +','+ item.padre_dni +','+ item.cantor_dni +','+ item.id +')">' +
                                //     ' <i class="fa fa-odnoklassniki text-info" title="Asignar padre/cantor"></i></a> &nbsp;';
                            } else {
                                $("#btn_update_padre_cantor").removeAttr('style');
                                $("#btn_update_padre_cantor").attr('style', 'display:none');


                            }

                            html += '</td>';
                            html += '<td>' + item.code + '</td>';
                            html += '<td>' + item.horario + '</td>';

                            if (item.estado == 'Pagado') {
                                html += '<td style="text-align: center"><span class="badge bg-blue">' + item.estado + '</span></td>';
                            } else {
                                if (item.estado == 'Anulado') {
                                    html += '<td style="text-align: center"><span class="badge bg-orange">' + item.estado + '</span></td>';

                                } else {
                                    html += '<td style="text-align: center"><span class="badge bg-yellow">' + item.estado + '</span></td>';

                                }
                            }
                            html += '<td>' + item.ofrece + '</td>';


                            html += '<td>' + item.cliente + '</td>';
                            html += '<td>' + item.padre + '</td>';
                            html += '<td>' + item.nombre_cantor + '</td>';
                            html += '<td style="text-align: right">s/. ' + item.total + '</td>';

                            html += '</tr>';
                        }

                    });
                    html += '</tbody>';
                    html += '</table>';
                    $("#list_reservas_horario").html("");
                    $("#list_reservas_horario").html(html);

                    $('#table_list_reservas_horario').dataTable({
                        "aaSorting": [[0, "asc"]],
                        "bScrollCollapse": true,
                        "bPaginate": true,
                        "sScrollX": "100%",
                        "sScrollXInner": "100%"

                    });

                } else {
                    $("#list_reservas_horario").html("");
                    swal("Nota", datosJSON.mensaje, "warning");
                }

            },

            error: function (error) {
                console.log(error);
                var datosJSON = $.parseJSON(error.responseText);
            }
        });
    }


}

function limpiar_formato() {
    $("#fr_codigopago").html("");
    $("#fr_fecha").html("");
    $("#fr_cliente").html("");
    $("#fr_ofrece").html("");
    $("#fr_horario").html("");
    $("#fr_padre").html("");
    $("#fr_cantor").html("");
    $("#fr_detail").html("");
    $("#fr_codigoreserva").html("");
    $("#fr_estado").html("");
    $("#fr_subtotal").html("");
    $("#fr_detalle").html("");
    $("#fr_total").html("");
}

function ver_comprobante(id) {
    $("#reserva_id").val(id);

    limpiar_formato();
    $("#formato_reserva").attr('style', 'display:none')
    $("#load").append('<img src="../imagenes/load.gif" alt="">');

    setTimeout(function () {
        $("#load").empty();
        $("#formato_reserva").removeAttr('style');
        var reserva = [];
        for (var i = 0; i < list_reservas.length; i++) {
            if (id == list_reservas[i].id) {
                reserva.push(list_reservas[i]);
            }

        }
        console.log(reserva);
        if (reserva != null) {


            $("#fr_combo_padre_id").val(reserva[0].padre_dni);
            $("#fr_combo_cantor_id").val(reserva[0].cantor_dni);

            $("#fr_codigopago").html(reserva[0].pago_code);
            $("#fr_capilla").html(reserva[0].capilla_nombre);
            $("#fr_fecha").html(reserva[0].fecha_pago);
            $("#fr_cliente").html(reserva[0].cliente);
            $("#fr_tipoculto").html(reserva[0].tc_nombre);
            $("#fr_detalle_tipoculto").html('Detalle : ' + reserva[0].tipoculto_detalle);
            $("#fr_ofrece").html(reserva[0].ofrece);
            $("#fr_horario").html(reserva[0].horario);
            $("#fr_padre").html(reserva[0].padre);
            $("#fr_cantor").html(reserva[0].cantor);
            $("#fr_codigoreserva").html(reserva[0].code);
            $("#fr_fecha_hora").html(reserva[0].fecha_reserva);
            $("#fr_estado").html(reserva[0].estado);
            var total_limosna = 0;
            var total_templo = 0;
            var total_cantor = 0;
            if (reserva[0].tipoculto_type == 'Comunitario'){
                for (var i = 0; i < reserva.length; i++) {
                    total_limosna = total_limosna + parseFloat(reserva[i].limosna);
                    total_templo = total_templo + parseFloat(reserva[i].templo);
                    total_cantor = total_cantor + parseFloat(reserva[i].cantor);
                }
            }else{
                total_limosna = parseFloat(reserva[0].limosna);
                total_templo= parseFloat(reserva[0].templo);
                total_cantor= parseFloat(reserva[0].cantor);
            }

            if (reserva[0].tipoculto_type == 'Comunitario'){
                $("#fr_limosna").html(reserva[0].total);
                $("#fr_templo").html('-');
                $("#fr_cantor").html('-');
            }else{
                $("#fr_limosna").html(total_limosna.toFixed(2));
                $("#fr_templo").html(total_templo.toFixed(2));
                $("#fr_cantor").html(total_cantor.toFixed(2));
            }

            $("#fr_total").html(reserva[0].total);

            for (var i = 0; i < reserva.length; i++) {
                var fila = "<tr>" +
                    "<td>" + (i + 1) + "</td>" ;
                if (reserva[i].tipoculto_type == 'Comunitario') {
                    $("#fr_detalle_tipoculto").removeAttr('style');
                    $("#fr_detalle_tipoculto").attr('style','display:none');
                    fila += "<td>" + reserva[i].tipoculto_detalle + "</td>" ;

                }else{
                    $("#fr_detalle_detalle").removeAttr('style');
                    $("#fr_detalle_detalle").attr('style','display:none');
                    $("#fr_detalle_importe").removeAttr('style');
                    $("#fr_detalle_importe").attr('style','display:none');
                }
                fila +=  "<td>" + reserva[i].dirigido + "</td>" ;
                if (reserva[i].tipoculto_type == 'Comunitario') {
                    fila += "<td style='text-align: right'>s/. " + reserva[i].importe + "</td>";

                } else {
                    fila += "<td style='display: none;text-align: right'>s/. -</td>";

                }
                fila += "</tr>";

                $("#fr_detalle").append(fila);

            }

        }

    }, 2000);


}

function anular(id) {

    swal({
            title: "Pregunta",
            text: "Desea anular la reserva? ",
            confirmButtonColor: '#3d9205',
            confirmButtonText: 'SI',
            cancelButtonText: "NO",
            showCancelButton: true,
            closeOnConfirm: false,
            closeOnCancel: true,
            imageUrl: "../imagenes/preguntar.png"
        },
        function (isConfirm) {
            if (isConfirm) {
                var data = {
                    'reserva_id': id

                };

                console.log(data);
                $.ajax({
                    data: data,
                    url: "../controlador/reserva_anular.php",
                    type: "post",
                    success: function (resultado) {
                        console.log(resultado);
                        var datosJSON = resultado;
                        if (datosJSON.estado == 200) {
                            console.log(resultado.estado);
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
                                        window.location.href = '../vista/reserva_por_horario.php?horario_id=' + horario_id;
                                    }
                                });
                        }
                    },
                    error: function (error) {
                        console.log(error);
                        var datosJSON = $.parseJSON(error.responseText);
                    }
                });
            }
        });


}

function pagar(id) {
    swal({
            title: "Pregunta",
            text: "Desea efectuar el pago de esta reserva ? ",
            confirmButtonColor: '#3d9205',
            confirmButtonText: 'SI',
            cancelButtonText: "NO",
            showCancelButton: true,
            closeOnConfirm: false,
            closeOnCancel: true,
            imageUrl: "../imagenes/preguntar.png"
        },
        function (isConfirm) {
            if (isConfirm) {
                var data = {
                    'reserva_id': id

                };
                console.log(data);
                $.ajax({
                    data: data,
                    url: "../controlador/pago_reserva.php",
                    type: "post",
                    success: function (resultado) {
                        console.log(resultado);
                        var datosJSON = resultado;
                        if (datosJSON.estado == 200) {
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
                                        window.location.href = '../vista/reserva_por_horario.php?horario_id=' + horario_id;
                                    }
                                });
                        }
                    },
                    error: function (error) {
                        console.log(error);
                        var datosJSON = $.parseJSON(error.responseText);
                    }
                });
            }
        });
}

//COMBOS PARA CAMBIO DE CANTOR Y PADRE


function cargarPadreId(p_nombreCombo, capilla_id, padre_dni) {
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

                html += '<option value="' + item.per_iddni + '">' + item.padre + '</option>';
            });
            $(p_nombreCombo).html(html);
            if (padre_dni == null) {
                $(p_nombreCombo).removeAttr('disabled')

            } else {
                $(p_nombreCombo).val(padre_dni);

            }

        } else {
            swal("Mensaje del sistema", resultado, "warning");
        }
    }).fail(function (error) {
        var datosJSON = $.parseJSON(error.responseText);
        swal("Error", datosJSON.mensaje, "error");
    });
}

function cargarCantorId(p_nombreCombo, capilla_id, cantor_dni) {
    var data = {
        'capilla': capilla_id
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

            if (cantor_dni == null) {
                $(p_nombreCombo).removeAttr('disabled')

            } else {
                $(p_nombreCombo).val(cantor_dni);

            }


        } else {
            swal("Mensaje del sistema", resultado, "warning");
        }
    }).fail(function (error) {
        var datosJSON = $.parseJSON(error.responseText);
        swal("Error", datosJSON.mensaje, "error");
    });
}

function mostrar_modal_padre_cantor(capilla_ide, padre_dni, cantor_dni) {
    console.log(capilla_ide);
    console.log(padre_dni);
    console.log(cantor_dni);
    cargarPadreId("#fr_combo_padre_id", capilla_ide, padre_dni);
    cargarCantorId("#fr_combo_cantor_id", capilla_ide, cantor_dni);
}

function update_padre_cantor() {
    swal({
            title: "Confirme",
            text: "¿Esta seguro de guardar los cambios",
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

                var datos_frm = {
                    horario_id: horario_id,
                    padre_dni: $("#fr_combo_padre_id").val(),
                    cantor_dni: $("#fr_combo_cantor_id").val()

                };
                console.log(datos_frm);
                $.post
                (
                    "../controlador/horario_update_padre_cantor.php",
                    datos_frm
                ).done(function (resultado) {
                    console.log(resultado);
                    if (resultado.estado === 200) {
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
                                    window.location.href = '../vista/reserva_por_horario.php?horario_id=' + horario_id;
                                }
                            });
                    } else {
                        swal("Mensaje del sistema", resultado.mensaje, "warning");
                    }
                }).fail(function (error) {
                    console.log(error);
                    var datosJSON = $.parseJSON(error.responseText);
                    swal("Ocurrió un error", datosJSON.mensaje, "error");
                });


            }
        });
}