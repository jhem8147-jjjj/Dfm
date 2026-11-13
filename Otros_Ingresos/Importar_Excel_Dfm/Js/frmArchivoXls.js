// JavaScript Document
function fileValidation(){
    var fileInput = document.getElementById('excel');
    var filePath = fileInput.value;
    var allowedExtensions = /\.(xls|xlt|xlsx|xlsm|xltx|xltm|xml|ods|ots)$/i;
    var submitButton = document.getElementById('button');
    var preview = document.getElementById('imagePreview');

    if(!allowedExtensions.exec(filePath)){
        if (filePath !== '') {
            alert('Seleccione un archivo Excel (.xls, .xlsx, .xlsm, .xlt, .xltx, .xltm o .xml) o OpenDocument (.ods, .ots).');
            fileInput.value = '';
        }
        preview.innerHTML = '';
        submitButton.disabled = true;
        return false;
    }

    preview.innerHTML = '<span class="comentario">Archivo seleccionado</span>';
    submitButton.disabled = false;
    return true;
}

function importacionEnviada(){
    var fileInput = document.getElementById('excel');
    var allowedExtensions = /\.(xls|xlt|xlsx|xlsm|xltx|xltm|xml|ods|ots)$/i;
    var submitButton = document.getElementById('button');

    if(!fileInput || !allowedExtensions.test(fileInput.value)){
        alert('Seleccione un archivo Excel u OpenDocument compatible antes de continuar.');
        return false;
    }

    submitButton.value = 'Procesando...';
    submitButton.disabled = true;
    return true;
}