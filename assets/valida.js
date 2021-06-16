window.addEventListener("DOMContentLoaded", function() {
    document.getElementById('telefono').addEventListener("keypress", soloNumeros, false);
    document.getElementById('nombre').addEventListener("keypress", soloLetras, false);
    document.getElementById('name').addEventListener("keypress", soloLetras, false);
    document.getElementById('apellido').addEventListener("keypress", soloLetras, false);
});


// campo de texto solo letras
function soloLetras(e) {
    key = window.event ? e.keyCode : e.which;
    tecla = String.fromCharCode(key).toString();
    letras = " áéíóúabcdefghijklmnñopqrstuvwxyzÁÉÍÓÚABCDEFGHIJKLMNÑOPQRSTUVWXYZ";
    especiales = [8, 37, 39, 46, 6]; //Es la validación del KeyCodes, que teclas recibe el campo de texto.

    tecla_especial = false
    for (var i in especiales) {
        if (key == especiales[i]) {
            tecla_especial = true;
            break;
        }
    }

    if (letras.indexOf(tecla) == -1 && !tecla_especial) {
        e.preventDefault();
    }
}
// ======================================================================

function soloNumeros(e) {
    let key = window.event ? e.which : e.keyCode;
    if (key < 48 || key > 57) {
        e.preventDefault();
    }
    
}

// ======================================================================
function soloLetras_(e) {
    key = window.event ? e.keyCode : e.which;
    tecla = String.fromCharCode(key).toString();
    letras = " _áéíóúabcdefghijklmnñopqrstuvwxyzÁÉÍÓÚABCDEFGHIJKLMNÑOPQRSTUVWXYZ";
    especiales = [8, 37, 39, 46, 6]; //Es la validación del KeyCodes, que teclas recibe el campo de texto.

    tecla_especial = false
    for (var i in especiales) {
        if (key == especiales[i]) {
            tecla_especial = true;
            break;
        }
    }

    if (letras.indexOf(tecla) == -1 && !tecla_especial) {
        e.preventDefault();
    }
}
// ======================================================================
function soloLetrasNumeros(e) {
    key = window.event ? e.keyCode : e.which;
    tecla = String.fromCharCode(key).toString();
    letras = " _abcdefghijklmnñopqrstuvwxyzÁÉÍÓÚABCDEFGHIJKLMNÑOPQRSTUVWXYZ0123456789";
    especiales = [8, 37, 39, 46, 6]; //Es la validación del KeyCodes, que teclas recibe el campo de texto.

    tecla_especial = false
    for (var i in especiales) {
        if (key == especiales[i]) {
            tecla_especial = true;
            break;
        }
    }

    if (letras.indexOf(tecla) == -1 && !tecla_especial) {
        e.preventDefault();
    }
}
// ======================================================================
function soloDireccion(e) {
    key = window.event ? e.keyCode : e.which;
    tecla = String.fromCharCode(key).toString();
    letras = " .,áéíóúabcdefghijklmnñopqrstuvwxyzÁÉÍÓÚABCDEFGHIJKLMNÑOPQRSTUVWXYZ0123456789";
    especiales = [8, 37, 39, 46, 6]; //Es la validación del KeyCodes, que teclas recibe el campo de texto.

    tecla_especial = false
    for (var i in especiales) {
        if (key == especiales[i]) {
            tecla_especial = true;
            break;
        }
    }

    if (letras.indexOf(tecla) == -1 && !tecla_especial) {
        e.preventDefault();
    }
}

// VALIDACION PRIMERA LETRA MAYUSCULA
function MaysPrimera(string){
    return string.value = string.value.charAt(0).toUpperCase() + string.value.slice(1);
  }
  // VALIDACION TODAS LAS LETRAS MAYUSCULA
  function mayusculas(e) {
    e.value = e.value.toUpperCase();
}
// PRIMERA LETRA DE CADA PALABRA EN MAYUSCULAS
function capitalizarPalabras( val ) {
  
    return val.value = val.value.toLowerCase()
              .split(' ')
              .map( v => v[0].toUpperCase() + v.substr(1) )
              .join(' ');  
  }
  