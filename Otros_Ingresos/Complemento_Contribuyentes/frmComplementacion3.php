<?php header('Content-Type: text/html; charset=utf-8');
require_once('../Control_Sesiones_Forms/frmControlSesionUsuario.php');
require '../Conexion_BD/Dbms.php';
$contextFields = array('COD_REGISTRO', 'CODIGO_ZONA_TRIB', 'COD_ASOCIACION', 'ASOCIACION', 'OMS', 'txtCodigoRegistro', 'txtDocumento', 'txtFecha', 'txtObservaciones', 'sltGestion');
foreach ($contextFields as $contextField) {
    if (isset($_POST[$contextField]) && is_scalar($_POST[$contextField]) && (string)$_POST[$contextField] !== '') {
        $_SESSION[$contextField] = (string)$_POST[$contextField];
    } elseif (isset($_GET[$contextField]) && is_scalar($_GET[$contextField]) && (string)$_GET[$contextField] !== '') {
        $_SESSION[$contextField] = (string)$_GET[$contextField];
    }
}
if(empty($_SESSION['COD_REGISTRO']) || empty($_SESSION['CODIGO_ZONA_TRIB']) || empty($_SESSION['COD_ASOCIACION']) || empty($_SESSION['ASOCIACION']) || empty($_SESSION['txtCodigoRegistro']) || empty($_SESSION['txtDocumento']) || empty($_SESSION['txtFecha']) || empty($_SESSION['sltGestion'])){
    header('Location: Index.php');
    exit;
}
$contextValues = array();
foreach ($contextFields as $contextField) {
    $contextValues[$contextField] = isset($_SESSION[$contextField]) && is_scalar($_SESSION[$contextField])
        ? (string)$_SESSION[$contextField] : '';
}
?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel='StyleSheet' href='../Css_Formularios/frmProcesos.css' type="text/css">
<script src='Js/frmValida.js' type="text/javascript"></script>
<script src='Js/Ajax/jquery.min.js' type="text/javascript"></script>
<script src='Js/frmAgregarCont.js' type="text/javascript"></script>
</head>
<body>
<?php foreach ($contextValues as $contextField => $contextValue) { ?>
<input type="hidden" name="<?php echo htmlspecialchars($contextField, ENT_QUOTES, 'UTF-8'); ?>" value="<?php echo htmlspecialchars($contextValue, ENT_QUOTES, 'UTF-8'); ?>" />
<?php } ?>
<table width="50%" border="0">
  <tr>
    <td align="center" class="TITULO">COMPLEMENTO</td>
  </tr>
  <tr>
    <td align="center" class="SUBTITULO">AGREGAR  CONTRIBUYENTE</td>
  </tr>
  <tr>
    <td><img src="../Img/Blanco.png" width="600" height="6" /></td>
  </tr>
  <tr>
    <td align="left"><table width="20%" border="0">
      <tr>
        <td colspan="2"  align="left"><span style="font-weight: bold">DATOS CONTRIBUYENTE</span>.</td>
      </tr>
      <tr>
        <td colspan="2"  align="left"><hr /></td>
      </tr>
      <tr>
        <td width="46%"  align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span> Nro. de Cédula de Identidad :</td>
        <td width="54%" style="font-weight: bold"><input name="txtNroCi" type="text" id="txtNroCi" style="width:150px; height:20px" onkeyup="buscar_ajax(this.value)" size="10" onkeypress="return soloNumeros(event)" placeholder="Nro. de C.I."/></td>
      </tr>
      <tr>
        <td colspan="2"  align="right"><div id="mostrar"></div></td>
      </tr>
      <tr>
        <td colspan="2"  align="right"><img src="../Img/Blanco.png" width="661" height="6" /></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center"><a href="frmComplementacion2.php">Volver</a></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="ASTERISCO">VER. 4</td>
  </tr>
</table>
</body>
</html><?php require '../Conexion_BD/Cerrar_Dbms.php';?>