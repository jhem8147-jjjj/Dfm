<?php header('Content-Type: text/html; charset=utf-8'); require_once('../Control_Sesiones_Forms/frmControlSesionUsuario.php');require_once('../Control_Sesiones_Forms/Loading.php'); require '../Conexion_BD/Dbms.php'; mysql_set_charset("utf8", $conexion_usuarios) or die("NO SE PUDO CONFIGURAR LA CONEXION UTF-8: " . mysql_error($conexion_usuarios));
if($txtMod==1){
$CONTSS=0;
/*CONSULTA SI ESTA LIQUIDADO*/	
$rest=mysql_query("select COUNT(*) from reg_contribuyente_habilitado_pago where  CODIGO_ASOCIACION='$COD_ASOCIACION' and ESTADO='ACTIVO' and CODIGO_REGISTRO='$CODIGOREGISTRO' and GESTION='$txtGestion' and ESTADO_PAGO='NO PAGO' and ESTADO_ORDEN_PAGO='NO VALIDADO'");while($rowt=mysql_fetch_array($rest)){ $CONTSS=$CONTSS+1;}
if($CONTSS>0){
//INHABILITA REGISTRO
$query = mysql_query("update reg_contribuyente_asociacion set ESTADO='NO ACTIVO', OBSERVACIONES_MODIFICACIONES='REGISTRO INHABILITADO POR EL USUARIO $US_SIOI-$SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO FECHA $FECHA HRS. $HORA, $txtObservaciones.' where CODIGO_ASOCIACION='$COD_ASOCIACION' and ESTADO='ACTIVO' and CODIGO_REGISTRO='$CODIGOREGISTRO'")or die ("NO SE PUDO ACTUALIZAR LOS DATOS DEL reg_contribuyente_habilitado_pago.");

$query = mysql_query("update reg_contribuyente_habilitado_pago set ESTADO='NO ACTIVO', ESTADO_PAGO='NO ACTIVO', ESTADO_REGISTRO='NO ACTIVO, REGISTRO INHABILITADO POR EL USUARIO $US_SIOI-$SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO, FECHA $FECHA HRS. $HORA',ESTADO_ORDEN_PAGO='NO ACTIVO, REGISTRO INHABILITADO POR EL USUARIO $US_SIOI-$SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO, FECHA $FECHA HRS. $HORA',COMUNICACION_INTERNA='NO ACTIVO, REGISTRO INHABILITADO POR EL USUARIO $US_SIOI-$SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO, FECHA $FECHA HRS. $HORA',ENLACE='NO ACTIVO, REGISTRO INHABILITADO POR EL USUARIO $US_SIOI-$SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO, FECHA $FECHA HRS. $HORA',OBSERVACIONES='NO ACTIVO, $txtObservaciones.' where CODIGO_ASOCIACION='$COD_ASOCIACION' and ESTADO='ACTIVO' and CODIGO_REGISTRO='$CODIGOREGISTRO' and GESTION='$txtGestion' and ESTADO_PAGO='NO PAGO' and ESTADO_ORDEN_PAGO='NO VALIDADO'")or die ("NO SE PUDO ACTUALIZAR LOS DATOS DEL reg_contribuyente_habilitado_pago.");
/*registra la transaccion*/
$COD_REGISTRO=date('Ymd His');
$sql1="insert into reg_contribuyente_transacciones(PC_NAME,PC_IP,USUARIO,NOMBRE_USUARIO,FECHA,HORA,CODIGO_REGISTRO,CODIGO_ASOCIACION,ASOCIACION,TRANSACCION_1,DESCRIPCION_TRAMITE,OBSERVACIONES,ENLACE)values('$hostname','$hostlocal','$US_SIOI','$SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO','$FECHA','$HORA','$COD_REGISTRO','$COD_ASOCIACION','$ASOCIACION','INHABILITACION MASIVA DE CONTRIBUYENTES','INHABILITACION MASIVA DE CONTRIBUYENTES HABILITADOS PARA LA GESTION DE COBRO $txtGestion - CODIGO HABILITADO CONTRIBUYENTES $CODIGOREGISTRO.','INHABILITACION MASIVA DE CONTRIBUYENTES HABILITADOS PARA LA GESTION DE COBRO $txtGestion - CODIGO HABILITADO CONTRIBUYENTES $CODIGOREGISTRO.','0')";$result=mysql_query($sql1)or die ("NO SE PUDO REGISTRAR EN LA ENTIDAD reg_contribuyente_transacciones."); 
echo "<script>alert('Se procedió a Inhabilitar los registros seleccionados.')</script>";echo"<script> location.href='frmDesimportar.php';</script>";
}else{
echo "<script>alert('No Se procedió a Inhabilitar los registros seleccionados, porque existe LIQUIDACION EMITIDA.')</script>";
$COD_REGISTRO=date('Ymd His');
$sql1="insert into reg_contribuyente_transacciones(PC_NAME,PC_IP,USUARIO,NOMBRE_USUARIO,FECHA,HORA,CODIGO_REGISTRO,CODIGO_ASOCIACION,ASOCIACION,TRANSACCION_1,DESCRIPCION_TRAMITE,OBSERVACIONES,ENLACE)values('$hostname','$hostlocal','$US_SIOI','$SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO','$FECHA','$HORA','$COD_REGISTRO','$COD_ASOCIACION','$ASOCIACION','INHABILITACION DE CONTRIBUYENTES','INTENTO DE INHABILITACION MASIVA DE CONTRIBUYENTES HABILITADOS PARA LA GESTION DE COBRO $txtGestion - CODIGO HABILITADO CONTRIBUYENTES $CODIGOREGISTRO.','INTENTO DE INHABILITACION DE CONTRIBUYENTES HABILITADOS PARA LA GESTION DE COBRO $txtGestion - CODIGO HABILITADO CONTRIBUYENTES $CODIGOREGISTRO.','0')";$result=mysql_query($sql1)or die ("NO SE PUDO REGISTRAR EN LA ENTIDAD reg_contribuyente_transacciones."); 
	}
}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel='StyleSheet' href='../Css_Formularios/frmProcesos.css' type="text/css">
</head>

