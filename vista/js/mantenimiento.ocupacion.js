//JQuery

$(document).ready(function(){
  // alert("se esta ejecutando codigo JS") 
    listar();
});

function listar()
{
    $.post
     (
        "../controlador/ocupacion.listar.controlador.php"
      ).done(function(resultado){
         var datosJSON = resultado;
         if (datosJSON.estado === 200){//validamos si el controlador se ha ejecutado correctamente
          
           var html = "";
            html += '<small>';
                html += '<table id="tabla-listado" class="table table-bordered table-striped">';
                    html += '<thead>';
                        html += '<tr style="background-color: #ededed; height:25px;">';
                        html += '<th>COD.OCUP</th>';
                        html += '<th>NOMBRE</th>';
                        html += '<th>ABREVIATURA</th>'; 
                        html += '<th style="text-align: center">OPCIONES</th>';
                        html += '</tr>';
                    html += '</thead>';
                    html += '<tbody>';

                    //Detalle
                        $.each(datosJSON.datos, function(i,item) {
                        html += '<tr>';
                        html += '<td align="center">'+item.ocu_id+'</td>';
                        html += '<td>'+item.ocu_nombre+'</td>';
                        html += '<td>'+item.ocu_abreviatura+'</td>';
                        html += '<td align="center">';
                        html += '<button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#myModal" onclick="leerDatos(' + item.ocu_id + ')"><i class="fa fa-pencil"></i></button>';
                        html += '&nbsp;&nbsp;';
                        html += '<button type="button" class="btn btn-danger btn-xs" onclick="eliminar(' + item.ocu_id + ')"><i class="fa fa-close"></i></button>';
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

//Eliminar la ocupación por el codigo de la ocupación
function eliminar(ocu_id){
    
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
                "../controlador/ocupacion.eliminar.controlador.php",
                {
                    p_ocu_id: ocu_id
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
    $("#titulomodal").html("Agregar una nueva Ocupación");
    $("#txtCodigo").val("");
    $("#txtNombreOcupacion").val("");
    $("#txtAbreviatura").val("");
});

$("#myModal").on("shown.bs.modal", function(){
    $("#txtNombreOcupacion").focus();
});


/*FUNCION GRABAR PARROQUIA*/
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
            var v_p_ocu_id = "";
            
            if (v_p_tipo_operacion === "agregar"){
                v_p_ocu_id = "nuevo";                
            }else{                
                v_p_ocu_id = $("#txtCodigo").val();                
            }
            
            var v_ocu_nombre = $("#txtNombreOcupacion").val();
            var v_p_ocu_abreviatura = $("#txtAbreviatura").val();
            
            $.post
                (
                    "../controlador/ocupacion.agregar.editar.controlador.php",
                    {
                        p_ocu_id: v_p_ocu_id,
                        p_ocu_nombre: v_ocu_nombre,
                        p_ocu_abreviatura: v_p_ocu_abreviatura,
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

function leerDatos(ocu_id){
    $.post
        (
            "../controlador/ocupacion.leer.datos.controlador.php",
            {
                p_ocu_id: ocu_id
            }
        ).done(function(resultado){
            var datosJSON = resultado;

            if (datosJSON.estado === 200){
                $("#txtTipoOperacion").val("editar");
                $("#txtCodigo").val(datosJSON.datos.ocu_id);
                $("#txtNombreOcupacion").val(datosJSON.datos.ocu_nombre);
                $("#txtAbreviatura").val(datosJSON.datos.ocu_abreviatura);                              
                $("#titulomodal").html("Editar datos de la Ocupación");
                
            }else{
              swal("Mensaje del sistema", resultado , "warning");
            }
        }).fail(function(error){
           var datosJSON = $.parseJSON( error.responseText );
           swal("Ocurrió un error", datosJSON.mensaje , "error");
        });
    
}
