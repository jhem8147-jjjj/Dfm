<?php require_once('../Control_Sesiones_Forms/frmControlSesionUsuario.php');
require_once('../Control_Sesiones_Forms/Loading.php');
require '../Conexion_BD/Dbms.php';
if (empty($_SESSION['COD_ASOCIACION'])) {
  include_once("Index.php");
}
if (empty($_SESSION['ASOCIACION'])) {
  include_once("Index.php");
}
if (empty($_SESSION['DOCUMENTOREG'])) {
  include_once("Index.php");
}
if (empty($_SESSION['COM_INT'])) {
  include_once("Index.php");
}
if (empty($_SESSION['CODIGOREGISTRO'])) {
  include_once("Index.php");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel='StyleSheet' href='../Css_Formularios/frmProcesos.css' type="text/css">
  <script src='Js/frmValida.js' type="text/javascript"></script>
</head>
<form method="post" action="frmEmisionCP4.php?CODIGOREGISTRO=<?php echo $_GET['CODIGOREGISTRO'];?>">

  <body>
    <table width="10%" border="0" align="left">
      <tr>
        <td align="center" class="TITULO">EMISION DE COMPROBANTE DE PAGO</td>
      </tr>
      <tr>
        <td align="center" class="SUBTITULO"><?php if ($txtTipo == 'CC') {
                                                echo "COMPLEMENTACION DE PUESTOS DE VENTA";
                                              }
                                              if ($txtTipo == 'CN') {
                                                echo "CAMBIO DE NOMBRE";
                                              } ?></td>
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
              <td height="25" align="right" bgcolor="#CCCCCC">Cuenta Bancaria Depositado :</td>
              <td style="font-weight: bold; font-size: 14px;"><?php echo $txtDeposito; ?>
                <input name="txtDeposito" type="hidden" id="txtDeposito" value="<?php echo $txtDeposito; ?>" />
              </td>
            </tr>
            <tr>
              <td height="25" align="right" bgcolor="#CCCCCC">Número de Deposito :</td>
              <td style="font-weight: bold; font-size: 14px;"><?php echo $txtNumeroDeposito; ?>
                <input name="txtNumeroDeposito" type="hidden" id="txtNumeroDeposito" value="<?php echo $txtNumeroDeposito; ?>" />
              </td>
            </tr>
            <tr>
              <td height="25" align="right" bgcolor="#CCCCCC">Fecha de Deposito :</td>
              <td style="font-weight: bold; font-size: 14px;"><?php $dia = substr("$txtFechaDeposito", 8, 2);
                                                              $mes = substr("$txtFechaDeposito", 5, 2);
                                                              $gestion = substr("$txtFechaDeposito", 0, 4);
                                                              echo $fechadeposito = $dia . '-' . $mes . '-' . $gestion; ?>
                <span class="SUBTITULO"><span style="font-weight: bold">
                    <input name="txtFechaDeposito" type="hidden" id="txtFechaDeposito" value="<?php echo $fechadeposito; ?>" />
                    <input name="txtTipo" type="hidden" id="txtTipo" value="<?php echo $txtTipo; ?>" />
                  </span></span>
              </td>
            </tr>
            <tr>
              <td align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">* </span>Glosa para Observaciones :</td>
              <td rowspan="2"><textarea name="textarea" id="textarea" cols="45" rows="5" maxlength="255"><?php echo 'PAGO AUTORIZADO MEDIANTE COMUNICACION INTERNA ' . $COM_INT . ', AUTORIZADO POR: ' . $txtAutorizado . ' CARGO DE: ' . $txtCargo . ', PAGO REALIZADO MEDIANTE DEPOSITO No. ' . $txtNumeroDeposito . ', DE FECHA: ' . $fechadeposito . ' BANCO UNION.'; ?></textarea></td>
            </tr>
            <tr>
              <td align="right" bgcolor="#CCCCCC">&nbsp;</td>
            </tr>
            <tr>
              <td align="right" bgcolor="#CCCCCC">&nbsp;</td>
              <td>
                <input type="hidden" value="<?php echo $_GET['CODIGOREGISTRO'];?>" name="CODIGOREGISTRO" id="CODIGOREGISTRO">
                <input type="submit" name="button" id="button" value="Registrar Datos" style="width:250px; height:35px" /></td>
            </tr>
            <tr>
              <td align="right"><span style="font-weight: bold"><img src="../Img/Linea.png" width="250" height="4" /></span></td>
              <td>&nbsp;</td>
            </tr>
          </table>
        </td>
      </tr>
      <tr>
        <td align="left">&nbsp;</td>
      </tr>
      <tr>
        <td align="center"><a href="frmEmisionCP1.php">
            Volver</a></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td class="ASTERISCO">VER. 3</td>
      </tr>
    </table>
  </body>
</form>

</html><?php require '../Conexion_BD/Cerrar_Dbms.php'; ?>