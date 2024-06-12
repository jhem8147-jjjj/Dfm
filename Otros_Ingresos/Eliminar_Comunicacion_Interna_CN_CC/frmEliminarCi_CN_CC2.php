<?php  require_once('../Control_Sesiones_Forms/frmControlSesionUsuario.php');
require_once('../Control_Sesiones_Forms/Loading.php'); 
require '../Conexion_BD/Dbms.php';
$_SESSION['COD_ASOCIACION']=$COD_ASOCIACION;
$_SESSION['ASOCIACION']=$ASOCIACION;
$_SESSION['CODIGO_REGISTRO']=$CODIGO_REGISTRO;
if($REGCC==1){
//CUENTA 
$resy=mysql_query("select  COUNT(*) from reg_contribuyente_habilitado_pago_complementacion RCC, contribuyentes CONTRI where RCC.CODIGO_REGISTRO='$CODIGO_REGISTRO' and RCC.CODIGO_ASOCIACION='$COD_ASOCIACION' and RCC.CODIGO_CONTRIBUYENTE=CONTRI.CODIGO_CONTRIBUYENTE and RCC.ESTADO='ACTIVO'  and CONTRI.ESTADO='ACTIVO'");
while($rowy=mysql_fetch_array($resy)){$TOTAL=$rowy[0]; }
//modifica el estado del contribuyente habilitado para el pago de COMPLEMENTACION.
$query = mysql_query("UPDATE reg_contribuyente_habilitado_pago_complementacion  SET ESTADO='COMPLEMENTACION DE CONTRIBUYENTES  ELIMINADO POR EL USUARIO $US_SIOI - $SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO, FECHA: $FECHA HORA: $HORA',ESTADO_PAGO='COMPLEMENTACION DE CONTRIBUYENTES ELIMINADO POR EL USUARIO $US_SIOI - $SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO, FECHA: $FECHA HORA: $HORA',ESTADO_ORDEN_PAGO='COMPLEMENTACION DE CONTRIBUYENTES ELIMINADO POR EL USUARIO $US_SIOI - $SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO, FECHA: $FECHA HORA: $HORA',OBSERVACIONES='COMPLEMENTACION DE CONTRIBUYENTES ELIMINADO FECHA: $FECHA HORA: $HORA' where  CODIGO_REGISTRO='$CODIGO_REGISTRO' and ESTADO='ACTIVO'")or die ("NO SE PUDO ACTUALIZAR LOS DATOS DE LA MODIFICACION DE reg_contribuyente_habilitado_pago_complementacion.");

// REISTRA EN TRANSACCIONES 
$sql1="insert into reg_contribuyente_transacciones(PC_NAME,PC_IP,USUARIO,NOMBRE_USUARIO,FECHA,HORA,CODIGO_REGISTRO,CODIGO_ASOCIACION,ASOCIACION,TRANSACCION_1,DESCRIPCION_TRAMITE,OBSERVACIONES,ENLACE)values('$hostname','$hostlocal','$US_SIOI','$SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO','$FECHA','$HORA','$CODIGO_REGISTRO','$COD_ASOCIACION','$ASOCIACION','COMPLEMENTACION DE CONTRIBUYENTE','COMPLEMENTACION(ES) DE CONTRIBUYENTE(S) ELIMINADO(S) POR EL USUARIO $US_SIOI - $SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO, FECHA: $FECHA HORA: $HORA TOTAL DE CONTRIBUYENTE(S): $TOTAL','COMPLEMENTACION(ES) DE CONTRIBUYENTE(S) ELIMINADO(S) POR EL USUARIO $US_SIOI - $SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO, FECHA: $FECHA HORA: $HORA TOTAL DE CONTRIBUYENTE(S): $TOTAL','0')";$result=mysql_query($sql1)or die ("NO SE PUDO REGISTRAR EN LA ENTIDAD reg_contribuyente_transacciones."); 

echo"<script> alert('( ($TOTAL) Complemento de Contribuyentes Eliminados.');</script>";
echo"<script> location.href='frmEliminarCi_CN_CC.php';</script>";
	
}

