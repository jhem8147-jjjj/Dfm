<?php require_once('../Control_Sesiones_Forms/frmControlSesionUsuario.php');
require_once('../Control_Sesiones_Forms/Loading.php'); 
require '../Conexion_BD/Dbms.php';
if($AGREGARP==1){

$sql1="insert into reg_contribuyente_transacciones(PC_NAME,PC_IP,USUARIO,NOMBRE_USUARIO,FECHA,HORA,CODIGO_REGISTRO,CODIGO_ASOCIACION,ASOCIACION,TRANSACCION_1,DESCRIPCION_TRAMITE,OBSERVACIONES,ENLACE)values('$hostname','$hostlocal','$US_SIOI','$SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO','$FECHA','$HORA','$txtCodigoRegistro','$COD_ASOCIACION','$ASOCIACION','COMPLEMENTACION DE CONTRIBUYENTE','COMPLEMENTACION DE CONTRIBUYENTE ACTUALIZACION DE PUESTO DE VENTA $sltPuesto, FILA $txtFila, PUESTO $txtPuesto','COMPLEMENTACION DE CONTRIBUYENTE ACTUALIZACION DE PUESTO DE VENTA $sltPuesto, FILA $txtFila, PUESTO $txtPuesto','0')";$result=mysql_query($sql1)or die ("NO SE PUDO REGISTRAR EN LA ENTIDAD reg_contribuyente_transacciones."); 

$query = mysql_query("UPDATE reg_contribuyente_habilitado_pago_complementacion  SET TIPO_VENTA='$sltPuesto',FILA='$txtFila',PUESTO='$txtPuesto' where ID='$IDS' and ESTADO='ACTIVO'")or die ("NO SE PUDO ACTUALIZAR LOS DATOS DE LA MODIFICACION DE reg_contribuyente_habilitado_pago_complementacion.");
echo"<script> alert('Se Agregó Datos de la Actividad del Contribuyente');</script>";
echo"<script> location.href='frmComplementacion2.php';</script>";
	}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel='StyleSheet' href='../Css_Formularios/frmProcesos.css' type="text/css">
<script src='Js/frmValida.js' type="text/javascript"></script>
</head>
<form method="post" action="frmComplementacionAgregarAct.php">
<body>
<table width="50%" border="0">
  <tr>
    <td align="center" class="TITULO">COMPLEMENTO</td>
  </tr>
  <tr>
    <td align="center" class="SUBTITULO">AGREGAR DATOS PUESTO DE VENTA</td>
  </tr>
  <tr>
    <td><img src="../Img/Blanco.png" width="600" height="6" /></td>
  </tr>
  <tr>
    <td align="left"><table width="20%" border="0">
      <tr>
        <td colspan="2"  align="left" style="font-weight: bold">DATOS CONTRIBUYENTE.</td>
      </tr>
      <tr>
        <td colspan="2"  align="left"><hr /></td>
      </tr><?php $res=mysql_query("select C.DOC_IDENTIDAD,C.DOC_IDENTIDAD_ALFA,C.EXPEDIDO,C.NOMBRE_RSOCIAL,C.PRIMER_APELLIDO,C.SEGUNDO_APELLIDO,C.APELLIDO_ESPOSO from reg_contribuyente_habilitado_pago_complementacion RCHPC,contribuyentes C where RCHPC.Id='$IDS' and RCHPC.ESTADO='ACTIVO' and RCHPC.CODIGO_CONTRIBUYENTE='$CODIGO_CONTRIBUYENTE' AND C.CODIGO_CONTRIBUYENTE='$CODIGO_CONTRIBUYENTE' and C.ESTADO='ACTIVO' ");while($row=mysql_fetch_array($res)){ ?>
      <tr>
        <td  align="right" bgcolor="#CCCCCC">Documento de Identificacion :</td>
        <td style="font-weight: bold"><?php if($row['1']== null){echo $row['0'];}else{echo $row['0'].' - '.$row['1']
		; }?></td>
      </tr>
      <tr>
        <td  align="right" bgcolor="#CCCCCC">Expedido :</td>
        <td style="font-weight: bold"><?php echo $row[2];?></td>
      </tr>
      <tr>
        <td  align="right" bgcolor="#CCCCCC">Nombre(s) y Apellido(s) :</td>
        <td style="font-weight: bold"><?php if($row['6']== null){echo $row['3'].' '.$row['4'].' '.$row['5'];}else{echo $row['3'].' '.$row['4'].' '.$row['5'].' de '.$row['6'];}?></td>
      </tr><?php } ?>
      <tr>
        <td colspan="2"  align="left" style="font-weight: bold">DATOS ACTIVIDAD ECONOMICA.</td>
      </tr>
      <tr>
        <td colspan="2"  align="left"><hr /></td>
        </tr>
      <tr>
        <td  align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span> TIPO DE ACTIVIDAD ECONOMICA :</td>
        <td style="font-weight: bold"><select name="sltPuesto" id="sltPuesto">
          <option selected="selected">PUESTO DE VENTA</option>
          <option>KIOSCO</option>
          <option>CARRITO</option>
        </select>
          <input name="AGREGARP" type="hidden" id="AGREGARP" value="1" />
          <input name="IDS" type="hidden" id="IDS" value="<?php echo $IDS;?>" /></td>
      </tr>
      <tr>
        <td  align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span> FILA :</td>
        <td style="font-weight: bold"><input name="txtFila" type="text" id="txtFila" style="width:200px; height:20px" onkeyup="buscar_ajax(this.value);return fileValidationAec();" size="10" onkeypress="return soloLetrasNumeros(event)" placeholder="FILA"/></td>
      </tr>
      <tr>
        <td  align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span> PUESTO:</td>
        <td style="font-weight: bold"><input name="txtPuesto" type="text" id="txtPuesto" style="width:200px; height:20px" onkeyup="buscar_ajax(this.value);return fileValidationAec();" size="10" onkeypress="return soloLetrasNumeros(event)" placeholder="PUESTO"/></td>
      </tr>
      <tr>
        <td width="46%"  align="right" bgcolor="#CCCCCC">&nbsp;</td>
        <td width="54%" style="font-weight: bold"><input type="submit" name="button" id="button" value="Aceptar" style="width:200px; height:35px" /></td>
      </tr>
      <tr>
        <td colspan="2"  align="right"></td>
      </tr>
      <tr>
        <td colspan="2"  align="right"><img src="../Img/Blanco.png" width="661" height="6" /></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center"><a href="frmComplementacion2.php">Volver</a></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="ASTERISCO">VER. 4</td>
  </tr>
</table>
</body></form>
</html><?php require '../Conexion_BD/Cerrar_Dbms.php';?>