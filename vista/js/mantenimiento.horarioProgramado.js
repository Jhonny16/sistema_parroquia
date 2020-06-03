//JQuery

$(document).ready(function () {
    // alert("se esta ejecutando codigo JS")

    listar();
    cargarComboHora("#cboHora", "s");
});

function listar() {
    $.post
    (
        "../controlador/horarioProgramado.listar.controlador.php"
    ).done(function (resultado) {
        var datosJSON = resultado;
        if (datosJSON.estado === 200) {//validamos si el controlador se ha ejecutado correctamente

            var html = "";
            html += '<small>';
            html += '<table id="tabla-listado" class="table table-bordered table-striped">';
            html += '<thead>';
            html += '<tr style="background-color: #ededed; height:25px;">';
            html += '<th>CODIGO</th>';
            html += '<th>HORA</th>';
            html += '<th>DOM</th>';
            html += '<th>LUN</th>';
            html += '<th>MAR</th>';
            html += '<th>MIE</th>';
            html += '<th>JUE</th>';
            html += '<th>VIE</th>';
            html += '<th>SAB</th>';
            html += '<th>CAPILLA</th>';
            html += '<th>ANNO</th>';
            html += '<th style="text-align: center">OPCIONES</th>';
            html += '</tr>';
            html += '</thead>';
            html += '<tbody>';

            //Detalle
            $.each(datosJSON.datos, function (i, item) {
                html += '<tr>';
                html += '<td align="center">' + item.hp_id + '</td>';
                html += '<td>' + item.hora + '</td>';
                if (item.hp_domingo == 1) {
                    html += '<td style="text-align: center"><span class="pull-right badge bg-green">Activo</span></td>';
                } else {
                    html += '<td><span class="pull-right badge bg-red-gradient">No Activo</span></td>';
                }
                if (item.hp_lunes == 1) {
                    html += '<td style="text-align: center"><span class="pull-right badge bg-green">Activo</span></td>';
                } else {
                    html += '<td><span class="pull-right badge bg-red-gradient">No Activo</span></td>';
                }
                if (item.hp_martes == 1) {
                    html += '<td style="text-align: center"><span class="pull-right badge bg-green">Activo</span></td>';
                } else {
                    html += '<td><span class="pull-right badge bg-red-gradient">No Activo</span></td>';
                }
                if (item.hp_miercoles == 1) {
                    html += '<td style="text-align: center"><span class="pull-right badge bg-green">Activo</span></td>';
                } else {
                    html += '<td><span class="pull-right badge bg-red-gradient">No Activo</span></td>';
                }
                if (item.hp_jueves == 1) {
                    html += '<td style="text-align: center"><span class="pull-right badge bg-green">Activo</span></td>';
                } else {
                    html += '<td><span class="pull-right badge bg-red-gradient">No Activo</span></td>';
                }
                if (item.hp_viernes == 1) {
                    html += '<td style="text-align: center"><span class="pull-right badge bg-green">Activo</span></td>';
                } else {
                    html += '<td><span class="pull-right badge bg-red-gradient">No Activo</span></td>';
                }
                if (item.hp_sabado == 1) {
                    html += '<td style="text-align: center"><span class="pull-right badge bg-green">Activo</span></td>';
                } else {
                    html += '<td><span class="pull-right badge bg-red-gradient">No Activo</span></td>';
                }


                html += '<td>' + item.capilla + '</td>';
                html += '<td>' + item.anno_nombre + '</td>';
                html += '<td align="center">';
                html += '<button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#myModal" onclick="leerDatos(' + item.hp_id + ')"><i class="fa fa-pencil"></i></button>';
                html += '&nbsp;&nbsp;';
                html += '<button type="button" class="btn btn-danger btn-xs" onclick="eliminar(' + item.hp_id + ')"><i class="fa fa-close"></i></button>';
                html += '</td>';
                html += '</tr>';
            });

            html += '</tbody>';
            html += '</table>';
            html += '</small>';

            //Mostrar el resultado de la variable html en el div "listado"
            $("#listado").html(html);

            //Aplicar la funcion datatable a la tabla donde se muestra el resultado
            $('#tabla-listado').dataTable({
                "aaSorting": [[1, "asc"]] // 0 es la primera columan de la tabla, ordena por la primera columna
            });
        }

    }).fail(function (error) {
        var datosJSON = $.parseJSON(error.responseText);
        swal("Ocurrió un error", datosJSON.mensaje, "error");
    });
}

