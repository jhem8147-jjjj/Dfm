<?php require_once('../Control_Sesiones_Forms/frmControlSesionUsuario.php');
header('Content-Type: text/html; charset=utf-8');
require '../Conexion_BD/Dbms.php';
function complementoActividadValue($name, $includeGet = false)
{
    $sources = $includeGet ? array($_POST, $_GET) : array($_POST);
    foreach ($sources as $source) {
        if (isset($source[$name]) && is_scalar($source[$name])) {
            return (string)$source[$name];
        }
    }
    return '';
}
$AGREGARP = complementoActividadValue('AGREGARP');
$IDS = complementoActividadValue('IDS', true);
$CODIGO_CONTRIBUYENTE = complementoActividadValue('CODIGO_CONTRIBUYENTE', true);
$sltPuesto = complementoActividadValue('sltPuesto');
$txtFila = trim(complementoActividadValue('txtFila'));
$txtPuesto = trim(complementoActividadValue('txtPuesto'));
$txtCodigoRegistro = complementoActividadValue('txtCodigoRegistro');
$txtDocumento = complementoActividadValue('txtDocumento');
$txtFecha = complementoActividadValue('txtFecha');
$txtObservaciones = complementoActividadValue('txtObservaciones');
$sltGestion = complementoActividadValue('sltGestion');

if ($txtCodigoRegistro === '' && isset($_SESSION['txtCodigoRegistro'])) {
    $txtCodigoRegistro = $_SESSION['txtCodigoRegistro'];
}

if ($txtDocumento === '' && isset($_SESSION['txtDocumento'])) {
    $txtDocumento = $_SESSION['txtDocumento'];
}

if ($txtFecha === '' && isset($_SESSION['txtFecha'])) {
    $txtFecha = $_SESSION['txtFecha'];
}

if ($txtObservaciones === '' && isset($_SESSION['txtObservaciones'])) {
    $txtObservaciones = $_SESSION['txtObservaciones'];
}

if ($sltGestion === '' && isset($_SESSION['sltGestion'])) {
    $sltGestion = $_SESSION['sltGestion'];
}

if ($IDS === '' || $CODIGO_CONTRIBUYENTE === '') {
    die("FALTAN LOS DATOS DE IDENTIFICACION DEL CONTRIBUYENTE. VUELVA A LA LISTA E INTENTE NUEVAMENTE.");
}

$IDS_SQL = mysql_real_escape_string($IDS);
$CODIGO_CONTRIBUYENTE_SQL = mysql_real_escape_string($CODIGO_CONTRIBUYENTE);
$contribuyenteQuery = mysql_query("select C.DOC_IDENTIDAD,C.DOC_IDENTIDAD_ALFA,C.EXPEDIDO,C.NOMBRE_RSOCIAL,C.PRIMER_APELLIDO,C.SEGUNDO_APELLIDO,C.APELLIDO_ESPOSO,RCHPC.CODIGO_REGISTRO AS RCHPC_CODIGO_REGISTRO,RCHPC.CODIGO_ASOCIACION AS RCHPC_CODIGO_ASOCIACION,RCHPC.CODIGO_ZONA AS RCHPC_CODIGO_ZONA,RCHPC.DOCUMENTO AS RCHPC_DOCUMENTO,RCHPC.FECHA_DOCUMENTO AS RCHPC_FECHA_DOCUMENTO,RCHPC.OBSERVACIONES_REGISTRO AS RCHPC_OBSERVACIONES,RCHPC.GESTION AS RCHPC_GESTION from reg_contribuyente_habilitado_pago_complementacion RCHPC, contribuyentes C where RCHPC.ID='$IDS_SQL' and RCHPC.ESTADO='ACTIVO' and RCHPC.CODIGO_CONTRIBUYENTE='$CODIGO_CONTRIBUYENTE_SQL' and C.CODIGO_CONTRIBUYENTE=RCHPC.CODIGO_CONTRIBUYENTE and C.ESTADO='ACTIVO'") or die("NO SE PUDO CONSULTAR EL CONTRIBUYENTE DE LA COMPLEMENTACION.");
$contribuyente = mysql_fetch_array($contribuyenteQuery);
if (!$contribuyente) {
    die("EL CONTRIBUYENTE YA NO PERTENECE A ESTA COMPLEMENTACION.");
}

$txtCodigoRegistro = trim((string)$contribuyente['RCHPC_CODIGO_REGISTRO']);
$COD_ASOCIACION = trim((string)$contribuyente['RCHPC_CODIGO_ASOCIACION']);
$CODIGO_ZONA_TRIB = trim((string)$contribuyente['RCHPC_CODIGO_ZONA']);
$txtDocumento = (string)$contribuyente['RCHPC_DOCUMENTO'];
$txtFecha = (string)$contribuyente['RCHPC_FECHA_DOCUMENTO'];
$txtObservaciones = (string)$contribuyente['RCHPC_OBSERVACIONES'];
$sltGestion = (string)$contribuyente['RCHPC_GESTION'];
$ASOCIACION = isset($_SESSION['ASOCIACION']) && $_SESSION['ASOCIACION'] !== ''
    ? $_SESSION['ASOCIACION'] : $COD_ASOCIACION;
