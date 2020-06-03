/**
 * Created by tito_ on 18/12/2018.
 */
$(document).ready(function () {
    cargarBusquedaCapillaReport("#busqueda_capilla");

});
function cargarBusquedaCapillaReport(p_nombreCombo) {
    var cargo = $("#cargo_id").val()
    var capilla_id = $("#sesion_capilla_id").val()
    var rol_id = $("#sesion_rol_id").val()
    var data = {'p_cargo': cargo,'capilla_id': capilla_id,'rol_id': rol_id};
    $.post
    (
        "../controlador/capilla.listar.controlador.php",data
    ).done(function (resultado) {
        var datosJSON = resultado;

        if (datosJSON.estado === 200) {
            var html = "";

            html += '<option value="">Seleccione Capillassss</option>';
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
function listar_utilidades(){
    var fecha1 = $("#busqueda_fecha_incial").val();
    var fecha2 = $("#busqueda_fecha_final").val();
    var capilla = $("#busqueda_capilla").val();


    if(capilla == null){
        capilla = 0;
    }

    var data = {
        'fecha_inicio': fecha1,
        'fecha_fin': fecha2,
        'capilla': capilla
    }
    console.log(data);
    $.post
    (
        "../controlador/capilla_listar_vista_controlador.php", data
    ).done(function (resultado) {
        var datosJSON = resultado;
        if (datosJSON.estado === 200) {//validamos si el controlador se ha ejecutado correctamente
            var suma = 0.00;
            var html = "";

            html += '<table id="tabla_list_utilidades" class="table table-bordered table-striped">' +
                '<thead>' +
                '<tr>'+
                '<th>DNI</th>'+
                '<th>CLIENTE</th>'+
                '<th>CELEBRACION</th>'+
                '<th>HORA</th>'+
                '<th>FECHA</th>'+
                '<th>TELEFONO</th>'+
                '<th>ESTADO</th>'+
                '<th>TOTAL</th>'+
                '</tr>'+
                '</thead>'+
                '<tbody>';
            //Detalle
            $.each(datosJSON.datos, function (i, item) {
                suma = parseFloat(item.total) + suma;
                html += '<tr>';
                html += '<td>' + item.cliente_dni+ '</td>';
                html += '<td>' + item.cliente + '</td>';
                html += '<td>' + item.celebracion+ '</td>';
                html += '<td>' + item.hora_hora + '</td>';
                html += '<td>' + item.fecha + '</td>';
                html += '<td>' + item.telefono + '</td>';
                html += '<td>' + item.estado + '</td>';
                html += '<td>' + item.total + '</td>';
                html += '</tr>';
            });
            html += '</tbody>';
            html += '<tfoot>';
            html += '<tr>';
            html += '<th colspan="7" style="text-align:center">TOTAL</th>';
            html += '<th>'+ suma +'</th>';
            html += '</tr>';
            html += '</tfoot>';
            html += '</table>';

            $("#list_utilidades").html(html);

            $('#tabla_list_utilidades').dataTable({
                "aaSorting": [[0, "asc"]]
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
