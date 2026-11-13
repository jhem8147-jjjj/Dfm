<?php require_once('../Control_Sesiones_Forms/frmControlSesionUsuario.php');
require_once('../Control_Sesiones_Forms/Loading.php');
require '../Conexion_BD/Dbms.php';
unset($_SESSION['COM_INT'], $_SESSION['CODIGOREGISTRO']);
$_SESSION['COD_ASOCIACION'] = $COD_ASOCIACION;
$_SESSION['ASOCIACION'] = $ASOCIACION;
$_SESSION['DOCUMENTOREG'] = $DOCUMENTOREG;
$cont = 0;
$conts = 0;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel='StyleSheet' href='../Css_Formularios/frmProcesos.css' type="text/css">
</head>

<body>
  <table width="10%" border="0" align="left">
    <tr>
      <td align="center" class="TITULO">EMISION DE COMPROBANTE DE PAGO</td>
    </tr>
    <tr>
      <td align="center" class="SUBTITULO">CAMBIO DE NOMBRE Y COMPLEMENTACION</td>
    </tr>
    <tr>
      <td><span style="font-weight: bold">DATOS DE ASOCIACION.</span></td>
    </tr>
    <tr>
      <td style="font-weight: bold"><img src="../Img/Linea.png" width="843" height="4" /></td>
    </tr>
    <tr>
      <td>
        <table width="100%" border="0" cellpadding="1" cellspacing="1" bordercolor="#FFFFFF">
          <tr>
            <td height="32" align="right" bgcolor="#CCCCCC">Documento :</td>
            <td style="font-weight: bold"><?php echo $DOCUMENTOREG; ?></td>
          </tr>
          <tr>
            <td width="28%" height="32" align="right" bgcolor="#CCCCCC">Asociación Seleccionada :</td>
            <td width="72%" style="font-weight: bold"><?php echo utf8_decode($ASOCIACION); ?></td>
          </tr>
          <tr>
            <td height="30" align="right" bgcolor="#CCCCCC">Zona Tributaria :</td>
            <td style="font-weight: bold; font-size: 14px;"><span style="font-weight: bold">
                <?php $liqui = mysql_query("select ZT.DESCRIPCION,ZT.CODIGO_ZONA from zona_tributaria ZT,reg_asociacion_zona_tributaria RAZT where RAZT.CODIGO_ASOCIACION='$COD_ASOCIACION' and RAZT.CODIGO_ZONA=ZT.CODIGO_ZONA and RAZT.ESTADO='ACTIVO' and ZT.ESTADO='ACTIVO'");
                while ($rowt = mysql_fetch_array($liqui)) {
                  echo $rowt[0];
                  $CODIGO_ZONA_TRIB = $rowt[1];
                } ?>
              </span></td>
          </tr>

          <tr>
            <td align="right"><span style="font-weight: bold"><img src="../Img/Linea.png" width="250" height="4" /></span></td>
            <td>&nbsp;</td>
          </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td align="left" style="font-weight: bold">Datos Registrados CAMBIO DE NOMBRE .</td>
    </tr>
    <tr>
      <td align="left" style="font-weight: bold"><img src="../Img/Linea.png" width="843" height="4" /></td>
    </tr>
    <tr>
      <td align="left" style="font-weight: bold"></td>
    </tr>
    <tr>
      <td align="center" style="font-weight: normal">
        <table width="100%" border="0" cellspacing="3" cellpadding="2">
          <tr>
            <td height="33" align="center" bgcolor="#CCCCCC" style="font-weight: bold">No.</td>
            <td align="center" bgcolor="#CCCCCC" style="font-weight: bold">FECHA</td>
            <td align="center" bgcolor="#CCCCCC" style="font-weight: bold">USUARIO</td>
            <td align="center" bgcolor="#CCCCCC" style="font-weight: bold">COMUNICACION INTERNA</td>
            <td align="center" bgcolor="#CCCCCC" style="font-weight: bold">CANTIDAD</td>
            <td align="center">&nbsp;</td>
          </tr><?php $res = mysql_query("select CODIGO_REGISTRO,USUARIO,NOMBRE_USUARIO,FECHA,COMUNICACION_INTERNA,COUNT(*) AS TOTAL from reg_contribuyente_habilitado_pago_cambio_nombre where CODIGO_ASOCIACION='$COD_ASOCIACION' and ESTADO='ACTIVO' and ESTADO_PAGO='NO PAGO' AND ESTADO_COMUNICACION_INTERNA='GENERADO' and ESTADO_ORDEN_PAGO='GENERADO' group by CODIGO_REGISTRO,USUARIO,NOMBRE_USUARIO,FECHA,COMUNICACION_INTERNA");
                while ($row = mysql_fetch_array($res)) { ?>
            <tr>
              <td bgcolor="#F3F3F3"><?php $cont++;
                                    echo $cont; ?></td>
              <td bgcolor="#F3F3F3"><?php echo $row['3']; ?></td>
              <td bgcolor="#F3F3F3"><?php echo $row['1'] . ' - ' . $row['2']; ?></td>
              <td bgcolor="#F3F3F3"><?php echo $row['4']; ?></td>
              <td bgcolor="#F3F3F3"><?php echo '( ' . $row['TOTAL'] . ' ) REGISTROS.'; ?></td>
              <td><a href="frmEmisionCP2.php?CN=1&COM_INT=<?php echo $row['4']; ?>&CODIGOREGISTRO=<?php echo $row['0']; ?>">Seleccionar</a></td>
            </tr><?php }
                if ($cont == 0) { ?>
            <tr>
              <td colspan="5" bgcolor="#F3F3F3"><span style="font-weight: bold">PROFORMAS NO EMITIDOS.</span></td>
              <td>&nbsp;</td>
            </tr><?php } ?>

        </table>
      </td>
    </tr>
    <tr>
      <td align="left" style="font-weight: bold">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" style="font-weight: bold">Datos Registrados COMPLEMENTACION .</td>
    </tr>
    <tr>
      <td align="center"><span style="font-weight: bold"><img src="../Img/Linea.png" width="843" height="4" /></span></td>
    </tr>
    <tr>
      <td align="center">
        <table width="100%" border="0" cellspacing="3" cellpadding="2">
          <tr>
            <td height="33" align="center" bgcolor="#CCCCCC" style="font-weight: bold">No.</td>
            <td align="center" bgcolor="#CCCCCC" style="font-weight: bold">FECHA</td>
            <td align="center" bgcolor="#CCCCCC" style="font-weight: bold">USUARIO</td>
            <td align="center" bgcolor="#CCCCCC" style="font-weight: bold">COMUNICACION INTERNA</td>
            <td align="center" bgcolor="#CCCCCC" style="font-weight: bold">CANTIDAD</td>
            <td align="center">&nbsp;</td>
          </tr>
          <?php $res = mysql_query("select CODIGO_REGISTRO,USUARIO,NOMBRE_USUARIO,FECHA,COMUNICACION_INTERNA,COUNT(*) AS TOTAL from reg_contribuyente_habilitado_pago_complementacion where CODIGO_ASOCIACION='$COD_ASOCIACION' and ESTADO='ACTIVO' and ESTADO_PAGO='NO PAGO' AND ESTADO_COMUNICACION_INTERNA='GENERADO' and ESTADO_ORDEN_PAGO='GENERADO' group by CODIGO_REGISTRO,USUARIO,NOMBRE_USUARIO,FECHA,COMUNICACION_INTERNA");
          while ($row = mysql_fetch_array($res)) { ?>
            <tr>
              <td bgcolor="#F3F3F3"><?php $conts++;
                                    echo $conts; ?></td>
              <td bgcolor="#F3F3F3"><?php echo $row['3']; ?></td>
              <td bgcolor="#F3F3F3"><?php echo $row['1'] . ' - ' . $row['2']; ?></td>
              <td bgcolor="#F3F3F3"><?php echo $row['4']; ?></td>
              <td bgcolor="#F3F3F3"><?php echo '( ' . $row['TOTAL'] . ' ) REGISTROS.'; ?></td>
              <td><a href="frmEmisionCP2.php?CC=1&COM_INT=<?php echo $row['4']; ?>&CODIGOREGISTRO=<?php echo $row['0']; ?>">Seleccionar</a></td>
            </tr> <?php }
                if ($conts == 0) { ?>
            <tr>
              <td colspan="5" bgcolor="#F3F3F3" style="font-weight: bold">PROFORMAS NO EMITIDOS.</td>
              <td>&nbsp;</td>
            </tr><?php } ?>

        </table>
      </td>
    </tr>
    <tr>
      <td align="center">&nbsp;</td>
    </tr>
    <tr>
      <td align="center"><a href="frmEmisionCP.php">Volver</a></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="ASTERISCO">VER. 1</td>
    </tr>
  </table>
</body>

</html><?php require '../Conexion_BD/Cerrar_Dbms.php';
        if ($cont == 0 and $conts == 0) {
          echo "<script>alert('No se emitieron proformas de pago para la Asociacion Seleccionada.')</script>";
          echo "<script> location.href='frmEmisionCP.php';</script>";
        }
        ?>