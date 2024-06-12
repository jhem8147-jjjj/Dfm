<?php require '../Control_Sesiones_Forms/frmControlSesionUsuario.php';  require_once('../Control_Sesiones_Forms/Loading.php');
$FECHA=date('d/m/Y H:i:s');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel='StyleSheet' href='cssFormato.css' type="text/css">
</head>
<form method="post" action="Pdf/frmAdicionRoles.php">
<body>
<table width="70%" border="0">
  <tr>
    <td align="center" class="TITULO">MODIFICAR  USUARIO</td>
  </tr>
  <tr>
    <td align="center">AGREGAR, BAJA DE ROL(ES)</td>
  </tr><?php require '../Conexion_BD/Dbms_Usuario.php'; $roles=mysql_query("select * from usuarios where USUARIO='$USUARIO' and ESTADO='DESBLOQUEADO'");
		  while($rows=mysql_fetch_array($roles)){?>
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td align="right"><table width="100%" height="26" border="1" cellpadding="0" cellspacing="0" bordercolor="#6699FF">
          <tr bordercolor="#FF9900" bordercolorlight="#FF9900">
            <td align="right" bordercolor="#6699FF"> No. de Cédula de Identidad :<span style="text-align: right"></span></td>
          </tr>
        </table></td>
        <td><?php echo $rows['CEDULA_IDENTIDAD'].' '.$rows['EXPEDIDO'];?></td>
      </tr>
      <tr>
        <td align="right"><table width="100%" height="26" border="1" cellpadding="0" cellspacing="0" bordercolor="#6699FF">
          <tr bordercolor="#FF9900" bordercolorlight="#FF9900">
            <td align="right" bordercolor="#6699FF"> Nombre(s) :<span style="text-align: right"></span></td>
            </tr>
          </table></td>
        <td><?php echo $rows['NOMBRES'];?></td>
      </tr>
      <tr>
        <td align="right"><table width="100%" height="26" border="1" cellpadding="0" cellspacing="0" bordercolor="#6699FF">
          <tr bordercolor="#FF9900" bordercolorlight="#FF9900">
            <td align="right" bordercolor="#6699FF"> Primer Apellido :<span style="text-align: right"></span></td>
          </tr>
        </table></td>
        <td><?php echo $rows['PRIMER_APELLIDO'];?></td>
      </tr>
      <tr>
        <td align="right"><table width="100%" height="26" border="1" cellpadding="0" cellspacing="0" bordercolor="#6699FF">
          <tr bordercolor="#FF9900" bordercolorlight="#FF9900">
            <td align="right" bordercolor="#6699FF"> Segundo Apellido :</td>
          </tr>
        </table></td>
        <td><?php echo $rows['SEGUNDO_APELLIDO'];?></td>
      </tr>
      <tr>
        <td align="right"><table width="100%" height="26" border="1" cellpadding="0" cellspacing="0" bordercolor="#6699FF">
          <tr bordercolor="#FF9900" bordercolorlight="#FF9900">
            <td align="right" bordercolor="#6699FF"> Usuario Asignado :</td>
          </tr>
        </table></td>
        <td><?php echo $USUARIO;?></td>
      </tr><?php } require '../Conexion_BD/Cerrar_Dbms.php';?>
      <tr>
        <td align="right"><table width="100%" height="26" border="1" cellpadding="0" cellspacing="0" bordercolor="#6699FF">
          <tr bordercolor="#FF9900" bordercolorlight="#FF9900">
            <td align="right" bordercolor="#6699FF"> Asignar Nueva Contraseña :</td>
          </tr>
        </table></td> 
        <td align="left"><input type="checkbox" name="chkNueva" id="chkNueva" />
          <input name="USUARIO" type="hidden" id="USUARIO" value="<?php echo $USUARIO;?>" />
          <input type="submit" name="button2" id="button2" value="Aceptar" style="width:150px; height:50px"/></td>
      </tr>
      <tr>
        <td colspan="2" align="right"><table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td class="TITULO">Asignar Rol(es).</td>
          </tr>
          <tr>
            <td><hr /></td>
          </tr>
        </table></td>
        </tr>
      <tr>
        <td colspan="2" align="right"><table width="100%" border="0" cellpadding="3" cellspacing="3">
          <tr class="TITULO">
            <td height="40" align="center" bgcolor="#C7DEDD">PERFIL</td>
            <td align="center" bgcolor="#C7DEDD">DESCRIPCION</td>
            <td align="center" bgcolor="#C7DEDD">&nbsp;</td>
          </tr><?php require '../Conexion_BD/Dbms_Usuario.php';
		  if(isset($ELIMINAR)){
		  $query = mysql_query("UPDATE asignacion_roles SET ESTADO='NO ACTIVO. DESDE $FECHA ELIMINADO POR EL USUARIO $US_SIOI' where USUARIO='$USUARIO' and  CODIGO_ROL='$ELIMINAR' and ESTADO='VIGENTE'"); 
		  }
		  if(isset($AGREGAR)){
			  $sql="insert into asignacion_roles(PC_NAME,PC_IP,FECHA_REGISTRO,USUARIO_ADMIN,ASIGNADO_POR,USUARIO,CODIGO_ROL,SIGLA)
values('$hostname','$hostlocal','$FECHA','$US_SIOI','$SIAUNOMBRES $SIAUPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO','$USUARIO','$AGREGAR','$SIGLA')";
$result=mysql_query($sql)or die ("NO SE PUDO REGISTRAR EN LA TABLA ASIGNACION DE ROLES");
			  }
		  
		  $roles=mysql_query("select * from menu_oi where ESTADO='ACTIVO' order by SIGLA,DESCRIPCION");
		  while($rows=mysql_fetch_array($roles)){ $SW=0; 
		  $rol=mysql_query("select * from asignacion_roles where USUARIO='$USUARIO' and CODIGO_ROL='$rows[CODIGO_ROL]' and ESTADO='VIGENTE'");
		  while($row=mysql_fetch_array($rol)){$SW=1;} if($SW==0){?>
          <tr>
            <td bgcolor="#F0F4F4"><?php echo $rows['GRUPO'];?></td>
            <td bgcolor="#F0F4F4"><?php echo $rows['DESCRIPCION'];?></td>
            <td bgcolor="#F0F4F4"><?php echo "<a href='frmModificar2.php?AGREGAR=$rows[CODIGO_ROL]&SIGLA=$rows[SIGLA]&USUARIO=$USUARIO'>";?>Asignar</a></td>
          </tr><?php }} ?>
        </table></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td class="TITULO"> Rol(es)  Asignado(s) Vigente(s).</td>
      </tr>
      <tr>
        <td><hr /></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="3" cellspacing="3">
      <tr class="TITULO">
        <td height="40" align="center" bgcolor="#C7DEDD">PERFIL</td>
        <td align="center" bgcolor="#C7DEDD">DESCRIPCION</td>
        <td align="center" bgcolor="#C7DEDD">&nbsp;</td>
      </tr>
      <?php  
		  
		   $roles=mysql_query("select MS.SIGLA,MS.DESCRIPCION,MS.CODIGO_ROL from asignacion_roles AR, menu_oi MS where AR.USUARIO='$USUARIO' and AR.APLICACION='SIOI' and AR.CODIGO_ROL=MS.CODIGO_ROL and AR.ESTADO='VIGENTE' and MS.ESTADO='ACTIVO' order by MS.SIGLA,MS.DESCRIPCION");
		  while($rows=mysql_fetch_array($roles)){?>
      <tr>
        <td bgcolor="#F0F4F4"><?php echo $rows['0'];?></td>
        <td bgcolor="#F0F4F4"><?php echo $rows['1'];?></td>
        <td bgcolor="#F0F4F4"><?php echo "<a href='frmModificar2.php?ELIMINAR=$rows[2]&USUARIO=$USUARIO'>";?>Eliminar</a></td>
      </tr>
      <?php } ?>
    </table></td>
  </tr>
  <tr>
    <td align="center"><input type="submit" name="button" id="button" value="Aceptar" style="width:150px; height:50px"/></td>
  </tr>
  <tr>
    <td class="TITULO"><span class="ASTERISCO">Ver 1.</span></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<blockquote>&nbsp;</blockquote>
</body></form>
</html><?php require '../Conexion_BD/Cerrar_Dbms.php';?>