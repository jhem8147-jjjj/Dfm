<?php require_once('../Control_Sesiones_Forms/frmControlSesionUsuario.php');
require 'frmControlSesion.php';
require_once('../Control_Sesiones_Forms/Loading.php'); require '../Conexion_BD/Dbms.php';?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel='StyleSheet' href='../Css_Formularios/frmProcesos.css' type="text/css">
<script src='Js/frmValida.js' type="text/javascript"></script>
</head>
<form  method="post" action='frmConsultaComprobantesDetallados1.php'>
<body>
<table width="30%" border="0">
  <tr>
    <td align="center" class="TITULO">REPORTE COMPROBANTE DE PAGO DETALLADO</td>
  </tr>
  <tr>
    <td align="center" class="SUBTITULO">Buscar Comprobantes de Pagos</td>
  </tr>
  <tr>
    <td style="font-weight: bold">Ingrese Números de Comprobante(s).</td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td colspan="2" align="left"><img src="../Img/Linea.png" width="900" height="4" /></td>
      </tr>
      <tr>
        <td width="23%" align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span> No. de Comprobante Inicial :</td>
        <td width="77%" style="font-weight: bold; font-size: 14px;"><span style="font-weight: bold">
          <input name="txtCinicial" type="text" id="txt" style="width:200px; height:30px" onKeyPress="return soloNumeros(event)" size="20" required="required" placeholder="No. DE COMPROBANTE DE PAGO."/>
        </span></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span> No. de Comprobante Final :</td>
        <td ><span style="font-weight: bold">
        <input name="txtCfinal" type="text" id="txt2" style="width:200px; height:30px" required="required" onKeyPress="return soloNumeros(event)" placeholder="No. DE COMPROBANTE DE PAGO."/>
        </span></td>
      </tr>
      <tr>
        <td align="right"><img src="../Img/Blanco.png" width="200" height="6" /></td>
        <td ><input type="submit" name="button" id="button" value="Aceptar" style="width:250px; height:35px"/></td>
      </tr>
      <tr>
        <td align="right">&nbsp;</td>
        <td >&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
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
  <tr>
    <td class="ASTERISCO">VER. 0</td>
  </tr>
</table>
</body></form>
</html><?php  require '../Conexion_BD/Cerrar_Dbms.php';?>