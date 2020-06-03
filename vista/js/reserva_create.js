/**
 * Created by tito_ on 16/12/2018.
 */
var lista_horarios = [];
var detalle = []
$(document).ready(function () {
    cargarCapillaId("#combo_capilla_id");
    cargarTipoCultoId("#combo_tipoculto_id");
    cargarClienteId("#combo_cliente_id");
    //cargarPadreId("#combo_padre_id");

});

$("#nueva_reserva").click(function () {
    //$("#operation").val("agregar");
    $("#content_create_reserva").removeAttr('style');
    $("#content_lista_reserva").attr('style','display:none');

//    limpiar();


});
function cargarCapillaId(p_nombreCombo) {
    var dni = $("#sesion_dni").val()
    var data = {'dni': dni};

    console.log(data);
    $.post
    (
        "../controlador/capillas_listar_por_dni.php",data
    ).done(function (resultado) {
        console.log(resultado);

        var datosJSON = resultado;

        if (datosJSON.estado === 200) {
            var html = "";

            html += '<option value="0">Seleccione Capilla</option>';
            $.each(datosJSON.datos, function (i, item) { //each para recorrer todos los elementos de array
                html += '<option value="' + item.cap_id + '">' + item.cap_nombre+ ' / ' + item.cap_direccion + '</option>';
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

                html += '<option value="' + item.tc_id + '">' + item.tc_nombre+ ' / ' + item.culto + '</option>';
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

$("#combo_capilla_id").change(function(){
    cargarPadreId("#combo_padre_id");
});

function cargarPadreId(p_nombreCombo) {
    var data = {
        'capilla' : $("#combo_capilla_id").val()
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
            $(p_nombreCombo).html(html);
        } else {
            swal("Mensaje del sistema", resultado, "warning");
        }
    }).fail(function (error) {
        var datosJSON = $.parseJSON(error.responseText);
        swal("Error", datosJSON.mensaje, "error");
    });
}

function verificar(){
    var tipo_culto = $("#combo_tipoculto_id").val();
    var capilla = $("#combo_capilla_id").val();

    if(tipo_culto == null){
        tipo_culto = 0;
    }
    if(capilla == null){
        capilla = 0;
    }

    var data = {
        'tipo_culto': tipo_culto,
        'capilla': capilla
    }
    console.log(data);
    $.post
    (
        "../controlador/horario_verificar_controlador.php", data
    ).done(function (resultado) {
        var datosJSON = resultado;
        if (datosJSON.estado === 200) {//validamos si el controlador se ha ejecutado correctamente
            lista_horarios = datosJSON.datos;
            var html = "";

            html += '<table id="tabla_horarios_verificacion" class="table table-bordered table-striped">' +
                '<thead>' +
                '<tr>'+
                '<th style="text-align: center">SEL.</th>'+
                '<th>HORA</th>'+
                '<th>FECHA</th>'+
                '<th>DIA SEMANA</th>'+
                '<th style="text-align: center">TIPO</th>'+
                '</tr>'+
                '</thead>'+
                '<tbody>';
            //Detalle
            $.each(datosJSON.datos, function (i, item) {
                html += '<tr>';
                html += '<td style="text-align: center">';
                html += '<input type="radio" name="radio_horario" class="flat-red" onclick="seleccion(' + item.id + ')">';
                html += '</td>';
                html += '<td>' + item.hora_hora + '</td>';
                html += '<td>' + item.fecha + '</td>';
                html += '<td>' + item.dia_semana + '</td>';
                if(item.estado == 'comunitario'){
                    html += '<td style="text-align:center"><span class="pull-right badge bg-green">'+ item.tipo +'</span></td>';
                }else{
                    html += '<td style="text-align:center"><span class="pull-right badge bg-purple-gradient">'+ item.tipo +'</span></td>';
                }

                html += '</tr>';
            });
            html += '</tbody>';
            html += '</table>';
            //Mostrar el resultado de la variable html en el div "listado"
            $("#horarios").html(html);

            //Aplicar la funcion datatable a la tabla donde se muestra el resultado
            $('#tabla_horarios_verificacion').dataTable({
                "aaSorting": [[0, "asc"]] ,
                "sScrollX": "100%",
                "sScrollXInner": "100%",
                "bScrollCollapse": true,
                "bPaginate": true
            });

        }else{
            $("#horarios").html("");
            swal("Nota", datosJSON.mensaje, "warning");
        }

    }).fail(function (error) {
        var datosJSON = $.parseJSON(error.responseText);
        swal("Ocurrió un error", datosJSON.mensaje, "error");
    });
}

function seleccion(id) {

    console.log(detalle.length);
    for(var i=0; i < lista_horarios.length ; i++){
        if(lista_horarios[i].id == id){
                comparar_fecha(lista_horarios[i].tiempo,lista_horarios[i].fecha,id);
            break;
        }
    }


    
}
function llenar_data_form(id){
    if(detalle.length > 0){
        for(var i=0; i < lista_horarios.length ; i++){
            console.log(lista_horarios);
            if(lista_horarios[i].id == id){
                var fec = $("#fecha_ref").val();
                var hor =  $("#hora_ref").val();
                console.log(fec);
                console.log(lista_horarios[i].fecha);
                if(fec != lista_horarios[i].fecha){
                    swal("Nota",'La fecha ingresada en el detalle es diferente a la seleccionada', "info");
                    return 0;
                }else{
                    if( hor != lista_horarios[i].hora_hora){
                        swal("Nota",'La hora ingresada en el detalle es diferente a la seleccionada', "info");
                        return 0;
                    }else{
                        add(id);
                    }
                }
            }
        }
    }else{
        add(id);
    }
}

function comparar_fecha(dias, fecha,id){
    console.log("Emtrooo");
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
            $("#btn_editar").removeAttr('style');
            swal("Bien!", resultado.mensaje, "info");
            llenar_data_form(id);
        } else {
            if(datosJSON.estado === 203){
                console.log("maluu");

                swal("Nota", resultado.mensaje, "info");
            }
        }
    }).fail(function (error) {
        console.log(error);
        var datosJSON = $.parseJSON(error.responseText);
        //swal("Error", datosJSON.mensaje, "error");
    });

}

function add(id){
    var type = $("#type").val();
    console.log(id);
    for(var i=0; i < lista_horarios.length ; i++){
        console.log(lista_horarios);
        if(lista_horarios[i].id == id){
            if( type == 'Individual' && detalle.length > 0){
                swal("Nota",'El tipo de culto es indiviual por lo tanto no puede agregar mas de un item', "info");
                return 0;
            }else{
                $("#fecha_ref").val(lista_horarios[i].fecha);
                $("#hora_ref").val(lista_horarios[i].hora_hora);
                $("#precio").val(lista_horarios[i].tc_precio);
                $("#horario_id").val(lista_horarios[i].id);
                $("#type").val(lista_horarios[i].tipo);
                break;
            }
        }
    }
}
$('#aprobacion').on('ifChecked', function (event) {
    $("#combo_padre_id").removeAttr('disabled');
    $("#precio").removeAttr('disabled');
});
$('#aprobacion').on('ifUnchecked', function (event) {
    $("#combo_padre_id").attr('disabled','disabled');
    $("#precio").attr('disabled','disabled');

});

function plus_add(){
    var type=$("#type").val();
    console.log(type);

    var codigo   = $("#horario_id").val();
    var dirigido   = $("#dirigido").val();
    var costo = $("#precio").val();
    console.log(dirigido);
    if( $("#dirigido").val() == ""){
        swal("Nota",'Ingrese el campo : "Dirigido a ... "', "info");
        return false;
    }

    var fila =   "<tr>"+
        "<td align=\"center\" id=\"celiminar\"><a href=\"javascript:void();\"><i class=\"fa fa-trash text-orange\"></i></a></td>"+
        "<td>"+ codigo +"</td>"+
        "<td>" + dirigido + "</td>"+
        "<td style=\"text-align: right\">" + costo + "</td>"+
        "</tr>";

    var cont =0
    $("#detalle tr").each(function () {
        cont = cont+ 1;
    });


    if(type == 'Individual' && cont >= 1){
        swal("Nota",'El tipo de culto es indiviual por lo tanto no puede agregar mas de un item', "info");
        $("#dirigido").val("");
        return 0;
    }else{
        detalle.push(codigo);
        $("#detalle").append(fila);
        $("#precio").val("0");
        calcularTotales();
    }



}

function calcularTotales() {
    var importeNeto = 0;
    $("#detalle tr").each(function () {
        var importe = $(this).find("td").eq(3).html();
        importeNeto = importeNeto + parseFloat(importe);
    });
    $("#total").html(importeNeto.toFixed(2));
}

$(document).on("click", "#celiminar", function(){
    if (! confirm("Esta seguro de elimina el registro seleccionado")){
        return 0;
    }
    var fila = $(this).parents().get(0); //capturar la fila que deseamos eliminar
    fila.remove(); //eliminar la fila
    calcularTotales();
    detalle.pop();
});


var arrayDetalle = new Array(); //permite almacenar todos los productos agregados en el detalle de la venta

function save_reserv() {

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
        function(isConfirm){
            if (isConfirm){ //el usuario hizo clic en el boton SI
                arrayDetalle.splice(0, arrayDetalle.length);
                /*RECORREMOS CADA FILA DE LA TABLA DONDE ESTAN LOS PRODUCTOS VENDIDOS*/
                $("#detalle tr").each(function () {
                    var horario = $(this).find("td").eq(1).html();
                    var dirigido = $(this).find("td").eq(2).html();
                    var importe = $(this).find("td").eq(3).html();

                    var objDetalle = new Object(); //Crear un objeto para almacenar los datos

                    /*declaramos y asignamos los valores a los atributos*/
                    objDetalle.horario = horario;
                    objDetalle.dirigido = dirigido;
                    objDetalle.importe = importe;
                    arrayDetalle.push(objDetalle);

                });
                var jsonDetalle = JSON.stringify(arrayDetalle);
                var datos_frm = {

                    padre: $("#combo_padre_id").val(),
                    cliente: $("#combo_cliente_id").val(),
                    total: $("#total").html(),
                    detalle: jsonDetalle,
                    estado: $("#combo_estado").val(),
                    capilla: $("#combo_capilla_id").val(),
                    cantor: $("#combo_cantor_id").val(),
                    reserva_id: $("#reserva_id").val(),
                    ofrece: $("#ofrece").val(),
                    detail: $("#combo_detail_id").val(),
                    operacion: operacion

                };
                console.log(datos_frm);
                $.post
                (
                    "../controlador/intencion.agregar.editar.controlador.php",
                    datos_frm
                ).done(function(resultado){
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
                                if (isConfirm){
                                    sms_cliente(resultado.datos);
                                }
                            });



                    }else{
                        swal("Mensaje del sistema", resultado , "warning");
                    }
                }).fail(function(error){
                    console.log(error);
                    var datosJSON = $.parseJSON( error.responseText );
                    swal("Ocurrió un error", datosJSON.mensaje , "error");
                });


            }
        });

}

function clear_reserv(){
    window.location.href = '../vista/reserva_vista.php';
}

function sms_cliente(id){
    console.log(id);
    var data = {'id': id};
    console.log(data);
    $.post
    (
        "../controlador/reserva_sms-controlador.php", data
    ).done(function(resultado){
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
                    if (isConfirm){
                        window.location.href = '../vista/reserva_vista.php';
                    }

                })


            swal("Exito", datosJSON.mensaje, "success");
            window.location.href = '../vista/reserva_vista.php';
        }else{
            swal("Mensaje del sistema", resultado , "warning");
        }
    }).fail(function(error){
        console.log(error);
        var datosJSON = $.parseJSON( error.responseText );
        swal("Ocurrió un error", datosJSON.mensaje , "error");
    });

}