$ASOCIACION_SQL = mysql_real_escape_string($ASOCIACION);
$txtCodigoRegistro_SQL = mysql_real_escape_string($txtCodigoRegistro);
$COD_ASOCIACION_SQL = mysql_real_escape_string($COD_ASOCIACION);

$_SESSION['txtCodigoRegistro'] = $txtCodigoRegistro;
$_SESSION['txtDocumento'] = $txtDocumento;
$_SESSION['txtFecha'] = $txtFecha;
$_SESSION['txtObservaciones'] = $txtObservaciones;
$_SESSION['sltGestion'] = $sltGestion;
$_SESSION['CODIGO_ZONA_TRIB'] = $CODIGO_ZONA_TRIB;
$_SESSION['COD_ASOCIACION'] = $COD_ASOCIACION;
$_SESSION['ASOCIACION'] = $ASOCIACION;

if($AGREGARP==1){
if (!in_array($sltPuesto, array('PUESTO DE VENTA', 'KIOSCO', 'CARRITO'), true) || $txtFila === '' || $txtPuesto === '') {
    die("COMPLETE EL TIPO DE ACTIVIDAD, LA FILA Y EL PUESTO PARA REGISTRAR LA ACTIVIDAD.");
}
$sltPuesto_SQL = mysql_real_escape_string($sltPuesto);
$txtFila_SQL = mysql_real_escape_string($txtFila);
$txtPuesto_SQL = mysql_real_escape_string($txtPuesto);
$NOMBRE_USUARIO_SQL = mysql_real_escape_string("$SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO");
$US_SIOI_SQL = mysql_real_escape_string($US_SIOI);
$actividad = mysql_real_escape_string("COMPLEMENTACION DE CONTRIBUYENTE ACTUALIZACION DE PUESTO DE VENTA $sltPuesto, FILA $txtFila, PUESTO $txtPuesto");
$query = mysql_query("UPDATE reg_contribuyente_habilitado_pago_complementacion SET TIPO_VENTA='$sltPuesto_SQL',FILA='$txtFila_SQL',PUESTO='$txtPuesto_SQL' where ID='$IDS_SQL' and CODIGO_CONTRIBUYENTE='$CODIGO_CONTRIBUYENTE_SQL' and CODIGO_REGISTRO='$txtCodigoRegistro_SQL' and CODIGO_ASOCIACION='$COD_ASOCIACION_SQL' and ESTADO='ACTIVO'")or die ("NO SE PUDO ACTUALIZAR LOS DATOS DE LA MODIFICACION DE reg_contribuyente_habilitado_pago_complementacion.");
$sql1="insert into reg_contribuyente_transacciones(PC_NAME,PC_IP,USUARIO,NOMBRE_USUARIO,FECHA,HORA,CODIGO_REGISTRO,CODIGO_ASOCIACION,ASOCIACION,TRANSACCION_1,DESCRIPCION_TRAMITE,OBSERVACIONES,ENLACE)values('$hostname','$hostlocal','$US_SIOI_SQL','$NOMBRE_USUARIO_SQL','$FECHA','$HORA','$txtCodigoRegistro_SQL','$COD_ASOCIACION_SQL','$ASOCIACION_SQL','COMPLEMENTACION DE CONTRIBUYENTE','$actividad','$actividad','0')";$result=mysql_query($sql1)or die ("NO SE PUDO REGISTRAR EN LA ENTIDAD reg_contribuyente_transacciones."); 
$_SESSION['complementacionMensaje'] = 'Se actualizaron los datos de actividad del contribuyente.';
header('Location: frmComplementacion2.php?txtCodigoRegistro=' . urlencode($txtCodigoRegistro) .
    '&txtDocumento=' . urlencode($txtDocumento) .
    '&txtFecha=' . urlencode($txtFecha) .
    '&txtObservaciones=' . urlencode($txtObservaciones) .
    '&sltGestion=' . urlencode($sltGestion));
exit;
	}
?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel='StyleSheet' href='../Css_Formularios/frmProcesos.css' type="text/css">
<script src='Js/frmValida.js' type="text/javascript"></script>
</head>
<body>

