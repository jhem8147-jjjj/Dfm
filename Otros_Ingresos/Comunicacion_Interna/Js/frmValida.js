// JavaScript Document
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
       letras = "0123456789ABSCDEFGHIJKLMNOPQRSTUVWXYZ abcdefghijklmnopqrstuvwxyz.";
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
miCampoTexto1 = document.getElementById("txtGrado").value;
miCampoTexto2 = document.getElementById("txtNombres").value;
miCampoTexto3 = document.getElementById("txtCargo").value;
      //la condición
        if (miCampoTexto1.length == 0 || miCampoTexto2.length == 0 || miCampoTexto3.length == 0) {
           document.getElementById('button').disabled=true;
        }else{
        	 document.getElementById('button').disabled=false;
		}

}
