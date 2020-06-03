$(document).ready(function () {
    listar_reservas();

});

function listar_reservas(){
    var fecha1 = $("#busqueda_fecha1").val();
    var fecha2 = $("#busqueda_fecha2").val();
    var dni = $("#sesion_dni").val();
    var data = {
        'fecha_inicio': fecha1,
        'fecha_fin': fecha2,
        'dni': dni
    }
    console.log(data);
    $.post
    (
        "../controlador/reserva_listar_por_cliente.php", data
    ).done(function (resultado) {
        var datosJSON = resultado;
        console.log(resultado);
        if (datosJSON.estado === 200) {//validamos si el controlador se ha ejecutado correctamente

            var html = "";

            html += '<table id="tabla_reservas" class="table table-bordered table-striped">' +
                '<thead>' +
                '<tr>'+
                '<th  style="text-align: center">#</th>'+
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
            var cont =0
            $.each(datosJSON.datos, function (i, item) {
                cont = cont + 1;
                html += '<tr>';
                html += '<td style="text-align:center">'+ cont +'</td>';
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
            //swal("Nota", datosJSON.mensaje, "warning");
        }

    }).fail(function (error) {
        var datosJSON = $.parseJSON(error.responseText);
        swal("Ocurrió un error", datosJSON.mensaje, "error");
    });


}