<?php require_once('../Control_Sesiones_Forms/frmControlSesionUsuario.php');
require_once('../Control_Sesiones_Forms/Loading.php'); require '../Conexion_BD/Dbms.php';
if(empty($_SESSION['COD_ASOCIACION'])){include_once("Index.php");}else{$_SESSION['COD_ASOCIACION']=$COD_ASOCIACION;}
if(empty($_SESSION['ASOCIACION'])){include_once("Index.php");}else{$_SESSION['ASOCIACION']=$ASOCIACION;}
if(empty($_SESSION['OMS'])){include_once("Index.php");}else{$_SESSION['OMS']=$OMS;}
if(empty($_SESSION['CODIGOREGISTRO'])){include_once("Index.php");}else{$_SESSION['CODIGOREGISTRO']=$CODIGOREGISTRO;}
if(empty($_SESSION['sltGestion'])){include_once("Index.php");}else{$_SESSION['sltGestion']=$sltGestion;}
if(empty($_SESSION['COD_REGISTRO'])){include_once("Index.php");}else{$_SESSION['COD_REGISTRO']=$COD_REGISTRO;}
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
    <td align="center" class="TITULO">PROFORMA</td>
  </tr>
  <tr>
    <td align="center" class="SUBTITULO">Emisión de Proforma de Deuda</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="left">Registro</td>
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
        <td bgcolor="#E3F0F2">Imprimir Proforma Resumida, genera archivo pdf el total de la deuda de la gestion seleccionada .</td>
        <td><form  method="post" action='frmProforma2.php' target="_blank">
          <span style="font-weight: bold">
          <input name="CODIGOREGISTRO" type="hidden" id="CODIGOREGISTRO" value="<?php echo $CODIGOREGISTRO;?>" />
          </span>
          <input type="submit" name="button3" id="button3" value="Imprimir Proforma Resumida" style="width:200px; height:35px"/></form></td>
      </tr>
      <tr>
        <td bgcolor="#E3F0F2">2</td>
        <td bgcolor="#E3F0F2">Imprimir Comprobante Copia, genera archivo pdf de contribuyentes que deben de la gestión seleccionada .</td>
        <td><form  method="post" action='frmProformaDetallada.php' target="_blank">
          <span style="font-weight: bold">
          </span>
          <input type="submit" name="button" id="button" value="Imprimir Proforma Detallada" style="width:200px; height:35px"/></form></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center"><a href="frmProforma.php">Volver</a></td>
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
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="ASTERISCO">VER. 3</td>
  </tr>
</table>

</body>
</html><?php  require '../Conexion_BD/Cerrar_Dbms.php';?>