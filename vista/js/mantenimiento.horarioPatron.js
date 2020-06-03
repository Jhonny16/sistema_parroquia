//JQuery

$(document).ready(function(){
  // alert("se esta ejecutando codigo JS") 
    listar();
});

function listar()
{
    $.post
     (
        "../controlador/horarioPatron.listar.controlador.php"
      ).done(function(resultado){
         var datosJSON = resultado;
         if (datosJSON.estado === 200){//validamos si el controlador se ha ejecutado correctamente
          
           var html = "";
            html += '<small>';
                html += '<table id="tabla-listado" class="table table-bordered table-striped">';
                    html += '<thead>';
                        html += '<tr style="background-color: #ededed; height:25px;">';
                        html += '<th>COD.HORA</th>';
                        html += '<th>HORARIO</th>';
                        html += '<th style="text-align: center">OPCIONES</th>';
                        html += '</tr>';
                    html += '</thead>';
                    html += '<tbody>';

                    //Detalle
                        $.each(datosJSON.datos, function(i,item) {
                        html += '<tr>';
                        html += '<td align="center">'+item.hora_id+'</td>';
                        html += '<td>'+item.hora_hora+'</td>';
                        html += '<td align="center">';
                        html += '<button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#myModal" onclick="leerDatos(' + item.hora_id + ')"><i class="fa fa-pencil"></i></button>';
                        html += '&nbsp;&nbsp;';
                        html += '<button type="button" class="btn btn-danger btn-xs" onclick="eliminar(' + item.hora_id + ')"><i class="fa fa-close"></i></button>';
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
         
      }).fail(function (error){
          var datosJSON = $.parseJSON( error.responseText );
                   swal("Ocurrió un error", datosJSON.mensaje , "error");
      });
}

//Eliminar horario_patron por el codigo del horario_patron
function eliminar(hora_id){
    
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
                "../controlador/horarioPatron.eliminar.controlador.php",
                {
                    p_hora_id: hora_id
                }
            ).done(function(resultado){
                var datosJSON = resultado;

                if (datosJSON.estado === 200){
                    swal("Exito", datosJSON.mensaje, "success");
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
    
}


$("#btnagregar").click(function(){
    $("#txtTipoOperacion").val("agregar");
    $("#titulomodal").html("Agregar una nuevo Horario Patron");
    $("#txtCodigo").val("");
    $("#txtHorarioPatron").val("");
});

$("#myModal").on("shown.bs.modal", function(){
    $("#txtHorarioPatron").focus();
});


/*FUNCION GRABAR HORARIO PATRON*/
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
            var v_p_hora_id = "";
            
            if (v_p_tipo_operacion === "agregar"){
                v_p_hora_id = "nuevo";                
            }else{                
                v_p_hora_id = $("#txtCodigo").val();                
            }
            
            var v_hora_hora = $("#txtHorarioPatron").val();
            
            
            $.post
                (
                    "../controlador/horarioPatron.agregar.editar.controlador.php",
                    {
                        p_hora_id: v_p_hora_id,
                        p_hora_hora: v_hora_hora,
                        p_tipo_operacion: v_p_tipo_operacion
                       
                    }
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

function leerDatos(hora_id){
    $.post
        (
            "../controlador/horarioPatron.leer.datos.controlador.php",
            {
                p_hora_id: hora_id
            }
        ).done(function(resultado){
            var datosJSON = resultado;

            if (datosJSON.estado === 200){
                $("#txtTipoOperacion").val("editar");
                $("#txtCodigo").val(datosJSON.datos.hora_id);
                $("#txtHorarioPatron").val(datosJSON.datos.hora_hora);
                $("#titulomodal").html("Editar datos del Horario Patron");
                
            }else{
              swal("Mensaje del sistema", resultado , "warning");
            }
        }).fail(function(error){
           var datosJSON = $.parseJSON( error.responseText );
           swal("Ocurrió un error", datosJSON.mensaje , "error");
        });
    
}
