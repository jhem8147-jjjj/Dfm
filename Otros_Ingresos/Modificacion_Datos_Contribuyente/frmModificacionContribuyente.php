<?php require_once('../Control_Sesiones_Forms/frmControlSesionUsuario.php');
require 'frmControlSesion.php';
require_once('../Control_Sesiones_Forms/Loading.php'); require '../Conexion_BD/Dbms.php';?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel='StyleSheet' href='../Css_Formularios/frmProcesos.css' type="text/css">
<script src='Js/frmValida.js' type="text/javascript"></script>
<style type="text/css"></style>
</head>
<body>
<table width="30%" border="0">
  <tr>
    <td align="center" class="TITULO">MODIFICAR DATOS CONTRIBUYENTE</td>
  </tr>
  <tr>
    <td align="center" class="SUBTITULO">Buscar  Contribuyente</td>
  </tr>
  <tr>
    <td><img src="../Img/Linea.png" width="900" height="4" /></td>
  </tr>
  <tr>
    <td><form  method="post" action='frmModificacionCOntribuyente.php'><table width="100%" border="0">
      <tr>
        <td colspan="2" align="left" style="font-weight: bold">DATOS DE CONTRIBUYENTE.</td>
      </tr>
      <tr>
        <td colspan="2" align="right"><hr /></td>
        </tr>
      <tr>
        <td width="23%" align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span> No. de Cédula de Identidad :</td>
        <td width="77%" style="font-weight: bold; font-size: 14px;"><span style="font-weight: bold">
          <input name="txtCi" type="text" id="txtCi" style="width:250px; height:20px" onKeyPress="return soloNumeros(event)" placeholder="No. de CEDULA DE IDENTIDAD" required/>
          -
          <input name="txtCi2" type="text" id="txtCi2" style="width:75px; height:20px" maxlength="5" onKeyPress="return soloLetrasNumeros(event)">
          <input name="BUSQ" type="hidden" id="BUSQ" value="1" />
          </span></td>
      </tr>
      <tr>
        <td align="right">&nbsp;</td>
        <td style="font-style: italic; font-weight: bold;" >ES RESPONSABILIDAD DEL OPERADOR LA MODIFICACION DE DATOS DEL CONTRIBUYENTE.</td>
      </tr>
      <tr>
        <td align="right"><img src="../Img/Blanco.png" width="200" height="6" /></td>
        <td ><input type="submit" name="button" id="button" value="Aceptar" style="width:250px; height:35px" onclick="disabled"/></td>
      </tr>
    </table></form></td>
  </tr>
  <tr><?php if($BUSQ==1){?>
    <td align="left"><span style="font-weight: bold">Resultados Encontrados</span>.</td>
  </tr>
  <tr>
    <td><hr /></td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td height="41" align="center" bgcolor="#CCCCCC" style="font-weight: bold">Registro Contribuyente</td>
        <td align="center" bgcolor="#CCCCCC" style="font-weight: bold">Documentación de Identificación</td>
        <td align="center" bgcolor="#CCCCCC" style="font-weight: bold">Nombre Completo</td>
        <td align="center" style="font-weight: bold">&nbsp;</td>
      </tr><?php $res=mysql_query("select * from contribuyentes where DOC_IDENTIDAD='$txtCi' and DOC_IDENTIDAD_ALFA='$txtCi2' and ESTADO='ACTIVO'");
	  while($row=mysql_fetch_array($res)){ 
	 ?>
      <tr>
        <td height="31" bgcolor="#F4F4F4"><?php echo $row['CODIGO_CONTRIBUYENTE']; ?></td>
        <td bgcolor="#F4F4F4"><?php echo $row['DOC_IDENTIDAD'].' '.$row['DOC_IDENTIDAD_ALFA'].' '.$row['EXPEDIDO']; ?></td>
        <td bgcolor="#F4F4F4"><?php if($row['APELLIDO_ESPOSO'] == null){ echo $row['NOMBRE_RSOCIAL'].' '.$row['PRIMER_APELLIDO'].' '.$row['SEGUNDO_APELLIDO'];}else{echo $row['NOMBRE_RSOCIAL'].' '.$row['PRIMER_APELLIDO'].' '.$row['SEGUNDO_APELLIDO'].' de '.$row['APELLIDO_ESPOSO'];} ?> <span class="ASTERISCO"><?php if($row['PRIMER_APELLIDO']==null and $row['SEGUNDO_APELLIDO']==null){?>
          (DATOS  NO ACTUALIZADOS)
          <?php } ?></span></td>
        <td bgcolor="#F4F4F4"><a href="frmModificacionContribuyente1.php?txtCi=<?php echo $row['DOC_IDENTIDAD'];?>&txtCi2=<?php echo $row['DOC_IDENTIDAD_ALFA'];?>&CodigoRegistro=<?php echo $row['CODIGO_REGISTRO'];?>&txtCodigoContribuyente=<?php echo $row['CODIGO_CONTRIBUYENTE'];?> " title="Modificar Datos Contribuyente">Modificar</a></td>
      </tr><?php } ?>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr><?php } ?>
  <tr>
    <td class="ASTERISCO">VER. 0</td>
  </tr>
</table>

</body>
</html><?php  require '../Conexion_BD/Cerrar_Dbms.php'; ?>