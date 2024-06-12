<?php require_once('../Control_Sesiones_Forms/frmControlSesionUsuario.php');
require_once('../Control_Sesiones_Forms/Loading.php');
if(empty($_SESSION['COD_REGISTRO'])){include_once("Index.php");}
if(empty($_SESSION['CODIGO_ZONA_TRIB'])){include_once("Index.php");}
if(empty($_SESSION['COD_ASOCIACION'])){include_once("Index.php");}
if(empty($_SESSION['ASOCIACION'])){include_once("Index.php");}
if(empty($_SESSION['txtCodigoRegistro'])){include_once("Index.php");}
if(empty($_SESSION['txtFecha'])){include_once("Index.php");}
if(empty($_SESSION['txtObservaciones'])){include_once("Index.php");}
if(empty($_SESSION['sltGestion'])){include_once("Index.php");}
 ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel='StyleSheet' href='../Css_Formularios/frmProcesos.css' type="text/css">
<style type="text/css">
</style>
</head>

<body>
<table width="50%" border="0">
  <tr>
    <td align="center" class="TITULO">COMPLEMENTACION</td>
  </tr>
  <tr>
    <td align="center" class="SUBTITULO">GENERAR COMUNICACION INTERNA</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="left" style="font-weight: bold">REGISTRO FINAL</td>
  </tr>
  <tr>
    <td><img src="../Img/Linea.png" width="843" height="4" /></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="3" cellpadding="2">
      <tr>
        <td height="32" align="center" bgcolor="#CCCCCC" style="font-weight: bold">PASO</td>
        <td align="center" bgcolor="#CCCCCC" style="font-weight: bold">DESCRIPCION</td>
        <td align="center" style="font-weight: bold">&nbsp;</td>
      </tr>
      <tr>
        <td bgcolor="#E3F0F2">1</td>
        <td bgcolor="#E3F0F2">Generar Comunicación Interna, Autorización para Área de Otros Ingresos.</td>
        <td><form  method="post" action='Pdf_Complementos/frmGenerarComunInternaCC.php' target="_blank" rel="noopener noreferrer"><input type="submit" name="button3" id="button3" value="Generar Comunicación Interna" style="width:200px; height:35px" />
        </form></td>
      </tr>
      <tr>
        <td bgcolor="#E3F0F2">2</td>
        <td bgcolor="#E3F0F2">Nuevo Registro, generar nueva registro de Complemntos.</td>
        <td><form  method="post" action='frmComplementacion.php'><input type="submit" name="button" id="button" value=" Nuevo Registro" style="width:200px; height:35px" /></form></td>
      </tr>
    </table></td>
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
    <td class="ASTERISCO">VER. 3</td>
  </tr>
</table>

</body>
</html>