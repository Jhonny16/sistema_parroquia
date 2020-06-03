/**
 * Created by tito_ on 13/12/2018.
 */


$(document).ready(function () {
    // alert("se esta ejecutando codigo JS")
    cargarComboCulto("#combo_culto");
    list();
});

function list() {
    // var fechas = $("#reservation").val();
    // var fecha1 = fechas.substr(0, 10);
    // var fecha2 = fechas.substr(13, 23);
    //
    // var data = {
    //     p_busqueda: param,
    //     p_fecha_inicio: fecha1,
    //     p_fecha_fin: fecha2
    //
    // }
    $.post(
        "../controlador/reserva.listar.controlador.php", {}
    ).done(function (resultado) {
        console.log(resultado);
        var datosJSON = resultado;
        if (datosJSON.estado === 200) {
            var html = "";

            html += '<table id="tbl_reserva" class="table table-bordered table-striped">';
            html += '<thead>';
            html += '<tr style="background-color: #ededed; height:25px;">';
            html += '<th>Id</th>';
            html += '<th>Costo</th>';
            html += '<th>Fecha</th>';
            html += '<th>Hora</th>';
            html += '<th>Editable</th>';
            html += '<th>Capilla_id</th>';
            html += '<th>Anio</th>';
            html += '</tr>';
            html += '</thead>';
            html += '<tbody>';
            var total = 0;
            var interes = 0;
            var saldo = 0;
            $.each(datosJSON.datos, function (i, item) {

                html += '<td>' + item.int_id + '</td>';
                html += '<td>' + item.int_costo + '</td>';
                html += '<td>' + item.int_fecha + '</td>';
                html += '<td>' + item.int_hora + '</td>';
                html += '<td>' + item.int_editable + '</td>';
                html += '<td>' + item.cap_id + '</td>';
                html += '<td>' + item.anno_nombre + '</td>';

                html += '</tr>';
            });
            html += '</tbody>';
            html += '</table>';

            $("#listado_reserva").html(html);
            $('#tbl_reserva').DataTable({
                "aaSorting": [[5, "desc"]],
                "sScrollX": "150%",
                "sScrollXInner": "150%",
                "bScrollCollapse": true,
                "bPaginate": true
            })
        } else {
            swal("Mensaje del sistema", resultado, "warning");
        }

    }).fail(function (error) {
        console.log(error);
        //var datosJSON = $.parseJSON(error.responseText);

    });
}

function cargarComboCulto(p_nombreCombo) {
    $.post
    (
        "../controlador/tipoCulto.listar.controlador.php"
    ).done(function (resultado) {
        var datosJSON = resultado;

        if (datosJSON.estado === 200) {
            var html = "";

            html += '<option value="0">Seleccione Culto</option>';
            $.each(datosJSON.datos, function (i, item) { //each para recorrer todos los elementos de array
                html += '<option value="' + item.tc_id + '">[ '+ item.tc_id +' ] ' + item.tc_nombre + ' / ' + item.tc_descripcion + '</option>';
            });
            $(p_nombreCombo).html(html);
        } else {
            swal("Mensaje del sistema", resultado, "warning");
        }
    }).fail(function (error) {
        var datosJSON = $.parseJSON(error.responseText);
        swal("Error", datosJSON.mensaje, "error");
    });
}

$("#btn_plus").click(function(){


    var codigo = $("#combo_culto").val();
    var intecion   = $("#txt_intencion").val();
    var ofrece   = $("#txt_cliente").val();
    var tipo_culto   = '-';
    var costo = $("#txt_costo").val()

    var fila =   "<tr>"+
        "<td align=\"center\" id=\"celiminar\"><a href=\"javascript:void();\"><i class=\"fa fa-trash text-orange\"></i></a></td>"+
        "<td>"+ codigo +"</td>"+
        "<td>" + intecion + "</td>"+
        "<td >" + ofrece + "</td>"+
        "<td style=\"text-align: right\">" + costo + "</td>"+
        "</tr>";

    if( costo <= 0){
        alert("Ingrese cantidad mayor a cero");
        $("#txt_costo").focus();
    }
    else
    {
        $("#detalle").append(fila);

        $("#combo_culto").val("0");
        $("#txt_intencion").val("");
        $("#txt_cliente").val("");
        $("#txt_costo").val("");
        // $("#txtarticulo").focus();

        calcularTotales();
//     alert(co);

    }


});

$("#btn_reserva_add").click(function () {
    $("#operation").val("agregar");
    $("#titulomodal").html("Agregar nueva Reserva");
    //limpiar();


});

function calcularTotales() {
    var importeNeto = 0;
    $("#detalle tr").each(function () {
        var importe = $(this).find("td").eq(4).html();
        importeNeto = importeNeto + parseFloat(importe);
    });
    $("#total").html(importeNeto.toFixed(2));
}

