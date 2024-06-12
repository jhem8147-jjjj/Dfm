<?php require_once('../Control_Sesiones_Forms/frmControlSesionUsuario.php');require_once('../Control_Sesiones_Forms/Loading.php'); ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel='StyleSheet' href='../Css_Formularios/frmProcesos.css' type="text/css">
</head>

<body>
<table width="50%" border="0">
  <tr>
    <td align="center" class="TITULO">PROFORMA</td>
  </tr>
  <tr>
    <td align="center" class="SUBTITULO"><?php if($hdfLiquidacion=='CC'){echo "COMPLEMENTACION DE PUESTOS DE VENTA";} if($hdfLiquidacion=='CN'){echo "CAMBIO DE NOMBRE";} ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="left">Registro</td>
  </tr>
  <tr>
    <td><img src="../Img/Linea.png" width="843" height="4" /></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="3" cellpadding="2">
      <tr>
        <td height="32" align="center" bgcolor="#CCCCCC" style="font-weight: bold">PASO</td>
        <td align="center" bgcolor="#CCCCCC" style="font-weight: bold">DESCRIPCION</td>
        <td align="center" style="font-weight: bold">&nbsp;</td>
      </tr><?php if($hdfLiquidacion=='CN'){?>
      <tr>
        <td bgcolor="#F3F3F3">1</td>
        <td bgcolor="#F3F3F3">Imprimir Proforma, genera archivo Pdf para ver detalles de la liquidación por Cambio de Nombre.</td>
        <td><form  method="post" action='frmLiquidacionCn.php' target="_blank">
          <input type="submit" name="btnImprimirCn" id="btnImprimirCn" value="Imprimir Proforma" style="width:200px; height:35px" /></form></td>
      </tr><?php } 
	  if($hdfLiquidacion=='CC'){?>
     <tr>
        <td bgcolor="#F3F3F3">1</td>
        <td bgcolor="#F3F3F3">Imprimir Proforma, genera archivo Pdf para ver detalles de la liquidación por Complemento de Puestos de Venta.</td> 
        <td><form method="post" action="frmLiquidacionCC.php" target="_blank"><input type="submit" name="btnImprimirCc" id="btnImprimirCc" value="Imprimir Proforma" style="width:200px; height:35px"/></form></td>
      </tr><?php } ?>
      <tr>
        <td bgcolor="#F3F3F3">2</td>
        <td bgcolor="#F3F3F3"><p>Salir, permite salir del módulo.</p></td>
        <td><form  method="post" action='../Autenticacion_Usuario/frmCuerpo.php'"><input type="submit" name="btnSalir" id="btnSalir" value="Salir" style="width:200px; height:35px" /></form></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center"><a href="frmProforma.php">Volver</a></td>
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
    <td class="ASTERISCO">VER. 4</td>
  </tr>
</table>

</body>
</html>