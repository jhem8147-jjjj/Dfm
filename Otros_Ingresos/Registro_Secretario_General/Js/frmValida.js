function permiteTeclaComposicion(e) {
    var key = e && typeof e.key === 'string' ? e.key : '';
    var code = e ? (e.keyCode || e.which || 0) : 0;
    return !!(e && (e.isComposing || e.keyCode === 0 || e.keyCode === 229 ||
        (code >= 160 && code <= 255) ||
        key === 'Dead' || key === 'Process' || key === '\u00b4' ||
        key === '\u00a8' || key === '^' || key === '`' || key === '~' ||
        /^[\u0300-\u036f]$/.test(key)));
}

// JavaScript Document, 
function soloNumeros(e){
       key = e.keyCode || e.which;
       tecla = (e.key && e.key.length === 1 ? e.key : String.fromCharCode(key)).toLowerCase();
       letras = "0123456789";
       especiales = "8-32-9";

       tecla_especial = false
       for(var i in especiales){
            if(key == especiales[i]){
                tecla_especial = true;
                break;
            }
        }

        if(letras.indexOf(tecla)==-1 && !tecla_especial){
            return false;
        }
    }
	
	
function soloLetrasNumeros(e){
       key = e.keyCode || e.which;
       tecla = (e.key && e.key.length === 1 ? e.key : String.fromCharCode(key)).toLowerCase();
       letras = "0123456789ABSCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz\u00e1\u00e9\u00ed\u00f3\u00fa\u00fc\u00f1";
       especiales = "8-32-9";

       tecla_especial = false
       for(var i in especiales){
            if(key == especiales[i]){
                tecla_especial = true;
                break;
            }
        }

        if(letras.indexOf(tecla)==-1 && !tecla_especial && !permiteTeclaComposicion(e)){
            return false;
        }
    }


function soloLetras(e){
       key = e.keyCode || e.which;
       tecla = (e.key && e.key.length === 1 ? e.key : String.fromCharCode(key)).toLowerCase();
       letras = "ABSCDEFGHIJKLMNOPQRSTUVWXYZ abcdefghijklmnopqrstuvwxyz\u00e1\u00e9\u00ed\u00f3\u00fa\u00fc\u00f1";
       especiales = "8-32-9";

       tecla_especial = false
       for(var i in especiales){
            if(key == especiales[i]){
                tecla_especial = true;
                break;
            }
        }

        if(letras.indexOf(tecla)==-1 && !tecla_especial && !permiteTeclaComposicion(e)){
            return false;
        }
    }

function soloNumeroSigno(e){
       key = e.keyCode || e.which;
       tecla = (e.key && e.key.length === 1 ? e.key : String.fromCharCode(key)).toLowerCase();
       letras = "0123456789-";
       especiales = "8-32-9";

       tecla_especial = false
       for(var i in especiales){
            if(key == especiales[i]){
                tecla_especial = true;
                break;
            }
        }

        if(letras.indexOf(tecla)==-1 && !tecla_especial){
            return false;
        }
    }
	
function correoElectronico(e){
       key = e.keyCode || e.which;
       tecla = (e.key && e.key.length === 1 ? e.key : String.fromCharCode(key)).toLowerCase();
       letras = "0123456789abcdefghijklmnopqrstuvwxyz\u00e1\u00e9\u00ed\u00f3\u00fa\u00fc\u00f1-.@";
       especiales = "8-32-9";

       tecla_especial = false
       for(var i in especiales){
            if(key == especiales[i]){
                tecla_especial = true;
                break;
            }
        }

        if(letras.indexOf(tecla)==-1 && !tecla_especial && !permiteTeclaComposicion(e)){
            return false;
        }
    }

//
function fileValidation(){
  //obteniendo el valor que se puso en campo text del formulario
miCampoTexto1 = document.getElementById("txtNroCi").value;
miCampoTexto2 = document.getElementById("txtNombres").value;
miCampoTexto3 = document.getElementById("txtPapellido").value;
      //la condición
        if (miCampoTexto1.length == 0 || miCampoTexto2.length == 0 || miCampoTexto3.length == 0) {
           document.getElementById('button').disabled=true;
        }else{
        	 document.getElementById('button').disabled=false;
		}

}