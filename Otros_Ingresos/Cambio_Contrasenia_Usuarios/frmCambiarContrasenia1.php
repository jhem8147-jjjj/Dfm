<?php require'../Control_Sesiones_Forms/frmControlSesionUsuario.php'; require'../Control_Sesiones_Forms/Loading.php'; require'../Control_Sesiones_Forms/Key.php';require '../Conexion_BD/Dbms_Usuario.php'; $COD_REGISTRO=date('Ymd His');$FECHA=date('d/m/Y'); $HORA=date('H:i:s'); $txtContrasenia=md5($txtContrasenia); $roles=mysql_query("select * from usuarios where  USUARIO='$US_SIOI' and PASSWORD='$txtContrasenia' and estado ='DESBLOQUEADO'");while($rows=mysql_fetch_array($roles)){$SW=1;} if($SW=='1' and ($txtContNueva==$txtContRepNueva) and ($txtContNueva!=" " or $txtContRepNueva!=" ")){/*cambia la contraseña*/ $txtContNueva=md5($txtContNueva);
$query = mysql_query("UPDATE usuarios SET PASSWORD='$txtContNueva' where USUARIO='$US_SIOI' and PASSWORD='$txtContrasenia' and ESTADO ='DESBLOQUEADO'")or die ("Error No se pudo cambiar la contraseña."); 

require '../Conexion_BD/Dbms.php';
$sql1="insert into reg_contribuyente_transacciones(PC_NAME,PC_IP,USUARIO,NOMBRE_USUARIO,FECHA,HORA,CODIGO_REGISTRO,CODIGO_ASOCIACION,ASOCIACION,TRANSACCION_1,DESCRIPCION_TRAMITE,OBSERVACIONES,ENLACE)values('$hostname','$hostlocal','$US_SIOI','$SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO','$FECHA','$HORA','$COD_REGISTRO','CAMBIO DE CONTRASEÑA DE USUARIO','CAMBIO DE CONTRASEÑA DE USUARIO','CAMBIO DE CONTRASEÑA DE USUARIO','CAMBIO DE CONTRASEÑA DE USUARIO.','CAMBIO DE CONTRASEÑA DE USUARIO.','0')";$result=mysql_query($sql1)or die ("NO SE PUDO REGISTRAR EN LA ENTIDAD reg_contribuyente_transacciones.");
echo "<script>alert('Se procedió a cambiar la Contraseña.')</script>";
 }else{

	 require '../Conexion_BD/Dbms.php';
$sql1="insert into reg_contribuyente_transacciones(PC_NAME,PC_IP,USUARIO,NOMBRE_USUARIO,FECHA,HORA,CODIGO_REGISTRO,CODIGO_ASOCIACION,ASOCIACION,TRANSACCION_1,DESCRIPCION_TRAMITE,OBSERVACIONES,ENLACE)values('$hostname','$hostlocal','$US_SIOI','$SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO','$FECHA','$HORA','$COD_REGISTRO','INTENTO DE CAMBIO DE CONTRASEÑA DE USUARIO','INTENTO DE CAMBIO DE CONTRASEÑA DE USUARIO','INTENTO DE CAMBIO DE CONTRASEÑA DE USUARIO','INTENTO DE  CAMBIO DE CONTRASEÑA DE USUARIO.','INTENTO DE  CAMBIO DE CONTRASEÑA DE USUARIO.','0')";$result=mysql_query($sql1)or die ("NO SE PUDO REGISTRAR EN LA ENTIDAD reg_contribuyente_transacciones.");	 
echo "<script>alert('Error en la contraseña.')</script>";} require '../Conexion_BD/Cerrar_Dbms.php'; ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
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

<body>
<table width="60%" border="0">
  <tr>
    <td align="center"><span style="font-family: Verdana, Geneva, sans-serif; font-weight: bold; font-size: 14px; color: #C33;">CAMBIAR CONTRASEÑA</span></td>
  </tr>
  <tr>
    <td><hr /></td>
  </tr>
  <tr>
    <td align="center"></td>
  </tr>
  <tr>
    <td align="center"></td>
  </tr>
  <tr>
    <td align="center"></td>
  </tr>
  <tr>
    <td align="center"></td>
  </tr>
  <tr>
    <td align="center"></td>
  </tr>
  <tr>
    <td align="center"><table width="80%" border="0">
      <tr>
        <td align="right"><a href="frmCambiarContrasenia.php">Volver a Intentarlo</a></td>
        <td align="center">|</td>
        <td align="left"><a href="../Autenticacion_Usuario/frmCuerpo.php">Salir</a></td>
      </tr>
    </table>      <a href="frmCuerpo.php"></a></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>