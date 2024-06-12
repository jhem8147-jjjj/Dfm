<?php  require_once('../Control_Sesiones_Forms/frmControlSesionUsuario.php');require '../Conexion_BD/Dbms.php';
$GESTION=date('Y');

$res=mysql_query("select * from nros_correlativos ");while($ro=mysql_fetch_array($res)){
$CODIGO_NRO=$ro['NRO_REPORTE']+1;
}$TOTAL=0;
$query = mysql_query("UPDATE nros_correlativos  SET NRO_REPORTE='$CODIGO_NRO'")or die ("NO SE PUDO ACTUALIZAR LOS DATOS DEL nros_correlativos.");
$res=mysql_query("select MONTO,MULTA,FORMULARIO,COMUNICACION_INTERNA from reg_contribuyente_habilitado_pago_cambio_nombre RCHP where RCHP.CODIGO_REGISTRO='$CODIGOREGISTRO' and  RCHP.CODIGO_ASOCIACION='$COD_ASOCIACION' and RCHP.ESTADO_COMUNICACION_INTERNA='GENERADO' and RCHP.ESTADO='ACTIVO' and RCHP.ESTADO_PAGO='NO PAGO'");
	  while($row=mysql_fetch_array($res)){ $TOTAL=$TOTAL+$row[0]+$row[1]+$row[2];
	  $COMUNICACION_INTERNA=$row[3];
	  }
require('../Pdf_Fpdf/mc_table.php');
$pdf=new PDF_MC_Table();

