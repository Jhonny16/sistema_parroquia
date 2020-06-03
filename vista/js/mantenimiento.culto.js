//JQuery

$(document).ready(function(){
  // alert("se esta ejecutando codigo JS") 
    listar();
    cargarComboCategoria("#cboCategoria","s");
});

function listar()
{
    $.post
     (
        "../controlador/culto.listar.controlador.php"
      ).done(function(resultado){
         var datosJSON = resultado;
         if (datosJSON.estado === 200){//validamos si el controlador se ha ejecutado correctamente
          
           var html = "";
            html += '<small>';
                html += '<table id="tabla-listado" class="table table-bordered table-striped">';
                    html += '<thead>';
                        html += '<tr style="background-color: #ededed; height:25px;">';
                        html += '<th>COD.CULTO</th>';
                        html += '<th>NOMBRE</th>';
                        html += '<th>DESCRIPCION</th>';                        
                        html += '<th>CELEBRACION</th>';
                        html += '<th style="text-align: center">OPCIONES</th>';
                        html += '</tr>';
                    html += '</thead>';
                    html += '<tbody>';

                    //Detalle
                        $.each(datosJSON.datos, function(i,item) {
                        html += '<tr>';
                        html += '<td align="center">'+item.cul_id+'</td>';
                        html += '<td>'+item.cul_nombre+'</td>';
                        html += '<td>'+item.cul_descripcion+'</td>';
                        html += '<td>'+item.celebracion+'</td>';
                        html += '<td align="center">';
                        html += '<button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#myModal" onclick="leerDatos(' + item.cul_id + ')"><i class="fa fa-pencil"></i></button>';
                        html += '&nbsp;&nbsp;';
                        html += '<button type="button" class="btn btn-danger btn-xs" onclick="eliminar(' + item.cul_id + ')"><i class="fa fa-close"></i></button>';
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

//Eliminar producto por el codigo del culto
function eliminar(cul_id){
    
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
                "../controlador/culto.eliminar.controlador.php",
                {
                    p_cul_id: cul_id
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
    $("#titulomodal").html("Agregar una nuevo Culto");
    $("#txtCodigo").val("");
    $("#txtNombreCulto").val("");
    $("#txtDescripcion").val("");
    $("#cboCategoria").val("");
});

$("#myModal").on("shown.bs.modal", function(){
    $("#txtNombreCulto").focus();
});


/*FUNCION GRABAR CULTO*/
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
            var v_p_cul_id = "";
            
            if (v_p_tipo_operacion === "agregar"){
                v_p_cul_id = "nuevo";                
            }else{                
                v_p_cul_id = $("#txtCodigo").val();                
            }
            
            var v_cul_nombre = $("#txtNombreCulto").val();
            var v_p_cul_descripcion = $("#txtDescripcion").val();
            var v_p_cel_id = $("#cboCategoria").val();
                       
            $.post
                (
                    "../controlador/culto.agregar.editar.controlador.php",
                    {
                        p_cul_id: v_p_cul_id,
                        p_cul_nombre: v_cul_nombre,
                        p_cul_descripcion: v_p_cul_descripcion,
                        p_cel_id: v_p_cel_id,                        
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

function leerDatos(cul_id){
    $.post
        (
            "../controlador/culto.leer.datos.controlador.php",
            {
                p_cul_id: cul_id
            }
        ).done(function(resultado){
            var datosJSON = resultado;

            if (datosJSON.estado === 200){
                $("#txtTipoOperacion").val("editar");
                $("#txtCodigo").val(datosJSON.datos.cul_id);
                $("#txtNombreCulto").val(datosJSON.datos.cul_nombre);
                $("#txtDescripcion").val(datosJSON.datos.cul_descripcion);
                $("#cboCategoria").val(datosJSON.datos.cel_id);
                              
                $("#titulomodal").html("Editar datos del Culto");
                
            }else{
              swal("Mensaje del sistema", resultado , "warning");
            }
        }).fail(function(error){
           var datosJSON = $.parseJSON( error.responseText );
           swal("Ocurrió un error", datosJSON.mensaje , "error");
        });
    
}
