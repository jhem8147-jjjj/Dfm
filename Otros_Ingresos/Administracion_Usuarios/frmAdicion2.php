<?php require '../Control_Sesiones_Forms/frmControlSesionUsuario.php';
require_once('../Control_Sesiones_Forms/Loading.php');
require '../Conexion_BD/Dbms_Usuario.php';
//ACTUALIZA A LETRAS MAYUSCULAS
$txtNoDocumento = strtoupper($txtNoDocumento);
$txtNombres = strtoupper($txtNombres);
$txtPrimerApellido = strtoupper($txtPrimerApellido);
$txtPrimerApellido = normaliza($txtPrimerApellido);
$txtSegundoApellido = strtoupper($txtSegundoApellido);
$txtSegundoApellido = normaliza($txtSegundoApellido);
$txtCargo = strtoupper($txtCargo);
$roles = mysql_query("select * from usuarios where CEDULA_IDENTIDAD='$txtNoDocumento' ");
while ($rows = mysql_fetch_array($roles)) {
  $SW = 1;
}
if ($SW == 1) {
  echo "<script>alert('El número de Cédula de Identidad , ya fue registrado.')</script>";
}
#genera usuario 
$USUARIO = substr("$txtNombres", 0, 1) . $txtPrimerApellido;
$result = mysql_query("select USUARIO from usuarios where USUARIO like '$USUARIO%'");
while ($row = mysql_fetch_array($result)) {
  $CONT++;
}
if ($CONT > 0) {
  $USUARIO = $USUARIO . $CONT . '.SIFM';
} else {
  $USUARIO = $USUARIO . '.SIFM';
}
require '../Conexion_BD/Cerrar_Dbms.php'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel='StyleSheet' href='cssFormato.css' type="text/css">
  <form method="post" action="frmAdicion3.php">