$(document).on("click", "#celiminar", function(){
    if (! confirm("Esta seguro de elimina el registro seleccionado")){
        return 0;
    }
    var fila = $(this).parents().get(0); //capturar la fila que deseamos eliminar
    fila.remove(); //eliminar la fila
    calcularTotales();
});

var arrayDetalle = new Array(); //permite almacenar todos los productos agregados en el detalle de la venta

function save_reserva() {
    swal({
        title: 'Confirme.',
        text:'¿Desea guardar la Reserva?',
        type: 'success',
        confirmButtonColor: '#3d9205',
        confirmButtonText: 'OK!',
    }).then(function (result) {
        if (result.value) {
            arrayDetalle.splice(0, arrayDetalle.length);

            /*RECORREMOS CADA FILA DE LA TABLA DONDE ESTAN LOS PRODUCTOS VENDIDOS*/
            $("#detalle tr").each(function () {
                var intencion = $(this).find("td").eq(2).html();
                var ofrece = $(this).find("td").eq(3).html();
                var tipo_culto = $(this).find("td").eq(1).html();
                var importe = $(this).find("td").eq(4).html();

                var objDetalle = new Object(); //Crear un objeto para almacenar los datos

                /*declaramos y asignamos los valores a los atributos*/
                objDetalle.intencion = intencion;
                objDetalle.ofrece = ofrece;
                objDetalle.culto = tipo_culto;
                objDetalle.importe = importe;
                //Almacenar al objeto objDetalle en el array arrayDetalle
                arrayDetalle.push(objDetalle);

            });

            var jsonDetalle = JSON.stringify(arrayDetalle);

            var datos_frm = {
                p_fecha: $("#txt_fecha").val(),
                p_hora: $("#txt_hora").val(),
                p_total: $("#total").html(),
                p_datosJSONDetalle: jsonDetalle,
                p_capilla: 1,
                p_anio: 2018,
                operation : $("#operation").val()

            };
            console.log(datos_frm);
        }

    })

    // swal({
    //         title: "Confirme",
    //         text: "¿Esta seguro de grabar los datos ingresados?",
    //         showCancelButton: true,
    //         confirmButtonColor: '#3d9205',
    //         confirmButtonText: 'Si',
    //         cancelButtonText: "No",
    //         closeOnConfirm: false,
    //         closeOnCancel: true,
    //         imageUrl: "../imagenes/preguntar.png"
    //     },
    //     function(isConfirm){
    //         if (isConfirm){ //el usuario hizo clic en el boton SI
    //
    //
    //             arrayDetalle.splice(0, arrayDetalle.length);
    //
    //             /*RECORREMOS CADA FILA DE LA TABLA DONDE ESTAN LOS PRODUCTOS VENDIDOS*/
    //             $("#detalle tr").each(function () {
    //                 var intencion = $(this).find("td").eq(2).html();
    //                 var ofrece = $(this).find("td").eq(3).html();
    //                 var tipo_culto = $(this).find("td").eq(1).html();
    //                 var importe = $(this).find("td").eq(4).html();
    //
    //                 var objDetalle = new Object(); //Crear un objeto para almacenar los datos
    //
    //                 /*declaramos y asignamos los valores a los atributos*/
    //                 objDetalle.intencion = intencion;
    //                 objDetalle.ofrece = ofrece;
    //                 objDetalle.culto = tipo_culto;
    //                 objDetalle.importe = importe;
    //                 //Almacenar al objeto objDetalle en el array arrayDetalle
    //                 arrayDetalle.push(objDetalle);
    //
    //             });
    //
    //             var jsonDetalle = JSON.stringify(arrayDetalle);
    //
    //             var datos_frm = {
    //                 p_fecha: $("#txt_fecha").val(),
    //                 p_hora: $("#txt_hora").val(),
    //                 p_total: $("#total").html(),
    //                 p_datosJSONDetalle: jsonDetalle,
    //                 p_capilla: 1,
    //                 p_anio: 2018,
    //                 operation : $("#operation").val()
    //
    //             };
    //             console.log(datos_frm);
    //             // $.post
    //             // (
    //             //     "../controlador/reserva.agregar.editar.controlador.php",
    //             //     datos_frm
    //             // ).done(function(resultado){
    //             //     console.log(resultado);
    //             //     var datosJSON = resultado;
    //             //
    //             //     if (datosJSON.estado === 200){
    //             //         swal("Exito", datosJSON.mensaje, "success");
    //             //         $("#btncerrar").click(); //Cerrar la ventana
    //             //         listar(); //actualizar la lista
    //             //     }else{
    //             //         swal("Mensaje del sistema", resultado , "warning");
    //             //     }
    //             // }).fail(function(error){
    //             //     var datosJSON = $.parseJSON( error.responseText );
    //             //     swal("Ocurrió un error", datosJSON.mensaje , "error");
    //             // });
    //
    //
    //         }
    //     });

}
