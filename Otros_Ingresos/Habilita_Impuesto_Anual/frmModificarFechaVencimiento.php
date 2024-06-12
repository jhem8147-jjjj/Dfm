<?php require_once('../Control_Sesiones_Forms/frmControlSesionUsuario.php');
require_once('../Control_Sesiones_Forms/Loading.php'); 
require '../Conexion_BD/Dbms.php';
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel='StyleSheet' href='../Css_Formularios/frmProcesos.css' type="text/css">
<script src='Js/frmValida.js' type="text/javascript"></script>
</head>
<form  method="post" action='frmRegFechaInicioVencimiento.php'>
<body>
<table width="50%" border="0">
  <tr>
    <td align="center" class="TITULO">&nbsp;</td>
    <td align="center" class="TITULO">MODIFICAR GESTION DE COBRO DE IMPUESTO</td>
  </tr>
  <tr>
    <td align="center" class="SUBTITULO">&nbsp;</td>
    <td align="center" class="SUBTITULO">Fecha Inicio y Fecha de Culminacion de Cobro de Impuesto</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><img src="../Img/Linea.png" width="843" height="4" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Datos Fecha de Inicio y Conclusión de cobro de Impuesto Eventual..</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><table width="100%" border="0" cellpadding="2" cellspacing="2">
      <tr>
        <td width="48%" align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span> Gestion de Cobro de Impuesto  :</td>
        <td width="52%"><select name="sltGestion" id="sltGestion" required>
         
          <option><?php echo $sltGestiones; ?></option>
        </select></td>
      </tr>
      <tr>
        <td align="right"><img src="../Img/Blanco.png" width="400" height="6" /></td>
        <td class="comentario">&nbsp;</td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span> Fecha de Inicio de Cobro de Impuesto  :</td>
        <td><input name="txtFechaInicio" type="date" id="txtFechaInicio" value='<?php echo $FechaInicio;?>'  required/></td>
      </tr>
      <tr>
        <td align="right"><img src="../Img/Blanco.png" width="400" height="6" /></td>
        <td class="comentario">&nbsp;</td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span> Fecha de Culminacion de Cobro de Impuesto  :</td>
        <td><input name="txtFechaFin" type="date" id="txtFechaFin" value='<?php echo $FechaFin;?>' required="required"/>
          <input name="txtSwm" type="hidden" id="txtSwm" value="1" /></td>
      </tr>
      <tr>
        <td align="right"><img src="../Img/Blanco.png" width="400" height="6" /></td>
        <td class="comentario">&nbsp;</td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span> Ufv de la fecha de Culminacion de Cobro de Impueso :</td>
        <td><input name="txtUfv" type="text" id="txtUfv" value="<?php echo $ValorUfv;?>" onkeypress="return soloNumPunto(event)" placeholder="Valor de Ufv" required />
          <input name="CODREGM" type="hidden" id="CODREGM" value="<?php echo $CODREGM;?>" /></td>
      </tr>
      <tr>
        <td align="right">&nbsp;</td>
        <td class="comentario">&nbsp;</td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">* </span>Observaciones :</td>
        <td ><textarea name="txtObservaciones" id="txtObservaciones" cols="45" rows="5" maxlength="250" required>NINGUNO.</textarea></td>
      </tr>
      <tr>
        <td align="right"><img src="../Img/Blanco.png" width="400" height="6" /></td>
        <td ><input type="submit" name="button" id="button" value="Modificar" style="width:250px; height:35px"/></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td class="ASTERISCO">&nbsp;</td>
    <td align="center" class="ASTERISCO"><a href="frmRegFechaInicioVencimiento.php">Volver</a></td>
  </tr>
  <tr>
    <td class="ASTERISCO">&nbsp;</td>
    <td class="ASTERISCO">VER. 1</td>
  </tr>
</table>
</body></form>
</html><?php  require '../Conexion_BD/Cerrar_Dbms.php';?>