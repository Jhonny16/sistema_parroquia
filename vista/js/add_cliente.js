$(document).ready(function(){
    // alert("se esta ejecutando codigo JS")

   //listar();
   cargarComboCargo("#cboCargo","s");
   cargarComboOcup("#cboOcupacion","s");
});
function cargarComboCargo(p_nombreCombo, p_tipo){
    $.post
    (
        "../controlador/cargo.cargar.combo.controlador.php"

    ).done(function(resultado){
        var datosJSON = resultado;

        if (datosJSON.estado===200){
            var html = "";
            if (p_tipo==="s"){
                html += '<option value="">Seleccione un cargo</option>';
            }else{
                html += '<option value="0">Todos los estados</option>';
            }


            $.each(datosJSON.datos, function(i,item) { //each para recorrer todos los elementos de array
                if (item.car_id == '5') {

                    html += '<option value="' + item.car_id + '" >' + item.car_nombre + '</option>';
                }



            });

            $(p_nombreCombo).html(html);
        }else{
            console.log(resultado);
            swal("Mensaje del sistemaa", resultado , "warning");
        }
    }).fail(function(error){
        var datosJSON = $.parseJSON( error.responseText );
        swal("Error", datosJSON.mensaje , "error");
    });
}
function cargarComboOcup(p_nombreCombo, p_tipo){
    $.post
    (
        "../controlador/ocupacion.cargar.combo.controlador.php"
    ).done(function(resultado){
        var datosJSON = resultado;

        if (datosJSON.estado===200){
            var html = "";
            if (p_tipo==="s"){
                html += '<option value="">Seleccione una ocupación</option>';
            }else{
                html += '<option value="0">Todos los miveles</option>';
            }


            $.each(datosJSON.datos, function(i,item) { //each para recorrer todos los elementos de array
                if (item.ocu_id == '7') {
                    html += '<option value="'+item.ocu_id+'">'+item.ocu_nombre+'</option>';
                }

            });

            $(p_nombreCombo).html(html);
        }else{
            console.log(resultado);
            swal("Mensaje del sistemae", resultado , "warning");
        }
    }).fail(function(error){
        var datosJSON = $.parseJSON( error.responseText );
        swal("Error", datosJSON.mensaje , "error");
    });
}

function nuevo_cliente(){
    $("#txtDNI").val("");
    $("#txtApellidoPaterno").val("");
    $("#txtApellidoMaterno").val("");
    $("#txtNombre").val("");
    $("#txtDireccion").val("");
    $("#txtEmail").val("");
    $("#cboOcupacion").val("");
    $("#cboCargo").val("");
}


$("#mdl_cliente").on("shown.bs.modal", function(){
    $("#txtDNI").focus();
});


$("#frm_save_cliente").submit(function(event){
    event.preventDefault();

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
        function(isConfirm){
            if (isConfirm){ //el usuario hizo clic en el boton SI

                var  v_p_tra_iddni = $("#txtDNI").val();
                var v_tra_apellido_paterno = $("#txtApellidoPaterno").val();
                var v_p_tra_apellido_materno = $("#txtApellidoMaterno").val();
                var v_p_tra_nombre = $("#txtNombre").val();
                var v_p_tra_direccion = $("#txtDireccion").val();
                var v_p_tra_email = $("#txtEmail").val();
                var v_p_ocu_id  = $("#cboOcupacion").val();
                var v_p_car_id  = $("#cboCargo").val();
                var v_telefono  = $("#celular").val();

                var data =  {
                    p_tra_iddni: v_p_tra_iddni,
                    p_tra_apellido_paterno: v_tra_apellido_paterno,
                    p_tra_apellido_materno: v_p_tra_apellido_materno,
                    p_tra_nombre: v_p_tra_nombre,
                    p_tra_direccion: v_p_tra_direccion,
                    p_tra_email: v_p_tra_email,
                    p_ocu_id: v_p_ocu_id,
                    p_car_id: v_p_car_id,
                    p_tipo_operacion: 'agregar',
                    p_telefono: v_telefono

                };
                console.log(data);

                $.post
                (
                    "../controlador/trabajador.agregar.editar.controlador.php",data

                ).done(function(resultado){
                    var datosJSON = resultado;
                    if (datosJSON.estado === 200){
                        swal("Exito", datosJSON.mensaje, "success");
                        cargarClientenewId("#combo_cliente_id");
                        $("#close_mld_cliente").click();
                    }else{
                        swal("Mensaje del sistema", resultado , "warning");
                    }
                }).fail(function(error){
                    var datosJSON = $.parseJSON( error.responseText );
                    swal("Ocurrió un error", datosJSON.mensaje , "error");
                });
            }
        });

});