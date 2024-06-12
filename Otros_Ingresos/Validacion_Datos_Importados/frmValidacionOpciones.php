<?php require_once('../Control_Sesiones_Forms/frmControlSesionUsuario.php');
require_once('../Control_Sesiones_Forms/Loading.php'); require '../Conexion_BD/Dbms.php';
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
    <td align="center" class="TITULO"><?php $result=mysql_query("select * from nombre_formularios where UBICACION='VALIDACION DE NOMBRE DE CONTRIBUYENTE' and ESTADO='ACTIVO'"); while($row=mysql_fetch_array($result)){ echo $row['DESCRIPCION']; }?></td>
  </tr>
  <tr>
    <td align="center" class="SUBTITULO">Validacion de Datos de Contribuyentes</td>
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
        <td bgcolor="#E3F0F2">Generar Comunicación Interna, Autorización para Área de Otros Ingresos.</td>
        <td><form  method="post" action="Pdf_Comunicacion_Interna/Comunicacion_Interna.php" target="_blank"><input type="submit" name="button3" id="button3" value="Generar Comunicación Interna" style="width:200px; height:35px" />
          <input name="ANIOS" type="hidden" id="ANIOS" value="<?php echo $sltGestion;?>" />
          <input name="COD_ASOCIACION" type="hidden" id="COD_ASOCIACION" value="<?php echo $COD_ASOCIACION;?>" />
        </form></td>
      </tr>
      <tr>
        <td bgcolor="#E3F0F2">2</td>
        <td bgcolor="#E3F0F2">Nueva Validación de Datos de Contribuyentes..</td>
        <td><form  method="post" action='frmValidarNombresCont.php'><input type="submit" name="button" id="button" value="Nueva Validación" style="width:200px; height:35px" /></form></td>
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
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="ASTERISCO">VER. 4</td>
  </tr>
</table>

</body>
</html><?php require '../Conexion_BD/Cerrar_Dbms.php';?>