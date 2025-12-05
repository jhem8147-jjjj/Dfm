<?php require_once('../Control_Sesiones_Forms/frmControlSesionUsuario.php');
require_once('../Control_Sesiones_Forms/Loading.php');
require '../Conexion_BD/Dbms.php';
$_SESSION['CODIGOREGISTRO'] = $CODIGOREGISTRO;
$_SESSION['sltGestion'] = $sltGestion;
if (empty($_SESSION['COD_ASOCIACION'])) {
  include_once("Index.php");
} else {
  $_SESSION['COD_ASOCIACION'] = $COD_ASOCIACION;
}
if (empty($_SESSION['ASOCIACION'])) {
  include_once("Index.php");
} else {
  $_SESSION['ASOCIACION'] = $ASOCIACION;
}
if (empty($_SESSION['OMS'])) {
  include_once("Index.php");
} else {
  $_SESSION['OMS'] = $OMS;
}
if (empty($_SESSION['CODIGOREGISTRO'])) {
  include_once("Index.php");
} else {
  $_SESSION['CODIGOREGISTRO'] = $CODIGOREGISTRO;
}
if (empty($_SESSION['sltGestion'])) {
  include_once("Index.php");
} else {
  $_SESSION['sltGestion'] = $sltGestion;
}
if (empty($_SESSION['COD_REGISTRO'])) {
  include_once("Index.php");
} else {
  $_SESSION['COD_REGISTRO'] = $COD_REGISTRO;
}
$cont = 0;
$conts = 0;
if ($hdfRegistro == 1) {
  //registra en reg_parametros_orden_pago
  $sql1 = "insert into reg_parametros_orden_pago(PC_NAME,PC_IP,USUARIO,NOMBRE_USUARIO,FECHA,HORA,CODIGO_REGISTRO,CODIGO_ASOCIACION,ASOCIACION,GESTION,TIPO_PUESTO,IMPE,MANT_VALOR,MIDF,INTERES,OTRAS_MULTAS,FORMULARIO,OBSERVACIONES)values('$hostname','$hostlocal','$US_SIOI','$SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO','$FECHA','$HORA','$COD_REGISTRO','$COD_ASOCIACION','$ASOCIACION','$sltGestion','$sltTipoActividad','$txtImpe','$txtMv','$txtMidf','$txtInteres','$txtOtrasMultas','$txtFormulario','$txtObservacion')";
  $result = mysql_query($sql1) or die("NO SE PUDO REGISTRAR EN LA ENTIDAD reg_parametros_orden_pago PUESTO DE VENTA.");
  //actualiza los campos MULTAS EN LA TABLA reg_contribuyente_habilitado_pago
  $query = mysql_query("UPDATE reg_contribuyente_habilitado_pago  SET MANT_VALOR='$txtMv',MIDF='$txtMidf',INTERES='$txtInteres',OTRAS_MULTAS='$txtOtrasMultas',FORMULARIO='$txtFormulario',ESTADO_ORDEN_PAGO='VALORES DE LIQUIDACION VALIDADOS',OBSERVACIONES='$txtObservacion' where CODIGO_REGISTRO='$CODIGOREGISTRO' and TIPO_VENTA='$sltTipoActividad' and CODIGO_ASOCIACION='$COD_ASOCIACION' and GESTION='$sltGestion' and ESTADO_PAGO='NO PAGO' and ESTADO_REGISTRO='REGISTRO VALIDADO.' and ESTADO='ACTIVO'") or die("NO SE PUDO ACTUALIZAR LOS DATOS DEL reg_parametros_orden_pago.");
  /*REGISTRA LA TRANSACCION*/
  $sql1 = "insert into reg_contribuyente_transacciones(PC_NAME,PC_IP,USUARIO,NOMBRE_USUARIO,FECHA,HORA,CODIGO_REGISTRO,CODIGO_ASOCIACION,ASOCIACION,TRANSACCION_1,DESCRIPCION_TRAMITE,OBSERVACIONES,ENLACE)values('$hostname','$hostlocal','$US_SIOI','$SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO','$FECHA','$HORA','$COD_REGISTRO','$COD_ASOCIACION','$ASOCIACION','VALIDACION DE IMPUESTO EVENTUAL Y ACCESORIOS DE LEY','VALIDACION DE IMPUESTO EVENTUAL Y ACCESORIOS DE LEY, TIPO DE ACTIVIDAD: $sltTipoActividad, GESTION: $sltGestion','VALIDACION DE IMPUESTO EVENTUAL Y ACCESORIOS DE LEY, TIPO DE ACTIVIDAD: $sltTipoActividad, GESTION: $sltGestion.','0')";
  $result = mysql_query($sql1) or die("NO SE PUDO REGISTRAR EN LA ENTIDAD reg_contribuyente_transacciones.");
  echo "<script>alert('Se registro las MULTAS para EL TIPO DE ACTIVIDAD Seleccionada.')</script>";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel='StyleSheet' href='../Css_Formularios/frmProcesos.css' type="text/css">
</head>

<body>
  <table width="100%" border="0" align="left">
    <tr>
      <td align="center" class="TITULO">PROFORMA DE DEUDA</td>
    </tr>
    <tr>
      <td align="center" class="SUBTITULO">Emisión de Proforma de Deuda</td>
    </tr>
    <tr>
      <td align="center" class="SUBTITULO">CARGADO DE MULTAS</td>
    </tr>
    <tr>
      <td><span style="font-weight: bold">DATOS DE ASOCIACION.</span></td>
    </tr>
    <tr>
      <td style="font-weight: bold"><img src="../Img/Linea_Negra.png" width="1000" height="2" /></td>
    </tr>
    <tr>
      <td>
        <table width="100%" border="0" cellpadding="1" cellspacing="1" bordercolor="#FFFFFF">
          <tr>
            <td height="32" align="right" bgcolor="#CCCCCC">Documento de Registro :</td>
            <td style="font-weight: bold"><?php echo $OMS; ?></td>
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
            <td align="right" bgcolor="#CCCCCC">Gestión de Liquidación :</td>
            <td style="font-weight: bold; font-size: 14px;"><?php echo $sltGestion; ?></td>
          </tr>
          <tr>
            <td align="right"><img src="../Img/Blanco.png" width="300" height="1" /></td>
            <td>&nbsp;</td>
          </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td align="left" style="font-weight: bold">Datos de Liquidación(ES RESPONSABILIDAD DEL OPERADOR EL CARGADO Y LA VERIFICACION DE MULTAS).</td>
    </tr>
    <tr>
      <td align="left" style="font-weight: bold"><img src="../Img/Linea_Negra.png" width="1000" height="2" /></td>
    </tr>
    <tr>
      <td align="left" style="font-weight: bold"></td>
    </tr>
    <tr>
      <td align="center" style="font-weight: bold">
        <table width="100%" border="0" cellspacing="1" cellpadding="1">
          <tr>
            <td rowspan="3" align="center" bgcolor="#CCCCCC">No.</td>
            <td rowspan="3" align="center" bgcolor="#CCCCCC">GESTIÓN</td>
            <td rowspan="3" align="center" bgcolor="#CCCCCC">COMUNICACIÓN INTENA</td>
            <td rowspan="3" align="center" bgcolor="#CCCCCC">TIPO DE ACTIVIDAD</td>
            <td rowspan="2" align="center" bgcolor="#CCCCCC">
              <p>IMPUESTO ANUAL</p>
            </td>
            <td height="24" colspan="4" align="center" bgcolor="#CCCCCC">MULTAS</td>
            <td rowspan="2" align="center" bgcolor="#CCCCCC">FORMULARIO</td>
            <td rowspan="3" align="center" bgcolor="#CCCCCC">CANTIDAD</td>
            <td align="center">&nbsp;</td>
          </tr>
          <tr>
            <td height="24" align="center" bgcolor="#CCCCCC">MANT. UFV</td>
            <td align="center" bgcolor="#CCCCCC">MIDF</td>
            <td align="center" bgcolor="#CCCCCC">INTERES</td>
            <td align="center" bgcolor="#CCCCCC">OTRAS MULTAS</td>
            <td align="center">&nbsp;</td>
          </tr>
          <tr>
            <td height="22" align="center" bgcolor="#CCCCCC">Bs.-</td>
            <td align="center" bgcolor="#CCCCCC">Bs.-</td>
            <td align="center" bgcolor="#CCCCCC">Bs.-</td>
            <td align="center" bgcolor="#CCCCCC">Bs.-</td>
            <td align="center" bgcolor="#CCCCCC">Bs.-</td>
            <td align="center" bgcolor="#CCCCCC">Bs.-</td>
            <td align="center">&nbsp;</td>
          </tr>
          <?php $res = mysql_query("
          select DISTINCT CODIGO_REGISTRO,GESTION,COMUNICACION_INTERNA,TIPO_VENTA,MONTO,MANT_VALOR,MIDF,INTERES,OTRAS_MULTAS,FORMULARIO,ESTADO_ORDEN_PAGO  
          from reg_contribuyente_habilitado_pago 
          where CODIGO_REGISTRO='$CODIGOREGISTRO' 
          and CODIGO_ASOCIACION='$COD_ASOCIACION' 
          and GESTION='$sltGestion' and ESTADO='ACTIVO' 
          and ESTADO_REGISTRO='REGISTRO VALIDADO.' order by MONTO");
          while ($row = mysql_fetch_array($res)) { ?>
            <tr>
              <td bgcolor="#E3F0F2"><?php $cont++;
                                    echo $cont; ?></td>
              <td bgcolor="#E3F0F2"><?php echo $row['1']; ?></td>
              <td bgcolor="#E3F0F2"><?php echo $row['2']; ?></td>
              <td bgcolor="#E3F0F2"><?php echo $row['3']; ?></td>
              <td align="center" bgcolor="#E3F0F2" style="font-size: 13px; color: #F00;"><?php echo $row['4']; ?></td>
              <td align="center" bgcolor="#E3F0F2"><?php echo $row['5']; ?></td>
              <td align="center" bgcolor="#E3F0F2"><?php echo $row['6']; ?></td>
              <td align="center" bgcolor="#E3F0F2"><?php echo $row['7']; ?></td>
              <td align="center" bgcolor="#E3F0F2"><?php echo $row['8']; ?></td>
              <td align="center" bgcolor="#E3F0F2"><?php echo $row['9']; ?></td>
              <td bgcolor="#E3F0F2">
                <?PHP $rest = mysql_query("select COUNT(*) from reg_contribuyente_habilitado_pago 
                                            where CODIGO_REGISTRO='$CODIGOREGISTRO' 
                                            and TIPO_VENTA='$row[3]' and CODIGO_ASOCIACION='$COD_ASOCIACION' and GESTION='$sltGestion' and ESTADO='ACTIVO' and ESTADO_REGISTRO='REGISTRO VALIDADO.'");
                                    while ($rowt = mysql_fetch_array($rest)) {
                                      echo '( ' . $rowt[0] . ' ) REGISTROS.';
                                    } ?></td>
              <td><a href="frmProformaDatosLiq.php?Formulario=<?php echo $row[9]; ?>&ImpAnual=<?php echo $row[4]; ?>&txtTipoActividad=<?php echo $row[3]; ?>&sltGestion=<?php echo $sltGestion; ?>&CODIGOREGISTRO=<?php echo $row['0']; ?>"><?php if ($row[10] == 'NO VALIDADO') { ?>Seleccionar<?php } else {
                                                                                                                                                                                                                                                                                      $conts++;
                                                                                                                                                                                                                                                                                      echo "Actualizar Multas";
                                                                                                                                                                                                                                                                                    } ?></a></td>
            </tr><?php }
                if ($conts == $cont) { ?>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td align="center" style="font-size: 13px; color: #F00;">&nbsp;</td>
              <td align="center">&nbsp;</td>
              <td align="center">&nbsp;</td>
              <td align="center">&nbsp;</td>
              <td align="center">&nbsp;</td>
              <td align="center">&nbsp;</td>
              <td>&nbsp;</td>
              <td>
                <form method="post" action="frmProformaAsociacion.php"><input type="submit" name="button" id="button" value="Continuar" style="width:100px; height:35px" /></form>
              </td>
            </tr><?php } ?>

        </table>
      </td>
    </tr>
    <tr>
      <td align="center">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" class="ASTERISCO">* NOTIFICACION.</td>
    </tr>
    <?php $ANIOVEN = date('Y') - 1;
    if ($sltGestion < $ANIOVEN) { ?><tr>
        <td align="left" class="SUBTITULO">
          <ul>
            <li><span class="TITULO">CORRESPONDE CARGAR MULTAS DE ACUERDO A NORMATIVAS A LA GESTION VENCIDA: <?php echo $sltGestion; ?>.</span></li>
          </ul>
        </td>
      </tr><?php } ?>
    <?php $ANIOVEN = date('Y') - 1;
    if ($sltGestion == $ANIOVEN) { ?><tr>
        <td align="left" class="SUBTITULO">
          <ul>
            <li><span class="TITULO">NO CORRESPONDE CARGAR MULTAS A LA GESTION: <?php echo $sltGestion; ?>.</span></li>
          </ul>
        </td>
      </tr><?php } ?>
    <tr>
      <td align="center">&nbsp;</td>
    </tr>
    <tr>
      <td align="center"><a href="frmProformaDatosAsoc.php">Volver</a></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
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
        if ($cont == 0) {
          echo "<script>alert('No se encontraron registros Validados para la Asociacion Seleccionada.')</script>";
          echo "<script> location.href='frmProforma.php';</script>";
        }
        ?>