// JavaScript Document
function fileValidation(){
  //obteniendo el valor que se puso en campo text del formulario
miCampoTexto2 = document.getElementById("txtOrdenanzaMunicipal").value;
miCampoTexto1 = document.getElementById("txtDescripcion").value;
miCampoTexto = document.getElementById("txtZona").value;
miCampoTexto3 = document.getElementById("txtDireccion").value;

        //la condición
        if (miCampoTexto.length == 0 || miCampoTexto1.length == 0 || miCampoTexto2.length == 0 || miCampoTexto3.length == 0 ) {
           document.getElementById('button').disabled=true;
        }else{
        	 document.getElementById('button').disabled=false;
		}

}