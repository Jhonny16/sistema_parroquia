/**
 * Created by tito_ on 15/12/2018.
 */

var array = [];
var mes = []
$(document).ready(function () {
    // alert("se esta ejecutando codigo JS")

    //listar();
    cargarBusquedaCapilla("#busqueda_capilla");
    cargarBusquedaTipoCulto("#busqueda_tipoculto");
    cargarBusquedaHora("#busqueda_hora", "s");
});

function cargarBusquedaCapilla(p_nombreCombo) {
    var dni = $("#sesion_dni").val();
    var data = {'dni': dni};
    $.post
    (
        "../controlador/capillas_por_dni_group_parroquia.php",data
    ).done(function (resultado) {
        var datosJSON = resultado;

        if (datosJSON.estado === 200) {
            var html = "";

            html += '<option value="0">Seleccione Capilla</option>';
            $.each(datosJSON.datos, function (i, item) { //each para recorrer todos los elementos de array
                html += '<option value="' + item.cap_id + '">' + item.cap_nombre+ ' / ' + item.cap_direccion + '</option>';
            });
            $(p_nombreCombo).html(html);
            $("#busqueda_capilla").html(html);
        } else {
            swal("Mensaje del sistema", resultado, "warning");
        }
    }).fail(function (error) {
        var datosJSON = $.parseJSON(error.responseText);
        swal("Error", datosJSON.mensaje, "error");
    });
}

function cargarBusquedaTipoCulto(p_nombreCombo) {
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
            $("#combo_tipoculto").html(html);
        } else {
            swal("Mensaje del sistema", resultado, "warning");
        }
    }).fail(function (error) {
        var datosJSON = $.parseJSON(error.responseText);
        swal("Error", datosJSON.mensaje, "error");
    });
}

function cargarBusquedaHora(p_nombreCombo, p_tipo){
    $.post
    (
        "../controlador/hora.cargar.combo.controlador.php"

    ).done(function(resultado){
        var datosJSON = resultado;

        if (datosJSON.estado===200){
            var html = "";
            if (p_tipo==="s"){
                html += '<option value="">Seleccione una hora</option>';
            }else{
                html += '<option value="0"></option>';
            }


            $.each(datosJSON.datos, function(i,item) { //each para recorrer todos los elementos de array
                html += '<option value="'+item.hora_id+'">'+item.hora_hora+'</option>';
            });

            $(p_nombreCombo).html(html);
        }else{
            swal("Mensaje del sistema", resultado , "warning");
        }
    }).fail(function(error){
        var datosJSON = $.parseJSON( error.responseText );
        swal("Error", datosJSON.mensaje , "error");
    });
}

