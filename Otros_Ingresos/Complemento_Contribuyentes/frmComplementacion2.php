<?php require_once('../Control_Sesiones_Forms/frmControlSesionUsuario.php');
header('Content-Type: text/html; charset=utf-8');
require '../Conexion_BD/Dbms.php';
function complementacion2RequestValue($name, $includeGet)
{
    $sources = $includeGet ? array($_POST, $_GET) : array($_POST);
    foreach ($sources as $source) {
        if (isset($source[$name]) && is_scalar($source[$name])) {
            return (string)$source[$name];
        }
    }
    return '';
}
function complementacion2SessionValue($name)
{
    $value = complementacion2RequestValue($name, true);
    if ($value === '' && isset($_SESSION[$name]) && is_scalar($_SESSION[$name])) {
        $value = (string)$_SESSION[$name];
    }
    return $value;
}
$REG = complementacion2RequestValue('REG', false);
$REGISTRAR = complementacion2RequestValue('REGISTRAR', true);
$ELIMINAR = complementacion2RequestValue('ELIMINAR', true);
$CODIGO_CONTRIBUYENTE = complementacion2RequestValue('CODIGO_CONTRIBUYENTE', true);
$IDS = complementacion2RequestValue('IDS', true);
$COD_REGISTRO = complementacion2SessionValue('COD_REGISTRO');
$CODIGO_ZONA_TRIB = complementacion2SessionValue('CODIGO_ZONA_TRIB');
$COD_ASOCIACION = complementacion2SessionValue('COD_ASOCIACION');
$ASOCIACION = complementacion2SessionValue('ASOCIACION');
$OMS = complementacion2SessionValue('OMS');
$txtCodigoRegistro = complementacion2RequestValue('txtCodigoRegistro', true);
$txtDocumento = complementacion2RequestValue('txtDocumento', true);
$txtFecha = complementacion2RequestValue('txtFecha', true);
$txtObservaciones = complementacion2RequestValue('txtObservaciones', true);
$sltGestion = complementacion2RequestValue('sltGestion', true);
$mensaje = isset($_SESSION['complementacionMensaje']) ? $_SESSION['complementacionMensaje'] : '';
unset($_SESSION['complementacionMensaje']);
if ($txtCodigoRegistro === '' && isset($_SESSION['txtCodigoRegistro'])) { $txtCodigoRegistro = $_SESSION['txtCodigoRegistro']; }
if ($txtDocumento === '' && isset($_SESSION['txtDocumento'])) { $txtDocumento = $_SESSION['txtDocumento']; }
if ($txtFecha === '' && isset($_SESSION['txtFecha'])) { $txtFecha = $_SESSION['txtFecha']; }
if ($txtObservaciones === '' && isset($_SESSION['txtObservaciones'])) { $txtObservaciones = $_SESSION['txtObservaciones']; }
if ($sltGestion === '' && isset($_SESSION['sltGestion'])) { $sltGestion = $_SESSION['sltGestion']; }
$contextoSesion = array(
    'COD_REGISTRO' => $COD_REGISTRO,
    'CODIGO_ZONA_TRIB' => $CODIGO_ZONA_TRIB,
    'COD_ASOCIACION' => $COD_ASOCIACION,
    'ASOCIACION' => $ASOCIACION,
    'OMS' => $OMS,
    'txtCodigoRegistro' => $txtCodigoRegistro,
    'txtDocumento' => $txtDocumento,
    'txtFecha' => $txtFecha,
    'txtObservaciones' => $txtObservaciones,
    'sltGestion' => $sltGestion
);
foreach ($contextoSesion as $nombreContexto => $valorContexto) {
    if (trim((string)$valorContexto) !== '') {
        $_SESSION[$nombreContexto] = $valorContexto;
    }
}
$datosObligatorios = array(
    'CODIGO_ZONA_TRIB' => $CODIGO_ZONA_TRIB,
    'COD_ASOCIACION' => $COD_ASOCIACION,
    'ASOCIACION' => $ASOCIACION,
    'txtCodigoRegistro' => $txtCodigoRegistro,
    'txtDocumento' => $txtDocumento,
    'txtFecha' => $txtFecha,
    'sltGestion' => $sltGestion
);
$datosFaltantes = array();
foreach ($datosObligatorios as $nombreDato => $valorDato) {
    if (trim((string)$valorDato) === '') {
        $datosFaltantes[] = $nombreDato;
    }
}
if ($REGISTRAR == '1' && count($datosFaltantes) > 0) {
    echo 'NO SE PUEDE ASOCIAR EL CONTRIBUYENTE: FALTAN DATOS DEL TRAMITE (' .
        htmlspecialchars(implode(', ', $datosFaltantes), ENT_QUOTES, 'UTF-8') .
        '). VUELVA A LA BUSQUEDA E INTENTE NUEVAMENTE.';
    exit;
}
if (count($datosFaltantes) > 0 && $mensaje === '') {
    $mensaje = 'NO SE PUDO RECUPERAR EL CONTEXTO DE LA SOLICITUD (' .
        implode(', ', $datosFaltantes) .
        '). NO SE REGISTRO NINGUN CONTRIBUYENTE; VUELVA A LA SOLICITUD E INTENTE NUEVAMENTE.';
}
$SW11 = 0;
$CODIGO_CONTRIBUYENTE_SQL = mysql_real_escape_string($CODIGO_CONTRIBUYENTE);

