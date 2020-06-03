


$(document).ready(function () {
    setInterval(function(){
       //mensajes()
    //}, 5 * 1000);//cada # minutos
    }, 1 * 60000);//cada # minutos
});

function mensajes(){

    $.post
    (
        "../controlador/persona_cliente_sms_controlador.php"
    ).done(function (resultado) {
        console.log(resultado);
    }).fail(function (error) {
        console.log(error);
        var datosJSON = $.parseJSON(error.responseText);
        swal("Error", datosJSON.mensaje, "error");
    });

}

