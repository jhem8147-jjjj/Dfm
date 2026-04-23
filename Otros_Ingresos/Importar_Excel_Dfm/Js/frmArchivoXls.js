// JavaScript Document
function fileValidation(){
    var fileInput = document.getElementById('excel');
    var filePath = fileInput.value;
    var allowedExtensions = /(.xls|.xlsx)$/i;
    if(!allowedExtensions.exec(filePath)){
        alert('Por favor suba el archivo que tiene extensiones .xls/.xlsx solamente.');
        fileInput.value = '';
        return false;
    }else{
        //Image preview
        if (fileInput.files && fileInput.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
				 document.getElementById('imagePreview').innerHTML = '<img src="../Img/Validar.png" width="25" height="25"/>';
				 document.getElementById('button').disabled=false;
            };
            reader.readAsDataURL(fileInput.files[0]);
        }
    }
}