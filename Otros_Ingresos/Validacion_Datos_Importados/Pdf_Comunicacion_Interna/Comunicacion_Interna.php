<?php  require_once('../../Control_Sesiones_Forms/frmControlSesionUsuario.php');require '../../Conexion_BD/Dbms.php'; $GESTION=date('Y');$cont=0;
$ANIOS=date('Y')-1;
$res=mysql_query("select * from nros_comunicacion_interna where GESTION='$GESTION' and ESTADO='ACTIVO'");while($ro=mysql_fetch_array($res)){
$ENCONTRADO=1;
}
if($ENCONTRADO==1){}else{
$query = mysql_query("UPDATE nros_comunicacion_interna  SET ESTADO='NO ACTIVO'")or die ("NO SE PUDO ACTUALIZAR LOS DATOS DEL nros_comunicacion_interna.");
$sql1="insert into nros_comunicacion_interna(GESTION,NRO)values('$GESTION','0')";$result=mysql_query($sql1)or die ("NO SE PUDO REGISTRAR EN LA ENTIDAD nros_comunicacion_interna.");
	}

//extrae DATOS del secretario general
$res=mysql_query("select SG.DOC_IDENTIDAD,SG.DOC_IDENTIDAD_ALFA,SG.EXPEDIDO,SG.NOMBRE_RSOCIAL,SG.PRIMER_APELLIDO,SG.SEGUNDO_APELLIDO,SG.APELLIDO_ESPOSO,SG.TELEFONO,SG.CELULAR,SG.EMAIL  from reg_secretario_general_asociacion RSGA, secretario_general SG where RSGA.CODIGO_ASOCIACION='$COD_ASOCIACION' and RSGA.CODIGO_SECRETARIO_GENERAL=SG.CODIGO_SECRETARIO_GENERAL and RSGA.ESTADO='ACTIVO' and RSGA.GESTION='$ANIOS' and SG.ESTADO='ACTIVO'");
		  	  while($row=mysql_fetch_array($res)){ if($row[6]== null){$SEC_GENERAL=$row[3].' '.$row[4].' '.$row[5].', ';}else{$SEC_GENERAL= $row[3].' '.$row[4].' '.$row[5].' de '.$row[6].', ';}
			  if(strlen($row[7])>4 ){$CONTACTOS=' TEL.'.$row[7].'.';}
			   if(strlen($row[8])>4){$CONTACTOS=$CONTACTOS.' CEL.'.$row[8].'.';}
			   if(strlen($row[9])>5){$CONTACTOS=$CONTACTOS.' EMAIL '.$row[9].'.';}
			  
			  }
if($SEC_GENERAL==null){$SEC_GENERAL='NO DEFINIDO';}

$res=mysql_query("select * from reg_contribuyente_habilitado_pago RCHP, contribuyentes CONTRI where  RCHP.CODIGO_REGISTRO='$CODIGO_REGISTRO' and RCHP.CODIGO_ASOCIACION='$COD_ASOCIACION' and RCHP.CODIGO_CONTRIBUYENTE=CONTRI.CODIGO_CONTRIBUYENTE and RCHP.ESTADO='ACTIVO' and CONTRI.ESTADO='ACTIVO' and RCHP.GESTION='$sltGestion' and RCHP.ESTADO_REGISTRO='REGISTRO VALIDADO.'");
		  while($row=mysql_fetch_array($res)){ $cont++;}
