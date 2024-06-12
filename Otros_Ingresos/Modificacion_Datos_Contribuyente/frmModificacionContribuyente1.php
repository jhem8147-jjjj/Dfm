<?php  require_once('../Control_Sesiones_Forms/frmControlSesionUsuario.php');
require_once('../Control_Sesiones_Forms/Loading.php'); require '../Conexion_BD/Dbms.php';
if($REG==1){
if(strlen($txtCodigoRegistro)==0){include_once("Index.php");}
$sltExpedido=trim($sltExpedido);
$sltExpedido=limpia_puntos($sltExpedido);
$txtCi2=limpia_espacios($txtCi2);
$txtPrimerApellido=normaliza($txtPrimerApellido);
$txtSegundoApellido=normaliza($txtSegundoApellido);
$txtApellidoEsposo=normaliza($txtApellidoEsposo);
$txtObservaciones=normaliza($txtObservaciones);
$query = mysql_query("UPDATE contribuyentes  SET ESTADO='NO ACTIVO, MODIFICADO POR EL USUARIO: $US_SIOI - $SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO EN FECHA $FECHA HORA $HORA' where CODIGO_CONTRIBUYENTE='$txtCodigoContribuyente' and ESTADO='ACTIVO'")or die ("NO SE PUDO ACTUALIZAR LOS DATOS DEL contribuyentes.");
$sql="insert into contribuyentes(CODIGO_REGISTRO,CODIGO_CONTRIBUYENTE,DOC_IDENTIDAD,DOC_IDENTIDAD_ALFA,EXPEDIDO,TIPO_DOCUMENTO,NOMBRE_RSOCIAL,PRIMER_APELLIDO,SEGUNDO_APELLIDO,APELLIDO_ESPOSO,OBSERVACIONES)values('$txtCodigoRegistro','$txtCodigoContribuyente','$txtCi','$txtCi2','$sltExpedido','CEDULA DE IDENTIDAD','$txtNombres','$txtPrimerApellido','$txtSegundoApellido','$txtApellidoEsposo','NOMBRE(S) Y APELLIDO(S) MODIFICADOS. $txtObservaciones')";$result=mysql_query($sql)or die ("NO SE PUDO REGISTRAR EN LA ENTIDAD contribuyentes."); 
/*MODIFICACION DATOS COMPROBANTES DE PAGO*/
if($txtCi2==null){$CARNET=$txtCi.' '.$sltExpedido;}else{$CARNET=$txtCi.'-'.$txtCi2.' '.$sltExpedido;}
if($txtApellidoEsposo==null){$NOMBRESCONT=$txtNombres.' '.$txtPrimerApellido.' '.$txtSegundoApellido;}else{$NOMBRESCONT=$txtNombres.' '.$txtPrimerApellido.' '.$txtSegundoApellido.' de '.$txtApellidoEsposo;}


$query = mysql_query("UPDATE reg_contribuyente_asociacion_pago  SET CEDULA_IDENTIDAD='$CARNET',CONTRIBUYENTE='$NOMBRESCONT',OBSERVACIONES_DFM='NOMBRE(S) Y APELLIDO(S) MODIFICADOS. $txtObservaciones' where  CODIGO_CONTRIBUYENTE='$txtCodigoContribuyente' and ESTADO='ACTIVO'")or die ("NO SE PUDO ACTUALIZAR LOS DATOS DEL reg_contribuyente_asociacion_pago.");
/*actualiza las transacciones*/
$rest=mysql_query("select * from reg_contribuyente_asociacion_pago where CODIGO_CONTRIBUYENTE='$txtCodigoContribuyente' and ESTADO='ACTIVO'");
while($rowt=mysql_fetch_array($rest)){ 
$CODIGO_ASOCIACION=$rowt['CODIGO_ASOCIACION'];
$sql1="insert into reg_contribuyente_transacciones(PC_NAME,PC_IP,USUARIO,NOMBRE_USUARIO,FECHA,HORA,CODIGO_REGISTRO,CODIGO_CONTRIBUYENTE,CODIGO_ASOCIACION,ASOCIACION,TRANSACCION_1,DESCRIPCION_TRAMITE,OBSERVACIONES,ENLACE)values('$hostname','$hostlocal','$US_SIOI','$SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO','$FECHA','$HORA','$txtCodigoRegistro','$txtCodigoContribuyente','$rowt[CODIGO_ASOCIACION]','$rowt[ASOCIACION]','MODIFICACION DE NOMBRE(S) Y APELLIDO(S) COMPROBANTES DE PAGO','MODIFICACION DE NOMBRE(S) Y APELLIDO(S): $NOMBRESCONT, Nro. DE COMPROBANTE DE PAGO $rowt[NRO_COMPROBANTE].','MODIFICACION DE NOMBRE(S) Y APELLIDO(S): $NOMBRESCONT, Nro. DE COMPROBANTE DE PAGO $rowt[NRO_COMPROBANTE]','0')";$result=mysql_query($sql1)or die ("NO SE PUDO REGISTRAR EN LA ENTIDAD reg_contribuyente_transacciones.");
	  }
//ACTUALIZA DATOS EN TRANSACCIONES
/*REGISTRA MODIFICACION DE CONTRIBUYENTES*/
$sql1="insert into reg_contribuyente_transacciones(PC_NAME,PC_IP,USUARIO,NOMBRE_USUARIO,FECHA,HORA,CODIGO_REGISTRO,CODIGO_CONTRIBUYENTE,CODIGO_ASOCIACION,ASOCIACION,TRANSACCION_1,DESCRIPCION_TRAMITE,OBSERVACIONES,ENLACE)values('$hostname','$hostlocal','$US_SIOI','$SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO','$FECHA','$HORA','$txtCodigoRegistro','$txtCodigoContribuyente','$CODIGO_ASOCIACION','CONTRIBUYENTE','MODIFICACION DE NOMBRE(S) Y APELLIDO(S)','MODIFICACION DE NOMBRE(S) Y APELLIDO(S), CON NRO DE DOCUMENTO $CARNET - $NOMBRESCONT.','MODIFICACION DE NOMBRE(S) Y APELLIDO(S), CON NRO DE DOCUMENTO $CARNET - $NOMBRESCONT.','0')";$result=mysql_query($sql1)or die ("NO SE PUDO REGISTRAR EN LA ENTIDAD reg_contribuyente_transacciones.");	

echo "<script>alert('Se procedió a modificar los datos del Contribuyente.')</script>";
	}

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel='StyleSheet' href='../Css_Formularios/frmProcesos.css' type="text/css">
<script> function comprobar(obj)
{   
    if (obj.checked){
      document.getElementById('txtCi2').readOnly = false;
       document.getElementById('txtNombres').readOnly = false;
	   document.getElementById('txtPrimerApellido').readOnly = false;
	   document.getElementById('txtSegundoApellido').readOnly = false;
	   document.getElementById('txtApellidoEsposo').readOnly = false;
	   document.getElementById('txtObservaciones').readOnly = false;

	}else{
      document.getElementById('txtCi2').readOnly = true;
       document.getElementById('txtNombres').readOnly = true;
	   document.getElementById('txtPrimerApellido').readOnly = true;
	   document.getElementById('txtSegundoApellido').readOnly = true;
	   document.getElementById('txtApellidoEsposo').readOnly = true;
	   document.getElementById('txtObservaciones').readOnly = true;
	}
        
}</script>
<script src='Js/frmValida.js' type="text/javascript"></script>
</head>
<form  method="post" action='frmModificacionContribuyente1.php'>
<body oncopy="return false" onpaste="return false">
<table width="100%" border="0">
  <tr>
    <td align="center" class="TITULO">MODIFICAR DATOS CONTRIBUYENTE</td>
  </tr>
  <tr>
    <td align="center" class="SUBTITULO">Modificar Datos Contribuyente</td>
  </tr>
  <tr>
    <td style="font-weight: bold">DOCUMENTOS REQUERIDOS.</td>
  </tr>
  <tr>
    <td style="font-weight: bold"><img src="../Img/Linea.png" width="843" height="4" /></td>
  </tr>
  <tr>
    <td style="font-weight: bold"><table width="100%" border="0">
      <tr>
        <td width="25%" align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span> DOCUMENTO DE CEDULA DE IDENTIDAD IDENTIDAD :</td>
        <td width="1%">&nbsp;</td>
        <td width="74%"><input type="checkbox" name="checkbox" id="chec" onChange="comprobar(this);" required/>
        Haga clic para habilitar para modificadr Datos del Contribuyente.</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td style="font-style: italic; font-weight: normal;">Documento Indispensable para realizar modificaciones.</td>
      </tr>
      <tr>
        <td><img src="../Img/Blanco.png" width="300" height="8" /></td>
        <td>&nbsp;</td>
        <td style="font-style: italic; font-weight: normal;">Al habilitar la <span style="font-weight: bold">CASILLA</span> se modificará también los datos del contribuyente en los <span style="font-weight: bold">COMPROBANTES DE PAGO EMITIDOS.</span></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td style="font-weight: bold">Datos de Contribuyente (<span class="ASTERISCO">ES RESPONSABILIDAD DEL OPERADOR EL LLENADO DE DATOS</span>).</td>
  </tr>
  <tr>
    <td><span style="font-weight: bold"><img src="../Img/Linea.png" width="843" height="4" /></span></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" bordercolor="#FFFFFF">
      <?php 
	$res=mysql_query("select * from contribuyentes where DOC_IDENTIDAD='$txtCi' and DOC_IDENTIDAD_ALFA='$txtCi2' and ESTADO='ACTIVO'");  
	  while($row=mysql_fetch_array($res)){ 
	  $CODIGO_CONTRIBUYENTE=$row['CODIGO_CONTRIBUYENTE'];?> <tr>
        <td width="24%" height="32" align="right" bgcolor="#CCCCCC">Nro. de Cédula de Identidad :</td>
        <td width="76%" style="font-weight: bold"> <?php echo $txtCi;?>
          <input name="txtCi" type="hidden" id="txtCi" value="<?php echo $txtCi;?>" /> 
          - 
          <input name="txtCi2" type="text" id="txtCi2" style="width:75px; height:20px" onkeypress="return soloLetrasNumeros(event)" value="<?php echo $txtCi2;?>" maxlength="5" onchange="javascript:this.value=this.value.toUpperCase();"  readonly/>
          <input name="txtCodigoContribuyente" type="hidden" id="txtCodigoContribuyente" value="<?php echo $txtCodigoContribuyente;?>" />
          <input name="txtCodigoRegistro" type="hidden" id="txtCodigoRegistro" value="<?php echo $CodigoRegistro;?>" /></td>
      </tr>
      <tr>
        <td height="32" align="right" bgcolor="#CCCCCC">Expedido :</td>
        <td style="font-weight: bold"><select name="sltExpedido" id="sltExpedido">
          <option selected="selected"><?php echo $row['EXPEDIDO'];?></option>
          <?php $rest=mysql_query("select * from parametros_sistema where UBICACION='EXPEDIDO' and ESTADO='ACTIVO'");
	  while($rowt=mysql_fetch_array($rest)){  ?><option><?php echo $rowt['DESCRIPCION'];?></option><?php } ?>
          </select>          </td>
      </tr>
      <tr>
        <td height="32" align="right" bgcolor="#CCCCCC">Tipo de Documento :</td>
        <td style="font-weight: bold"><?php echo $row['TIPO_DOCUMENTO'];?>
          <input name="REG" type="hidden" id="REG" value="1" /></td>
      </tr>
      <tr>
        <td height="32" align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span> Nombre(s) :</td>
        <td style="font-weight: bold"><input name="txtNombres" type="text" id="txtNombres" onchange="javascript:this.value=this.value.toUpperCase();" value="<?php echo $row['NOMBRE_RSOCIAL'];?>" onkeypress="return soloLetras(event)"  size="50" readonly  required/> </td>
      </tr>
      <tr>
        <td height="32" align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span> Primer Apellido :</td>
        <td style="font-weight: bold"><input name="txtPrimerApellido" type="text" id="txtPrimerApellido" value="<?php echo $row['PRIMER_APELLIDO'];?>" size="50" onchange="javascript:this.value=this.value.toUpperCase();" onkeypress="return soloLetras(event)"  readonly required/></td>
      </tr>
      <tr>
        <td height="32" align="right" bgcolor="#CCCCCC">Segundo Apellido :</td>
        <td style="font-weight: bold"><input name="txtSegundoApellido" type="text" id="txtSegundoApellido" value="<?php echo $row['SEGUNDO_APELLIDO'];?>" onkeypress="return soloLetras(event)"  onchange="javascript:this.value=this.value.toUpperCase();" size="50" readonly /></td>
      </tr>
      <tr>
        <td height="32" align="right" bgcolor="#CCCCCC">Apellido Esposo :</td>
        <td style="font-weight: bold"><input name="txtApellidoEsposo" type="text" id="txtApellidoEsposo" value="<?php echo $row['APELLIDO_ESPOSO'];?>" onkeypress="return soloLetras(event)"  onchange="javascript:this.value=this.value.toUpperCase();" size="50" readonly /></td>
      </tr>
      <tr>
        <td height="32" align="right" bgcolor="#CCCCCC">Observaciones :</td>
        <td style="font-weight: bold"><textarea name="txtObservaciones" id="txtObservaciones" onchange="javascript:this.value=this.value.toUpperCase();" onkeypress="return soloNumAlfSig(event)"  cols="45" rows="4" readonly></textarea></td>
      </tr>
      <tr>
        <td height="32" align="right"><img src="../Img/Blanco.png" width="400" height="8" /></td>
        <td style="font-weight: bold"><input type="submit" name="button" id="button" value="Aceptar" style="width:200px; height:35px"/></td>
      </tr>
      <?php } ?>
    </table></td>
  </tr>
  <tr>
    <td align="left" class="ASTERISCO" style="font-style: italic; font-weight: bold;"><hr /></td>
  </tr>
  <tr>
    <td align="left" class="ASTERISCO" style="font-style: italic; font-weight: bold;">La modificación de datos (NOMBRE(S) Y APELLIDO(S)), afectara a los Comprobantes de Pago emitidos en anteriores fechas.</td>
  </tr>
  <tr>
    <td align="left" style="font-weight: bold">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" valign="top"><span style="font-weight: bold">RESULTADOS ENCONTRADOS(COMPROBANTES DE PAGO A LOS QUE AFECTARA LOS  DATOS DEL CONTRIBUYENTE MODIFICADOS).</span></td>
  </tr>
  <tr>
    <td align="center"><table id="example" class="table table-striped table-bordered" style="width:100%;">
          <thead>
      <tr>
        <td height="36" align="center" bgcolor="#CCCCCC" style="font-weight: bold">No</td>
        <td align="center" bgcolor="#CCCCCC" style="font-weight: bold">Número de Comprobante de Pago</td>
        <td align="center" bgcolor="#CCCCCC" style="font-weight: bold">Fecha de Emisión</td>
        <td align="center" bgcolor="#CCCCCC" style="font-weight: bold">Documento de Identificación</td>
        <td align="center" bgcolor="#CCCCCC" style="font-weight: bold">Nombre Completo</td>
        <td align="center" bgcolor="#CCCCCC" style="font-weight: bold">Asociación</td>
        <td align="center" bgcolor="#CCCCCC" style="font-weight: bold">Actividad</td>
        <td align="center" bgcolor="#CCCCCC" style="font-weight: bold">Gestion Fiscal de Cobro</td>
      </tr></thead>  <tbody><?php $rest=mysql_query("select * from reg_contribuyente_asociacion_pago where CODIGO_CONTRIBUYENTE='$txtCodigoContribuyente' and ESTADO='ACTIVO'");
	  while($rowt=mysql_fetch_array($rest)){  ?>
      <tr>
        <td height="24" bgcolor="#F4F4F4"><?php $cont++; echo $cont;?></td>
        <td bgcolor="#F4F4F4"><?php echo $rowt['NRO_COMPROBANTE'];?></td>
        <td bgcolor="#F4F4F4"><?php echo $rowt['FECHA'].' Hrs. '.$rowt['HORA'];?></td>
        <td bgcolor="#F4F4F4"><?php echo $rowt['CEDULA_IDENTIDAD'];?></td>
        <td bgcolor="#F4F4F4"><?php echo $rowt['CONTRIBUYENTE'];?></td>
        <td bgcolor="#F4F4F4"><?php echo $rowt['ASOCIACION'];?></td>
        <td bgcolor="#F4F4F4"><?php echo $rowt['ACTIVIDAD'];?></td>
        <td bgcolor="#F4F4F4"><?php echo $rowt['GLOSA_DESCRIPCION_1'];?></td>
      </tr><?php } ?></tbody>
          <tfoot>
          </tfoot>
          <tfoot>
          </tfoot>
    </table></td>
  </tr>
  <tr>
    <td align="center"><a href="frmModificacionCOntribuyente.php">Volver</a></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="ASTERISCO">VER. 1</td>
  </tr>
</table>
</body></form>
</html><?php  require '../Conexion_BD/Cerrar_Dbms.php'; 
function normaliza ($cadena){
    $originales = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞ
ßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ';
    $modificadas = 'aaaaaaaceeeeiiiidnoooooouuuuy
bsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
    $cadena = utf8_decode($cadena);
    $cadena = strtr($cadena, utf8_decode($originales), $modificadas);
    $cadena = strtoupper($cadena);
    return utf8_encode($cadena);
}

function limpia_espacios($cadena){
	$cadena = str_replace(' ', '', $cadena);
	return $cadena;
}
function limpia_puntos($cadena){
	$cadena = str_replace('.', '', $cadena);
	return $cadena;
}
?>