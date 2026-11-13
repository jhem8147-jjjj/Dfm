<?php header('Content-Type: text/html; charset=utf-8');
require_once('../Control_Sesiones_Forms/frmControlSesionUsuario.php');
if(empty($_SESSION['COD_REGISTRO']) || empty($_SESSION['CODIGO_ZONA_TRIB']) || empty($_SESSION['COD_ASOCIACION']) || empty($_SESSION['ASOCIACION']) || empty($_SESSION['txtCodigoRegistro']) || empty($_SESSION['txtDocumento']) || empty($_SESSION['txtFecha']) || empty($_SESSION['sltGestion'])){
    header('Location: Index.php');
    exit;
}
 ?><!DOCTYPE html>
<html>
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
        <td bgcolor="#E3F0F2">Generar Comunicación Interna, Autorización para área de Otros Ingresos.</td>
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