//extrae DATOS del secretario general
$res=mysql_query("select SG.DOC_IDENTIDAD,SG.DOC_IDENTIDAD_ALFA,SG.EXPEDIDO,SG.NOMBRE_RSOCIAL,SG.PRIMER_APELLIDO,SG.SEGUNDO_APELLIDO,SG.APELLIDO_ESPOSO,SG.TELEFONO,SG.CELULAR,SG.EMAIL  from reg_secretario_general_asociacion RSGA, secretario_general SG where RSGA.CODIGO_ASOCIACION='$COD_ASOCIACION' and RSGA.CODIGO_SECRETARIO_GENERAL=SG.CODIGO_SECRETARIO_GENERAL and RSGA.ESTADO='ACTIVO' and RSGA.GESTION='$ANIOS' and SG.ESTADO='ACTIVO'");
		  	  while($row=mysql_fetch_array($res)){
		 if($row[6]== null){$SEC_GENERAL=$row[3].' '.$row[4].' '.$row[5].', REFERENCIA(S): ';}else{$SEC_GENERAL= $row[3].' '.$row[4].' '.$row[5].' de '.$row[6].', REFERENCIA(S):';}
		 $CONTACTOS='';
			  if(strlen($row[7])>4 ){$CONTACTOS=' TEL.'.$row[7].'.';}
			   if(strlen($row[8])>4){$CONTACTOS=$CONTACTOS.' CEL.'.$row[8].'.';}
			   if(strlen($row[9])>5){$CONTACTOS=$CONTACTOS.' EMAIL '.$row[9].'.';}
		  }
if($SEC_GENERAL==null){$SEC_GENERAL='NO DEFINIDO';}

$result=mysql_query("select * from reg_asociacion where CODIGO_ASOCIACION='$COD_ASOCIACION' and ESTADO='ACTIVO'"); while($row=mysql_fetch_array($result)){
	if($row['AFILIADOS']==0){$AFILIADOS=utf8_decode($row['OBSERVACIONES']);}else{
$AFILIADOS=$row['AFILIADOS'];}
$OM=utf8_decode($row['ORDENANZA_MUNICIPAL']);
$ASOCIACION=utf8_decode($row['DESCRIPCION']);
$LUGARES_ASENT=utf8_decode($row['ZONA_UBICACION']);
$LUGARES_ASENTA=utf8_decode($row['DIRECCION']);
	}
//OBTIENE LA ZONA TRIBUTARIA
$result=mysql_query("select ZT.DESCRIPCION from reg_asociacion_zona_tributaria AZT,zona_tributaria ZT where AZT.CODIGO_ASOCIACION='$COD_ASOCIACION' and ZT.CODIGO_ZONA=AZT.CODIGO_ZONA and AZT.ESTADO='ACTIVO' and ZT.ESTADO='ACTIVO'"); while($row=mysql_fetch_array($result)){
$ZONATRIBUTARIA=utf8_decode($row['0']);

	}

$res=mysql_query("select * from nros_comunicacion_interna where GESTION='$GESTION' and ESTADO='ACTIVO'");while($ro=mysql_fetch_array($res)){
$CODIGO_NRO=$ro['NRO']+1;
}
$query = mysql_query("UPDATE nros_comunicacion_interna  SET NRO='$CODIGO_NRO' where GESTION='$GESTION' and ESTADO='ACTIVO'")or die ("NO SE PUDO ACTUALIZAR LOS DATOS DEL nros_comunicacion_interna.");

$HOY_ES=$dias[date('w')].", ".date('d')." de ".$meses[date('n')-1]. " de ".date('Y');
$NOMBRE='';
	$NOMBRE='COM_INT_DF_AC_AP_00'.$CODIGO_NRO.'_'.$GESTION;?>
<?php /* En los encabezados indicamos que se trata de un documento de MS-WORD
  y en el nombre de archivo le ponemos la extensión RTF.            */
