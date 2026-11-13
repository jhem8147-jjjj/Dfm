<?php require_once('../Control_Sesiones_Forms/frmControlSesionUsuario.php');
require_once('../Control_Sesiones_Forms/Loading.php'); require '../Conexion_BD/Dbms.php'; require_once '../Conexion_BD/request.php';
$COD_ASOCIACION = appRequestValue('COD_ASOCIACION');
$ASOCIACION = appRequestValue('ASOCIACION');
$ORDENANZA_MUNICIPAL = appRequestValue('ORDENANZA_MUNICIPAL');
$sltGestion = appRequestValue('sltGestion');
if ($COD_ASOCIACION === '' || $sltGestion === '') {
	echo "<script>alert('Seleccione una asociación y una gestión para continuar.'); location.href='frmValidarNombresCont.php';</script>";
	exit;
}
$_SESSION['COD_ASOCIACION'] = $COD_ASOCIACION;
$_SESSION['ASOCIACION'] = $ASOCIACION;
$_SESSION['ORDENANZA_MUNICIPAL'] = $ORDENANZA_MUNICIPAL;
$_SESSION['sltGestion'] = $sltGestion;
$COD_ASOCIACION_SQL = mysql_real_escape_string($COD_ASOCIACION);
$sltGestion_SQL = mysql_real_escape_string($sltGestion);
 ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel='StyleSheet' href='../Css_Formularios/frmProcesos.css' type="text/css">
