<?php require_once('../Control_Sesiones_Forms/frmControlSesionUsuario.php');
require_once('../Control_Sesiones_Forms/Loading.php'); require '../Conexion_BD/Dbms.php';
$_SESSION['COD_ASOCIACION']=$COD_ASOCIACION;
$_SESSION['ASOCIACION']=$ASOCIACION;?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel='StyleSheet' href='../Css_Formularios/frmProcesos.css' type="text/css">
<link rel="stylesheet" href="../CssTablas/Css/bootstrap.min.css">
<link rel="stylesheet" href="../CssTablas/Css/dataTables.bootstrap.min.css">
<script src="../CssTablas/Js/jquery-3.3.1.js"></script>
<script src="../CssTablas/Js/jquery.dataTables.min.js"></script> 
<script src="../CssTablas/Js/dataTables.bootstrap.min.js"></script>
</head>
<body>
<table width="100%" border="0">
  <tr>
    <td align="center" class="TITULO">&nbsp;</td>
    <td align="center" class="TITULO">&nbsp;</td>
    <td align="center" class="TITULO">REIMPRESION DE COMPROBANTES GENERADOS</td>
  </tr>
  <tr>
    <td align="center" class="SUBTITULO">&nbsp;</td>
    <td align="center" class="SUBTITULO">&nbsp;</td>
    <td align="center" class="SUBTITULO">ASOCIACION SELECCIONADA</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td style="font-weight: bold">&nbsp;</td>
    <td style="font-weight: bold">&nbsp;</td>
    <td style="font-weight: bold">Asociación Seleccionada.</td>
  </tr>
  <tr>
    <td style="font-weight: bold">&nbsp;</td>
    <td style="font-weight: bold">&nbsp;</td>
    <td style="font-weight: bold"><img src="../Img/Linea_Negra.png" width="1070" height="2" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><table width="100%" border="0" cellspacing="3" bordercolor="#FFFFFF">
      <tr>
        <td width="28%" height="32" align="right" bgcolor="#CCCCCC">Asociación Seleccionada :</td>
        <td width="72%" style="font-weight: bold"><?php $result=mysql_query("select * from reg_asociacion where CODIGO_ASOCIACION='$COD_ASOCIACION' and ESTADO='ACTIVO'"); while($row=mysql_fetch_array($result)){ ?><?php echo utf8_decode($row['DESCRIPCION']);}?>
          <input name="COD_ASOCIACION" type="hidden" id="COD_ASOCIACION" value="<?php echo $COD_ASOCIACION;?>" />
          <input name="ASOCIACION" type="hidden" id="ASOCIACION" value="<?php echo $ASOCIACION;?>" />
          <input name="REG" type="hidden" id="REG" value="1" /></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC"><img src="../Img/Blanco.png" width="300" height="1" /></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="35" align="right" bgcolor="#CCCCCC">Zona Tributaria :</td>
        <td><span style="font-weight: bold">
          <?php $liqui=mysql_query("select ZT.DESCRIPCION from zona_tributaria ZT,reg_asociacion_zona_tributaria RAZT where RAZT.CODIGO_ASOCIACION='$COD_ASOCIACION' and RAZT.CODIGO_ZONA=ZT.CODIGO_ZONA and RAZT.ESTADO='ACTIVO' and ZT.ESTADO='ACTIVO'");while($rowt=mysql_fetch_array($liqui)){ echo $rowt[0];  } ?>
        </span></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
    <td align="left"><img src="../Img/Blanco.png" width="800" height="1" /></td>
  </tr>
  <tr>
    <td align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
    <td align="left"><span style="font-weight: bold">RESULTADOS ENCONTRADOS.</span></td>
  </tr>
  <tr>
    <td align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
    <td align="left"><span style="font-weight: bold"><img src="../Img/Linea_Negra.png" width="1070" height="2" /></span></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><table id="example" class="table table-striped table-bordered" style="width:100%;">
      <thead>
        <tr>
          <td height="27" align="center" bgcolor="#CCCCCC" style="font-weight: bold">No.</td>
          <td align="center" bgcolor="#CCCCCC" style="font-weight: bold">FECHA Y HORA</td>
          <td align="center" bgcolor="#CCCCCC" style="font-weight: bold">USUARIO</td>
          <td align="center" bgcolor="#CCCCCC" style="font-weight: bold">DESCRIPCION</td>
          <td align="center" style="font-weight: bold">ORIGINAL</td>
          </tr>
      </thead>
      <tbody>
        <?php $result=mysql_query("select DISTINCT CODIGO_REGISTRO,FECHA,HORA,USUARIO,NOMBRE_USUARIO,GLOSA_DESCRIPCION_1 from reg_contribuyente_asociacion_pago where CODIGO_ASOCIACION='$COD_ASOCIACION' and ESTADO='ACTIVO' "); while($row=mysql_fetch_array($result)){ ?>
        <tr>
          <td valign="middle"><?php $CONT++; echo $CONT; ?></td>
          <td valign="middle"><?php echo $row['1'].' Hrs. '.$row['2']; ?></td>
          <td valign="middle"><?php echo $row['3'].' - '.$row['4']; ?></td>
          <td valign="middle"><?php echo $row['5']; ?></td>
          <td align="center" style="font-weight: bold"><a href="tcpdf/Reproduccion/frmOriginalComprobanteReimpresion.php?COD_ASOCIACION=<?php echo $COD_ASOCIACION;?>&COD_REGISTRO=<?php echo $row['0'];?>" title="GENERAR COMRPOBANTE DE PAGO ORIGINAL" target="_new"><img src="../Img/compago.png" width="81" height="50" /></a></td>
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
    <td align="center">&nbsp;</td>
    <td align="center"><a href="frmReimpComrobantePago.php">Volver</a></td>
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
<?php include '../CssTablas/frmPieTabla.php'?>
</body>
</html><?php  if($CONT==0){echo "<script>alert('No Se encontraron registros para la Asociacion Seleccionada.')</script>";}   require '../Conexion_BD/Cerrar_Dbms.php';?>