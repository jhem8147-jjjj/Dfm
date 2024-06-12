<?php require '../Control_Sesiones_Forms/frmControlSesionUsuario.php'; require'frmCerrarSesiones.php';require_once('../Control_Sesiones_Forms/Loading.php');  ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel='StyleSheet' href='cssFormato.css' type="text/css">
<script language="JavaScript" src='Js/jsValidacion.js' type="text/javascript"></script>
<form 	method="post" action="frmModificar.php">
<body>
<table width="70%" border="0">
  <tr>
    <td align="center" class="TITULO">MODIFICAR  USUARIO</td>
  </tr>
  <tr>
    <td align="center">AGREGAR, BAJA DE ROL(ES)</td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td align="right"><table width="100%" height="26" border="1" cellpadding="0" cellspacing="0" bordercolor="#6699FF">
          <tr bordercolor="#FF9900" bordercolorlight="#FF9900">
            <td align="right" bordercolor="#6699FF"> ( <span class="ASTERISOC"><span class="ASTERISCO">*</span></span> ) Nombre(s) :</td>
            </tr>
          </table></td>
        <td><input type="text" name="txtNombres" id="txtNombres" onKeyPress="return soloAlf(event)" required />
          <input name="hdfReg" type="hidden" id="hdfReg" value="1" /></td>
      </tr>
      <tr>
        <td align="right">&nbsp;</td>
        <td><input type="submit" name="button" id="button" value="Buscar" style="width:150px; height:50px"/></td>
      </tr>
    </table></td>
  </tr><?php if($hdfReg==1){?>
  <tr>
    <td align="center"><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td class="TITULO">Usuario(s) Registrado(s) y Activo(s).</td>
      </tr>
      <tr>
        <td><hr /></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="1" cellspacing="3">
      <tr class="TITULO">
        <td height="40" align="center" bgcolor="#C7DEDD">Cédula de Identidad</td>
        <td align="center" bgcolor="#C7DEDD">Nombre(s) y Apellido(s)</td>
        <td align="center" bgcolor="#C7DEDD">Usuario</td>
        <td align="center">&nbsp;</td>
      </tr>
      <?php require '../Conexion_BD/Dbms_Usuario.php';
	 	  
	    $roles=mysql_query("select * from usuarios where NOMBRES like '%$txtNombres%' and ESTADO='DESBLOQUEADO' order by PRIMER_APELLIDO");
	  
		  while($rows=mysql_fetch_array($roles)){$CONT++;?>
      <tr>
        <td bgcolor="#F0F4F4"><?php echo $rows['CEDULA_IDENTIDAD'].' '.$rows['EXPEDIDO'];?></td>
        <td bgcolor="#F0F4F4"><?php echo $rows['NOMBRES'].' '.$rows['PRIMER_APELLIDO'].' '.$rows['SEGUNDO_APELLIDO'];?></td>
        <td bgcolor="#F0F4F4"><?php echo $rows['USUARIO'];?></td>
        <td bgcolor="#F0F4F4"><a href="frmModificar2.php?USUARIO=<?php echo $rows['USUARIO'];?>" title="SELECCIONAR USUARIO DE <?php echo $rows['NOMBRES'].' '.$rows['PRIMER_APELLIDO'].' '.$rows['SEGUNDO_APELLIDO'];?>"><img src="../Img/modificar.png" width="25" height="25" /></a></td>
      </tr>
      <?php } ?><?php require '../Conexion_BD/Cerrar_Dbms.php';?>
    </table></td>
  </tr>
  <tr>
    <td class="TITULO">&nbsp;</td>
  </tr><?php } ?>
  <tr>
    <td class="TITULO">&nbsp;</td>
  </tr>
  <tr>
    <td class="TITULO">&nbsp;</td>
  </tr>
  <tr>
    <td class="ASTERISCO">Ver 0.</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body></form>
</html><?php if($hdfReg==1 and $CONT==0){echo  "<script>alert('No se encontró registros.')</script>";echo"<script> location.href='frmModificar.php';</script>";}?>