header('Content-type: application/vnd.msword');
header("Content-Disposition: attachment; filename=".$NOMBRE.".doc");
header("Pragma: no-cache"); header("Expires: 0");  
//header('Content-Disposition: attachment; filename=INFORME.RTF'); 
?>[html xmlns:w:="urn:schemas-microsoft-com:office:word"]<head><xml>
<style type="text/css">
<!--
.Estilo19 {
	font-size: 10px;
	font-weight: bold;
}
body,td,th {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
}
.Estilo22 {font-size: 10px}
-->
</style><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
[o:DocumentProperties]</xml>
<style type="text/css">
.Estilo11 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 14px;
}
.Estilo15 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 8px; }
.Estilo16 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px;  }
.Estilo18 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
}
.Estilo20 {font-size: 13px}
.Estilo21 {font-family: Georgia, "Times New Roman", Times, serif; font-size: 36px; font-weight: bold; }
.Estilo23 {font-family: Arial, Helvetica, sans-serif;font-size: 11px}
</style><body>
<p align="center" class="Estilo11">&nbsp;</p>
<div align="center" class="Estilo18 Estilo19">COMUNICACION INTERNA</div>
<div align="center" class="Estilo18 Estilo19"><span style="font-weight: bold">DFM/AC/AP/00<b><?php echo $CODIGO_NRO;?></b>/<b><?php echo $GESTION; $COMUNICACION_INTERNA='DFM/AC/AP/00'.$CODIGO_NRO.'/'.$GESTION;?></b></span></div>
<table width="100%" border="0" cellspacing="0" cellpadding="0"><tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
<?php $resulty=mysql_query("select * from reg_comunicacion_interna_autoridades where ESTADO='ACTIVO' order by NIVEL "); while($rowy=mysql_fetch_array($resulty)){if($rowy['NIVEL']=='NIVEL 1'){ $NIVELES='A :'; }else{$NIVELES='VIA :';} ?>
  
  <tr>
    <td width="34%" align="right"><span class="Estilo18"><?php echo $NIVELES;?></span></td>
    <td width="66%"><span class="Estilo18"><?php echo $rowy['NOMBRE_A'];?></span></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td><span class="Estilo18" style="font-weight: bold"><?php echo $rowy['CARGO_A'];?></span></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td class="Estilo18" style="font-weight: bold">GOBIERNO AUTONOMO MUNICIPAL DE EL ALTO.</td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
  </tr><?php } ?>
  <tr>
    <td align="right"><span class="Estilo18">DE :</span></td>
    <td> <span class="Estilo18"><?php echo $SIAUNOMBRES.' '.$USPRIMERAPELLIDO.' '.$SIAUSEGUNDOAPELLIDO;?></span></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td><span class="Estilo18" style="font-weight: bold"><?php echo $SIOICARGO;?></span></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td class="Estilo18" style="font-weight: bold">GOBIERNO AUTONOMO MUNICIPAL DE EL ALTO.</td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right"><span class="Estilo18">REF.:</span></td>
    <td class="Estilo18"><span class="Estilo18" style="font-weight: bold">AUTORIZACION PAGO DE PATENTE EVENTUAL</span></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td class="Estilo18">&nbsp;</td>
  </tr>
  <tr>
    <td align="right"><span class="Estilo18">FECHA:</span></td>
    <td class="Estilo18"><span class="Estilo18"><?php echo $HOY_ES;?></span></td>
  </tr>
  <tr>
    <td colspan="2" align="right"><hr></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td class="Estilo18">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="justify" class="Estilo23">En atencion a solicitud de pago de Patente presentado por la Asociacion, se remite la autorizacion para el pago de patente eventual de acuerdo a las siguientes caracteristicas:</td>
  </tr>
  <tr>
    <td colspan="2" align="justify"><table width="100%" border="1" cellspacing="0" cellpadding="3" bordercolor="#000000">
      <tr>
        <td class="Estilo18"><span class="Estilo23">NOMBRE DE LA ASOCIACION</span></td>
        <td class="Estilo23"><?php echo $ASOCIACION;?></td>
      </tr>
      <tr>
        <td class="Estilo23">CANTIDAD DE AFILIADOS SEGUN <?php echo $OM;?></td>
        <td class="Estilo23"><?php echo $AFILIADOS;?> PUESTOS DE VENTA.</td>
      </tr>
      <tr>
        <td class="Estilo18"><span class="Estilo23">CANTIDAD AUTORIZADA PARA EL PAGO DE PATENTE</span></td>
        <td class="Estilo23"><?php echo $cont; ?> PUESTOS DE VENTA.</td>
      </tr>
      <tr>
        <td class="Estilo18"><span class="Estilo23">ZONIFICACION</span></td>
        <td class="Estilo23">&quot;<?php echo $ZONATRIBUTARIA;?>&quot;</td>
      </tr>
      <tr>
        <td class="Estilo18"><span class="Estilo23">GESTION CORRESPONDIENTE AL PAGO</span></td>
        <td class="Estilo23"><?php echo $sltGestion;?></td>
      </tr>
      <tr>
        <td class="Estilo18"><span class="Estilo23">LUGAR DE ASENTAMIENTO</span></td>
        <td class="Estilo23"><?php echo $LUGARES_ASENT.' - '.$LUGARES_ASENTA;?></td>
      </tr>
      <tr>
        <td class="Estilo18"><span class="Estilo23">NOMBRE DEL SECRETARIO GENERAL (A)</span></td>
        <td class="Estilo23"><?php echo $SEC_GENERAL;?><?php echo $CONTACTOS;?> </td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="2" align="justify" class="Estilo23">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="justify" class="Estilo23">El asentamiento en v&iacute;a p&uacute;blica es de caracter estrictamente provisional seg&uacute;n lo establece la Ley Municipal 291/2015 y su reglamentaci&oacute;n Decreto Municipal 046/2015. A la presente se adjunta la lista de contribuyente(s) Autorizados para la emisi&oacute;n de los comprobantes de pago de Impuesto Anual Eventual para la gesti&oacute;n: <?php echo $sltGestion;?>.</td></tr></table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="justify" class="Estilo23">Atentamente,</td>
  </tr>
  <tr>
    <td align="justify">&nbsp;</td>
  </tr>
  <tr>
    <td align="justify">&nbsp;</td>
  </tr>
  <tr>
    <td align="center"><span class="Estilo23"><?php echo utf8_decode($SIAUNOMBRES).' '.utf8_decode($USPRIMERAPELLIDO).' '.utf8_decode($SIAUSEGUNDOAPELLIDO);?></span></td>
  </tr>
  <tr>
    <td align="center"><span class="Estilo23"><?php echo $SIOICARGO;?></span></td>
  </tr>
  <tr>
    <td align="justify">&nbsp;</td>
  </tr>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td class="Estilo15">Adjunto lo Indicado</td>
  </tr>
  <tr>
    <td class="Estilo15">c.c./Archivo </span></td>
  </tr>
  <tr>
    <td class="Estilo15">c.c. FilePersonal</span></td>  
