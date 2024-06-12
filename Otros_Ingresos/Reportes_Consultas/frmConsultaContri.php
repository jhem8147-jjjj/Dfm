<?php require_once('../Control_Sesiones_Forms/frmControlSesionUsuario.php');
require 'frmControlSesion.php';
require_once('../Control_Sesiones_Forms/Loading.php');
 require '../Conexion_BD/Dbms.php';?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
    <td align="center" class="TITULO">CONSULTA CONTRIBUYENTE</td>
  </tr>
  <tr>
    <td align="center" class="SUBTITULO">Buscar  Contribuyente</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><form  method="post" action='frmConsultaContri.php'><table width="100%" border="0">
      <tr>
        <td colspan="2" align="left" style="font-weight: bold">Datos de Contribuyente.</td>
      </tr>
      <tr>
        <td colspan="2" align="right"><img src="../Img/Linea.png" width="900" height="4" /></td>
        </tr>
      <tr>
        <td width="23%" align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span> No. de Cédula de Identidad :</td>
        <td width="77%" style="font-weight: bold; font-size: 14px;">
          <input name="txtCi" type="text" id="txtCi" style="width:250px; height:20px" onKeyPress="return soloNumeros(event)" placeholder="No. de CEDULA DE IDENTIDAD" required/> 
          <span style="font-size: 10px">
          <input name="hdBuscar" type="hidden" id="hdBuscar" value="1" />
          <span class="comentario">Ingrese solo el numero de Cédula de Identidad sin Alfa Numerico.</span></span>
        </td>
      </tr>
      <tr>
        <td align="right"><img src="../Img/Blanco.png" width="200" height="6" /></td>
        <td ><input type="submit" name="button" id="button" value="Aceptar" style="width:250px; height:35px"/></td>
      </tr>
      <tr>
        <td align="right">&nbsp;</td>
        <td >&nbsp;</td>
      </tr>
      <tr>
        <td align="right">&nbsp;</td>
        <td ><a href="frmConsultaContriAvanzada.php">Busqueda Avanzada Contribuyente</a></td>
      </tr>
    </table></form></td>
  </tr>
  <tr>
    <td class="ASTERISCO">&nbsp;</td>
  </tr><?php if($hdBuscar==1){?>
  <tr>
    <td align="left" style="font-weight: bold; font-size: 12px;">Resultados de la Busqueda.</td>
  </tr>
  <tr>
    <td><hr /></td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td   height="28" align="center" bgcolor="#999999" style="font-weight: bold">No.</td>
        <td colspan="2" align="center" bgcolor="#999999" style="font-weight: bold">CEDULA DE IDENTIDAD</td>
        <td align="center" bgcolor="#999999" style="font-weight: bold">NOMBRE(S)</td>
        <td   align="center" bgcolor="#999999" style="font-weight: bold">ESTADO</td>
        <td   align="center" style="font-weight: bold">&nbsp;</td>
      </tr><?php $res=mysql_query("select DOC_IDENTIDAD, DOC_IDENTIDAD_ALFA,EXPEDIDO,NOMBRE_RSOCIAL,PRIMER_APELLIDO,SEGUNDO_APELLIDO,APELLIDO_ESPOSO,OBSERVACIONES,CODIGO_CONTRIBUYENTE from contribuyentes RCHP where DOC_IDENTIDAD='$txtCi' and RCHP.ESTADO='ACTIVO'");
	  while($row=mysql_fetch_array($res)){ 
	 ?>
      <tr>
        <td bgcolor="#F3F3F3"><?php $cont++; echo $cont;?></td>
        <td width="3%" bgcolor="#F3F3F3"><img src="../Img/512x512.png" width="30" height="30" /></td>
        <td bgcolor="#F3F3F3"><?php if(strlen($row[1])>1){echo $row[0].' - '.$row[1].' '.$row[2];}else{echo $row[0].' '.$row[1].' '.$row[2];}?></td>
        <td bgcolor="#F3F3F3"><?php  if(strlen($row[6])>3) {echo $row[3].' '.$row[4].' '.$row[5].' de '.$row[6];}else{echo $row[3].' '.$row[4].' '.$row[5];}?></td>
        <td bgcolor="#F3F3F3" class="ASTERISCO"><?php echo $row[7];?></td>
        <td><a href="frmConsultaContri2.php?CODIGO_CONTRIBUYENTE=<?php echo $row[8];?>">Seleccionar</a></td>
      </tr><?php } ?>
    </table></td>
  </tr><?php } ?>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="ASTERISCO">VER. 0</td>
  </tr>
</table>

</body>
</html><?php require '../Control_Sesiones_Forms/Key.php';?><?php  require '../Conexion_BD/Cerrar_Dbms.php';?>