//Creación del objeto de la clase heredada
//$pdf=new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetLeftMargin(12);
$pdf->SetRightMargin(30);
$pdf->Ln(10);
$pdf->SetFont('courier', '', 9);
$pdf->Multicell(180,4,'DIRECCION DE ADMINISTRACION TRIBUTARIA MUNICIPAL',0,'C');
$pdf->Multicell(180,4,'PROFORMA POR CONCEPTO DE CAMBIO DE NOMBRE',0,'C');
$pdf->Multicell(180,4,'AREA DE OTROS INGRESOS',0,'C');
$pdf->SetFont('courier', 'B', 9);
$pdf->Multicell(180,4,'Nro. 000'.$CODIGO_NRO,0,'C');
$pdf->Ln(1);
$pdf->Multicell(180,4,'FECHA DE EMISION  '.date('d/m/Y'),1,'C');
$pdf->Ln(2);
$pdf->Multicell(180,4,utf8_decode('Numero de Cuenta Corriente :   '.$txtDepositoCn.' - '.$txtBancoCn),0,'C');$pdf->Ln(1);
$pdf->Multicell(180,4,utf8_decode('I. DATOS DE LA ASOCIACION.'),0,'J');
$pdf->SetFont('courier', '', 9);
$pdf->Multicell(180,4,utf8_decode('    Documento de registro : '.$DOCUMENTOREG),0,'J');
$pdf->Multicell(180,4,utf8_decode('    Nombre de la Asociación: "'.$ASOCIACION.'"'),0,'J');
$pdf->Ln(2);
$pdf->SetFont('courier', 'B', 9);
$pdf->Multicell(180,4,utf8_decode('II. DATOS DE PAGO.'),0,'J');
$pdf->Multicell(180,4,utf8_decode('    Importe Total a Pagar:   Bs.- '.$TOTAL),0,'J');
$pdf->Ln(2);
$pdf->SetFont('courier', 'B', 9);
$pdf->Multicell(180,4,utf8_decode('III. OBSERVACIONES.'),0,'J');
$pdf->SetFont('courier', '', 9);
$pdf->Multicell(180,3,utf8_decode('     - La válides de la presente proforma tiene vigencia hasta la fecha.' .date('d/m/Y')),0,'J');$pdf->Ln(1);
$pdf->Multicell(180,3,utf8_decode('     - Traer 3 Fotocopias del Comprobante del Banco.'),0,'J');
$pdf->Ln(2);
$pdf->SetFont('courier', 'B', 9);
$pdf->Multicell(180,4,utf8_decode('IV. DETALLE DE CONTRIBUYENTES HABILITADOS PARA PAGO DE CAMBIO DE NOMBRE.'),0,'J');
$pdf->SetFont('courier', '', 9);
$pdf->Multicell(180,4,utf8_decode('    COMUNICACION INTERNA: '.$COMUNICACION_INTERNA),0,'J');
$pdf->Ln(1);
$cont=0;
$pdf->SetFont('courier','',7);
$pdf->SetWidths(array (7,25,40,35,25,20,18,17));
$pdf->Row(array ('No.','No.DE DOCUMENTO','  NOMBRE(S) Y APELLIDO(S)','TIPO DE CAMBIO NOMBRE','DESCRIPCION','  PUESTO','     FILA','TOTAL'));
$res=mysql_query("select  CONTRI.TIPO_DOCUMENTO,CONTRI.DOC_IDENTIDAD,CONTRI.DOC_IDENTIDAD_ALFA,CONTRI.EXPEDIDO,CONTRI.NOMBRE_RSOCIAL,CONTRI.PRIMER_APELLIDO,CONTRI.SEGUNDO_APELLIDO,CONTRI.APELLIDO_ESPOSO,CONTRI.CODIGO_CONTRIBUYENTE,CONTRI.REGISTRO,RCN.REGISTRO_GREMIAL,RCN.TIPO_CAMBIO,RCN.TIPO_PUESTO,RCN.FILA,RCN.PUESTO,RCN.MONTO,RCN.MULTA,RCN.FORMULARIO from reg_contribuyente_habilitado_pago_cambio_nombre RCN, contribuyentes CONTRI where RCN.CODIGO_REGISTRO='$CODIGOREGISTRO' and RCN.ESTADO_COMUNICACION_INTERNA='GENERADO' and RCN.CODIGO_ASOCIACION='$COD_ASOCIACION' and RCN.CODIGO_CONTRIBUYENTE_ENTRANTE=CONTRI.CODIGO_CONTRIBUYENTE and RCN.ESTADO='ACTIVO' and CONTRI.ESTADO='ACTIVO'");
		  	  while($row=mysql_fetch_array($res)){ 
			  $TOTALCONT=$row[15]+$row[16]+$row[17];
// ARMA CEDULA DE IDENTIDAD
if($row[2]== null){ $CEDULA_IDENTIDAD=$row[1].' '.$row[3];}else{ $CEDULA_IDENTIDAD=$row[1].' - '.$row[2].' '.$row[3];}
//ARMA NOMBRES
if($row[7]== null){$NOMBRE_CONT= $row[4].' '.$row[5].' '.$row[6];}else{$NOMBRE_CONT= $row[4].' '.$row[5].' '.$row[6].' de '.$row[7];}
$NOMBRE_CONT=utf8_decode($NOMBRE_CONT);
$cont++;			  
$pdf->Row(array ($cont,$CEDULA_IDENTIDAD,$NOMBRE_CONT,$row[11],$row[12],$row[13],$row[14],'Bs.- '.$TOTALCONT));
$TOTALPAGAR=$TOTALPAGAR + $TOTALCONT;
$TOTALCONT=0;

}
$pdf->SetFont('courier', 'B', 9);
$pdf->SetWidths(array (170,17));
$pdf->Row(array ('                                                        TOTAL EXPRESADO EN BOLIVIANOS:','Bs.- '.$TOTALPAGAR));
$pdf->SetFont('courier', '', 9);
$pdf->Multicell(180,4,utf8_decode('Total de Contribuyentes Habilitados para pago:'.$cont),0,'L');
$NOMBRE='REPORTE_000'.$CODIGO_NRO;
$COD_REGISTRO=date('Ymd His');
$sql1="insert into reg_contribuyente_transacciones(PC_NAME,PC_IP,USUARIO,NOMBRE_USUARIO,FECHA,HORA,CODIGO_REGISTRO,CODIGO_ASOCIACION,ASOCIACION,TRANSACCION_1,DESCRIPCION_TRAMITE,OBSERVACIONES,ENLACE)values('$hostname','$hostlocal','$US_SIOI','$SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO','$FECHA','$HORA','$COD_REGISTRO','$COD_ASOCIACION','$ASOCIACION','CAMBIO DE NOMBRE','EMISION DE PROFORMA / ORDEN DE PAGO CAMBIO DE NOMBRE DETALLADO No. $CODIGO_NRO.','EMISION DE PROFORMA / ORDEN DE PAGO CAMBIO DE NOMBRE No. $CODIGO_NRO.','0')";$result=mysql_query($sql1)or die ("NO SE PUDO REGISTRAR EN LA ENTIDAD reg_contribuyente_transacciones."); 

//REGISTRA EN LA TABLA reg_documentos_generados

$sql1="insert into reg_documentos_generados(PC_NAME,PC_IP,USUARIO,NOMBRE_USUARIO,FECHA,HORA,CODIGO_REGISTRO,CODIGO_ASOCIACION,ASOCIACION,NRO_DOCUMENTO,ENLACE)values('$hostname','$hostlocal','$US_SIOI','$SIAUNOMBRES $USPRIMERAPELLIDO $SIAUSEGUNDOAPELLIDO','$FECHA','$HORA','$COD_REGISTRO','$COD_ASOCIACION','$ASOCIACION','PROFORMA POR CONCEPTO DE CAMBIO DE NOMBRE No. $CODIGO_NRO','VISTO EN PANTALLA')";$result=mysql_query($sql1)or die ("NO SE PUDO REGISTRAR EN LA ENTIDAD reg_documentos_generados."); 

$pdf->Output($NOMBRE.'.pdf','I');


require '../Conexion_BD/Cerrar_Dbms.php';
?>