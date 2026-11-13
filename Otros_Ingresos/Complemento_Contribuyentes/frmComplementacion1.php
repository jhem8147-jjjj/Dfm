<?php  require_once('../Control_Sesiones_Forms/frmControlSesionUsuario.php');
header('Content-Type: text/html; charset=utf-8');
require '../Conexion_BD/Dbms.php';
function complementacion1PostValue($name)
{
    return isset($_POST[$name]) && is_scalar($_POST[$name])
        ? (string)$_POST[$name]
        : '';
}
$OMS = isset($_SESSION['OMS']) ? $_SESSION['OMS'] : '';
$COD_ASOCIACION = isset($_SESSION['COD_ASOCIACION']) ? $_SESSION['COD_ASOCIACION'] : '';
$ASOCIACION = isset($_SESSION['ASOCIACION']) ? $_SESSION['ASOCIACION'] : '';
$CODIGO_ZONA_TRIB = isset($_SESSION['CODIGO_ZONA_TRIB']) ? $_SESSION['CODIGO_ZONA_TRIB'] : '';
$sltGestion = complementacion1PostValue('sltGestion');
$txtCodigoRegistro = complementacion1PostValue('txtCodigoRegistro');
$txtDocumento = complementacion1PostValue('txtDocumento');
$txtFecha = complementacion1PostValue('txtFecha');
$txtObservaciones = complementacion1PostValue('txtObservaciones');
if ($OMS === '' || $COD_ASOCIACION === '' || $CODIGO_ZONA_TRIB === '') {
    include_once("Index.php");
    exit;
}
$cont=0;
$COD_REGISTRO = isset($_SESSION['COD_REGISTRO']) ? $_SESSION['COD_REGISTRO'] : date('Ymd His').rand(1,10);
$_SESSION['COD_REGISTRO']=$COD_REGISTRO;
$_SESSION['CODIGO_ZONA_TRIB']=$CODIGO_ZONA_TRIB;
if ($txtCodigoRegistro !== '') { $_SESSION['txtCodigoRegistro'] = $txtCodigoRegistro; }
if ($txtDocumento !== '') { $_SESSION['txtDocumento'] = $txtDocumento; }
if ($txtFecha !== '') { $_SESSION['txtFecha'] = $txtFecha; }
if ($txtObservaciones !== '') { $_SESSION['txtObservaciones'] = $txtObservaciones; }
if ($sltGestion !== '') { $_SESSION['sltGestion'] = $sltGestion; }
?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel='StyleSheet' href='../Css_Formularios/frmProcesos.css' type="text/css">
<script src='Js/frmValida.js' type="text/javascript"></script>
</head>

<body>
<table width="10%" border="0" align="left">
  <tr>
    <td align="center" class="TITULO">COMPLEMENTACION</td>
  </tr>
  <tr>
    <td align="center" class="SUBTITULO">DOCUMENTACION</td>
  </tr>
  <tr>
    <td><span style="font-weight: bold">DATOS DE ASOCIACION.</span></td>
  </tr>
  <tr>
    <td style="font-weight: bold"><img src="../Img/Linea_Negra.png" width="628" height="2" /></td>
  </tr>
  <tr>
    <td><form method="post" accept-charset="UTF-8" action="frmComplementacion2.php"><table width="100%" border="0" cellpadding="1" cellspacing="1" bordercolor="#FFFFFF">
      <tr>
        <td height="32" align="right" bgcolor="#CCCCCC">Documento de Registro :</td>
        <td style="font-weight: bold"><?php echo htmlspecialchars($OMS, ENT_QUOTES, 'UTF-8');?></td>
      </tr>
      <tr>
        <td width="28%" height="32" align="right" bgcolor="#CCCCCC">Asociación seleccionada :</td>
        <td width="72%" style="font-weight: bold"><?php echo htmlspecialchars($ASOCIACION, ENT_QUOTES, 'UTF-8');?>
          <input name="COD_ASOCIACION" type="hidden" id="COD_ASOCIACION" value="<?php echo htmlspecialchars($COD_ASOCIACION, ENT_QUOTES, 'UTF-8');?>" />
          <input name="ASOCIACION" type="hidden" id="ASOCIACION" value="<?php echo htmlspecialchars($ASOCIACION, ENT_QUOTES, 'UTF-8');?>" />
          <input name="REG" type="hidden" id="REG" value="1" /></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC">Zona Tributaria :</td>
        <td style="font-weight: bold; font-size: 14px;"><span style="font-weight: bold">
          <?php $liqui=mysql_query("select ZT.DESCRIPCION,ZT.CODIGO_ZONA from zona_tributaria ZT,reg_asociacion_zona_tributaria RAZT where RAZT.CODIGO_ASOCIACION='".mysql_real_escape_string($COD_ASOCIACION)."' and RAZT.CODIGO_ZONA=ZT.CODIGO_ZONA and RAZT.ESTADO='ACTIVO' and ZT.ESTADO='ACTIVO'");while($rowt=mysql_fetch_array($liqui)){ echo htmlspecialchars($rowt[0], ENT_QUOTES, 'UTF-8'); $ZONA_TRIB=$rowt[0]; $CODIGO_ZONA_TRIB=$rowt[1];} ?>
        </span></td>
      </tr>
      <tr>
        <td colspan="2" align="left" style="font-weight: bold">DATOS DE LA SOLICITUD.</td>
      </tr>
      <tr>
        <td colspan="2" align="left"><hr /></td>
        </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span> Gestión</td>
        <td style="font-weight: bold; font-size: 14px;"><select name="sltGestion" id="sltGestion">
          <option><?php echo date('Y')-1;?></option>
        </select></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span> Documento :</td>
        <td style="font-weight: bold; font-size: 14px;"><input name="txtDocumento" type="text" id="txtDocumento" onchange="javascript:this.value=this.value.toUpperCase();" onkeyup="return fileValidation();" placeholder="Nro. de DOCUMENTO" required/>
          <input name="txtCodigoRegistro" type="hidden" id="txtCodigoRegistro" value="<?php echo date('Ymd His').rand(100,1000);?>" /></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span> Fecha Documento :</td>
        <td style="font-weight: bold; font-size: 14px;"><input type="date" name="txtFecha" step="1" id="txtFecha" max="<?php echo date('Y-m-d');?>" value="<?php echo date("Y-m-d");?>" onkeyup="return fileValidation();" required/></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC">Observaciones :</td>
        <td style="font-weight: bold; font-size: 14px;"><textarea name="txtObservaciones" id="txtObservaciones" onchange="javascript:this.value=this.value.toUpperCase();" cols="45" rows="5">SIN OBSERVACION.</textarea></td>
      </tr>
      <tr>
        <td align="right">&nbsp;</td>
        <td style="font-weight: bold; font-size: 14px;"><input type="submit" name="button" id="button" value="Aceptar" style="width:200px; height:35px" /></td>
      </tr>
      <tr>
        <td align="right">&nbsp;</td>
        <td class="ASTERISCO" style="font-size: 10px; font-weight: bold; font-style: italic;">ES RESPONSABILIDAD DEL OPERADOR EL LLENADO DE DATOS</td>
      </tr>
    </table>
    </form></td>
  </tr>
  <tr>
    <td align="center"><a href="frmComplementacion.php">Volver</a></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="ASTERISCO">VER. 2</td>
  </tr>
</table>
</body>
</html><?php require '../Conexion_BD/Cerrar_Dbms.php';?>