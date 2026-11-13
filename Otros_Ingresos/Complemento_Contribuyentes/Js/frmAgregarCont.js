// JavaScript Document
function buscar_ajax(cadena){
	cadena = $.trim(cadena);
	if(cadena === ''){
		$('#mostrar').empty();
		return;
	}
	$.ajax({
	type: 'POST',
	url: 'frmBusqContriComple.php',
	data: {
		cadena: cadena,
		COD_REGISTRO: $('input[name="COD_REGISTRO"]').val(),
		CODIGO_ZONA_TRIB: $('input[name="CODIGO_ZONA_TRIB"]').val(),
		COD_ASOCIACION: $('input[name="COD_ASOCIACION"]').val(),
		ASOCIACION: $('input[name="ASOCIACION"]').val(),
		OMS: $('input[name="OMS"]').val(),
		txtCodigoRegistro: $('input[name="txtCodigoRegistro"]').val(),
		txtDocumento: $('input[name="txtDocumento"]').val(),
		txtFecha: $('input[name="txtFecha"]').val(),
		txtObservaciones: $('input[name="txtObservaciones"]').val(),
		sltGestion: $('input[name="sltGestion"]').val()
	},
	success: function(respuesta) {
		//Copiamos el resultado en #mostrar
		$('#mostrar').html(respuesta);
   },
	error: function() {
		$('#mostrar').text('No se pudo realizar la búsqueda de contribuyentes.');
	}
});
}