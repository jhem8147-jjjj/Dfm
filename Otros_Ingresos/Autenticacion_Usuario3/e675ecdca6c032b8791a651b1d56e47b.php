<?php require 'frmComplementos/frmLogin.php'; $SW=0; $FECHA=date('d/m/Y'); $HORA=date('h:i:s');
require'../Loading.php';
require('../Conexion_BD/Dbms_Usuario.php');  
//verifica en la bd si esta registrado.
$password=md5($password); $roles=mysql_query("select US.USUARIO,US.NOMBRES,US.PRIMER_APELLIDO,US.SEGUNDO_APELLIDO,US.CARGO,US.AREA from usuarios US,  asignacion_roles AR where( US.USUARIO='$username' and US.PASSWORD='$password' and US.ESTADO='DESBLOQUEADO' and AR.APLICACION='SIOI' and AR.ESTADO='VIGENTE' ) ");while($rows=mysql_fetch_array($roles)){ $_SESSION['US_SIOI']=$rows['0']; $SIAUNOMBRES= $rows['1']; $_SESSION['SIAUNOMBRES'] = $rows['1']; $_SESSION["USPRIMERAPELLIDO"]=$rows['2']; $SIAUSEGUNDOAPELLIDO= $rows['3'];$_SESSION['SIAUSEGUNDOAPELLIDO'] = $rows['3'];$_SESSION['SIOICARGO'] = $rows['4'];$_SESSION['SIOIAREA'] = $rows['5'];$SW=1;}
//cuenta los ingresos
$INTENTOS=$INTENTOS+1;
$_SESSION['INTENTOS']=$INTENTOS;
if($SW==1){echo"<script> location.href='frmArmadoPanel.php';</script>";}else{echo"<script> location.href='a62969f7bff757f0bcb7aaabe171cde8.php';</script>";}
//cierra la bd
require('../Conexion_BD/Cerrar_Dbms.php');
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.:: GOBIERNO AUTONOMO MUNICIPAL DE EL ALTO ::.</title>
<script language="JavaScript" src='Js/frmMax.js' type="text/javascript"></script>
<script language="JavaScript" src='Js/frmValida.js' type="text/javascript"></script>
<style type="text/css">
body {
	background-color: #CCC;
}
body,td,th {
	color: #000;
}
</style>
</head>

<body   onselectstart="return false" oncontextmenu="return false" ondragstart="return false">
<table width="100%" border="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center" style="font-weight: bold; font-size: 24px;">&nbsp;</td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td align="center"><table width="40%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000" bordercolordark="#ffffff" bordercolorlight="#ffffff">
      <tr>
        <td align="center" background="images/bg.jpg"><img src="images/cargando.gif" width="189" height="38" /></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>