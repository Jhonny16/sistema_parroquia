

function lista_reservas($horario_id){


    var data = {
        'horario_id': horario_id
    };

    console.log(data);
    $.ajax({
        data: data,
        url: "../controlador/reserva_horario_lista.php",
        type: "post",
        success: function (resultado) {
            console.log(resultado);
            var datosJSON = resultado;
            if (datosJSON.estado === 200) {//validamos si el controlador se ha ejecutado correctamente
                list_horarios_reservas = resultado.datos;
                $("#reserva_lista").html(html);

                var html = "";

                html += '<table id="table_reserva_horario_lista" class="table table-bordered table-striped">' +
                    '<thead>' +
                    '<tr>'+
                    '<th  style="text-align: center">#</th>'+
                    '<th>Code</th>'+
                    '<th>Horario</th>'+
                    '<th>Estado</th>'+
                    '<th>Ofrece(n)</th>'+
                    '<th>Cliente</th>'+
                    '<th>Padre</th>'+
                    '<th>Cantor</th>'+
                    '<th>Total</th>'+
                    '</tr>'+
                    '</thead>'+
                    '<tbody>';
                //Detalle
                $.each(datosJSON.datos, function (i, item) {
                    html += '<tr>';

                    html += '<td style="text-align: center">';
                    html += '<input type="radio" name="radio_reserva_id" class="flat-red" onclick="horario_selection(' + item.id + ')">';
                    html += '</td>';
                    html += '<td>' + item.code + '</td>';
                    html += '<td>' + item.horario + '</td>';
                    if(item.estado == 'Pagado'){
                        html += '<td style="text-align: center"><span class="badge bg-green">'+ item.estado +'</span></td>';
                    }else{
                        html += '<td style="text-align: center"><span class="badge bg-yellow-active">'+ item.estado +'</span></td>';
                    }
                    html += '<td>' + item.ofrece + '</td>';
                    html += '<td>' + item.cliente + '</td>';
                    html += '<td>' + item.padre + '</td>';
                    html += '<td>' + item.cantor + '</td>';
                    html += '<td style="text-align: right">s/.' + item.total + '</td>';

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
                });

            }else{
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