</tr></table>

<p align="center" class="Estilo11">&nbsp;</p>
<p align="center" class="Estilo11">&nbsp;</p>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center" class="Estilo18">LISTA DE  AFILIADOS AUTORIZADOS</td>
  </tr>
  <tr>
    <td align="center" class="Estilo18"><?php echo $OM;?></td>
  </tr>
  <tr>
    <td align="center" class="Estilo18"><?php echo $ASOCIACION;?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
      <tr style="font-weight: bold">
        <td width="4%" height="25" align="center" bgcolor="#CCCCCC" class="Estilo23">No.</td>
        <td  width="11%" align="center" bgcolor="#CCCCCC" class="Estilo23">Nro. DE DOCUMENTO</td>
        <td  width="30%" align="center" bgcolor="#CCCCCC" class="Estilo23">NOMBRE(S) Y APELLIDO(S)</td>
		<td  width="10%" align="center" bgcolor="#CCCCCC" class="Estilo23">GESTION</td>
        <td align="center" bgcolor="#CCCCCC" class="Estilo23">DESCRIPCION DE PUESTO</td>
        <td align="center" bgcolor="#CCCCCC" class="Estilo23">FILA</td>
        <td align="center" bgcolor="#CCCCCC" class="Estilo23">PUESTO</td>
      </tr><?php 
	 $cont=0; //BUSCA LOS REGISTROS HABILITADOS
  $res=mysql_query("select  CONTRI.DOC_IDENTIDAD,CONTRI.DOC_IDENTIDAD_ALFA,CONTRI.EXPEDIDO,CONTRI.NOMBRE_RSOCIAL,CONTRI.PRIMER_APELLIDO,CONTRI.SEGUNDO_APELLIDO,CONTRI.APELLIDO_ESPOSO,RCA.GESTION,RCA.TIPO_VENTA,RCA.FILA,RCA.PUESTO,RCA.REGISTRO_GREMIAL,RCA.GESTION,RCA.MONTO,RCA.Id,CONTRI.APELLIDO_ESPOSO  from reg_contribuyente_habilitado_pago RCA, contribuyentes CONTRI where RCA.CODIGO_REGISTRO='$CODIGO_REGISTRO' and RCA.CODIGO_ASOCIACION='$COD_ASOCIACION' and RCA.CODIGO_CONTRIBUYENTE=CONTRI.CODIGO_CONTRIBUYENTE and RCA.ESTADO='ACTIVO' and CONTRI.ESTADO='ACTIVO' and RCA.GESTION='$sltGestion'");
 while($row=mysql_fetch_array($res)){ 
			  $conts++;
if($row['1']== null){$CIS=$row['0'].' '.$row['1'].' '.$row['2'];}else{$CIS=$row['0'].' - '.$row['1'].' '.$row['2'];};
if($row['6']== null){$NOMBRES=$row['3'].' '.$row['4'].' '.$row['5'];}else{$NOMBRES=$row['3'].' '.$row['4'].' '.$row['5'].' de '.$row['6'];}
			  ?>
<tr>
  <td class="Estilo16">
    <?php echo $conts;?></td>
        <td class="Estilo16"><?php echo $CIS;?></td>
        <td class="Estilo16"><?php echo utf8_decode($NOMBRES);?></td>
        <td align="center" class="Estilo16" ><?php echo $row[7];?></td>
        <td class="Estilo16" ><?php echo utf8_decode($row[8]);?></td>
        <td align="center" class="Estilo16"><?php echo utf8_decode($row[9]);?></td>
        <td align="center" class="Estilo16"><?php echo utf8_decode($row[10]);?></td></tr><?php   
		//ACTUALIZA LOS REGISTROS DE LA COMUNICACION INTERNA
$query = mysql_query("UPDATE reg_contribuyente_habilitado_pago  SET COMUNICACION_INTERNA='$COMUNICACION_INTERNA', ENLACE='GENERADO MEDIANTE ARCHIVO WORD.' where Id='$row[14]' and CODIGO_REGISTRO='$CODIGO_REGISTRO' and ESTADO='ACTIVO'")or die ("NO SE PUDO ACTUALIZAR LOS DATOS DEL reg_contribuyente_habilitado_pago.");
		     }  ?> </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="Estilo23">Cantidad de Afiliados habilitados para el Pago de Patente Eventual: <?php echo $conts; ?> Registro(s).</td>
  </tr>
