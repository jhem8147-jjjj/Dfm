<?php require '../Control_Sesiones_Forms/frmControlSesionUsuario.php'; require'frmCerrarSesiones.php';require_once('../Control_Sesiones_Forms/Loading.php'); ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel='StyleSheet' href='cssFormato.css' type="text/css">
<script language="JavaScript" src='Js/jsValidacion.js' type="text/javascript"></script>
<form 	method="POST" action="frmAdicion2.php">
<body>
<table width="70%" border="0">
  <tr>
    <td align="center" class="TITULO">REGISTRO DE USUARIO</td>
  </tr>
  <tr>
    <td align="center" class="SUBTITULO">REGISTRAR NUEVO USUARIO</td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td colspan="2" align="left" class="TITULO">DATOS DE OPERADOR.</td>
      </tr>
      <tr>
        <td colspan="2" align="right"><hr /></td>
        </tr>
      <tr>
        <td align="right" bgcolor="#F9F9F9"><table width="100%" height="26" border="1" cellpadding="0" cellspacing="0" bordercolor="#6699FF">
          <tr bordercolor="#FF9900" bordercolorlight="#FF9900">
            <td align="right" bordercolor="#6699FF"> ( <span class="ASTERISCO">*</span> ) No. de Documento :</td>
            </tr>
          </table></td>
        <td><input type="text" name="txtNoDocumento" id="txtNoDocumento" style="width:300px; height:25px" onchange="return fileValidation();"  onkeypress="return soloNumAlf(event)" placeholder="No. DE CEDULA DE IDENTIDAD"^required/>
          <input name="hdfReg" type="hidden" id="hdfReg" value="1" /></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#F9F9F9"><table width="100%" height="26" border="1" cellpadding="0" cellspacing="0" bordercolor="#6699FF">
          <tr bordercolor="#FF9900" bordercolorlight="#FF9900">
            <td align="right" bordercolor="#6699FF"> ( <span class="ASTERISCO">*</span> ) Expedido :</td>
          </tr>
        </table></td>
        <td><select name="sltExpedido" id="sltExpedido">
          <option selected="selected">LA PAZ</option>
          <option>ORURO</option>
          <option>POTOSI</option>
          <option>PANDO</option>
          <option>BENI</option>
          <option>COCHABAMBA</option>
          <option>SANTA CRUZ</option>
          <option>TARIJA</option>
          <option>CHUQUISACA</option>
	  <option> </option>
        </select></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#F9F9F9"><table width="100%" height="26" border="1" cellpadding="0" cellspacing="0" bordercolor="#6699FF">
          <tr bordercolor="#FF9900" bordercolorlight="#FF9900">
            <td align="right" bordercolor="#6699FF"> ( <span class="ASTERISCO">*</span> ) Nombre(s) :</td>
          </tr>
        </table></td>
        <td><input type="text" name="txtNombres" id="txtNombres" style="width:300px; height:25px"  onKeyPress="return soloAlf(event)" placeholder="NOMBRE(S)" required="required"  onchange="return fileValidation();"/></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#F9F9F9"><table width="100%" height="26" border="1" cellpadding="0" cellspacing="0" bordercolor="#6699FF">
          <tr bordercolor="#FF9900" bordercolorlight="#FF9900">
            <td align="right" bordercolor="#6699FF"> ( <span class="ASTERISOC"><span class="ASTERISCO">*</span></span> ) Primer Apellido :</td>
          </tr>
        </table></td>
        <td><input type="text" name="txtPrimerApellido" id="txtPrimerApellido" style="width:300px; height:25px"  onKeyPress="return soloAlf(event)" placeholder="PRIMER APELLIDO" required="required" onchange="return fileValidation();"/></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#F9F9F9"><table width="100%" height="26" border="1" cellpadding="0" cellspacing="0" bordercolor="#6699FF">
          <tr bordercolor="#FF9900" bordercolorlight="#FF9900">
            <td align="right" bordercolor="#6699FF"> Segundo Apellido :</td>
          </tr>
        </table></td>
        <td><input type="text" name="txtSegundoApellido" id="txtSegundoApellido" style="width:300px; height:25px"  onKeyPress="return soloAlf(event)" placeholder="SEGUNDO APELLIDO"/></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#F9F9F9"><table width="100%" height="26" border="1" cellpadding="0" cellspacing="0" bordercolor="#6699FF">
          <tr bordercolor="#FF9900" bordercolorlight="#FF9900">
            <td align="right" bordercolor="#6699FF">Unidad :</td>
          </tr>
        </table></td>
        <td><select name="sltUnidad" id="sltUnidad">
          <option>DIRECCION DE ADMINISTRACION TRIBUTARIA MUNICIPAL</option>
          <option>DIRECCION DE FERIAS Y MERCADOS</option>
        </select></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#F9F9F9"><table width="100%" height="26" border="1" cellpadding="0" cellspacing="0" bordercolor="#6699FF">
          <tr bordercolor="#FF9900" bordercolorlight="#FF9900">
            <td align="right" bordercolor="#6699FF">Area :</td>
          </tr>
        </table></td>
        <td><select name="sltArea" id="sltArea">
          <option>FERIAS Y MERCADOS</option>
          <option selected="selected">OTROS INGRESOS</option>
        </select></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#F9F9F9"><table width="100%" height="26" border="1" cellpadding="0" cellspacing="0" bordercolor="#6699FF">
          <tr bordercolor="#FF9900" bordercolorlight="#FF9900">
            <td align="right" bordercolor="#6699FF">( <span class="ASTERISCO">*</span> ) Cargo  :</td>
          </tr>
        </table></td>
        <td><input type="text" name="txtCargo" id="txtCargo" onkeypress="return soloAlf(event)" style="width:300px; height:25px" onchange="return fileValidation();" placeholder="CARGO DEL OPERADOR" required/></td>
      </tr>
      <tr>
        <td align="right">&nbsp;</td>
        <td><input type="submit" name="button" id="button" value="Aceptar" style="width:150px; height:50px"/></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td class="TITULO" style="font-style: italic; font-weight: normal;"><span class="ASTERISCO">( * ) Son campos oligatorios</span></td>
  </tr>
  <tr>
    <td class="TITULO">&nbsp;</td>
  </tr>
  <tr>
    <td class="TITULO"><span class="ASTERISCO">Ver 0.</span></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body></form>
</html>