<body>
<table width="50%" border="0">
  <tr>
    <td align="center" class="TITULO">DESHABILITAR MASIVAMENTE REGISTROS CARGADOS</td>
  </tr>
  <tr>
    <td align="center" class="SUBTITULO">DESHABILITAR REGISTROS CARGADOS</td>
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
      </tr>
      <tr>
        <td bgcolor="#E3F0F2">1</td>
        <td bgcolor="#E3F0F2">Registrar, Consolidar  la baja de registros de contribuyentes habilitados para el cobro de gestion fiscal <?php echo $txtGestion;?>.</td>
        <td><form  method="post" action='frmDesimportar3.php'>
          <span style="font-weight: bold">
          <input name="txtMod" type="hidden" id="txtMod" value="1" />
          <input name="COD_ASOCIACION" type="hidden" id="COD_ASOCIACION" value="<?php echo htmlspecialchars($COD_ASOCIACION, ENT_QUOTES, 'UTF-8');?>" />
          <input name="CODIGOREGISTRO" type="hidden" id="CODIGOREGISTRO" value="<?php echo $CODIGOREGISTRO;?>" />
          <input name="ASOCIACION" type="hidden" id="ASOCIACION" value="<?php echo htmlspecialchars($ASOCIACION, ENT_QUOTES, 'UTF-8');?>" />
          <input name="txtGestion" type="hidden" id="txtGestion" value="<?php echo $txtGestion;?>" />
          <input name="txtObservaciones" type="hidden" id="txtObservaciones" value="<?php echo $txtObservaciones;?>" />
          </span>
          <input type="submit" name="button3" id="button3" value="Registrar" style="width:200px; height:35px" /></form></td>
      </tr>
      <tr>
        <td bgcolor="#E3F0F2">2</td>
        <td bgcolor="#E3F0F2">Salir, permite terminar la tarea seleccionada.</td>
        <td><form  method="post" action='frmDesimportar.php' target="_blank">
          <input type="submit" name="button" id="button" value="Salir" style="width:200px; height:35px"/></form></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center"><a href="frmDesimportar.php">Volver</a></td>
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
    <td class="ASTERISCO">VER. 3</td>
  </tr>
</table>

</body>
</html><?php require '../Conexion_BD/Cerrar_Dbms.php';?>