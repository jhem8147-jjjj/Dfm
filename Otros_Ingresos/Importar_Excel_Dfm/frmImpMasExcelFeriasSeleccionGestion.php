<?php require_once('../Control_Sesiones_Forms/frmControlSesionUsuario.php');
require_once('../Control_Sesiones_Forms/Loading.php');
require '../Conexion_BD/Dbms.php';
function importarFeriasSelectionValue($name)
{
    foreach (array($_POST, $_GET) as $source) {
        if (isset($source[$name]) && is_scalar($source[$name])) {
            return (string)$source[$name];
        }
    }
    return '';
}
$COD_ASOCIACION = importarFeriasSelectionValue('COD_ASOCIACION');
$DOCUMENTOASOC = importarFeriasSelectionValue('DOCUMENTOASOC');
$ASOCIACION = importarFeriasSelectionValue('ASOCIACION');
if($COD_ASOCIACION==='' || $DOCUMENTOASOC==='' || $ASOCIACION===''){
echo "<script>alert('No se recibieron los datos de la asociación. Vuelva a seleccionarla.')</script>";
echo"<script> location.href='frmImpMasAsocFerias.php';</script>";
exit;
}
$COD_ASOCIACION_SQL = mysql_real_escape_string($COD_ASOCIACION);
$_SESSION['COD_ASOCIACION']=$COD_ASOCIACION;
$_SESSION['DOCUMENTOASOC']=$DOCUMENTOASOC;
$_SESSION['ASOCIACION']=$ASOCIACION;
$SWSEC=0;
// VERIFICA DATOS DEL SECRETARIO GENERAL
$GESTION_SEC=date('Y')-1;
$resultY=mysql_query("select * from reg_secretario_general_asociacion RSG where RSG.CODIGO_ASOCIACION='$COD_ASOCIACION_SQL' and RSG.GESTION='$GESTION_SEC' and RSG.ESTADO='ACTIVO'") or die("No se pudo verificar el secretario general: " . mysql_error()); while($rowY=mysql_fetch_array($resultY)){ $SWSEC=1; }

if($SWSEC==0){echo "<script>alert('LA ASOCIACION SELECCIONADA NO TIENE DATOS ACTUALIZADOS DEL \\n SECRETARIO GENERAL PARA LA GESTION $GESTION_SEC.')</script>";
echo"<script> location.href='frmImpMasAsocFerias.php';</script>";
exit;
}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel='StyleSheet' href='../Css_Formularios/frmProcesos.css' type="text/css">
</head>
<form  method="post" action='frmImpMasExcelFerias.php' enctype="multipart/form-data">
<body>
<table width="100%" border="0">
  <tr>
    <td align="center" class="TITULO">&nbsp;</td>
    <td align="center" class="TITULO">&nbsp;</td>
    <td align="center" class="TITULO">IMPORTACION MASIVA FERIAS Y MERCADOS</td>
  </tr>
  <tr>
    <td align="center" class="SUBTITULO">&nbsp;</td>
    <td align="center" class="SUBTITULO">&nbsp;</td>
    <td align="center" class="SUBTITULO">Seleccionar Archivo</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td style="font-weight: bold">&nbsp;</td>
    <td style="font-weight: bold">&nbsp;</td>
    <td style="font-weight: bold">Seleccione Archivo Excel. </td>
  </tr>
  <tr>
    <td style="font-weight: bold">&nbsp;</td>
    <td style="font-weight: bold">&nbsp;</td>
    <td style="font-weight: bold"><img src="../Img/Linea_Negra.png" width="1070" height="2" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><table width="100%" border="0" bordercolor="#FFFFFF">
      <tr>
        <td height="32" align="right" bgcolor="#CCCCCC">Documento de Registro :</td>
        <td style="font-weight: bold"><?php echo htmlspecialchars($DOCUMENTOASOC, ENT_QUOTES, 'UTF-8');?></td>
      </tr>
      <tr>
        <td width="33%" height="32" align="right" bgcolor="#CCCCCC">Asociación Seleccionada :</td>
        <td width="67%" style="font-weight: bold"><?php $result=mysql_query("select * from reg_asociacion where CODIGO_ASOCIACION='$COD_ASOCIACION' and ESTADO='ACTIVO'"); while($row=mysql_fetch_array($result)){ ?><?php echo utf8_decode($row['DESCRIPCION']);}?>
          <input name="COD_ASOCIACION" type="hidden" id="COD_ASOCIACION" value="<?php echo htmlspecialchars($COD_ASOCIACION, ENT_QUOTES, 'UTF-8');?>" />
          <input name="DOCUMENTOASOC" type="hidden" id="DOCUMENTOASOC" value="<?php echo htmlspecialchars($DOCUMENTOASOC, ENT_QUOTES, 'UTF-8');?>" />
          <input name="ASOCIACION" type="hidden" id="ASOCIACION" value="<?php echo htmlspecialchars($ASOCIACION, ENT_QUOTES, 'UTF-8');?>" />
          <input name="REG" type="hidden" id="REG" value="1" /></td>
      </tr>
      <tr>
        <td height="35" align="right" bgcolor="#CCCCCC">Zona Tributaria :</td>
        <td><span style="font-weight: bold">
          <?php $liqui=mysql_query("select ZT.DESCRIPCION from zona_tributaria ZT,reg_asociacion_zona_tributaria RAZT where RAZT.CODIGO_ASOCIACION='$COD_ASOCIACION' and RAZT.CODIGO_ZONA=ZT.CODIGO_ZONA and RAZT.ESTADO='ACTIVO' and ZT.ESTADO='ACTIVO'");while($rowt=mysql_fetch_array($liqui)){ echo $rowt[0];  } ?>
        </span></td>
      </tr>
      <tr>
        <td height="35" align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span> Seleccionar Gestión :</td>
        <td><select name="sltGestion" id="sltGestion">
          <?php $ANIO=date('Y')-1;$liq=mysql_query("select * from fechas_vencimiento where  ESTADO='ACTIVO' order by GESTION_COBRO");while($row=mysql_fetch_array($liq)){ $SW1=1;?>
                        <option select><?php echo $row['GESTION_COBRO'];?></option>
            <?PHP }?>
        </select> 
          <span class="comentario">Se importara datos a la Gestión Seleccionada.</span></td>
      </tr>
      <tr>
        <td align="right"><img src="../Img/Blanco.png" width="350" height="1" /></td>
        <td class="comentario">&nbsp;</td>
      </tr>
      <tr>
        <td align="right">&nbsp;</td>
        <td><input type="submit" name="button" id="button" value="Aceptar" style="width:250px; height:35px"  /></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center"><a href="frmImpMasAsocFerias.php">Volver</a></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="ASTERISCO">&nbsp;</td>
    <td class="ASTERISCO">&nbsp;</td>
    <td class="ASTERISCO">VER. 1</td>
  </tr>
</table>
</body></form>
</html><?php  if($SW1==0){echo "<script>alert('No se encontró gestión habilitada para cobro de Impuesto Eventual.')</script>";echo"<script> location.href='frmImpMasAsocFerias.php';</script>";} require '../Conexion_BD/Cerrar_Dbms.php';?>