$(document).ready(function () {
    listar();
    list_capillas();
    lista_personas();
});

var operacion ="agregar";

function lista_personas() {
    $("#combo_persona").empty();

    $.post
    (
        "../controlador/persona_listar_controlador.php"
    ).done(function (resultado) {
        console.log(resultado);
        var datosJSON = resultado;
        console.log(resultado);
        if (datosJSON.estado === 200) {
            var html = "";
            html += '<option value="0">-- Seleccione Persona --</option>';
            $.each(datosJSON.datos, function (i, item) {
                var cargo = item.car_nombre;
                var nombre = item.per_apellido_paterno + ' ' + item.per_apellido_materno + ' ' + item.per_nombre;
                html += '<option value="' + item.per_iddni + '">' + nombre + '/ <strong>' + cargo + ' </strong></option>';
            });
            $("#combo_persona").append(html);
        } else {
            swal("Mensaje del sistema", resultado, "warning");
        }

    }).fail(function (error) {
        var datosJSON = $.parseJSON(error.responseText);
        //swal("Error", datosJSON.mensaje , "error");
    });
}

function listar() {
    var parroquia = $("#sesion_parroquia_id").val();
    var rol_id = $("#sesion_rol_id").val();
    var data = {
        'parroquia_id': parroquia,
        'rol_id': rol_id
    }
    console.log(data);
    $.post
    (
        "../controlador/asignacion_listar.php", data
    ).done(function (resultado) {
        var datosJSON = resultado;
        if (datosJSON.estado === 200) {//validamos si el controlador se ha ejecutado correctamente
            operacion = "agregar";
            var html = "";

            html += '<table id="tabla_asignacion" class="table table-bordered table-striped">' +
                '<thead>' +
                '<tr>' +
                '<th>#</th>' +
                '<th>SEL.</th>' +
                '<th>DNI</th>' +
                '<th>PERSONA</th>' +
                '<th>CAPILLAS ASIG.</th>' +
                '</tr>' +
                '</thead>' +
                '<tbody>';
            //Detall
            var num = 0;
            $.each(datosJSON.datos, function (i, item) {
                num = num + 1;
                html += '<tr>';
                html += '<td>' + num + '</td>';
                html += '<td>';
                html += '<input type="radio" name="rd_dni" class="flat-red" onclick="seleccion(' + item.per_iddni + ')" />';
                html += '</td>';
                html += '<td>' + item.per_iddni + '</td>';
                html += '<td>' + item.persona + '</td>';
                html += '<td align="center">';
                html += '<button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#mdl_capillas" onclick="detail(' + item.per_iddni + ')" ' +
                    'title="Editar"><i class="fa fa-th-list"></i></button>';
                html += '</td>';
                html += '</tr>';
            });
            html += '</tbody>';
            html += '</table>';
            //Mostrar el resultado de la variable html en el div "listado"
            $("#listado_asignacion").html(html);

            //Aplicar la funcion datatable a la tabla donde se muestra el resultado
            $('#tabla_asignacion').dataTable({
                "aaSorting": [[0, "asc"]] // 0 es la primera columan de la tabla, ordena por la primera columna
            });

        } else {
            $("#list_horarios").html("");
            swal("Nota", datosJSON.mensaje, "warning");
        }

    }).fail(function (error) {
        var datosJSON = $.parseJSON(error.responseText);
        swal("Ocurrió un error", datosJSON.mensaje, "error");
    });


}

var array_capillas = [];

function seleccion(dni) {
    console.log(dni);
    var data = {
        'dni': dni
    }
    console.log(data);
    $.post
    (
        "../controlador/asignacion_leer_dato.php", data
    ).done(function (resultado) {
        var datosJSON = resultado;
        console.log(resultado)
        if (datosJSON.estado === 200) {
            operacion = "editar";
            var arreglo = [];
            $("#combo_persona").val(resultado.datos[0].dni);
            var html = "";
            var sw = 0;

            for (var i = 0; i < array_capillas.length; i++) {
                //console.log(array_capillas[i].cap_id);
                for (var j = 0; j < resultado.datos.length; j++) {
                    if (array_capillas[i].cap_id == resultado.datos[j].capilla_id) {
                        console.log("#entro");
                        html += '<option value="' +array_capillas[i].cap_id + '" selected>' +
                            '' + array_capillas[i].cap_nombre + '</option>';
                        sw = 1;
                        break;

                    }
                }
                console.log("sw");
                console.log(sw);
                if(sw==1){

                }else{
                    html += '<option value="' + array_capillas[i].cap_id + '" >' + array_capillas[i].cap_nombre + '</option>';

                }

                sw=0;
            }
            //$("#combo_capillas").empty();
            $("#combo_capillas").html(html);

            //$("#combo_capillas").val(arreglo);

        } else {
            swal("Nota", datosJSON.mensaje, "warning");
        }

    }).fail(function (error) {
        var datosJSON = $.parseJSON(error.responseText);
        swal("Ocurrió un error", datosJSON.mensaje, "error");
    });
}