<table width="50%" border="0">
  <tr>
    <td align="center" class="TITULO">COMPLEMENTO</td>
  </tr>
  <tr>
    <td align="center" class="SUBTITULO">AGREGAR DATOS PUESTO DE VENTA</td>
  </tr>
  <tr>
    <td><img src="../Img/Blanco.png" width="600" height="6" /></td>
  </tr>
  <tr>
    <td align="left"><form method="post" accept-charset="UTF-8" action="frmComplementacionAgregarAct.php">
      <input type="hidden" name="txtCodigoRegistro" value="<?php echo htmlspecialchars($txtCodigoRegistro, ENT_QUOTES, 'UTF-8'); ?>" />
      <input type="hidden" name="txtDocumento" value="<?php echo htmlspecialchars($txtDocumento, ENT_QUOTES, 'UTF-8'); ?>" />
      <input type="hidden" name="txtFecha" value="<?php echo htmlspecialchars($txtFecha, ENT_QUOTES, 'UTF-8'); ?>" />
      <input type="hidden" name="txtObservaciones" value="<?php echo htmlspecialchars($txtObservaciones, ENT_QUOTES, 'UTF-8'); ?>" />
      <input type="hidden" name="sltGestion" value="<?php echo htmlspecialchars($sltGestion, ENT_QUOTES, 'UTF-8'); ?>" />
      <table width="20%" border="0">
      <tr>
        <td colspan="2"  align="left" style="font-weight: bold">DATOS CONTRIBUYENTE.</td>
      </tr>
      <tr>
        <td colspan="2"  align="left"><hr /></td>
      </tr><?php $row = $contribuyente; ?>
      <tr>
        <td  align="right" bgcolor="#CCCCCC">Documento de Identificacion :</td>
        <td style="font-weight: bold"><?php if($row['1']== null){echo $row['0'];}else{echo $row['0'].' - '.$row['1']
		; }?></td>
      </tr>
      <tr>
        <td  align="right" bgcolor="#CCCCCC">Expedido :</td>
        <td style="font-weight: bold"><?php echo $row[2];?></td>
      </tr>
      <tr>
        <td  align="right" bgcolor="#CCCCCC">Nombre(s) y Apellido(s) :</td>
        <td style="font-weight: bold"><?php if($row['6']== null){echo $row['3'].' '.$row['4'].' '.$row['5'];}else{echo $row['3'].' '.$row['4'].' '.$row['5'].' de '.$row['6'];}?></td>
      </tr>
      <tr>
        <td colspan="2"  align="left" style="font-weight: bold">DATOS ACTIVIDAD ECONOMICA.</td>
      </tr>
      <tr>
        <td colspan="2"  align="left"><hr /></td>
        </tr>
      <tr>
        <td  align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span> TIPO DE ACTIVIDAD ECONOMICA :</td>
        <td style="font-weight: bold"><select name="sltPuesto" id="sltPuesto">
          <option selected="selected">PUESTO DE VENTA</option>
          <option>KIOSCO</option>
          <option>CARRITO</option>
        </select>
          <input name="AGREGARP" type="hidden" id="AGREGARP" value="1" />
          <input name="IDS" type="hidden" id="IDS" value="<?php echo htmlspecialchars($IDS, ENT_QUOTES, 'UTF-8');?>" />
          <input name="CODIGO_CONTRIBUYENTE" type="hidden" id="CODIGO_CONTRIBUYENTE" value="<?php echo htmlspecialchars($CODIGO_CONTRIBUYENTE, ENT_QUOTES, 'UTF-8');?>" /></td>
      </tr>
      <tr>
        <td  align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span> FILA :</td>
        <td style="font-weight: bold"><input name="txtFila" type="text" id="txtFila" style="width:200px; height:20px" size="10" placeholder="FILA" required="required" /></td>
      </tr>
      <tr>
        <td  align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span> PUESTO:</td>
        <td style="font-weight: bold"><input name="txtPuesto" type="text" id="txtPuesto" style="width:200px; height:20px" size="10" placeholder="PUESTO" required="required" /></td>
      </tr>
      <tr>
        <td width="46%"  align="right" bgcolor="#CCCCCC">&nbsp;</td>
        <td width="54%" style="font-weight: bold"><input type="submit" name="button" id="button" value="Aceptar" style="width:200px; height:35px" /></td>
      </tr>
      <tr>
        <td colspan="2"  align="right"></td>
      </tr>
      <tr>
        <td colspan="2"  align="right"><img src="../Img/Blanco.png" width="661" height="6" /></td>
      </tr>
      </table>
    </form></td>
  </tr>
  <tr>
    <td align="center">
<form method="post" accept-charset="UTF-8" action="frmComplementacion2.php">
    <input type="hidden" name="txtCodigoRegistro"
           value="<?php echo htmlspecialchars($txtCodigoRegistro, ENT_QUOTES, 'UTF-8'); ?>" />

    <input type="hidden" name="txtDocumento"
           value="<?php echo htmlspecialchars($txtDocumento, ENT_QUOTES, 'UTF-8'); ?>" />

    <input type="hidden" name="txtFecha"
           value="<?php echo htmlspecialchars($txtFecha, ENT_QUOTES, 'UTF-8'); ?>" />

    <input type="hidden" name="txtObservaciones"
           value="<?php echo htmlspecialchars($txtObservaciones, ENT_QUOTES, 'UTF-8'); ?>" />

    <input type="hidden" name="sltGestion"
           value="<?php echo htmlspecialchars($sltGestion, ENT_QUOTES, 'UTF-8'); ?>" />

    <input type="submit" value="Volver" />
</form>
</td>
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