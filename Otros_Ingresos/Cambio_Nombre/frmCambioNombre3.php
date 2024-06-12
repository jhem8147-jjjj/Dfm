<?php  require_once('../Control_Sesiones_Forms/frmControlSesionUsuario.php');
require_once('../Control_Sesiones_Forms/Loading.php'); 
require '../Conexion_BD/Dbms.php';
$_SESSION['COD_ASOCIACION']=$COD_ASOCIACION;
$_SESSION['ASOCIACION']=$ASOCIACION;
if($MOD==1){
//modifica el estado del contribuyente habilitado para el pago de cambio de nombre
$query = mysql_query("UPDATE reg_contribuyente_habilitado_pago_cambio_nombre  SET ESTADO='CAMBIO DE NOMBRE ELIMINADO POR EL USUARIO $US_SIOI - $SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO, FECHA: $FECHA HORA: $HORA',ESTADO_PAGO='CAMBIO DE NOMBRE ELIMINADO POR EL USUARIO $US_SIOI - $SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO, FECHA: $FECHA HORA: $HORA',ESTADO_ORDEN_PAGO='CAMBIO DE NOMBRE ELIMINADO POR EL USUARIO $US_SIOI - $SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO, FECHA: $FECHA HORA: $HORA',OBSERVACIONES='CAMBIO DE NOMBRE REALIZADO POR $TIPO_CAMBIO, POR EL USUARIO $US_SIOI - $SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO, FECHA: $FECHA HORA: $HORA' where  ID='$ID' and CODIGO_REGISTRO='$COD_REGISTRO' and ESTADO='ACTIVO'")or die ("NO SE PUDO ACTUALIZAR LOS DATOS DE LA MODIFICACION DE reg_contribuyente_habilitado_pago_cambio_nombre.");
// REISTRA EN TRANSACCIONES 
$sql1="insert into reg_contribuyente_transacciones(PC_NAME,PC_IP,USUARIO,NOMBRE_USUARIO,FECHA,HORA,CODIGO_REGISTRO,CODIGO_ASOCIACION,ASOCIACION,TRANSACCION_1,DESCRIPCION_TRAMITE,OBSERVACIONES,ENLACE)values('$hostname','$hostlocal','$US_SIOI','$SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO','$FECHA','$HORA','$COD_REGISTRO','$COD_ASOCIACION','$ASOCIACION','CAMBIO DE AFILIADOS','CAMBIO DE NOMBRE ELIMINADO POR EL USUARIO $US_SIOI - $SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO, FECHA: $FECHA HORA: $HORA CODIGO CONTRIBUYENTE $CODIGO_CONTRIBUYENTE, GREMIAL $NUMERO_GREMIAL','CAMBIO DE NOMBRE ELIMINADO POR EL USUARIO $US_SIOI - $SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO, FECHA: $FECHA HORA: $HORA CODIGO CONTRIBUYENTE $CODIGO_CONTRIBUYENTE, GREMIAL $NUMERO_GREMIAL','0')";$result=mysql_query($sql1)or die ("NO SE PUDO REGISTRAR EN LA ENTIDAD reg_contribuyente_transacciones."); 
	}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel='StyleSheet' href='../Css_Formularios/frmProcesos.css' type="text/css">
