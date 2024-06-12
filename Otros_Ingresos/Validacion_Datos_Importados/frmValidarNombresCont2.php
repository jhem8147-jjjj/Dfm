<?php  require_once('../Control_Sesiones_Forms/frmControlSesionUsuario.php');
require_once('../Control_Sesiones_Forms/Loading.php'); require '../Conexion_BD/Dbms.php';
$BUSCAR=1;
$_SESSION['CODIGO_REGISTRO']=$CODIGO_REGISTRO;
 $COD_REGISTRO=date('Ymd His');
 if(empty($_SESSION['COD_ASOCIACION'])){include_once("Index.php");}
 if(empty($_SESSION['ASOCIACION'])){include_once("Index.php");}
 if(empty($_SESSION['ORDENANZA_MUNICIPAL'])){include_once("Index.php");}
 if(empty($_SESSION['sltGestion'])){include_once("Index.php");}
 if(empty($_SESSION['CODIGO_REGISTRO'])){include_once("Index.php");}
//MODIIFICAR DATOS DE PUESTOS DE VENTA
if($REGMODPUESTO==1){
$query = mysql_query("UPDATE reg_contribuyente_asociacion  SET ESTADO='DATOS ACTUALIZADOS POR EL USUARIO $US_SIOI - $SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO, FECHA: $FECHA HORA: $HORA' where REGISTRO_GREMIAL='$NroGremial' and ESTADO='ACTIVO'")or die ("NO SE PUDO ACTUALIZAR LOS DATOS DEL reg_contribuyente.");
	
$sql1="insert into reg_contribuyente_asociacion(PC_NAME,PC_IP,USUARIO,NOMBRE_USUARIO,FECHA,HORA,CODIGO_REGISTRO,REGISTRO_GREMIAL,CODIGO_CONTRIBUYENTE,CODIGO_ASOCIACION,CODIGO_ZONA,TIPO_VENTA,PUESTO,FILA)values('$hostname','$hostlocal','$US_SIOI','$SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO','$FECHA','$HORA','$CODIGO_REGISTRO','$NroGremial','$CODIGO_CONTRIBUYENTE','$COD_ASOCIACION','$txtZona','$sltVenta','$txtPuesto','$txtFila')";$result=mysql_query($sql1)or die ("NO SE PUDO REGISTRAR EN LA ENTIDAD reg_contribuyente_asociacion.");

///verifica si kiosco
if($sltVenta=='KIOSCO'){$MONTO=60;}else{
$result=mysql_query("select ZT.MONTO from reg_asociacion_zona_tributaria RAZT,zona_tributaria ZT where  RAZT.CODIGO_ASOCIACION='$COD_ASOCIACION' and RAZT.CODIGO_ZONA=ZT.CODIGO_ZONA and ZT.ESTADO='ACTIVO' and RAZT.ESTADO='ACTIVO'"); while($row=mysql_fetch_array($result)){
	$MONTO=$row['0'];}	
	
	}
$query = mysql_query("UPDATE reg_contribuyente_habilitado_pago  SET ESTADO='TIPO DE PUESTO DE VENTA MODIFICADO POR EL USUARIO $US_SIOI - $SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO, FECHA: $FECHA HORA: $HORA',ESTADO_PAGO='TIPO DE PUESTO DE VENTA MODIFICADO POR EL USUARIO $US_SIOI - $SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO, FECHA: $FECHA HORA: $HORA',ESTADO_ORDEN_PAGO='TIPO DE PUESTO DE VENTA MODIFICADO POR EL USUARIO $US_SIOI - $SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO, FECHA: $FECHA HORA: $HORA', ESTADO_REGISTRO='TIPO DE PUESTO DE VENTA MODIFICADO POR EL USUARIO $US_SIOI - $SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO, FECHA: $FECHA HORA: $HORA', COMUNICACION_INTERNA='TIPO DE PUESTO DE VENTA MODIFICADO POR EL USUARIO $US_SIOI - $SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO, FECHA: $FECHA HORA: $HORA',ENLACE='TIPO DE PUESTO DE VENTA MODIFICADO POR EL USUARIO $US_SIOI - $SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO, FECHA: $FECHA HORA: $HORA',OBSERVACIONES='TIPO DE PUESTO DE VENTA MODIFICADO POR EL USUARIO $US_SIOI - $SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO, FECHA: $FECHA HORA: $HORA' where Id='$Idcs' and ESTADO='ACTIVO'")or die ("NO SE PUDO ACTUALIZAR LOS DATOS DEL reg_contribuyente_habilitado_pago.");

$sql1="insert into reg_contribuyente_habilitado_pago(PC_NAME,PC_IP,USUARIO,NOMBRE_USUARIO,FECHA,HORA,CODIGO_REGISTRO,REGISTRO_GREMIAL,CODIGO_CONTRIBUYENTE,CODIGO_ASOCIACION,CODIGO_ZONA,GESTION,TIPO_VENTA,FILA,PUESTO,MONTO,COMUNICACION_INTERNA)values('$hostname','$hostlocal','$US_SIOI','$SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO','$FECHA','$HORA','$CODIGO_REGISTRO','$NroGremial','$CODIGO_CONTRIBUYENTE','$COD_ASOCIACION','$txtZona','$sltGestion','$sltVenta','$txtFila','$txtPuesto','$MONTO','NO GENERADO')";$result=mysql_query($sql1)or die ("NO SE PUDO REGISTRAR EN LA ENTIDAD reg_contribuyente_habilitado_pago.");

//REGISTRA EN LA TABLA TRANSACCIONES.
$COD_REGISTRO=date('Ymd His');
$sql1="insert into reg_contribuyente_transacciones(PC_NAME,PC_IP,USUARIO,NOMBRE_USUARIO,FECHA,HORA,CODIGO_REGISTRO,CODIGO_ASOCIACION,ASOCIACION,TRANSACCION_1,DESCRIPCION_TRAMITE,OBSERVACIONES,ENLACE)values('$hostname','$hostlocal','$US_SIOI','$SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO','$FECHA','$HORA','$COD_REGISTRO','$COD_ASOCIACION','$ASOCIACION','ACTUALIZACION DE DATOS DE PUESTOS','ACTUALIZACION DE DATOS DE PUESTOS - NRO. GREMIAL $NroGremial, GESTION DE PAGO $sltGestion.','ACTUALIZACION DE DATOS DE PUESTOS - NRO. GREMIAL $NroGremial, GESTION DE PAGO  $sltGestion.','0')";$result=mysql_query($sql1)or die ("NO SE PUDO REGISTRAR EN LA ENTIDAD reg_contribuyente_transacciones.");

echo"<script> alert('Se Actualizo los datos del Puesto de Venta.');</script>";	
}
//COMIENZA A VALIDAR LOS REGISTROS uno por uno
if($VALIDADO==1){
$COD_REGISTRO=date('Ymd His');
$query = mysql_query("UPDATE reg_contribuyente_habilitado_pago  SET ESTADO_REGISTRO='REGISTRO VALIDADO.' where Id='$Ids' and CODIGO_CONTRIBUYENTE='$CODIGO_CONTRIBUYENTE' and ESTADO_ORDEN_PAGO='NO VALIDADO' and REGISTRO_GREMIAL='$NUMERO_GREMIAL' and ESTADO='ACTIVO' and ESTADO_PAGO='NO PAGO'")or die ("NO SE PUDO ACTUALIZAR LOS DATOS DEL reg_contribuyente_habilitado_pago.");	
$sql1="insert into reg_validacion_datos_contribuyente(PC_NAME,PC_IP,USUARIO,NOMBRE_USUARIO,FECHA,HORA,CODIGO_REGISTRO,REGISTRO_GREMIAL,CODIGO_CONTRIBUYENTE,OBSERVACIONES)values('$hostname','$hostlocal','$US_SIOI','$SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO','$FECHA','$HORA','$COD_REGISTRO','$NUMERO_GREMIAL','$CODIGO_CONTRIBUYENTE','DATOS DE REGISTRO DE CONTRIBUYENTE VALIDADO POR EL USUARIO  $US_SIOI - $SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO, EN FECHA: $FECHA HORA: $HORA.')";$result=mysql_query($sql1)or die ("NO SE PUDO REGISTRAR EN LA ENTIDAD reg_validacion_datos_contribuyente.");
//REGISTRA EN LA TABLA TRANSACCIONES.
$COD_REGISTRO=date('Ymd His');
$sql1="insert into reg_contribuyente_transacciones(PC_NAME,PC_IP,USUARIO,NOMBRE_USUARIO,FECHA,HORA,CODIGO_REGISTRO,CODIGO_ASOCIACION,ASOCIACION,TRANSACCION_1,DESCRIPCION_TRAMITE,OBSERVACIONES,ENLACE)values('$hostname','$hostlocal','$US_SIOI','$SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO','$FECHA','$HORA','$COD_REGISTRO','$COD_ASOCIACION','$ASOCIACION','VALIDACION DE DATOS','VALIDACION DE DATOS DEL CONTRIBUYENTE - NRO. GREMIAL $NUMERO_GREMIAL, GESTION DE PAGO $sltGestion.','VALIDACION DE DATOS DEL CONTRIBUYENTE - NRO. GREMIAL $NUMERO_GREMIAL, GESTION DE PAGO  $sltGestion.','0')";$result=mysql_query($sql1)or die ("NO SE PUDO REGISTRAR EN LA ENTIDAD reg_contribuyente_transacciones."); 
/*echo"<script> alert('Se Válido los datos correctamente.');</script>";*/
	
	}