function detail(dni) {

    var data = {
        'dni': dni
    }
    console.log(data);
    $.post
    (
        "../controlador/asignacion_detalle_capillas.php", data
    ).done(function (resultado) {
        var datosJSON = resultado;
        if (datosJSON.estado === 200) {//validamos si el controlador se ha ejecutado correctamente

            var html = "";

            html += '<table id="tabla_detail" class="table table-bordered table-striped">' +
                '<thead>' +
                '<tr>' +
                '<th colspan="3">' + resultado.datos[0].per_iddni + ' : ' + resultado.datos[0].persona + ' </th>' +
                '</tr>' +
                '<tr>' +
                '<th>#</th>' +
                '<th>Capilla.</th>' +
                '<th>Parroquia</th>' +
                '</tr>' +
                '</thead>' +
                '<tbody>';
            //Detall
            var num = 0;
            $.each(datosJSON.datos, function (i, item) {
                num = num + 1;
                html += '<tr>';
                html += '<td>' + num + '</td>';
                html += '<td>' + item.cap_nombre + '</td>';
                html += '<td>' + item.par_nombre + '</td>';
                html += '</tr>';
            });
            html += '</tbody>';
            html += '</table>';
            //Mostrar el resultado de la variable html en el div "listado"
            $("#detalla_capillas").html(html);

            //Aplicar la funcion datatable a la tabla donde se muestra el resultado
            $('#tabla_detail').dataTable({
                "aaSorting": [[0, "asc"]] // 0 es la primera columan de la tabla, ordena por la primera columna
            });

        } else {
            $("#list_horarios").html("");
            swal("Nota", datosJSON.mensaje, "warning");
        }

    }).fail(function (error) {
        var datosJSON = $.parseJSON(error.responseText);
        swal("Ocurrió un error", datosJSON.mensaje, "error");
    });
}

function list_capillas() {
    $("#combo_capillas").html("");
    var parroquia_id = $("#sesion_parroquia_id").val();
    var rol_id = $("#sesion_rol_id").val();
    var data = {'parroquia': parroquia_id, 'rol_id' : rol_id};
    $.post
    (
        "../controlador/capillas_por_parroquia.php",
        data
    ).done(function (resultado) {
        var datosJSON = resultado;

        if (datosJSON.estado === 200) {
            var html = "";
            array_capillas = resultado.datos;

            $.each(datosJSON.datos, function (i, item) { //each para recorrer todos los elementos de array
                html += '<option value="' + item.cap_id + '">' + item.cap_nombre + '</option>';
            });

            $("#combo_capillas").html(html);
        } else {
            swal("Mensaje del sistema", resultado, "warning");
        }
    }).fail(function (error) {
        var datosJSON = $.parseJSON(error.responseText);
        swal("Error", datosJSON.mensaje, "error");
    });
}

function add_asignacion() {
    swal({
            title: "Confirme",
            text: "¿Esta seguro de grabar los datos ingresados?",
            showCancelButton: true,
            confirmButtonColor: '#3d9205',
            confirmButtonText: 'Si',
            cancelButtonText: "No",
            closeOnConfirm: false,
            closeOnCancel: true,
            imageUrl: "../imagenes/preguntar.png"
        },
        function (isConfirm) {
            if (isConfirm) { //el usuario hizo clic en el boton SI

                var data = {
                    dni: $("#combo_persona").val(),
                    capilla: $("#combo_capillas").val(),
                    operacion: operacion

                }
                console.log(data);

                $.post
                (
                    "../controlador/asignacion_agreagr_editar_controlador.php", data
                ).done(function (resultado) {
                    var datosJSON = resultado;
                    console.log(resultado);
                    if (datosJSON.estado === 200) {
                        swal({
                                title: "Genial",
                                text: resultado.mensaje,
                                confirmButtonColor: '#3d9205',
                                confirmButtonText: 'OK!',
                            },
                            function (isConfirm) {
                                if (isConfirm) {
                                    location.reload();
                                }
                            }
                        );
                    } else {
                        swal("Mensaje del sistema", resultado, "warning");
                    }
                }).fail(function (error) {
                    console.log(error);
                    var datosJSON = $.parseJSON(error.responseText);
                    swal("Ocurrió un error", datosJSON.mensaje, "error");
                });
            }
        });
}

function limpiar(){
    // $("#combo_persona").val("");
    // $("#combo_capillas").val("");
    window.location = "../vista/personal_asignacion.php";
}