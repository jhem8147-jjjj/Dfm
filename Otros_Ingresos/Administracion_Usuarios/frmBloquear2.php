<?php require '../Control_Sesiones_Forms/frmControlSesionUsuario.php'; require_once('../Control_Sesiones_Forms/Loading.php');  ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel='StyleSheet' href='cssFormato.css' type="text/css">
</head>
<form method="post" action="frmBloquear3.php">
<body>
<table width="70%" border="0">
  <tr>
    <td align="center" class="TITULO">BLOQUEO Y/O DESBLOQUEO DE   USUARIO</td>
  </tr>
  <tr>
    <td align="center">BLOQUEO Y/O DESBLOQUEO</td>
  </tr>
  <?php  require '../Conexion_BD/Dbms_Usuario.php'; $roles=mysql_query("select * from usuarios where USUARIO='$USUARIO'");
		  while($rows=mysql_fetch_array($roles)){?>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="TITULO">Datos Operador.</td>
  </tr>
  <tr>
    <td><hr /></td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td align="right" bgcolor="#F9F9F9"><table width="100%" height="26" border="1" cellpadding="0" cellspacing="0" bordercolor="#6699FF">
          <tr bordercolor="#FF9900" bordercolorlight="#FF9900">
            <td align="right" bordercolor="#6699FF"> No. de Cédula de Identidad :<span style="text-align: right"></span></td>
          </tr>
        </table></td>
        <td><?php echo $rows['CEDULA_IDENTIDAD'].' '.$rows['EXPEDIDO'];?></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#F9F9F9"><table width="100%" height="26" border="1" cellpadding="0" cellspacing="0" bordercolor="#6699FF">
          <tr bordercolor="#FF9900" bordercolorlight="#FF9900">
            <td align="right" bordercolor="#6699FF"> Nombre(s) :<span style="text-align: right"></span></td>
            </tr>
          </table></td>
        <td><?php echo $rows['NOMBRES'];?></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#F9F9F9"><table width="100%" height="26" border="1" cellpadding="0" cellspacing="0" bordercolor="#6699FF">
          <tr bordercolor="#FF9900" bordercolorlight="#FF9900">
            <td align="right" bordercolor="#6699FF"> Primer Apellido :<span style="text-align: right"></span></td>
          </tr>
        </table></td>
        <td><?php echo $rows['PRIMER_APELLIDO'];?></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#F9F9F9"><table width="100%" height="26" border="1" cellpadding="0" cellspacing="0" bordercolor="#6699FF">
          <tr bordercolor="#FF9900" bordercolorlight="#FF9900">
            <td align="right" bordercolor="#6699FF"> Segundo Apellido :</td>
          </tr>
        </table></td>
        <td><?php echo $rows['SEGUNDO_APELLIDO'];?></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#F9F9F9"><table width="100%" height="26" border="1" cellpadding="0" cellspacing="0" bordercolor="#6699FF">
          <tr bordercolor="#FF9900" bordercolorlight="#FF9900">
            <td align="right" bordercolor="#6699FF"> Usuario Asignado :</td>
          </tr>
        </table></td>
        <td style="font-weight: bold"><?php echo $USUARIO;?>
          <input name="USUARIO" type="hidden" id="USUARIO" value="<?php echo $USUARIO;?>" /></td>
      </tr><?php } require '../Conexion_BD/Cerrar_Dbms.php';?>
      <tr>
        <td colspan="2" align="right"><table width="100%" border="0">
          <tr>
            <td class="TITULO">Estado de Usuario.</td>
          </tr>
          <tr>
            <td><hr /></td>
          </tr>
        </table></td>
        </tr>
      <tr>
        <td  align="right" valign="top" bgcolor="#F9F9F9"><table width="100%" height="26" border="1" cellpadding="0" cellspacing="0" bordercolor="#6699FF">
          <tr bordercolor="#FF9900" bordercolorlight="#FF9900">
            <td align="right" bordercolor="#6699FF"> Definir Estado de USUARIO :</td>
          </tr>
        </table></td><td  align="right"><table width="100%" border="0">
          <tr>
            <td><input name="rdEstado" type="radio" id="radio" value="0" checked="checked" />
              Bloquear</td>
          </tr>
          <tr>
            <td><input name="rdEstado" type="radio" id="radio2" value="1" />
DesBloquear</td>
          </tr>
          <tr>
            <td><input type="submit" name="button" id="button" value="Aceptar" style="width:150px; height:50px" /></td>
          </tr>
        </table></td>
        </tr>
      <tr>
        <td colspan="2" align="right">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center"><a href="frmBloquear.php">Volver</a></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td class="ASTERISCO">Ver 1.</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body></form>
</html>