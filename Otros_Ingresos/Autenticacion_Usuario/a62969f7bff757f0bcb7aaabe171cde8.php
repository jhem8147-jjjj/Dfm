<?php session_start();
unset($_SESSION['US_SIOI'],$_SESSION['SIOIUNOMBRES'],$_SESSION['USNOMBRES'],$_SESSION["USPRIMERAPELLIDO"],$_SESSION['SIAUPRIMERAPELLIDO'],$_SESSION["USSEGUNDOAPELLIDO"],$_SESSION['SIAUSEGUNDOAPELLIDO']);
if($INTENTOS==0){}else{
if($INTENTOS>3){
echo"<script>alert('USUARIO y/o CONTRASEÑA NO VALIDA, VUELVA A INTENTARLO LUEGO.');</script>";
echo"<script> location.href='../Control_Sesiones_Forms/frmLogeoUsuarioNoAutentificacion.php';</script>";
}else{
echo"<script>alert('USUARIO y/o CONTRASEÑA NO VALIDA.');</script>";
	}
}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.:: GOBIERNO AUTONOMO MUNICIPAL DE EL ALTO ::.</title>
<script language="JavaScript" src='Js/frmMax.js' type="text/javascript"></script>
<script language="JavaScript" src='Js/frmValida.js' type="text/javascript"></script>
<style type="text/css">
body {
	background-color: #CCC;
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
body,td,th {
	color: #000;
}
</style>
</head>
<form method="post" action="e675ecdca6c032b8791a651b1d56e47b.php" autocomplete="off">
<body   onselectstart="return false" oncontextmenu="return false" ondragstart="return false">
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<table width="10%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000" bordercolorlight="#ffffff" bordercolordark="#ffffff">
  <tr>
    <td background="images/bg.jpg"><table width="85%" border="0" align="center">
      <tr>
        <td>&nbsp;</td>
        <td colspan="2" align="center">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="2" align="center"><span style="font-weight: bold; font-size: 22px;">AUTENTICACION DE USUARIO</span></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td width="9%">&nbsp;</td>
        <td width="9%"><img src="images/users-password.png" width="53" height="34" /></td>
        <td width="91%"><input type="text" name="txtUsuario" id="txtUsuario" style="width:300px; height:35px" placeholder="USUARIO" required="required"/></td>
        <td width="91%">&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td><img src="images/144861.png" width="51" height="38" /></td>
        <td><input type="password" name="txtPassword" id="txtPassword" style="width:300px; height:35px" placeholder="CONTRASENIA" required="required"/></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><input type="submit" name="button" id="button" value="Ingresar"  style="width:200px; height:50px"/></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</form>
</html>