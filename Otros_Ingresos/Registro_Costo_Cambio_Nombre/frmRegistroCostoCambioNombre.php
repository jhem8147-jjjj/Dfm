<?php require_once('../Control_Sesiones_Forms/frmControlSesionUsuario.php');
require 'frmControlSesion.php';
require_once('../Control_Sesiones_Forms/Loading.php'); require '../Conexion_BD/Dbms.php';
if($txtCodigoRegistro==1){

$COD_REGISTRO=date('Ymd His').rand(1,10);
$query = mysql_query("UPDATE cambio_nombre  SET ESTADO='NO ACTIVO',OBSERVACIONES='MODIFICADO POR EL USUARIO: $US_SIOI - $SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO EN FECHA $FECHA HORA $HORA' where ESTADO='ACTIVO'")or die ("NO SE PUDO ACTUALIZAR LOS DATOS DEL cambio_nombre.");

$sql1="insert into cambio_nombre(PC_NAME,PC_IP,USUARIO,NOMBRE_USUARIO,FECHA,HORA,CODIGO_REGISTRO,MONTO,FORMULARIO,OBSERVACIONES)values('$hostname','$hostlocal','$US_SIOI','$SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO','$FECHA','$HORA','$COD_REGISTRO','$txtCosto','$txtFormulario','$txtObservaciones')";$result=mysql_query($sql1)or die ("NO SE PUDO REGISTRAR EN LA ENTIDAD cambio_nombre.");	

$query = mysql_query("UPDATE reg_contribuyente_habilitado_pago_cambio_nombre  SET MONTO='$txtCosto',FORMULARIO='$txtFormulario',ESTADO_ORDEN_PAGO='NO VALIDADO' where ESTADO_PAGO='NO PAGO' and ESTADO='ACTIVO'")or die ("NO SE PUDO ACTUALIZAR LOS DATOS DEL reg_contribuyente_habilitado_pago_cambio_nombre.");

$sql1="insert into reg_contribuyente_transacciones(PC_NAME,PC_IP,USUARIO,NOMBRE_USUARIO,FECHA,HORA,CODIGO_REGISTRO,ASOCIACION,TRANSACCION_1,DESCRIPCION_TRAMITE,OBSERVACIONES,ENLACE)values('$hostname','$hostlocal','$US_SIOI','$SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO','$FECHA','$HORA','$COD_REGISTRO','CAMBIO DE NOMBRE','CAMBIO DE NOMBRE','REGISTRO, MODIFICACION DE COSTO CAMBIO DE NOMBRE','MODIFICO COSTO CAMBIO DE NOMBRE - COSTO=$txtCosto Bs.-, FORMULARIO=$txtFormulario Bs.-','0')";$result=mysql_query($sql1)or die ("NO SE PUDO REGISTRAR EN LA ENTIDAD reg_contribuyente_transacciones.");	
}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel='StyleSheet' href='../Css_Formularios/frmProcesos.css' type="text/css">
<script src='Js/frmValida.js' type="text/javascript"></script>
</head>