//EXCLUIR CONTRIBUYENTE
if($EXCLUIR==1){
$COD_REGISTRO=date('Ymd His');
$query = mysql_query("UPDATE reg_contribuyente_habilitado_pago  SET ESTADO_REGISTRO='EXCLUIDO DE PAGO',ESTADO='EXCLUIDO DE PAGO',ESTADO_PAGO='EXCLUIDO DE PAGO',ESTADO_ORDEN_PAGO='EXCLUIDO DE PAGO REGISTRADO POR EL USUARIO $US_SIOI - $SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO, EN FECHA: $FECHA HORA: $HORA.',COMUNICACION_INTERNA='EXCLUIDO DE PAGO REGISTRADO POR EL USUARIO $US_SIOI - $SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO, EN FECHA: $FECHA HORA: $HORA.',ENLACE='EXCLUIDO DE PAGO REGISTRADO POR EL USUARIO $US_SIOI - $SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO, EN FECHA: $FECHA HORA: $HORA.',OBSERVACIONES='EXCLUIDO DE PAGO REGISTRADO POR EL USUARIO $US_SIOI - $SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO, EN FECHA: $FECHA HORA: $HORA.' where Id='$Ids' and CODIGO_CONTRIBUYENTE='$CODIGO_CONTRIBUYENTE' and REGISTRO_GREMIAL='$NUMERO_GREMIAL' and ESTADO='ACTIVO' and ESTADO_PAGO='NO PAGO' and ESTADO_REGISTRO='NO VALIDADO' and ESTADO_ORDEN_PAGO='NO VALIDADO'")or die ("NO SE PUDO ACTUALIZAR LOS DATOS DEL reg_contribuyente_habilitado_pago.");	

//REGISTRA EN LA TABLA TRANSACCIONES.

$sql1="insert into reg_contribuyente_transacciones(PC_NAME,PC_IP,USUARIO,NOMBRE_USUARIO,FECHA,HORA,CODIGO_REGISTRO,CODIGO_ASOCIACION,ASOCIACION,TRANSACCION_1,DESCRIPCION_TRAMITE,OBSERVACIONES,ENLACE)values('$hostname','$hostlocal','$US_SIOI','$SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO','$FECHA','$HORA','$COD_REGISTRO','$COD_ASOCIACION','$ASOCIACION','EXCLUSION DE PAGO DE IMPUESTO ANUAL','EXCLUSION DE PAGO DE IMPUESTO ANUAL - NRO. GREMIAL $NUMERO_GREMIAL, GESTION DE PAGO $sltGestion.','EXCLUSION DE PAGO DE IMPUESTO ANUAL - NRO. GREMIAL $NUMERO_GREMIAL, GESTION DE PAGO $sltGestion, CODIGO CONTRIBUYENTE: $CODIGO_CONTRIBUYENTE.','0')";$result=mysql_query($sql1)or die ("NO SE PUDO REGISTRAR EN LA ENTIDAD reg_contribuyente_transacciones."); 
echo"<script> alert('Se Excluyó de Pago de Impuesto Anual al Registro Gremial $NUMERO_GREMIAL.');</script>";	
	
	}
