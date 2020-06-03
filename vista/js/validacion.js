

function letras_numeros(e) {

    key = e.keyCode || e.which;
    teclado = String.fromCharCode(key).toLowerCase();
    letras = " abcdefghijklmnopqrstuvwxyz1234567890-";

    if (letras.indexOf(teclado) === -1) {
        return false;
    }

}
function sololetras(e) {

    key = e.keyCode || e.which;
    teclado = String.fromCharCode(key).toLowerCase();
    letras = " abcdefghijklmnopqrstuvwxyz";

    if (letras.indexOf(teclado) === -1) {
        return false;
    }

}

function numeros(e) {

    key = e.keyCode || e.which; //captura entrada del teclado
    teclado = String.fromCharCode(key);
    letras = "1234567890";

    if (letras.indexOf(teclado) === -1) {
        return false;
    }

}

function decimales(e) {

    key = e.keyCode || e.which; //captura entrada del teclado
    teclado = String.fromCharCode(key);
    letras = "1234567890.";

    if (letras.indexOf(teclado) === -1) {
        return false;
    }


}

function solonumeros(e) {

    key = e.keyCode || e.which; //captura entrada del teclado
    teclado = String.fromCharCode(key);
    letras = "#1234567890-";

    if (letras.indexOf(teclado) === -1) {
        return false;
    }

}

function medida(e) {

    key = e.keyCode || e.which; //captura entrada del teclado
    teclado = String.fromCharCode(key);
    letras = " xX1234567890.";

    if (letras.indexOf(teclado) === -1) {
        return false;
    }

}

function dni_ruc(e) {

    key = e.keyCode || e.which; //captura entrada del teclado
    teclado = String.fromCharCode(key);
    letras = "1234567890";

    if (letras.indexOf(teclado) === -1) {
        return false;

    }
    espe(e);
}

function espe(e) {
    key = e.keyCode || e.which; //captura entrada del teclado
    teclado = String.fromCharCode(key);
    letras = "|!#$%&/(()=?*¨*[];:_'¿´+{},.";

    if (letras.indexOf(teclado) !== -1) {
        return false;
    }
}

function correo(e) {
    key = e.keyCode || e.which; //captura entrada del teclado
    teclado = String.fromCharCode(key);
    letras = "|!#$%&/(()=?*¨*[];:'¿´+{},";

    if (letras.indexOf(teclado) !== -1) {
        return false;
    }
}

function medida(e) {
    key = e.keyCode || e.which; //captura entrada del teclado
    teclado = String.fromCharCode(key);
    letras = " 1234567890.x";

    if (letras.indexOf(teclado) === -1) {
        return false;
    }
}

function precio(e) {
    key = e.keyCode || e.which; //captura entrada del teclado
    teclado = String.fromCharCode(key);
    letras = "1234567890.";

    if (letras.indexOf(teclado) === -1) {
        return false;
    }
}

function edit() {
    title = "texto al pasar el raton";
}


function validar() {

    var h = "";
    h = $("#txtdr").val();
    if (h === "") {
        alert("dni vacio");

    }
    alert("entrooo");
}

function num_cuotas() {

    var h = $("#txtnc").val();
    if (h <= 0) {
        alert("El número de cuotas debe ser mayor a cero");
        $("#txtnc").val("1");
    }
}

function validar_digitos_documento() {
    var value_documento = $("#txtdni_ruc").val();
    console.log(value_documento);
    if (tipo_documento == 'dni') {
        if (value_documento.length != 8) {
            swal({
                type: 'warning',
                title: 'Nota',
                text: 'El DNI debe contener 8 caracteres!'
            })
        }

    } else {
        if (value_documento.length != 11) {
            swal({
                type: 'warning',
                title: 'Nota',
                text: 'El RUC debe contener 11 caracteres!',
            })
        }
    }

    //return true;
}

function validar_entrada_cliente() {

    var numero = $("#txtdni_ruc").val();
    var cliente = $("#txtnombre").val();
    var razon = $("#txtrazon").val();
    var dir = $("#txtdireccion").val();

    if (numero === '') {
        console.log("entro");
        swal({
            type: 'warning',
            title: 'Nota',
            text: 'Ingrese campo DNI/RUC!',
        })
    } else {
        if (cliente === '') {
            console.log("cliente");
            swal({
                type: 'warning',
                title: 'Nota',
                text: 'Ingrese nombre del cliente!',
            })
        } else {
            if (razon === '') {
                console.log("razon");
                swal({
                    type: 'warning',
                    title: 'Nota',
                    text: 'Ingrese la razon social!',
                })
            } else {
                if (dir === '') {
                    console.log("dir");
                    swal({
                        type: 'warning',
                        title: 'Nota',
                        text: 'Ingrese la dirección!',
                    })
                } else {
                    if (dir === '') {
                        console.log("dir");
                        swal({
                            type: 'warning',
                            title: 'Nota',
                            text: 'Ingrese la dirección!',
                        })
                    }
                }

            }
        }
    }

    return true;
}

function validar_entrada_producto() {

    var medida = $("#txtmedida").val();
    var des = $("#txtdescripcion").val();
    var stock = $("#txtstock").val();
    var sminimo = $("#txtstock_minimo").val();
    var precio = $("#txtprecio").val();

    if (medida === '') {
        swal({
            type: 'warning',
            title: 'Nota',
            text: 'Ingrese Medida del producto!',
        })
    } else {
        if (des === '') {
            swal({
                type: 'warning',
                title: 'Nota',
                text: 'Ingrese descripcion, ejem: 200 Bolsas!',
            })
        } else {
            if (stock === '0' || stock === '') {
                swal({
                    type: 'warning',
                    title: 'Nota',
                    text: 'Ingrese  el stock !',
                })
            } else {
                if (sminimo === '0' || sminimo === '') {
                    swal({
                        type: 'warning',
                        title: 'Nota',
                        text: 'Ingrese  el stock mímimo!',
                    })
                } else {
                    if (precio === '0.0' || precio === '') {
                        swal({
                            type: 'warning',
                            title: 'Nota',
                            text: 'Ingrese precio!',
                        })
                    }
                }

            }
        }
    }

    return true;
}

function validar_num_cuotas() {
    var value = $("txtnum_cuotas").val();
    if (value > 12) {
        swal({
            type: 'warning',
            title: 'Nota',
            text: 'EL número de cuotas no debe ser mayor a 12!',
        })
    }
}

function validar_stock() {
    var stock = $("#txten_stock").val();
    var cantidad = $("#txtcantidad").val();
    if (parseInt(stock) < parseInt(cantidad)) {
        swal({
            type: 'warning',
            title: 'Nota',
            text: 'La cantidad no debe superar el stock del producto!',
        })
        $("#txtcantidad").val("");
        $("#txtcantidad").focus();
    }
}


function validarNumeros(evento) {
    var tecla = (evento.which) ? evento.which : evento.keyCode;
    if (tecla >= 48 && tecla <= 57 || tecla == 46) {
        return true;
    }

    return false;
}

