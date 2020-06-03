//JQuery

$(document).ready(function(){
  // alert("se esta ejecutando codigo JS") 
    listar();
});

function listar()
{
    $.post
     (
        "../controlador/parroquia.listar.controlador.php"
      ).done(function(resultado){
         var datosJSON = resultado;
         if (datosJSON.estado === 200){//validamos si el controlador se ha ejecutado correctamente
          
           var html = "";
            html += '<small>';
                html += '<table id="tabla-listado" class="table table-bordered table-striped">';
                    html += '<thead>';
                        html += '<tr style="background-color: #ededed; height:25px;">';
                        html += '<th>COD.PARR</th>';
                        html += '<th>NOMBRE</th>';
                        html += '<th>DIRECCION</th>';                        
                        html += '<th>TELEFONO</th>';
                        html += '<th>EMAIL</th>';
                        html += '<th style="text-align: center">OPCIONES</th>';
                        html += '</tr>';
                    html += '</thead>';
                    html += '<tbody>';

                    //Detalle
                        $.each(datosJSON.datos, function(i,item) {
                        html += '<tr>';
                        html += '<td align="center">'+item.par_id+'</td>';
                        html += '<td>'+item.par_nombre+'</td>';
                        html += '<td>'+item.par_direccion+'</td>';
                        html += '<td>'+item.par_telefono+'</td>';
                        html += '<td>'+item.par_email+'</td>';
                        html += '<td align="center">';
                        html += '<button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#myModal" onclick="leerDatos(' + item.par_id + ')"><i class="fa fa-pencil"></i></button>';
                        html += '&nbsp;&nbsp;';
                        html += '<button type="button" class="btn btn-danger btn-xs" onclick="eliminar(' + item.par_id + ')"><i class="fa fa-close"></i></button>';
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

//Eliminar producto por el codigo del producto
function eliminar(par_id){
    
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
                "../controlador/parroquia.eliminar.controlador.php",
                {
                    p_par_id: par_id
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
    $("#titulomodal").html("Agregar una nueva Parroquia");
    $("#txtCodigo").val("");
    $("#txtNombreParroquia").val("");
    $("#txtTelefonoMovil1").val("");
    $("#txtDireccion").val("");
    $("#txtEmail").val("");
});

$("#myModal").on("shown.bs.modal", function(){
    $("#txtNombreParroquia").focus();
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
            var v_p_par_id = "";
            
            if (v_p_tipo_operacion === "agregar"){
                v_p_par_id = "nuevo";                
            }else{                
                v_p_par_id = $("#txtCodigo").val();                
            }
            
            var v_par_nombre = $("#txtNombreParroquia").val();
            var v_p_par_telefono = $("#txtTelefonoMovil1").val();
            var v_p_par_direccion = $("#txtDireccion").val();
            var v_p_par_email = $("#txtEmail").val();
            
            $.post
                (
                    "../controlador/parroquia.agregar.editar.controlador.php",
                    {
                        p_par_id: v_p_par_id,
                        p_par_nombre: v_par_nombre,
                        p_par_telefono: v_p_par_telefono,
                        p_par_direccion: v_p_par_direccion,                        
                        p_par_email: v_p_par_email,
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

function leerDatos(par_id){
    $.post
        (
            "../controlador/parroquia.leer.datos.controlador.php",
            {
                p_par_id: par_id
            }
        ).done(function(resultado){
            var datosJSON = resultado;

            if (datosJSON.estado === 200){
                $("#txtTipoOperacion").val("editar");
                $("#txtCodigo").val(datosJSON.datos.par_id);
                $("#txtNombreParroquia").val(datosJSON.datos.par_nombre);
                $("#txtTelefonoMovil1").val(datosJSON.datos.par_telefono);
                $("#txtDireccion").val(datosJSON.datos.par_direccion);
                $("#txtEmail").val(datosJSON.datos.par_email);
                              
                $("#titulomodal").html("Editar datos de la parroquia");
                
            }else{
              swal("Mensaje del sistema", resultado , "warning");
            }
        }).fail(function(error){
           var datosJSON = $.parseJSON( error.responseText );
           swal("Ocurrió un error", datosJSON.mensaje , "error");
        });
    
}
