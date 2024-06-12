<?php require_once('../Control_Sesiones_Forms/frmControlSesionUsuario.php');
require_once('../Control_Sesiones_Forms/Loading.php'); require '../Conexion_BD/Dbms.php';
$_SESSION['COD_ASOCIACION']=$COD_ASOCIACION;
$_SESSION['ASOCIACION']=utf8_decode($ASOCIACION);
$_SESSION['ORDENANZA_MUNICIPAL']=utf8_decode($ORDENANZA_MUNICIPAL); ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel='StyleSheet' href='../Css_Formularios/frmProcesos.css' type="text/css">
</head>
<body>
<table width="50%" border="0">
  <tr>
    <td align="center" class="TITULO">COMPROBANTE DE PAGO</td>
  </tr>
  <tr>
    <td align="center" class="SUBTITULO">Emisión de Comprobante de Pago Asociación Anual</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td style="font-weight: bold">Datos de Asociación.</td>
  </tr>
  <tr>
    <td><img src="../Img/Linea.png" width="843" height="4" />
      <table width="100%" border="0">
      <tr>
        <td height="20" align="right" bgcolor="#CCCCCC">Documento de Registro :</td>
        <td style="font-weight: bold"><?php echo $ORDENANZA_MUNICIPAL;?></td>
      </tr>
      <tr>
        <td height="21" align="right" bgcolor="#CCCCCC">Asociación Seleccionada :</td>
        <td style="font-weight: bold"><?php echo utf8_decode($ASOCIACION);?>
          <input name="txtSw" type="hidden" id="txtSw" value="1" /></td>
      </tr>
      <tr>
        <td width="36%" height="21" align="right" bgcolor="#CCCCCC">Zona Tributaria :</td>
        <td width="64%" style="font-weight: bold"><?php $liqui=mysql_query("select ZT.DESCRIPCION,ZT.CODIGO_ZONA from zona_tributaria ZT,reg_asociacion_zona_tributaria RAZT where RAZT.CODIGO_ASOCIACION='$COD_ASOCIACION' and RAZT.CODIGO_ZONA=ZT.CODIGO_ZONA and RAZT.ESTADO='ACTIVO' and ZT.ESTADO='ACTIVO'");while($rowt=mysql_fetch_array($liqui)){ echo $rowt[0];  $CODIGO_ZONA_TRIB=$rowt[1];} ?></td>
      </tr>
      <tr><td align="left" style="font-weight: bold"><img src="../Img/Blanco.png" width="300" height="2" /></td>
        <td align="left" style="font-weight: bold">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" align="left" style="font-weight: bold">Datos de Autorización de Impresión de Comprobante de Pago.</td>
        </tr>
      <tr>
        <td colspan="2" align="right"><img src="../Img/Linea.png" width="843" height="4" /></td>
      </tr>
      <tr>
        <td colspan="2" align="right"><table width="100%" border="0" cellspacing="3" cellpadding="2">
          <tr>
            <td height="33" align="center" bgcolor="#CCCCCC" style="font-weight: bold">No.</td>
            <td align="center" bgcolor="#CCCCCC" style="font-weight: bold">FECHA Y HORA</td>
            <td align="center" bgcolor="#CCCCCC" style="font-weight: bold">USUARIO</td>
            <td align="center" bgcolor="#CCCCCC" style="font-weight: bold">COMUNICACION INTERNA</td>
            <td align="center" bgcolor="#CCCCCC" style="font-weight: bold">GESTION</td>
            <td align="center" >&nbsp;</td>
          </tr>
          <?php $res=mysql_query("select DISTINCT CODIGO_REGISTRO,USUARIO,NOMBRE_USUARIO,FECHA,HORA,GESTION,COMUNICACION_INTERNA  from reg_contribuyente_habilitado_pago where CODIGO_ASOCIACION='$COD_ASOCIACION' and ESTADO_REGISTRO='REGISTRO VALIDADO.' and ESTADO='ACTIVO' and ESTADO_ORDEN_PAGO='VALORES DE LIQUIDACION VALIDADOS' and ESTADO_PAGO='NO PAGO' order by GESTION");while($row=mysql_fetch_array($res)){ $SW2=1;?>
          <tr>
            <td bgcolor="#E3F0F2"><?php $cont++; echo $cont;?></td>
            <td bgcolor="#E3F0F2"><?php echo $row['3'].' Hrs. '.$row['4'];?></td>
            <td bgcolor="#E3F0F2"><?php echo $row['1'].' - '.$row['2'];?></td>
            <td bgcolor="#E3F0F2"><?php echo $row['6'];?></td>
            <td bgcolor="#E3F0F2"><?php echo $row['5'];?></td>
            <td><a href="frmComprobantePagoDatosCont.php?COM_INTERNA=<?php echo $row['6'];?>&VERIFICAR=1&sltGestion=<?php echo $row['5'];?>&CODIGOREGISTRO=<?php echo $row['0'];?>">Seleccionar</a></td>
          </tr>
          <?php } ?>
        </table></td>
        </tr>
      <tr>
        <td align="right"><img src="../Img/Blanco.png" width="300" height="6" /></td>
        <td class="comentario">&nbsp;</td>
      </tr>
  </table></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center"><a href="frmComprobantePago.php">Volver</a></td>
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
if($SW2==0){
	echo"<script> alert('No Existe Gestiones Habilitados.');</script>";
	echo"<script> location.href='frmComprobantePago.php';</script>";
	}
if($VERIFICAR==1){if($SWV==0){ echo"<script> alert('No Existe Cotribuyentes Habilitados y/o Validados Correctamente.');</script>";
	echo"<script> location.href='frmComprobantePago.php';</script>";}}
	?>