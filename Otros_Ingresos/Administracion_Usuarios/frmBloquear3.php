<?php require '../Control_Sesiones_Forms/frmControlSesionUsuario.php'; require_once('../Control_Sesiones_Forms/Loading.php'); if($rdEstado==0){$ESTADOS='BLOQUEO';}elseif($rdEstado==1){$ESTADOS='DESBLOQUEO';}
 ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel='StyleSheet' href='cssFormato.css' type="text/css">
</head>

<body>
<table width="70%" border="0">
  <tr>
    <td align="center" class="TITULO">BLOQUEO Y/O DESBLOQUEO DE USUARIO DEL SISTEMA DE FISCALIZACION</td>
  </tr>
  <tr>
    <td align="center">BLOQUEO Y/O DESBLOQUEO</td>
  </tr>
  <?php ?>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td class="TITULO">Pasos Finales.</td>
      </tr>
      <tr>
        <td><hr /></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td>1</td>
        <td>Presione el botón Imprimir el documento de Bloqueo y/o Desbloqueo.</td>
        <td align="center"><form method="post" action="Pdf/frmBloqueo.php">
          <input name="ESTADOS" type="hidden" id="ESTADOS" value="<?php echo $ESTADOS;?>" />
          <input name="USUARIO" type="hidden" id="USUARIO" value="<?php echo $USUARIO;?>" />
          <input type="submit" name="button" id="button" value="Imprimir " style="width:200px; height:35px" />
        </form></td>
      </tr>
      <tr>
        <td>2</td>
        <td>Presione el botón Nueva Operación , para para realizar un Nuevo Bloqueo y/o Desbloqueo de Usuario.</td>
        <td align="center"><input type="submit" name="button2" id="button2" value="Nueva Operación" style="width:200px; height:35px"/></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="TITULO"><span class="ASTERISCO">Ver 2.</span></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>