var horario_id = 0;
var reserva_id = 0;
var persona_dni = '0';
var list_reservas = [];
var ides = [];

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
        "../controlador/reserva_horario_lista_filtros.php",data
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
                html2 += '<option value="' + item.persona_dni + '">' + item.persona_dni +' / '+item.persona_nombre + '</option>';
            });
            $("#busqueda_persona_dni").html(html2);

            html3 += '<option value="0">Seleccione código</option>';
            $.each(datosJSON.datos, function (i, item) {
                html3 += '<option value="' + item.reserva_id + '">' + item.reserva_code + '</option>';
            });
            $("#busqueda_reserva_id").html(html3);

            getUrlVars();


        } else {
            swal("Mensaje del sistema", resultado, "warning");
        }
    }).fail(function (error) {
        var datosJSON = $.parseJSON(error.responseText);
        swal("Error", datosJSON.mensaje, "error");
    });
}


function getUrlVars() {
    var vars = {};
    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
        vars[key] = value;
    });
    console.log(vars.horario_id);
    if (vars.horario_id >= 1){
        horario_id = vars.horario_id;
        console.log("horario_id");
        console.log(horario_id);
        $("#busqueda_horario_id").val(horario_id);
    }

    buscar_reservas();

}

$("#busqueda_horario_id").change(function(){
    horario_id = $("#busqueda_horario_id").val();
});
$("#busqueda_persona_dni").change(function(){
    persona_dni = $("#busqueda_persona_dni").val();
});
$("#busqueda_reserva_id").change(function(){
    reserva_id = $("#busqueda_reserva_id").val();
});



