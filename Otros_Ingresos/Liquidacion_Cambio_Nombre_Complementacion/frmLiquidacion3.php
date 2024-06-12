<?php require_once('../Control_Sesiones_Forms/frmControlSesionUsuario.php');
require_once('../Control_Sesiones_Forms/Loading.php');
require '../Conexion_BD/Dbms.php';
$_SESSION['txtDepositoCn'] = $txtDepositoCn;
$_SESSION['txtBancoCn'] = $txtBancoCn;
$_SESSION['txtDepositoCC'] = $txtDepositoCC;
$_SESSION['txtBancoCc'] = $txtBancoCc;
$cont = 0;
$VALORES = "";
//ACTUALIZA LOS MONTOS A PAGAR
$COD_REGISTRO = date('Ymd His') . rand(100, 1000);
if ($CN == 1) {
  $VALORES = "CN";
  $query = mysql_query("UPDATE reg_contribuyente_habilitado_pago_cambio_nombre  SET MONTO='$txtMontoCn',MULTA='$txtMultaCn',FORMULARIO='$txtFormularioCN',ESTADO_ORDEN_PAGO='GENERADO',OBSERVACIONES='MONTO=$txtMontoCn Bs.-, MULTA=$txtMultaCn Bs.-, FORMULARIO=$txtFormularioCN Bs.- ACTUALIZADOS POR: $US_SIOI - $SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO, FECHA: $FECHA Hrs.: $HORA' where CODIGO_REGISTRO='$CODIGOREGISTRO' and ESTADO_COMUNICACION_INTERNA='GENERADO' and CODIGO_ASOCIACION='$COD_ASOCIACION' and ESTADO='ACTIVO' and ESTADO_PAGO='NO PAGO'") or die("NO SE PUDO ACTUALIZAR LOS DATOS DEL reg_parametros_orden_pago.");
  //REGISTRA EN LA TABLA TRANSACCIONES
  $sql1 = "insert into reg_contribuyente_transacciones(PC_NAME,PC_IP,USUARIO,NOMBRE_USUARIO,FECHA,HORA,CODIGO_REGISTRO,CODIGO_ASOCIACION,ASOCIACION,TRANSACCION_1,DESCRIPCION_TRAMITE,OBSERVACIONES,ENLACE)values('$hostname','$hostlocal','$US_SIOI','$SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO','$FECHA','$HORA','$COD_REGISTRO','$COD_ASOCIACION','$ASOCIACION','CAMBIO DE NOMBRE','ACTUALIZACION DE MONTOS A COBRAR POR CONCEPTO DE CAMBIO DE NOMBRE INDIVIDUAL','ACTUALIZACION DE MONTOS A COBRAR: MONTO=$txtMontoCn Bs.-, MULTA=$txtMultaCn Bs.-, FORMULARIO=$txtFormularioCN Bs.- ','0')";
  $result = mysql_query($sql1) or die("NO SE PUDO REGISTRAR EN LA ENTIDAD reg_contribuyente_transacciones.");
}
//ACTUALIZA MONTOS PARA COMPLEMENTO DE CONTRIBUYENTES
if ($CC == 1) {
  $VALORES = "CC";
  $query = mysql_query("UPDATE reg_contribuyente_habilitado_pago_complementacion  SET MONTO='$txtMontoCC',MULTA='$txtMultaCC',FORMULARIO='$txtFormularioCC',ESTADO_ORDEN_PAGO='GENERADO',OBSERVACIONES='MONTO=$txtMontoCC Bs.-, MULTA=$txtMultaCC Bs.-, FORMULARIO=$txtFormularioCC Bs.- ACTUALIZADOS POR: $US_SIOI - $SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO, FECHA: $FECHA Hrs.: $HORA' where CODIGO_REGISTRO='$CODIGOREGISTRO' and ESTADO_COMUNICACION_INTERNA='GENERADO' and CODIGO_ASOCIACION='$COD_ASOCIACION' and ESTADO='ACTIVO' and ESTADO_PAGO='NO PAGO'") or die("NO SE PUDO ACTUALIZAR LOS DATOS DEL reg_parametros_orden_pago.");
  //REGISTRA EN LA TABLA TRANSACCIONES
  $sql1 = "insert into reg_contribuyente_transacciones(PC_NAME,PC_IP,USUARIO,NOMBRE_USUARIO,FECHA,HORA,CODIGO_REGISTRO,CODIGO_ASOCIACION,ASOCIACION,TRANSACCION_1,DESCRIPCION_TRAMITE,OBSERVACIONES,ENLACE)values('$hostname','$hostlocal','$US_SIOI','$SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO','$FECHA','$HORA','$COD_REGISTRO','$COD_ASOCIACION','$ASOCIACION','COMPLEMENTACION DE PUESTO DE VENTA','ACTUALIZACION DE MONTOS A COBRAR POR CONCEPTO DE COMPLEMENTACION DE PUESTOS DE VENTA','ACTUALIZACION DE MONTOS A COBRAR: MONTO=$txtMontoCC Bs.-, MULTA=$txtMultaCC Bs.-, FORMULARIO=$txtFormularioCC Bs.- ','0')";
  $result = mysql_query($sql1) or die("NO SE PUDO REGISTRAR EN LA ENTIDAD reg_contribuyente_transacciones.");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
<form method="post" action='frmLiquidacion4.php'>

  <body>
    <table width="99%" border="0" align="center">
      <tr>
        <td align="center" class="TITULO">LIQUIDACION</td>
      </tr>
      <tr>
        <td align="center" class="SUBTITULO"><span style="font-weight: bold">
            <input name="hdfLiquidacion" type="hidden" id="hdfLiquidacion" value="<?php echo $VALORES; ?>" />
          </span><?php if ($VALORES == 'CC') {
                    echo "COMPLEMENTACION DE PUESTOS DE VENTA";
                  }
                  if ($VALORES == 'CN') {
                    echo "CAMBIO DE NOMBRE";
                  } ?></td>
      </tr>
      <tr>
        <td><span style="font-weight: bold">DATOS DE ASOCIACION.</span></td>
      </tr>
      <tr>
        <td style="font-weight: bold">
          <hr />
        </td>
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
              <td align="right" bgcolor="#CCCCCC">Zona Tributaria :</td>
              <td style="font-weight: bold; font-size: 14px;"><span style="font-weight: bold">
                  <?php $liqui = mysql_query("select ZT.DESCRIPCION,ZT.CODIGO_ZONA from zona_tributaria ZT,reg_asociacion_zona_tributaria RAZT where RAZT.CODIGO_ASOCIACION='$COD_ASOCIACION' and RAZT.CODIGO_ZONA=ZT.CODIGO_ZONA and RAZT.ESTADO='ACTIVO' and ZT.ESTADO='ACTIVO'");
                  while ($rowt = mysql_fetch_array($liqui)) {
                    echo $rowt[0];
                    $CODIGO_ZONA_TRIB = $rowt[1];
                  } ?>
                </span></td>
            </tr>
            <tr>
              <td height="25" align="right" bgcolor="#CCCCCC">Comunicación Interna :</td>
              <td style="font-weight: bold; font-size: 14px;"><?php echo $COM_INT; ?></td>
            </tr>
            <tr>
              <td align="right"><span style="font-weight: bold"><img src="../Img/Linea.png" width="250" height="4" /></span></td>
              <td>&nbsp;</td>
            </tr>
          </table>
        </td>
      </tr>
      <tr>
        <td align="center" style="font-weight: bold">&nbsp;</td>
      </tr><?php if ($CN == 1) { ?>
        <tr>
          <td align="left" style="font-weight: bold; font-size: 13px;"><u>CONTRIBUYENTES HABILITADOS PARA EL PAGO DE CAMBIO DE NOMBRE.</u></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>
            <table cellpadding="2" cellspacing="2" class="table table-striped table-bordered" id="example" style="width:100%;">
              <thead>
                <tr style="font-weight: bold">
                  <td height="38" align="center" bgcolor="#CCCCCC">No.</td>
                  <td align="center" bgcolor="#CCCCCC"> DOCUMENTO</td>
                  <td align="center" bgcolor="#CCCCCC">NOMBRE(S) Y APELLIDO(S)</td>
                  <td align="center" bgcolor="#CCCCCC">TIPO DE CAMBIO DE NOMBRE</td>
                  <td align="center" bgcolor="#CCCCCC">TIPO PUESTO</td>
                  <td align="center" bgcolor="#CCCCCC">FILA</td>
                  <td align="center" bgcolor="#CCCCCC">PUESTO</td>
                  <td align="center" bgcolor="#CCCCCC">MONTO</td>
                  <td align="center" bgcolor="#CCCCCC">MULTA</td>
                  <td align="center" bgcolor="#CCCCCC">FORMULARIO</td>
                  <td align="center" bgcolor="#CCCCCC">TOTAL Bs.-</td>
                </tr>
              </thead>
              <tbody>
                <?php

                $res = mysql_query("select  CONTRI.TIPO_DOCUMENTO,CONTRI.DOC_IDENTIDAD,CONTRI.DOC_IDENTIDAD_ALFA,CONTRI.EXPEDIDO,CONTRI.NOMBRE_RSOCIAL,CONTRI.PRIMER_APELLIDO,CONTRI.SEGUNDO_APELLIDO,CONTRI.APELLIDO_ESPOSO,CONTRI.CODIGO_CONTRIBUYENTE,CONTRI.REGISTRO,RCN.REGISTRO_GREMIAL,RCN.TIPO_CAMBIO,RCN.TIPO_PUESTO,RCN.FILA,RCN.PUESTO,RCN.MONTO,RCN.MULTA,RCN.FORMULARIO from reg_contribuyente_habilitado_pago_cambio_nombre RCN, contribuyentes CONTRI where RCN.CODIGO_REGISTRO='$CODIGOREGISTRO' and RCN.ESTADO_COMUNICACION_INTERNA='GENERADO' and RCN.CODIGO_ASOCIACION='$COD_ASOCIACION' and RCN.CODIGO_CONTRIBUYENTE_ENTRANTE=CONTRI.CODIGO_CONTRIBUYENTE and RCN.ESTADO='ACTIVO' and CONTRI.ESTADO='ACTIVO' order by CONTRI.REGISTRO,CONTRI.NOMBRE_RSOCIAL,CONTRI.PRIMER_APELLIDO,CONTRI.SEGUNDO_APELLIDO ");
                while ($row = mysql_fetch_array($res)) {
                  $SW2 = 1; ?>
                  <tr>
                    <td><?php $cont++;
                        echo $cont; ?></td>
                    <td><?php if ($row[2] == null) {
                          echo  $row[1] . ' ' . $row[3];
                        } else {
                          echo $row[1] . ' - ' . $row[2] . ' ' . $row[3];
                        } ?></td>
                    <td><?php if ($row[7] == null) {
                          echo $row[4] . ' ' . $row[5] . ' ' . $row[6];
                        } else {
                          echo $row[4] . ' ' . $row[5] . ' ' . $row[6] . ' de ' . $row[7];
                        } ?></td>
                    <td><?php echo $row[11]; ?></td>
                    <td><?php echo $row[12]; ?></td>
                    <td><?php if ($row[13] == null) {
                          echo '-';
                        } else {
                          echo $row[13];
                        } ?></td>
                    <td><?php echo $row[14]; ?></td>
                    <td align="center" style="color: #F00; font-weight: bold; font-size: 12px;"><?php echo $row[15]; ?></td>
                    <td align="center" style="color: #33C; font-weight: bold; font-size: 12px;"><?php echo $row[16]; ?></td>
                    <td align="center" style="color: #090; font-weight: bold; font-size: 12px;"><?php echo $row[17]; ?></td>
                    <td align="center" style="color: #090; font-weight: bold; font-size: 12px;"><?php echo $row[15] + $row[16] + $row[17];
                                                                                                $TOTAL = $TOTAL + $row[15] + $row[16] + $row[17]; ?></td>
                  </tr>
                  <tr> <?php } ?>
                  <td colspan="10" align="right">TOTAL Bs.-</td>
                  <td align="center"><span style="font-size: 14px; font-weight: bold;"><?php echo $TOTAL; ?></span></td>
                  </tr>
                  <tr>
                    <td colspan="10" align="right">&nbsp;</td>
                    <td align="left"><input type="submit" name="btnEnviar1" id="btnEnviar1" value="Continuar" style="width:110px; height:35px"  /></td>
                  </tr>

              </tbody>
            </table>
          </td>
        </tr><?php } ?>
      <tr>
        <td align="right">
        </td>
      </tr>
      <?php if ($CC == 1) { ?>
        <tr>
          <td align="left" style="font-weight: bold; font-size: 13px;"><u>CONTRIBUYENTES HABILITADOS PARA EL PAGO DE COMPLEMENTO DE PUESTOS.</u></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>
            <table cellpadding="2" cellspacing="2" class="table table-striped table-bordered" id="example" style="width:100%;">
              <thead>
                <tr style="font-weight: bold">
                  <td height="33" align="center" bgcolor="#CCCCCC">No.</td>
                  <td align="center" bgcolor="#CCCCCC">Documento</td>
                  <td align="center" bgcolor="#CCCCCC">Nombre(s) y Apellido(s)</td>
                  <td align="center" bgcolor="#CCCCCC">ACTIVIDAD</td>
                  <td align="center" bgcolor="#CCCCCC">FILA</td>
                  <td align="center" bgcolor="#CCCCCC">PUESTO</td>
                  <td align="center" bgcolor="#CCCCCC">MONTO</td>
                  <td align="center" bgcolor="#CCCCCC">MULTA</td>
                  <td align="center" bgcolor="#CCCCCC">FORMULARIO</td>
                  <td align="center" bgcolor="#CCCCCC">TOTAL Bs.-</td>
                </tr>
              </thead>
              <tbody>
                <?php $res = mysql_query("select C.DOC_IDENTIDAD,C.DOC_IDENTIDAD_ALFA,C.EXPEDIDO,C.NOMBRE_RSOCIAL,C.PRIMER_APELLIDO,C.SEGUNDO_APELLIDO,C.APELLIDO_ESPOSO,C.CODIGO_CONTRIBUYENTE,RCHPC.Id,RCHPC.TIPO_VENTA,RCHPC.FILA,RCHPC.PUESTO,RCHPC.MONTO,RCHPC.MULTA,RCHPC.FORMULARIO from reg_contribuyente_habilitado_pago_complementacion RCHPC,contribuyentes C where RCHPC.CODIGO_REGISTRO='$CODIGOREGISTRO' and RCHPC.ESTADO_COMUNICACION_INTERNA='GENERADO'  and RCHPC.CODIGO_ASOCIACION='$COD_ASOCIACION' and RCHPC.ESTADO='ACTIVO' and RCHPC.CODIGO_CONTRIBUYENTE=C.CODIGO_CONTRIBUYENTE and C.ESTADO='ACTIVO'");
                while ($row = mysql_fetch_array($res)) {
                  $SW11 = 0; ?>
                  <tr>
                    <td><?php $cont++;
                        echo $cont; ?></td>
                    <td><?php if ($row['1'] == null) {
                          echo $row['0'] . ' ' . $row['2'];
                        } else {
                          echo $row['0'] . ' - ' . $row['1'] . ' ' . $row['2'];
                        }; ?></td>
                    <td><?php if ($row['6'] == null) {
                          echo $row['3'] . ' ' . $row['4'] . ' ' . $row['5'];
                        } else {
                          echo $row['3'] . ' ' . $row['4'] . ' ' . $row['5'] . ' de ' . $row['6'];
                        } ?></td>
                    <td><?php echo $row['9'];
                        if ($row['9'] == "NO DEFINIDO.") {
                          $SW11 = 1;
                        } else {
                          $SW11 = 0;
                        } ?></td>
                    <td><?php echo $row['10'];
                        if ($row['10'] == "NO DEFINIDO.") {
                          $SW11 = 1;
                        } else {
                          $SW11 = 0;
                        } ?></td>
                    <td><?php echo $row['11'];
                        if ($row['11'] == "NO DEFINIDO.") {
                          $SW11 = 1;
                        } else {
                          $SW11 = 0;
                        } ?></td>
                    <td><?php echo $row[12]; ?></td>
                    <td><?php echo $row[13]; ?></td>
                    <td><?php echo $row[14]; ?></td>
                    <td><?php echo $row[12] + $row[13] + $row[14];
                        $TOTAL = $TOTAL + $row[12] + $row[13] + $row[14]; ?></td>
                  </tr>
                <?php } ?>
                <tr>
                  <td colspan="9" align="right">TOTAL Bs.-</td>
                  <td><span style="font-size: 14px; font-weight: bold;"><?php echo $TOTAL; ?></span></td>
                </tr>
                <tr>
                  <td colspan="9">&nbsp;</td>
                  <td><input type="submit" name="btnEnviar2" id="btnEnviar2" value="Continuar" style="width:110px; height:35px"/></td>
                </tr>
              </tbody>
            </table>
          </td>
        </tr><?php } ?>
      <tr>
        <td align="center"><a href="frmLiquidacion1.php">Volver</a></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
      </tr>
      <tr>
        <td class="ASTERISCO">VER. 3</td>
      </tr>
    </table>
    <?php include '../CssTablas/frmPieTabla.php' ?>
  </body>
</form>

</html><?php require '../Conexion_BD/Cerrar_Dbms.php';
        if ($cont == 0) {
          echo "<script>alert('No se encontraron registros Validados para la Asociacion Seleccionada.')</script>";
          echo "<script> location.href='frmLiquidacion1.php';</script>";
        }
        ?>