$(document).ready(function () {
    cargarCapillaId("#busqueda_capilla_id");
    $("#user_id").val($("#sesion_user_name").val());

});

function cargarCapillaId(p_nombreCombo) {
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
                html += '<option value="0" >--Todas--</option>';

                var sw=0;
                $.each(resultado.datos, function (i, item) {
                    console.log(item.is_parroquia)
                    if (item.is_parroquia == true){
                        html += '<option value="' + item.cap_id + '">' + item.cap_nombre + '</option>';

                    }else{
                        console.log(item.cap_id)
                        console.log($("#sesion_capilla_id").val());
                        if (item.cap_id == parseInt($("#sesion_capilla_id").val())){
                            sw=1;
                            html += '<option value="' + item.cap_id + '" selected>' + item.cap_nombre + '</option>';


                        }

                    }
                });
                $(p_nombreCombo).html(html);
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


function listado(){


    var data = {
        'capilla_id': $("#busqueda_capilla_id").val(),
        'anio': $("#busqueda_anio").val()

    };

    console.log(data);
    $.ajax({
        data: data,
        url: "../controlador/reporte_caja.php",
        type: "post",
        success: function (resultado) {
            console.log(resultado);
            var datosJSON = resultado;
            if (datosJSON.estado === 200) {
                var ingresos = resultado.datos[0];
                var egresos = resultado.datos[1];
                $("#lista_ingresos").html("");
                $("#lista_egresos").html("");

                var html = "";
                html += '<table id="table_ingresos" class="table table-bordered table-hover">' +
                    '<thead>' +
                    '<tr><th style="font-style: oblique;color: #01a189" colspan="15">Ingresos año ' + $("#busqueda_anio").val() + ' : </th></tr>'+
                    '<tr style="background-color: #01a189; color: white">' +
                    '<th  style="text-align: center; background-color: #005b80">#.</th>' +
                    '<th style="background-color: #005b80">Estipendio</th>' +
                    '<th>Enero</th>' +
                    '<th>Febrero</th>' +
                    '<th>Marzo</th>' +
                    '<th>Abril</th>' +
                    '<th>Mayo</th>' +
                    '<th>Junio</th>' +
                    '<th>Julio</th>' +
                    '<th>Agosto</th>' +
                    '<th>Setiembre</th>' +
                    '<th>Octubre</th>' +
                    '<th>Noviembre</th>' +
                    '<th>Diciembre</th>' +
                    '<th style="background-color: #278383">Total</th>' +
                    '</tr>' +
                    '</thead>' +
                    '<tbody>';
                var suma = 0;
                var enero=0,febrero=0,marzo=0,abril=0,mayo=0,junio=0,julio=0,agosto=0,setiembre=0,octubre=0,noviembre=0,diciembre = 0;
                $.each(ingresos, function (i, item) {
                    html += '<tr>';
                    var total = parseFloat(item.enero)
                                + parseFloat(item.febrero)
                                + parseFloat(item.marzo)
                                + parseFloat(item.abril)
                                + parseFloat(item.mayo)
                                + parseFloat(item.junio)
                                + parseFloat(item.julio)
                                + parseFloat(item.agosto)
                                + parseFloat(item.setiembre)
                                + parseFloat(item.octubre)
                                + parseFloat(item.noviembre)
                                + parseFloat(item.diciembre)
                    suma = suma + total;
                    enero = enero + parseFloat(item.enero);
                    febrero = febrero + parseFloat(item.febrero);
                    marzo = marzo + parseFloat(item.marzo);
                    abril = abril + parseFloat(item.abril);
                    mayo = mayo + parseFloat(item.mayo);
                    junio = junio + parseFloat(item.junio);
                    julio = julio + parseFloat(item.julio);
                    agosto = agosto + parseFloat(item.agosto);
                    setiembre = setiembre + parseFloat(item.setiembre);
                    octubre = octubre + parseFloat(item.octubre);
                    noviembre = noviembre + parseFloat(item.noviembre);
                    diciembre = diciembre + parseFloat(item.diciembre);

                    html += '<td style="background-color: #c9c9c9" >' + (i+1) + '</td>';
                    html += '<td style="background-color: #e3e3e3">' + item.tc_nombre + '</td>';
                    html += '<td style="text-align: right">' + item.enero + '</td>';
                    html += '<td style="text-align: right">' + item.febrero + '</td>';
                    html += '<td style="text-align: right">' + item.marzo + '</td>';
                    html += '<td style="text-align: right">' + item.abril + '</td>';
                    html += '<td style="text-align: right">' + item.mayo + '</td>';
                    html += '<td style="text-align: right">' + item.junio + '</td>';
                    html += '<td style="text-align: right">' + item.julio + '</td>';
                    html += '<td style="text-align: right">' + item.agosto + '</td>';
                    html += '<td style="text-align: right">' + item.setiembre + '</td>';
                    html += '<td style="text-align: right">' + item.octubre + '</td>';
                    html += '<td style="text-align: right">' + item.noviembre + '</td>';
                    html += '<td style="text-align: right">' + item.diciembre + '</td>';
                    html += '<td style="text-align: right;background-color: #ececec">s/. ' + total.toFixed(2) + '</td>';
                    html += '</tr>';

                });
                html += '</tbody>';
                html += '<tfoot style="color: #1b7f7a">';
                html += '<tr style="background-color: #f8f2f2">';
                html += '<th colspan="2" style="text-align:center">TOTAL</th>';
                html += '<th style="text-align: right">s/. '+ enero.toFixed(2) +'</th>';
                html += '<th style="text-align: right">s/. '+ febrero.toFixed(2) +'</th>';
                html += '<th style="text-align: right">s/. '+ marzo.toFixed(2) +'</th>';
                html += '<th style="text-align: right">s/. '+ abril.toFixed(2) +'</th>';
                html += '<th style="text-align: right">s/. '+ mayo.toFixed(2) +'</th>';
                html += '<th style="text-align: right">s/. '+ junio.toFixed(2) +'</th>';
                html += '<th style="text-align: right">s/. '+ julio.toFixed(2) +'</th>';
                html += '<th style="text-align: right">s/. '+ agosto.toFixed(2) +'</th>';
                html += '<th style="text-align: right">s/. '+ setiembre.toFixed(2) +'</th>';
                html += '<th style="text-align: right">s/. '+ octubre.toFixed(2) +'</th>';
                html += '<th style="text-align: right">s/. '+ noviembre.toFixed(2) +'</th>';
                html += '<th style="text-align: right">s/. '+ diciembre.toFixed(2) +'</th>';
                html += '<th style="text-align: right">s/. '+ suma.toFixed(2) +'</th>';
                html += '</tr>';
                html += '</tfoot>';
                html += '</table>';
                $("#lista_ingresos").html(html);

                var html2 = "";
                html2 += '<table id="table_egresos" class="table table-bordered table-hover">' +
                    '<thead>' +
                    '<tr><th style="font-style: oblique;color: #01a189" colspan="15">Egresos año ' + $("#busqueda_anio").val() + ' : </th></tr>'+
                    '<tr style="background-color: #01a189; color: white">' +
                    '<th  style="text-align: center; background-color: #005b80">#.</th>' +
                    '<th style="background-color: #005b80">Cantor</th>' +
                    '<th>Enero</th>' +
                    '<th>Febrero</th>' +
                    '<th>Marzo</th>' +
                    '<th>Abril</th>' +
                    '<th>Mayo</th>' +
                    '<th>Junio</th>' +
                    '<th>Julio</th>' +
                    '<th>Agosto</th>' +
                    '<th>Setiembre</th>' +
                    '<th>Octubre</th>' +
                    '<th>Noviembre</th>' +
                    '<th>Diciembre</th>' +
                    '<th style="background-color: #278383">Total</th>' +
                    '</tr>' +
                    '</thead>' +
                    '<tbody>';
                var suma_e = 0;
                var enero_e=0,febrero_e=0,marzo_e=0,abril_e=0,mayo_e=0,junio_e=0,julio_e=0,agosto_e=0,setiembre_e=0,octubre_e=0,noviembre_e=0,diciembre_e = 0;
                $.each(egresos, function (i, item) {
                    html += '<tr>';
                    var total = parseFloat(item.enero)
                                + parseFloat(item.febrero)
                                + parseFloat(item.marzo)
                                + parseFloat(item.abril)
                                + parseFloat(item.mayo)
                                + parseFloat(item.junio)
                                + parseFloat(item.julio)
                                + parseFloat(item.agosto)
                                + parseFloat(item.setiembre)
                                + parseFloat(item.octubre)
                                + parseFloat(item.noviembre)
                                + parseFloat(item.diciembre)
                    suma_e = suma_e + total;
                    enero_e = enero_e + parseFloat(item.enero);
                    febrero_e = febrero_e + parseFloat(item.febrero);
                    marzo_e = marzo_e + parseFloat(item.marzo);
                    abril_e = abril_e + parseFloat(item.abril);
                    mayo_e = mayo_e + parseFloat(item.mayo);
                    junio_e = junio_e + parseFloat(item.junio);
                    julio_e = julio_e + parseFloat(item.julio);
                    agosto_e = agosto_e + parseFloat(item.agosto);
                    setiembre_e = setiembre_e + parseFloat(item.setiembre);
                    octubre_e = octubre_e + parseFloat(item.octubre);
                    noviembre_e = noviembre_e + parseFloat(item.noviembre);
                    diciembre_e = diciembre_e + parseFloat(item.diciembre);

                    html2 += '<td style="background-color: #c9c9c9" >' + (i+1) + '</td>';
                    html2 += '<td style="background-color: #e3e3e3">' + item.cantor + '</td>';
                    html2 += '<td style="text-align: right">' + item.enero + '</td>';
                    html2 += '<td style="text-align: right">' + item.febrero + '</td>';
                    html2 += '<td style="text-align: right">' + item.marzo + '</td>';
                    html2 += '<td style="text-align: right">' + item.abril + '</td>';
                    html2 += '<td style="text-align: right">' + item.mayo + '</td>';
                    html2 += '<td style="text-align: right">' + item.junio + '</td>';
                    html2 += '<td style="text-align: right">' + item.julio + '</td>';
                    html2 += '<td style="text-align: right">' + item.agosto + '</td>';
                    html2 += '<td style="text-align: right">' + item.setiembre + '</td>';
                    html2 += '<td style="text-align: right">' + item.octubre + '</td>';
                    html2 += '<td style="text-align: right">' + item.noviembre + '</td>';
                    html2 += '<td style="text-align: right">' + item.diciembre + '</td>';
                    html2 += '<td style="text-align: right;background-color: #ececec">s/. ' + total.toFixed(2) + '</td>';
                    html2 += '</tr>';

                });
                html2 += '</tbody>';
                html2 += '<tfoot style="color: #1b7f7a">';
                html2 += '<tr style="background-color: #f8f2f2">';
                html2 += '<th colspan="2" style="text-align:center">TOTAL</th>';
                html2 += '<th style="text-align: right">s/. '+ enero_e.toFixed(2) +'</th>';
                html2 += '<th style="text-align: right">s/. '+ febrero_e.toFixed(2) +'</th>';
                html2 += '<th style="text-align: right">s/. '+ marzo_e.toFixed(2) +'</th>';
                html2 += '<th style="text-align: right">s/. '+ abril_e.toFixed(2) +'</th>';
                html2 += '<th style="text-align: right">s/. '+ mayo_e.toFixed(2) +'</th>';
                html2 += '<th style="text-align: right">s/. '+ junio_e.toFixed(2) +'</th>';
                html2 += '<th style="text-align: right">s/. '+ julio_e.toFixed(2) +'</th>';
                html2 += '<th style="text-align: right">s/. '+ agosto_e.toFixed(2) +'</th>';
                html2 += '<th style="text-align: right">s/. '+ setiembre_e.toFixed(2) +'</th>';
                html2 += '<th style="text-align: right">s/. '+ octubre_e.toFixed(2) +'</th>';
                html2 += '<th style="text-align: right">s/. '+ noviembre_e.toFixed(2) +'</th>';
                html2 += '<th style="text-align: right">s/. '+ diciembre_e.toFixed(2) +'</th>';
                html2 += '<th style="text-align: right">s/. '+ suma_e.toFixed(2) +'</th>';
                html2 += '</tr>';
                html2 += '</tfoot>';
                html2 += '</table>';
                $("#lista_egresos").html(html2);

                // $('#table_ingresos').dataTable({
                //     "aaSorting": [[2, "asc"]],
                //     "bScrollCollapse": true,
                //     "bPaginate": true,
                //
                // });

            } else {
                $("#lista_ingresos").empty();
                $("#lista_egresos").empty();
                swal("Nota",  "No hay resultados en la búsqueda.", "warning");
            }

        },
        error: function (error) {
            console.log(error);
            var datosJSON = $.parseJSON(error.responseText);
        }
    });


}