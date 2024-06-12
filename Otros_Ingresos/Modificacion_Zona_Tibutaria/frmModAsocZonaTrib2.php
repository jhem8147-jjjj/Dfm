<?php require_once('../Control_Sesiones_Forms/frmControlSesionUsuario.php');
require_once('../Control_Sesiones_Forms/Loading.php'); 
require '../Conexion_BD/Dbms.php';
if($txtMod==1){

//ELIMINA LOS REGISTROS ACTIVOS O SUBIDOS CON ANTERIOR ZONA TRIBUTARIA

$query = mysql_query("UPDATE reg_contribuyente_habilitado_pago  SET ESTADO='NO ACTIVO',ESTADO_REGISTRO='ZONA TRIBUTARIA MODIFICADA POR: $US_SIOI-$SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO FECHA: $FECHA Hrs. $HORA.',ESTADO_PAGO='ZONA TRIBUTARIA MODIFICADA POR: $US_SIOI-$SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO FECHA: $FECHA Hrs. $HORA.',ESTADO_ORDEN_PAGO='ZONA TRIBUTARIA MODIFICADA POR: $US_SIOI-$SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO FECHA: $FECHA Hrs. $HORA.',OBSERVACIONES='ZONA TRIBUTARIA MODIFICADA POR: $US_SIOI-$SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO FECHA: $FECHA Hrs. $HORA, DOCUMENTO $txtDocumentoRespaldo AUTORIZADO: $txtAutorizado-$sltCargo.' where ESTADO='ACTIVO' and CODIGO_ASOCIACION='$COD_ASOCIACION' and CODIGO_ZONA='$CODIGOACTUAL' and ESTADO='ACTIVO'")or die ("NO SE PUDO ACTUALIZAR LOS DATOS DEL reg_contribuyente_habilitado_pago.");
	
$COD_ASOC=date('Ymd His');
$COD_REGISTRO=date('Ymd His');
//actualiza la zona tributaria
$query = mysql_query("UPDATE reg_asociacion_zona_tributaria  SET ESTADO='DATOS MODIFICADOS $US_SIOI - $SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO, FECHA $FECHA Hrs. $HORA.' where CODIGO_ASOCIACION='$COD_ASOCIACION' AND CODIGO_ZONA='$CODIGOACTUAL' AND ESTADO='ACTIVO'")or die ("NO SE PUDO ACTUALIZAR LOS DATOS DEL reg_asociacion_zona_tributaria.");
//BUSCA ZONA TRIBUTARIA
$result=mysql_query("select * from zona_tributaria where DESCRIPCION='$sltZonaTributaria' and ESTADO='ACTIVO'"); while($row=mysql_fetch_array($result)){ $ZONATRIB=$row['CODIGO_ZONA'];$MONTO=$row['MONTO'];}	
//REGISTRA LA NUEVA ZONA TRIBUTARIA
$sql1="insert into reg_asociacion_zona_tributaria(PC_NAME,PC_IP,USUARIO,NOMBRE_USUARIO,FECHA,HORA,CODIGO_REGISTRO,CODIGO_ASOCIACION,CODIGO_ZONA)values('$hostname','$hostlocal','$US_SIOI','$SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO','$FECHA','$HORA','$COD_ASOC','$COD_ASOCIACION','$ZONATRIB')";$result=mysql_query($sql1)or die ("NO SE PUDO REGISTRAR EN LA ENTIDAD REGISTRO reg_asociacion_zona_tributaria.");
/*ACTUALIZA reg_contribuyente_asociacion*/
$query = mysql_query("UPDATE reg_contribuyente_asociacion  SET CODIGO_ZONA='$ZONATRIB',OBSERVACIONES_MODIFICACIONES='MODIFICACION DE ZONA TRIBUTARIA $US_SIOI- $SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO FECHA: $FECHA Hrs. $HORA' where ESTADO='ACTIVO' and CODIGO_ASOCIACION='$COD_ASOCIACION' AND CODIGO_ZONA='$CODIGOACTUAL'")or die ("NO SE PUDO ACTUALIZAR LOS DATOS DEL reg_contribuyente_habilitado_pago.");

//REGISTRA LA MODIFICACION DE LA ZONA TRIBUTARIA
$sql1="insert into reg_contribuyente_transacciones(PC_NAME,PC_IP,USUARIO,NOMBRE_USUARIO,FECHA,HORA,CODIGO_REGISTRO,CODIGO_ASOCIACION,ASOCIACION,CODIGO_ZONA,TRANSACCION_1,DESCRIPCION_TRAMITE,OBSERVACIONES,ENLACE)values('$hostname','$hostlocal','$US_SIOI','$SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO','$FECHA','$HORA','$COD_REGISTRO','$COD_ASOCIACION','$ASOCIACION','$ZONATRIB','MODIFICACION DE ZONA TRIBUTARIA','MODIFICACION DE ZONA TRIBUTARIA $ASOCIACION','MODIFICACION DE ZONA TRIBUTARIA MEDIANTE DOCUMENTO $txtDocumentoRespaldo AUTORIZADO: $txtAutorizado-$sltCargo.','0')";$result=mysql_query($sql1)or die ("NO SE PUDO REGISTRAR EN LA ENTIDAD reg_contribuyente_transacciones."); 			 
echo "<script>alert('Se módifico la Zona Tributaria de la Asociación $ASOCIACION.')</script>";
echo"<script> location.href='frmModAsocZonaTrib.php';</script>";
}

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel='StyleSheet' href='../Css_Formularios/frmProcesos.css' type="text/css">
<script src='Js/frmValida.js' type="text/javascript"></script>
</head>
<form  method="post" action='frmModificacionAsociacion1.php' enctype="multipart/form-data">
<body>
<table width="10%" border="0">
  <tr>
    <td align="center" class="TITULO">MODIFICAR ASOCIACION</td>
  </tr>
  <tr>
    <td align="center" class="SUBTITULO">Zona Tributaria</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td style="font-weight: bold">DATOS NUEVA ASOCIACION.</td>
  </tr>
  <tr>
    <td><hr /></td>
  </tr>
  <tr>
    <td><table width="20%" border="0">
      <?php $res=mysql_query("select * from reg_asociacion where CODIGO_ASOCIACION='$COD_ASOCIACION' and ESTADO='ACTIVO'"); while($rows=mysql_fetch_array($res)){ ?><tr>
        <td align="right" bgcolor="#CCCCCC">Nro. Carpeta :</td>
        <td><?php echo $rows['CARPETA']; ?></td>
        <td class="comentario">&nbsp;</td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC">Ordenanza Municipal :</td>
        <td><?php echo $rows['ORDENANZA_MUNICIPAL']; ?></td>
        <td class="comentario">&nbsp;</td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC">Nombre de la Asociación :</td>
        <td><?php echo $rows['DESCRIPCION']; ?></td>
        <td class="comentario">&nbsp;</td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC">Zona de Asentamiento :</td>
        <td><?php echo $rows['ZONA_UBICACION']; ?></td>
        <td class="comentario">&nbsp;</td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC">Direccion descriptiva de puestos de Venta :</td>
        <td><?php echo $rows['DIRECCION']; ?></td>
        <td class="comentario">&nbsp;</td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC">Observaciones :</td>
        <td><?php echo $rows['OBSERVACIONES']; ?></td>
        <td>&nbsp;</td>
      </tr><?php } ?>
      <tr>
        <td colspan="3" align="left" style="font-weight: bold">DATOS PUESTOS DE VENTA.</td>
      </tr>
      <tr>
        <td colspan="3" align="right"><hr /></td>
        </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC">Cantidad de Puestos de Venta :</td>
        <td><?php $res=mysql_query("select * from reg_asociacion_puesto where DESCRIPCION='PUESTOS DE VENTA' and CODIGO_ASOCIACION='$COD_ASOCIACION' and ESTADO='ACTIVO'"); while($rows=mysql_fetch_array($res)){ echo $rows['AFILIADOS'];}?></td>
        <td class="comentario">&nbsp;</td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC">Cantidad de Carritos :</td>
        <td><?php $res=mysql_query("select * from reg_asociacion_puesto where DESCRIPCION='CARRITOS' and CODIGO_ASOCIACION='$COD_ASOCIACION' and ESTADO='ACTIVO'"); while($rows=mysql_fetch_array($res)){ echo $rows['AFILIADOS'];}?></td>
        <td class="comentario">&nbsp;</td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC">Cantidad Kioskos :</td>
        <td><?php $res=mysql_query("select * from reg_asociacion_puesto where DESCRIPCION='KIOSKO' and CODIGO_ASOCIACION='$COD_ASOCIACION' and ESTADO='ACTIVO'"); while($rows=mysql_fetch_array($res)){ echo $rows['AFILIADOS'];}?></td>
        <td class="comentario">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="3" align="left" style="font-weight: bold">DATO ZONA TRIBUTARIA.</td>
      </tr>
      <tr>
        <td colspan="3" align="right"><hr /></td>
        </tr><?php $res=mysql_query("select ZT.DESCRIPCION,ZT.MONTO from reg_asociacion_zona_tributaria RAZT,zona_tributaria ZT where RAZT.CODIGO_ASOCIACION='$COD_ASOCIACION' and  RAZT.CODIGO_ZONA=ZT.CODIGO_ZONA and RAZT.ESTADO='ACTIVO' and ZT.ESTADO='ACTIVO'"); while($rows=mysql_fetch_array($res)){ ?>
      <tr>
        <td align="right" bgcolor="#CCCCCC">Zona Tributaria Actual :</td>
        <td><?php  echo $rows[0];$ACTUAL=$rows[0];?></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC">Impuesto Eventual Definido :</td>
        <td><?php  echo $rows[1];?></td>
        <td>&nbsp;</td>
      </tr><?PHP } ?>
      <tr>
        <td align="right"><img src="../Img/Blanco.png" width="400" height="6" /></td>
        <td class="comentario"><img src="../Img/Blanco.png" width="400" height="6" /></td>
        <td class="comentario">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center"><a href="frmModAsocZonaTrib.php">Volver</a></td>
  </tr>
  <tr>
    <td class="ASTERISCO">VER. 2</td>
  </tr>
</table>
</body></form>
</html><?php require '../Conexion_BD/Cerrar_Dbms.php'; ?>