<body>
<table width="10%" border="0" align="left">
  <tr>
    <td align="center" class="TITULO">CAMBIO DE NOMBRE</td>
  </tr>
  <tr>
    <td align="center" class="SUBTITULO">Registro Costo</td>
  </tr>
  <tr>
    <td><span style="font-weight: bold">DATOS DE DOCUMENTO.</span></td>
  </tr>
  <tr>
    <td style="font-weight: bold"><img src="../Img/Linea.png" width="700" height="4" /></td>
  </tr>
  <tr>
    <td><form method="post" action="frmRegistroCostoCambioNombre.php"><table width="100%" border="0" cellpadding="1" cellspacing="1" bordercolor="#FFFFFF">
      <tr>
        <td width="28%" align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span> Costo Bs.- :</td>
        <td width="72%" style="font-weight: normal; font-size: 9px;"><input name="txtCosto" type="text" id="txtCosto" onchange="javascript:this.value=this.value.toUpperCase();" onkeypress="return soloNumeros(event)" placeholder="COSTO UNITARIO" onkeyup="return fileValidation();" required/>
          <input name="txtCodigoRegistro" type="hidden" id="txtCodigoRegistro" value="1" /></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span> Formulario Bs.- :</td>
        <td style="font-weight: bold; font-size: 14px;"><input name="txtFormulario" type="text" id="txtFormulario" onchange="javascript:this.value=this.value.toUpperCase();" onkeypress="return soloNumeros(event)" placeholder="COSTO UNITARIO" onkeyup="return fileValidation();" required="required"/></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC">Observaciones :</td>
        <td style="font-weight: bold; font-size: 14px;"><textarea name="txtObservaciones" id="txtObservaciones" onchange="javascript:this.value=this.value.toUpperCase();" onkeypress="return soloNumAlfSig(event)" cols="45" rows="3">NINGUNA OBSERVACION.</textarea></td>
      </tr>
      <tr>
        <td align="right">&nbsp;</td>
        <td style="font-weight: bold; font-size: 14px;"><input type="submit" name="button" id="button" value="Aceptar" style="width:200px; height:35px" /></td>
      </tr>
      <tr>
        <td align="right">&nbsp;</td>
        <td class="ASTERISCO" style="font-size: 14px; font-style: italic;">Es responsabilidad del Operador el llenado de los datos.</td>
      </tr>
    </table>
    </form></td>
  </tr>
  <tr>
    <td align="left">&nbsp;</td>
  </tr>
  <tr>
    <td align="left" style="font-weight: bold; font-size: 12px;">TABLA DE VALORES REGISTRADOS.</td>
  </tr>
  <tr>
    <td align="left"><hr /></td>
  </tr>
  <tr>
    <td align="left">&nbsp;</td>
  </tr>
  <tr>
    <td><table id="example" class="table table-striped table-bordered" style="width:100%;">
      <thead>
        <tr>
          <td height="36" align="center" bgcolor="#CCCCCC" style="font-weight: bold">No</td>
          <td align="center" bgcolor="#CCCCCC" style="font-weight: bold">USUARIO</td>
          <td align="center" bgcolor="#CCCCCC" style="font-weight: bold">FECHA Y HORA</td>
          <td align="center" bgcolor="#CCCCCC" style="font-weight: bold">COSTO</td>
          <td align="center" bgcolor="#CCCCCC" style="font-weight: bold">FORMULARIO</td>
          <td align="center" bgcolor="#CCCCCC" style="font-weight: bold">OBSERVACIONES</td>
          <td align="center" bgcolor="#CCCCCC" style="font-weight: bold">ESTADO</td>
        </tr>
      </thead>
      <tbody>
        <?php $rest=mysql_query("select * from cambio_nombre order by Id DESC");
	  while($rowt=mysql_fetch_array($rest)){  ?>
        <tr>
          <td height="24" bgcolor="#F4F4F4"><?php $cont++; echo $cont;?></td>
          <td bgcolor="#F4F4F4"><?php echo $rowt['USUARIO'].' - '.$rowt['NOMBRE_USUARIO'];?></td>
          <td bgcolor="#F4F4F4"><?php echo $rowt['FECHA'].' Hrs. '.$rowt['HORA'];?></td>
          <td bgcolor="#F4F4F4"><?php echo $rowt['MONTO'];?></td>
          <td bgcolor="#F4F4F4"><?php echo $rowt['FORMULARIO'];?></td>
          <td bgcolor="#F4F4F4"><?php echo $rowt['OBSERVACIONES'];?></td>
          <td bgcolor="#F4F4F4"><?php echo $rowt['ESTADO'];?></td>
        </tr>
        <?php } ?>
      </tbody>
      <tfoot>
      </tfoot>
      <tfoot>
      </tfoot>
    </table></td>
  </tr>
  <tr>
    <td class="ASTERISCO">VER. 0</td>
  </tr>
</table>
</body>
</html><?php require '../Conexion_BD/Cerrar_Dbms.php'; ?>