<?php header('Content-Type: text/html; charset=utf-8');
require_once('../Control_Sesiones_Forms/frmControlSesionUsuario.php');
require '../Conexion_BD/Dbms.php';
function registrarContribuyenteComplementoValue($name)
{
    return isset($_POST[$name]) && is_scalar($_POST[$name])
        ? (string)$_POST[$name]
        : '';
}
$REG = registrarContribuyenteComplementoValue('REG');
$txtCodigoRegistro = registrarContribuyenteComplementoValue('txtCodigoRegistro');
$txtCodigoRegistro = $txtCodigoRegistro !== '' ? $txtCodigoRegistro : (isset($_SESSION['txtCodigoRegistro']) ? $_SESSION['txtCodigoRegistro'] : '');
$COD_ASOCIACION = isset($_SESSION['COD_ASOCIACION']) ? $_SESSION['COD_ASOCIACION'] : '';
$ASOCIACION = isset($_SESSION['ASOCIACION']) ? $_SESSION['ASOCIACION'] : '';
$CODIGO_ZONA_TRIB = isset($_SESSION['CODIGO_ZONA_TRIB']) ? $_SESSION['CODIGO_ZONA_TRIB'] : '';
$txtDocumento = isset($_SESSION['txtDocumento']) ? $_SESSION['txtDocumento'] : '';
$txtFecha = isset($_SESSION['txtFecha']) ? $_SESSION['txtFecha'] : '';
$txtObservaciones = isset($_SESSION['txtObservaciones']) ? $_SESSION['txtObservaciones'] : '';
$sltGestion = isset($_SESSION['sltGestion']) ? $_SESSION['sltGestion'] : '';
$txtNroCi = trim(registrarContribuyenteComplementoValue('txtNroCi'));
$txtNroCiAl = trim(registrarContribuyenteComplementoValue('txtNroCiAl'));
$sltExpedido = registrarContribuyenteComplementoValue('sltExpedido');
$sltDocumento = registrarContribuyenteComplementoValue('sltDocumento');
$txtNombres = trim(registrarContribuyenteComplementoValue('txtNombres'));
$txtPapellido = trim(registrarContribuyenteComplementoValue('txtPapellido'));
$txtSapellido = trim(registrarContribuyenteComplementoValue('txtSapellido'));
$txtApellidoEsposo = trim(registrarContribuyenteComplementoValue('txtApellidoEsposo'));
if($REG==1){
if ($txtCodigoRegistro === '' || $COD_ASOCIACION === '' || $ASOCIACION === '' || $CODIGO_ZONA_TRIB === '') {
    die("FALTAN DATOS DE LA SOLICITUD DE COMPLEMENTACION.");
}
	//busca si el c.i. esta registrado
$EXISTE=0;
$txtNroCi_SQL = mysql_real_escape_string($txtNroCi);
$txtNroCiAl_SQL = mysql_real_escape_string($txtNroCiAl);
$result=mysql_query("select * from contribuyentes where DOC_IDENTIDAD='$txtNroCi_SQL' and DOC_IDENTIDAD_ALFA='$txtNroCiAl_SQL' and ESTADO='ACTIVO'"); while($row=mysql_fetch_array($result)){$EXISTE=1;}
if($EXISTE==0){
$CODIGOS_CONTRIBUYENTES='CC'.$txtNroCi.$txtNroCiAl.rand(1,99);
$txtNombres=normaliza($txtNombres);
$txtNombres=trim($txtNombres);
$txtPapellido=normaliza($txtPapellido);
$txtPapellido=trim($txtPapellido);
$txtSapellido=normaliza($txtSapellido);
$txtSapellido=trim($txtSapellido);
$txtApellidoEsposo=normaliza($txtApellidoEsposo);
$txtApellidoEsposo=trim($txtApellidoEsposo);
$txtNombres_SQL = mysql_real_escape_string($txtNombres);
$txtPapellido_SQL = mysql_real_escape_string($txtPapellido);
$txtSapellido_SQL = mysql_real_escape_string($txtSapellido);
$txtApellidoEsposo_SQL = mysql_real_escape_string($txtApellidoEsposo);
$sltExpedido_SQL = mysql_real_escape_string($sltExpedido);
$sltDocumento_SQL = mysql_real_escape_string($sltDocumento);
$txtCodigoRegistro_SQL = mysql_real_escape_string($txtCodigoRegistro);
$CODIGOS_CONTRIBUYENTES_SQL = mysql_real_escape_string($CODIGOS_CONTRIBUYENTES);
$sql1="insert into contribuyentes(CODIGO_REGISTRO,CODIGO_CONTRIBUYENTE,DOC_IDENTIDAD,DOC_IDENTIDAD_ALFA,EXPEDIDO,TIPO_DOCUMENTO,NOMBRE_RSOCIAL,PRIMER_APELLIDO,SEGUNDO_APELLIDO,APELLIDO_ESPOSO)values('$txtCodigoRegistro_SQL','$CODIGOS_CONTRIBUYENTES_SQL','$txtNroCi_SQL','$txtNroCiAl_SQL','$sltExpedido_SQL','$sltDocumento_SQL','$txtNombres_SQL','$txtPapellido_SQL','$txtSapellido_SQL','$txtApellidoEsposo_SQL')";$result=mysql_query($sql1)or die ("NO SE PUDO REGISTRAR EN LA ENTIDAD reg_contribuyente.");

$txtCodigoRegistro_AUDIT = mysql_real_escape_string($txtCodigoRegistro);
$NOMBRE_USUARIO_SQL = mysql_real_escape_string("$SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO");
$US_SIOI_SQL = mysql_real_escape_string($US_SIOI);
$ASOCIACION_SQL = mysql_real_escape_string($ASOCIACION);
$COD_ASOCIACION_SQL = mysql_real_escape_string($COD_ASOCIACION);
$sql1="insert into reg_contribuyente(PC_NAME,PC_IP,USUARIO,NOMBRE_USUARIO,FECHA,HORA,CODIGO_REGISTRO,CODIGO_CONTRIBUYENTE)values('$hostname','$hostlocal','$US_SIOI_SQL','$NOMBRE_USUARIO_SQL','$FECHA','$HORA','$txtCodigoRegistro_AUDIT','$CODIGOS_CONTRIBUYENTES_SQL')";$result=mysql_query($sql1)or die ("NO SE PUDO REGISTRAR EN LA ENTIDAD reg_contribuyente.");

$descripcion = mysql_real_escape_string("REGISTRO DE CONTRIBUYENTE NUEVO - $txtNroCi $txtNroCiAl $sltExpedido $txtNombres $txtPapellido $txtSapellido.");
$observaciones = mysql_real_escape_string("REGISTRO DE CONTRIBUYENTE NUEVO - $txtNroCi $txtNroCiAl $sltExpedido $txtNombres $txtPapellido $txtSapellido $txtApellidoEsposo.");
$sql1="insert into reg_contribuyente_transacciones(PC_NAME,PC_IP,USUARIO,NOMBRE_USUARIO,FECHA,HORA,CODIGO_REGISTRO,CODIGO_ASOCIACION,ASOCIACION,TRANSACCION_1,DESCRIPCION_TRAMITE,OBSERVACIONES,ENLACE)values('$hostname','$hostlocal','$US_SIOI_SQL','$NOMBRE_USUARIO_SQL','$FECHA','$HORA','$txtCodigoRegistro_AUDIT','$COD_ASOCIACION_SQL','$ASOCIACION_SQL','REGISTRO CONTRIBUYENTE NUEVO','$descripcion','$observaciones','0')";$result=mysql_query($sql1)or die ("NO SE PUDO REGISTRAR EN LA ENTIDAD reg_contribuyente_transacciones."); 
//COMIENZA A REGISTRAR EN TABLA COMPLEMENTOS
//OBTIENE EL MONTO DE COMPLEMENTO
$liqui=mysql_query("select * from complemento where ESTADO='ACTIVO'");while($rowt=mysql_fetch_array($liqui)){ $MONTOS=$rowt['MONTO'];$FORMULARIOS=$rowt['FORMULARIO'];}

$res=mysql_query("select * from nros_correlativos ");while($ro=mysql_fetch_array($res)){
$NUMERO_GREMIAL=$ro['NRO_PUESTO']+1;}
$query = mysql_query("UPDATE nros_correlativos  SET NRO_PUESTO='$NUMERO_GREMIAL'")or die ("NO SE PUDO ACTUALIZAR LOS DATOS DEL nros_correlativos.");
$CODIGO_ZONA_TRIB_SQL = mysql_real_escape_string($CODIGO_ZONA_TRIB);
$txtDocumento_SQL = mysql_real_escape_string($txtDocumento);
$txtFecha_SQL = mysql_real_escape_string($txtFecha);
$txtObservaciones_SQL = mysql_real_escape_string($txtObservaciones);
$sltGestion_SQL = mysql_real_escape_string($sltGestion);
$MONTOS_SQL = mysql_real_escape_string($MONTOS);
$FORMULARIOS_SQL = mysql_real_escape_string($FORMULARIOS);
$sql1="insert into reg_contribuyente_habilitado_pago_complementacion(PC_NAME,PC_IP,USUARIO,NOMBRE_USUARIO,FECHA,HORA,CODIGO_REGISTRO,CODIGO_GREMIAL,CODIGO_CONTRIBUYENTE,CODIGO_ASOCIACION,CODIGO_ZONA,DOCUMENTO,FECHA_DOCUMENTO,OBSERVACIONES_REGISTRO,GESTION,MONTO,FORMULARIO)values('$hostname','$hostlocal','$US_SIOI_SQL','$NOMBRE_USUARIO_SQL','$FECHA','$HORA','$txtCodigoRegistro_AUDIT','$NUMERO_GREMIAL','$CODIGOS_CONTRIBUYENTES_SQL','$COD_ASOCIACION_SQL','$CODIGO_ZONA_TRIB_SQL','$txtDocumento_SQL','$txtFecha_SQL','$txtObservaciones_SQL','$sltGestion_SQL','$MONTOS_SQL','$FORMULARIOS_SQL')";$result=mysql_query($sql1)or die ("NO SE PUDO REGISTRAR EN LA ENTIDAD reg_contribuyente_habilitado_pago_complementacion.");
//TERMINA ADICIONA CONTRIBUYENTE NUEVO
$_SESSION['complementacionMensaje'] = 'Se Adiciono Contribuyente';
header('Location: frmComplementacion2.php');
exit;
	}else{
$_SESSION['complementacionMensaje'] = 'El número de Cédula de Identidad ya está registrado.';
header('Location: frmComplementacion2.php');
exit;
		}
}
?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel='StyleSheet' href='../Css_Formularios/frmProcesos.css' type="text/css">
<script src='Js/frmValida.js' type="text/javascript"></script>
<script src='Js/Ajax/jquery.min.js' type="text/javascript"></script>
<script src='Js/frmBuscarTiempoReal.js' type="text/javascript"></script>
</head>
<body>
<form method="post" accept-charset="UTF-8" action="frmRegistrarContribuyenteComplemento.php">
<table width="10%" border="0">
  <tr>
    <td align="center" class="TITULO">&nbsp;</td>
    <td align="center" class="TITULO">&nbsp;</td>
    <td align="center" class="TITULO">COMPLEMENTO</td>
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
    <td align="left" valign="top" style="font-weight: bold"><img src="../Img/Linea_Negra.png" width="669" height="2" /></td>
  </tr>
  <tr>
    <td align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
    <td align="left"><table width="20%" border="0" cellpadding="0" cellspacing="3" >
      <tr>
        <td align="right" bgcolor="#CCCCCC">Documento :</td>
        <td style="font-weight: bold"><select name="sltDocumento" id="sltDocumento" style="width:250px; height:20px">
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
        <td style="font-weight: bold"><input name="txtNombres" type="text" id="txtNombres"  style="width:250px; height:20px" onchange="javascript:this.value=this.value.toUpperCase();" placeholder="NOMBRE(S)" onkeyup="return fileRegValidation()" required/></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span> Primer Apellido :</td>
        <td style="font-weight: bold"><input name="txtPapellido" type="text" id="txtPapellido"  style="width:250px; height:20px" onchange="javascript:this.value=this.value.toUpperCase();" onkeyup="return fileRegValidation()" placeholder="PRIMER APELLIDO" required="required"/></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC">Segundo Apellido :</td>
        <td style="font-weight: bold"><input name="txtSapellido" type="text" id="txtSapellido"  style="width:250px; height:20px" onchange="javascript:this.value=this.value.toUpperCase();" placeholder="SEGUNDO APELLIDO"/></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC">Apellido Esposo</td>
        <td style="font-weight: bold"><input name="txtApellidoEsposo" type="text" id="txtApellidoEsposo"  style="width:250px; height:20px" onchange="javascript:this.value=this.value.toUpperCase();" placeholder="APELLIDO ESPOSO"/></td>
      </tr>
      <tr>
        <td align="right"><img src="../Img/Blanco.png" width="300" height="6" /></td>
        <td style="font-weight: bold"><input type="submit" name="button" id="button" value="Aceptar" style="width:150px; height:35px" disabled="disabled"/></td>
      </tr>
      <tr>
        <td colspan="2"  align="left"><img src="../Img/Blanco.png" width="661" height="6" /></td>
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
    <td align="center" class="ASTERISCO"><a href="frmComplementacion2.php">Volver</a></td>
  </tr>
  <tr>
    <td class="ASTERISCO">&nbsp;</td>
    <td class="ASTERISCO">&nbsp;</td>
    <td class="ASTERISCO">VER. 3</td>
  </tr>
</table>
</form>
</body>
</html><?php 

function normaliza ($cadena){
    return mb_strtoupper($cadena, 'UTF-8');
} require '../Conexion_BD/Cerrar_Dbms.php';?>