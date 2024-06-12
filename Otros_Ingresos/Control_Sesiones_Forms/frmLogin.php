<?php session_start();
$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$hostlocal=$_SERVER['REMOTE_ADDR'];
$hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']); 
$_SESSION["hostname"]= $hostname;
$_SESSION['hostlocal']=$hostlocal;
?>