</head>
<body>
<table width="100%" border="0">
  <tr>
    <td align="center" class="TITULO"><?php 
    $result=mysql_query("select * from nombre_formularios where UBICACION='VALIDACION DE NOMBRE DE CONTRIBUYENTE' and ESTADO='ACTIVO'"); 
    while($row=mysql_fetch_array($result)){ echo $row['DESCRIPCION']; }?></td>
  </tr>
  <tr>
    <td align="center" class="SUBTITULO">Validacion de Nombre(s) de Contribuyente(s) y Datos(s) Puesto(s) y Fila(s)</td>
  </tr>
  <tr>
    <td><img src="../Img/Linea.png" width="843" height="4" /></td>
  </tr>
  <tr>
    <td style="font-weight: bold">Datos de Asociación.</td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="2" cellspacing="2" bordercolor="#FFFFFF">
      <tr>
        <td height="32" align="right" bgcolor="#CCCCCC">Documento de Registro :</td>
        <td style="font-weight: bold"><?php echo htmlspecialchars($ORDENANZA_MUNICIPAL, ENT_QUOTES, 'UTF-8');?></td>
      </tr>
      <tr>
        <td width="32%" height="32" align="right" bgcolor="#CCCCCC">Asociación Seleccionada :</td>
        <td width="68%" style="font-weight: bold"><?php echo htmlspecialchars($ASOCIACION, ENT_QUOTES, 'UTF-8');?>
          <input name="txtSw" type="hidden" id="txtSw" value="1" /></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC">Gestión Seleccionada :</td>
        <td ><span style="font-weight: bold"><?php echo htmlspecialchars($sltGestion, ENT_QUOTES, 'UTF-8');?></span></td>
      </tr>
      <tr>
        <td align="right"><img src="../Img/Blanco.png" width="300" height="1" /></td>
        <td class="comentario">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="left"><span style="font-weight: bold">Resultados de Busqueda.
    </span>      <hr /></td>
  </tr>
  <tr>
    <td><table id="example" class="table table-striped table-bordered" style="width:100%;">
      <thead>
        <tr>
          <td height="43" align="center" bgcolor="#CCCCCC" style="font-weight: bold">No.</td>
          <td align="center" bgcolor="#CCCCCC" style="font-weight: bold">FECHA Y HORA</td>
          <td align="center" bgcolor="#CCCCCC" style="font-weight: bold">USUARIO</td>
          <td align="center" bgcolor="#CCCCCC" style="font-weight: bold">GESTION</td>
          <td align="center" bgcolor="#CCCCCC" style="font-weight: bold">ESTADO PAGO</td>
          <td align="center" bgcolor="#CCCCCC" style="font-weight: bold">ESTADO DE REGISTROS</td>
          <td align="center" bgcolor="#CCCCCC" style="font-weight: bold">COMUNICACION INTERNA</td>
          <td align="center" style="font-weight: bold">&nbsp;</td>
        </tr>
      </thead>
      <tbody>
        <?php $result=mysql_query("select distinct CODIGO_REGISTRO,GESTION,FECHA,HORA,USUARIO,NOMBRE_USUARIO,ESTADO,ESTADO_REGISTRO,COMUNICACION_INTERNA,ENLACE 
        from reg_contribuyente_habilitado_pago 
        where ESTADO='ACTIVO' AND  CODIGO_ASOCIACION='$COD_ASOCIACION_SQL' 
        and GESTION='$sltGestion_SQL' order by ESTADO_REGISTRO"); while($row=mysql_fetch_array($result)){$SWT=0; ?>
        <tr>
          <td bgcolor="#F4F4F4"><?php $CONT++; echo $CONT; ?></td>
          <td bgcolor="#F4F4F4"><?php echo $row[2].' Hrs. '.$row[3]; ?></td>
          <td bgcolor="#F4F4F4"><?php echo htmlspecialchars($row[4].' Hrs. '.$row[5], ENT_QUOTES, 'UTF-8'); ?></td>
          <td bgcolor="#F4F4F4"><?php echo htmlspecialchars($row[1], ENT_QUOTES, 'UTF-8'); ?></td>
          <td bgcolor="#F4F4F4"><?php if($row[6]=='ACTIVO'){echo 'NO PAGADO';}else{echo htmlspecialchars($row[6], ENT_QUOTES, 'UTF-8');} ?></td>
          <td bgcolor="#F4F4F4"><?php  $codigoRegistroSql = mysql_real_escape_string($row[0]); $estadoRegistroSql = mysql_real_escape_string($row[7]); $results=mysql_query("select count(CODIGO_REGISTRO) from reg_contribuyente_habilitado_pago where CODIGO_REGISTRO='$codigoRegistroSql' AND ESTADO='ACTIVO' AND  CODIGO_ASOCIACION='$COD_ASOCIACION_SQL' and GESTION='$sltGestion_SQL' and ESTADO_REGISTRO='$estadoRegistroSql'"); while($rowts=mysql_fetch_array($results)){ echo '( '.$rowts[0].' ) ';} echo htmlspecialchars($row[7], ENT_QUOTES, 'UTF-8'); ?></td>
          <td bgcolor="#F4F4F4"><?php if ($row[8] !== '' && preg_match('/^[0-9]{4}\/[A-Za-z0-9_-]+$/', $row[9])) { $rutaDocumento = dirname(__FILE__) . '/Pdf_Comunicacion_Interna/generated/' . $row[9]; $extensionDocumento = is_file($rutaDocumento . '.docx') ? 'docx' : (is_file($rutaDocumento . '.pdf') ? 'pdf' : ''); if ($extensionDocumento !== '') { ?><a href="Pdf_Comunicacion_Interna/generated/<?php echo htmlspecialchars($row[9], ENT_QUOTES, 'UTF-8'); ?>.<?php echo $extensionDocumento; ?>" target="_blank"><?php echo htmlspecialchars($row[8], ENT_QUOTES, 'UTF-8'); ?></a><?php } else { echo htmlspecialchars($row[8], ENT_QUOTES, 'UTF-8'); } } else { echo htmlspecialchars($row[8], ENT_QUOTES, 'UTF-8'); } ?></td>
          <td align="center" style="font-weight: bold"><a href="frmValidarNombresCont2.php?sltGestion=<?php echo urlencode($row[1]); ?>&amp;CODIGO_REGISTRO=<?php echo urlencode($row[0]); ?>" ><?php if($row[7]=='NO VALIDADO'){?>VALIDAR REGISTROS<?php }else{echo 'MOSTRAR LISTADO';}?></a></td>
        </tr>
        <?php } ?>
      </tbody>
      <tfoot>
      </tfoot>
      <tfoot>
      </tfoot>
    </table></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td align="center"><a href="frmValidarNombresCont.php">Volver</a></td>
  </tr>
  <tr>
    <td class="ASTERISCO">VER. 2</td>
  </tr>
</table>
</body>
</html><?php require '../Conexion_BD/Cerrar_Dbms.php';
if($CONT==0){
	echo"<script> alert('No Existe Gestiones Habilitados.');</script>";
//	echo"<script> location.href='frmDuplicadoComprobante.php';</script>";
	}?>