<?php require_once('../Control_Sesiones_Forms/frmControlSesionUsuario.php');
require_once('../Control_Sesiones_Forms/Loading.php'); 
require '../Conexion_BD/Dbms.php';
if(empty($_SESSION['COD_REGISTRO'])){include_once("Index.php");}
if(empty($_SESSION['CODIGO_ZONA_TRIB'])){include_once("Index.php");}
if(empty($_SESSION['COD_ASOCIACION'])){include_once("Index.php");}
if(empty($_SESSION['ASOCIACION'])){include_once("Index.php");}
if(empty($_SESSION['txtCodigoRegistro'])){include_once("Index.php");}
if(empty($_SESSION['txtFecha'])){include_once("Index.php");}
if(empty($_SESSION['txtObservaciones'])){include_once("Index.php");}
if(empty($_SESSION['sltGestion'])){include_once("Index.php");}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel='StyleSheet' href='../Css_Formularios/frmProcesos.css' type="text/css">
<script src='Js/frmValida.js' type="text/javascript"></script>
<script src='Js/Ajax/jquery.min.js' type="text/javascript"></script>
<script src='Js/frmAgregarCont.js' type="text/javascript"></script>
</head>
<form method="post" action="frmCambioNombre1.php">
<body>
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
     <?php $resulty=mysql_query("select * from contribuyentes where CODIGO_CONTRIBUYENTE='$CODIGO_CONTRIBUYENTE' and ESTADO='ACTIVO'"); while($rowy=mysql_fetch_array($resulty)){ ?><?PHP } ?>
      <tr>
        <td colspan="2"  align="left"><span style="font-weight: bold">DATOS CONTRIBUYENTE</span>.</td>
      </tr>
      <tr>
        <td colspan="2"  align="left"><hr /></td>
      </tr>
      <tr>
        <td width="46%"  align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span> Nro. de Cédula de Identidad :</td>
        <td width="54%" style="font-weight: bold"><input name="txtNroCi" type="text" id="txtNroCi" style="width:150px; height:20px" onkeyup="buscar_ajax(this.value);return fileValidation();" size="10" onkeypress="return soloNumeros(event)" placeholder="Nro. de C.I."/></td>
      </tr>
      <tr>
        <td colspan="2"  align="right"><div id="mostrar"></div></td>
      </tr>
     <?php $res=mysql_query("select * from reg_contribuyente_habilitado_pago where REGISTRO_GREMIAL='$NUMERO_GREMIAL' and ESTADO='ACTIVO' and CODIGO_ASOCIACION='$COD_ASOCIACION'"); while($ros=mysql_fetch_array($res)){ $_SESSION['MONTOS']=$ros['MONTO'];$_SESSION['TIPO_PUESTOS']=$ros['TIPO_VENTA'];?><?php } ?>
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
</body></form>
</html><?php require '../Conexion_BD/Cerrar_Dbms.php';?>