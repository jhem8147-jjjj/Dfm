<?php require_once('../Control_Sesiones_Forms/frmControlSesionUsuario.php');
require_once('../Control_Sesiones_Forms/Loading.php');
 require '../Conexion_BD/Dbms.php';
 if(empty($_SESSION['COD_ASOCIACION'])){include_once("Index.php");}
if(empty($_SESSION['ASOCIACION'])){include_once("Index.php");}
if(empty($_SESSION['DOCUMENTOREG'])){include_once("Index.php");}
if(empty($_SESSION['COM_INT'])){include_once("Index.php");}
if(empty($_SESSION['CODIGOREGISTRO'])){include_once("Index.php");}
$FECHA=date('d/m/Y');$HORA=date('H:i:s');
// REGISTRA EN LA TABLA DE EMISION DE COMPROBANTES DE PAGO
if($txtTipo=='CN'){
	$CONT=0;
$GESTIONACTUAL=date('Y');
	$REGS=0;
//verifica si LA GESTION EXISTE
$resul=mysql_query("select * from nros_correlativos_registros WHERE GESTION='$GESTIONACTUAL' and ESTADO='ACTIVO'");
if($filas=mysql_fetch_array($resul)){$REGS=1;}
//CONSULTA SI LOS CONTADORES ESTAN ACTUALIZADOS
if($REGS==0){
$query = mysql_query("UPDATE nros_correlativos_registros SET ESTADO='NO ACTIVO' WHERE ESTADO='ACTIVO'")or die ("NO SE PUDO ACTUALIZAR CONTADORES");

$sql1="insert into nros_correlativos_registros(GESTION,IMPORTACION,COMPROBANTES)values('$GESTIONACTUAL','0','0')";$result=mysql_query($sql1)or die ("NO SE PUDO REGISTRAR EN LA ENTIDAD nros_correlativos_registros.");
}

//EXTARE NROS. DE COMPROBANTES DE PAGO
$resul=mysql_query("select COMPROBANTES from nros_correlativos_registros WHERE GESTION='$GESTIONACTUAL' and ESTADO='ACTIVO'");
while($fila=mysql_fetch_array($resul)){$CONTADORES=$fila[0]+1;}
$query = mysql_query("UPDATE nros_correlativos_registros SET COMPROBANTES='$CONTADORES' WHERE GESTION='$GESTIONACTUAL' and ESTADO='ACTIVO'")or die ("NO SE PUDO ACTUALIZAR CONTADORES");

$CODIGO_REGISTROS=date('Ymd His').rand(1,10).$CONTADORES;
$_SESSION['CODIGO_REGISTROS']=$COD_REGISTRO;


//COMIENZA A GENERAR CONTRIBUYENTES
 $res=mysql_query("select 
 CONTRI.CODIGO_CONTRIBUYENTE,
 CONTRI.DOC_IDENTIDAD,
 CONTRI.DOC_IDENTIDAD_ALFA,
 CONTRI.EXPEDIDO,
 CONTRI.NOMBRE_RSOCIAL,
 CONTRI.PRIMER_APELLIDO,
 CONTRI.SEGUNDO_APELLIDO,
 CONTRI.APELLIDO_ESPOSO,
 RHCN.Id,
 RHCN.CODIGO_ZONA,
 RHCN.REGISTRO_GREMIAL,
 RHCN.TIPO_CAMBIO,
 RHCN.GESTION,
 RHCN.TIPO_PUESTO,
 RHCN.FILA,
 RHCN.PUESTO,
 RHCN.MONTO,
 RHCN.MULTA,
 RHCN.FORMULARIO,
 RHCN.COMUNICACION_INTERNA
from contribuyentes CONTRI, reg_contribuyente_habilitado_pago_cambio_nombre RHCN 
where RHCN.CODIGO_REGISTRO='$CODIGOREGISTRO' and RHCN.ESTADO='ACTIVO' and RHCN.CODIGO_CONTRIBUYENTE_ENTRANTE=CONTRI.CODIGO_CONTRIBUYENTE and CONTRI.ESTADO='ACTIVO' and RHCN.ESTADO_COMUNICACION_INTERNA='GENERADO' and ESTADO_ORDEN_PAGO='GENERADO'");
while($rows=mysql_fetch_array ($res)){ 
$CONT++;
//ARMA LA CEDULA DE IDENTIDAD DE CONTRIBUYENTE
if(strlen($rows[2])>1){ $CEDULADENTIDAD=$rows[1].' - '.$rows[2].' '.$rows[3];}else{$CEDULADENTIDAD=$rows[1].' '.$rows[2].' '.$rows[3];
	}
//ARMA EL NOMBRE DE CONTRIBUYENTE
if(strlen($rows[7])>3){$NOMBRE_CONTRI=$rows[4].' '.$rows[5].' '.$rows[6].' de '.$rows[7];}else{$NOMBRE_CONTRI=$rows[4].' '.$rows[5].' '.$rows[6];}
//SUMA COSTO + MULTA + FORMULARIO
$SUBTOTAL=0;
$TOTAL=0;
$SUBTOTAL=$rows[16]+$rows[17];
$TOTAL=$rows[16]+$rows[17]+$rows[18];
$LITERAL=valorEnLetras($TOTAL);
//DESCRIBE DIRECCION DEL PUESTO
$DIRPUESTO=mysql_query("select * from reg_asociacion where CODIGO_ASOCIACION='$COD_ASOCIACION' and ESTADO='ACTIVO'");while($rowt=mysql_fetch_array ($DIRPUESTO)){$ZONAPUESTO=$rowt['ZONA_UBICACION'];$DIRECCIONPUESTO=$rowt['DIRECCION'];}
//GENERA NRO DE COMPROBANTES DE PAGO
$result=mysql_query("select MAX(COMPROBANTE) from nro_comprobantes");
if($fila=mysql_fetch_array($result)){$CONTADOR=$fila[0]+1;}
$query = mysql_query("UPDATE nro_comprobantes SET COMPROBANTE='$CONTADOR'")or die ("NO SE PUDO ACTUALIZAR CONTADORES");
// REGISTRA EN LA TABLA reg_contribuyente_asociacion_pago
$sql2="insert into reg_contribuyente_asociacion_pago(PC_NAME,PC_IP,USUARIO,NOMBRE_USUARIO,FECHA,HORA,CODIGO_REGISTRO,REGISTRO_GREMIAL,NRO_COMPROBANTE,CODIGO_CONTRIBUYENTE,CODIGO_ASOCIACION,CODIGO_ZONA,FECHA_IMPRESION,CEDULA_IDENTIDAD,CONTRIBUYENTE,ASOCIACION,DIRECCION,ZONA_UBICACION,ACTIVIDAD,CODIGO_CUENTA1,DESCRIPCION_1,GLOSA_DESCRIPCION_1,GLOSA_DESCRIPCION_2,TOTAL1,CODIGO_CUENTA2,DESCRIPCION_2,DESCRIPCION_2_1,TOTAL2,CODIGO_CUENTA3,DESCRIPCION_3,TOTAL3,LITERAL,TOTAL,TRANSCRIPTOR,OBSERVACIONES,CAJERO,VERIFICADOR,PAGO_REALIZADO,COMUNICACION_INTERNA)values('$hostname','$hostlocal','$US_SIOI','$SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO','$FECHA','$HORA','$CODIGO_REGISTROS','$rows[10]','$CONTADOR','$rows[0]','$COD_ASOCIACION','$rows[9]','$FECHA','$CEDULADENTIDAD','$NOMBRE_CONTRI','$ASOCIACION','$DIRECCIONPUESTO','$ZONAPUESTO','$rows[13] $rows[14] - $rows[15]','9.03','DERECHO DE ASENTAMIENTO EVENTUAL EN SITIO PUBLICO.(A PARTIR DE LA GESTION $rows[12])','PAGO POR CAMBIO DE NOMBRE- $rows[11].','SEGUN RESOLUCION ADMINISTRATIVA BI SECTORIAL 001/2023.','$SUBTOTAL',' ',' ',' ',' ','11.01','Formulario','$rows[18]','$LITERAL','$TOTAL','D.F.M.','$textarea','BANCO UNION','$SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO','DEPOSITO BANCARIO $txtNumeroDeposito, REALIZADO EN BANCO UNION A LA CUENTA $txtDeposito.','$COM_INT')";$result=mysql_query($sql2)or die ("NO SE PUDO REGISTRAR EN LA ENTIDAD reg_contribuyente_asociacion_pago."); 
// REGISTRA EN LA TABLA reg_contribuyente_asociacion_datos_comprobantes
$sql2="insert into reg_contribuyente_asociacion_datos_comprobantes(PC_NAME,PC_IP,USUARIO,NOMBRE_USUARIO,FECHA,HORA,CODIGO_REGISTRO,REGISTRO_GREMIAL,NRO_COMPROBANTE,CODIGO_CONTRIBUYENTE,CODIGO_ASOCIACION,CODIGO_ZONA,FECHA_IMPRESION,CEDULA_IDENTIDAD,CONTRIBUYENTE,ASOCIACION,DIRECCION,ZONA_UBICACION,ACTIVIDAD,CODIGO_CUENTA1,DESCRIPCION_1,GLOSA_DESCRIPCION_1,GLOSA_DESCRIPCION_2,TOTAL1,CODIGO_CUENTA2,DESCRIPCION_2,DESCRIPCION_2_1,TOTAL2,CODIGO_CUENTA3,DESCRIPCION_3,TOTAL3,LITERAL,TOTAL,TRANSCRIPTOR,OBSERVACIONES,CAJERO,VERIFICADOR,PAGO_REALIZADO,COMUNICACION_INTERNA)values('$hostname','$hostlocal','$US_SIOI','$SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO','$FECHA','$HORA','$CODIGO_REGISTROS','$rows[10]','$CONTADOR','$rows[0]','$COD_ASOCIACION','$rows[9]','$FECHA','$CEDULADENTIDAD','$NOMBRE_CONTRI','$ASOCIACION','$DIRECCIONPUESTO','$ZONAPUESTO','$rows[13] $rows[14] - $rows[15]','9.03','DERECHO DE ASENTAMIENTO EVENTUAL EN SITIO PUBLICO.(A PARTIR DE LA GESTION $rows[12])','PAGO POR CAMBIO DE NOMBRE- $rows[11].','SEGUN RESOLUCION ADMINISTRATIVA BI SECTORIAL 001/2023.','$SUBTOTAL',' ',' ',' ',' ','11.01','Formulario','$rows[18]','$LITERAL','$TOTAL','D.F.M.','$textarea','BANCO UNION','$SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO','DEPOSITO BANCARIO $txtNumeroDeposito, REALIZADO EN BANCO UNION A LA CUENTA $txtDeposito.','$COM_INT')";$result=mysql_query($sql2)or die ("NO SE PUDO REGISTRAR EN LA ENTIDAD reg_contribuyente_asociacion_pago."); 

//Actualiza el estado de os pagos	
$query = mysql_query("UPDATE reg_contribuyente_habilitado_pago_cambio_nombre SET ESTADO_PAGO='PAGADO CON DEPOSITO BANCARIO $txtNumeroDeposito, EN FECHA $txtFechaDeposito.' , ESTADO='PAGADO' where  Id='$rows[8]' and CODIGO_REGISTRO='$CODIGOREGISTRO' and ESTADO='ACTIVO' and ESTADO_ORDEN_PAGO='GENERADO'")or die ("NO SE PUDO ACTUALIZAR reg_contribuyente_habilitado_pago");	
$TOTAL=0;
$SUBTOTAL=0;
$LITERAL='';
//registra en transacciones
$sql1="insert into reg_contribuyente_transacciones(PC_NAME,PC_IP,USUARIO,NOMBRE_USUARIO,FECHA,HORA,CODIGO_REGISTRO,CODIGO_CONTRIBUYENTE,CODIGO_ASOCIACION,ASOCIACION,TRANSACCION_1,DESCRIPCION_TRAMITE,OBSERVACIONES,ENLACE)values('$hostname','$hostlocal','$US_SIOI','$SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO','$FECHA','$HORA','$CODIGO_REGISTROS','$rows[0]','$COD_ASOCIACION','$ASOCIACION','R.A. BI SECTORIAL 001/2023, CAMBIO DE NOMBRE','R.A. BI SECTORIAL 001/2023, CAMBIO DE NOMBRE - $ASOCIACION.','REGISTRO DE DATOS COMPROBANTE DE PAGO - $CEDULADENTIDAD $NOMBRE_CONTRI, No. COMPROBANTE DE PAGO $CONTADOR','0')";$result=mysql_query($sql1)or die ("NO SE PUDO REGISTRAR EN LA ENTIDAD reg_contribuyente_transacciones.");
	  }	
echo"<script> alert('Se registro correctamente los pagos. $CONT , Cambios de Nombre.');</script>";
	
	}
	
// REGISTRA EN LA TABLA DE EMISION DE COMPROBANTES DE PAGO
if($txtTipo=='CC'){
	$CONT=0;
$GESTIONACTUAL=date('Y');
	$REGS=0;
//verifica si LA GESTION EXISTE
$resul=mysql_query("select * from nros_correlativos_registros WHERE GESTION='$GESTIONACTUAL' and ESTADO='ACTIVO'");
if($filas=mysql_fetch_array($resul)){$REGS=1;}
//CONSULTA SI LOS CONTADORES ESTAN ACTUALIZADOS
if($REGS==0){
$query = mysql_query("UPDATE nros_correlativos_registros SET ESTADO='NO ACTIVO' WHERE ESTADO='ACTIVO'")or die ("NO SE PUDO ACTUALIZAR CONTADORES");

$sql1="insert into nros_correlativos_registros(GESTION,IMPORTACION,COMPROBANTES)values('$GESTIONACTUAL','0','0')";$result=mysql_query($sql1)or die ("NO SE PUDO REGISTRAR EN LA ENTIDAD nros_correlativos_registros.");
}

//EXTARE NROS. DE COMPROBANTES DE PAGO
//EXTARE NROS. DE COMPROBANTES DE PAGO
$resul=mysql_query("select COMPROBANTES from nros_correlativos_registros WHERE GESTION='$GESTIONACTUAL' and ESTADO='ACTIVO'");
while($fila=mysql_fetch_array($resul)){$CONTADORES=$fila[0]+1;}

$query = mysql_query("UPDATE nros_correlativos_registros SET COMPROBANTES='$CONTADORES' WHERE GESTION='$GESTIONACTUAL' and ESTADO='ACTIVO'")or die ("NO SE PUDO ACTUALIZAR CONTADORES");

$CODIGO_REGISTROS=date('Ymd His').rand(1,10).$CONTADORES;
$_SESSION['CODIGO_REGISTROS']=$COD_REGISTRO;
//COMIENZA A GENERAR CONTRIBUYENTES
 $res=mysql_query("select 
 CONTRI.CODIGO_CONTRIBUYENTE,
 CONTRI.DOC_IDENTIDAD,
 CONTRI.DOC_IDENTIDAD_ALFA,
 CONTRI.EXPEDIDO,
 CONTRI.NOMBRE_RSOCIAL,
 CONTRI.PRIMER_APELLIDO,
 CONTRI.SEGUNDO_APELLIDO,
 CONTRI.APELLIDO_ESPOSO,
 RHCC.Id,
 RHCC.CODIGO_GREMIAL,
 RHCC.CODIGO_ZONA,
 RHCC.GESTION,
 RHCC.TIPO_VENTA,
 RHCC.FILA,
 RHCC.PUESTO,
 RHCC.MONTO,
 RHCC.MULTA,
 RHCC.FORMULARIO,
 RHCC.COMUNICACION_INTERNA
from contribuyentes CONTRI, reg_contribuyente_habilitado_pago_complementacion RHCC 
where RHCC.CODIGO_REGISTRO='$CODIGOREGISTRO' and RHCC.ESTADO='ACTIVO' and RHCC.CODIGO_CONTRIBUYENTE=CONTRI.CODIGO_CONTRIBUYENTE and CONTRI.ESTADO='ACTIVO' and RHCC.ESTADO_COMUNICACION_INTERNA='GENERADO' and RHCC.ESTADO_ORDEN_PAGO='GENERADO'");
while($rows=mysql_fetch_array ($res)){ 
$CONT++;
//ARMA LA CEDULA DE IDENTIDAD DE CONTRIBUYENTE
if(strlen($rows[2])>1){ $CEDULADENTIDAD=$rows[1].' - '.$rows[2].' '.$rows[3];}else{$CEDULADENTIDAD=$rows[1].' '.$rows[2].' '.$rows[3];
	}
//ARMA EL NOMBRE DE CONTRIBUYENTE
if(strlen($rows[7])>3){$NOMBRE_CONTRI=$rows[4].' '.$rows[5].' '.$rows[6].' de '.$rows[7];}else{$NOMBRE_CONTRI=$rows[4].' '.$rows[5].' '.$rows[6];}
//SUMA COSTO + MULTA + FORMULARIO
$SUBTOTAL=0;
$TOTAL=0;
$SUBTOTAL=$rows[15]+$rows[16];
$TOTAL=$rows[15]+$rows[16]+$rows[17];
$LITERAL=valorEnLetras($TOTAL);
//DESCRIBE DIRECCION DEL PUESTO
$DIRPUESTO=mysql_query("select * from reg_asociacion where CODIGO_ASOCIACION='$COD_ASOCIACION' and ESTADO='ACTIVO'");while($rowt=mysql_fetch_array ($DIRPUESTO)){$ZONAPUESTO=$rowt['ZONA_UBICACION'];$DIRECCIONPUESTO=$rowt['DIRECCION'];}
//GENERA NRO DE COMPROBANTES DE PAGO
$result=mysql_query("select MAX(COMPROBANTE) from nro_comprobantes");
if($fila=mysql_fetch_array($result)){$CONTADOR=$fila[0]+1;}
$query = mysql_query("UPDATE nro_comprobantes SET COMPROBANTE='$CONTADOR'")or die ("NO SE PUDO ACTUALIZAR CONTADORES");
// REGISTRA EN LA TABLA reg_contribuyente_asociacion_pago
$sql2="insert into reg_contribuyente_asociacion_pago(PC_NAME,PC_IP,USUARIO,NOMBRE_USUARIO,FECHA,HORA,CODIGO_REGISTRO,REGISTRO_GREMIAL,NRO_COMPROBANTE,CODIGO_CONTRIBUYENTE,CODIGO_ASOCIACION,CODIGO_ZONA,FECHA_IMPRESION,CEDULA_IDENTIDAD,CONTRIBUYENTE,ASOCIACION,DIRECCION,ZONA_UBICACION,ACTIVIDAD,CODIGO_CUENTA1,DESCRIPCION_1,GLOSA_DESCRIPCION_1,GLOSA_DESCRIPCION_2,TOTAL1,CODIGO_CUENTA2,DESCRIPCION_2,DESCRIPCION_2_1,TOTAL2,CODIGO_CUENTA3,DESCRIPCION_3,TOTAL3,LITERAL,TOTAL,TRANSCRIPTOR,OBSERVACIONES,CAJERO,VERIFICADOR,PAGO_REALIZADO,COMUNICACION_INTERNA)values('$hostname','$hostlocal','$US_SIOI','$SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO','$FECHA','$HORA','$CODIGO_REGISTROS','$rows[9]','$CONTADOR','$rows[0]','$COD_ASOCIACION','$rows[10]','$FECHA','$CEDULADENTIDAD','$NOMBRE_CONTRI','$ASOCIACION','$DIRECCIONPUESTO','$ZONAPUESTO','$rows[12] $rows[13] - $rows[14]','9.03','DERECHO DE ASENTAMIENTO EVENTUAL EN SITIO PUBLICO','PAGO POR COMPLEMENTACION DE CONTRIBUYENTE A PARTIR DE LA GESTION $rows[11].','SEGUN RESOLUCION ADMINISTRATIVA BI SECTORIAL 001/2023.','$SUBTOTAL',' ',' ',' ',' ','11.01','Formulario','$rows[17]','$LITERAL','$TOTAL','D.F.M.','$textarea','BANCO UNION','$SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO','DEPOSITO BANCARIO $txtNumeroDeposito, REALIZADO EN BANCO UNION A LA CUENTA $txtDeposito.','$COM_INT')";$result=mysql_query($sql2)or die ("NO SE PUDO REGISTRAR EN LA ENTIDAD reg_contribuyente_asociacion_pago."); 
//REGISTRA EN LA TABLA reg_contribuyente_asociacion_datos_comprobantes
$sql2="insert into reg_contribuyente_asociacion_datos_comprobantes(PC_NAME,PC_IP,USUARIO,NOMBRE_USUARIO,FECHA,HORA,CODIGO_REGISTRO,REGISTRO_GREMIAL,NRO_COMPROBANTE,CODIGO_CONTRIBUYENTE,CODIGO_ASOCIACION,CODIGO_ZONA,FECHA_IMPRESION,CEDULA_IDENTIDAD,CONTRIBUYENTE,ASOCIACION,DIRECCION,ZONA_UBICACION,ACTIVIDAD,CODIGO_CUENTA1,DESCRIPCION_1,GLOSA_DESCRIPCION_1,GLOSA_DESCRIPCION_2,TOTAL1,CODIGO_CUENTA2,DESCRIPCION_2,DESCRIPCION_2_1,TOTAL2,CODIGO_CUENTA3,DESCRIPCION_3,TOTAL3,LITERAL,TOTAL,TRANSCRIPTOR,OBSERVACIONES,CAJERO,VERIFICADOR,PAGO_REALIZADO,COMUNICACION_INTERNA)values('$hostname','$hostlocal','$US_SIOI','$SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO','$FECHA','$HORA','$CODIGO_REGISTROS','$rows[9]','$CONTADOR','$rows[0]','$COD_ASOCIACION','$rows[10]','$FECHA','$CEDULADENTIDAD','$NOMBRE_CONTRI','$ASOCIACION','$DIRECCIONPUESTO','$ZONAPUESTO','$rows[12] $rows[13] - $rows[14]','9.03','DERECHO DE ASENTAMIENTO EVENTUAL EN SITIO PUBLICO','PAGO POR COMPLEMENTACION DE CONTRIBUYENTE A PARTIR DE LA GESTION $rows[11].','SEGUN RESOLUCION ADMINISTRATIVA BI SECTORIAL 001/2023.','$SUBTOTAL',' ',' ',' ',' ','11.01','Formulario','$rows[17]','$LITERAL','$TOTAL','D.F.M.','$textarea','BANCO UNION','$SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO','DEPOSITO BANCARIO $txtNumeroDeposito, REALIZADO EN BANCO UNION A LA CUENTA $txtDeposito.','$COM_INT')";$result=mysql_query($sql2)or die ("NO SE PUDO REGISTRAR EN LA ENTIDAD reg_contribuyente_asociacion_pago."); 

//Actualiza el estado de os pagos	
$query = mysql_query("UPDATE reg_contribuyente_habilitado_pago_complementacion SET ESTADO_PAGO='PAGADO CON DEPOSITO BANCARIO $txtNumeroDeposito, EN FECHA $txtFechaDeposito.' , ESTADO='PAGADO' where  Id='$rows[8]' and CODIGO_REGISTRO='$CODIGOREGISTRO' and ESTADO='ACTIVO' and ESTADO_ORDEN_PAGO='GENERADO'")or die ("NO SE PUDO ACTUALIZAR reg_contribuyente_habilitado_pago");	
$TOTAL=0;
$SUBTOTAL=0;
$LITERAL='';
//registra en transacciones
$sql1="insert into reg_contribuyente_transacciones(PC_NAME,PC_IP,USUARIO,NOMBRE_USUARIO,FECHA,HORA,CODIGO_REGISTRO,CODIGO_CONTRIBUYENTE,CODIGO_ASOCIACION,ASOCIACION,TRANSACCION_1,DESCRIPCION_TRAMITE,OBSERVACIONES,ENLACE)values('$hostname','$hostlocal','$US_SIOI','$SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO','$FECHA','$HORA','$CODIGO_REGISTROS','$rows[0]','$COD_ASOCIACION','$ASOCIACION','R.A. BI SECTORIAL 001/2023, COMPLEMENTACION','R.A. BI SECTORIAL 001/2023, COMPLEMENTACION - $ASOCIACION.','REGISTRO DE DATOS COMPROBANTE DE PAGO - $CEDULADENTIDAD $NOMBRE_CONTRI, No. COMPROBANTE DE PAGO $CONTADOR','0')";$result=mysql_query($sql1)or die ("NO SE PUDO REGISTRAR EN LA ENTIDAD reg_contribuyente_transacciones.");
	  }	
echo"<script> alert('Se registro correctamente los pagos. $CONT , Complemento de Contribuyente.');</script>";
	
	}
 require '../Conexion_BD/Cerrar_Dbms.php';?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel='StyleSheet' href='../Css_Formularios/frmProcesos.css' type="text/css">
</head>

<body>
<table width="50%" border="0">
  <tr>
    <td align="center" class="TITULO">EMISION DE COMPROBANTE DE PAGO</td>
  </tr>
  <tr>
    <td align="center" class="SUBTITULO"><?php if($txtTipo=='CC'){echo "COMPLEMENTACION DE PUESTOS DE VENTA";} if($txtTipo=='CN'){echo "CAMBIO DE NOMBRE";} ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="left">Registro</td>
  </tr>
  <tr>
    <td><img src="../Img/Linea.png" width="843" height="4" /></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="3" cellpadding="2">
      <tr>
        <td height="32" align="center" bgcolor="#CCCCCC" style="font-weight: bold">PASO</td>
        <td align="center" bgcolor="#CCCCCC" style="font-weight: bold">DESCRIPCION</td>
        <td align="center" style="font-weight: bold">&nbsp;</td>
      </tr><?php if($txtTipo=='CN'){?>
      <tr>
        <td bgcolor="#F3F3F3">1</td>
        <td bgcolor="#F3F3F3">Imprimir Comprobante de Pago Cambio de Nombre, genera archivo Pdf los Comprobantes de Pago por Cambio de Nombre.</td>
        <td><form  method="post" action="tcpdf/Generar_Comprobante/frmComprobantePago.php" target="_blank">
          <input type="submit" name="btnImprimirCn" id="btnImprimirCn" value="Imprimir Comprobante" style="width:200px; height:35px" /></form></td>
      </tr><?php } 
	  if($txtTipo=='CC'){?>
     <tr>
        <td bgcolor="#F3F3F3">1</td>
        <td bgcolor="#F3F3F3">Imprimir Comprobante de Pago Complemento de Contribuyente, genera archivo Pdf los Comprobantes de Pago por Complemento de Puestos de Venta.</td> 
        <td><form method="post" action="tcpdf/Generar_Comprobante/frmComprobantePago.php" target="_blank"><input type="submit" name="btnImprimirCc" id="btnImprimirCc" value="Imprimir Comprobante de Pago" style="width:200px; height:35px" /></form></td>
      </tr><?php } ?>
      <tr>
        <td bgcolor="#F3F3F3">2</td>
        <td bgcolor="#F3F3F3"><p>Salir, permite salir del módulo.</p></td>
        <td><form  method="post" action='../Autenticacion_Usuario/frmCuerpo.php'"><input type="submit" name="btnSalir" id="btnSalir" value="Salir" style="width:200px; height:35px" /></form></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="ASTERISCO">VER. 4</td>
  </tr>
</table>

</body>
</html>
<?php 
function valorEnLetras($x) 
{ 
if ($x<0) { $signo = "menos ";} 
else      { $signo = "";} 
$x = abs ($x); 
$C1 = $x; 

$G6 = floor($x/(1000000));  // 7 y mas 

$E7 = floor($x/(100000)); 
$G7 = $E7-$G6*10;   // 6 

$E8 = floor($x/1000); 
$G8 = $E8-$E7*100;   // 5 y 4 

$E9 = floor($x/100); 
$G9 = $E9-$E8*10;  //  3 

$E10 = floor($x); 
$G10 = $E10-$E9*100;  // 2 y 1 


$G11 = round(($x-$E10)*100,0);  // Decimales 
////////////////////// 

$H6 = unidades($G6); 

if($G7==1 AND $G8==0) { $H7 = "Cien "; } 
else {    $H7 = decenas($G7); } 

$H8 = unidades($G8); 

if($G9==1 AND $G10==0) { $H9 = "Cien "; } 
else {    $H9 = decenas($G9); } 

$H10 = unidades($G10); 

if($G11 < 10) { $H11 = "0".$G11; } 
else { $H11 = $G11; } 

///////////////////////////// 
    if($G6==0) { $I6=" "; } 
elseif($G6==1) { $I6="Millón "; } 
         else { $I6="Millones "; } 
          
if ($G8==0 AND $G7==0) { $I8=" "; } 
         else { $I8="Mil "; } 
          
$I10 = " con "; 
$I11 = "/100"; 

$C3 = $signo.$H6.$I6.$H7.$I7.$H8.$I8.$H9.$I9.$H10.$I10.$H11.$I11; 

return $C3; //Retornar el resultado 

} 

function unidades($u) 
{ 
    if ($u==0)  {$ru = " ";} 
elseif ($u==1)  {$ru = "Un ";} 
elseif ($u==2)  {$ru = "Dos ";} 
elseif ($u==3)  {$ru = "Tres ";} 
elseif ($u==4)  {$ru = "Cuatro ";} 
elseif ($u==5)  {$ru = "Cinco ";} 
elseif ($u==6)  {$ru = "Seis ";} 
elseif ($u==7)  {$ru = "Siete ";} 
elseif ($u==8)  {$ru = "Ocho ";} 
elseif ($u==9)  {$ru = "Nueve ";} 
elseif ($u==10) {$ru = "Diez ";} 

elseif ($u==11) {$ru = "Once ";} 
elseif ($u==12) {$ru = "Doce ";} 
elseif ($u==13) {$ru = "Trece ";} 
elseif ($u==14) {$ru = "Catorce ";} 
elseif ($u==15) {$ru = "Quince ";} 
elseif ($u==16) {$ru = "Dieciseis ";} 
elseif ($u==17) {$ru = "Decisiete ";} 
elseif ($u==18) {$ru = "Dieciocho ";} 
elseif ($u==19) {$ru = "Diecinueve ";} 
elseif ($u==20) {$ru = "Veinte ";} 

elseif ($u==21) {$ru = "Veintiun ";} 
elseif ($u==22) {$ru = "Veintidos ";} 
elseif ($u==23) {$ru = "Veintitres ";} 
elseif ($u==24) {$ru = "Veinticuatro ";} 
elseif ($u==25) {$ru = "Veinticinco ";} 
elseif ($u==26) {$ru = "Veintiseis ";} 
elseif ($u==27) {$ru = "Veintisiente ";} 
elseif ($u==28) {$ru = "Veintiocho ";} 
elseif ($u==29) {$ru = "Veintinueve ";} 
elseif ($u==30) {$ru = "Treinta ";} 

elseif ($u==31) {$ru = "Treinta y un ";} 
elseif ($u==32) {$ru = "Treinta y dos ";} 
elseif ($u==33) {$ru = "Treinta y tres ";} 
elseif ($u==34) {$ru = "Treinta y cuatro ";} 
elseif ($u==35) {$ru = "Treinta y cinco ";} 
elseif ($u==36) {$ru = "Treinta y seis ";} 
elseif ($u==37) {$ru = "Treinta y siete ";} 
elseif ($u==38) {$ru = "Treinta y ocho ";} 
elseif ($u==39) {$ru = "Treinta y nueve ";} 
elseif ($u==40) {$ru = "Cuarenta ";} 

elseif ($u==41) {$ru = "Cuarenta y un ";} 
elseif ($u==42) {$ru = "Cuarenta y dos ";} 
elseif ($u==43) {$ru = "Cuarenta y tres ";} 
elseif ($u==44) {$ru = "Cuarenta y cuatro ";} 
elseif ($u==45) {$ru = "Cuarenta y cinco ";} 
elseif ($u==46) {$ru = "Cuarenta y seis ";} 
elseif ($u==47) {$ru = "Cuarenta y siete ";} 
elseif ($u==48) {$ru = "Cuarenta y ocho ";} 
elseif ($u==49) {$ru = "Cuarenta y nueve ";} 
elseif ($u==50) {$ru = "Cincuenta ";} 

elseif ($u==51) {$ru = "Cincuenta y un ";} 
elseif ($u==52) {$ru = "Cincuenta y dos ";} 
elseif ($u==53) {$ru = "Cincuenta y tres ";} 
elseif ($u==54) {$ru = "Cincuenta y cuatro ";} 
elseif ($u==55) {$ru = "Cincuenta y cinco ";} 
elseif ($u==56) {$ru = "Cincuenta y seis ";} 
elseif ($u==57) {$ru = "Cincuenta y siete ";} 
elseif ($u==58) {$ru = "Cincuenta y ocho ";} 
elseif ($u==59) {$ru = "Cincuenta y nueve ";} 
elseif ($u==60) {$ru = "Sesenta ";} 

elseif ($u==61) {$ru = "Sesenta y un ";} 
elseif ($u==62) {$ru = "Sesenta y dos ";} 
elseif ($u==63) {$ru = "Sesenta y tres ";} 
elseif ($u==64) {$ru = "Sesenta y cuatro ";} 
elseif ($u==65) {$ru = "Sesenta y cinco ";} 
elseif ($u==66) {$ru = "Sesenta y seis ";} 
elseif ($u==67) {$ru = "Sesenta y siete ";} 
elseif ($u==68) {$ru = "Sesenta y ocho ";} 
elseif ($u==69) {$ru = "Sesenta y nueve ";} 
elseif ($u==70) {$ru = "Setenta ";} 

elseif ($u==71) {$ru = "Setenta y un ";} 
elseif ($u==72) {$ru = "Setenta y dos ";} 
elseif ($u==73) {$ru = "Setenta y tres ";} 
elseif ($u==74) {$ru = "Setenta y cuatro ";} 
elseif ($u==75) {$ru = "Setenta y cinco ";} 
elseif ($u==76) {$ru = "Setenta y seis ";} 
elseif ($u==77) {$ru = "Setenta y siete ";} 
elseif ($u==78) {$ru = "Setenta y ocho ";} 
elseif ($u==79) {$ru = "Setenta y nueve ";} 
elseif ($u==80) {$ru = "Ochenta ";} 

elseif ($u==81) {$ru = "Ochenta y un ";} 
elseif ($u==82) {$ru = "Ochenta y dos ";} 
elseif ($u==83) {$ru = "Ochenta y tres ";} 
elseif ($u==84) {$ru = "Ochenta y cuatro ";} 
elseif ($u==85) {$ru = "Ochenta y cinco ";} 
elseif ($u==86) {$ru = "Ochenta y seis ";} 
elseif ($u==87) {$ru = "Ochenta y siete ";} 
elseif ($u==88) {$ru = "Ochenta y ocho ";} 
elseif ($u==89) {$ru = "Ochenta y nueve ";} 
elseif ($u==90) {$ru = "Noventa ";} 

elseif ($u==91) {$ru = "Noventa y un ";} 
elseif ($u==92) {$ru = "Noventa y dos ";} 
elseif ($u==93) {$ru = "Noventa y tres ";} 
elseif ($u==94) {$ru = "Noventa y cuatro ";} 
elseif ($u==95) {$ru = "Noventa y cinco ";} 
elseif ($u==96) {$ru = "Noventa y seis ";} 
elseif ($u==97) {$ru = "Noventa y siete ";} 
elseif ($u==98) {$ru = "Noventa y ocho ";} 
else            {$ru = "Noventa y nueve ";} 
return $ru; //Retornar el resultado 
} 

function decenas($d) 
{ 
    if ($d==0)  {$rd = "";} 
elseif ($d==1)  {$rd = "Ciento ";} 
elseif ($d==2)  {$rd = "Doscientos ";} 
elseif ($d==3)  {$rd = "Trescientos ";} 
elseif ($d==4)  {$rd = "Cuatrocientos ";} 
elseif ($d==5)  {$rd = "Quinientos ";} 
elseif ($d==6)  {$rd = "Seiscientos ";} 
elseif ($d==7)  {$rd = "Setecientos ";} 
elseif ($d==8)  {$rd = "Ochocientos ";} 
else            {$rd = "Novecientos ";} 
return $rd; //Retornar el resultado 
} 
?>