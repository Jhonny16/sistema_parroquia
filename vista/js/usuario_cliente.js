var operacion = "agregar";
$(document).ready(function () {
    roles();
    lista_personas();
    editar();

});

function lista_personas(){
    var rol_id = $("#sesion_rol_id").val();
    var parroquia = $("#sesion_parroquia_id").val();
    var dni = $("#sesion_dni").val();

    var data = {'rol_id': rol_id, 'parroquia': parroquia, 'dni': dni};
    console.log(data);
    $("#combo_usuario").empty();

    $.post
    (
        "../controlador/employeesListController.php", data
    ).done(function (resultado) {
        var datosJSON = resultado;
        console.log(resultado);
        if (datosJSON.estado === 200) {
            var html = "";
            if($("#sesion_rol_id").val() == '2' ){
                var data = resultado.datos;
                html += '<option value="">-- Seleccione Usuario --</option>';

                var nombre = data.per_apellido_paterno +' ' + data.per_apellido_materno + ' ' + data.per_nombre;
                html += '<option value="' + data.per_iddni + '">' + nombre + '</option>';

                $("#combo_usuario").append(html);
            }else{
                html += '<option value="">-- Seleccione Usuario --</option>';
                $.each(datosJSON.datos, function (i, item) {
                    var nombre = item.per_apellido_paterno +' ' + item.per_apellido_materno + ' ' + item.per_nombre;
                    html += '<option value="' + item.per_iddni + '">' + nombre + '</option>';
                });
                $("#combo_usuario").append(html);
            }



        } else {
            swal("Mensaje del sistema", resultado, "warning");
        }

    }).fail(function (error) {
        console.log(error);
        var datosJSON = $.parseJSON(error.responseText);
        //swal("Error", datosJSON.mensaje , "error");
    });
}

function roles() {
    $("#combo_tipousuario").empty();

    $.post
    (
        "../controlador/rolListaController.php"
    ).done(function (resultado) {
        console.log(resultado);
        var datosJSON = resultado;
        // alert(resultado);
        console.log(resultado);
        if (datosJSON.estado === 200) {
            var html = "";

            if ($("#sesion_rol_id").val() == '2'){
                html += '<option value="0">-- Seleccione Rol --</option>';
                $.each(datosJSON.datos, function (i, item) {
                    if(item.id==2 || item.id=='2'){
                        html += '<option value="' + item.id + '">' + item.nombre + '</option>';
                    }
                });
            }else{
                html += '<option value="0">-- Seleccione Rol --</option>';
                $.each(datosJSON.datos, function (i, item) {

                    html += '<option value="' + item.id + '">' + item.nombre + '</option>';


                });
            }

            $("#combo_tipousuario").append(html);
        } else {
            swal("Mensaje del sistema", resultado, "warning");
        }

    }).fail(function (error) {
        var datosJSON = $.parseJSON(error.responseText);
        //swal("Error", datosJSON.mensaje , "error");
    });
}

function editar() {

    var id = $("#sesion_user_id").val();
    $.post
    (
        "../controlador/usuarioLeerController.php",
        {
            p_id: id
        }
    ).done(function (resultado) {
        console.log(resultado);
        var jsonResultado = resultado;
        if (jsonResultado.estado === 200) {
            operacion = 'editar';
            $("#divcheck_contrasenia").removeAttr('style');
            $("#txtcontrasenia").attr('readonly', 'readonly');
            $("#usuario_id").val(resultado.datos.usu_id);
            $("#combo_usuario").val(resultado.datos.per_iddni);
            if (resultado.datos.usu_estado == 'A') {
                $("#rbactivo").iCheck('check');
            } else {
                $("#rbnoactivo").iCheck('check')
            }
            $("#combo_tipousuario").val(resultado.datos.id);
            $("#datefec_inicio").val(resultado.datos.fecha_inicio);
            $("#datefec_fin").val(resultado.datos.fecha_fin);
        }
    }).fail(function (error) {
        var datosJSON = $.parseJSON(error.responseText);
        swal("Error", datosJSON.mensaje, "error");
    });
}