function buscar_reservas(){


    var data = {
        'horario_id': horario_id,
        'reserva_id': reserva_id,
        'persona_dni': persona_dni

    };
    console.log(data);

    if(horario_id == 0 && reserva_id ==0 && persona_dni == '0'){
        $("#list_reservas_horario").html("<p style='text-align: center; color: #999580'><strong>No hay resultados</strong></p>");
        swal("Mensaje", "Debe seleccionar al menos algún filtro para la búsqueda", "info");
    }else{
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
                        '<tr style="background-color: #00c0ef; color: white">'+
                        '<th  style="text-align: center">Opción</th>'+
                        '<th>Código reserva</th>'+
                        '<th>Horario</th>'+
                        '<th>Estado</th>'+
                        '<th>Ofrece(n)</th>'+
                        '<th>Cliente</th>'+
                        '<th>Padre</th>'+
                        '<th>Cantor</th>'+
                        '<th>total</th>'+
                        '</tr>'+
                        '</thead>'+
                        '<tbody>';
                    //Detalle
                    $.each(datosJSON.datos, function (i, item) {
                        //Adicionamos el id de la reserva para la generacion del pdf

                        sw=0;
                        if(ides.length == 0){
                            ides.push(item.id);
                        }else{

                            for(var i=0; i < ides.length; i++){
                                if (ides[i] == item.id){
                                    sw=1;
                                    break;
                                }
                            }
                            if(sw==0){
                                ides.push(item.id);
                            }
                        }
                        console.log(ides);

                        if(sw==0){
                            $("#user_name").val($("#sesion_user_name").val());

                            html += '<tr>';
                            html += '<td style="text-align: center">';
                            html += '<a style="cursor:pointer" class="nav-link" onclick="ver_comprobante('+ item.id +')">' +
                                '<i class="fa fa-eye text-info" title="Detalle completo"></i></a> &nbsp;';
                            html += '<a style="cursor:pointer" class="nav-link" onclick="anular('+ item.id +')">' +
                                '<i class="fa fa-trash-o text-orange" title="Anular reserva"></i></a> &nbsp;';
                            if(item.estado != 'Pagado'){
                                html += '<a style="cursor:pointer" class="nav-link" onclick="pagar('+ item.id +')">' +
                                    '<i class="fa fa-credit-card text-success" title="Pagar reserva"></i></a> &nbsp;';
                            }

                            html += '</td>';
                            html += '<td>' + item.code + '</td>';
                            html += '<td>' + item.horario+ '</td>';

                            if(item.estado == 'Pagado'){
                                html += '<td style="text-align: center"><span class="badge bg-blue">'+ item.estado +'</span></td>';
                            }else{
                                if(item.estado == 'Anulado'){
                                    html += '<td style="text-align: center"><span class="badge bg-orange">'+ item.estado +'</span></td>';

                                }else{
                                    html += '<td style="text-align: center"><span class="badge bg-yellow">'+ item.estado +'</span></td>';

                                }
                            }
                            html += '<td>' + item.ofrece + '</td>';


                            html += '<td>' + item.cliente + '</td>';
                            html += '<td>' + item.padre + '</td>';
                            html += '<td>' + item.cantor + '</td>';
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

                }else{
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
    $("#fr_estado").html("");
    $("#fr_subtotal").html("");
    $("#fr_detalle").html("");
    $("#fr_total").html("");
}

function ver_comprobante(id){
    $("#reserva_id").val(id);

    limpiar_formato();
    $("#formato_reserva").attr('style','display:none')
    $("#load").append('<img src="../imagenes/load.gif" alt="">');

    setTimeout(function(){
        $("#load").empty();
        $("#formato_reserva").removeAttr('style');
        var reserva = [];
        for(var i=0; i<list_reservas.length; i++){
            if(id == list_reservas[i].id){
                reserva.push(list_reservas[i]);
            }

        }
        console.log(reserva);
        if (reserva != null){
            $("#fr_codigopago").html(reserva[0].pago_code);
            $("#fr_fecha").html(reserva[0].fecha);
            $("#fr_cliente").html(reserva[0].cliente);
            $("#fr_ofrece").html(reserva[0].ofrece);
            $("#fr_horario").html(reserva[0].horario);
            $("#fr_padre").html(reserva[0].padre);
            $("#fr_cantor").html(reserva[0].cantor);
            $("#fr_detail").html(reserva[0].detail_comunitaria);
            $("#fr_codigoreserva").html(reserva[0].code);
            $("#fr_estado").html(reserva[0].estado);
            $("#fr_estado").html(reserva[0].estado);
            $("#fr_subtotal").html(reserva[0].total);
            $("#fr_total").html(reserva[0].total);

            for (var i=0; i<reserva.length; i++){
                var fila =   "<tr>"+
                    "<td>" + (i)+1 + "</td>"+
                    "<td>" + reserva[i].dirigido + "</td>"+
                    "<td style=\"text-align: right\">" + reserva[i].importe + "</td>"+
                    "</tr>";

                $("#fr_detalle").append(fila);

            }

        }

    }, 2200);



}

function anular(id){

    swal({
            title: "Pregunta",
            text: "Desea anular la reserva? ",
            confirmButtonColor: '#3d9205',
            confirmButtonText: 'SI',
            cancelButtonText: "NO",
            showCancelButton: true,
            closeOnConfirm: true,
            closeOnCancel: true,
            imageUrl: "../imagenes/preguntar.png"
        },
        function (isConfirm) {
            if (isConfirm){
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
                        if (datosJSON.estado === 200) {
                            swal("Exito!", datosJSON.mensaje , "success");
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

function pagar(id){
    swal({
            title: "Pregunta",
            text: "Desea efectuar el pago de esta reserva ? ",
            confirmButtonColor: '#3d9205',
            confirmButtonText: 'SI',
            cancelButtonText: "NO",
            showCancelButton: true,
            closeOnConfirm: true,
            closeOnCancel: true,
            imageUrl: "../imagenes/preguntar.png"
        },
        function (isConfirm) {
            if (isConfirm){
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
                        if (datosJSON.estado === 200) {

                            swal("Exito!", datosJSON.mensaje , "success");
                            buscar_reservas();
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