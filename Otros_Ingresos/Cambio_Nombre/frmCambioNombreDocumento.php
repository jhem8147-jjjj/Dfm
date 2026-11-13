<?php require_once('../Control_Sesiones_Forms/frmControlSesionUsuario.php');
header('Content-Type: text/html; charset=utf-8');
require '../Conexion_BD/Dbms.php';
$COD_REGISTRO = isset($_SESSION['COD_REGISTRO']) ? $_SESSION['COD_REGISTRO'] : '';
$COD_ASOCIACION = isset($_SESSION['COD_ASOCIACION']) ? $_SESSION['COD_ASOCIACION'] : '';
$ASOCIACION = isset($_SESSION['ASOCIACION']) ? $_SESSION['ASOCIACION'] : '';
$OMS = isset($_SESSION['OMS']) ? $_SESSION['OMS'] : '';
if ($COD_ASOCIACION === '' || $ASOCIACION === '' || $OMS === '') {
    header('Location: frmCambioNombre.php');
    exit;
}
if ($COD_REGISTRO === '') {
    $COD_REGISTRO = date('Ymd His').rand(1, 10);
    $_SESSION['COD_REGISTRO'] = $COD_REGISTRO;
}
$COD_ASOCIACION_SQL = mysql_real_escape_string($COD_ASOCIACION);
$zonas = array();
$liqui = mysql_query("select ZT.DESCRIPCION,ZT.CODIGO_ZONA from zona_tributaria ZT,reg_asociacion_zona_tributaria RAZT where RAZT.CODIGO_ASOCIACION='$COD_ASOCIACION_SQL' and RAZT.CODIGO_ZONA=ZT.CODIGO_ZONA and RAZT.ESTADO='ACTIVO' and ZT.ESTADO='ACTIVO'") or die("NO SE PUDO CONSULTAR LA ZONA TRIBUTARIA DE LA ASOCIACION.");
while ($rowt = mysql_fetch_array($liqui)) {
    $zonas[] = $rowt['DESCRIPCION'];
    $_SESSION['CODIGO_ZONA_TRIB'] = $rowt['CODIGO_ZONA'];
}
require_once('../Control_Sesiones_Forms/Loading.php');
$gestionDocumento = date('Y') - 1;
$cont=0;

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel='StyleSheet' href='../Css_Formularios/frmProcesos.css' type="text/css">
<script src='Js/frmValida.js' type="text/javascript"></script>
</head>

<body>
<table width="10%" border="0" align="left">
  <tr>
    <td align="center" class="TITULO">CAMBIO DE NOMBRE</td>
  </tr>
  <tr>
    <td align="center" class="SUBTITULO">Registro Documentos</td>
  </tr>
  <tr>
    <td><span style="font-weight: bold">DATOS DE DOCUMENTO.</span></td>
  </tr>
  <tr>
    <td style="font-weight: bold"><img src="../Img/Linea.png" width="700" height="4" /></td>
  </tr>
  <tr>
    <td><form method="post" accept-charset="UTF-8" action="frmCambioNombre1.php"><table width="100%" border="0" cellpadding="1" cellspacing="1" bordercolor="#FFFFFF">
      <tr>
        <td height="32" align="right" bgcolor="#CCCCCC">Documento de Registro :</td>
        <td style="font-weight: bold"><?php echo htmlspecialchars(str_replace("Â°", "°", $OMS), ENT_QUOTES, 'UTF-8');?></td>
      </tr>
      <tr>
        <td width="28%" height="32" align="right" bgcolor="#CCCCCC">Asociación Seleccionada :</td>
        <td width="72%" style="font-weight: bold"><?php echo htmlspecialchars($ASOCIACION, ENT_QUOTES, 'UTF-8');?>
          <input name="COD_ASOCIACION" type="hidden" id="COD_ASOCIACION" value="<?php echo htmlspecialchars($COD_ASOCIACION, ENT_QUOTES, 'UTF-8');?>" />
          <input name="ASOCIACION" type="hidden" id="ASOCIACION" value="<?php echo htmlspecialchars($ASOCIACION, ENT_QUOTES, 'UTF-8');?>" />
          <input name="REG" type="hidden" id="REG" value="1" /></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC">Zona Tributaria :</td>
        <td style="font-weight: bold; font-size: 14px;"><span style="font-weight: bold">
          <?php echo htmlspecialchars(implode(', ', $zonas), ENT_QUOTES, 'UTF-8'); ?>
        </span></td>
      </tr>
      <tr>
        <td colspan="2" align="left" style="font-weight: bold">DATOS SOLICITUD.</td>
      </tr>
      <tr>
        <td colspan="2" align="left"><hr /></td>
        </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span> Gestión :</td>
        <td style="font-weight: bold; font-size: 14px;"><select id="gestionDocumento" disabled="disabled">
          <option><?php echo $gestionDocumento;?></option>
        </select>
          <input type="hidden" name="sltGestion" value="<?php echo $gestionDocumento;?>" />
          <span style="font-size: 12px; font-weight: normal">Se asigna automáticamente al año anterior; no es necesario elegirla.</span></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span> Documento :</td>
        <td style="font-weight: bold; font-size: 14px;"><input name="txtDocumento" type="text" id="txtDocumento" onchange="javascript:this.value=this.value.toUpperCase();" placeholder="Nro. de DOCUMENTO" onkeyup="return fileValidation();" required/>
          <input name="txtCodigoRegistro" type="hidden" id="txtCodigoRegistro" value="<?php echo date('Ymd His').rand(100,1000);?>" /></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span> Fecha Documento :</td>
        <td style="font-weight: bold; font-size: 14px;"><input type="date" name="txtFecha" step="1" id="txtFecha" max="<?php echo date('Y-m-d');?>" value="<?php echo date("Y-m-d");?>" onkeyup="return fileValidation();" required/></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC">Observaciones :</td>
        <td style="font-weight: bold; font-size: 14px;"><textarea name="txtObservaciones" id="txtObservaciones" onchange="javascript:this.value=this.value.toUpperCase();" cols="45" rows="5">NINGUNA OBSERVACION.</textarea></td>
      </tr>
      <tr>
        <td align="right">&nbsp;</td>
        <td style="font-weight: bold; font-size: 14px;"><input type="submit" name="button" id="button" value="Aceptar" style="width:200px; height:35px" /></td>
      </tr>
      <tr>
        <td align="right">&nbsp;</td>
        <td class="ASTERISCO" style="font-size: 14px; font-style: italic;">Es responsabilidad del Operador el llenado de los datos.</td>
      </tr>
    </table>
    </form></td>
  </tr>
  <tr>
    <td align="center"><a href="frmCambioNombre.php">Volver</a></td>
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