</table>
</body><?php  
//REGISTRA LAS TRANSACCIONES.
$COD_REGISTRO=date('Ymd His');
$sql1="insert into reg_contribuyente_transacciones(PC_NAME,PC_IP,USUARIO,NOMBRE_USUARIO,FECHA,HORA,CODIGO_REGISTRO,CODIGO_ASOCIACION,ASOCIACION,TRANSACCION_1,DESCRIPCION_TRAMITE,OBSERVACIONES,ENLACE)values('$hostname','$hostlocal','$US_SIOI','$SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO','$FECHA','$HORA','$COD_REGISTRO','$COD_ASOCIACION','$ASOCIACION','COMUNICACION INTERNA PAGO IMPUESTO ANUAL $sltGestion','COMUNICACION INTERNA - $COMUNICACION_INTERNA.','COMUNICACION INTERNA - $COMUNICACION_INTERNA.','0')";$result=mysql_query($sql1)or die ("NO SE PUDO REGISTRAR EN LA ENTIDAD reg_contribuyente_transacciones.");
//REGISTRA LA COMUNICACION INTERNA
$sql1="insert into reg_comunicacion_interna(PC_NAME,PC_IP,USUARIO,NOMBRE_USUARIO,FECHA,HORA,CODIGO_REGISTRO,CODIGO_ASOCIACION,ASOCIACION,COMUNICACION_INTERNA,ENLACE)values('$hostname','$hostlocal','$US_SIOI','$SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO','$FECHA','$HORA','$COD_REGISTRO','$COD_ASOCIACION','$ASOCIACION','$COMUNICACION_INTERNA','GENERADO MEDIANTE ARCHIVO WORD. - PARA LA GESTION $sltGestion')";$result=mysql_query($sql1)or die ("NO SE PUDO REGISTRAR EN LA ENTIDAD reg_contribuyente_transacciones.");
 echo $output; ?></span>