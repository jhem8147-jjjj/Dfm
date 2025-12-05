<?php require_once('../Control_Sesiones_Forms/frmControlSesionUsuario.php');
require_once('../Control_Sesiones_Forms/Loading.php');
require '../Conexion_BD/Dbms.php';
$_SESSION['COM_INT'] = $COM_INT;
$_SESSION['CODIGOREGISTRO'] = $CODIGOREGISTRO;
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
<form method="post" action="frmEmisionCP3.php?CODIGOREGISTRO=<?php echo $_GET['CODIGOREGISTRO'];?>">

  <body>
    <table width="10%" border="0" align="left">
      <tr>
        <td align="center" class="TITULO">EMISION DE COMPROBANTE DE PAGO</td>
      </tr>
      <tr>
        <td align="center" class="SUBTITULO"><?php if ($CC == '1') {
                                                echo "COMPLEMENTACION DE PUESTOS DE VENTA";
                                                $TIPO = 'CC';
                                              }
                                              if ($CN == '1') {
                                                echo "CAMBIO DE NOMBRE";
                                                $TIPO = 'CN';
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
              <td align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">* </span>Autorizado por :</td>
              <td><input name="txtAutorizado" type="text" id="txtAutorizado" size="60" maxlength="100" onkeyup="return fileValidation();" onchange="javascript:this.value=this.value.toUpperCase();" onkeypress="return soloNumAlfSig(event)" placeholder="CARGO, NOMBRE, CARGO " required /></td>
            </tr>
            <tr>
              <td align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">* </span> Cargo :</td>
              <td><input name="txtCargo" type="text" id="txtCargo" size="60" maxlength="100" onkeyup="return fileValidation();" onchange="javascript:this.value=this.value.toUpperCase();" onkeypress="return soloNumAlfSig(event)" placeholder="CARGO, NOMBRE, CARGO " required="required" /></td>
            </tr>
            <tr>
              <td align="right" bgcolor="#CCCCCC">&nbsp;</td>
              <td>Rango y Nombre Completo, Cargo(s)</td>
            </tr>
            <tr>
              <td align="right" bgcolor="#CCCCCC">&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td align="right"><span style="font-weight: bold"><img src="../Img/Linea.png" width="250" height="4" /></span></td>
              <td>&nbsp;</td>
            </tr>
          </table>
        </td>
      </tr>
      <tr>
        <td align="left" style="font-weight: bold">DATOS DE DEPOSITO.</td>
      </tr>
      <tr>
        <td align="left" style="font-weight: bold"><img src="../Img/Linea.png" width="843" height="4" /></td>
      </tr>
      <tr>
        <td align="left" style="font-weight: bold"></td>
      </tr>
      <tr>
        <td align="center">
          <table width="100%" border="0">
            <tr>
              <td width="8%" align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span> CUENTA BANCARIA DEPOSITADO :</td>
              <td width="92%"><input name="txtDeposito" type="text" id="txtDeposito" value="10000004711912" onkeyup="return fileValidation();" onkeypress="return soloNumeros(event)" placeholder="No. DE CUENTA BANCARIA" /></td>
            </tr>
            <tr>
              <td align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span> FECHA DEPOSITO :</td>
              <td><input name="txtFechaDeposito" type="date" id="txtFechaDeposito" Min="2020-09-01" max="<?php echo date('Y-m-d'); ?>" placeholder="FECHA DE DEPOSITO" onkeyup="return fileValidation();" required /></td>
            </tr>
            <tr>
              <td align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span> NUMERO DEPOSITO BANCARIO :</td>
              <td><input name="txtNumeroDeposito" type="text" id="txtNumeroDeposito" onkeyup="return fileValidation();" onkeypress="return soloNumeros(event)" placeholder="No. DE DEPOSITO BANCARIA" required />
                <span class="SUBTITULO">
                  <input name="txtTipo" type="hidden" id="txtTipo" value="<?php echo $TIPO; ?>" />
                </span>
              </td>
            </tr>
            <tr>
              <td align="right" valign="top"><img src="../Img/Linea.png" width="250" height="4" /></td>
              <td>
                <input type="hidden" value="<?php echo $_GET['CODIGOREGISTRO'];?>" name="CODIGOREGISTRO" id="CODIGOREGISTRO">
                <input type="submit" name="button" id="button" value="Registrar Datos" style="width:250px; height:35px" />
              </td>
            </tr>
          </table>
        </td>
      </tr>
      <tr>
        <td align="left"><span class="ASTERISCO">* Campos Obligatorios.</span></td>
      </tr>
      <tr>
        <td align="center"><a href="frmEmisionCP1.php">
            Volver</a></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td class="ASTERISCO">VER. 2</td>
      </tr>
    </table>
  </body>
</form>

</html><?php require '../Conexion_BD/Cerrar_Dbms.php'; ?>