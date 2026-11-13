<?php header('Content-Type: text/html; charset=utf-8');
require_once('../Control_Sesiones_Forms/frmControlSesionUsuario.php');
require_once('../Control_Sesiones_Forms/Loading.php');
require '../Conexion_BD/Dbms.php';
mysql_set_charset("utf8", $conexion_usuarios) or die("NO SE PUDO CONFIGURAR LA CONEXION UTF-8: " . mysql_error($conexion_usuarios));
$_SESSION['COD_ASOCIACION'] = $COD_ASOCIACION;
$_SESSION['OMS'] = $OMS;
$_SESSION['ASOCIACION'] = $ASOCIACION;
$cont = 0;
unset($_SESSION['CODIGOREGISTRO']);
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
      <td align="center" class="TITULO">DESHABILITAR MASIVAMENTE REGISTROS CARGADOS</td>
    </tr>
    <tr>
      <td align="center" class="SUBTITULO">DESHABILITAR REGISTROS CARGADOS</td>
    </tr>
    <tr>
      <td><span style="font-weight: bold">DATOS DE ASOCIACION.</span></td>
    </tr>
    <tr>
      <td style="font-weight: bold"><img src="../Img/Linea_Negra.png" width="700" height="2" /></td>
    </tr>
    <tr>
      <td>
        <form method="post" action="frmDesimportar1.php">
          <table width="100%" border="0" cellpadding="1" cellspacing="1" bordercolor="#FFFFFF">
            <tr>
              <td height="32" align="right" bgcolor="#CCCCCC">Documento de Registro :</td>
              <td style="font-weight: bold"><?php echo htmlspecialchars(str_replace("Â°", "°", $OMS), ENT_QUOTES, 'UTF-8'); ?></td>
            </tr>
            <tr>
              <td width="28%" height="32" align="right" bgcolor="#CCCCCC">Asociación Seleccionada :</td>
              <td width="72%" style="font-weight: bold"><?php echo htmlspecialchars($ASOCIACION, ENT_QUOTES, 'UTF-8'); ?>
                <input name="COD_ASOCIACION" type="hidden" id="COD_ASOCIACION" value="<?php echo htmlspecialchars($COD_ASOCIACION, ENT_QUOTES, 'UTF-8'); ?>" />
                <input name="ASOCIACION" type="hidden" id="ASOCIACION" value="<?php echo htmlspecialchars($ASOCIACION, ENT_QUOTES, 'UTF-8'); ?>" />
                <input name="REG" type="hidden" id="REG" value="1" />
              </td>
            </tr>
            <tr>
              <td align="right" bgcolor="#CCCCCC">Zona Tributaria :</td>
              <td style="font-weight: bold; font-size: 14px;"><span style="font-weight: bold">
                  <?php $liqui = mysql_query("select ZT.DESCRIPCION,ZT.CODIGO_ZONA from zona_tributaria ZT,reg_asociacion_zona_tributaria RAZT where RAZT.CODIGO_ASOCIACION='$COD_ASOCIACION' and RAZT.CODIGO_ZONA=ZT.CODIGO_ZONA and RAZT.ESTADO='ACTIVO' and ZT.ESTADO='ACTIVO'");
                  while ($rowt = mysql_fetch_array($liqui)) {
                    echo $rowt[0];
                    $ZONA_TRIB = $rowt[0];
                    $CODIGO_ZONA_TRIB = $rowt[1];
                  } ?>
                </span></td>
            </tr>
            <tr>
              <td align="right" bgcolor="#CCCCCC">Gestión de Liquidación :</td>
              <td style="font-weight: bold; font-size: 14px;"><span style="font-weight: bold">
                  <select name="sltGestion" id="sltGestion" style="height:30px">
                    <?php $liq = mysql_query("select DISTINCT GESTION from reg_contribuyente_habilitado_pago where CODIGO_ASOCIACION='$COD_ASOCIACION' and ESTADO_ORDEN_PAGO='NO VALIDADO' and ESTADO='ACTIVO' order by GESTION");
                    while ($row = mysql_fetch_array($liq)) {
                      $SW = 1; ?>
                      <option <?php if ($sltGestion == $row[0]) {
                                echo "selected";
                              } ?>><?php echo $row[0]; ?></option>
                    <?PHP } ?>
                  </select>
                  <input name="txtBuscar" type="hidden" id="txtBuscar" value="1" />
                </span></td>
            </tr>
            <tr>
              <td align="right"><img src="../Img/Blanco.png" width="300" height="8" /></td>
              <td><input type="submit" name="button" id="button" value="Aceptar" style="width:250px; height:35px" /></td>
            </tr>
          </table>
        </form>
      </td>
    </tr><?php if ($txtBuscar == 1) {
            $sltGestion = $sltGestion; ?>
      <tr>
        <td align="left" style="font-weight: bold">Datos de Liquidación.</td>
      </tr>
      <tr>
        <td align="left" style="font-weight: bold"><img src="../Img/Linea_Negra.png" width="700" height="2" /></td>
      </tr>
      <tr>
        <td align="left" style="font-weight: bold"></td>
      </tr>
      <tr>
        <td align="center" style="font-weight: bold">
          <table width="100%" border="0" cellspacing="3" cellpadding="2">
            <tr>
              <td height="33" align="center" bgcolor="#CCCCCC">No.</td>
              <td align="center" bgcolor="#CCCCCC">Fecha y Hora</td>
              <td align="center" bgcolor="#CCCCCC">Usuario</td>
              <td align="center" bgcolor="#CCCCCC">Gestion</td>
              <td align="center" bgcolor="#CCCCCC">Cantidad</td>
              <td align="center">&nbsp;</td>
            </tr><?php $res = mysql_query("select DISTINCT CODIGO_REGISTRO,USUARIO,NOMBRE_USUARIO,FECHA,HORA,GESTION  from reg_contribuyente_habilitado_pago where CODIGO_ASOCIACION='$COD_ASOCIACION' and GESTION='$sltGestion' and ESTADO='ACTIVO' and ESTADO_ORDEN_PAGO='NO VALIDADO' order by GESTION");
                  while ($row = mysql_fetch_array($res)) { ?>
              <tr>
                <td bgcolor="#E3F0F2"><?php $cont++;
                                      echo $cont; ?></td>
                <td bgcolor="#E3F0F2"><?php echo $row['3'] . ' Hrs. ' . $row['4']; ?></td>
                <td bgcolor="#E3F0F2"><?php echo $row['1'] . ' - ' . $row['2']; ?></td>
                <td bgcolor="#E3F0F2"><?php echo $row['5']; ?></td>
                <td bgcolor="#E3F0F2"><?PHP $rest = mysql_query("select COUNT(*) from reg_contribuyente_habilitado_pago where CODIGO_REGISTRO='$row[0]' and CODIGO_ASOCIACION='$COD_ASOCIACION' and GESTION='$sltGestion' and ESTADO='ACTIVO' and ESTADO_ORDEN_PAGO='NO VALIDADO'");
                                      while ($rowt = mysql_fetch_array($rest)) {
                                        echo '( ' . $rowt[0] . ' ) REGISTROS.';
                                      } ?></td>
                <td><a href="frmDesimportar2.php?ZONA_TRIB=<?php echo $ZONA_TRIB; ?>&COD_ASOCIACION=<?php echo $COD_ASOCIACION; ?>&txtBuscar=1&sltGestion=<?php echo $sltGestion; ?>&CODIGOREGISTRO=<?php echo $row['0']; ?>">Seleccionar</a></td>
              </tr><?php } ?>
          </table>
        </td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
      </tr><?php } ?>
    <tr>
      <td align="center"><a href="frmDesimportar.php">Volver</a></td>
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
        if ($cont == 0 && $txtBuscar == 1) {
          echo "<script>alert('No se encontraron registros Validados para la Asociacion Seleccionada.')</script>";
          echo "<script> location.href='frmDesimportar.php';</script>";
        }
        ?>