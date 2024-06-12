// JavaScript Document
function soloNumeros(e){
       key = e.keyCode || e.which;
       tecla = String.fromCharCode(key).toLowerCase();
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
       tecla = String.fromCharCode(key).toLowerCase();
       letras = "ABSCDEFGHIJKLMNOPQRSTUVWXYZ abcdefghijklmnopqrstuvwxyz1234567890";
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
	
	    function soloLetras(e){
       key = e.keyCode || e.which;
       tecla = String.fromCharCode(key).toLowerCase();
       letras = "ABSCDEFGHIJKLMNOPQRSTUVWXYZ abcdefghijklmnopqrstuvwxyz.";
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



function soloNumAlfSig(e){
       key = e.keyCode || e.which;
       tecla = String.fromCharCode(key).toLowerCase();
       letras = "0123456789ABSCDEFGHIJKLMNOPQRSTUVWXYZ abcdefghijklmnopqrstuvwxyz/-.";
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
function soloNumAlfSigD(e){
       key = e.keyCode || e.which;
       tecla = String.fromCharCode(key).toLowerCase();
       letras = "0123456789ABSCDEFGHIJKLMNOPQRSTUVWXYZ abcdefghijklmnopqrstuvwxyz/-,";
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
	
function soloNumerosPunto(e){
       key = e.keyCode || e.which;
       tecla = String.fromCharCode(key).toLowerCase();
       letras = "0123456789.";
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
	function soloNumerosGuiones(e){
       key = e.keyCode || e.which;
       tecla = String.fromCharCode(key).toLowerCase();
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

function fileValidation(){
  //obteniendo el valor que se puso en campo text del formulario
miCampoTexto1 = document.getElementById("txtCarpeta").value;
miCampoTexto2 = document.getElementById("txtOrdenanzaMunicipal").value;
miCampoTexto3 = document.getElementById("txtDescripcion").value;
miCampoTexto4 = document.getElementById("txtZona").value;
miCampoTexto5 = document.getElementById("txtDireccion").value;
miCampoTexto6 = document.getElementById("txtPuestos").value;
miCampoTexto7 = document.getElementById("txtCentralera").value;
miCampoTexto8 = document.getElementById("txtKiosko").value;
miCampoTexto9 = document.getElementById("txtArchivo").value;
      //la condición
        if (miCampoTexto1.length == 0 || miCampoTexto2.length == 0 || miCampoTexto3.length == 0 || miCampoTexto4.length == 0 || miCampoTexto5.length == 0 || miCampoTexto6.length == 0 || miCampoTexto7.length == 0 || miCampoTexto8.length == 0 || miCampoTexto9.length == 0) {
           document.getElementById('button').disabled=true;
        }else{
        	 document.getElementById('button').disabled=false;
		}

}