//Eliminar producto por el codigo del producto
function eliminar(par_id) {

    swal({
            title: "Confirme",
            text: "¿Esta seguro de eliminar el registro?",
            showCancelButton: true,
            confirmButtonColor: '#d93f1f',
            confirmButtonText: 'Si',
            cancelButtonText: "No",
            closeOnConfirm: false,
            closeOnCancel: true,
            imageUrl: "../imagenes/eliminar2.png"
        },
        function (isConfirm) {
            if (isConfirm) { //el usuario hizo clic en el boton SI
                $.post
                (
                    "../controlador/parroquia.eliminar.controlador.php",
                    {
                        p_par_id: par_id
                    }
                ).done(function (resultado) {
                    var datosJSON = resultado;

                    if (datosJSON.estado === 200) {
                        swal("Exito", datosJSON.mensaje, "success");
                        listar(); //actualizar la lista
                    } else {
                        swal("Mensaje del sistema", resultado, "warning");
                    }
                }).fail(function (error) {
                    var datosJSON = $.parseJSON(error.responseText);
                    swal("Ocurrió un error", datosJSON.mensaje, "error");
                });
            }
        });

}


$("#agregar_horario").click(function () {
    $("#operation").val("agregar");
    $("#titulomodal").html("Agregar una nueva Horario");
    limpiar();


});
function limpiar(){

    $("#txtCodigo").val("");
    $("#cboHora").val("");
    $("#chkDom").prop('checked',false);
    $("#chkLun").prop('checked',false);
    $("#chkMar").prop('checked',false);
    $("#chkMie").prop('checked',false);
    $("#chkJue").prop('checked',false);
    $("#chkVie").prop('checked',false);
    $("#chkSab").prop('checked',false);

    $("#txtAnnoNombre").val("");
}

$("#myModal").on("shown.bs.modal", function () {
    $("#cboHora").focus();
});


/*FUNCION GRABAR PARROQUIA*/
var dom = '';
var lun = '';
var mar = '';
var mier = '';
var jue = '';
var vie = '';
var sab = '';
$("#frmgrabar").submit(function (event) {
    event.preventDefault();

    if ($("#chkDom").prop('checked')) {
        dom = 1;
    } else {
        dom = 0;
    }
    if ($("#chkLun").prop('checked')) {
        lun = 1;
    } else {
        lun = 0;
    }
    if ($("#chkMar").prop('checked')) {
        mar = 1;
    } else {
        mar = 0;
    }
    if ($("#chkMie").prop('checked')) {
        mier = 1;
    } else {
        mier = 0;
    }
    if ($("#chkJue").prop('checked')) {
        jue = 1;
    } else {
        jue = 0;
    }
    if ($("#chkVie").prop('checked')) {
        vie = 1;
    } else {
        vie = 0;
    }
    if ($("#chkSab").prop('checked')) {
        sab = 1;
    } else {
        sab = 0;
    }

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
                    'domingo': dom,
                    'lunes': lun,
                    'martes': mar,
                    'miercoles': mier,
                    'jueves': jue,
                    'viernes': vie,
                    'sabado': sab,
                    'hora': $("#cboHora").val(),
                    'capilla': 1,
                    'anio': 2018,
                    'operation': $("#operation").val()
                }
                console.log(data);
                $.post
                (
                    "../controlador/programar_horarios_create_update.php",
                    data
                ).done(function (resultado) {
                    var datosJSON = resultado;
                    if (datosJSON.estado === 200) {
                        swal("Exito", datosJSON.mensaje, "success");
                        $("#btncerrar").click(); //Cerrar la ventana 
                        window.location  = '../vista/mantenimiento.horarioProgramado.vista.php';
                    } else {
                        swal("Mensaje del sistema", resultado, "warning");
                    }
                }).fail(function (error) {
                    var datosJSON = $.parseJSON(error.responseText);
                    swal("Ocurrió un error", datosJSON.mensaje, "error");
                });
            }
        });

});


function leerDatos(par_id) {
    limpiar();
    $.post
    (
        "../controlador/programar_horarios.leer.datos.controlador.php",
        {
            p_par_id: par_id
        }
    ).done(function (resultado) {
        var datosJSON = resultado;
        console.log(resultado);
        if (datosJSON.estado === 200) {
            $("#txtTipoOperacion").val("editar");
            $("#txtCodigo").val(datosJSON.datos.hp_id);
           if(datosJSON.datos.hp_domingo == 1){
                $("#chkDom").click();
           }
            if(datosJSON.datos.hp_lunes == 1){
                $("#chklun").click();
            }
            if(datosJSON.datos.hp_martes == 1){
                $("#chkmar").click();
            }if(datosJSON.datos.hp_miercoles == 1){
                $("#chkmie").click();
            }if(datosJSON.datos.hp_jueves== 1){
                $("#chkjue").click();
            }if(datosJSON.datos.hp_viernes == 1){
                $("#chkvie").click();
            }if(datosJSON.datos.hp_sabado == 1){
                $("#chksab").click();
            }
            $("#cboHora").val(datosJSON.datos.hora_id);
            $("#titulomodal").html("Editar Horario");

        } else {
            swal("Mensaje del sistema", resultado, "warning");
        }
    }).fail(function (error) {
        var datosJSON = $.parseJSON(error.responseText);
        swal("Ocurrió un error", datosJSON.mensaje, "error");
    });

}
