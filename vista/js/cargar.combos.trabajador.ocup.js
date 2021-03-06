function cargarComboOcup(p_nombreCombo, p_tipo){
    $.post
    (
	"../controlador/ocupacion.cargar.combo.controlador.php"
    ).done(function(resultado){
	var datosJSON = resultado;
	
        if (datosJSON.estado===200){
            var html = "";
            if (p_tipo==="s"){
                html += '<option value="">Seleccione una ocupación</option>';
            }else{
                html += '<option value="0">Todos los miveles</option>';
            }

            
            $.each(datosJSON.datos, function(i,item) { //each para recorrer todos los elementos de array
                html += '<option value="'+item.ocu_id+'">'+item.ocu_nombre+'</option>';
            });
            
            $(p_nombreCombo).html(html);
	}else{
            console.log(resultado);
            swal("Mensaje del sistemae", resultado , "warning");
        }
    }).fail(function(error){
	var datosJSON = $.parseJSON( error.responseText );
	swal("Error", datosJSON.mensaje , "error");
    });
}