<?php
if (session_id() == '') {
    session_start();
}

// VALIDAR SESION DEL USUARIO
if (
    empty($_SESSION['US_SIOI']) ||
    empty($_SESSION['SIAUNOMBRES']) ||
    empty($_SESSION['USPRIMERAPELLIDO']) ||
    empty($_SESSION['SIAUSEGUNDOAPELLIDO'])
) {
    include_once("Index.php");
    exit;
}

// FECHA Y HORA
$FECHA = date('d/m/Y');
$HORA = date('H:i:s');

$dias = array(
    "Domingo", "Lunes", "Martes", "Miercoles",
    "Jueves", "Viernes", "Sabado"
);

$meses = array(
    "Enero", "Febrero", "Marzo", "Abril",
    "Mayo", "Junio", "Julio", "Agosto",
    "Septiembre", "Octubre", "Noviembre", "Diciembre"
);

// DATOS DEL EQUIPO
$hostlocal = $_SERVER['REMOTE_ADDR'];
$hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);

$_SESSION['hostname'] = $hostname;
$_SESSION['hostlocal'] = $hostlocal;
?>