if($REGISTRAR==1){
//BUSCA EL REGISTRO DEL CONTRIBUYENTE
$SWCONT=0;
$rest=mysql_query("select * from contribuyentes where CODIGO_CONTRIBUYENTE='$CODIGO_CONTRIBUYENTE_SQL' and ESTADO='ACTIVO' ");while($rot=mysql_fetch_array($rest)){$SWCONT=1;}
if($SWCONT==1){
$res=mysql_query("select NRO_PUESTO from nros_correlativos limit 1") or die("NO SE PUDO CONSULTAR EL CORRELATIVO DE PUESTOS.");
$ro=mysql_fetch_array($res);
if (!$ro) { die("NO EXISTE UN CORRELATIVO EN nros_correlativos."); }
$NUMERO_GREMIAL=(int)$ro['NRO_PUESTO']+1;
$query = mysql_query("UPDATE nros_correlativos  SET NRO_PUESTO='$NUMERO_GREMIAL'")or die ("NO SE PUDO ACTUALIZAR LOS DATOS DEL nros_correlativos.");
//OBTIENE EL MONTO DE COMPLEMENTO
$liqui=mysql_query("select * from complemento where ESTADO='ACTIVO'");while($rowt=mysql_fetch_array($liqui)){ $MONTOS=$rowt['MONTO'];$FORMULARIOS=$rowt['FORMULARIO'];}
$contextSql = array(
  'user' => mysql_real_escape_string($US_SIOI),
  'userName' => mysql_real_escape_string("$SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO"),
  'registry' => mysql_real_escape_string($txtCodigoRegistro),
  'contributor' => $CODIGO_CONTRIBUYENTE_SQL,
  'association' => mysql_real_escape_string($COD_ASOCIACION),
  'zone' => mysql_real_escape_string($CODIGO_ZONA_TRIB),
  'document' => mysql_real_escape_string($txtDocumento),
  'documentDate' => mysql_real_escape_string($txtFecha),
  'observations' => mysql_real_escape_string($txtObservaciones),
  'management' => mysql_real_escape_string($sltGestion),
  'amount' => mysql_real_escape_string(isset($MONTOS) ? $MONTOS : ''),
  'form' => mysql_real_escape_string(isset($FORMULARIOS) ? $FORMULARIOS : '')
);
$sql1="insert into reg_contribuyente_habilitado_pago_complementacion(PC_NAME,PC_IP,USUARIO,NOMBRE_USUARIO,FECHA,HORA,CODIGO_REGISTRO,CODIGO_GREMIAL,CODIGO_CONTRIBUYENTE,CODIGO_ASOCIACION,CODIGO_ZONA,DOCUMENTO,FECHA_DOCUMENTO,OBSERVACIONES_REGISTRO,GESTION,MONTO,FORMULARIO)values('$hostname','$hostlocal','{$contextSql['user']}','{$contextSql['userName']}','$FECHA','$HORA','{$contextSql['registry']}','$NUMERO_GREMIAL','{$contextSql['contributor']}','{$contextSql['association']}','{$contextSql['zone']}','{$contextSql['document']}','{$contextSql['documentDate']}','{$contextSql['observations']}','{$contextSql['management']}','{$contextSql['amount']}','{$contextSql['form']}')";$result=mysql_query($sql1)or die ("NO SE PUDO REGISTRAR EN LA ENTIDAD reg_contribuyente_habilitado_pago_complementacion.");
$mensaje = 'Se Adiciono Contribuyente';
//REGISTRA EN TRANSACCIONES
$sql1="insert into reg_contribuyente_transacciones(PC_NAME,PC_IP,USUARIO,NOMBRE_USUARIO,FECHA,HORA,CODIGO_REGISTRO,CODIGO_ASOCIACION,ASOCIACION,TRANSACCION_1,DESCRIPCION_TRAMITE,OBSERVACIONES,ENLACE)values('$hostname','$hostlocal','{$contextSql['user']}','{$contextSql['userName']}','$FECHA','$HORA','{$contextSql['registry']}','{$contextSql['association']}','".mysql_real_escape_string($ASOCIACION)."','COMPLEMENTACION DE CONTRIBUYENTE','COMPLEMENTACION DE CONTRIBUYENTE CON CODIGO CONTRIBUYENTE $CODIGO_CONTRIBUYENTE NUMERO GREMIAL $NUMERO_GREMIAL PARA LA GESTION {$contextSql['management']} DOCUMENTO {$contextSql['document']}.','COMPLEMENTACION DE CONTRIBUYENTE CON CODIGO CONTRIBUYENTE $CODIGO_CONTRIBUYENTE NUMERO GREMIAL $NUMERO_GREMIAL PARA LA GESTION {$contextSql['management']} DOCUMENTO {$contextSql['document']}.','0')";$result=mysql_query($sql1)or die ("NO SE PUDO REGISTRAR EN LA ENTIDAD reg_contribuyente_transacciones."); 
} else {
$mensaje = 'NO SE ENCONTRO UN CONTRIBUYENTE ACTIVO PARA ASOCIAR.';
}
}
if($ELIMINAR==1){
$IDS_SQL = mysql_real_escape_string($IDS);
$puestoQuery = mysql_query("select CODIGO_GREMIAL from reg_contribuyente_habilitado_pago_complementacion where CODIGO_CONTRIBUYENTE='$CODIGO_CONTRIBUYENTE_SQL' and ID='$IDS_SQL' and ESTADO='ACTIVO'") or die("NO SE PUDO CONSULTAR EL REGISTRO DE COMPLEMENTACION.");
$puestoRow = mysql_fetch_array($puestoQuery);
if (!$puestoRow) { die("EL REGISTRO DE COMPLEMENTACION YA NO ESTA ACTIVO O NO EXISTE."); }
$NUMERO_GREMIAL = $puestoRow['CODIGO_GREMIAL'];
$eliminado = mysql_real_escape_string("ELIMINADO POR EL USUARIO $US_SIOI - $SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO, FECHA: $FECHA HORA: $HORA");
$observacionEliminada = mysql_real_escape_string("REGISTRO ELIMINADO, POR EL USUARIO $US_SIOI - $SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO, FECHA: $FECHA HORA: $HORA");
$query = mysql_query("UPDATE reg_contribuyente_habilitado_pago_complementacion SET ESTADO='$eliminado',COMUNICACION_INTERNA='$eliminado',ESTADO_COMUNICACION_INTERNA='$eliminado',ENLACE='$eliminado',ESTADO_PAGO='$eliminado',ESTADO_ORDEN_PAGO='$eliminado',OBSERVACIONES='$observacionEliminada' where CODIGO_CONTRIBUYENTE='$CODIGO_CONTRIBUYENTE_SQL' and ID='$IDS_SQL' and ESTADO='ACTIVO'")or die ("NO SE PUDO ACTUALIZAR LOS DATOS DE LA MODIFICACION DE reg_contribuyente_habilitado_pago_complementacion.");
$mensaje = 'Se Elimino Contribuyente';

//REGISTRA EN TRANSACCIONES
$nombreUsuario = mysql_real_escape_string("$SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO");
$descripcion = mysql_real_escape_string("ELIMINO LA COMPLEMENTACION DE CONTRIBUYENTE CON CODIGO CONTRIBUYENTE $CODIGO_CONTRIBUYENTE PARA LA GESTION $sltGestion.");
$observaciones = mysql_real_escape_string("ELIMINO LA COMPLEMENTACION DE CONTRIBUYENTE CON CODIGO CONTRIBUYENTE $CODIGO_CONTRIBUYENTE $NUMERO_GREMIAL PARA LA GESTION $sltGestion.");
$sql1="insert into reg_contribuyente_transacciones(PC_NAME,PC_IP,USUARIO,NOMBRE_USUARIO,FECHA,HORA,CODIGO_REGISTRO,CODIGO_ASOCIACION,ASOCIACION,TRANSACCION_1,DESCRIPCION_TRAMITE,OBSERVACIONES,ENLACE)values('$hostname','$hostlocal','".mysql_real_escape_string($US_SIOI)."','$nombreUsuario','$FECHA','$HORA','".mysql_real_escape_string($txtCodigoRegistro)."','".mysql_real_escape_string($COD_ASOCIACION)."','".mysql_real_escape_string($ASOCIACION)."','COMPLEMENTACION DE CONTRIBUYENTE','$descripcion','$observaciones','0')";$result=mysql_query($sql1)or die ("NO SE PUDO REGISTRAR EN LA ENTIDAD reg_contribuyente_transacciones."); 
	}
