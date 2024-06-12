<?php require_once('../Control_Sesiones_Forms/frmControlSesionUsuario.php'); 
 require_once('../Control_Sesiones_Forms/Loading.php'); 
 require '../Conexion_BD/Dbms.php';

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel='StyleSheet' href='../Css_Formularios/frmProcesos.css' type="text/css">
<script src='Js/frmValida.js' type="text/javascript"></script>
</head>
<form method="post" action="frmSecretarioGeneral1.php">
<body>
<table width="10%" border="0">
  <tr>
    <td align="center" class="TITULO">&nbsp;</td>
    <td align="center" class="TITULO">&nbsp;</td>
    <td align="center" class="TITULO"><?php $result=mysql_query("select * from nombre_formularios where UBICACION='REGISTRO SECRETARIO GENERAL' and ESTADO='ACTIVO'"); while($row=mysql_fetch_array($result)){ echo $row['DESCRIPCION']; }?></td>
  </tr>
  <tr>
    <td align="center" class="SUBTITULO">&nbsp;</td>
    <td align="center" class="SUBTITULO">&nbsp;</td>
    <td align="center" class="SUBTITULO">REGISTRAR NUEVO SECRETARIO GENERAL</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
    <td align="left" style="font-weight: bold"><table width="10%" border="0" cellpadding="2" cellspacing="2" bordercolor="#FFFFFF">
      <?php $result=mysql_query("select * from reg_asociacion where CODIGO_ASOCIACION='$COD_ASOCIACION' and ESTADO='ACTIVO'"); while($row=mysql_fetch_array($result)){ ?>
      <tr>
        <td height="32" align="right" bgcolor="#CCCCCC">Ordenanza Municipal :</td>
        <td style="font-weight: bold"><?php echo utf8_decode($row['ORDENANZA_MUNICIPAL']);?></td>
      </tr>
      <tr>
        <td width="32%" height="32" align="right" bgcolor="#CCCCCC">Asociación Seleccionada :</td>
        <td width="68%" style="font-weight: bold"><?php echo utf8_decode($row['DESCRIPCION']);?></td>
      </tr>
      <tr>
        <td height="32" align="right" bgcolor="#CCCCCC">Zona Tributaria :</td>
        <td style="font-weight: bold"><?php $liqui=mysql_query("select ZT.DESCRIPCION from zona_tributaria ZT,reg_asociacion_zona_tributaria RAZT where RAZT.CODIGO_ASOCIACION='$COD_ASOCIACION' and RAZT.CODIGO_ZONA=ZT.CODIGO_ZONA and RAZT.ESTADO='ACTIVO' and ZT.ESTADO='ACTIVO'");while($rowt=mysql_fetch_array($liqui)){ echo $rowt[0];  } ?></td>
      </tr>
      <?php }?>
      <tr>
        <td height="32" align="right"><img src="../Img/Blanco.png" width="370" height="6" /></td>
        <td style="font-weight: bold"><img src="../Img/Blanco.png" width="500" height="6" /></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
    <td align="left" style="font-weight: bold">Datos de Nuevo Secretario General(<span class="comentario" style="font-style: italic; font-weight: normal;">Es Responsabilidad del operador el llenado de datos </span>). </td>
  </tr>
  <tr>
    <td align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
    <td align="left" valign="top" style="font-weight: bold"><hr /></td>
  </tr>
  <tr>
    <td align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
    <td align="left"><table width="20%" border="0" cellpadding="2" cellspacing="2" bordercolor="#FFFFFF" bordercolordark="#FFFFFF" bordercolorlight="#FFFFFF" b="b">
      <tr>
        <td align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span> Gestión :</td>
        <td style="font-weight: bold"><select name="sltGestionSeleccionado" id="sltGestionSeleccionado">
                    <option><?php echo date('Y')-1;?></option>
        </select></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC">Documento :</td>
        <td style="font-weight: bold"><select name="sltDocumento" id="sltDocumento" style="width:250px; height:20px">
          <?php $result=mysql_query("select * from parametros_sistema where UBICACION='DOCUMENTO' and ESTADO='ACTIVO' order by DESCRIPCION"); while($row=mysql_fetch_array($result)){ ?>
          <option><?php echo $row['DESCRIPCION'];?></option>
          <?PHP  } ?>
        </select></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span> Número de Cédula de Identidad :</td>
        <td style="font-weight: bold"><input name="txtNroCi" type="text" id="txtNroCi" style="width:150px; height:20px" onkeypress="return soloNumeros(event)" onkeyup="return fileValidation();" size="10" maxlength="10" placeholder="Nro. de C.I." required="required"/>
          -
          <input name="txtNroCiAl" type="text" id="txtNroCiAl" style="width:40px; height:20px" onchange="javascript:this.value=this.value.toUpperCase();" onkeypress="return soloLetrasNumeros(event)" size="10" maxlength="5" placeholder="ALFA" />
          <input name="REG" type="hidden" id="REG" value="1" /></td>
      </tr>
      <tr>
        <td  align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span> Expedido :</td>
        <td style="font-weight: bold"><select name="sltExpedido" id="sltExpedido" style="width:250px; height:20px">
          <?php $result=mysql_query("select * from parametros_sistema where UBICACION='EXPEDIDO' and ESTADO='ACTIVO' order by DESCRIPCION"); while($row=mysql_fetch_array($result)){ if($rowy['EXPEDIDO']==$row['DESCRIPCION']){ echo "<option selected> $row[DESCRIPCION]</option>";}else{?>
          <option><?php echo $row['DESCRIPCION'];?></option>
          <?PHP } } ?>
        </select></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span> Nombre(s) :</td>
        <td style="font-weight: bold"><input name="txtNombres" type="text" id="txtNombres"  style="width:250px; height:20px" onchange="javascript:this.value=this.value.toUpperCase();" onkeypress="return soloLetras(event)" onkeyup="return fileValidation()" maxlength="100" placeholder="NOMBRE(S)" required="required"/></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span> Primer Apellido :</td>
        <td style="font-weight: bold"><input name="txtPapellido" type="text" id="txtPapellido"  style="width:250px; height:20px" onchange="javascript:this.value=this.value.toUpperCase();"  onkeypress="return soloLetras(event)" onkeyup="return fileValidation()" maxlength="100" placeholder="PRIMER APELLIDO" required="required"/></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC">Segundo Apellido :</td>
        <td style="font-weight: bold"><input name="txtSapellido" type="text" id="txtSapellido"  style="width:250px; height:20px" onchange="javascript:this.value=this.value.toUpperCase();"  onkeypress="return soloLetras(event)" maxlength="100" placeholder="SEGUNDO APELLIDO"/></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC">Teléfono :</td>
        <td style="font-weight: bold"><input name="txtTelefono" type="text" id="txtTelefono"  style="width:250px; height:20px" onchange="javascript:this.value=this.value.toUpperCase();"  onkeypress="return soloNumeroSigno(event)" maxlength="70" placeholder="TELEFONOS"/></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span> Celular :</td>
        <td style="font-weight: bold"><input name="txtCelular" type="text" id="txtCelular"  style="width:250px; height:20px" onchange="javascript:this.value=this.value.toUpperCase();"  onkeypress="return soloNumeroSigno(event)" maxlength="70" placeholder="CELULAR" onkeyup="return fileValidation()" required="required"/></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC">Correo Electrónico :</td>
        <td style="font-weight: bold"><input name="txtEmail" type="text" id="txtEmail"  style="width:250px; height:20px" onchange="javascript:this.value=this.value.toLowerCase();"  onkeypress="return correoElectronico(event)" maxlength="400" placeholder="CORREO ELECTRONICO"/></td>
      </tr>
      <tr>
        <td align="right"><img src="../Img/Blanco.png" width="370" height="6" /></td>
        <td style="font-weight: bold"><input type="submit" name="button" id="button" value="Aceptar" style="width:150px; height:35px" /></td>
      </tr>
            <tr>
        <td  align="right">&nbsp;</td>
        <td style="font-weight: bold">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="center"><a href="frmSecretarioGeneral1.php">Volver</a>      </div></td>
  </tr>
  <tr>
    <td class="ASTERISCO">&nbsp;</td>
    <td class="ASTERISCO">&nbsp;</td>
    <td class="ASTERISCO">* <span style="font-weight: normal; font-style: italic;">Son campos obligatorios.</span></td>
  </tr>
  <tr>
    <td class="ASTERISCO">&nbsp;</td>
    <td class="ASTERISCO">&nbsp;</td>
    <td class="ASTERISCO">&nbsp;</td>
  </tr>
  <tr>
    <td class="ASTERISCO">&nbsp;</td>
    <td class="ASTERISCO">&nbsp;</td>
    <td class="ASTERISCO">VER. 2</td>
  </tr>
</table>
</body></form>
</html>