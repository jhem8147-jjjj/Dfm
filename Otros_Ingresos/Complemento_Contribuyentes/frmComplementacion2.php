<?php require_once('../Control_Sesiones_Forms/frmControlSesionUsuario.php');
require_once('../Control_Sesiones_Forms/Loading.php'); 
require '../Conexion_BD/Dbms.php';
$_SESSION['COD_REGISTRO']=$COD_REGISTRO;
$_SESSION['CODIGO_ZONA_TRIB']=$CODIGO_ZONA_TRIB;
 $_SESSION['COD_ASOCIACION']=$COD_ASOCIACION;
$_SESSION['ASOCIACION']=$ASOCIACION;
$_SESSION['txtCodigoRegistro']=$txtCodigoRegistro;
$_SESSION['txtDocumento']=$txtDocumento;
$_SESSION['txtFecha']=$txtFecha;
$_SESSION['txtObservaciones']=$txtObservaciones;
$_SESSION['sltGestion']=$sltGestion;
if(empty($_SESSION['COD_REGISTRO'])){include_once("Index.php");}
if(empty($_SESSION['CODIGO_ZONA_TRIB'])){include_once("Index.php");}

if($REGISTRAR==1){
//BUSCA EL REGISTRO DEL CONTRIBUYENTE
$SWCONT=0;
$rest=mysql_query("select * from contribuyentes where CODIGO_CONTRIBUYENTE='$CODIGO_CONTRIBUYENTE' and ESTADO='ACTIVO' ");while($rot=mysql_fetch_array($rest)){$SWCONT=1;}
if($SWCONT==1){
$res=mysql_query("select * from nros_correlativos   and CODIGO_ZONA_ like  '$CODIGO_ZONA_TRIB' ");while($ro=mysql_fetch_array($res)){
$NUMERO_GREMIAL=$ro['NRO_PUESTO']+1;}
$query = mysql_query("UPDATE nros_correlativos  SET NRO_PUESTO='$NUMERO_GREMIAL'")or die ("NO SE PUDO ACTUALIZAR LOS DATOS DEL nros_correlativos.");
//OBTIENE EL MONTO DE COMPLEMENTO
$liqui=mysql_query("select * from complemento where ESTADO='ACTIVO'");while($rowt=mysql_fetch_array($liqui)){ $MONTOS=$rowt['MONTO'];$FORMULARIOS=$rowt['FORMULARIO'];}
$sql1="insert into reg_contribuyente_habilitado_pago_complementacion(PC_NAME,PC_IP,USUARIO,NOMBRE_USUARIO,FECHA,HORA,CODIGO_REGISTRO,CODIGO_GREMIAL,CODIGO_CONTRIBUYENTE,CODIGO_ASOCIACION,CODIGO_ZONA,DOCUMENTO,FECHA_DOCUMENTO,OBSERVACIONES_REGISTRO,GESTION,MONTO,FORMULARIO)values('$hostname','$hostlocal','$US_SIOI','$SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO','$FECHA','$HORA','$txtCodigoRegistro','$NUMERO_GREMIAL','$CODIGO_CONTRIBUYENTE','$COD_ASOCIACION','$CODIGO_ZONA_TRIB','$txtDocumento','$txtFecha','$txtObservaciones','$sltGestion','$MONTOS','$FORMULARIOS')";$result=mysql_query($sql1)or die ("NO SE PUDO REGISTRAR EN LA ENTIDAD reg_contribuyente_habilitado_pago_complementacion.");
echo"<script> alert('Se Adiciono Contribuyente');</script>";	
//REGISTRA EN TRANSACCIONES
$sql1="insert into reg_contribuyente_transacciones(PC_NAME,PC_IP,USUARIO,NOMBRE_USUARIO,FECHA,HORA,CODIGO_REGISTRO,CODIGO_ASOCIACION,ASOCIACION,TRANSACCION_1,DESCRIPCION_TRAMITE,OBSERVACIONES,ENLACE)values('$hostname','$hostlocal','$US_SIOI','$SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO','$FECHA','$HORA','$txtCodigoRegistro','$COD_ASOCIACION','$ASOCIACION','COMPLEMENTACION DE CONTRIBUYENTE','COMPLEMENTACION DE CONTRIBUYENTE CON CODIGO CONTRIBUYENTE $CODIGO_CONTRIBUYENTE NUMERO GREMIAL $NUMERO_GREMIAL PARA LA GESTION $sltGestion DOCUMENTO $txtDocumento.','COMPLEMENTACION DE CONTRIBUYENTE CON CODIGO CONTRIBUYENTE $CODIGO_CONTRIBUYENTE NUMERO GREMIAL $NUMERO_GREMIAL PARA LA GESTION $sltGestion  DOCUMENTO $txtDocumento.','0')";$result=mysql_query($sql1)or die ("NO SE PUDO REGISTRAR EN LA ENTIDAD reg_contribuyente_transacciones."); 
}
}
if($ELIMINAR==1){
$query = mysql_query("UPDATE reg_contribuyente_habilitado_pago_complementacion  SET ESTADO='ELIMINADO POR EL USUARIO $US_SIOI - $SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO, FECHA: $FECHA HORA: $HORA',COMUNICACION_INTERNA='ELIMINADO POR EL USUARIO $US_SIOI - $SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO, FECHA: $FECHA HORA: $HORA',ESTADO_COMUNICACION_INTERNA='ELIMINADO POR EL USUARIO $US_SIOI - $SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO, FECHA: $FECHA HORA: $HORA',ENLACE='ELIMINADO POR EL USUARIO $US_SIOI - $SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO, FECHA: $FECHA HORA: $HORA',ESTADO_PAGO='ELIMINADO POR EL USUARIO $US_SIOI - $SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO, FECHA: $FECHA HORA: $HORA',ESTADO_ORDEN_PAGO='ELIMINADO POR EL USUARIO $US_SIOI - $SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO, FECHA: $FECHA HORA: $HORA',OBSERVACIONES='REGISTRO ELIMINADO, POR EL USUARIO $US_SIOI - $SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO, FECHA: $FECHA HORA: $HORA' where CODIGO_CONTRIBUYENTE='$CODIGO_CONTRIBUYENTE' and ID='$IDS' and ESTADO='ACTIVO'")or die ("NO SE PUDO ACTUALIZAR LOS DATOS DE LA MODIFICACION DE reg_contribuyente_habilitado_pago_complementacion.");
echo"<script> alert('Se Elimino Contribuyente');</script>";

//REGISTRA EN TRANSACCIONES
$sql1="insert into reg_contribuyente_transacciones(PC_NAME,PC_IP,USUARIO,NOMBRE_USUARIO,FECHA,HORA,CODIGO_REGISTRO,CODIGO_ASOCIACION,ASOCIACION,TRANSACCION_1,DESCRIPCION_TRAMITE,OBSERVACIONES,ENLACE)values('$hostname','$hostlocal','$US_SIOI','$SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO','$FECHA','$HORA','$txtCodigoRegistro','$COD_ASOCIACION','$ASOCIACION','COMPLEMENTACION DE CONTRIBUYENTE','ELIMINO LA COMPLEMENTACION DE CONTRIBUYENTE CON CODIGO CONTRIBUYENTE $CODIGO_CONTRIBUYENTE PARA LA GESTION $sltGestion.','ELIMINO LA COMPLEMENTACION DE CONTRIBUYENTE CON CODIGO CONTRIBUYENTE $CODIGO_CONTRIBUYENTE $NUMERO_GREMIAL PARA LA GESTION $sltGestion.','0')";$result=mysql_query($sql1)or die ("NO SE PUDO REGISTRAR EN LA ENTIDAD reg_contribuyente_transacciones."); 
	}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel='StyleSheet' href='../Css_Formularios/frmProcesos.css' type="text/css">