?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel='StyleSheet' href='../Css_Formularios/frmProcesos.css' type="text/css">
</head>
<body>
<?php if ($mensaje !== '') { ?><script>alert(<?php echo json_encode($mensaje); ?>);</script><?php } ?>
<form method="post" accept-charset="UTF-8" action="frmComplementacion4.php">
<input type="hidden" name="COD_REGISTRO" value="<?php echo htmlspecialchars($COD_REGISTRO, ENT_QUOTES, 'UTF-8'); ?>" />
<input type="hidden" name="CODIGO_ZONA_TRIB" value="<?php echo htmlspecialchars($CODIGO_ZONA_TRIB, ENT_QUOTES, 'UTF-8'); ?>" />
<input type="hidden" name="OMS" value="<?php echo htmlspecialchars($OMS, ENT_QUOTES, 'UTF-8'); ?>" />
<input type="hidden" name="txtCodigoRegistro" value="<?php echo htmlspecialchars($txtCodigoRegistro, ENT_QUOTES, 'UTF-8'); ?>" />
<input type="hidden" name="sltGestion" value="<?php echo htmlspecialchars($sltGestion, ENT_QUOTES, 'UTF-8'); ?>" />
<table width="100%" border="0" align="left">
  <tr>
    <td align="center" class="TITULO">COMPLEMENTACION</td>
  </tr>
  <tr>
    <td align="center" class="SUBTITULO">AGREGAR CONTRIBUYENTES</td>
  </tr>
  <tr>
    <td><span style="font-weight: bold">DATOS DE ASOCIACION.</span></td>
  </tr>
  <tr>
    <td style="font-weight: bold"><img src="../Img/Linea_Negra.png" width="880" height="2" /></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="1" cellspacing="1" bordercolor="#FFFFFF">
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
          <?php $liqui=mysql_query("select ZT.DESCRIPCION,ZT.CODIGO_ZONA from zona_tributaria ZT,reg_asociacion_zona_tributaria RAZT where RAZT.CODIGO_ASOCIACION='".mysql_real_escape_string($COD_ASOCIACION)."' and RAZT.CODIGO_ZONA=ZT.CODIGO_ZONA and RAZT.ESTADO='ACTIVO' and ZT.ESTADO='ACTIVO'");while($rowt=mysql_fetch_array($liqui)){ echo htmlspecialchars($rowt[0], ENT_QUOTES, 'UTF-8'); $ZONA_TRIB=$rowt[0];  $CODIGO_ZONA_TRIB=$rowt[1];} ?>
        </span></td>
      </tr>
      <tr>
        <td colspan="2" align="left" style="font-weight: bold">DATOS SOLICITUD.</td>
      </tr>
      <tr>
        <td colspan="2" align="left"><hr /></td>
        </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC">Gestión</td>
        <td style="font-weight: bold; font-size: 14px;"><?php echo htmlspecialchars($sltGestion, ENT_QUOTES, 'UTF-8');?></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC">Documento :</td>
        <td style="font-weight: bold; font-size: 14px;"><input name="txtDocumento" type="hidden" id="txtDocumento" value="<?php echo htmlspecialchars($txtDocumento, ENT_QUOTES, 'UTF-8');?>" /><?php echo htmlspecialchars($txtDocumento, ENT_QUOTES, 'UTF-8');?></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC"> Fecha Documento :</td>
        <td style="font-weight: bold; font-size: 14px;"><input name="txtFecha" type="hidden" id="txtFecha" value="<?php echo htmlspecialchars($txtFecha, ENT_QUOTES, 'UTF-8');?>" />
          <?php echo htmlspecialchars($txtFecha, ENT_QUOTES, 'UTF-8');?></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC">Observaciones :</td>
        <td style="font-weight: bold; font-size: 14px;"><input name="txtObservaciones" type="hidden" id="txtObservaciones" value="<?php echo htmlspecialchars($txtObservaciones, ENT_QUOTES, 'UTF-8');?>" />
          <?php echo htmlspecialchars($txtObservaciones, ENT_QUOTES, 'UTF-8');?></td>
      </tr>
    </table>
  </td>
  </tr>
  <tr>
    <td align="left" style="font-weight: bold">Datos Contribuyente.</td>
  </tr>
  <tr>
    <td align="left" style="font-weight: bold"><img src="../Img/Linea_Negra.png" width="880" height="2" /></td>
  </tr>
  <tr>
    <td align="left" style="font-weight: bold"></td>
  </tr>
  <tr>
    <td align="center" style="font-weight: bold"><table width="100%" border="0" cellspacing="1" cellpadding="1">
      <tr>
        <td height="33" align="center" bgcolor="#CCCCCC">No.</td>
        <td align="center" bgcolor="#CCCCCC">Documento</td>
        <td align="center" bgcolor="#CCCCCC">Nombre(s) y Apellido(s)</td>
        <td align="center" bgcolor="#CCCCCC" >ACTIVIDAD</td>
        <td align="center" bgcolor="#CCCCCC" >FILA</td>
        <td align="center" bgcolor="#CCCCCC" >PUESTO</td>
        <td align="center" >&nbsp;</td>
        </tr><?php $rest=mysql_query("select RC.DOC_IDENTIDAD,RC.DOC_IDENTIDAD_ALFA,RC.EXPEDIDO,RC.NOMBRE_RSOCIAL,RC.PRIMER_APELLIDO,RC.SEGUNDO_APELLIDO,RC.APELLIDO_ESPOSO,RC.CODIGO_CONTRIBUYENTE,RCHPC.Id,RCHPC.TIPO_VENTA,RCHPC.FILA,RCHPC.PUESTO from contribuyentes RC, reg_contribuyente_habilitado_pago_complementacion RCHPC where RCHPC.CODIGO_REGISTRO='".mysql_real_escape_string($txtCodigoRegistro)."' and RCHPC.CODIGO_ASOCIACION='".mysql_real_escape_string($COD_ASOCIACION)."' and RC.ESTADO='ACTIVO' and RC.CODIGO_CONTRIBUYENTE=RCHPC.CODIGO_CONTRIBUYENTE and RCHPC.ESTADO='ACTIVO'") or die("NO SE PUDO CONSULTAR LA LISTA DE CONTRIBUYENTES DE LA COMPLEMENTACION."); while($row=mysql_fetch_array($rest)){ ?>
      <tr>
        <td bgcolor="#E3F0F2"><?php $cont++; echo $cont;?></td>
        <td bgcolor="#E3F0F2"><?php if($row['1']== null){echo htmlspecialchars($row['0'].' '.$row['2'], ENT_QUOTES, 'UTF-8');}else{echo htmlspecialchars($row['0'].' - '.$row['1'].' '.$row['2'], ENT_QUOTES, 'UTF-8');};?></td>
        <td bgcolor="#E3F0F2"><?php if($row['6']== null){echo htmlspecialchars($row['3'].' '.$row['4'].' '.$row['5'], ENT_QUOTES, 'UTF-8');}else{echo htmlspecialchars($row['3'].' '.$row['4'].' '.$row['5'].' de '.$row['6'], ENT_QUOTES, 'UTF-8');}?></td>
        <td bgcolor="#E3F0F2"><?php echo htmlspecialchars($row['9'], ENT_QUOTES, 'UTF-8'); if(trim((string)$row['9']) === '' || trim((string)$row['10']) === '' || trim((string)$row['11']) === '' || $row['9']=="NO DEFINIDO." || $row['10']=="NO DEFINIDO." || $row['11']=="NO DEFINIDO."){$SW11=1;}?></td>
        <td bgcolor="#E3F0F2"><?php echo htmlspecialchars($row['10'], ENT_QUOTES, 'UTF-8');?></td>
        <td bgcolor="#E3F0F2"><?php echo htmlspecialchars($row['11'], ENT_QUOTES, 'UTF-8');?></td>
        <td align="left"><table width="70%" border="0">
          <tr>
            <td width="10%" align="right"><img src="../Img/Adicionar.png" width="20" height="20" /></td>
            <td width="52%" ><a href="frmComplementacionAgregarAct.php?IDS=<?php echo urlencode($row['8']);?>&amp;CODIGO_CONTRIBUYENTE=<?php echo urlencode($row['7']);?>" title="AGREGAR TIPO DE ACTIVIDAD ECONOMICA">Agregar Actividad</a></td>
            <td width="10%" align="right"><img src="../Img/excluir.png" width="20" height="20" /></td>
            <td width="28%" ><a href="frmComplementacion2.php?IDS=<?php echo urlencode($row['8']);?>&amp;CODIGO_CONTRIBUYENTE=<?php echo urlencode($row['7']);?>&amp;ELIMINAR=1" title="SELECCIONAR CONTRIBUYENTE">Eliminar</a></td>
            </tr>
        </table></td>
        </tr>  <?php } ?>
      <tr>
        <td bgcolor="#E3F0F2">&nbsp;</td>
        <td bgcolor="#E3F0F2">&nbsp;</td>
        <td bgcolor="#E3F0F2">&nbsp;</td>
        <td bgcolor="#E3F0F2">&nbsp;</td>
        <td bgcolor="#E3F0F2">&nbsp;</td>
        <td bgcolor="#E3F0F2">&nbsp;</td>
        <td><?php if($SW11==0){?><table width="30%" border="0">
          <tr>
            <td width="18%" align="right"><img src="../Img/Agregar.png" width="20" height="20" /></td>
            <td width="82%"><a href="frmComplementacion3.php?COD_REGISTRO=<?php echo urlencode($COD_REGISTRO);?>&amp;CODIGO_ZONA_TRIB=<?php echo urlencode($CODIGO_ZONA_TRIB);?>&amp;COD_ASOCIACION=<?php echo urlencode($COD_ASOCIACION);?>&amp;ASOCIACION=<?php echo urlencode($ASOCIACION);?>&amp;OMS=<?php echo urlencode($OMS);?>&amp;txtCodigoRegistro=<?php echo urlencode($txtCodigoRegistro);?>&amp;txtDocumento=<?php echo urlencode($txtDocumento);?>&amp;txtFecha=<?php echo urlencode($txtFecha);?>&amp;txtObservaciones=<?php echo urlencode($txtObservaciones);?>&amp;sltGestion=<?php echo urlencode($sltGestion);?>">Adicionar</a></td>
            </tr>
        </table><?php } else{echo 'ASIGNE LOS DATOS DE LA ACTIVIDAD ECONOMICA.';}?></td>
        </tr>
    
    </table></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td align="center"><table width="30%" border="0">
      <tr>
        <td align="right"><a href="frmComplementacion.php">Volver</a></td>
      <?php if($SW11==0 && $cont > 0){ ?>  <td align="center">|</td>
        <td><input type="submit" name="button" id="button" value="Continuar" style="width:200px; height:35px" /></td><?php } ?>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="ASTERISCO">VER. 3</td>
  </tr>
</table>
</form>
</body>
</html><?php require '../Conexion_BD/Cerrar_Dbms.php';?>