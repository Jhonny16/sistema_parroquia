var operacion = "agregar";
var moment = moment().format('YYYY-MM-DD');

$(document).ready(function () {

    combo_capillas();
    combo_tipoculto();
    lista_precios();



});

function combo_capillas(){
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
                html += '<option value="0">Seleccione capilla</option>';

                $.each(resultado.datos, function (i, item) {
                    html += '<option value="' + item.cap_id + '">' + item.cap_nombre + '</option>';
                });

                $("#lp_cb_capill_id").html(html);
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

function combo_tipoculto(){
    $("#lp_cb_tipoculto_id").html("");


    $.ajax({
        url: "../controlador/tipoCulto.listar.controlador.php",
        type: "get",
        success: function (resultado) {
            if (resultado.estado === 200) {
                var html = "";
                html += '<option value="0">Seleccione tipo de culto</option>';
                $.each(resultado.datos, function (i, item) { //each para recorrer todos los elementos de array

                    html += '<option value="' + item.tc_id + '">' + item.tc_nombre+ ' / ' + item.culto + '</option>';
                });
                $("#lp_cb_tipoculto_id").html(html);
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

function lista_precios(){

    $("#lista_precios").html("");

    //var data = {'capilla_id': $("#sesion_capilla_id").val() };
    var parroquia_id = $("#sesion_parroquia_id").val();
    var rol_id = $("#sesion_rol_id").val();
    var data = {'parroquia_id': parroquia_id, 'rol_id' : rol_id};
    $.ajax({
        data: data,
        url: "../controlador/lista_precios_controlador.php",
        type: "post",
        success: function (resultado) {
            console.log(resultado);
            var datosJSON = resultado;

            if (datosJSON.estado == 200) {

                var html = "";
                html += '<table id="table_lista_precios" class="table table-bordered table-striped text-sm">';
                html += '<thead>';
                html += '<tr style="background-color: #17a2b8; width:25%;">';
                html += '<th style="text-align: center">OPCIONES</th>';
                html += '<th>PARROQUIA/CAPILLA</th>';
                html += '<th>TIPO DE CULTO</th>';
                html += '<th>S/. LIMOSNA</th>';
                html += '<th>S/. TEMPLO</th>';
                html += '<th>S/. CANTOR</th>';
                html += '<th>S/. PRECIO TOTAL</th>';
                html += '<th>FECHAS</th>';
                html += '<th>VIGENCIA</th>';
                html += '</tr>';
                html += '</thead>';
                html += '<tbody>';
                $.each(datosJSON.datos, function (i, item) {

                    html += '<td align="center">';
                    html += '<button type="button" class="btn btn-warning btn-xs" data-toggle="modal" ' +
                        'data-target="#mdl_lista_precios" onclick="read(' + item.id + ')"><i class="fa fa-pencil"></i></button>';
                    html += '</td>';
                    html += '<td>' + item.parroquia_capilla + '</td>';
                    html += '<td>' + item.tipo_culto + '</td>';
                    html += '<td style="text-align: right">s/. ' + item.limosna + '</td>';
                    html += '<td style="text-align: right">s/. ' + item.templo + '</td>';
                    html += '<td style="text-align: right">s/. ' + item.cantor + '</td>';
                    html += '<td style="text-align: right">s/. ' + item.precio + '</td>';
                    html += '<td>' + item.fechas + '</td>';
                    html += '<td>' + item.vigencia + '</td>';
                    html += '</tr>';
                });
                html += '</tbody>';
                html += '</table>';

                $("#lista_precios").html(html);
                $("#table_lista_precios").DataTable({
                    "aaSorting": [[0, "asc"]]
                });
            }

        },
        error: function (error) {
            console.log(error);
            var datosJSON = $.parseJSON(error.responseText);
            swal("Error", datosJSON.mensaje, "error");
        }
    });

}

function limpiar(){
    $("#lp_id").val("");
    $("#lp_cb_tipoculto_id").val("0");
    $("#lp_cb_capill_id").val("0");

    $("#lp_fecha_inicio").val(moment);
    $("#lp_fecha_fin").val(moment);
    $("#lp_limosna").val("0.00");
    $("#lp_templo").val("0.00");
    $("#lp_cantor").val("0.00");
    $("#lp_precio_total").val("0.00");
}

$("#btnadd_listaprecios").click(function () {
    limpiar();
    operacion = 'agregar';
    $("#title_lista_precios").html('Nuevo');

});

$("#lp_limosna").change(function(){
    calculo_precio_total();
});

$("#lp_templo").change(function(){
    calculo_precio_total();
});

$("#lp_cantor").change(function(){
    calculo_precio_total();
});


function calculo_precio_total(){
    var limosna = $("#lp_limosna").val();
    var templo = $("#lp_templo").val();
    var cantor = $("#lp_cantor").val();

    total = parseFloat(limosna) + parseFloat(templo) + parseFloat(cantor);
    console.log(total);
    $("#lp_precio_total").val(total);


}

function read(id) {
    var data = {'lp_id': id };
    $.ajax({
        data: data,
        url: "../controlador/lista_precios_read.php",
        type: "post",
        success: function (resultado) {
            console.log(resultado);
            var datosJSON = resultado;

            if (datosJSON.estado == 200) {

                limpiar();
                operacion = 'editar';
                $("#title_lista_precios").html('Editar');

                var data = datosJSON.datos;
                $("#lp_id").val(data.id);
                $("#lp_cb_capill_id").val(data.capilla_id);
                $("#lp_cb_tipoculto_id").val(data.tipo_culto_id);
                $("#lp_fecha_inicio").val(data.fecha_inicio);
                $("#lp_fecha_fin").val(data.fecha_fin);
                $("#lp_limosna").val(data.limosna);
                $("#lp_templo").val(data.templo);
                $("#lp_cantor").val(data.cantor);
                $("#lp_precio_total").val(data.precio);

            }

        },
        error: function (error) {
            console.log(error);
            var datosJSON = $.parseJSON(error.responseText);
            swal("Error", datosJSON.mensaje, "error");
        }
    });
}


function create_update(){
    var data = {
        'capilla_id': $("#lp_cb_capill_id").val() ,
        'tipoculto_id': $("#lp_cb_tipoculto_id").val(),
        'fecha_inicio': $("#lp_fecha_inicio").val() ,
        'fecha_fin': $("#lp_fecha_fin").val() ,
        'limosna': $("#lp_limosna").val() ,
        'templo': $("#lp_templo").val() ,
        'cantor': $("#lp_cantor").val() ,
        'precio': $("#lp_precio_total").val(),
        'id': $("#lp_id").val(),
        'operation': operacion
    };
    console.log(data);
    $.ajax({
        data: data,
        url: "../controlador/lista_precios_create_update.php",
        type: "post",
        success: function (res) {
            if (res.estado == 200){
                swal({title: "Exito",text: res.mensaje , type: "success"},function(isConfirm){
                    if (isConfirm) {
                        lista_precios();
                        $("#lp_btn_close").click();
                    }
                });
            }
            else{
                swal("Ocurrió un error", res.mensaje, "warning");

            }


        },
        error: function (error) {
            console.log(error);
            var datosJSON = $.parseJSON(error.responseText);
            swal("Error", datosJSON.mensaje, "error");
        }
    });


}