function validar_password(){
    if(operacion== 'editar'){
        var data = {
            'user_id': $("#usuario_id").val(),
            'clave': $("#txtcontrasenia").val()
        };
        console.log(data);
        $.ajax({
            data: data,
            url: "../controlador/usuarioValidarPassswordController.php",
            type: "post",
            success: function (resultado) {
                console.log(resultado);
                if(resultado.datos=='1'){
                    $("#divnueva_contrasenia").removeAttr('style');

                    swal({title: "Exito",text: "Contraseña Valida!!", type: "success"},function(isConfirm){
                        if (isConfirm) {
                            $("#txtcontrasenia").attr('readonly','readonly');
                            $("#txtnueva_contrasenia").removeAttr('readonly');
                            $("#txtnueva_contrasenia").focus();
                        }
                    });
                    ;

                }else{
                    if(resultado.datos=='0'){
                        swal("Nota", "Contraseña N0 Valida!!", "info");
                        $("#txtcontrasenia").val("");

                    }else{
                        swal("Nota", "No hubo resultado en la búsqueda", "info");
                        $("#txtcontrasenia").val("");
                    }
                }


            },
            error: function (error) {
                console.log(error);
                var datosJSON = $.parseJSON(error.responseText);
                swal("Error", datosJSON.mensaje, "error");
            }
        });
    }



}

var check=0;
$('#check_contrasenia').on('ifChecked', function (event) {
    $("#txtcontrasenia").removeAttr('readonly');
    $("#divnueva_contrasenia").removeAttr('style');
    check =1;

});
$('#check_contrasenia').on('ifUnchecked', function (event) {
    $("#txtcontrasenia").attr('readonly','readonly');
    $("#txtnueva_contrasenia").attr('readonly','readonly');
    $("#txtcontrasenia").val("");
    $("#divnueva_contrasenia").attr('style','display:none');
    $("#txtnueva_contrasenia").val("");
    check=0;
});
var estado='A';
$('#rbactivo').on('ifChecked', function (event) {
    estado='A';

});
$('#rbnoactivo').on('ifChecked', function (event) {
    estado='I';
});

function refresh(){
    window.location = "../vista/usuario_cliente_vista.php";
}

function usuario_add() {
    if(operacion=='agregar' && ($("#sesion_rol_id").val() == '2' || $("#sesion_rol_id").val() == '4') ){
        swal("NOTA", "Ud. no puede agregar usuarios", "warning");
        return 0;
    }else{
        var clave =null;
        if(check == 1){
            clave = $("#txtnueva_contrasenia").val();
        }else{
            clave = $("#txtcontrasenia").val();
        }

        var data = {
            p_usuario_id: $("#usuario_id").val(),
            p_documento: $("#combo_usuario").val(),
            p_rol_id: $("#combo_tipousuario").val(),
            p_password: clave ,
            p_estado: estado,
            p_operacion: operacion,
            p_check: check,
            p_fecha_inicio : $("#datefec_inicio").val(),
            p_fecha_fin : $("#datefec_fin").val()
        };
        console.log(data);
        $.ajax({
            data: data,
            url: "../controlador/usuarioAgreagrEditarController.php",
            type: "post",
            success: function (resultado) {
                console.log(resultado);
                if (resultado.estado == 200) {
                    //limpiar();
                    swal("Genial !", resultado.mensaje, "success");
                    window.location = "../vista/usuario_cliente_vista.php";
                    operacion = "agregar";
                } else {
                    console.log(resultado);
                    swal("Nota !", resultado.mensaje, "success");
                }
            },
            error: function (error) {
                console.log(error);
                var datosJSON = $.parseJSON(error.responseText);
                swal("Error", datosJSON.mensaje, "error");
            }
        });
    }


}
