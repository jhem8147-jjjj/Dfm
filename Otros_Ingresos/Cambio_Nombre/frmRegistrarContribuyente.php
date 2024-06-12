<?php require_once('../Control_Sesiones_Forms/frmControlSesionUsuario.php');
require_once('../Control_Sesiones_Forms/Loading.php'); 
require '../Conexion_BD/Dbms.php';
if($REG==1){
//busca si el c.i. esta registrado
$EXISTE=0;
$result=mysql_query("select * from contribuyentes where DOC_IDENTIDAD='$txtNroCi' and DOC_IDENTIDAD_ALFA='$txtNroCiAl' and ESTADO='ACTIVO'"); while($row=mysql_fetch_array($result)){$EXISTE=1;}
if($EXISTE==0){
$CODIGOS_REGISTROS=date('Ymd His').rand(1,10);
$CODIGOS_CONTRIBUYENTES='CN'.$txtNroCi.$txtNroCiAl.rand(1,10);
$txtNombres=normaliza($txtNombres);
$txtNombres=trim($txtNombres);
$txtPapellido=normaliza($txtPapellido);
$txtPapellido=trim($txtPapellido);
$txtSapellido=normaliza($txtSapellido);
$txtSapellido=trim($txtSapellido);
$txtApellidoEsposo=normaliza($txtApellidoEsposo);
$txtApellidoEsposo=trim($txtApellidoEsposo);
$sql1="insert into contribuyentes(CODIGO_REGISTRO,CODIGO_CONTRIBUYENTE,DOC_IDENTIDAD,DOC_IDENTIDAD_ALFA,EXPEDIDO,TIPO_DOCUMENTO,NOMBRE_RSOCIAL,PRIMER_APELLIDO,SEGUNDO_APELLIDO,APELLIDO_ESPOSO)values('$CODIGOS_REGISTROS','$CODIGOS_CONTRIBUYENTES','$txtNroCi','$txtNroCiAl','$sltExpedido','$sltDocumento','$txtNombres','$txtPapellido','$txtSapellido','$txtApellidoEsposo')";$result=mysql_query($sql1)or die ("NO SE PUDO REGISTRAR EN LA ENTIDAD reg_contribuyente.");

$sql1="insert into reg_contribuyente(PC_NAME,PC_IP,USUARIO,NOMBRE_USUARIO,FECHA,HORA,CODIGO_REGISTRO,CODIGO_CONTRIBUYENTE)values('$hostname','$hostlocal','$US_SIOI','$SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO','$FECHA','$HORA','$CODIGOS_REGISTROS','$CODIGOS_CONTRIBUYENTES')";$result=mysql_query($sql1)or die ("NO SE PUDO REGISTRAR EN LA ENTIDAD reg_contribuyente.");

$sql1="insert into reg_contribuyente_transacciones(PC_NAME,PC_IP,USUARIO,NOMBRE_USUARIO,FECHA,HORA,CODIGO_REGISTRO,CODIGO_ASOCIACION,ASOCIACION,TRANSACCION_1,DESCRIPCION_TRAMITE,OBSERVACIONES,ENLACE)values('$hostname','$hostlocal','$US_SIOI','$SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO','$FECHA','$HORA','$CODIGOS_REGISTROS','NO DEFINIDO','NO DEFINIDO','REGISTRO CONTRIBUYENTE NUEVO','REGISTRO DE CONTRIBUYENTE NUEVO - $txtNroCi $txtNroCiAl $sltExpedido $txtNombres $txtPapellido $txtSapellido.','REGISTRO DE CONTRIBUYENTE NUEVO - $txtNroCi $txtNroCiAl $sltExpedido $txtNombres $txtPapellido $txtSapellido.','1')";$result=mysql_query($sql1)or die ("NO SE PUDO REGISTRAR EN LA ENTIDAD reg_contribuyente_transacciones."); 
echo"<script> alert('Se Registró los datos del Nuevo Contribuyente.');</script>";	
echo"<script> location.href='frmCambioNombre2.php';</script>";
	}else{
		echo"<script> alert('El número de Cédula de Identidad ya esta registrado.');</script>";	
echo"<script> location.href='frmCambioNombre2.php';</script>";
		}
} 
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel='StyleSheet' href='../Css_Formularios/frmProcesos.css' type="text/css">
<script src='Js/frmValida.js' type="text/javascript"></script>
<script src='Js/Ajax/jquery.min.js' type="text/javascript"></script>
<script src='Js/frmBuscarTiempoReal.js' type="text/javascript"></script>
<form method="post" action="frmRegistrarContribuyente.php">
<body>
<table width="10%" border="0">
  <tr>
    <td align="center" class="TITULO">&nbsp;</td>
    <td align="center" class="TITULO">&nbsp;</td>
    <td align="center" class="TITULO">CAMBIO DE NOMBRE</td>
  </tr>
  <tr>
    <td align="center" class="SUBTITULO">&nbsp;</td>
    <td align="center" class="SUBTITULO">&nbsp;</td>
    <td align="center" class="SUBTITULO">REGISTRAR NUEVO CONTRIBUYENTE</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
    <td align="left" style="font-weight: bold">Datos de Nuevo Contribuyente (<span style="font-style: italic; font-weight: normal;">Es Responsabilidad del operador el llenado de datos</span>). </td>
  </tr>
  <tr>
    <td align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
    <td align="left" valign="top" style="font-weight: bold"><img src="../Img/Linea.png" width="700" height="2" /></td>
  </tr>
  <tr>
    <td align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
    <td align="left"><table width="20%" border="0" cellpadding="2" cellspacing="2" bordercolor="#FFFFFF" bordercolordark="#FFFFFF" bordercolorlight="#FFFFFF" b>
      <tr>
        <td width="46%" align="right" bgcolor="#CCCCCC">Documento :</td>
        <td width="54%" style="font-weight: bold"><select name="sltDocumento" id="sltDocumento" style="width:250px; height:20px">
          <?php $result=mysql_query("select * from parametros_sistema where UBICACION='DOCUMENTO' and ESTADO='ACTIVO' order by DESCRIPCION"); while($row=mysql_fetch_array($result)){ ?>
          <option><?php echo $row['DESCRIPCION'];?></option>
          <?PHP  } ?>
        </select></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span> Número de Cédula de Identidad :</td>
        <td style="font-weight: bold"><input name="txtNroCi" type="text" id="txtNroCi" style="width:150px; height:20px" onkeyup="buscar_ajax(this.value);return fileRegValidation();" size="10" onKeyPress="return soloNumeros(event)" placeholder="Nro. de C.I." required/>
          -
          <input name="txtNroCiAl" type="text" id="txtNroCiAl" style="width:40px; height:20px" size="10" onKeyPress="return soloLetrasNumeros(event)" placeholder="ALFA" onchange="javascript:this.value=this.value.toUpperCase();" />
          <input name="REG" type="hidden" id="REG" value="1" /></td>
      </tr>
      <tr>
        <td  align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span> Expedido :</td>
        <td style="font-weight: bold"><select name="sltExpedido" id="sltExpedido" style="width:250px; height:20px">
          <?php $result=mysql_query("select * from parametros_sistema where UBICACION='EXPEDIDO' and ESTADO='ACTIVO' order by DESCRIPCION"); while($row=mysql_fetch_array($result)){ if($rowy['EXPEDIDO']==$row['DESCRIPCION']){ echo "<option selected> $row[DESCRIPCION]</option>";}else{?> <option><?php echo $row['DESCRIPCION'];?></option><?PHP } } ?>
    </select></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span> Nombre(s) :</td>
        <td style="font-weight: bold"><input name="txtNombres" type="text" id="txtNombres"  style="width:250px; height:20px" onchange="javascript:this.value=this.value.toUpperCase();" placeholder="NOMBRE(S)" onKeyPress="return soloLetras(event)" onkeyup="return fileRegValidation()" required/></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span> Primer Apellido :</td>
        <td style="font-weight: bold"><input name="txtPapellido" type="text" id="txtPapellido"  style="width:250px; height:20px" onchange="javascript:this.value=this.value.toUpperCase();"  onKeyPress="return soloLetras(event)" onkeyup="return fileRegValidation()" placeholder="PRIMER APELLIDO" required="required"/></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC">Segundo Apellido :</td>
        <td style="font-weight: bold"><input name="txtSapellido" type="text" id="txtSapellido"  style="width:250px; height:20px" onchange="javascript:this.value=this.value.toUpperCase();"  onkeypress="return soloLetras(event)" placeholder="SEGUNDO APELLIDO"/></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC">Apellido Esposo</td>
        <td style="font-weight: bold"><input name="txtApellidoEsposo" type="text" id="txtApellidoEsposo"  style="width:250px; height:20px" onchange="javascript:this.value=this.value.toUpperCase();"  onkeypress="return soloLetras(event)" placeholder="APELLIDO ESPOSO"/></td>
      </tr>
      <tr>
        <td align="right"><img src="../Img/Blanco.png" width="300" height="1" /></td>
        <td style="font-weight: bold"><input type="submit" name="button" id="button" value="Aceptar" style="width:150px; height:35px" disabled="disabled"/></td>
      </tr>
      <tr>
        <td colspan="2"  align="left"><img src="../Img/Blanco.png" width="661" height="1" /></td>
      </tr>
      <tr>
        <td  align="right">&nbsp;</td>
        <td style="font-weight: bold">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="center"><div id="mostrar"></div></td>
  </tr>
  <tr>
    <td class="ASTERISCO">&nbsp;</td>
    <td class="ASTERISCO">&nbsp;</td>
    <td align="center" class="ASTERISCO"><a href="frmCambioNombre2.php">Volver</a></td>
  </tr>
  <tr>
    <td class="ASTERISCO">&nbsp;</td>
    <td class="ASTERISCO">&nbsp;</td>
    <td class="ASTERISCO">VER. 3</td>
  </tr>
</table>
</body></form>
</html><?php 

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
require '../Conexion_BD/Cerrar_Dbms.php';?>