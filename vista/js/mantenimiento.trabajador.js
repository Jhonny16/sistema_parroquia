//JQuery

$(document).ready(function(){
  // alert("se esta ejecutando codigo JS") 
    
    listar();
    cargarComboCargo("#cboCargo","s");
    cargarComboOcup("#cboOcupacion","s");
});

function listar()
{
    var cargo_id=$("#cargo_id").val();
    var data = {cargo_id : cargo_id};
    $.post
     (
        "../controlador/trabajador.listar.controlador.php",data
      ).done(function(resultado){
         var datosJSON = resultado;
         console.log(resultado);
         if (datosJSON.estado === 200){//validamos si el controlador se ha ejecutado correctamente
          
           var html = "";
            html += '<small>';
                html += '<table id="tabla-listado" class="table table-bordered table-striped">';
                    html += '<thead>';
                        html += '<tr style="background-color: #ededed; height:25px;">';
                        html += '<th>DNI</th>';
                        html += '<th>AP. PATERNO</th>';
                        html += '<th>AP. MATERNO</th>';
                        html += '<th>NOMBRE</th>';
                        html += '<th>CARGO</th>';   
                        html += '<th style="text-align: center">OPCIONES</th>';
                        html += '</tr>';
                    html += '</thead>';
                    html += '<tbody>';

                    //Detalle
                        $.each(datosJSON.datos, function(i,item) {
                        html += '<tr>';
                        html += '<td align="center">'+item.per_iddni+'</td>';
                        html += '<td>'+item.per_apellido_paterno+'</td>';
                        html += '<td>'+item.per_apellido_materno+'</td>';
                        html += '<td>'+item.per_nombre+'</td>';
                        html += '<td>'+item.cargo+'</td>';
                        html += '<td align="center">';
                        html += '<button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#myModal" onclick="leerDatos(' + item.per_iddni + ')"><i class="fa fa-pencil"></i></button>';
                        html += '&nbsp;&nbsp;';
                        html += '<button type="button" class="btn btn-danger btn-xs" onclick="eliminar(' + item.per_iddni + ')"><i class="fa fa-close"></i></button>';
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
                "aaSorting": [[0, "asc"]] // 0 es la primera columan de la tabla, ordena por la primera columna
            });
        }
         
      }).fail(function (error){
          var datosJSON = $.parseJSON( error.responseText );
                   swal("Ocurrió un error", datosJSON.mensaje , "error");
      });
}

//Eliminar tipo_culto por el codigo del tipo_culto
function eliminar(tc_id){
    
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
    function(isConfirm){
        if (isConfirm){ //el usuario hizo clic en el boton SI     
            $.post
            (
                "../controlador/tipoCulto.eliminar.controlador.php",
                {
                    p_tc_id: tc_id
                }
            ).done(function(resultado){
                var datosJSON = resultado;
                console.log(resultado);
                if (datosJSON.estado == 200){
                    //swal("Exito", datosJSON.mensaje, "success");
                    listar(); //actualizar la lista
                }else{
                    console.log(resultado);
                  //swal("Mensaje del sistema", resultado , "warning");
                }
            }).fail(function(error){
               var datosJSON = $.parseJSON( error.responseText );
               swal("Ocurrió un error", datosJSON.mensaje , "error");
            });
        }
    });
    
}


$("#btnagregar").click(function(){
    $("#txtTipoOperacion").val("agregar");
    $("#titulomodal").html("Agregar una nuevo Trabajador");
    /*$("#txtCodigo").val("");*/
    $("#txtDNI").val("");
    $("#txtApellidoPaterno").val("");
    $("#txtApellidoMaterno").val("");
    $("#txtNombre").val("");
    $("#txtDireccion").val("");
    $("#txtEmail").val("");
    $("#cboOcupacion").val("");
    $("#cboCargo").val("");
});

$("#myModal").on("shown.bs.modal", function(){
    $("#txtDNI").focus();
});


/*FUNCION GRABAR TIPO_CULTO*/
$("#frmgrabar").submit(function(event){
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
            
            var v_p_tipo_operacion = $("#txtTipoOperacion").val();
            var v_p_tra_iddni = "";
            
            if (v_p_tipo_operacion == "agregar"){
                v_p_tra_iddni = $("#txtDNI").val();                
            }else{
                v_p_tra_iddni = $("#txtDNI").val()
                //v_p_tra_iddni = $("#txtDNI").val();                
            }
            
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
                p_tipo_operacion: v_p_tipo_operacion,
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
                        $("#btncerrar").click(); //Cerrar la ventana 
                        listar(); //actualizar la lista
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

function leerDatos(dni){
    var data = {'dni': dni};
    console.log(data);

    $.post
        (
            "../controlador/trabajador_leer_controaldor.php",
            data
        ).done(function(resultado){
            var datosJSON = resultado;

            console.log(resultado);
            if (datosJSON.estado === 200){


                $("#txtDNI").val(datosJSON.datos.per_iddni);
                $("#txtDNI").attr('disabled','disabled');

                $("#txtApellidoPaterno").val(datosJSON.datos.per_apellido_paterno);
                $("#txtApellidoMaterno").val(datosJSON.datos.per_apellido_materno);
                $("#txtNombre").val(datosJSON.datos.per_nombre);
                $("#txtDireccion").val(datosJSON.datos.per_direccion);
                $("#txtEmail").val(datosJSON.datos.per_email);
                $("#celular").val(datosJSON.datos.per_telefono);
                $("#cboOcupacion").val(datosJSON.datos.ocu_id);
                $("#cboCargo").val(datosJSON.datos.car_id);
                $("#titulomodal").html("Editar");
                $("#txtTipoOperacion").val("editar");
                
            }else{
              swal("Mensaje del sistema", resultado , "warning");
            }
        }).fail(function(error){
            console.log(error);
           var datosJSON = $.parseJSON( error.responseText );
           swal("Ocurrió un error", datosJSON.mensaje , "error");
        });
    
}