<body>
  <table width="70%" border="0">
    <tr>
      <td align="center" class="TITULO">REGISTRO DE USUARIO</td>
    </tr>
    <tr>
      <td align="center" class="SUBTITULO">REGISTRAR NUEVO USUARIO</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>
        <table width="100%" border="0">
          <tr>
            <td colspan="2" align="left" class="TITULO">DATOS DE OPERADOR.</td>
          </tr>
          <tr>
            <td colspan="2" align="right">
              <hr />
            </td>
          </tr>
          <tr>
            <td align="right" bgcolor="#CCCCCC">
              <table width="100%" height="26" border="1" cellpadding="0" cellspacing="0" bordercolor="#6699FF">
                <tr bordercolor="#FF9900" bordercolorlight="#FF9900">
                  <td align="right" bordercolor="#6699FF"> No. de Documento :</td>
                </tr>
              </table>
            </td>
            <td><?php echo $txtNoDocumento; ?>
              <input name="txtNoDocumento" type="hidden" id="txtNoDocumento" value="<?php echo $txtNoDocumento; ?>" />
              <input name="hdfReg" type="hidden" id="hdfReg" value="1" />
            </td>
          </tr>
          <tr>
            <td align="right" bgcolor="#CCCCCC">
              <table width="100%" height="26" border="1" cellpadding="0" cellspacing="0" bordercolor="#6699FF">
                <tr bordercolor="#FF9900" bordercolorlight="#FF9900">
                  <td align="right" bordercolor="#6699FF"> Expedido :</td>
                </tr>
              </table>
            </td>
            <td><?php echo $sltExpedido; ?>
              <input name="sltExpedido" type="hidden" id="sltExpedido" value="<?php echo $sltExpedido; ?>" />
            </td>
          </tr>
          <tr>
            <td align="right" bgcolor="#CCCCCC">
              <table width="100%" height="26" border="1" cellpadding="0" cellspacing="0" bordercolor="#6699FF">
                <tr bordercolor="#FF9900" bordercolorlight="#FF9900">
                  <td align="right" bordercolor="#6699FF"> Nombre(s) :</td>
                </tr>
              </table>
            </td>
            <td><?php echo $txtNombres; ?>
              <input name="txtNombres" type="hidden" id="txtNombres" value="<?php echo $txtNombres; ?>" />
            </td>
          </tr>
          <tr>
            <td align="right" bgcolor="#CCCCCC">
              <table width="100%" height="26" border="1" cellpadding="0" cellspacing="0" bordercolor="#6699FF">
                <tr bordercolor="#FF9900" bordercolorlight="#FF9900">
                  <td align="right" bordercolor="#6699FF"> Primer Apellido :</td>
                </tr>
              </table>
            </td>
            <td><?php echo $txtPrimerApellido; ?>
              <input name="txtPrimerApellido" type="hidden" id="txtPrimerApellido" value="<?php echo $txtPrimerApellido; ?>" />
            </td>
          </tr>
          <tr>
            <td align="right" bgcolor="#CCCCCC">
              <table width="100%" height="26" border="1" cellpadding="0" cellspacing="0" bordercolor="#6699FF">
                <tr bordercolor="#FF9900" bordercolorlight="#FF9900">
                  <td align="right" bordercolor="#6699FF"> Segundo Apellido :</td>
                </tr>
              </table>
            </td>
            <td><?php echo $txtSegundoApellido; ?>
              <input name="txtSegundoApellido" type="hidden" id="txtSegundoApellido" value="<?php echo $txtSegundoApellido; ?>" />
            </td>
          </tr>
          <tr>
            <td align="right" bgcolor="#CCCCCC">
              <table width="100%" height="26" border="1" cellpadding="0" cellspacing="0" bordercolor="#6699FF">
                <tr bordercolor="#FF9900" bordercolorlight="#FF9900">
                  <td align="right" bordercolor="#6699FF"> Usuario Asignado :</td>
                </tr>
              </table>
            </td>
            <td><?php echo $USUARIO; ?>
              <input name="USUARIO" type="hidden" id="USUARIO" value="<?php echo $USUARIO; ?>" />
            </td>
          </tr>
          <tr>
            <td align="right" bgcolor="#CCCCCC">
              <table width="100%" height="26" border="1" cellpadding="0" cellspacing="0" bordercolor="#6699FF">
                <tr bordercolor="#FF9900" bordercolorlight="#FF9900">
                  <td align="right" bordercolor="#6699FF">Unidad :</td>
                </tr>
              </table>
            </td>
            <td><?php echo $sltUnidad; ?>
              <input name="txtUnidad" type="hidden" id="txtUnidad" value="<?php echo $sltUnidad; ?>" />
            </td>
          </tr>
          <tr>
            <td align="right" bgcolor="#CCCCCC">
              <table width="100%" height="26" border="1" cellpadding="0" cellspacing="0" bordercolor="#6699FF">
                <tr bordercolor="#FF9900" bordercolorlight="#FF9900">
                  <td align="right" bordercolor="#6699FF">Area :</td>
                </tr>
              </table>
            </td>
            <td><?php echo $sltArea; ?>
              <input name="txtArea" type="hidden" id="txtArea" value="<?php echo $sltArea; ?>" />
            </td>
          </tr>
          <tr>
            <td align="right" bgcolor="#CCCCCC">
              <table width="100%" height="26" border="1" cellpadding="0" cellspacing="0" bordercolor="#6699FF">
                <tr bordercolor="#FF9900" bordercolorlight="#FF9900">
                  <td align="right" bordercolor="#6699FF">Cargo :</td>
                </tr>
              </table>
            </td>
            <td><?php echo $txtCargo; ?>
              <input name="txtCargo" type="hidden" id="txtCargo" value="<?php echo $txtCargo; ?>" />
            </td>
          </tr>
          <tr>
            <td align="right">&nbsp;</td>
            <td><input type="submit" name="button" id="button" value="Continuar" style="width:150px; height:50px"  /></td>
          </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td align="center"><a href="frmAdicion.php">Volver</a></td>
    </tr>
    <tr>
      <td class="TITULO"><span class="ASTERISCO">Ver 1.</span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
  </table>
</body>
</form>

</html>
<?php

function normaliza($cadena)
{
  $originales = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞ
ßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ';
  $modificadas = 'aaaaaaaceeeeiiiidnoooooouuuuy
bsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
  $cadena = utf8_decode($cadena);
  $cadena = strtr($cadena, utf8_decode($originales), $modificadas);
  $cadena = strtoupper($cadena);
  return utf8_encode($cadena);
}