<link rel="stylesheet" href="../CssTablas/Css/bootstrap.min.css">
<link rel="stylesheet" href="../CssTablas/Css/dataTables.bootstrap.min.css">
<script src="../CssTablas/Js/jquery-3.3.1.js"></script>
<script src="../CssTablas/Js/jquery.dataTables.min.js"></script> 
<script src="../CssTablas/Js/dataTables.bootstrap.min.js"></script>
</head>
<form method="post" action="frmCambioNombre4.php">
<body>
<table width="100%" border="0">
  <tr>
    <td><img src="../Img/Blanco.png" width="10" height="6" /></td>
    <td><table width="90%" border="0" align="left">
      <tr>
        <td align="center" class="TITULO">CAMBIO DE AFILIADO</td>
      </tr>
      <tr>
        <td align="center" class="SUBTITULO">LISTADO DE CAMBIO DE NOMBRE - REALIZADOS</td>
      </tr>
      <tr>
        <td style="font-weight: bold">Asociacion Seleccionado.</td>
      </tr>
      <tr>
        <td style="font-weight: bold"><img src="../Img/Linea.png" width="1070" height="2" /></td>
      </tr>
      <tr>
        <td style="font-weight: bold"><table width="100%" border="0" bordercolor="#FFFFFF">
        <?php $result=mysql_query("select * from reg_asociacion where CODIGO_ASOCIACION='$COD_ASOCIACION' and ESTADO='ACTIVO'"); while($row=mysql_fetch_array($result)){ ?>  <tr>
            <td height="32" align="right" bgcolor="#CCCCCC">Ordenanza Municipal :</td>
            <td style="font-weight: bold"><?php echo utf8_decode($row['ORDENANZA_MUNICIPAL']);?></td>
          </tr>
          <tr>
            <td width="33%" height="32" align="right" bgcolor="#CCCCCC">Asociación Seleccionada :</td>
            <td width="67%" style="font-weight: bold"><?php echo utf8_decode($row['DESCRIPCION']);?>
              
            
          </tr>
          <tr>
            <td height="32" align="right" bgcolor="#CCCCCC">Zona Tributaria :</td>
            <td style="font-weight: bold"><?php $liqui=mysql_query("select ZT.DESCRIPCION from zona_tributaria ZT,reg_asociacion_zona_tributaria RAZT where RAZT.CODIGO_ASOCIACION='$COD_ASOCIACION' and RAZT.CODIGO_ZONA=ZT.CODIGO_ZONA and RAZT.ESTADO='ACTIVO' and ZT.ESTADO='ACTIVO'");while($rowt=mysql_fetch_array($liqui)){ echo $rowt[0];  } ?>          
            </tr>
          <?php }?>
        </table></td>
      </tr>
      <tr>
        <td style="font-weight: bold">Registro de Cambio de Nombre(s) Realizado(s).</td>
      </tr>
      <tr>
        <td><span style="font-weight: bold"><img src="../Img/Linea.png" width="1070" height="2" /></span></td>
      </tr>
      <tr>
        <td><table cellpadding="2" cellspacing="2" class="table table-striped table-bordered" id="example" style="width:100%;">
          <thead>
            <tr style="font-weight: bold">
              <td height="38" align="center" bgcolor="#CCCCCC">No.</td>
              <td align="center" bgcolor="#CCCCCC"> DOCUMENTO</td>
              <td align="center" bgcolor="#CCCCCC">NOMBRE(S) Y APELLIDO(S)</td>
              <td align="center" bgcolor="#CCCCCC">TIPO DE CAMBIO DE NOMBRE</td>
              <td align="center" bgcolor="#CCCCCC">TIPO PUESTO</td>
              <td align="center" bgcolor="#CCCCCC">FILA</td>
              <td align="center" bgcolor="#CCCCCC">PUESTO</td>
              <td align="center" bgcolor="#CCCCCC">&nbsp;</td>
              </tr>
          </thead>
          <tbody>
            <?php 
	 
	  $res=mysql_query("select  CONTRI.TIPO_DOCUMENTO,CONTRI.DOC_IDENTIDAD,CONTRI.DOC_IDENTIDAD_ALFA,CONTRI.EXPEDIDO,CONTRI.NOMBRE_RSOCIAL,CONTRI.PRIMER_APELLIDO,CONTRI.SEGUNDO_APELLIDO,CONTRI.APELLIDO_ESPOSO,CONTRI.CODIGO_CONTRIBUYENTE,CONTRI.REGISTRO,RCN.REGISTRO_GREMIAL,RCN.TIPO_CAMBIO,RCN.TIPO_PUESTO,RCN.FILA,RCN.PUESTO,RCN.MONTO,RCN.Id,RCN.FORMULARIO from reg_contribuyente_habilitado_pago_cambio_nombre RCN, contribuyentes CONTRI where RCN.CODIGO_REGISTRO='$COD_REGISTRO' and RCN.CODIGO_ASOCIACION='$COD_ASOCIACION' and RCN.CODIGO_CONTRIBUYENTE_ENTRANTE=CONTRI.CODIGO_CONTRIBUYENTE and RCN.ESTADO='ACTIVO'  and CONTRI.ESTADO='ACTIVO' order by CONTRI.REGISTRO,CONTRI.NOMBRE_RSOCIAL,CONTRI.PRIMER_APELLIDO,CONTRI.SEGUNDO_APELLIDO ");
		  	  while($row=mysql_fetch_array($res)){ 
	 	  $SW2=1;?>
            <tr>
              <td><?php $cont++; echo $cont; ?></td>
              <td><?php if($row[2]== null){ echo  $row[1].' '.$row[3];}else{echo $row[0].' '.$row[1].' - '.$row[2].' '.$row[3];} ?></td>
              <td><?php if($row[7]== null){echo $row[4].' '.$row[5].' '.$row[6];}else{echo $row[4].' '.$row[5].' '.$row[6].' de '.$row[7];} ?></td>
              <td><?php echo $row[11]; ?></td>
              <td><?php echo $row[12]; ?></td>
              <td><?php if($row[13]== null){ echo '-';}else{echo $row[13];} ?></td>
              <td><?php echo $row[14]; ?></td>
              <td><table width="100%" border="0">
                <tr>
                  <td width="20%"><img src="../Img/excluir.png" width="20" height="20" /></td>
                  <td width="80%" align="left"><a href="frmCambioNombre3.php?COD_REGISTRO=<?php echo $COD_REGISTRO;?>&NUMERO_GREMIAL=<?php echo $row[10];?>&CODIGO_CONTRIBUYENTE=<? echo $row[8];?>&MOD=1&ID=<? echo $row[16];?>" title="ELIMINAR CONTRIBUYENTE">Eliminar</a></td>
                  </tr>
              </table></td>
              </tr>
            <?php } ?>
          </tbody>
        </table></td>
      </tr>
      <tr>
        <td><hr /></td>
      </tr>
      <tr>
        <td align="center"><table width="100%" border="0">
          <tr>
            <td align="right"><a href="frmCambioNombre1.php">Volver Átras</a></td>
            <td align="right">|</td>
            <td><input name="txtCont" type="hidden" id="txtCont" value="<?php echo $cont;?>" />
              <input type="submit" name="button" id="button" value="FINALIZAR CAMBIO DE NOMBRE" style="width:220px; height:35px" /></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
      </tr>
      <tr>
        <td class="ASTERISCO">VER. 4</td>
      </tr>
    </table></td>
  </tr>
</table>
<?php include '../CssTablas/frmPieTabla.php'?>
</body></form>
</html><?php require '../Conexion_BD/Cerrar_Dbms.php';
if($cont==0){echo"<script> alert('No Existen Contribuyentes Habilitados para Cmabio de Nombre');</script>";
	echo"<script> location.href='frmCambioNombre1.php';</script>";}
?>