<?php require_once('../Control_Sesiones_Forms/frmControlSesionUsuario.php');
header('Content-Type: text/html; charset=utf-8');
require '../Conexion_BD/Dbms.php';
$COD_ASOCIACION = isset($_GET['COD_ASOCIACION']) && is_scalar($_GET['COD_ASOCIACION']) ? (string)$_GET['COD_ASOCIACION'] : '';
$OMS = isset($_GET['OMS']) && is_scalar($_GET['OMS']) ? (string)$_GET['OMS'] : '';
$OMS = str_replace("Â°", "°", $OMS);
$ASOCIACION = isset($_GET['ASOCIACION']) && is_scalar($_GET['ASOCIACION']) ? (string)$_GET['ASOCIACION'] : '';
if ($COD_ASOCIACION === '' || $ASOCIACION === '' || $OMS === '') {
    include_once("Index.php");
    exit;
}
unset($_SESSION['OMS'],$_SESSION['COD_ASOCIACION'],$_SESSION['CODIGO_ZONA_TRIB'],$_SESSION['COD_REGISTRO'],$_SESSION['sltGestion'],$_SESSION['ASOCIACION'],$_SESSION['txtCodigoRegistro'],$_SESSION['txtDocumento'],$_SESSION['txtFecha'],$_SESSION['txtObservaciones']);
$_SESSION['COD_ASOCIACION']=$COD_ASOCIACION;
$_SESSION['OMS']=$OMS;
$_SESSION['ASOCIACION']=$ASOCIACION;$cont=0;
$CONTS=0;
$CONTTS=0;
$GESTION_SEC=(int)date('Y')-1;
$COD_ASOCIACION_SQL=mysql_real_escape_string($COD_ASOCIACION);
$resultY=mysql_query("select RSG.id from reg_secretario_general_asociacion RSG inner join secretario_general SG on SG.CODIGO_SECRETARIO_GENERAL=RSG.CODIGO_SECRETARIO_GENERAL and SG.ESTADO='ACTIVO' where RSG.CODIGO_ASOCIACION='$COD_ASOCIACION_SQL' and RSG.GESTION='$GESTION_SEC' and RSG.ESTADO='ACTIVO' limit 1") or die("NO SE PUDO VERIFICAR EL SECRETARIO GENERAL.");
$SWSEC = mysql_num_rows($resultY) > 0 ? 1 : 0;
?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel='StyleSheet' href='../Css_Formularios/frmProcesos.css' type="text/css">
</head>

