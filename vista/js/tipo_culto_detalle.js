//JQuery

$(document).ready(function(){
    // alert("se esta ejecutando codigo JS")

    listar();
    cargarTipoCultoId();

});
function cargarTipoCultoId() {
    $("#combo_tipoculto").html("");
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
            $("#combo_tipoculto").html(html);
        } else {
            swal("Mensaje del sistema", resultado, "warning");
        }
    }).fail(function (error) {
        var datosJSON = $.parseJSON(error.responseText);
        swal("Error", datosJSON.mensaje, "error");
    });
}
function listar()
{
    $.post
    (
        "../controlador/tipoculto_detale_listar.php"
    ).done(function(resultado){
        var datosJSON = resultado;
        if (datosJSON.estado === 200){//validamos si el controlador se ha ejecutado correctamente

            var html = "";
            html += '<small>';
            html += '<table id="tablalistado_detalle" class="table table-bordered table-striped">';
            html += '<thead>';
            html += '<tr style="background-color: #ededed; height:25px;">';
            html += '<th>COD.TIPO</th>';
            html += '<th>NOMBRE</th>';
            html += '<th>DESCRIPCIÓN</th>';
            html += '<th>TIPO CULTO</th>';
            html += '<th style="text-align: center">OPCIONES</th>';
            html += '</tr>';
            html += '</thead>';
            html += '<tbody>';

            //Detalle
            $.each(datosJSON.datos, function(i,item) {
                html += '<tr>';
                html += '<td align="center">'+item.det_id+'</td>';
                html += '<td>'+item.det_nombre+'</td>';
                html += '<td>'+item.det_descripcion+'</td>';
                html += '<td>'+item.tipo_culto+'</td>';
                html += '<td align="center">';
                html += '<button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#mdl_detail_tipoculto" onclick="leerDatos(' + item.det_id + ')"><i class="fa fa-pencil"></i></button>';
                html += '</td>';
                html += '</tr>';
            });

            html += '</tbody>';
            html += '</table>';
            html += '</small>';

            $("#listado_detalle").html(html);

            $('#tablalistado_detalle').dataTable({
                "aaSorting": [[0, "asc"]] // 0 es la primera columan de la tabla, ordena por la primera columna
            });
        }

    }).fail(function (error){
        var datosJSON = $.parseJSON( error.responseText );
        swal("Ocurrió un error", datosJSON.mensaje , "error");
    });
}

//Eliminar tipo_culto por el codigo del tipo_culto

$("#btn_add_detail").click(function(){
    $("#txtTipoOperacion").val("agregar");
    $("#titulomodal").html("Agregar Detalle Tipo Culto");
    $("#txtCodigo").val("");
    $("#nombre_detalletc").val("");
    $("#descripcion_detalletc").val("");
    $("#combo_tipoculto").val("");
});

$("#myModal").on("shown.bs.modal", function(){
    $("#txtNombreTipoCulto").focus();
});


/*FUNCION GRABAR TIPO_CULTO*/
$("#frm_detail_tipoculto").submit(function(event){
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

                var operacion = $("#txtTipoOperacion").val();
                var id = "";

                if (operacion === "agregar"){
                    id = "nuevo";
                }else{
                    id = $("#txtCodigo").val();
                }

                var nombre = $("#nombre_detalletc").val();
                var descripcion = $("#descripcion_detalletc").val();
                var tipo_culto = $("#combo_tipoculto").val();

                $.post
                (
                    "../controlador/tipoculto_detalle_agregar_editar.php",
                    {
                        id: id,
                        nombre: nombre,
                        descripcion: descripcion,
                        tipo_culto: tipo_culto,
                        operacion: operacion

                    }
                ).done(function(resultado){
                    var datosJSON = resultado;

                    if (datosJSON.estado === 200){
                        swal("Exito", datosJSON.mensaje, "success");
                        $("#btncerrar").click();
                        listar();
                    }else{
                        swal("Mensaje del sistema", resultado , "warning");
                    }
                }).fail(function(error){
                    console.log(error);
                    var datosJSON = $.parseJSON( error.responseText );
                    swal("Ocurrió un error", datosJSON.mensaje , "error");
                });
            }
        });

});

function leerDatos(id){
    $.post
    (
        "../controlador/tipoculto_detalle_read.php",
        {
            'id': id
        }
    ).done(function(resultado){
        var datosJSON = resultado;

        if (datosJSON.estado === 200){
            $("#txtTipoOperacion").val("editar");
            $("#txtCodigo").val(datosJSON.datos.det_id);
            $("#nombre_detalletc").val(datosJSON.datos.det_nombre);
            $("#descripcion_detalletc").val(datosJSON.datos.det_descripcion);
            $("#combo_tipoculto").val(datosJSON.datos.tc_id);
            $("#titulomodal").html("Editar Detalle Tipo de Culto");

        }else{
            swal("Mensaje del sistema", resultado , "warning");
        }
    }).fail(function(error){
        var datosJSON = $.parseJSON( error.responseText );
        swal("Ocurrió un error", datosJSON.mensaje , "error");
    });

}