//VALIDAR TODO
if($VALIDAR_TODO==1){
$COD_REGISTRO=date('Ymd His');
 $res=mysql_query("select  CONTRI.TIPO_DOCUMENTO,CONTRI.DOC_IDENTIDAD,CONTRI.DOC_IDENTIDAD_ALFA,CONTRI.EXPEDIDO,CONTRI.NOMBRE_RSOCIAL,CONTRI.PRIMER_APELLIDO,CONTRI.SEGUNDO_APELLIDO,CONTRI.CODIGO_CONTRIBUYENTE,RCA.ESTADO_REGISTRO,RCA.TIPO_VENTA,RCA.FILA,RCA.PUESTO,RCA.REGISTRO_GREMIAL,RCA.GESTION,RCA.MONTO  from reg_contribuyente_habilitado_pago RCA, contribuyentes CONTRI where RCA.CODIGO_REGISTRO='$CODIGO_REGISTRO' and RCA.CODIGO_ASOCIACION='$COD_ASOCIACION' and RCA.CODIGO_CONTRIBUYENTE=CONTRI.CODIGO_CONTRIBUYENTE and RCA.ESTADO='ACTIVO' and RCA.ESTADO_REGISTRO='NO VALIDADO'  and CONTRI.ESTADO='ACTIVO' and RCA.GESTION='$sltGestion'");
		  	  while($row=mysql_fetch_array($res)){
				  
$query = mysql_query("UPDATE reg_contribuyente_habilitado_pago  SET ESTADO_REGISTRO='REGISTRO VALIDADO.' where CODIGO_REGISTRO='$CODIGO_REGISTRO' and CODIGO_CONTRIBUYENTE='$row[7]' and REGISTRO_GREMIAL='$row[12]' and ESTADO='ACTIVO' and ESTADO_PAGO='NO PAGO' and ESTADO_REGISTRO='NO VALIDADO'")or die ("NO SE PUDO ACTUALIZAR LOS DATOS DEL reg_contribuyente_habilitado_pago.");	
$sql1="insert into reg_validacion_datos_contribuyente(PC_NAME,PC_IP,USUARIO,NOMBRE_USUARIO,FECHA,HORA,CODIGO_REGISTRO,REGISTRO_GREMIAL,CODIGO_CONTRIBUYENTE,OBSERVACIONES)values('$hostname','$hostlocal','$US_SIOI','$SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO','$FECHA','$HORA','$COD_REGISTRO','$row[12]','$row[7]','DATOS DE REGISTRO DE CONTRIBUYENTE Y PUESTOS DE VENTA VALIDADOS POR EL USUARIO  $US_SIOI - $SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO, EN FECHA: $FECHA HORA: $HORA.')";$result=mysql_query($sql1)or die ("NO SE PUDO REGISTRAR EN LA ENTIDAD reg_validacion_datos_contribuyente.");
//REGISTRA EN LA TABLA TRANSACCIONES.

$sql1="insert into reg_contribuyente_transacciones(PC_NAME,PC_IP,USUARIO,NOMBRE_USUARIO,FECHA,HORA,CODIGO_REGISTRO,CODIGO_ASOCIACION,ASOCIACION,TRANSACCION_1,DESCRIPCION_TRAMITE,OBSERVACIONES,ENLACE)values('$hostname','$hostlocal','$US_SIOI','$SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO','$FECHA','$HORA','$COD_REGISTRO','$COD_ASOCIACION','$ASOCIACION','VALIDACION DE DATOS','VALIDACION DE DATOS DEL CONTRIBUYENTE Y PUESTOS DE VENTA - NRO. GREMIAL $row[12], GESTION DE PAGO $sltGestion.','VALIDACION DE DATOS DEL CONTRIBUYENTE  Y PUESTOS DE VENTA - NRO. GREMIAL $row[12], GESTION DE PAGO  $sltGestion.','0')";$result=mysql_query($sql1)or die ("NO SE PUDO REGISTRAR EN LA ENTIDAD reg_contribuyente_transacciones."); 

}echo"<script> alert('Se Válido Todos los datos Como Registro Correcto.');</script>";
	}
