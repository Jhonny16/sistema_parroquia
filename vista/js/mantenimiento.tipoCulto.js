//JQuery

$(document).ready(function(){
  // alert("se esta ejecutando codigo JS") 
    
    listar();
    cargarComboCulto("#cboCulto","s");
});

function listar()
{
    $.post
     (
        "../controlador/tipoCulto.listar.controlador.php"
      ).done(function(resultado){
         var datosJSON = resultado;
         if (datosJSON.estado === 200){//validamos si el controlador se ha ejecutado correctamente
          
           var html = "";
            html += '<small>';
                html += '<table id="tabla-listado" class="table table-bordered table-striped">';
                    html += '<thead>';
                        html += '<tr style="background-color: #ededed; height:25px;">';
                        html += '<th>COD.TIPO</th>';
                        html += '<th>NOMBRE</th>';
                        html += '<th>DESCRIPCIÓN</th>';
                        html += '<th>TIEMPO MAX.</th>';
                        html += '<th>TIPO</th>';                        
                        html += '<th>CULTO</th>';
                        html += '<th style="text-align: center">OPCIONES</th>';
                        html += '</tr>';
                    html += '</thead>';
                    html += '<tbody>';

                    //Detalle
                        $.each(datosJSON.datos, function(i,item) {
                        html += '<tr>';
                        html += '<td align="center">'+item.tc_id+'</td>';
                        html += '<td>'+item.tc_nombre+'</td>';
                        html += '<td>'+item.tc_descripcion+'</td>';
                        html += '<td>'+item.tc_tiempo_maximo+'</td>';
                        html += '<td>'+item.tc_tipo+'</td>';
                        html += '<td>'+item.culto+'</td>';
                        html += '<td align="center">';
                        html += '<button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#myModal" onclick="leerDatos(' + item.tc_id + ')"><i class="fa fa-pencil"></i></button>';
                        html += '&nbsp;&nbsp;';
                        html += '<button type="button" class="btn btn-danger btn-xs" onclick="eliminar(' + item.tc_id + ')"><i class="fa fa-close"></i></button>';
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
    $("#titulomodal").html("Agregar un Tipo de Culto");
    $("#txtCodigo").val("");
    $("#txtNombreTipoCulto").val("");
    $("#txtDescripcion").val("");
    
    $("#txtTiempoMaximo").val("");

    $("#cboCulto").val("");
});

$("#myModal").on("shown.bs.modal", function(){
    $("#txtNombreTipoCulto").focus();
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
            var v_p_tc_id = "";
            
            if (v_p_tipo_operacion === "agregar"){
                v_p_tc_id = "nuevo";                
            }else{                
                v_p_tc_id = $("#txtCodigo").val();                
            }
            
            var v_tc_nombre = $("#txtNombreTipoCulto").val();
            var v_p_tc_descripcion = $("#txtDescripcion").val();
            
            var v_p_tc_tipo = $("#cboTipo").val();
            var v_p_tc_tiempo_maximo = $("#txtTiempoMaximo").val();

            var v_p_cul_id = $("#cboCulto").val();            
            
            $.post
                (
                    "../controlador/tipoCulto.agregar.editar.controlador.php",
                    {
                        p_tc_id: v_p_tc_id,
                        p_tc_nombre: v_tc_nombre,
                        p_tc_descripcion: v_p_tc_descripcion,
                        
                        p_tc_tipo: v_p_tc_tipo,
                        p_tc_tiempo_maximo: v_p_tc_tiempo_maximo,

                        p_cul_id: v_p_cul_id,                        
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
                    console.log(error);
                   var datosJSON = $.parseJSON( error.responseText );
                   swal("Ocurrió un error", datosJSON.mensaje , "error");
                });
        }
    });
    
});

function leerDatos(tc_id){
    $.post
        (
            "../controlador/tipoCulto.leer.datos.controlador.php",
            {
                p_tc_id: tc_id
            }
        ).done(function(resultado){
            var datosJSON = resultado;

            if (datosJSON.estado === 200){
                $("#txtTipoOperacion").val("editar");
                $("#txtCodigo").val(datosJSON.datos.tc_id);
                $("#txtNombreTipoCulto").val(datosJSON.datos.tc_nombre);
                $("#txtDescripcion").val(datosJSON.datos.tc_descripcion);
                
                $("#cboTipo").val(datosJSON.datos.tc_tipo);
                $("#txtTiempoMaximo").val(datosJSON.datos.tc_tiempo_maximo);

                
                $("#cboCulto").val(datosJSON.datos.cul_id);
                              
                $("#titulomodal").html("Editar datos del Tipo de Culto");
                
            }else{
              swal("Mensaje del sistema", resultado , "warning");
            }
        }).fail(function(error){
           var datosJSON = $.parseJSON( error.responseText );
           swal("Ocurrió un error", datosJSON.mensaje , "error");
        });
    
}
