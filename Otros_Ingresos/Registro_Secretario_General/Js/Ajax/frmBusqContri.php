<?php
header('Content-Type: text/html; charset=UTF-8');
require '../Conex_Dbms/Dbms.php';
//Recogemos la cadena
$busqueda=$_POST['cadena'];

//Aquí hacer la consulta para la busqueda con LIKE $busqueda
$query = sprintf("SELECT * FROM contribuyentes WHERE DOC_IDENTIDAD='$busqueda'", 
        GetSQLValueString("%" . $busqueda . "%", "text")); //Función GetSQLValueString al fina del tema

//Esto se pega en la div #mostrar
echo 'Demo '.$busqueda; //Mostrar los resultados aquí
require '../Conex_Dbms/Cerrar_Dbms.php';

?>