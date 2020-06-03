function cargarComboCategoria(p_nombreCombo, p_tipo){
    $.post
    (
	"../controlador/categoria.cargar.combo.controlador.php"
    ).done(function(resultado){
	var datosJSON = resultado;
	
        if (datosJSON.estado===200){
            var html = "";
            if (p_tipo==="s"){
                html += '<option value="">Seleccione una celebración</option>';
            }else{
                html += '<option value="0">Todos las celebraciones</option>';
            }

            
            $.each(datosJSON.datos, function(i,item) { //each para recorrer todos los elementos de array
                html += '<option value="'+item.cel_id+'">'+item.cel_nombre+'</option>';
            });
            
            $(p_nombreCombo).html(html);
	}else{
            swal("Mensaje del sistema", resultado , "warning");
        }
    }).fail(function(error){
	var datosJSON = $.parseJSON( error.responseText );
	swal("Error", datosJSON.mensaje , "error");
    });
}