if($REGCN==1){
//CUENTA 
$resy=mysql_query("select  COUNT(*) from reg_contribuyente_habilitado_pago_cambio_nombre RCN, contribuyentes CONTRI where RCN.CODIGO_REGISTRO='$CODIGO_REGISTRO' 
and RCN.CODIGO_ASOCIACION='$COD_ASOCIACION' and RCN.CODIGO_CONTRIBUYENTE_ENTRANTE=CONTRI.CODIGO_CONTRIBUYENTE and RCN.ESTADO='ACTIVO'  and CONTRI.ESTADO='ACTIVO'");
while($rowy=mysql_fetch_array($resy)){$TOTAL=$rowy[0]; }
			  
//modifica el estado del contribuyente habilitado para el pago de cambio de nombre
$query = mysql_query("UPDATE reg_contribuyente_habilitado_pago_cambio_nombre  SET ESTADO='CAMBIO DE NOMBRE ELIMINADO POR EL USUARIO $US_SIOI - $SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO, FECHA: $FECHA HORA: $HORA',ESTADO_PAGO='CAMBIO DE NOMBRE ELIMINADO POR EL USUARIO $US_SIOI - $SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO, FECHA: $FECHA HORA: $HORA',ESTADO_ORDEN_PAGO='CAMBIO DE NOMBRE ELIMINADO POR EL USUARIO $US_SIOI - $SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO, FECHA: $FECHA HORA: $HORA',OBSERVACIONES='CAMBIO DE NOMBRE ELIMINADO POR EL USUARIO $US_SIOI - $SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO, FECHA: $FECHA HORA: $HORA' where  CODIGO_REGISTRO='$CODIGO_REGISTRO' and ESTADO='ACTIVO'")or die ("NO SE PUDO ACTUALIZAR LOS DATOS DE LA MODIFICACION DE reg_contribuyente_habilitado_pago_cambio_nombre.");

// REISTRA EN TRANSACCIONES 
$sql1="insert into reg_contribuyente_transacciones(PC_NAME,PC_IP,USUARIO,NOMBRE_USUARIO,FECHA,HORA,CODIGO_REGISTRO,CODIGO_ASOCIACION,ASOCIACION,TRANSACCION_1,DESCRIPCION_TRAMITE,OBSERVACIONES,ENLACE)values('$hostname','$hostlocal','$US_SIOI','$SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO','$FECHA','$HORA','$CODIGO_REGISTRO','$COD_ASOCIACION','$ASOCIACION','CAMBIO DE AFILIADOS','CAMBIO(S) DE NOMBRE(S) ELIMINADO(S) POR EL USUARIO $US_SIOI - $SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO, FECHA: $FECHA HORA: $HORA TOTAL DE CONTRIBUYENTE(S): $TOTAL','CAMBIO(S) DE NOMBRE(S) ELIMINADO(S) POR EL USUARIO $US_SIOI - $SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO, FECHA: $FECHA HORA: $HORA TOTAL DE CONTRIBUYENTE(S): $TOTAL','0')";$result=mysql_query($sql1)or die ("NO SE PUDO REGISTRAR EN LA ENTIDAD reg_contribuyente_transacciones."); 

echo"<script> alert('( ($TOTAL) Cambi(s) de Nombre(s) Eliminados.');</script>";
echo"<script> location.href='frmEliminarCi_CN_CC.php';</script>";
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
<script type="text/javascript"> 
$(function() {
       $(".checkbox").click(function() {
         $(".delete").attr("disabled", !this.checked);
		 $(".delete1").attr("disabled", !this.checked);
       });
});
</script>
</head>
<body>
<table width="100%" border="0">
  <tr>
    <td><img src="../Img/Blanco.png" width="10" height="6" /></td>
    <td><table width="90%" border="0" align="left">
      <tr>
        <td align="center" class="TITULO">ELIMINAR REGISTRO COMUNICACIONES INTERNAS</td>
      </tr>
      <tr>
        <td align="center" class="SUBTITULO"><?php if($CC==1){echo 'COMPLEMENTACION';}else{echo 'CAMBIO DE NOMBRE';}?></td>
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
            <td height="32" align="right" bgcolor="#CCCCCC">Registro Documento  :</td>
            <td style="font-weight: bold"><?php echo utf8_decode($row['ORDENANZA_MUNICIPAL']);?></td>
          </tr>
          <tr>
            <td align="right" bgcolor="#CCCCCC"><img src="../Img/Linea_Negra.png" width="400" height="2" /></td>
            <td style="font-weight: bold">          
          </tr>
          <tr>
            <td width="33%" height="32" align="right" bgcolor="#CCCCCC">Asociación Seleccionada :</td>
            <td width="67%" style="font-weight: bold"><?php echo utf8_decode($row['DESCRIPCION']);?>
              
            
          </tr> <?php }?>
          <tr>
            <td align="right" bgcolor="#CCCCCC"><img src="../Img/Linea_Negra.png" width="400" height="2" /></td>
            <td style="font-weight: bold">          
          </tr>
          <tr>
            <td height="32" align="right" bgcolor="#CCCCCC">Zona Tributaria :</td>
            <td style="font-weight: bold"><?php $liqui=mysql_query("select ZT.DESCRIPCION from zona_tributaria ZT,reg_asociacion_zona_tributaria RAZT where RAZT.CODIGO_ASOCIACION='$COD_ASOCIACION' and RAZT.CODIGO_ZONA=ZT.CODIGO_ZONA and RAZT.ESTADO='ACTIVO' and ZT.ESTADO='ACTIVO'");while($rowt=mysql_fetch_array($liqui)){ echo $rowt[0];  } ?>                      
          </tr>
          <tr>
            <td align="right" bgcolor="#CCCCCC"><img src="../Img/Linea_Negra.png" width="400" height="2" /></td>
            <td style="font-weight: bold">          
          </tr>
          <tr>
            <td height="32" align="right" bgcolor="#CCCCCC">Gestión :</td>
            <td style="font-weight: bold"><?php echo $GESTIONSELECIONADA; ?>                      
          </tr>
          <tr>
            <td align="right" bgcolor="#CCCCCC"><img src="../Img/Linea_Negra.png" width="400" height="2" /></td>
            <td style="font-weight: bold">          
          </tr>
          <tr>
            <td height="32" align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span> Eliminar el Listado de Registros :</td>
            <td style="font-weight: bold"><input type="checkbox" name="msg[]" value="1" class="checkbox" /><span style="font-style: italic; color: #F00;">Seleccione la Casilla si esta de acuerdo para Eliminar los Registros que se muestran.</span></tr>
         
        </table></td>
      </tr>
    <?php if($CC==1){?>  
    <tr>
      <td style="font-weight: bold">&nbsp;</td>
    </tr>
    <tr>
      <td style="font-weight: bold">&nbsp;</td>
    </tr>
    <tr>
        <td style="font-weight: bold">Registro de Complementación de Contribuyentes Realizados.</td>
      </tr>
      <tr>
        <td style="font-weight: bold"><hr /></td>
      </tr>
      <tr>
        <td style="font-weight: bold"><table cellpadding="2" cellspacing="2" class="table table-striped table-bordered" id="example2" style="width:100%;">
          <thead>
            <tr style="font-weight: bold">
              <td height="38" align="center" bgcolor="#CCCCCC">No.</td>
              <td align="center" bgcolor="#CCCCCC">FECHA</td>
              <td align="center" bgcolor="#CCCCCC">USUARIO</td>
              <td align="center" bgcolor="#CCCCCC"> DOCUMENTO</td>
              <td align="center" bgcolor="#CCCCCC">NOMBRE(S) Y APELLIDO(S)</td>
              <td align="center" bgcolor="#CCCCCC">SOLICITUD DOCUMENTO</td>
              <td align="center" bgcolor="#CCCCCC">GESTION</td>
              <td align="center" bgcolor="#CCCCCC">TIPO PUESTO</td>
              <td align="center" bgcolor="#CCCCCC">FILA</td>
              <td align="center" bgcolor="#CCCCCC">PUESTO</td>
              <td align="center" bgcolor="#CCCCCC">COMUNICACION INTERNA</td>
              </tr>
          </thead>
          <tbody>
            <?php 
	 
	  $res=mysql_query("select  CONTRI.TIPO_DOCUMENTO,CONTRI.DOC_IDENTIDAD,CONTRI.DOC_IDENTIDAD_ALFA,CONTRI.EXPEDIDO,CONTRI.NOMBRE_RSOCIAL,CONTRI.PRIMER_APELLIDO,CONTRI.SEGUNDO_APELLIDO,CONTRI.APELLIDO_ESPOSO,RCC.CODIGO_GREMIAL,RCC.DOCUMENTO,RCC.GESTION,RCC.TIPO_VENTA,RCC.FILA,RCC.PUESTO,RCC.COMUNICACION_INTERNA,RCC.ESTADO_COMUNICACION_INTERNA,RCC.USUARIO,RCC.NOMBRE_USUARIO,RCC.FECHA,RCC.HORA from reg_contribuyente_habilitado_pago_complementacion RCC, contribuyentes CONTRI where RCC.CODIGO_REGISTRO='$CODIGO_REGISTRO' and RCC.CODIGO_ASOCIACION='$COD_ASOCIACION' and RCC.CODIGO_CONTRIBUYENTE=CONTRI.CODIGO_CONTRIBUYENTE and RCC.ESTADO='ACTIVO'  and CONTRI.ESTADO='ACTIVO'");
		  	  while($row=mysql_fetch_array($res)){ 
	 	  $SW2=1;?>
            <tr>
              <td><?php $cont++; echo $cont; ?></td>
              <td><?php echo utf8_decode($row[18].' Hrs. '.$row[19]); ?></td>
              <td><?php echo utf8_decode($row[16].' - '.$row[17]); ?></td>
              <td><?php if($row[2]== null){ echo  $row[1].' '.$row[3];}else{echo $row[0].' '.$row[1].' - '.$row[2].' '.$row[3];} ?></td>
              <td><?php if($row[7]== null){echo $row[4].' '.$row[5].' '.$row[6];}else{echo $row[4].' '.$row[5].' '.$row[6].' de '.$row[7];} ?></td>
              <td><?php echo $row[9]; ?></td>
              <td><?php echo $row[10]; ?></td>
              <td><?php echo $row[11]; ?></td>
              <td><?php echo $row[12]; ?></td>
              <td><?php echo $row[13]; ?></td>
              <td><?php echo $row[14]; ?></td>
              </tr><?php } ?>
            <tr>
              <td colspan="11" align="center"><form method="post" action="frmEliminarCi_CN_CC2.php"> <input name="REGCC" type="hidden" id="REGCC" value="1" />                <input type="submit" class="delete" name="button2" id="button2" value="CONFIRMAR ELIMINAR REGISTRO" style="width:230px; height:35px" disabled="disabled" /></form></td>
              </tr>
            
          </tbody>
        </table></td>
      </tr> <?php } ?>
   <?php if($CN==1){?>   
   <tr>
     <td style="font-weight: bold">&nbsp;</td>
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
              <td align="center" bgcolor="#CCCCCC">FECHA</td>
              <td align="center" bgcolor="#CCCCCC">USUARIO</td>
              <td align="center" bgcolor="#CCCCCC"> DOCUMENTO</td>
              <td align="center" bgcolor="#CCCCCC">NOMBRE(S) Y APELLIDO(S)</td>
              <td align="center" bgcolor="#CCCCCC">TIPO DE CAMBIO DE NOMBRE</td>
              <td align="center" bgcolor="#CCCCCC">TIPO PUESTO</td>
              <td align="center" bgcolor="#CCCCCC">FILA</td>
              <td align="center" bgcolor="#CCCCCC">PUESTO</td>
              <td align="center" bgcolor="#CCCCCC">COMUNICACION INTERNA</td>
              </tr>
          </thead>
          <tbody>
            <?php 
	 
	  $res=mysql_query("select  CONTRI.TIPO_DOCUMENTO,CONTRI.DOC_IDENTIDAD,CONTRI.DOC_IDENTIDAD_ALFA,CONTRI.EXPEDIDO,CONTRI.NOMBRE_RSOCIAL,CONTRI.PRIMER_APELLIDO,CONTRI.SEGUNDO_APELLIDO,CONTRI.APELLIDO_ESPOSO,CONTRI.CODIGO_CONTRIBUYENTE,CONTRI.REGISTRO,RCN.REGISTRO_GREMIAL,RCN.TIPO_CAMBIO,RCN.TIPO_PUESTO,RCN.FILA,RCN.PUESTO,RCN.FECHA,RCN.HORA,RCN.USUARIO,RCN.COMUNICACION_INTERNA,RCN.NOMBRE_USUARIO from reg_contribuyente_habilitado_pago_cambio_nombre RCN, contribuyentes CONTRI where RCN.CODIGO_REGISTRO='$CODIGO_REGISTRO' and RCN.CODIGO_ASOCIACION='$COD_ASOCIACION' and RCN.CODIGO_CONTRIBUYENTE_ENTRANTE=CONTRI.CODIGO_CONTRIBUYENTE and RCN.ESTADO='ACTIVO'  and CONTRI.ESTADO='ACTIVO'");
		  	  while($row=mysql_fetch_array($res)){ 
	 	  $SW2=1;?>
            <tr>
              <td><?php $cont++; echo $cont; ?></td>
              <td><?php echo utf8_decode($row[15].' Hrs. '.$row[16]); ?></td>
              <td><?php echo utf8_decode($row[17].' - '.$row[19]); ?></td>
              <td><?php if($row[2]== null){ echo  $row[1].' '.$row[3];}else{echo $row[0].' '.$row[1].' - '.$row[2].' '.$row[3];} ?></td>
              <td><?php if($row[7]== null){echo $row[4].' '.$row[5].' '.$row[6];}else{echo $row[4].' '.$row[5].' '.$row[6].' de '.$row[7];} ?></td>
              <td><?php echo $row[11]; ?></td>
              <td><?php echo $row[12]; ?></td>
              <td><?php if($row[13]== null){ echo '-';}else{echo $row[13];} ?></td>
              <td><?php echo $row[14]; ?></td>
              <td><?php echo $row[18]; ?></td>
              </tr>
            <?php } ?>
          </tbody>
        </table></td>
      </tr>
      <tr>
        <td align="center"><form method="post" action="frmEliminarCi_CN_CC2.php"><input name="REGCN" type="hidden" id="REGCN" value="1" />
          <input type="submit" class="delete1" name="button" id="button" value="CONFIRMAR ELIMINAR REGISTRO" style="width:230px; height:35px" disabled="disabled" /></form></td>
      </tr>  <?php } ?>
      <tr>
        <td align="center"><table width="100%" border="0">
          <tr>
            <td align="center">&nbsp;</td>
          </tr>
          <tr>
            <td align="left" class="ASTERISCO">Es Responsabilidad del Operador la ELIMINACION DE REGISTROS.</td>
          </tr>
          <tr>
            <td align="center"><a href="frmEliminarCi_CN_CC1.php">Volver Átras</a></td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
      </tr>
      <tr>
        <td class="ASTERISCO">VER. 2</td>
      </tr>
    </table></td>
  </tr>
</table>
<?php include '../CssTablas/frmPieTabla.php'?>
</body>
</html><?php require '../Conexion_BD/Cerrar_Dbms.php';
if($cont==0){echo"<script> alert('No Existen Contribuyentes Habilitados para Cmabio de Nombre');</script>";
	echo"<script> location.href='frmEliminarCi_CN_CC.php';</script>";}
?>