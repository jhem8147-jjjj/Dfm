<?php require'../Control_Sesiones_Forms/frmControlSesionUsuario.php'; require'../Control_Sesiones_Forms/Loading.php'; require'../Control_Sesiones_Forms/Key.php';?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src='Js/frmValida.js' type="text/javascript"></script>
<style type="text/css">
body,td,th {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 10px;
}
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
</style>
</head>
<form method="post" action="frmCambiarContrasenia1.php" >
<body>
<table width="100%" border="0">
  <tr>
    <td align="left"><table width="40%" border="0">
      <tr>
        <td align="center" style="font-family: Verdana, Geneva, sans-serif; font-weight: bold; font-size: 14px; color: #C33;">&nbsp;</td>
      </tr>
      <tr>
        <td align="center" style="font-family: Verdana, Geneva, sans-serif; font-weight: bold; font-size: 14px; color: #C33;">CAMBIAR CONTRASEÑA</td>
      </tr>
      <tr>
        <td align="center">CAMBIAR CONTRASEÑA ACTUAL DE INGRESO AL SISTEMA</td>
      </tr>
      <tr>
        <td><img src="../Img/Lineas.png" width="500" height="2" /></td>
      </tr>
      <tr>
        <td><table width="100%" border="0" cellpadding="3" cellspacing="2">
          <tr>
            <td align="right" bgcolor="#CCCCCC"><table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#6699CC">
              <tr>
                <td align="right">( <span style="font-weight: bold; color: #C30; font-size: 13px;">* </span>) Usuario Actual :</td>
              </tr>
            </table></td>
            <td style="font-weight: bold; font-size: 12px;"><?php echo $US_SIOI; ?></td>
          </tr>
          <tr>
            <td align="right" bgcolor="#CCCCCC"><table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#6699CC">
              <tr>
                <td align="right">( <span style="font-weight: bold; color: #C30; font-size: 13px;">* </span>) Contraseña Actual :</td>
              </tr>
            </table></td>
            <td><input type="password" name="txtContrasenia" id="txtContrasenia" style='height:30px; width:220px' onkeypress="return soloNumAlfSigPas(event)" onchange="return fileValidation()" placeholder="CONTRASEÑA ACTUAL" required="required"/></td>
          </tr>
          <tr>
            <td align="right" bgcolor="#CCCCCC"><table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#6699CC">
              <tr>
                <td align="right">( <span style="font-weight: bold; color: #C30; font-size: 13px;">* </span>) Contraseña Nueva :</td>
              </tr>
            </table></td>
            <td><input type="password" name="txtContNueva" id="txtContNueva" style='height:30px; width:220px' onkeypress="return soloNumAlfSigPas(event)" placeholder="CONTRASEÑA NUEVA" onchange="return fileValidation()" required="required"/></td>
          </tr>
          <tr>
            <td align="right" bgcolor="#CCCCCC"><table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#6699CC">
              <tr>
                <td align="right">( <span style="font-weight: bold; color: #C30; font-size: 13px;">* </span>) Repita Contraseña Nueva :</td>
              </tr>
            </table></td>
            <td><input type="password" name="txtContRepNueva" id="txtContRepNueva" style='height:30px; width:220px' onkeypress="return soloNumAlfSigPas(event)" placeholder="REPITA LA CONTRASEÑA NUEVA"  onchange="return fileValidation()" required="required"/></td>
          </tr>
          <tr>
            <td align="right">&nbsp;</td>
            <td><input type="submit" name="button" id="button" value="Aceptar" style="width:170px; height:40px"  /></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td>( <span style="font-weight: bold; color: #C30; font-size: 13px;">* </span>) Campos Obligatorios.</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td style="font-weight: bold; color: #F00; font-size: 12px;">Ver. 0</td>
      </tr>
    </table></td>
  </tr>
</table>
</body></form>
</html>