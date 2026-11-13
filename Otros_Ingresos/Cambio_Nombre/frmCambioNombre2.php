<?php require_once('../Control_Sesiones_Forms/frmControlSesionUsuario.php');
require_once('../Control_Sesiones_Forms/Loading.php'); 
require '../Conexion_BD/Dbms.php';
$_SESSION['GESTION_BUSQUEDA']=$GESTION_BUSQUEDA;
$_SESSION['CODIGO_CONTRIBUYENTE']=$CODIGO_CONTRIBUYENTE;
$_SESSION['NUMERO_GREMIAL']=$NUMERO_GREMIAL; 
$NUMERO_GREMIAL=$NUMERO_GREMIAL; 
//$_SESSION['CODIGO_REGISTRO']=$CODIGO_REGISTRO;

if($BORRAR==1){unset($_SESSION['TIPO_CAMBIO']);$TIPO_CAMBIO='Seleccionar...';}else{
if(isset($TIPO_CAMBIO)){$_SESSION['TIPO_CAMBIO']=$TIPO_CAMBIO;}else{$TIPO_CAMBIO='Seleccionar...';}
}
if($CAMBIAR==1){
	if($TIPO_CAMBIO=='Seleccionar...'){
echo"<script> alert('Seleccione el TIPO DE CAMBIO DE NOMBRE.');</script>"; $SWREEG=0;
}else{$SWREEG=1;}
if($SWREEG==1){
$GESTION_LIQ=date('Y')-1;
//VERIFICA SI EL CONTRIBUYENTE ESTA HABILITADO
$SWCONTRI=0;
$rest=mysql_query("select * from contribuyentes where CODIGO_CONTRIBUYENTE='$CODIGO_NUEVO_CONTRIBUYENTE' and ESTADO='ACTIVO'");
while($rowst=mysql_fetch_array($rest)){
	$SWCONTRI=1;
		  }

if($SWCONTRI==1){
$PC_NAME_SQL = mysql_real_escape_string($hostname);
$PC_IP_SQL = mysql_real_escape_string($hostlocal);
$USUARIO_SQL = mysql_real_escape_string($US_SIOI);
$NOMBRE_USUARIO_SQL = mysql_real_escape_string($SIAUNOMBRES.' '.$USPRIMERAPELLIDO.' '.$SIAUSEGUNDOAPELLIDO);
$FECHA_SQL = mysql_real_escape_string($FECHA);
$HORA_SQL = mysql_real_escape_string($HORA);
$COD_REGISTRO_SQL = mysql_real_escape_string($COD_REGISTRO);
$NUMERO_GREMIAL_SQL = mysql_real_escape_string($NUMERO_GREMIAL);
$CODIGO_NUEVO_CONTRIBUYENTE_SQL = mysql_real_escape_string($CODIGO_NUEVO_CONTRIBUYENTE);
$COD_ASOCIACION_SQL = mysql_real_escape_string($COD_ASOCIACION);
$CODIGO_ZONAS_SQL = mysql_real_escape_string($CODIGO_ZONAS);
$TIPO_PUESTOS_SQL = mysql_real_escape_string($TIPO_PUESTOS);
$PUESTOS_SQL = mysql_real_escape_string($PUESTOS);
$FILAS_SQL = mysql_real_escape_string($FILAS);
$OBSERVACIONES_SQL = mysql_real_escape_string("REGISTRO POR CAMBIO DE NOMBRE REALIZADO POR $TIPO_CAMBIO, POR EL USUARIO $US_SIOI - $SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO, FECHA: $FECHA HORA: $HORA");
$sql1="insert into reg_contribuyente_asociacion(PC_NAME,PC_IP,USUARIO,NOMBRE_USUARIO,FECHA,HORA,CODIGO_REGISTRO,REGISTRO_GREMIAL,CODIGO_CONTRIBUYENTE,CODIGO_ASOCIACION,CODIGO_ZONA,TIPO_VENTA,PUESTO,FILA,OBSERVACIONES)values('$PC_NAME_SQL','$PC_IP_SQL','$USUARIO_SQL','$NOMBRE_USUARIO_SQL','$FECHA_SQL','$HORA_SQL','$COD_REGISTRO_SQL','$NUMERO_GREMIAL_SQL','$CODIGO_NUEVO_CONTRIBUYENTE_SQL','$COD_ASOCIACION_SQL','$CODIGO_ZONAS_SQL','$TIPO_PUESTOS_SQL','$PUESTOS_SQL','$FILAS_SQL','$OBSERVACIONES_SQL')";
$result=mysql_query($sql1);
if($result===false){
	$errorMysql=mysql_error();
	error_log('Cambio de nombre: fallo INSERT en reg_contribuyente_asociacion: '.$errorMysql);
	die("NO SE PUDO REGISTRAR EN LA ENTIDAD reg_contribuyente_asociacion. Detalle MySQL: ".htmlspecialchars($errorMysql, ENT_QUOTES, 'UTF-8'));
}

//OBTIENE MONTO
$res=mysql_query("select * from cambio_nombre where  ESTADO='ACTIVO' and CODIGO_ZONA_ like '$CODIGO_ZONAS'");
while($row=mysql_fetch_array($res)){
	$MONTOS=$row['MONTO'];
		  }
		  
$sql1="insert into reg_contribuyente_habilitado_pago_cambio_nombre(PC_NAME,PC_IP,USUARIO,NOMBRE_USUARIO,FECHA,HORA,CODIGO_REGISTRO,CODIGO_ASOCIACION,CODIGO_ZONA,REGISTRO_GREMIAL,CODIGO_CONTRIBUYENTE_SALIENTE,CODIGO_CONTRIBUYENTE_ENTRANTE,DOCUMENTO,FECHA_DOCUMENTO,OBSERVACIONES_DOCUMENTO,TIPO_CAMBIO,GESTION,TIPO_PUESTO,FILA,PUESTO,MONTO)values('$hostname','$hostlocal','$US_SIOI','$SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO','$FECHA','$HORA','$COD_REGISTRO','$COD_ASOCIACION','$CODIGO_ZONAS','$NUMERO_GREMIAL','$CODIGO_CONTRIBUYENTE','$CODIGO_NUEVO_CONTRIBUYENTE','$txtDocumento','$txtFecha','$txtObservaciones','$TIPO_CAMBIO','$GESTION_LIQ','$TIPO_PUESTOS','$FILAS','$PUESTOS','$MONTOS')";$result=mysql_query($sql1)or die ("NO SE PUDO REGISTRAR EN LA ENTIDAD reg_contribuyente_cambio_nombre.");

$sql1="insert into reg_contribuyente_transacciones(PC_NAME,PC_IP,USUARIO,NOMBRE_USUARIO,FECHA,HORA,CODIGO_REGISTRO,CODIGO_ASOCIACION,ASOCIACION,TRANSACCION_1,DESCRIPCION_TRAMITE,OBSERVACIONES,ENLACE)values('$hostname','$hostlocal','$US_SIOI','$SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO','$FECHA','$HORA','$COD_REGISTRO','$COD_ASOCIACION','$ASOCIACION','CAMBIO DE AFILIADOS','CAMBIO DE AFILIADOS NRO. DE PUESTO GREMIAL $NUMERO_GREMIAL CODIGO CONTRIBUYENTE ANTERIOR $CODIGO_CONTRIBUYENTE POR NUEVO CODIGO DE CONTRIBUYENTE $CODIGO_NUEVO_CONTRIBUYENTE A LA GESTION $GESTION_LIQ.','CAMBIO DE AFILIADOS.','0')";$result=mysql_query($sql1)or die ("NO SE PUDO REGISTRAR EN LA ENTIDAD reg_contribuyente_transacciones."); 

echo"<script> alert('Se realizó el cambio de contribuyente.');</script>";
//$CODIGO_CONTRIBUYENTE=$CODIGO_NUEVO_CONTRIBUYENTE;
echo"<script> location.href='frmCambioNombre1.php';</script>";
}
}
}

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel='StyleSheet' href='../Css_Formularios/frmProcesos.css' type="text/css">
<script src='Js/frmValida.js' type="text/javascript"></script>
<script src='Js/Ajax/jquery.min.js' type="text/javascript"></script>
<script src='Js/frmBuscarContriCambio.js' type="text/javascript"></script>
<script type="text/javascript">
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
</script>
</head>
<form method="post" action="frmCambioNombre1.php">
<body>
<table width="50%" border="0">
  <tr>
    <td align="center" class="TITULO"><?php $result=mysql_query("select * from nombre_formularios where UBICACION='CAMBIO DE NOMBRE DE CONTRIBUYENTE' and ESTADO='ACTIVO'"); while($row=mysql_fetch_array($result)){ echo $row['DESCRIPCION']; }?></td>
  </tr>
  <tr>
    <td align="center" class="SUBTITULO">CAMBIO DE CONTRIBUYENTES</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td style="font-weight: bold">Datos de Asociación.</td>
  </tr>
  <tr>
    <td><img src="../Img/Linea.png" width="700" height="2" /></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="1" cellspacing="1" bordercolor="#FFFFFF">
      <?php $result=mysql_query("select * from reg_asociacion where CODIGO_ASOCIACION='$COD_ASOCIACION' and ESTADO='ACTIVO'"); while($row=mysql_fetch_array($result)){ ?>
      <tr>
        <td align="right" bgcolor="#CCCCCC">Ordenanza Municipal :</td>
        <td style="font-weight: bold"><?php echo utf8_decode($row['ORDENANZA_MUNICIPAL']);?></td>
      </tr>
      <tr>
        <td  align="right" bgcolor="#CCCCCC">Zona Tributaria :</td>
        <td style="font-weight: bold"><?php $liqui=mysql_query("select ZT.DESCRIPCION from zona_tributaria ZT,reg_asociacion_zona_tributaria RAZT where RAZT.CODIGO_ASOCIACION='$COD_ASOCIACION' and RAZT.CODIGO_ZONA=ZT.CODIGO_ZONA and RAZT.ESTADO='ACTIVO' and ZT.ESTADO='ACTIVO'");while($rowt=mysql_fetch_array($liqui)){ echo $rowt[0];  } ?></td>
      </tr>
      <tr>
        <td width="47%" align="right" bgcolor="#CCCCCC">Asociación Seleccionada :</td>
        <td width="53%" style="font-weight: bold"><?php echo utf8_decode($row['DESCRIPCION']);?></td>
      </tr>
      <?php }?>
    </table></td>
  </tr>
  <tr>
    <td align="left" style="font-weight: bold">Datos de Contribuyente Actual.</td>
  </tr>
  <tr>
    <td align="center"><img src="../Img/Linea.png" width="700" height="2" /></td>
  </tr>
  <tr>
    <td align="left"><table width="20%" border="0">
     <?php $resulty=mysql_query("select * from contribuyentes where CODIGO_CONTRIBUYENTE='$CODIGO_CONTRIBUYENTE' and ESTADO='ACTIVO'"); while($rowy=mysql_fetch_array($resulty)){ ?>
      <tr>
        <td width="46%" align="right" bgcolor="#CCCCCC">Número de Cédula de Identidad :</td>
        <td width="54%" style="font-weight: bold"><?php echo $rowy['DOC_IDENTIDAD'];?>
          
          <?php if($rowy['DOC_IDENTIDAD_ALFA']==null){}else{echo ' - '.$rowy['DOC_IDENTIDAD_ALFA'];}?></td>
      </tr>
      <tr>
        <td  align="right" bgcolor="#CCCCCC">Expedido :</td>
        <td style="font-weight: bold"><?php echo $rowy['EXPEDIDO'];  ?></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC">Nombre(s) y Apellido(s) :</td>
        <td style="font-weight: bold"><?php echo $rowy['NOMBRE_RSOCIAL'];?> <?php echo $rowy['PRIMER_APELLIDO'];?> <?php echo $rowy['SEGUNDO_APELLIDO']; if($rowy['APELLIDO_ESPOSO']== null){ }else{echo ' de '.$rowy['APELLIDO_ESPOSO'];}?></td>
      </tr><?PHP } ?>
      <tr>
        <td colspan="2"  align="left" style="font-weight: bold">Tipo de Cambio de Nombre.</td>
      </tr>
      <tr>
        <td colspan="2"  align="left"><img src="../Img/Linea.png" width="700" height="2" /></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span> Tipo de Cambio de Nombre :</td>
                <td align="left"><form name="form" id="form">
                  <select name="jumpMenu" id="jumpMenu" onchange="MM_jumpMenu('self',this,0)">
                   <option><?php echo $TIPO_CAMBIO;?></option>
                    <option value="frmCambioNombre2.php?TIPO_CAMBIO=<?php echo 'POR ALTA Y BAJA DE CONTRIBUYENTES';?>">POR ALTA Y BAJA DE CONTRIBUYENTES</option>
                    <option value="frmCambioNombre2.php?TIPO_CAMBIO=<?php echo 'ABANDONO DEL AFILIADO';?>">ABANDONO DEL AFILIADO</option>
                  <option value="frmCambioNombre2.php?TIPO_CAMBIO=<?php echo 'FALLECIMIENTO';?>">FALLECIMIENTO</option>
                  
                  </select>
                  <a href="frmCambioNombre2.php?BORRAR=1"> Modificar</a>
                </form></td>
      </tr>
      <tr>
        <td colspan="2"  align="left" style="font-weight: bold">Nuevo Contribuyente.</td>
      </tr>
      <tr>
        <td colspan="2"  align="left"><img src="../Img/Linea.png" width="700" height="2" /></td>
        </tr>
      <tr>
        <td  align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span> Nro. de Cédula de Identidad :</td>
        <td style="font-weight: bold"><input name="txtNroCi" type="text" id="txtNroCi" style="width:150px; height:20px" onkeyup="buscar_ajax(this.value);" size="10" onkeypress="return soloNumeros(event)" placeholder="Nro. de C.I."/></td>
      </tr>
      <tr>
        <td colspan="2"  align="right"><div id="mostrar"></div></td>
      </tr>
      <tr>
        <td colspan="2"  align="left"><span style="font-weight: bold">Datos de Puesto de Venta. </span><img src="../Img/Linea.png" width="700" height="2" /></td>
      </tr>
     <?php $res=mysql_query("select * from reg_contribuyente_habilitado_pago where REGISTRO_GREMIAL='$NUMERO_GREMIAL' and ESTADO='PAGADO' and CODIGO_ASOCIACION='$COD_ASOCIACION'"); while($ros=mysql_fetch_array($res)){ $_SESSION['MONTOS']=$ros['MONTO'];$_SESSION['TIPO_PUESTOS']=$ros['TIPO_VENTA'];?> <tr>
        <td  align="right" bgcolor="#CCCCCC"><span class="ASTERISCO">*</span> Tipo de Puesto :</td>
        <td style="font-weight: bold"><select name="sltVenta" id="sltVenta" style="width:250px; height:20px">
             <option><?php echo $ros['TIPO_VENTA'];?></option>
         
        </select>
          <input name="CAMBIO_CONTRIBUYENTE" type="hidden" id="CAMBIO_CONTRIBUYENTE" value="<?php echo $CODIGO_CONTRIBUYENTE;?>" />
          <input name="NUMERO_GREMIAL" type="hidden" id="NUMERO_GREMIAL" value="<?php echo $NUMERO_GREMIAL;?>" />
          <input name="CAMBIO_CONTRIBUYENTE3" type="hidden" id="CAMBIO_CONTRIBUYENTE3" value="<?php echo $CODIGO_CONTRIBUYENTE;?>" />
<input name="MODPUESTOVENTA" type="hidden" id="MODPUESTOVENTA" value="1" /></td>
      </tr>
      <tr>
        <td  align="right" bgcolor="#CCCCCC">Puesto :</td>
        <td style="font-weight: bold"><?php echo $ros['PUESTO'];$_SESSION['PUESTOS']=$ros['PUESTO'];?>
          <input name="txtPuesto" type="hidden" id="txtPuesto"  style="width:250px; height:20px" onchange="javascript:this.value=this.value.toUpperCase();"  onkeypress="return soloLetrasNumeros(event)" value="<?php echo $ros['PUESTO'];?>" placeholder="PUESTO"/>
          <input name="txtZona" type="hidden" id="txtZona" value="<?php echo  $ros['CODIGO_ZONA']; $_SESSION['CODIGO_ZONAS']=$ros['CODIGO_ZONA'];?>" /></td>
      </tr>
      <tr>
        <td  align="right" bgcolor="#CCCCCC">Fila :</td>
        <td style="font-weight: bold"><?php echo $ros['FILA'];$_SESSION['FILAS']=$ros['FILA'];?>
          <input name="txtFila" type="hidden" id="txtFila"  style="width:250px; height:20px" onchange="javascript:this.value=this.value.toUpperCase();"  onkeypress="return soloLetrasNumeros(event)" value="<?php echo $ros['FILA'];?>" placeholder="FILA"/></td>
      </tr><?php } ?>
      <tr>
        <td  align="right">&nbsp;</td>
        <td style="font-weight: bold">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2"  align="right"><img src="../Img/Blanco.png" width="661" height="6" /></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center"><a href="frmCambioNombre1.php">Volver</a></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="ASTERISCO">VER. 2</td>
  </tr>
</table>
</body></form>
</html><?php require '../Conexion_BD/Cerrar_Dbms.php'; ?>