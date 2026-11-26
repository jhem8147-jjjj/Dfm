<?php
if (session_id() == '') {
    session_start();
}

// VALIDAR SESION DEL USUARIO
if (
    empty($_SESSION['US_SIOI']) ||
    empty($_SESSION['SIAUNOMBRES']) ||
    empty($_SESSION['USPRIMERAPELLIDO'])
) {
    include_once("Index.php");
    exit;
}

// DATOS DEL USUARIO
$US_SIOI = $_SESSION['US_SIOI'];
$SIAUNOMBRES = $_SESSION['SIAUNOMBRES'];
$USPRIMERAPELLIDO = $_SESSION['USPRIMERAPELLIDO'];
$SIAUSEGUNDOAPELLIDO = isset($_SESSION['SIAUSEGUNDOAPELLIDO'])
    ? $_SESSION['SIAUSEGUNDOAPELLIDO']
    : '';

// FECHA Y HORA
$FECHA = date('d/m/Y');
$HORA = date('H:i:s');

$dias = array(
    "Domingo", "Lunes", "Martes", "Miercoles",
    "Jueves", "Viernes", "Sábado"
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