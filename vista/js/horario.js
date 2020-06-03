combo_hora/**
 * Created by tito_ on 15/12/2018.
 */
$(document).ready(function () {
    // alert("se esta ejecutando codigo JS")

    //listar();
    cargarComboCapilla("#combo_capilla");
    cargarComboTipoCulto("#combo_tipoculto");
    cargarComboHora("#combo_hora");
});

$("#agregar_horario").click(function () {
    $("#operation").val("agregar");
    $("#titulomodal").html("Agregar una nuevo Horario");
     limpiar();


});
// function cargarComboCapilla(p_nombreCombo) {
//     var cargo = $("#cargo_id").val()
//     var data = {'p_cargo': cargo};
//     $.post
//     (
//         "../controlador/capilla.listar.controlador.php",data
//     ).done(function (resultado) {
//         var datosJSON = resultado;
//
//         if (datosJSON.estado === 200) {
//             var html = "";
//
//             html += '<option value="0">Seleccione Capilla</option>';
//             $.each(datosJSON.datos, function (i, item) { //each para recorrer todos los elementos de array
//                 html += '<option value="' + item.cap_id + '">' + item.cap_nombre+ ' / ' + item.cap_direccion + '</option>';
//             });
//             $(p_nombreCombo).html(html);
//             $("#busqueda_capilla").html(html);
//         } else {
//             swal("Mensaje del sistema", resultado, "warning");
//         }
//     }).fail(function (error) {
//         var datosJSON = $.parseJSON(error.responseText);
//         swal("Error", datosJSON.mensaje, "error");
//     });
// }

function cargarComboCapilla(p_nombreCombo) {
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
function cargarComboTipoCulto(p_nombreCombo) {
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

function cargarComboHora(p_nombreCombo){
    $.post
    (
        "../controlador/hora.cargar.combo.controlador.php"

    ).done(function(resultado){
        var datosJSON = resultado;

        if (datosJSON.estado===200){
            var html = "";

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


function save(){
    var capilla = $("#combo_capilla").val();
    console.log(capilla);
    if( capilla == 0){
        swal("Nota","Selecione Capilla", "warning");
        return 0;
    }
    if($("#combo_tipoculto").val() == 0){
        swal("Nota","Selecione el tipo de culto", "warning");
        return 0;
    }
    if($("#date_inicial").val() == ""){
        swal("Nota","Selecione Fecha inicial", "warning");
        return 0;
    }
    if($("#date_final").val() == ""){
        swal("Nota","Selecione FEcha final", "warning");
        return 0;
    }
    var hora = $("#combo_hora").val();
    if( hora.length == 0){
        swal("Nota","Selecione como mínimo alguna hora", "warning");
        return 0;
    }

    var data = {
        'fecha_inicial': $("#date_inicial").val(),
        'fecha_final': $("#date_final").val(),
        'hora': $("#combo_hora").val(),
        'tipo_culto': $("#combo_tipoculto").val(),
        'capilla': $("#combo_capilla").val(),
        'operation': $("#operation").val()
    }
    console.log(data);

    swal({
            title: "Confirme",
            text: "¿Esta seguro de generar el horario?",
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



                $.post
                (
                    "../controlador/horario_create_update_controlador.php",
                    data
                ).done(function (resultado) {
                    console.log(resultado);
                    var datosJSON = resultado;
                    if (datosJSON.estado === 200) {
                        swal("Exito", datosJSON.mensaje, "success");
                        limpiar();
                        $("#btncerrar").click(); //Cerrar la ventana
                        //listar();

                    } else {
                        if(datosJSON.estado == 203){
                            swal("Nota", datosJSON.mensaje , "info");
                        }else{
                            swal("Mensaje del sistema", resultado, "warning");

                        }
                    }
                }).fail(function (error) {
                    console.log(error);
                    var datosJSON = $.parseJSON(error.responseText);
                    swal("Ocurrió un error", datosJSON.mensaje, "error");
                });
            }
        });

}

$('#antodas_fechas').on('ifChecked', function (event) {
    param = '0';
    $("#mes1").attr('disabled','disabled');
    $("#mes2").attr('disabled','disabled');
    $("#anio1").attr('disabled','disabled');
    $("#anio2").attr('disabled','disabled');

});
$('#anrango_fechas').on('ifChecked', function (event) {
    param = '1';
    $("#mes1").removeAttr('disabled');
    $("#mes2").removeAttr('disabled');
    $("#anio1").removeAttr('disabled');
    $("#anio2").removeAttr('disabled');
});

function limpiar(){
    $("#combo_capilla").val("0");
    $("#combo_tipoculto").val("0");
    $("#date_inicial").val("");
    $("#date_final").val("");
    $("#combo_hora").html("");
    cargarComboHora("#combo_hora");
}