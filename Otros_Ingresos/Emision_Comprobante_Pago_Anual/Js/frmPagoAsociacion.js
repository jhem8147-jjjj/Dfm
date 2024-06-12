// JavaScript Document
function fileValidation(){
  //obteniendo el valor que se puso en campo text del formulario
miCampoTexto = document.getElementById("txtComunicacion").value;
miCampoTexto2 = document.getElementById("txtAutorizado").value;
miCampoTexto1 = document.getElementById("txtCargo").value;
miCampoTexto3 = document.getElementById("txtNroCuenta").value;
miCampoTexto5 = document.getElementById("txtDeposito").value;
miCampoTexto6 = document.getElementById("txtMonto").value;

        //la condición
        if (miCampoTexto.length == 0 || miCampoTexto1.length == 0 || miCampoTexto2.length == 0 || miCampoTexto3.length == 0 || miCampoTexto5.length == 0 || miCampoTexto6.length == 0 ) {
           document.getElementById('button').disabled=true;
        }else{
        	 document.getElementById('button').disabled=false;
		}

}