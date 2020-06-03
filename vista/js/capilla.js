$(document).ready(function () {
    // alert("se esta ejecutando codigo JS")
    cargaParroquia();
    listar();
});
var type_id=null;

function cargaParroquia() {
    $("#combo_paroquia").html("");
    $.post
    (
        "../controlador/parroquia.listar.controlador.php"
    ).done(function (resultado) {
        var datosJSON = resultado;

        if (datosJSON.estado === 200) {
            var html = "";
            html += '<option value="">Seleccione Parroquia</option>';
            $.each(datosJSON.datos, function (i, item) { //each para recorrer todos los elementos de array

                html += '<option value="' + item.par_id + '">' + item.par_nombre + '</option>';
            });
            $("#combo_paroquia").html(html);
        } else {
            swal("Mensaje del sistema", resultado, "warning");
        }
    }).fail(function (error) {
        var datosJSON = $.parseJSON(error.responseText);
        swal("Error", datosJSON.mensaje, "error");
    });
}


function listar() {
    $.post
    (
        "../controlador/capilla_list_controlador.php"
    ).done(function (resultado) {
        var datosJSON = resultado;
        if (datosJSON.estado === 200) {//validamos si el controlador se ha ejecutado correctamente

            var html = "";
            html += '<small>';
            html += '<table id="tabla-listado" class="table table-bordered table-striped">';
            html += '<thead>';
            html += '<tr style="background-color: #ededed; height:25px;">';
            html += '<th>#</th>';
            html += '<th>NOMBRE</th>';
            html += '<th>DIRECCION</th>';
            html += '<th>ESTADO</th>';
            html += '<th>PARROQUIA</th>';
            html += '<th style="text-align: center">EDITAR</th>';
            html += '</tr>';
            html += '</thead>';
            html += '<tbody>';

            //Detalle
            var num = 0;
            $.each(datosJSON.datos, function (i, item) {
                num = num + 1;
                html += '<tr>';
                html += '<td align="center">' + num + '</td>';
                html += '<td>' + item.cap_nombre + '</td>';
                html += '<td>' + item.cap_direccion + '</td>';
                if (item.cap_estado == true) {
                    html += '<td style="text-align: center"><span class="pull-right badge bg-green">Activo</span></td>';
                } else {
                    html += '<td><span class="pull-right badge bg-red-gradient">No Activo</span></td>';
                }
                html += '<td>' + item.par_nombre + '</td>';
                if (item.cap_estado == true) {
                    html += '<td align="center">';
                    html += '<button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#myModal" onclick="leerDatos(' + item.cap_id + ',\'+ 0 +\')" ' +
                        'title="Editar"><i class="fa fa-pencil"></i></button>';
                    html += '</td>';
                } else {
                    html += '<td align="center">';
                    console.log(item.paroquia);
                    if (item.parroquia == true) {

                    }else{
                        html += '<button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#myModal"' +
                            'title="Editar" onclick="leerDatos(' + item.cap_id + ',\'+ 0 +\')"><i class="fa fa-pencil"></i></button>';
                        html += '<button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#myModal" ' +
                            'title="Pasar a Parroquia" onclick="leerDatos(' + item.cap_id + ',' + 1 + ')"><i class="fa fa-bank"></i></button>';
                    }

                    html += '</td>';

                }

                html += '</tr>';
            });
            html += '</tbody>';
            html += '</table>';
            html += '</small>';

            //Mostrar el resultado de la variable html en el div "listado"
            $("#listado").html(html);

            //Aplicar la funcion datatable a la tabla donde se muestra el resultado
            $('#tabla-listado').dataTable({
                "aaSorting": [[0, "asc"]] // 0 es la primera columan de la tabla, ordena por la primera columna
            });
        }

    }).fail(function (error) {
        var datosJSON = $.parseJSON(error.responseText);
        swal("Ocurrió un error", datosJSON.mensaje, "error");
    });
}


$("#btnagregar").click(function () {
    $("#txtTipoOperacion").val("agregar");
    $("#titulomodal").html("Agregar una nueva Capilla");
    $("#txtCodigo").val("");
    $("#nombre").val("");
    $("#direccion").val("");
    $("#combo_paroquia").val("");
    $("#pasar_parroquia").iCheck('uncheck');
});

$("#myModal").on("shown.bs.modal", function () {
    $("#txtNombre").focus();
});
var estado = 1;
$('#activo').on('ifChecked', function (event) {
    estado = 1

});
$('#no_activo').on('ifChecked', function (event) {
    estado = 0;
});

/*FUNCION GRABAR PARROQUIA*/
$("#frmgrabar").submit(function (event) {
    event.preventDefault();
    var tipo =$("#txtTipoOperacion").val();
    console.log(tipo);

    if(pasar_parroquia == 0 &&  (type_id == 0 || type_id == '0')){
        swal("Nota", "No habrá ningun cambio", "warning");
        return 0;
    }else{
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
                        p_id: $("#txtCodigo").val(),
                        p_nombre: $("#nombre").val(),
                        p_direccion: $("#direccion").val(),
                        p_estado: estado,
                        p_parroquia: $("#combo_paroquia").val(),
                        p_tipo_operacion: $("#txtTipoOperacion").val(),
                        p_pasar_parroquia: pasar_parroquia

                    }
                    console.log(data);

                    $.post
                    (
                        "../controlador/capila_agregar_editar_controlador.php", data
                    ).done(function (resultado) {
                        var datosJSON = resultado;

                        if (datosJSON.estado === 200) {
                            swal("Exito", datosJSON.mensaje, "success");
                            $("#btncerrar").click(); //Cerrar la ventana
                            listar(); //actualizar la lista
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



});
var pasar_parroquia = 0;
$('#pasar_parroquia').on('ifChecked', function (event) {
    pasar_parroquia = 1;
    $("#div_estado").attr('style', 'display:none');
});
$('#pasar_parroquia').on('ifUnchecked', function (event) {
    pasar_parroquia = 0;
    $("#div_estado").removeAttr('style');

});

function leerDatos(id, type) {
    type_id = type;
    $("#pasar_parroquia").iCheck('uncheck');

        $.post
        (
            "../controlador/capilla_leer_contrlador.php",
            {
                p_id: id
            }
        ).done(function (resultado) {
            var datosJSON = resultado;
            console.log(resultado);
            if (datosJSON.estado === 200) {
                $("#txtTipoOperacion").val("editar");
                $("#txtCodigo").val(datosJSON.datos.cap_id);
                $("#nombre").val(datosJSON.datos.cap_nombre);
                $("#direccion").val(datosJSON.datos.cap_direccion);
                if (datosJSON.datos.cap_estado == true) {
                    $("#activo").iCheck('check');
                } else {
                    $("#no_activo").iCheck('check');
                }

                $("#combo_paroquia").val(datosJSON.datos.par_id);

                $("#titulomodal").html("Editar datos de la Capilla");

                if (type == '1' || type == 1) {
                    $("#div_pasar_parroquia").removeAttr('style');
                    $("#div_parroquia").attr('style', 'display:none');

                } else {
                    $("#div_pasar_parroquia").attr('style', 'display:none');
                    $("#div_parroquia").removeAttr('style');
                }

            } else {
                swal("Mensaje del sistema", resultado, "warning");
            }
        }).fail(function (error) {
            var datosJSON = $.parseJSON(error.responseText);
            swal("Ocurrió un error", datosJSON.mensaje, "error");
        });

}
