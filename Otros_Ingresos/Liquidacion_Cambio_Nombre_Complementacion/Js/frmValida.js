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
	
function fileValidation(){
  //obteniendo el valor que se puso en campo text del formulario
miCampoTexto1 = document.getElementById("txtDepositoCN").value;
miCampoTexto2 = document.getElementById("txtMontoCn").value;
miCampoTexto3 = document.getElementById("txtMultaCn").value;
miCampoTexto4 = document.getElementById("txtFormularioCN").value;
      //la condición
        if (miCampoTexto1.length == 0 || miCampoTexto2.length == 0 || miCampoTexto3.length == 0 || miCampoTexto4.length == 0) {
           document.getElementById('button').disabled=true;
        }else{
        	 document.getElementById('button').disabled=false;
		}

}

function fileValidation1(){
  //obteniendo el valor que se puso en campo text del formulario
miCampoTexto1 = document.getElementById("txtDepositoCC").value;
miCampoTexto2 = document.getElementById("txtMontoCC").value;
miCampoTexto3 = document.getElementById("txtMultaCC").value;
miCampoTexto4 = document.getElementById("txtFormularioCC").value;
      //la condición
        if (miCampoTexto1.length == 0 || miCampoTexto2.length == 0 || miCampoTexto3.length == 0 || miCampoTexto4.length == 0) {
           document.getElementById('button2').disabled=true;
        }else{
        	 document.getElementById('button2').disabled=false;
		}

}