<body>
<table width="100%" border="0" align="left">
  <tr>
    <td align="center" class="TITULO">COMPLEMENTACION</td>
  </tr>
  <tr>
    <td align="center" class="SUBTITULO">DEUDAS PENDIENTES</td>
  </tr>
  <tr>
    <td><span style="font-weight: bold">DATOS DE ASOCIACION.</span></td>
  </tr>
  <tr>
    <td style="font-weight: bold"><hr /></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="1" cellspacing="1" bordercolor="#FFFFFF">
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
          <?php $liqui=mysql_query("select ZT.DESCRIPCION,ZT.CODIGO_ZONA from zona_tributaria ZT,reg_asociacion_zona_tributaria RAZT where RAZT.CODIGO_ASOCIACION='".mysql_real_escape_string($COD_ASOCIACION)."' and RAZT.CODIGO_ZONA=ZT.CODIGO_ZONA and RAZT.ESTADO='ACTIVO' and ZT.ESTADO='ACTIVO'");while($rowt=mysql_fetch_array($liqui)){ echo htmlspecialchars($rowt[0], ENT_QUOTES, 'UTF-8'); $ZONA_TRIB=$rowt[0];  $CODIGO_ZONA_TRIB=$rowt[1]; $_SESSION['CODIGO_ZONA_TRIB']=$CODIGO_ZONA_TRIB;} ?>
        </span></td>
      </tr>
      <tr>
        <td colspan="2" align="left" style="font-weight: bold">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" align="left" style="font-weight: bold">DEUDAS PENDIENTES - IMPUESTO ANUAL.</td>
      </tr>
      <tr>
        <td colspan="2" align="left"><hr /></td>
        </tr>
      <tr>
        <td colspan="2" align="right"><table width="100%" border="0">
          <tr>
            <td height="33" align="center" bgcolor="#E3EEEE" style="font-weight: bold; font-size: 12px;">No.</td>
            <td align="center" bgcolor="#E3EEEE" style="font-weight: bold; font-size: 12px;">Fecha de Cargado</td>
            <td align="center" bgcolor="#E3EEEE" style="font-weight: bold; font-size: 12px;">Gestión</td>
            <td align="center" bgcolor="#E3EEEE" style="font-weight: bold; font-size: 12px;">Estado</td>
          </tr><?php $res=mysql_query("select distinct(CODIGO_REGISTRO),FECHA,HORA,GESTION,ESTADO_PAGO from reg_contribuyente_habilitado_pago where CODIGO_ASOCIACION='$COD_ASOCIACION_SQL' and ESTADO='ACTIVO'");while($row=mysql_fetch_array($res)){ ?>
          <tr>
            <td height="23" bgcolor="#EBDBD6"><?php $CONT++; echo $CONT; ?></td>
            <td bgcolor="#EBDBD6"><?php echo htmlspecialchars($row[1].' Hrs.: '.$row[2], ENT_QUOTES, 'UTF-8'); ?></td>
                <td bgcolor="#EBDBD6"><?php echo htmlspecialchars($row[3], ENT_QUOTES, 'UTF-8'); ?></td>
                <td bgcolor="#EBDBD6"><?php echo htmlspecialchars($row[4].' - IMPUESTO ANUAL CON DEUDA.', ENT_QUOTES, 'UTF-8'); ?></td>
          </tr><?php } ?>
        </table></td>
        </tr>
    </table>
   </td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td align="left"><span style="font-weight: bold">DEUDAS PENDIENTES - COMPLEMENTOS.</span></td>
  </tr>
  <tr>
    <td align="center"><hr /></td>
  </tr>
  <tr>
    <td align="center"><table width="100%" border="0">
      <tr>
        <td height="33" align="center" bgcolor="#E3EEEE" style="font-weight: bold; font-size: 12px;">No.</td>
        <td align="center" bgcolor="#E3EEEE" style="font-weight: bold; font-size: 12px;">Fecha de Cargado</td>
        <td align="center" bgcolor="#E3EEEE" style="font-weight: bold; font-size: 12px;">Usuario</td>
        <td align="center" bgcolor="#E3EEEE" style="font-weight: bold; font-size: 12px;">Gestión</td>
        <td align="center" bgcolor="#E3EEEE" style="font-weight: bold; font-size: 12px;">Estado</td>
        <td align="center" bgcolor="#E3EEEE" style="font-weight: bold; font-size: 12px;">Comunicación Interna</td>
        <td align="center" style="font-weight: bold; font-size: 12px;">&nbsp;</td>
      </tr>
      <?php $res=mysql_query("select distinct(CODIGO_REGISTRO),FECHA,GESTION,ESTADO_PAGO,USUARIO,NOMBRE_USUARIO,COMUNICACION_INTERNA,ENLACE from reg_contribuyente_habilitado_pago_complementacion where CODIGO_ASOCIACION='$COD_ASOCIACION_SQL' and ESTADO='ACTIVO'");while($row=mysql_fetch_array($res)){ ?>
      <tr>
        <td height="23" bgcolor="#EBDBD6"><?php $CONTS++; echo $CONTS; ?></td>
        <td bgcolor="#EBDBD6"><?php echo htmlspecialchars($row[1], ENT_QUOTES, 'UTF-8'); ?></td>
        <td bgcolor="#EBDBD6"><?php echo htmlspecialchars($row[4].' - '.$row[5], ENT_QUOTES, 'UTF-8'); ?></td>
        <td bgcolor="#EBDBD6"><?php echo htmlspecialchars($row[2], ENT_QUOTES, 'UTF-8'); ?></td>
        <td bgcolor="#EBDBD6"><?php echo htmlspecialchars($row[3].' - POR COMPLEMENTO DE CONTRIBUYENTES', ENT_QUOTES, 'UTF-8'); ?></td>
        <td bgcolor="#EBDBD6"><?php if ($row[6] !== 'NO GENERADO' && preg_match('/^[0-9]{4}\/[A-Za-z0-9_-]+$/', $row[7])) { $rutaDocumento = dirname(__FILE__) . '/Pdf_Complementos/generated/' . $row[7]; $extensionDocumento = is_file($rutaDocumento . '.docx') ? 'docx' : (is_file($rutaDocumento . '.pdf') ? 'pdf' : 'doc'); ?><a href="Pdf_Complementos/generated/<?php echo htmlspecialchars($row[7], ENT_QUOTES, 'UTF-8'); ?>.<?php echo $extensionDocumento; ?>" target="_blank"><?php echo htmlspecialchars($row[6], ENT_QUOTES, 'UTF-8'); ?></a><?php } else { echo htmlspecialchars($row[6] === 'NO GENERADO' ? $row[6] : 'ENLACE NO DISPONIBLE', ENT_QUOTES, 'UTF-8'); } ?></td>
        <td><a href="Pdf_Complementos/frmGenerarNominaSinComInt.php?CODIGO_REGISTRO=<?php echo urlencode($row[0]);?>&amp;COD_ASOCIACION=<?php echo urlencode($COD_ASOCIACION);?>" target="_new" title="HAGA CLIC PARA VER LA COMUNICACION INTERNA">Ver Nómina</a></td>
      </tr>  <?php } if($CONTS==0){ ?>
      <tr>
        <td height="23">&nbsp;</td>
        <td colspan="6">SIN REGISTRO</td>
        </tr><?php } ?>
    
    </table></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td align="left"><span style="font-weight: bold">DEUDAS PENDIENTES - CAMBIO DE NOMBRE.</span></td>
  </tr>
  <tr>
    <td align="center"><hr /></td>
  </tr>
  <tr>
    <td align="center"><table width="100%" border="0">
      <tr>
        <td height="33" align="center" bgcolor="#E3EEEE" style="font-weight: bold; font-size: 12px;">No.</td>
        <td align="center" bgcolor="#E3EEEE" style="font-weight: bold; font-size: 12px;">Fecha de Cargado</td>
        <td align="center" bgcolor="#E3EEEE" style="font-weight: bold; font-size: 12px;">Usuario</td>
        <td align="center" bgcolor="#E3EEEE" style="font-weight: bold; font-size: 12px;">Gestión</td>
        <td align="center" bgcolor="#E3EEEE" style="font-weight: bold; font-size: 12px;">Estado</td>
        <td align="center" bgcolor="#E3EEEE" style="font-weight: bold; font-size: 12px;">Comunicación Interna</td>
        <td align="center" style="font-weight: bold; font-size: 12px;">&nbsp;</td>
      </tr>
      <?php $res=mysql_query("select distinct(CODIGO_REGISTRO),FECHA,GESTION,ESTADO_PAGO,USUARIO,NOMBRE_USUARIO,COMUNICACION_INTERNA,ENLACE from reg_contribuyente_habilitado_pago_cambio_nombre where CODIGO_ASOCIACION='$COD_ASOCIACION_SQL' and ESTADO='ACTIVO'");while($row=mysql_fetch_array($res)){ ?>
      <tr>
        <td height="23" bgcolor="#EBDBD6"><?php $CONTTS++; echo $CONTTS; ?></td>
        <td bgcolor="#EBDBD6"><?php echo htmlspecialchars($row[1], ENT_QUOTES, 'UTF-8'); ?></td>
        <td bgcolor="#EBDBD6"><?php echo htmlspecialchars($row[4].' - '.$row[5], ENT_QUOTES, 'UTF-8'); ?></td>
        <td bgcolor="#EBDBD6"><?php echo htmlspecialchars($row[2], ENT_QUOTES, 'UTF-8'); ?></td>
        <td bgcolor="#EBDBD6"><?php echo htmlspecialchars($row[3].' - POR CAMBIO DE NOMBRE DE CONTRIBUYENTES', ENT_QUOTES, 'UTF-8'); ?></td>
        <td bgcolor="#EBDBD6"><a href="../Cambio_Nombre/Pdf_Cambio_Nombre/<?php echo rawurlencode($row[7]); ?>.pdf" target="_new"><?php echo htmlspecialchars($row[6], ENT_QUOTES, 'UTF-8'); ?></a></td>
        <td><a href="../Cambio_Nombre/Pdf_Cambio_Nombre/frmGenerarNominaCambioNombre.php?CODIGO_REGISTRO=<?php echo urlencode($row[0]);?>&amp;COD_ASOCIACION=<?php echo urlencode($COD_ASOCIACION);?>&amp;ASOCIACION=<?php echo urlencode($ASOCIACION);?>" target="_new">Ver Nómina</a></td>
      </tr> <?php } ?>
      <tr>
        <td height="23">&nbsp;</td>
        <td colspan="6">SIN REGISTRO</td>
      </tr>
     
    </table></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td align="center"><a href="frmComplementacion.php">Volver</a>
      <?php if($CONT==0){?>
|
        
  <a href="frmComplementacion1.php">Continuar</a>
<?php } ?>
    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="ASTERISCO">VER. 1</td>
  </tr>
</table>
</body>
</html><?php  require '../Conexion_BD/Cerrar_Dbms.php';
if($SWSEC==0){echo "<script>alert('LA ASOCIACION SELECCIONADA NO TIENE DATOS ACTUALIZADOS DEL \\n SECRETARIO GENERAL PARA LA GESTION: $GESTION_SEC.')</script>";
echo"<script> location.href='frmComplementacion.php';</script>";
}
if($CONT>0){echo "<script>alert('La ASOCIACION seleccionada tiene deudas pendientes.')</script>";}

if($CONT==0 and $CONTS==0 and $CONTTS==0){echo"<script> location.href='frmComplementacion1.php';</script>";}
?>