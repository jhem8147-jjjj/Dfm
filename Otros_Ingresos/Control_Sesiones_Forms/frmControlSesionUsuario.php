<?php 
session_start(); 
if(empty($_SESSION['US_SIOI'])){include_once("Index.php");}else{$_SESSION['US_SIOI']=$US_SIOI;}
if(empty($_SESSION['SIAUNOMBRES'])){include_once("Index.php");}else{$_SESSION['SIAUNOMBRES']=$SIAUNOMBRES;}
if(empty($_SESSION['USPRIMERAPELLIDO'])){include_once("Index.php");}else{$_SESSION['USPRIMERAPELLIDO']=$USPRIMERAPELLIDO;}
if(empty($_SESSION['SIAUSEGUNDOAPELLIDO'])){include_once("Index.php");}else{$_SESSION['SIAUSEGUNDOAPELLIDO']=$SIAUSEGUNDOAPELLIDO;}
if(empty($_SESSION['hostname'])){include_once("Index.php");}
if(empty($_SESSION['hostlocal'])){include_once("Index.php");}
$FECHA=date('d/m/Y');$HORA=date('H:i:s'); 
 $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
 $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$hostlocal=$_SERVER['REMOTE_ADDR'];
$hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']); 
$_SESSION["hostname"]= $hostname;
$_SESSION['hostlocal']=$hostlocal;
?>