function listar(){
    var fecha1 = $("#busqueda_date1").val();
    var fecha2 = $("#busqueda_date2").val();
    var hora = $("#busqueda_hora").val();
    var tipo_culto = $("#busqueda_tipoculto").val();
    var capilla = $("#busqueda_capilla").val();

    if(capilla == "0"){
        swal("Nota","Selecione Capilla", "warning");
        return 0;
    }
    if(hora == null || hora== ""){
        hora = 0;
    }
    if(tipo_culto == null){
        tipo_culto = 0;
    }
    if(capilla == null){

        capilla = 0;
    }

    var data = {
        'fecha1': fecha1,
        'fecha2': fecha2,
        'hora': hora,
        'tipo_culto': tipo_culto,
        'capilla': capilla
    }
    console.log(data);
    $.post
    (
        "../controlador/horario_listar_controlador.php", data
    ).done(function (resultado) {
        var datosJSON = resultado;
        if (datosJSON.estado === 200) {//validamos si el controlador se ha ejecutado correctamente

            var html = "";

            html += '<table id="tabla_horarios" class="table table-bordered table-striped">' +
                '<thead>' +
                '<tr>'+
                '<th>#</th>'+
                '<th>HORA</th>'+
                '<th>TIPO CULTO</th>'+
                '<th>FECHA</th>'+
                '<th>FECHA</th>'+
                '<th>DIA SEMANA</th>'+
                '<th>ESTADO</th>'+
                '<th style="text-align: center">SEL.</th>'+
                '</tr>'+
                '</thead>'+
                '<tbody>';
            //Detalle
            $.each(datosJSON.datos, function (i, item) {
                html += '<tr>';
                html += '<td>' + item.id + '</td>';
                html += '<td>' + item.hora_hora + '</td>';
                html += '<td>' + item.tc_nombre + '</td>';
                html += '<td>' + item.fecha + '</td>';
                html += '<td>' + item.dia_semana + '</td>';
                html += '<td>' + item.cap_nombre + '</td>';
                if(item.estado == 'Disponible'){
                    html += '<td style="text-align: center"><span class="pull-right badge bg-green">'+ item.estado +'</span></td>';
                }else{
                    html += '<td style="text-align: center"><span class="pull-right badge bg-yellow-active">'+ item.estado +'</span></td>';
                }
                html += '<td style="text-align: center">';
                html += '<input type="checkbox" class="flat-red" onclick="seleccion(' + item.id + ')">';
                html += '</td>';
                html += '</tr>';
            });
            html += '</tbody>';
            html += '</table>';
            //Mostrar el resultado de la variable html en el div "listado"
            $("#list_horarios").html(html);

            //Aplicar la funcion datatable a la tabla donde se muestra el resultado
            $('#tabla_horarios').dataTable({
                "aaSorting": [[0, "asc"]] // 0 es la primera columan de la tabla, ordena por la primera columna
            });

        }else{
            $("#list_horarios").html("");
            swal("Nota", datosJSON.mensaje, "warning");
        }

    }).fail(function (error) {
        var datosJSON = $.parseJSON(error.responseText);
        swal("Ocurrió un error", datosJSON.mensaje, "error");
    });


}

function seleccion(id) {
    var sw=0;
    //console.log(id);
    if (array.length == 0){
        array.push(id);
    }else{
        for(var i=0; i < array.length; i++){
            console.log(array[i]);
            if(array[i] === id){
                array.splice(i, 1);
                break;
            }else{
                if(i == (array.length - 1)){
                    sw = 1
                }

            }
        }
    }

    if(sw==1){
        array.push(id);
    }

    console.log(array);


}


function anular(){
    var data = {'array' : array};
    console.log(data);

    swal({
            title: "Confirme",
            text: "¿Desea anular este item del horario?",
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
                $.post
                (
                    "../controlador/horario_low_controlador.php", data
                ).done(function (resultado) {
                    var datosJSON = resultado;
                    if (datosJSON.estado === 200) {//validamos si el controlador se ha ejecutado correctamente
                        swal("Exito", datosJSON.mensaje, "success");
                        listar();
                    }else{
                        swal("Nota", datosJSON.mensaje, "warning");
                    }

                }).fail(function (error) {
                    var datosJSON = $.parseJSON(error.responseText);
                    swal("Ocurrió un error", datosJSON.mensaje, "error");
                });
            }
        });

}

function eliminar(){
    var data = {'array' : array};

    swal({
            title: "Confirme",
            text: "¿Desea eliminar este item del horario?",
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
                $.post
                (
                    "../controlador/horario_delete_controlador.php", data
                ).done(function (resultado) {
                    var datosJSON = resultado;
                    if (datosJSON.estado === 200) {//validamos si el controlador se ha ejecutado correctamente
                        swal("Exito", datosJSON.mensaje, "success");
                        listar();;
                    }else{
                        swal("Nota", datosJSON.mensaje, "warning");
                    }

                }).fail(function (error) {
                    var datosJSON = $.parseJSON(error.responseText);
                    swal("Ocurrió un error", datosJSON.mensaje, "error");
                });
            }
        });

}
