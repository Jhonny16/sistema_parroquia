/**
 * Created by tito_ on 17/12/2018.
 */
var capilla_id = null;
$(document).ready(function () {
    cargarBusquedaCapillaID("#busqueda_capilla_id");
    cargarBusquedaCelebracionId("#busqueda_celebracion");

    var  cargo= $("#cargo_id").val();
    console.log(cargo);
    if (cargo == 3 || cargo =='3'){
        $("#div_aprobar_precio").attr('style','display:none');
        $("#div_aprobar_precio_ext").attr('style','display:none');
    }

});
function cargarBusquedaCapillaID(p_nombreCombo) {
    var cargo = $("#cargo_id").val()
    var data = {'p_cargo': cargo};
    $.post
    (
        "../controlador/capilla.listar.controlador.php",data
    ).done(function (resultado) {
        var datosJSON = resultado;

        if (datosJSON.estado === 200) {
            var html = "";

            html += '<option value="">Seleccione Capilla</option>';
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
function cargarBusquedaCelebracionId(p_nombreCombo) {
    $.post
    (
        "../controlador/celebracion.listar.controlador.php"
    ).done(function (resultado) {
        var datosJSON = resultado;

        if (datosJSON.estado === 200) {
            var html = "";
            html += '<option value="">Seleccione Celebracion</option>';
            $.each(datosJSON.datos, function (i, item) { //each para recorrer todos los elementos de array
                html += '<option value="' + item.cel_id + '">' + item.cel_nombre + '</option>';
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

function listar_reservas(){
    var fecha1 = $("#busqueda_fecha1").val();
    var fecha2 = $("#busqueda_fecha2").val();
    var celebracion = $("#busqueda_celebracion").val();
    var capilla = $("#busqueda_capilla_id").val();
    var estado = $("#busqueda_estado").val();
    var type = $("#busqueda_type").val();

    if(celebracion ==null || celebracion== ""){
        tipo_culto = 0;
    }
    if(capilla == null){
        capilla = 0;
    }

    var data = {
        'fecha_inicio': fecha1,
        'fecha_fin': fecha2,
        'estado': estado,
        'celebracion': celebracion,
        'type': type,
        'capilla': capilla
    }
    console.log(data);
    $.post
    (
        "../controlador/intencion_listar_controlador.php", data
    ).done(function (resultado) {
        var datosJSON = resultado;
        if (datosJSON.estado === 200) {//validamos si el controlador se ha ejecutado correctamente

            var html = "";

            html += '<table id="tabla_reservas" class="table table-bordered table-striped">' +
                '<thead>' +
                '<tr>'+
                '<th  style="text-align: center">OPCIONES</th>'+
                '<th>CODE</th>'+
                '<th>DNI</th>'+
                '<th>CLIENTE</th>'+
                '<th style="text-align: center">ESTADO</th>'+
                '<th>TOTAL</th>'+
                '<th>FECHA</th>'+
                '<th>HORA</th>'+
                '<th>CELEBRACION</th>'+
                '<th>TIPO</th>'+
                '</tr>'+
                '</thead>'+
                '<tbody>';
            //Detalle
            $.each(datosJSON.datos, function (i, item) {
                html += '<tr>';
                html += '<td style="text-align:center">' +
                    '<a type="button" title="Cambiar estado" data-toggle="modal" onclick="ide('+ item.id+')" ' +
                'data-target="#modal_estado"><i class="fa fa-recycle text-aqua"></i></a>' +
                    '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="intencion" class="minimal" onclick="seleccion_list('+ item.id+')">' +
                    '</td>';
                html += '<td>' + item.code + '</td>';
                html += '<td>' + item.cliente_dni+ '</td>';
                html += '<td>' + item.cliente + '</td>';
                if(item.estado == 'Pagado'){
                    html += '<td style="text-align:center"><span class="pull-right badge bg-green">'+ item.estado +'</span></td>';
                }else{
                    if(item.estado == 'Anulado'){
                        html += '<td style="text-align:center"><span class="pull-right badge bg-yellow-active">'+ item.estado +'</span></td>';
                    }else {
                        html += '<td style="text-align:center"><span class="pull-right badge bg-red-gradient">' + item.estado + '</span></td>';
                    }
                }
                html += '<td>' + item.total+ '</td>';
                html += '<td>' + item.fecha+ '</td>';
                html += '<td>' + item.hora_hora+ '</td>';
                html += '<td>' + item.celebracion+ '</td>';
                html += '<td>' + item.type+ '</td>';
                html += '</tr>';
            });
            html += '</tbody>';
            html += '</table>';
            //Mostrar el resultado de la variable html en el div "listado"
            $("#list_reservas").html(html);

            //Aplicar la funcion datatable a la tabla donde se muestra el resultado
            $('#tabla_reservas').dataTable({
                "aaSorting": [[0, "asc"]] // 0 es la primera columan de la tabla, ordena por la primera columna
            });

        }else{
            $("#list_reservas").html("");
            swal("Nota", datosJSON.mensaje, "warning");
        }

    }).fail(function (error) {
        var datosJSON = $.parseJSON(error.responseText);
        swal("Ocurrió un error", datosJSON.mensaje, "error");
    });


}

function ide(id){
    console.log(id);
    $("#intencion_id").val(id);

}

function actualizar_estado(){
    var estado = $("#combo_estado_actualizar").val();
    var data = {
        'estado' : estado,
        'intencion_id':  $("#intencion_id").val()
    };
    console.log(data);
    swal({
            title: "Confirme",
            text: "Desea cambiar el estado de la intención?",
            showCancelButton: true,
            confirmButtonColor: '#3d9205',
            confirmButtonText: 'Si',
            cancelButtonText: "No",
            closeOnConfirm: false,
            closeOnCancel: true,
            imageUrl: "../imagenes/preguntar.png"
        },
        function(isConfirm) {
            $.post
            (
                "../controlador/intencion_estado_update_controlador.php",data
            ).done(function (resultado) {
                var datosJSON = resultado;

                if (datosJSON.estado === 200) {
                    swal("Bien", resultado.memsaje, "success");
                    $("#estado_close").click();
                } else {
                    swal("Mensaje del sistema", resultado.mensaje, "warning");
                }
            }).fail(function (error) {
                var datosJSON = $.parseJSON(error.responseText);
                swal("Error", datosJSON.mensaje, "error");
            });
        })


}

function seleccion_list(id){
    console.log(id);
    $("#int_id").val(id)
}