</head>
<form method="post" action="frmComplementacion4.php">
<body>
<table width="100%" border="0" align="left">
  <tr>
    <td align="center" class="TITULO">COMPLEMENTACION</td>
  </tr>
  <tr>
    <td align="center" class="SUBTITULO">AGREGAR CONTRIBUYENTES</td>
  </tr>
  <tr>
    <td><span style="font-weight: bold">DATOS DE ASOCIACION.</span></td>
  </tr>
  <tr>
    <td style="font-weight: bold"><img src="../Img/Linea_Negra.png" width="880" height="2" /></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="1" cellspacing="1" bordercolor="#FFFFFF">
      <tr>
        <td height="32" align="right" bgcolor="#CCCCCC">Documento de Registro :</td>
        <td style="font-weight: bold"><?php echo $OMS;?></td>
      </tr>
      <tr>
        <td width="28%" height="32" align="right" bgcolor="#CCCCCC">Asociación Seleccionada :</td>
        <td width="72%" style="font-weight: bold"><?php echo utf8_decode($ASOCIACION);?>
          <input name="COD_ASOCIACION" type="hidden" id="COD_ASOCIACION" value="<?php echo $COD_ASOCIACION;?>" />
          <input name="ASOCIACION" type="hidden" id="ASOCIACION" value="<?php echo utf8_decode($ASOCIACION);?>" />
          <input name="REG" type="hidden" id="REG" value="1" /></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC">Zona Tributaria :</td>
        <td style="font-weight: bold; font-size: 14px;"><span style="font-weight: bold">
          <?php $liqui=mysql_query("select ZT.DESCRIPCION,ZT.CODIGO_ZONA from zona_tributaria ZT,reg_asociacion_zona_tributaria RAZT where RAZT.CODIGO_ASOCIACION='$COD_ASOCIACION' and RAZT.CODIGO_ZONA=ZT.CODIGO_ZONA and RAZT.ESTADO='ACTIVO' and ZT.ESTADO='ACTIVO'");while($rowt=mysql_fetch_array($liqui)){ echo $rowt[0]; $ZONA_TRIB=$rowt[0];  $CODIGO_ZONA_TRIB=$rowt[1];} ?>
        </span></td>
      </tr>
      <tr>
        <td colspan="2" align="left" style="font-weight: bold">DATOS SOLICITUD.</td>
      </tr>
      <tr>
        <td colspan="2" align="left"><hr /></td>
        </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC">Gestión :</td>
        <td style="font-weight: bold; font-size: 14px;"><?php echo $sltGestion;?></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC">Documento :</td>
        <td style="font-weight: bold; font-size: 14px;"><input name="txtDocumento" type="hidden" id="txtDocumento" value="<?php echo $txtDocumento;?>" /><?php echo $txtDocumento;?></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC"> Fecha Documento :</td>
        <td style="font-weight: bold; font-size: 14px;"><input name="txtFecha" type="hidden" id="txtFecha" value="<?php echo $txtFecha;?>" />
          <?php echo $txtFecha;?></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC">Observaciones :</td>
        <td style="font-weight: bold; font-size: 14px;"><input name="txtObservaciones" type="hidden" id="txtObservaciones" value="<?php echo $txtObservaciones;?>" />
          <?php echo $txtObservaciones;?></td>
      </tr>
    </table>
  </td>
  </tr>
  <tr>
    <td align="left" style="font-weight: bold">Datos Contribuyente.</td>
  </tr>
  <tr>
    <td align="left" style="font-weight: bold"><img src="../Img/Linea_Negra.png" width="880" height="2" /></td>
  </tr>
  <tr>
    <td align="left" style="font-weight: bold"></td>
  </tr>
  <tr>
    <td align="center" style="font-weight: bold"><table width="100%" border="0" cellspacing="1" cellpadding="1">
      <tr>
        <td height="33" align="center" bgcolor="#CCCCCC">No.</td>
        <td align="center" bgcolor="#CCCCCC">Documento</td>
        <td align="center" bgcolor="#CCCCCC">Nombre(s) y Apellido(s)</td>
        <td align="center" bgcolor="#CCCCCC" >ACTIVIDAD</td>
        <td align="center" bgcolor="#CCCCCC" >FILA</td>
        <td align="center" bgcolor="#CCCCCC" >PUESTO</td>
        <td align="center" >&nbsp;</td>
        </tr><?php $rest=mysql_query("select RC.DOC_IDENTIDAD,RC.DOC_IDENTIDAD_ALFA,RC.EXPEDIDO,RC.NOMBRE_RSOCIAL,RC.PRIMER_APELLIDO,RC.SEGUNDO_APELLIDO,RC.APELLIDO_ESPOSO,RC.CODIGO_CONTRIBUYENTE,RCHPC.Id,RCHPC.TIPO_VENTA,RCHPC.FILA,RCHPC.PUESTO from contribuyentes RC, reg_contribuyente_habilitado_pago_complementacion RCHPC where RCHPC.CODIGO_REGISTRO='$txtCodigoRegistro' and RCHPC.CODIGO_ASOCIACION='$COD_ASOCIACION' and RC.ESTADO='ACTIVO' and RC.CODIGO_CONTRIBUYENTE=RCHPC.CODIGO_CONTRIBUYENTE and RCHPC.ESTADO='ACTIVO'");
		while($row=mysql_fetch_array($rest)){ $SW11=0;?>
      <tr>
        <td bgcolor="#E3F0F2"><?php $cont++; echo $cont;?></td>
        <td bgcolor="#E3F0F2"><?php if($row['1']== null){echo $row['0'].' '.$row['2'];}else{echo $row['0'].' - '.$row['1'].' '.$row['2'];};?></td>
        <td bgcolor="#E3F0F2"><?php if($row['6']== null){echo utf8_decode($row['3'].' '.$row['4'].' '.$row['5']);}else{echo utf8_decode($row['3'].' '.$row['4'].' '.$row['5'].' de '.$row['6']);}?></td>
        <td bgcolor="#E3F0F2"><?php echo $row['9']; if($row['9']=="NO DEFINIDO."){$SW11=1;}else{$SW11=0;}?></td>
        <td bgcolor="#E3F0F2"><?php echo $row['10'];if($row['10']=="NO DEFINIDO."){$SW11=1;}else{$SW11=0;}?></td>
        <td bgcolor="#E3F0F2"><?php echo $row['11'];if($row['11']=="NO DEFINIDO."){$SW11=1;}else{$SW11=0;}?></td>
        <td align="left"><table width="70%" border="0">
          <tr>
            <td width="10%" align="right"><img src="../Img/Adicionar.png" width="20" height="20" /></td>
            <td width="52%" ><a href="frmComplementacionAgregarAct.php?IDS=<?php echo $row['8'];?>&CODIGO_CONTRIBUYENTE=<?php echo $row['7'];?>" title="AGREGAR TIPO DE ACTIVIDAD ECONOMICA">Agregar Actividad</a></td>
            <td width="10%" align="right"><img src="../Img/excluir.png" width="20" height="20" /></td>
            <td width="28%" ><a href="frmComplementacion2.php?IDS=<?php echo $row['8'];?>&CODIGO_CONTRIBUYENTE=<?php echo $row['7'];?>&ELIMINAR=1" title="SELECCIONAR CONTRIBUYENTE">Eliminar</a></td>
            </tr>
        </table></td>
        </tr>  <?php } ?>
      <tr>
        <td bgcolor="#E3F0F2">&nbsp;</td>
        <td bgcolor="#E3F0F2">&nbsp;</td>
        <td bgcolor="#E3F0F2">&nbsp;</td>
        <td bgcolor="#E3F0F2">&nbsp;</td>
        <td bgcolor="#E3F0F2">&nbsp;</td>
        <td bgcolor="#E3F0F2">&nbsp;</td>
        <td><?php if($SW11==0){  $SW11=0;?><table width="30%" border="0">
          <tr>
            <td width="18%" align="right"><img src="../Img/Agregar.png" width="20" height="20" /></td>
            <td width="82%"><a href="frmComplementacion3.php">Adicionar</a></td>
            </tr>
        </table><?php } else{echo 'ASIGNE LOS DATOS DE LA ACTIVIDAD ECONOMICA.';}?></td>
        </tr>
    
    </table></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td align="center"><table width="30%" border="0">
      <tr>
        <td align="right"><a href="frmComplementacion.php">Volver</a></td>
      <?php if($SW11==0){ ?>  <td align="center">|</td>
        <td><input type="submit" name="button" id="button" value="Continuar" style="width:200px; height:35px" /></td><?php } ?>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="ASTERISCO">VER. 3</td>
  </tr>
</table>
</body></form>
</html><?php require '../Conexion_BD/Cerrar_Dbms.php';?>