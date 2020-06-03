function login() {

   var data = {
        dni: $("#dni").val(),
        ap_paterno: $("#ap_paterno").val(),
        ap_materno: $("#ap_materno").val(),
        nombres: $("#nombres").val(),
        celular: $("#celular").val(),
        dni: $("#dni").val(),
       email: $("#email").val(),
       password: $("#password").val(),
       direccion: $("#direccion").val()
    };
    console.log(data);
    $.ajax({
        data: data,
        url: "../controlador/ciente_agregar_form.php",
        type: "post",
        success: function (resultado) {
            console.log(resultado);
            if (resultado.estado == 200) {
                swal("Genial !", resultado.mensaje, "success");

                operacion = "agregar";
            } else {
                swal("Nota !", resultado.mensaje, "success");
                window.location = "../vista/index.html";
            }
        },
        error: function (error) {
            console.log(error);
            var datosJSON = $.parseJSON(error.responseText);
            swal("Error", datosJSON.mensaje, "error");
        }
    });


}