//HABILITA el boton de emision de comunicacion interna
$res=mysql_query("select  CONTRI.TIPO_DOCUMENTO,CONTRI.DOC_IDENTIDAD,CONTRI.DOC_IDENTIDAD_ALFA,CONTRI.EXPEDIDO,CONTRI.NOMBRE_RSOCIAL,CONTRI.PRIMER_APELLIDO,CONTRI.SEGUNDO_APELLIDO,CONTRI.CODIGO_CONTRIBUYENTE,RCA.ESTADO_REGISTRO,RCA.TIPO_VENTA,RCA.FILA,RCA.PUESTO,RCA.REGISTRO_GREMIAL,RCA.GESTION,RCA.MONTO  from reg_contribuyente_habilitado_pago RCA, contribuyentes CONTRI where RCA.CODIGO_REGISTRO='$CODIGO_REGISTRO' and RCA.CODIGO_ASOCIACION='$COD_ASOCIACION' and RCA.CODIGO_CONTRIBUYENTE=CONTRI.CODIGO_CONTRIBUYENTE and RCA.ESTADO='ACTIVO' and RCA.ESTADO_REGISTRO='NO VALIDADO'  and CONTRI.ESTADO='ACTIVO' and RCA.GESTION='$sltGestion' ");
		  	  while($row=mysql_fetch_array($res)){ $SW7=1;}

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
<form id="form1" name="form1" method="post" action="frmValidacionOpciones.php">
<body><script>
var clicks=0;
</script>
<table width="100%" border="0">
  <tr>
    <td><img src="../Img/Blanco.png" width="10" height="6" /></td>
    <td><table width="100%" border="0" align="left">
      <tr>
        <td align="center" class="TITULO"> <?php $result=mysql_query("select * from nombre_formularios where UBICACION='VALIDACION DE NOMBRE DE CONTRIBUYENTE' and ESTADO='ACTIVO'"); while($row=mysql_fetch_array($result)){ echo $row['DESCRIPCION']; }?></td>
      </tr>
      <tr>
        <td align="center" class="SUBTITULO">Validacion de Nombre(s) de Contribuyente(s) y Datos(s) Puesto(s) y Fila(s)</td>
      </tr>
      <tr>
        <td style="font-weight: bold">Asociacion Seleccionado.</td>
      </tr>
      <tr>
        <td style="font-weight: bold"><img src="../Img/Linea_Negra.png" width="1070" height="1" /></td>
      </tr>
      <tr>
        <td valign="bottom" style="font-weight: bold"><table width="100%" border="0" bordercolor="#FFFFFF">
        <?php $result=mysql_query("select * from reg_asociacion where CODIGO_ASOCIACION='$COD_ASOCIACION' and ESTADO='ACTIVO'"); while($row=mysql_fetch_array($result)){ ?>  <tr>
            <td height="32" align="right" bgcolor="#CCCCCC">Documento de Registro :</td>
            <td style="font-weight: bold"><?php echo utf8_decode($row['ORDENANZA_MUNICIPAL']);?></td>
          </tr>
          <tr>
            <td align="right" bgcolor="#CCCCCC"><img src="../Img/Linea_Negra.png" width="300" height="2" /></td>
            <td style="font-weight: bold">          
          </tr>
          <tr>
            <td width="32%" height="32" align="right" bgcolor="#CCCCCC">Asociación Seleccionada :</td>
            <td width="68%" style="font-weight: bold"><?php echo utf8_decode($row['DESCRIPCION']);?>
              
            
          </tr>
          <tr>
            <td align="right" bgcolor="#CCCCCC"><img src="../Img/Linea_Negra.png" width="300" height="2" /></td>
            <td style="font-weight: bold">&nbsp;</td>
          </tr>
          <tr>
            <td height="32" align="right" bgcolor="#CCCCCC">Zona Tributaria :</td>
            <td style="font-weight: bold"><?php $liqui=mysql_query("select ZT.DESCRIPCION,ZT.CODIGO_ZONA from zona_tributaria ZT,reg_asociacion_zona_tributaria RAZT where RAZT.CODIGO_ASOCIACION='$COD_ASOCIACION' and RAZT.CODIGO_ZONA=ZT.CODIGO_ZONA and RAZT.ESTADO='ACTIVO' and ZT.ESTADO='ACTIVO'");while($rowt=mysql_fetch_array($liqui)){ echo $rowt[0];  $CODIGO_ZONA_TRIB=$rowt[1];} ?></td>          
          </tr>  <?php }?>
          <tr>
            <td align="right" bgcolor="#CCCCCC"><img src="../Img/Linea_Negra.png" width="300" height="2" /></td>
            <td style="font-weight: bold">          
          </tr>
          <tr>
            <td height="32" align="right" bgcolor="#CCCCCC">Gestión :</td>
            <td style="font-weight: bold"><?php echo $sltGestion;?>            
              </tr>
          <tr>
            <td height="32" align="right"><img src="../Img/Blanco.png" width="380" height="1" /></td>
            <td align="right" style="font-weight: bold"></tr>
        
        </table></td>
      </tr><?php if($BUSCAR==1){?>
      <tr>
        <td style="font-weight: bold">Contribuyentes Afiliados.(SE RECOMIENDA REVISAR Y VALUDAR UNO A UNO CADA REGISTRO)</td>
      </tr>
      <tr>
        <td><span style="font-weight: bold"><img src="../Img/Linea_Negra.png" width="1070" height="1" /></span></td>
      </tr>
      <tr>
        <td align="right"><table width="10%" border="0" cellspacing="0" cellpadding="0">
          <?php if($SW7==1){?> <tr>
            <?php if($SW7==1){?>
            <td width="55%" align="right"><a href="frmValidarNombresCont2.php?sltGestion=<?php echo $sltGestion; ?>&BUSCAR=1&VALIDAR_TODO=1" title="VALIDAR TODOS LOS DATOS COMO CORRECTOS">Validar Todo</a></td>
            <td width="7%"><a href="frmValidarNombresCont2.php?sltGestion=<?php echo $sltGestion; ?>&BUSCAR=1&VALIDAR_TODO=1" title="VALIDAR TODOS LOS DATOS COMO CORRECTOS"><img src="../Img/Validar.png" width="35" height="35" /></a></td> <?php } ?>
        
          <tr>
            <td align="right"><img src="../Img/Blanco.png" width="100" height="1" /></td>
            <td>&nbsp;</td>
          </tr> <?php } ?>
        </table></td>
      </tr>
      <tr>
        <td><span style="font-weight: bold"><img src="../Img/Linea_Negra.png" width="1070" height="1" /></span></td>
      </tr>
      <tr>
        <td><table cellpadding="2" cellspacing="2" class="table table-striped table-bordered" id="example" style="width:100%;">
          <thead>
            <tr style="font-weight: bold">
              <td height="70" align="center" bgcolor="#CCCCCC">No.</td>
              <td align="center" bgcolor="#CCCCCC">NUMERO GREMIAL</td>
              <td align="center" bgcolor="#CCCCCC">No. DE DOCUMENTO</td>
              <td align="center" bgcolor="#CCCCCC">NOMBRE(S) Y APELLIDO(S)</td>
              <td align="center" bgcolor="#CCCCCC">GESTION</td>
              <td align="center" bgcolor="#CCCCCC">TIPO PUESTO DE VENTA</td>
              <td align="center" bgcolor="#CCCCCC">FILA</td>
              <td align="center" bgcolor="#CCCCCC">PUESTO</td>
              <td align="center" bgcolor="#CCCCCC">MONTO</td>
              <td align="center" bgcolor="#CCCCCC">OBSERVACIONES</td>
              <td></td>
              <td></td>
              <td></td>
              </tr>
          </thead>
          <tbody>
            <?php 
	 
	  $res=mysql_query("select  CONTRI.TIPO_DOCUMENTO,CONTRI.DOC_IDENTIDAD,CONTRI.DOC_IDENTIDAD_ALFA,CONTRI.EXPEDIDO,CONTRI.NOMBRE_RSOCIAL,CONTRI.PRIMER_APELLIDO,CONTRI.SEGUNDO_APELLIDO,CONTRI.CODIGO_CONTRIBUYENTE,RCA.ESTADO_REGISTRO,RCA.TIPO_VENTA,RCA.FILA,RCA.PUESTO,RCA.REGISTRO_GREMIAL,RCA.GESTION,RCA.MONTO,RCA.Id,CONTRI.APELLIDO_ESPOSO  from reg_contribuyente_habilitado_pago RCA, contribuyentes CONTRI where RCA.CODIGO_REGISTRO='$CODIGO_REGISTRO' and RCA.CODIGO_ASOCIACION='$COD_ASOCIACION' and RCA.CODIGO_CONTRIBUYENTE=CONTRI.CODIGO_CONTRIBUYENTE and RCA.ESTADO='ACTIVO' and CONTRI.ESTADO='ACTIVO' and RCA.GESTION='$sltGestion'");
		  	  while($row=mysql_fetch_array($res)){ $ANIOS=$sltGestion;
			  $SWMENSAJE=0;
			  $SWMENSAJECI=0;
			  $SWMENSAJENOMB=0;
	 	  $SW2=1;?>
            <tr>
              <td><?php $cont++; echo $cont; ?></td>
              <td><?php echo $row[12]; ?></td>
              <td><?php if($row[2]== null){ echo  $row[1].' '.$row[2].' '.$row[3];}else{echo $row[1].' - '.$row[2].' '.$row[3];} 
			  if(strlen($row[1])<=5){$SWMENSAJECI=1; $MENSAJECI='No. DE CEDULA DE IDENTIDAD';}
			  ?></td>
              <td><?php if($row[16]== null){echo $row[4].' '.$row[5].' '.$row[6];}else{echo $row[4].' '.$row[5].' '.$row[6].''.' de '.$row[16];}
			  //VERIFICA LOS DATOS DEL CONTRIBUYENTE
			  if(strlen($row[4])<=2){$SWMENSAJENOMB=1;$MENSAJENOMB='NOMBRE(S) Y APELLIDO(S)';}
			   ?></td>
              <td><?php echo $row[13]; ?></td>
              <td><?php echo $row[9]; ?></td>
              <td><?php if($row[10]== null){ echo '-';}else{echo $row[10];} ?></td>
              <td><?php echo $row[11]; ?></td>
              <td style="font-weight: bold"><?php echo $row[14]; ?></td>
              <td style="font-weight: bold; color: #F00;"><?php if($row[9]=='PUESTO DE VENTA' or $row[9]=='KIOSCO' or $row[9]=='CARRITO'){}else{$SWMENSAJE=1; $MENSAJE='TIPO DE PUESTO DE VENTA.';}
			  if($SWMENSAJE==1 or $SWMENSAJECI==1 or $SWMENSAJENOMB==1){echo 'REGISTRO NO VALIDO:'.' '.$MENSAJECI.', '.$MENSAJENOMB.', '.$MENSAJE;}
			  ?></td>
              <td align="center"><?php if($row[8]=='NO VALIDADO'){?>
                <table width="10%" border="0">
                  <tr>
                    <td width="14%"><a href="frmModificarDatosPuesto.php?Ids=<?php echo $row[15]; ?>&sltGestion=<?php echo $row[13]; ?>&NUMERO_GREMIAL=<?php echo $row[12];?>&CODIGO_CONTRIBUYENTE=<? echo $row[7];?>" title="MODIFICAR DATOS DE PUESTO"><img src="../Img/Adicionar.png" width="35" height="35" /></a></td>
                    </tr>
                  </table>
                <?php } ?></td>
              <td align="center"><?php if($row[8]=='NO VALIDADO'){?>
                <table width="10%" border="0">
                  <tr>
                    <td width="14%"><a href="frmValidarNombresCont2.php?Ids=<?php echo $row[15]; ?>&sltGestion=<?php echo $row[13]; ?>&NUMERO_GREMIAL=<?php echo $row[12];?>&BUSCAR=1&CODIGO_CONTRIBUYENTE=<? echo $row[7];?>&EXCLUIR=1" title="EXCLUIR PAGO DE IMPUESTO"><img src="../Img/excluir.png" width="30" height="30" /></a></td>
                  </tr>
                </table>
                <?php } ?></td>
              <td align="center"><?php if($row[8]=='NO VALIDADO'){?><table width="10%" border="0">
                <tr>
                  <td width="14%"><a href="frmValidarNombresCont2.php?Ids=<?php echo $row[15]; ?>&sltGestion=<?php echo $row[13]; ?>&NUMERO_GREMIAL=<?php echo $row[12];?>&BUSCAR=1&CODIGO_CONTRIBUYENTE=<? echo $row[7];?>&VALIDADO=1" title="DATOS CORRECTOS"><img src="../Img/Validar.png" width="30" height="35" /></a></td>
                  </tr>
              </table><?php }else{ echo 'VALIDADO.';$conts++;} ?></td>
              </tr>
            <?php } ?>
          </tbody>
        </table></td>
      </tr>
      <tr>
        <td align="center">
       <?php if($SW7==0){?>   <input type="submit" name="button" id="button" value="Generar Comunicación Interna" style="height:50px; width:220px" <?php if($conts==$cont){}else{?>disabled="disabled"<?php } ?>  /><?php }?>
        </td>
      </tr><?php } ?>
      <tr>
        <td align="center"><a href="frmValidarNombresCont.php">Volver</a></td>
      </tr>
      <tr>
        <td class="ASTERISCO">&nbsp;</td>
      </tr>
      <tr>
        <td class="ASTERISCO">&nbsp;</td>
      </tr>
      <tr>
        <td class="ASTERISCO">VER. 3</td>
      </tr>
    </table></td>
  </tr>
</table>
<?php include '../CssTablas/frmPieTabla.php'?>
</body></form>
</html><?php  require '../Conexion_BD/Cerrar_Dbms.php';
if($SWMENSAJE==1){echo"<script> alert('Existe Observaciones en los Registros.');</script>";}
?>